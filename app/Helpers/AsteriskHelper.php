<?php

use PAMI\Message\Action\ExtensionStateAction;
use PAMI\Message\Action\SIPPeersAction;
use PAMI\Message\Event\EventMessage;

function statusString($status) {
    switch ($status) {
        case -1:
            $statusCode = -1;
            $message = __('messages.asterisk.extension.status.01');
            $color = '#F5F5DC';
            $icon = 'gift';
            break;
        case 0:
            $statusCode = 0;
            $message = __('messages.asterisk.extension.status.02');
            $color = '#808080';
            $icon = 'share';
            break;
        case 1:
            $statusCode = 1;
            $message = __('messages.asterisk.extension.status.03');
            $color = '#32CD32';
            $icon = 'time';
            break;
        case 2:
            $statusCode = 2;
            $message = __('messages.asterisk.extension.status.04');
            $color = '#FFA500';
            $icon = 'clipboard';
            break;
        case 4:
            $statusCode = 4;
            $message = __('messages.asterisk.extension.status.05');
            $color = '#800000';
            $icon = 'cross-square';
            break;
        case 8:
            $statusCode = 8;
            $message = __('messages.asterisk.extension.status.06');
            $color = '#6B8E23';
            $icon = 'cd';
            break;
        case 9:
            $statusCode = 9;
            $message = __('messages.asterisk.extension.status.07');
            $color = '#A0522D';
            $icon = 'dots-square';
            break;
        case 16:
            $statusCode = 16;
            $message = __('messages.asterisk.extension.status.08');
            $color = '#FF0000';
            $icon = 'dots-square';
            break;
        default:
            $message = __('messages.asterisk.extension.status.01');
            $color = '#F5F5DC';
            $icon = 'gift';
    }

    return $statusCode."|".$color."|".$message."|".$icon;
}

function getExtensions($connection)
{
    $response = $connection->send(new SIPPeersAction());
    $extensions = [];

    foreach ($response->getEvents() as $event) {
        if ($event instanceof EventMessage) {
            if ($event->getKey('ObjectName') != null) {
                $extensions[] = [
                    'extension' => $event->getKey('ObjectName')
                ];
            }
        }
    }

    return $extensions;
}

function getExtensionStatus($connection, $extension)
{
    return statusString($connection->send(new ExtensionStateAction($extension, "default"))->getKeys()['status']);
}

function getExtensionsWithStatus($connection)
{
    $response = $connection->send(new SIPPeersAction());
    $extensions = [];

    foreach ($response->getEvents() as $event) {
        if ($event instanceof EventMessage) {
            if ($event->getKey('ObjectName') != null) {
                $extensions[] = [
                    'extension' => $event->getKey('ObjectName'),
                    'status' => statusString($connection->send(new ExtensionStateAction($event->getKey('ObjectName'), "default"))->getKeys()['status'])
                ];
            }
        }
    }

    return $extensions;
}
