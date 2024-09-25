<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Candidate extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'name',
        'partai_id',
        'election_id',
        'vision',
        'mision',
        'photo',
    ];

    public function partai()
    {
        return $this->belongsTo(Partai::class, 'partai_id');
    }

    public function election()
    {
        return $this->belongsTo(Election::class, 'election_id');
    }

    public function vote()
    {
        return $this->hasMany(Vote::class, 'candidate_id');
    }

    public function vote()
    {
        return $this->hasMany(Vote::class, 'candidate_id');
    }

    public function vote_c1()
    {
        return $this->hasMany(Votec1::class, 'candidate_id');
    }
}
