<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'role_id'   => 1,
            'name'      => 'Azi Saputra',
            'email'     => 'admin@laundryku.com',
            'password'  => Hash::make('Admin123'),
            'is_active' => true,
        ]);

        User::create([
            'role_id'   => 2,
            'name'      => 'Sandika Galih',
            'email'     => 'kasir@laundryku.com',
            'password'  => Hash::make('Kasir123'),
            'is_active' => true,
        ]);
    }
}