<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AsetKendaraan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ["id"];

    public function kendaraan()
    {
        return $this->hasOne(Kendaraan::class)->withTrashed();
    }
}
