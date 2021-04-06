<?php

namespace App\Http\Livewire;

use App\Models\Atribut;
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
        return CripsDetail::where('crips_id', '1')
            ->orderBy('kelompok', 'asc')
            ->get();
    }

    public function getPrestasiLists()
    {
        return CripsDetail::where('crips_id', '2')
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
            'kriteria_id' => 1
        ], [
            'value' => number_format($this->ipk, 2)
        ]);

        $penghasilan = Atribut::updateOrCreate([
            'mahasiswa_id' => $mahasiswa->id,
            'kriteria_id' => 2
        ], [
            'value' => (int) $this->penghasilan
        ]);

        $jumlah_tanggungan = Atribut::updateOrCreate([
            'mahasiswa_id' => $mahasiswa->id,
            'kriteria_id' => 3
        ], [
            'value' => (int) $this->jumlah_tanggungan
        ]);

        $prestasi = Atribut::updateOrCreate([
            'mahasiswa_id' => $mahasiswa->id,
            'kriteria_id' => 4
        ], [
            'value' => (int) $this->prestasi
        ]);

        $lokasi_rumah = Atribut::updateOrCreate([
            'mahasiswa_id' => $mahasiswa->id,
            'kriteria_id' => 5
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
            'kriteria_id' => 1
        ])->first();
        $this->ipk = $ipk ? number_format($ipk->real_value, 2) : '';

        $penghasilan = Atribut::where([
            'mahasiswa_id' => $mahasiswa->id,
            'kriteria_id' => 2
        ])->first();
        $this->penghasilan = $penghasilan ? $penghasilan->real_value : '';

        $jumlah_tanggungan = Atribut::where([
            'mahasiswa_id' => $mahasiswa->id,
            'kriteria_id' => 3
        ])->first();
        $this->jumlah_tanggungan = $jumlah_tanggungan ? $jumlah_tanggungan->real_value : '';

        $prestasi = Atribut::where([
            'mahasiswa_id' => $mahasiswa->id,
            'kriteria_id' => 4
        ])->first();
        $this->prestasi = $prestasi ? $prestasi->real_value : '';

        $lokasi_rumah = Atribut::where([
            'mahasiswa_id' => $mahasiswa->id,
            'kriteria_id' => 5
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
