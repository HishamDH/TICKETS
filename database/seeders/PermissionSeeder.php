<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::truncate();

        $merchantId = 1; // غيّره حسب ID التاجر الذي تريده
        $createdBy = 1;  // ID المستخدم الذي أنشأها


        $permissions = [
            // Overview
            ['key' => 'overview_page'],

            ['key' => 'offers_view'],
            ['key' => 'offers_create'],
            ['key' => 'offers_edit'],
            ['key' => 'offers_delete'],

            ['key' => 'check_view'],
            ['key' => 'check_tickets'],

            ['key' => 'ratings_view'],
            ['key' => 'ratings_reply'],

            ['key' => 'reservations_view'],
            ['key' => 'reservations_create'],
            ['key' => 'reservations_edit'],
            ['key' => 'reservations_delete'],
            ['key' => 'reservation_detail'],

            
            ['key' => 'pos_page'],
            ['key' => 'pos_create'],
            ['key' => 'pos_view'],
            ['key' => 'pos_delete'],

            ['key' => 'reports_view'],
            ['key' => 'notifications_view'],
            ['key' => 'messages_view'],
            ['key' => 'messages_send'],
            ['key' => 'accept_chats'],

            ['key' => 'wallet_view'],
            ['key' => 'wallet_withdraw'],

            ['key' => 'branches_view'],
            ['key' => 'branches_create'],
            ['key' => 'branches_edit'],
            ['key' => 'branches_delete'],

            ['key' => 'role_create'],
            ['key' => 'role_view'],
            ['key' => 'role_edit'],
            ['key' => 'role_delete'],

            ['key' => 'team_manager_create'],
            ['key' => 'team_manager_view'],
            ['key' => 'team_manager_edit'],
            ['key' => 'team_manager_kick'],

            //['key' => 'setup_page_view'],
            //['key' => 'ProfileSetup_page_view'],
            ['key' => 'support_view'],
            ['key' => 'support_open'],
            ['key' => 'support_delete'],



            ['key' => 'settings_view'],
            ['key' => 'settings_edit'],

            ['key' => 'policies_view'],
            ['key' => 'policies_edit'],



            ['key' => 'history_view'],
        ];


        foreach ($permissions as $permission) {
            Permission::create([
                'key' => $permission['key'],
            ]);
        }
    }
}
