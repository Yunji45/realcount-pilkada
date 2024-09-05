<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Election extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'name_pilkada',
        'start_date',
        'end_date',
    ];

    public function vote()
    {
        return $this->hasMany(Vote::class, 'election_id');
    }
}
