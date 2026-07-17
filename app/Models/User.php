<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'is_active',
        'gambar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relasi ke Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class)->withDefault([
            'name'  => 'guest',
            'label' => 'Guest',
        ]);
    }

    /**
     * Helper Helper Role
     */
    public function isAdmin(): bool
    {
        return $this->role?->name === 'admin';
    }

    public function isKasir(): bool
    {
        return $this->role?->name === 'kasir';
    }

    public function isKurir(): bool
    {
        return $this->role?->name === 'kurir';
    }
}
