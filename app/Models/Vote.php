<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Vote extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'user_id',
        'candidate_id',
        'election_id',
    ];

    public function voter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    public function election()
    {
        return $this->belongsTo(Election::class, 'election_id');
    }
}
