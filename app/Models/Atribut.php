<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atribut extends Model
{
    use HasFactory;
    protected $table='atribut';
    protected $fillable = [
        'kriteria_id', 'mahasiswa_id', 'value'
    ];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function getRealValueAttribute()
    {
        $kriteria = $this->kriteria;
        $tipe_data = $kriteria['tipe_data'];
        if ($tipe_data == 'float') return (float) $this['value'];
        return $this['value'];
    }

    public function getCaptionAttribute()
    {
        $kriteria = $this->kriteria;
        $tipe_data = $kriteria['tipe_data'];
        if ($tipe_data == 'float') return (float) $this['value'];
        if ($tipe_data == 'crips') {
            $cd = CripsDetail::where('crips_id', $kriteria['crips_id'])
                ->where('kelompok', $this['value'])
                ->first();
            return $cd['deskripsi'];
        }
        return $this['value'];
    }
}
