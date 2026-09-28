<?php

namespace App\Models;

use Database\Factories\ProdukFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produk extends Model
{
    /** @use HasFactory<ProdukFactory> */
    use HasFactory;

    /**
     * Nama tabel yang digunakan oleh model.
     *
     * @var string
     */
    protected $table = 'produk';

    /**
     * Primary key untuk tabel produk.
     *
     * @var string
     */
    protected $primaryKey = 'id_product';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'penjual_id',
        'nama_product',
        'deskripsi',
        'harga',
        'stok',
        'kategori',
        'gambar_product',
        'status_product',
    ];

    /**
     * Relasi ke model User (Penjual).
     *
     * @return BelongsTo<User, $this>
     */
    public function penjual(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penjual_id', 'id_user');
    }
}
