<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kendaraan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    public function serviceKendaraans()
    {
        return $this->hasMany(ServiceKendaraan::class)->withTrashed();
    }

    public function asetKendaraan()
    {
        return $this->hasOne(AsetKendaraan::class)->withTrashed();
    }
}
