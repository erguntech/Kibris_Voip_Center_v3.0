<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AsteriskService;

use PAMI\Client\Impl\ClientImpl;
use PAMI\Client\Impl\ClientImpl as PamiClient;
use PAMI\Listener\IEventListener;
use PAMI\Message\Action\CommandAction;
use PAMI\Message\Action\CoreStatusAction;
use PAMI\Message\Action\ExtensionStateAction;
use PAMI\Message\Action\GetConfigJSONAction;
use PAMI\Message\Action\ListCommandsAction;
use PAMI\Message\Action\SIPPeersAction;
use PAMI\Message\Event\EventMessage;
use PAMI\Message\Action\OriginateAction;
use PAMI\Message\OutgoingMessage;
use PAMI\Message\Message;
use PAMI\Message\IncomingMessage;
use PAMI\Message\Action\LoginAction;
use PAMI\Message\Response\ResponseMessage;
use PAMI\Message\Event\Factory\Impl\EventFactoryImpl;
use PAMI\Client\Exception\ClientException;
use PAMI\Client\IClient;

class EventListener implements IEventListener
{
    public function handle(EventMessage $event)
    {
        //var_dump($event);
    }
}

class SandboxController extends Controller
{
    public function fetchData(Request $request)
    {
        $brands = [];

        $barcodes = [
            '9786256965508',
            '9786256780804',
            '9786056949500'
        ];

        foreach ($barcodes as $barcode) {
            $url = 'https://www.bilgikare.com/Arama/Arama?q='.$barcode;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            $html = curl_exec($ch);
            curl_close($ch);

            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);

            $dom->loadHTML($html);
            $xpath = new \DOMXPath($dom);
            $publisher = "";

            // dty-value class'ına sahip elementin bulunduğu a tag'ini bulma
            $nodes = $xpath->query("//div[@class='dty-sag-sol']//div[@class='dty-items']//a//span[@class='dty-value']");

            foreach ($nodes as $node) {
                // Elementin HTML içeriğini döndürme
                $publisher = $node->textContent;
            }

            $brands[] = [
                'barcode' => $barcode,
                'brand' => $publisher
            ];

        }

        dd($brands);
    }

    public function sandboxIssabel(Request $request)
    {
        $clientHost = "172.22.30.168";
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

        $extensions = getExtensionsWithStatus($clientConnection);

        return view('pages.sandbox.sandbox_issabel', compact('extensions'));



        //$action = new SIPPeersAction();
        //$response = $clientConnection->send($action);
//
        //$extensions = [];
        //foreach ($response->getEvents() as $event) {
        //    if ($event instanceof EventMessage) {
        //        $extensions[] = [
        //            'extension' => $event->getKey('ObjectName'),
        //            'status' => $event->getKey('Status')
        //        ];
        //    }
        //}
//
        //$clientConnection->close();

        // dd($clientConnection->send(new CommandAction('sip show peers')));
        // $actionid = md5(uniqid());
        // $originateMsg = new OriginateAction('SIP/0900'); // Client Extension
        // $originateMsg->setContext('default');
        // $originateMsg->setPriority('1');
        // $originateMsg->setExtension('0901'); // Extension To Call
        // $originateMsg->setCallerId('0900');
        // $originateMsg->setTimeout(20000);
        // $originateMsg->setAsync(true);
        // $originateMsg->setActionID($actionid);
        // $clientConnection->send($originateMsg);

        // $clientConnection->close();

        // $actionid = md5(uniqid());
        // $originateMsg = new OriginateAction('SIP/0900');
        // $originateMsg->setContext('default');
        // $originateMsg->setPriority('1');
        // $originateMsg->setExtension('0901');
        // $originateMsg->setCallerId('ErgunTech');
        // $originateMsg->setTimeout(20000);
        // $originateMsg->setAsync(false);
        // $originateMsg->setActionID($actionid);
        // $a->send($originateMsg);
        // dd($a);
        // $a->close();

        return view('pages.sandbox.sandbox_issabel', compact('extensions'));
    }
}
