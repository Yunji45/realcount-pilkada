<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Election extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'type',
    ];

    public function candidate()
    {
        return $this->hasMany(Candidate::class, 'partai_id');
    }
}
