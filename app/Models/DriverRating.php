<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverRating extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function driver()
    {
        return $this->belongsTo(Driver::class)->withTrashed();
    }

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
}
