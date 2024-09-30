<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Votec1 extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'candidate_id',
        'tps_realcount_id',
        'real_count',
        'status'
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    public function tpsrealcount()
    {
        return $this->belongsTo(TpsRealcount::class, 'tps_realcount_id');
    }
}
