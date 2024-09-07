<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Vote extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'candidate_id',
        'polling_place_id',
        'vote_count',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    public function polling_place()
    {
        return $this->belongsTo(PollingPlace::class, 'polling_place_id');
    }
}
