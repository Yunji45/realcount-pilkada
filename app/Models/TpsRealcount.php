<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class TpsRealcount extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'name',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'kelurahan_id',
        'rw',
        'status',
        'longitude',
        'latitude',
        'DPT',
        'periode'
    ];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten_id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id');
    }

    public function vote_c1()
    {
        return $this->hasMany(Votec1::class, 'tps_realcount_id');
    }

    public function fileC1()
    {
        return $this->hasMany(Filec1::class);
    }

    public function fileD1()
    {
        return $this->hasMany(Filed1::class);
    }

}
