<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filed1 extends Model
{
    use HasFactory;
    protected $fillable = [
        'file',
        'kecamatan_id'
        // 'tps_realcount_id'
    ];
    public function tpsrealcount()
    {
        return $this->belongsTo(TpsRealcount::class);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
}
