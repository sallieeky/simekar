<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peminjaman extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ["id"];

    protected $appends = ['waktuPeminjamanFormated', 'waktuSelesaiFormated'];

    public function getWaktuPeminjamanFormatedAttribute()
    {
        return \Carbon\Carbon::parse($this->getAttribute("waktu_peminjaman"))->translatedFormat('l, d F Y H:i');
    }

    public function getWaktuSelesaiFormatedAttribute()
    {
        return \Carbon\Carbon::parse($this->getAttribute("waktu_selesai"))->translatedFormat('l, d F Y H:i');
    }


    public function tujuan_peminjaman()
    {
        return $this->belongsTo(TujuanPeminjaman::class);
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class)->withTrashed();
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class)->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function kendaraan_rating()
    {
        return $this->hasOne(KendaraanRating::class);
    }

    public function driver_rating()
    {
        return $this->hasOne(DriverRating::class);
    }
}
