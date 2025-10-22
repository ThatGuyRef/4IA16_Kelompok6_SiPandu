<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class WargaSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['nik' => '1234567890123456'],
            [
                'name' => 'Warga Contoh',
                'email' => 'warga@example.com',
                'password' => Hash::make('password'),
                'role' => 'warga',
            ]
        );
    }
}
