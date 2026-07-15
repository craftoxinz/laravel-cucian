<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'layanan_id', 'jumlah', 'harga', 'subtotal'];
    protected $casts = ['jumlah' => 'decimal:2', 'harga' => 'decimal:2', 'subtotal' => 'decimal:2'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }
}