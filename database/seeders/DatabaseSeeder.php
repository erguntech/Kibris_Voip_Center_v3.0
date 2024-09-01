<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AppSettingsSeeder::class,
            AppUserSeeder::class,
            AppRoleSeeder::class,
        ]);

        User::find(1)->assignRole('Sistem Yöneticisi');
    }
}
