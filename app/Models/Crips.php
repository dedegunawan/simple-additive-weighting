<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crips extends Model
{
    use HasFactory;
    protected $table='crips';
    protected $fillable = [
        'nama_crips'
    ];

    public function detail()
    {
        return $this->hasMany(CripsDetail::class, 'crips_id');
    }

    public function kriteria()
    {
        return $this->hasMany(Kriteria::class, 'crips_id');
    }

}
