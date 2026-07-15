<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['role_id', 'name', 'email', 'password', 'is_active'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['password' => 'hashed', 'is_active' => 'boolean'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function isAdmin(): bool
    {
        return $this->role->name === 'admin';
    }
    public function isKasir(): bool
    {
        return $this->role->name === 'kasir';
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}