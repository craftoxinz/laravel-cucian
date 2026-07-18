<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pelanggan extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pelanggan';
    protected $fillable = ['nama', 'telepon', 'alamat', 'email', 'password', 'is_member', 'is_active'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['is_member' => 'boolean', 'is_active' => 'boolean'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function totalOrder(): int
    {
        return $this->orders()->count();
    }
}
