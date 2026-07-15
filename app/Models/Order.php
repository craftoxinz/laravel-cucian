<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'kode_order', 'pelanggan_id', 'user_id', 'status', 'status_bayar',
        'tgl_masuk', 'estimasi_selesai', 'tgl_diambil', 'total', 'metode_bayar', 'catatan'
    ];
    protected $casts = [
        'tgl_masuk' => 'date',
        'estimasi_selesai' => 'date',
        'tgl_diambil' => 'date',
        'total' => 'decimal:2',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function getTotalFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'antri'   => 'warning',
            'proses'  => 'info',
            'selesai' => 'success',
            'diambil' => 'secondary',
            default   => 'secondary',
        };
    }
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'antri'   => 'Antri',
            'proses'  => 'Diproses',
            'selesai' => 'Selesai',
            'diambil' => 'Sudah Diambil',
            default   => 'Unknown',
        };
    }
    public static function generateKode(): string
    {
        $prefix = 'LDR-' . date('Ymd') . '-';
        $last = self::where('kode_order', 'like', $prefix . '%')->latest()->first();
        $num = $last ? (int) substr($last->kode_order, -3) + 1 : 1;
        return $prefix . str_pad($num, 3, '0', STR_PAD_LEFT);
    }
}