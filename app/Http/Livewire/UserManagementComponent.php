<?php

namespace App\Http\Livewire;

use App\Models\Level;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class UserManagementComponent extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $name, $email, $password, $password_confirmation, $level_id, $foto, $avatar;
    public $isModal = 0;
    public $user_id;
    public $levels;
    public $search;
    public $level_filter;

    protected $paginationTheme = 'bootstrap';

    //FUNGSI INI AKAN DIPANGGIL KETIKA TOMBOL TAMBAH ANGGOTA DITEKAN
    public function create()
    {
        //KEMUDIAN DI DALAMNYA KITA MENJALANKAN FUNGSI UNTUK MENGOSONGKAN FIELD
        $this->resetFields();
        //DAN MEMBUKA MODAL
        $this->openModal();
    }

    //FUNGSI INI UNTUK MENUTUP MODAL DIMANA VARIABLE ISMODAL KITA SET JADI FALSE
    public function closeModal()
    {
        $this->isModal = false;
    }

    //FUNGSI INI DIGUNAKAN UNTUK MEMBUKA MODAL
    public function openModal()
    {
        $this->isModal = true;
    }

    //FUNGSI INI UNTUK ME-RESET FIELD/KOLOM, SESUAIKAN FIELD APA SAJA YANG KAMU MILIKI
    public function resetFields()
    {
        $this->user_id = false;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->level_id = false;
        $this->foto = false;
        $this->avatar = '';
    }

    //METHOD STORE AKAN MENG-HANDLE FUNGSI UNTUK MENYIMPAN / UPDATE DATA
    public function store()
    {
        //MEMBUAT VALIDASI
        $this->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'password' => 'sometimes|confirmed',
            'level_id' => 'required|exists:level,id',
            'foto' => 'sometimes'.( $this->foto ? '|required|file|max:4096|image|mimes:jpg,png,jpeg' : ''),
        ]);

        //QUERY UNTUK MENYIMPAN / MEMPERBAHARUI DATA MENGGUNAKAN UPDATEORCREATE
        //DIMANA ID MENJADI UNIQUE ID, JIKA IDNYA TERSEDIA, MAKA UPDATE DATANYA
        //JIKA TIDAK, MAKA TAMBAHKAN DATA BARU
        $user = User::updateOrCreate(['id' => $this->user_id], [
            'name' => $this->name,
            'email' => $this->email,
            'level_id' => $this->level_id,
            'password' => password_hash($this->password, PASSWORD_DEFAULT)
        ]);

        if ($this->password) $user->password = password_hash($this->password, PASSWORD_DEFAULT);

        if ($this->foto) {
            $name = md5($this->foto . microtime()).'.'.$this->foto->extension();

            $this->foto->storeAs('public/foto', $name);

            $user->avatar = 'storage/foto/'.$name;
        }

        $user->save();

        $this->emit('success_message', 'Berhasil menyimpan data');

        $this->closeModal(); //TUTUP MODAL
        $this->resetFields(); //DAN BERSIHKAN FIELD
    }

    //FUNGSI INI UNTUK MENGAMBIL DATA DARI DATABASE BERDASARKAN ID MEMBER
    public function edit($id)
    {
        $user = User::find($id);

        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->level_id = $user->level_id;
        $this->avatar = $user->avatar_url;

        $this->openModal(); //LALU BUKA MODAL
    }

    //FUNGSI INI UNTUK MENGHAPUS DATA
    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        $this->emit('success_message', 'Berhasil menghapus data');
    }

    public function cancel()
    {
        $this->closeModal();
        $this->resetFields();
    }

    public function renderData()
    {
        $this->levels = Level::all();
    }

    public function clearFilter()
    {
        $this->search='';
        $this->level_filter='';
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingLevelFilter()
    {
        $this->resetPage();
    }

    public function renderUser()
    {
        $user = new User();
        if ($this->search) $user = $user->where(function($user) {
            return $user->where('email', 'like', '%'.$this->search.'%')
                ->orWhere('name', 'like', '%'.$this->search.'%');
        });

        if ($this->level_filter) $user = $user->where('level_id', $this->level_filter);

        return $user->paginate(20);
    }


    public function render()
    {
        $this->renderData();
        return view('livewire.user-management-component', [
            'users' => $this->renderUser()
        ]);
    }
}
