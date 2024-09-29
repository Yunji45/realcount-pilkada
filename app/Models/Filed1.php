<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filed1 extends Model
{
    use HasFactory;
    protected $fillable = [
        'file',
        'polling_place_id'
    ];

    public function tps()
    {
        return $this->belongsTo(PollingPlace::class);
    }
}
