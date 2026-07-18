<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'kode_order', 'pelanggan_id', 'user_id', 'status', 'status_bayar',
        'tgl_masuk', 'estimasi_selesai', 'tgl_diambil', 'total', 'metode_bayar', 'catatan',
        'tipe_order', 'alamat_jemput', 'kurir_id', 'status_jemput',
    ];

    protected $casts = [
        'tgl_masuk' => 'date',
        'estimasi_selesai' => 'date',
        'tgl_diambil' => 'date',
        'total' => 'decimal:2',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class)->withDefault([
            'nama' => 'Pelanggan Umum',
        ]);
    }

    // PERBAIKAN: Gunakan withDefault() agar $order->user tidak pernah bernilai null
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Belum ditugaskan',
        ]);
    }

    // PERBAIKAN: Gunakan withDefault() agar $order->kurir tidak pernah bernilai null
    public function kurir()
    {
        return $this->belongsTo(User::class, 'kurir_id')->withDefault([
            'name' => 'Belum ada kurir',
        ]);
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
        return match ($this->status) {
            'antri' => 'warning',
            'dibatalkan' => 'danger',
            'proses' => 'info',
            'selesai' => 'success',
            'diambil' => 'secondary',
            default => 'secondary',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'antri' => 'Antri',
            'dibatalkan' => 'Dibatalkan',
            'proses' => 'Diproses',
            'selesai' => 'Selesai',
            'diambil' => 'Sudah Diambil',
            default => 'Unknown',
        };
    }

    public static function generateKode(): string
    {
        $prefix = 'LDR-' . date('Ymd') . '-';
        $last = self::where('kode_order', 'like', $prefix . '%')->latest()->first();
        $num = $last ? (int)substr($last->kode_order, -3) + 1 : 1;
        return $prefix . str_pad($num, 3, '0', STR_PAD_LEFT);
    }

    public function getStatusJemputLabelAttribute(): string
    {
        return match ($this->status_jemput) {
            'menunggu' => 'Menunggu Kurir',
            'menuju_lokasi' => 'Menuju Lokasi Pelanggan',
            'menuju_laundry' => 'Menuju Laundry',
            'selesai_diantar' => 'Sudah Tiba di Laundry',
            'mengantar_ke_pelanggan' => 'Mengantar ke Pelanggan',
            'selesai' => 'Selesai / Diterima',
            default => '-',
        };
    }

    public function getStatusJemputBadgeAttribute(): string
    {
        return match ($this->status_jemput) {
            'menunggu' => 'warning',
            'menuju_lokasi' => 'info',
            'menuju_laundry' => 'azure',
            'selesai_diantar' => 'teal',
            'mengantar_ke_pelanggan' => 'purple',
            'selesai' => 'success',
            default => 'secondary',
        };
    }
}
