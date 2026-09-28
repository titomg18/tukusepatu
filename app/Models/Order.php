<?php

namespace App\Models;

use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory;

    /**
     * Nama tabel yang digunakan oleh model.
     *
     * @var string
     */
    protected $table = 'order';

    /**
     * Primary key untuk tabel order.
     *
     * @var string
     */
    protected $primaryKey = 'id_order';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pembeli_id',
        'tgl_order',
        'total_harga',
        'status_order',
        'alamat_pengiriman',
        'bukti_bayar',
    ];

    /**
     * Format tipe data kolom.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tgl_order' => 'datetime',
    ];

    /**
     * Relasi ke model User (Pembeli).
     *
     * @return BelongsTo<User, $this>
     */
    public function pembeli(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pembeli_id', 'id_user');
    }
}
