<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;
use App\Models\Layanan;
use App\Models\Pelanggan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Roles (idempotent)
        $admin  = Role::firstOrCreate(['name' => 'admin'],  ['label' => 'Administrator']);
        $kasir  = Role::firstOrCreate(['name' => 'kasir'],  ['label' => 'Kasir']);
        $kurir  = Role::firstOrCreate(['name' => 'kurir'],  ['label' => 'Kurir']);
        // Member role (registered pelanggan) - optional for future use
        $memberRole = Role::firstOrCreate(['name' => 'member'], ['label' => 'Member (Registered)']);

        // Users
        // Users (idempotent)
        User::updateOrCreate(
            ['email' => 'admin@laundryku.com'],
            [
                'role_id'   => $admin->id,
                'name'      => 'Azi Saputra',
                'email'     => 'admin@laundryku.com',
                'password'  => Hash::make('Admin123'),
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'kasir@laundryku.com'],
            [
                'role_id'   => $kasir->id,
                'name'      => 'Sandika Galih',
                'email'     => 'kasir@laundryku.com',
                'password'  => Hash::make('Kasir123'),
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'kurir@laundryku.com'],
            [
                'role_id'   => $kurir->id,
                'name'      => 'Asep Sumpena',
                'email'     => 'kurir@laundryku.com',
                'password'  => Hash::make('Kurir123'),
                'is_active' => true,
            ]
        );

        // Layanan
        $layanan = [
            ['nama' => 'Cuci + Setrika',   'satuan' => 'kg',  'harga' => 7000,  'deskripsi' => 'Cuci bersih dan disetrika rapi'],
            ['nama' => 'Cuci Saja',        'satuan' => 'kg',  'harga' => 5000,  'deskripsi' => 'Hanya dicuci tanpa setrika'],
            ['nama' => 'Setrika Saja',     'satuan' => 'kg',  'harga' => 4000,  'deskripsi' => 'Hanya disetrika tanpa cuci'],
            ['nama' => 'Dry Cleaning',     'satuan' => 'pcs', 'harga' => 25000, 'deskripsi' => 'Layanan dry cleaning untuk baju sensitif'],
            ['nama' => 'Cuci Sepatu',      'satuan' => 'pcs', 'harga' => 30000, 'deskripsi' => 'Cuci bersih sepatu'],
            ['nama' => 'Cuci Karpet',      'satuan' => 'kg',  'harga' => 10000, 'deskripsi' => 'Cuci karpet berbagai ukuran'],
            ['nama' => 'Express (1 Hari)', 'satuan' => 'kg',  'harga' => 12000, 'deskripsi' => 'Layanan express selesai 1 hari'],
        ];

        foreach ($layanan as $l) {
            Layanan::updateOrCreate(
                ['nama' => $l['nama']],
                array_merge($l, ['is_active' => true])
            );
        }

        // Sample pelanggan (existing customers) - mark is_member=false
        $pelanggan = [
            ['nama' => 'Budi Santoso',   'telepon' => '081234567890', 'alamat' => 'Jl. Mawar No. 10, Bandung', 'is_member' => false],
            ['nama' => 'Siti Rahayu',    'telepon' => '085678901234', 'alamat' => 'Jl. Melati No. 5, Bandung', 'is_member' => false],
            ['nama' => 'Ahmad Fauzi',    'telepon' => '087890123456', 'alamat' => 'Jl. Anggrek No. 3, Cimahi', 'is_member' => false],
            ['nama' => 'Dewi Lestari',   'telepon' => '082345678901', 'alamat' => 'Jl. Dahlia No. 8, Bandung', 'is_member' => false],
            ['nama' => 'Reza Pradana',   'telepon' => '089012345678', 'alamat' => 'Jl. Kenanga No. 12, Bandung', 'is_member' => false],
        ];

        foreach ($pelanggan as $p) {
            Pelanggan::updateOrCreate(
                ['telepon' => $p['telepon']],
                $p
            );
        }
    }
}
