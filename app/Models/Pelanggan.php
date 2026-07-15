<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $fillable = ['nama', 'telepon', 'alamat'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function totalOrder(): int
    {
        return $this->orders()->count();
    }
}