<?php

use Carbon\Carbon;

function setNextPaymentDate($paymentStartDate){
    $date = Carbon::create($paymentStartDate);
    $date->addMonthsNoOverflow(1);
    return $date;
}

function TCMB_Converter($from = 'TRY', $to = 'USD', $val = 1)
{

    // Sistemimizde Simplexml ve Curl fonksiyonları var mı kontrol ediyoruz.
    if (!function_exists('simplexml_load_string') || !function_exists('curl_init')) {
        return 'Simplexml extension missing.';
    }

    // Başlangıç için nereden/nereye değerlerini 1 yapıyoruz çünkü TRY'nin bir karşılığı yok.
    $CurrencyData = [
        'from' => 1,
        'to' => 1
    ];

    // XML verisini curl ile alıyoruz, hata var mı yok mu diye try/catch bloklarına alıyoruz.
    try {
        $tcmbMirror = 'https://www.tcmb.gov.tr/kurlar/today.xml';
        $curl = curl_init($tcmbMirror);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL, $tcmbMirror);

        $dataFromtcmb = curl_exec($curl);
    } catch (Exception $e) {
        echo 'Unhandled exception, maybe from cURL' . $e->getMessage();
        return 0;
    }

    // XML verisini SimpleXML'e aktararak bir class haline getiriyoruz.
    $Currencies = simplexml_load_string($dataFromtcmb);

    // Bütün verileri foreach ile gezerek arıyoruz ve nereden/nereye değerlerimize eşitliyoruz.
    foreach ($Currencies->Currency as $Currency) {
        if ($from == $Currency['CurrencyCode']) $CurrencyData['from'] = $Currency->BanknoteSelling;
        if ($to == $Currency['CurrencyCode']) $CurrencyData['to'] = $Currency->BanknoteSelling;
    }

    // Hesaplama işlemini yaparak return ediyoruz.
    return round(($CurrencyData['to'] / $CurrencyData['from']) * $val, 10);
}

function formatBytes($bytes, $precision = 2) {
    $kilobyte = 1024;
    $megabyte = $kilobyte * 1024;
    $gigabyte = $megabyte * 1024;

    if ($bytes < $kilobyte) {
        return $bytes . ' B';
    } elseif ($bytes < $megabyte) {
        return round($bytes / $kilobyte, $precision) . ' KB';
    } elseif ($bytes < $gigabyte) {
        return round($bytes / $megabyte, $precision) . ' MB';
    } else {
        return round($bytes / $gigabyte, $precision) . ' GB';
    }
}
