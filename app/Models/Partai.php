<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Partai extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'name',
        'color',
        'leader',
        'logo',
    ];

    public function candidate()
    {
        return $this->hasMany(Candidate::class, 'partai_id');
    }
}
