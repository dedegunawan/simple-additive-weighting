<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CripsDetail extends Model
{
    use HasFactory;
    protected $table='crips_detail';
    protected $fillable = [
        'crips_id', 'deskripsi', 'kelompok'
    ];

    public function crips()
    {
        return $this->belongsTo(Crips::class, 'crips_id');
    }
}
