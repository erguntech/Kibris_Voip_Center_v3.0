<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AppRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Roller
        $roleAdmin = Role::create(['name' => 'Sistem Yöneticisi', 'description' => 'Sistem Yöneticisi Rolü', 'created_by' => '1']); // Admin
        $roleAdminUser = Role::create(['name' => 'Sistem Kullanıcısı', 'description' => 'Sistem Kullanıcısı Rolü', 'created_by' => '1']); // Admin User
        $roleClient = Role::create(['name' => 'Şirket Yöneticisi', 'description' => 'Şirket Yöneticisi Rolü', 'created_by' => '1']); // Client
        $roleClientUser = Role::create(['name' => 'Şirket Kullanıcısı', 'description' => 'Şirket Kullanıcısı Rolü', 'created_by' => '1']); // Client User

        // Genel İzinler
        $permission00_01 = Permission::create(['name' => 'Genel Ayarları Düzenleme', 'description' => 'Genel Ayarları Düzenleme İzni', 'created_by' => '1']); // Admin

        // Sistem Yönetimi
        $permission01_01 = Permission::create(['name' => 'Kullanıcıları Görüntüleme', 'description' => 'Kullanıcıları Görüntüleme İzni', 'created_by' => '1']); // Admin
        $permission01_02 = Permission::create(['name' => 'Kullanıcı Rollerini Görüntüleme', 'description' => 'Kullanıcı Rollerini Görüntüleme İzni', 'created_by' => '1']); // Admin
        $permission01_03 = Permission::create(['name' => 'Kullanıcı İzinlerini Görüntüleme', 'description' => 'Kullanıcı İzinlerini Görüntüleme İzni', 'created_by' => '1']); // Admin
        $permission01_04 = Permission::create(['name' => 'Kullanıcı Hareketlerini Görüntüleme', 'description' => 'Kullanıcı Hareketlerini Görüntüleme İzni', 'created_by' => '1']); // Admin
        $permission01_05 = Permission::create(['name' => 'Sistem Ayarlarını Düzenleme', 'description' => 'Sistem Ayarlarını Düzenleme İzni', 'created_by' => '1']); // Admin

        // Müşteri Yönetimi
        $permission02_01 = Permission::create(['name' => 'Müşterileri Görüntüleme', 'description' => 'Müşterileri Görüntüleme İzni', 'created_by' => '1']); // Admin

        // Şirket Yönetimi
        $permission03_01 = Permission::create(['name' => 'Şirket Bilgilerini Görüntüleme', 'description' => 'Şirket Bilgilerini Görüntüleme İzni', 'created_by' => '1']); // Client
        $permission03_02 = Permission::create(['name' => 'Personelleri Görüntüleme', 'description' => 'Personelleri Görüntüleme İzni', 'created_by' => '1']); // Client
        $permission03_03 = Permission::create(['name' => 'Personel Hareketlerini Görüntüleme', 'description' => 'Personel Hareketlerini Görüntüleme İzni', 'created_by' => '1']); // Client
        $permission03_04 = Permission::create(['name' => 'Organizasyon Şeması Görüntüleme', 'description' => 'Organizasyon Şeması Görüntüleme İzni', 'created_by' => '1']); // Client

        // Call Center Müşteri Yönetimi
        $permission04_01 = Permission::create(['name' => 'Call Center Müşterilerini Görüntüleme', 'description' => 'Call Center Müşterilerini Görüntüleme İzni', 'created_by' => '1']); // Client
        $permission04_02 = Permission::create(['name' => 'Dış Hat Numaralarımı Görüntüleme', 'description' => 'Dış Hat Numaralarımı Görüntüleme İzni', 'created_by' => '1']); // Client
        $permission04_03 = Permission::create(['name' => 'Dahili Numaralarımı Görüntüleme', 'description' => 'Dahili Numaralarımı Görüntüleme İzni', 'created_by' => '1']); // Client
        $permission04_04 = Permission::create(['name' => 'Data Yönetimi Görüntüleme', 'description' => 'Data Yönetimi Görüntüleme İzni', 'created_by' => '1']); // Client
        $permission04_05 = Permission::create(['name' => 'Data Dağıtımı Görüntüleme', 'description' => 'Data Dağıtımı Görüntüleme İzni', 'created_by' => '1']); // Client

        // Finans Yönetimi
        $permission05_01 = Permission::create(['name' => 'Ödeme Periyotlarını Görüntüleme', 'description' => 'Ödeme Periyotlarını Görüntüleme İzni', 'created_by' => '1']); // Admin
        $permission05_02 = Permission::create(['name' => 'Ödeme Emirlerini Görüntüleme', 'description' => 'Ödeme Emirlerini Görüntüleme İzni', 'created_by' => '1']); // Admin
        $permission05_03 = Permission::create(['name' => 'Faturalarımı Görüntüleme', 'description' => 'Faturalarımı Görüntüleme İzni', 'created_by' => '1']); // Client
        $permission05_04 = Permission::create(['name' => 'Hizmet Fiyatlarını Görüntüleme', 'description' => 'Hizmet Fiyatlarını Görüntüleme İzni', 'created_by' => '1']); // Admin

        // Duyuru Yönetimi
        $permission06_01 = Permission::create(['name' => 'Duyuruları Görüntüleme', 'description' => 'Duyuruları Görüntüleme İzni', 'created_by' => '1']); // Admin, Client

        // Arama Emri Yönetimi
        $permission07_01 = Permission::create(['name' => 'Arama Emirlerini Görüntüleme', 'description' => 'Arama Emirlerini Görüntüleme İzni', 'created_by' => '1']); // Client User

        // SMS Modül Yönetimi
        $permission08_01 = Permission::create(['name' => 'SMS Cihazlarını Görüntüleme', 'description' => 'SMS Cihazlarını Görüntüleme İzni', 'created_by' => '1']); // Admin
        $permission08_02 = Permission::create(['name' => 'SMS Bakiye Modülü Görüntüleme', 'description' => 'SMS Bakiye Modülü Görüntüleme İzni', 'created_by' => '1']); // Admin

        $roleAdmin->givePermissionTo(
            $permission00_01, $permission01_01, $permission01_02, $permission01_03, $permission01_04, $permission01_05,
            $permission02_01,
            $permission05_01, $permission05_02, $permission05_04,
            $permission06_01,
            $permission08_01, $permission08_02,
        );

        $roleAdminUser->givePermissionTo(
            $permission00_01
        );

        $roleClient->givePermissionTo(
            $permission00_01,
            $permission03_01, $permission03_02, $permission03_03, $permission03_04,
            $permission04_01, $permission04_02, $permission04_03, $permission04_04, $permission04_05,
            $permission05_03,
            $permission06_01
        );

        $roleClientUser->givePermissionTo(
            $permission00_01,
            $permission07_01
        );
    }
}
