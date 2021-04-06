<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $table='mahasiswa';
    protected $fillable = [
        'nim', 'nama'
    ];
    public function atribut()
    {
        return $this->hasMany(Atribut::class, 'mahasiswa_id');
    }

    public function currentAtribut($kriteria_id)
    {
        return $this->atribut->filter(function ($atr) use ($kriteria_id)  {
            return $kriteria_id==$atr['kriteria_id'];
        })->first();
    }
}
