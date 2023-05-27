<?php

namespace App\Http\Livewire;

use App\Models\Atribut;
use App\Models\Crips;
use App\Models\CripsDetail;
use App\Models\Kriteria;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class MahasiswaComponent extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $mahasiswa_id, $nim, $nama, $ipk, $penghasilan, $jumlah_tanggungan, $prestasi, $lokasi_rumah;
    public $kriterias;
    public $isModal = 0;
    public $search;
    public $penghasilanLists=[];
    public $prestasiLists=[];
    protected $paginationTheme = 'bootstrap';
	const CRIPS_PENGHASILAN = 'Penghasilan Orang Tua';
	const CRIPS_PRESTASI = 'Prestasi';

	const KRITERIA_IPK = 'IPK';
	const KRITERIA_PENGHASILAN = 'Penghasilan Ortu/bln';
	const KRITERIA_TANGGUNGAN = 'Jumlah Tanggungan';
	const KRITERIA_PRESTASI = 'Prestasi';
	const KRITERIA_LOKASI_RUMAH = 'Lokasi Rumah';

	public function getKriteriaIpk() {
		return Kriteria::where('nama_kriteria', self::KRITERIA_IPK)->first();
	}
	public function getKriteriaPenghasilan() {
		return Kriteria::where('nama_kriteria', self::KRITERIA_PENGHASILAN)->first();
	}
	public function getKriteriaTanggungan() {
		return Kriteria::where('nama_kriteria', self::KRITERIA_TANGGUNGAN)->first();
	}
	public function getKriteriaPrestasi() {
		return Kriteria::where('nama_kriteria', self::KRITERIA_PRESTASI)->first();
	}
	public function getKriteriaLokasiRumah() {
		return Kriteria::where('nama_kriteria', self::KRITERIA_LOKASI_RUMAH)->first();
	}

    public function openModal()
    {
        $this->isModal = 1;
    }
    public function closeModal()
    {
        $this->isModal = 0;
    }

    public function getPenghasilanLists()
    {
		$crips = Crips::where('nama_crips', self::CRIPS_PENGHASILAN)->first();
		if (!$crips) throw new \Exception("Crips penghasilan tidak ada, pastikan menjalankan migrate db dulu");
        return CripsDetail::where('crips_id', $crips['id'])
            ->orderBy('kelompok', 'asc')
            ->get();
    }

    public function getPrestasiLists()
    {
	    $crips = Crips::where('nama_crips', self::CRIPS_PRESTASI)->first();
	    if (!$crips) throw new \Exception("Crips prestasi tidak ada, pastikan menjalankan migrate db dulu");
        return CripsDetail::where('crips_id', $crips['id'])
            ->orderBy('kelompok', 'asc')
            ->get();
    }

    public function renderData()
    {
        $this->penghasilanLists = $this->getPenghasilanLists();
        $this->prestasiLists = $this->getPrestasiLists();
        $this->kriterias = Kriteria::all();
    }

    public function renderUser()
    {
        $user = new Mahasiswa();
        if ($this->search) $user = $user->where(function($user) {
            return $user->where('nim', 'like', '%'.$this->search.'%')
                ->orWhere('nama', 'like', '%'.$this->search.'%');
        });


        return $user->paginate(20);
    }


    public function render()
    {
        $this->renderData();
        return view('livewire.mahasiswa-component', [
            'users' => $this->renderUser()
        ]);
    }

    public function simpan()
    {
        DB::beginTransaction();
        $mahasiswa_id = $this->mahasiswa_id;
        $mahasiswa = Mahasiswa::updateOrCreate([
            'id' => $mahasiswa_id
        ], [
            'nim' => $this->nim,
            'nama' => $this->nama,
        ]);

        // ipk = 1
        // Penghasilan Ortu/bln = 2
        // Jumlah Tanggungan = 3
        // Prestasi = 4
        // Lokasi Rumah = 5

        $ipk = Atribut::updateOrCreate([
            'mahasiswa_id' => $mahasiswa->id,
            'kriteria_id' => $this->getKriteriaIpk()['id']
        ], [
            'value' => number_format($this->ipk, 2)
        ]);

        $penghasilan = Atribut::updateOrCreate([
            'mahasiswa_id' => $mahasiswa->id,
            'kriteria_id' => $this->getKriteriaPenghasilan()['id']
        ], [
            'value' => (int) $this->penghasilan
        ]);

        $jumlah_tanggungan = Atribut::updateOrCreate([
            'mahasiswa_id' => $mahasiswa->id,
            'kriteria_id' => $this->getKriteriaTanggungan()['id']
        ], [
            'value' => (int) $this->jumlah_tanggungan
        ]);

        $prestasi = Atribut::updateOrCreate([
            'mahasiswa_id' => $mahasiswa->id,
            'kriteria_id' => $this->getKriteriaPrestasi()['id']
        ], [
            'value' => (int) $this->prestasi
        ]);

        $lokasi_rumah = Atribut::updateOrCreate([
            'mahasiswa_id' => $mahasiswa->id,
            'kriteria_id' => $this->getKriteriaLokasiRumah()['id']
        ], [
            'value' => (int) $this->lokasi_rumah
        ]);

        $mahasiswa_id ? $this->emit('success_message', 'Berhasil memperbaharui data')
            : $this->emit('success_message', 'Berhasil menambah data');

        DB::commit();

        $this->cleanInput();
        $this->closeModal();
    }

    public function edit($mahasiswa_id)
    {
        $this->openModal();
        $this->cleanInput();
        $this->mahasiswa_id = $mahasiswa_id;

        $mahasiswa = Mahasiswa::find($mahasiswa_id);
        $this->nim = $mahasiswa->nim;
        $this->nama = $mahasiswa->nama;

        // ipk = 1
        // Penghasilan Ortu/bln = 2
        // Jumlah Tanggungan = 3
        // Prestasi = 4
        // Lokasi Rumah = 5

        $ipk = Atribut::where([
            'mahasiswa_id' => $mahasiswa->id,
            'kriteria_id' => $this->getKriteriaIpk()['id']
        ])->first();
        $this->ipk = $ipk ? number_format($ipk->real_value, 2) : '';

        $penghasilan = Atribut::where([
            'mahasiswa_id' => $mahasiswa->id,
            'kriteria_id' => $this->getKriteriaPenghasilan()['id']
        ])->first();
        $this->penghasilan = $penghasilan ? $penghasilan->real_value : '';

        $jumlah_tanggungan = Atribut::where([
            'mahasiswa_id' => $mahasiswa->id,
            'kriteria_id' => $this->getKriteriaTanggungan()['id']
        ])->first();
        $this->jumlah_tanggungan = $jumlah_tanggungan ? $jumlah_tanggungan->real_value : '';

        $prestasi = Atribut::where([
            'mahasiswa_id' => $mahasiswa->id,
            'kriteria_id' => $this->getKriteriaPrestasi()['id']
        ])->first();
        $this->prestasi = $prestasi ? $prestasi->real_value : '';

        $lokasi_rumah = Atribut::where([
            'mahasiswa_id' => $mahasiswa->id,
            'kriteria_id' => $this->getKriteriaLokasiRumah()['id']
        ])->first();
        $this->lokasi_rumah = $lokasi_rumah ? $lokasi_rumah->real_value : '';

    }

    public function tambah()
    {
        $this->cleanInput();
        $this->openModal();
    }

    public function batal()
    {
        $this->cleanInput();
        $this->closeModal();
    }

    public function delete($mahasiswa_id)
    {
        DB::beginTransaction();
        Atribut::where('mahasiswa_id', $mahasiswa_id)->delete();
        Mahasiswa::where('id', $mahasiswa_id)->delete();
        DB::commit();
        $this->emit('success_message', 'Berhasil menghapus data');
    }

    public function cleanInput()
    {
        $this->mahasiswa_id = null;
        $this->nim = null;
        $this->nama = null;
        $this->ipk = null;
        $this->penghasilan = null;
        $this->jumlah_tanggungan = null;
        $this->prestasi = null;
        $this->lokasi_rumah = null;
    }
}
