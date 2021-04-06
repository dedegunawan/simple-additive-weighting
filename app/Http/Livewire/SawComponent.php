<?php

namespace App\Http\Livewire;

use App\Models\Atribut;
use App\Models\Kriteria;
use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class SawComponent extends Component
{
    public $error_messages='';
    public $header;
    protected $kriteria;
    protected $data_dasar;
    protected $normalisasi;
    protected $ranking;
    public $step=1;
    public $stepLists = [
        'Data Dasar', 'Analisa', 'Normalisasi', 'Perankingan'
    ];
    public $bobot;
    public function render()
    {
        $this->setup();
//        dd([
//            'kriteria' => $this->kriteria,
//            'data_dasar' => $this->data_dasar,
//            'normalisasi' => $this->normalisasi,
//            'ranking' => $this->ranking,
//        ]);
        return view('livewire.saw-component', [
            'kriteria' => $this->kriteria,
            'data_dasar' => $this->data_dasar,
            'normalisasi' => $this->normalisasi,
            'ranking' => $this->ranking,
        ]);
    }

    public function setup()
    {
        $this->setupKriteria();
        $this->setupHeader();
        $this->setupDataDasar();
        $this->setupNormalisasi();
        $this->setupPerankingan();
    }

    public function setupKriteria()
    {
        $this->kriteria = [
            'ipk' => Kriteria::find(1)->bobot,
            'penghasilan' => Kriteria::find(2)->bobot,
            'jumlah_tanggungan' => Kriteria::find(3)->bobot,
            'prestasi' => Kriteria::find(4)->bobot,
            'lokasi_rumah' => Kriteria::find(5)->bobot,
        ];
    }

    public function setupHeader()
    {
        $this->header = [
            "NIM",
            "Nama",
            "IPK",
            "Penghasilan Ortu/bln <br/><span class='text-sm'>(juta)</span>",
            "Jumlah Tanggungan",
            "Prestasi",
            "Lokasi Rumah <br/><span class='text-sm'>(km)</span>"
        ];
    }

    public function setupDataDasar()
    {
        if ($this->error_messages != '') return 0;

        $mahasiswas = Mahasiswa::all();
        $atributs = Atribut::all();

        $datas = [];
        $errors = '';

        foreach ($mahasiswas as $mahasiswa) {
            $ipk = $atributs->filter(function ($atr) use($mahasiswa) {
                return $atr['mahasiswa_id']==$mahasiswa->id && $atr['kriteria_id']==1;
            })->first();
            if (!$ipk) {
                $errors = $this->errorMahasiswaMessage('IPK', $mahasiswa);
                break;
            }

            $penghasilan = $atributs->filter(function ($atr) use($mahasiswa) {
                return $atr['mahasiswa_id']==$mahasiswa->id && $atr['kriteria_id']==2;
            })->first();
            if (!$penghasilan) {
                $errors = $this->errorMahasiswaMessage('Penghasilan ortu', $mahasiswa);
                break;
            }

            $jumlah_tanggungan = $atributs->filter(function ($atr) use($mahasiswa) {
                return $atr['mahasiswa_id']==$mahasiswa->id && $atr['kriteria_id']==3;
            })->first();
            if (!$jumlah_tanggungan) {
                $errors = $this->errorMahasiswaMessage('Jumlah tanggungan', $mahasiswa);
                break;
            }

            $prestasi = $atributs->filter(function ($atr) use($mahasiswa) {
                return $atr['mahasiswa_id']==$mahasiswa->id && $atr['kriteria_id']==4;
            })->first();
            if (!$prestasi) {
                $errors = $this->errorMahasiswaMessage('Prestasi', $mahasiswa);
                break;
            }

            $lokasi_rumah = $atributs->filter(function ($atr) use($mahasiswa) {
                return $atr['mahasiswa_id']==$mahasiswa->id && $atr['kriteria_id']==5;
            })->first();
            if (!$lokasi_rumah) {
                $errors = $this->errorMahasiswaMessage('Lokasi Rumah', $mahasiswa);
                break;
            }

            $data = [
                'mahasiswa' => $mahasiswa,
                'ipk' => $ipk,
                'penghasilan' => $penghasilan,
                'jumlah_tanggungan' => $jumlah_tanggungan,
                'prestasi' => $prestasi,
                'lokasi_rumah' => $lokasi_rumah,
            ];
            $datas[] = $data;
        }

        $this->error_messages = $errors;

        $this->data_dasar = collect($datas);

    }

    public function setupNormalisasi()
    {
        if ($this->error_messages != '') return 0;
        $datas = $this->data_dasar;
        $first = $datas->first();

        //ipk-> benefit
        $ipk_default = $first['ipk'];
        $ipk_default = $ipk_default ? $ipk_default->real_value : 0;
        $ipk_base = $datas->reduce(function ($acc, $d) {
            return $d['ipk']->real_value > $acc ? $d['ipk']->real_value : $acc;
        }, $ipk_default);

        //penghasilan-> cost
        $penghasilan_default = $first['penghasilan'];
        $penghasilan_default = $penghasilan_default ? $penghasilan_default->real_value : 0;
        $penghasilan_base = $datas->reduce(function ($acc, $d) {
            return $d['penghasilan']->real_value < $acc ? $d['penghasilan']->real_value : $acc;
        }, $penghasilan_default);

        //jumlah_tanggungan-> cost
        $jumlah_tanggungan_default = $first['jumlah_tanggungan'];
        $jumlah_tanggungan_default = $jumlah_tanggungan_default ? $jumlah_tanggungan_default->real_value : 0;
        $jumlah_tanggungan_base = $datas->reduce(function ($acc, $d) {
            return $d['jumlah_tanggungan']->real_value > $acc ? $d['jumlah_tanggungan']->real_value : $acc;
        }, $jumlah_tanggungan_default);

        //prestasi-> benefit
        $prestasi_default = $first['prestasi'];
        $prestasi_default = $prestasi_default ? $prestasi_default->real_value : 0;
        $prestasi_base = $datas->reduce(function ($acc, $d) {
            return $d['prestasi']->real_value > $acc ? $d['prestasi']->real_value : $acc;
        }, $prestasi_default);

        //lokasi_rumah-> cost
        $lokasi_rumah_default = $first['lokasi_rumah'];
        $lokasi_rumah_default = $lokasi_rumah_default ? $lokasi_rumah_default->real_value : 0;
        $lokasi_rumah_base = $datas->reduce(function ($acc, $d) {
            return $d['lokasi_rumah']->real_value < $acc ? $d['lokasi_rumah']->real_value : $acc;
        }, $lokasi_rumah_default);

        foreach ($datas as $key => $data)
        {
            $x = $data['ipk'] instanceof Atribut ? $data['ipk']['real_value'] : 0;
            $data['ipk_result'] = $x / $ipk_base;
            $data['ipk_base'] = $ipk_base;

            $x = $data['penghasilan'] instanceof Atribut ? $data['penghasilan']['real_value'] : 0;
            $data['penghasilan_result'] = $penghasilan_base / $x;
            $data['penghasilan_base'] = $penghasilan_base;

            $x = $data['jumlah_tanggungan'] instanceof Atribut ? $data['jumlah_tanggungan']['real_value'] : 0;
            $data['jumlah_tanggungan_result'] = $x / $jumlah_tanggungan_base;
            $data['jumlah_tanggungan_base'] = $jumlah_tanggungan_base;

            $x = $data['prestasi'] instanceof Atribut ? $data['prestasi']['real_value'] : 0;
            $data['prestasi_result'] = $x / $prestasi_base;
            $data['prestasi_base'] = $prestasi_base;

            $x = $data['lokasi_rumah'] instanceof Atribut ? $data['lokasi_rumah']['real_value'] : 0;
            $data['lokasi_rumah_result'] = $lokasi_rumah_base / $x;
            $data['lokasi_rumah_base'] = $lokasi_rumah_base;

            $datas[$key] = $data;
        }

        $this->normalisasi = $datas;

    }


    public function setupPerankingan()
    {
        if ($this->error_messages != '') return 0;
        $datas = $this->normalisasi;

        $ipk = Kriteria::find(1);
        $ipk = $ipk->bobot;
        $penghasilan = Kriteria::find(2);
        $penghasilan = $penghasilan->bobot;
        $jumlah_tanggungan = Kriteria::find(3);
        $jumlah_tanggungan = $jumlah_tanggungan->bobot;
        $prestasi = Kriteria::find(4);
        $prestasi = $prestasi->bobot;
        $lokasi_rumah = Kriteria::find(5);
        $lokasi_rumah = $lokasi_rumah->bobot;

        $this->bobot = [
            'ipk' => $ipk,
            'penghasilan' => $penghasilan,
            'jumlah_tanggungan' => $jumlah_tanggungan,
            'prestasi' => $prestasi,
            'lokasi_rumah' => $lokasi_rumah,
        ];

        foreach ($datas as $key => $data)
        {
            $skor = ($ipk * $data['ipk_result'])
                + ($penghasilan * $data['penghasilan_result'])
                + ($jumlah_tanggungan * $data['jumlah_tanggungan_result'])
                + ($prestasi * $data['prestasi_result'])
                + ($lokasi_rumah * $data['lokasi_rumah_result'])
            ;
            $data['skor'] = $skor;
            $datas[$key] = $data;
        }

//        usort($datas, function ($a, $b) {
//            return $a['skor'] > $b['skor'] ? -1 : 1;
//        });

        $datas = $datas->sortByDesc(function ($a) {
            return $a['skor'];
        });

        $ranking = 0;
        foreach ($datas as $key => $data)
        {
            $datas[$key] = ++$ranking;
        }
        $this->ranking = $datas;
    }


    public function errorMahasiswaMessage($string, $mahasiswa)
    {
        $errors = "$string mahasiswa .".$mahasiswa['nim']." - ".$mahasiswa['nama'];
        return $errors;
    }
}
