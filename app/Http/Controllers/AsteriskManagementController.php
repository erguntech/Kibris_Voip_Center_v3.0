<?php

namespace App\Http\Controllers;

use App\Models\AsteriskCallLog;
use App\Models\CallCenterClient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PAMI\Client\Impl\ClientImpl;
use PAMI\Message\Action\OriginateAction;
use Yajra\DataTables\DataTables;
use App\Models\Employee;
use phpseclib3\Net\SFTP;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class AsteriskManagementController extends Controller
{
    private $sftp;

    public function __construct()
    {
        $this->middleware(['role:Sistem Yöneticisi|Sistem Kullanıcısı|Şirket Yöneticisi|Şirket Kullanıcısı'],['only' => ['getAssignedExtensions', 'getEmptyExtensions', 'startCall', 'getExtensionStatus', 'getCallRecording', 'removeCallRecording']]);
    }

    public function getAssignedExtensions()
    {
        $client = Auth::user()->linkedClient;
        $clientPass = "24082408";

        $options = array(
            'host' => $client->linkedClientModules->pbx_server_ip_address,
            'scheme' => 'tcp://',
            'port' => 5038,
            'username' => 'admin',
            'secret' => $clientPass,
            'connect_timeout' => 2500,
            'read_timeout' => 2500
        );

        $clientConnection = new ClientImpl($options);
        $clientConnection->open();
        $extensions = getExtensionsWithStatus($clientConnection);
        $clientConnection->close();

        foreach ($extensions as $key => $extension) {
            $isAssigned = Employee::where('extension_no', $extension['extension'])->first();
            if($isAssigned) {
                $extensions[$key]['assignedUserFullName'] = $isAssigned->linkedUser->getUserFullName();
            } else {
                unset($extensions[$key]);
            }
        }

        return response()->json([
            "extensions" => $extensions,
        ]);
    }

    public function getEmptyExtensions()
    {
        $client = Auth::user()->linkedClient;
        $clientPass = "24082408";

        $options = array(
            'host' => $client->linkedClientModules->pbx_server_ip_address,
            'scheme' => 'tcp://',
            'port' => 5038,
            'username' => 'admin',
            'secret' => $clientPass,
            'connect_timeout' => 2500,
            'read_timeout' => 2500
        );

        $clientConnection = new ClientImpl($options);
        $clientConnection->open();
        $extensions = getExtensions($clientConnection);
        $clientConnection->close();

        foreach ($extensions as $key => $extension) {
            $isAssigned = Employee::where('extension_no', $extension['extension'])->first();
            if($isAssigned) {
                unset($extensions[$key]);
            }
        }

        return $extensions;
    }

    public function startCall(Request $request)
    {
        $asteriskCallLog = new AsteriskCallLog();
        $asteriskCallLog->client_id = Auth::user()->linkedClient->id;
        $asteriskCallLog->user_id = Auth::user()->id;
        $asteriskCallLog->call_center_client_id = $request->call_center_client_id;
        $asteriskCallLog->source = $request->source;
        $asteriskCallLog->destination = $request->destination;
        $asteriskCallLog->call_id = $request->call_id;
        $asteriskCallLog->status = "Success";
        $asteriskCallLog->created_by = Auth::user()->id;
        $asteriskCallLog->save();

        return response()->json([
            "status" => 'Success',
        ]);
    }


    public function getExtensionStatus(Request $request)
    {
        $client = Auth::user()->linkedClient;
        $clientPass = "24082408";

        $options = array(
            'host' => $client->linkedClientModules->pbx_server_ip_address,
            'scheme' => 'tcp://',
            'port' => 5038,
            'username' => 'admin',
            'secret' => $clientPass,
            'connect_timeout' => 2500,
            'read_timeout' => 2500
        );

        $clientConnection = new ClientImpl($options);
        $clientConnection->open();
        $extensionStatus = getExtensionStatus($clientConnection, $request->extension);
        $clientConnection->close();

        return response()->json([
            "extensionStatus" => $extensionStatus,
        ]);
    }

    public function getCallRecording(Request $request)
    {
        $data = json_decode(
            json_encode(
                $request->json()->all()
            )
        );

        $callLog = AsteriskCallLog::where('id', $data->uniqueID)->first();

        $this->sftp = new SFTP('172.22.30.168'); // Asterisk sunucusunun IP adresi

        if (!$this->sftp->login('root', '24082408')) { // Asterisk sunucusunun kullanıcı adı ve şifresi
            throw new \Exception('SFTP Login Failed');
        }

        $directory = '/var/spool/asterisk/monitor/'.Carbon::parse($callLog->created_at)->format('Y').'/'.Carbon::parse($callLog->created_at)->format('m').'/'.Carbon::parse($callLog->created_at)->format('d');
        $files = $this->sftp->nlist($directory);

        $callID = $callLog->call_id;

        $matchingFiles = array_filter($files, function($file) use ($callID) {
            return strpos($file, $callID) !== false;
        });

        $fileName = implode(", ", $matchingFiles);
        $remoteFile = $directory.'/'.$fileName;

        $remoteFile = mb_convert_encoding($remoteFile, 'UTF-8', 'UTF-8');
        $filename = mb_convert_encoding($fileName, 'UTF-8', 'UTF-8');
        $localPath = public_path('recordings/' . $fileName);

        if ($this->sftp->get($remoteFile, $localPath)) {
            $url = asset('recordings/' . $fileName);
            return response()->json(['url' => $url]);
        }
    }

    public function removeCallRecording(Request $request)
    {
        $audioElement = explode('/', $request->filename);

        if(File::exists(public_path('recordings/'.end($audioElement)))){
            File::delete(public_path('recordings/'.end($audioElement)));
            $status = "Success";
        } else {
            $status = "No File Exists";
        }

        return response()->json([
            "status" => $status
        ]);
    }
}
