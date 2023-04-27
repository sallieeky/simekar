<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KendaraanRating extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class)->withTrashed();
    }

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
}
