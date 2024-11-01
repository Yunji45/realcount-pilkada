<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filec1 extends Model
{
    use HasFactory;
    protected $fillable = [
        'file',
        'tps_realcount_id',
        'election_id'
    ];
    public function tpsrealcount()
    {
        return $this->belongsTo(TpsRealcount::class,'tps_realcount_id');
    }

    public function election()
    {
        return $this->belongsTo(Election::class,'election_id');
    }
}
