<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah admin sudah ada
        $admin = User::where('email', 'admin@ppdb.com')->first();

        if (!$admin) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@ppdb.com',
                'password' => Hash::make('password'),
            ]);
            
            $this->command->info('Akun admin berhasil dibuat (admin@ppdb.com / password).');
        } else {
            $this->command->info('Akun admin sudah ada di database.');
        }
    }
}
