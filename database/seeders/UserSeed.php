<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin app',
            'email' => 'support@zekindo.co.id',
            'password' => Hash::make('Zekindo1234!'),
            'sys_group_id' => 1,
            'is_active' => 1,
        ]);
    }
}
