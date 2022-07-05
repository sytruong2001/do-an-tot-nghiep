<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $supAdmin = User::create(
            [
                'name' => 'Trương Văn Sỹ',
                'email' => 'vanyyy2001@gmail.com',
                'password' => bcrypt('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
            ]
        );
        $supAdmin2 = User::create([
            'name' => 'Trần Huyền Nga',
            'email' => 'ngatran@gmail.com',
            'password' => bcrypt('12345678'),
            'created_at' => now(),
            'updated_at' => now(),
            'email_verified_at' => now(),
        ]);
        $supAdmin->assignRole('super admin', 'admin');
        $supAdmin2->assignRole('super admin', 'admin');

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'created_at' => now(),
            'updated_at' => now(),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');
    }
}