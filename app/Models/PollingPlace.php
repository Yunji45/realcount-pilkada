<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class PollingPlace extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'name',
        'kecamatan_id',
        'kelurahan_id',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'status',
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan');
    }
}
