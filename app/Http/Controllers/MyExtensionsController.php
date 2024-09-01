<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PAMI\Client\Impl\ClientImpl;

class MyExtensionsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Şirket Yöneticisi|Şirket Kullanıcısı'],['only' => ['index']]);
    }

    public function index()
    {
        $client = Auth::user()->linkedClient;

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
        return view('pages.my_extensions.my_extensions_index', compact('client', 'extensions'));
    }
}
