<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Pelanggan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PelangganRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_pelanggan_can_register_and_is_member()
    {
        $response = $this->post('/pelanggan/register', [
            'nama' => 'Test Pelanggan',
            'email' => 'test.pelanggan@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'telepon' => '081234567890',
            'alamat' => 'Jl. Test No. 1',
        ]);

        $response->assertRedirect(route('pelanggan.dashboard'));

        $this->assertDatabaseHas('pelanggan', [
            'email' => 'test.pelanggan@example.com',
            'nama' => 'Test Pelanggan',
            'is_member' => true,
        ]);

        $pelanggan = Pelanggan::where('email', 'test.pelanggan@example.com')->first();
        $this->assertNotNull($pelanggan);
        $this->assertTrue(Hash::check('secret123', $pelanggan->password));
        $this->assertTrue(Auth::guard('pelanggan')->check());
        $this->assertEquals($pelanggan->id, Auth::guard('pelanggan')->id());
    }
}
