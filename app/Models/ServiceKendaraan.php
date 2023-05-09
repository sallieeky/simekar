<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceKendaraan extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class)->withTrashed();
    }
}
