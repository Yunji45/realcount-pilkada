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
        'supporting_parties',
        'vision',
        'mision',
        'photo',
    ];

    public function vote()
    {
        return $this->hasMany(Vote::class, 'candidate_id');
    }
}
