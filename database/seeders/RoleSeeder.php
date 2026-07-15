<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::insert([
            ['name' => 'Azi Saputra', 'label' => 'Administrator', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sandika Galih', 'label' => 'Kasir',         'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}