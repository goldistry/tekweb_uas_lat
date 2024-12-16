<?php

namespace Database\Seeders;
use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [];

        for ($i = 1; $i <= 10; $i++) {
            $admins[] = [
                'id' => Str::uuid()->toString(),
                'username' => "Admin_$i",
                'password' => Hash::make('halo12345678'), 
                'nama_admin' => "Nama Admin $i",
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Admin::insert($admins);
    }
}
