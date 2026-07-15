<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'layanan';
    protected $fillable = ['nama', 'satuan', 'harga', 'deskripsi', 'is_active'];
    protected $casts = ['is_active' => 'boolean', 'harga' => 'decimal:2'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function getHargaFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }
}