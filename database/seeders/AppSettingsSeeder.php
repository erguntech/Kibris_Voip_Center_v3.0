<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppSettingsSeeder extends Seeder
{
    public function run(): void
    {
        settings()->set([
            'app_name' => 'Kıbrıs Voip Center',
            'app_title' => 'Kıbrıs Voip | Smart Voip App',
            'app_alias' => 'KVC',
            'app_domain' => 'https://www.kibrisvoip.com',
            'app_email' => 'info@kibrisvoip.com',
            'app_version' => 'v1.0',
            'app_description' => 'Kıbrıs Voip Center',
            'app_keywords' => 'Kıbrıs Voip Center',
            'app_auto_suspend_days' => '3', // Days
            'app_system_currency' => 'TRY', // TRY, EUR, USD
            'app_sms_service_fee' => 0, // TRY
            'app_whatsapp_contact' => '+905438848344',
            'app_telegram_contact' => '+905488789269',
            'app_skype_contact' => 'https://join.skype.com/invite/kdlDl1FQOsAb',
        ]);
    }
}
