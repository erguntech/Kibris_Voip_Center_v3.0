<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientModule;
use App\Models\SMSDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PAMI\Client\Impl\ClientImpl;

class ClientExtensionSelectionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Sistem Yöneticisi|Sistem Kullanıcısı'],['only' => ['index', 'update']]);
    }

    public function index(string $id)
    {
        $client = Client::find($id);

        $clientHost = $client->linkedClientModules->pbx_server_ip_address;
        $clientPass = "24082408";

        $options = array(
            'host' => $clientHost,
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
        return view('pages.clients.clients_extension_selection', compact('client', 'extensions'));
    }
}
