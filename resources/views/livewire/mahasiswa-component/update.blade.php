<!-- general form elements -->
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{$mahasiswa_id ? 'Update' : 'Tambah'}} Mahasiswa</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="form-group">
            <label for="nim">NIM</label>
            <input type="text" class="form-control" wire:model="nim">
            @error('nim') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" wire:model="nama">
            @error('nama') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="ipk">IPK</label>
            <input type="number" class="form-control" wire:model="ipk"  max="4.00" min="0.00" step="0.01">
            @error('ipk') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="penghasilan">Penghasilan Ortu/bln (juta)</label>
            <select wire:model="penghasilan" id="" class="form-control">
                <option value="">--Pilih Salah Satu--</option>
                @foreach($penghasilanLists as $penghasilan)
                    <option value="{{$penghasilan->kelompok}}">{{$penghasilan->deskripsi}}</option>
                @endforeach
            </select>
            @error('penghasilan') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="jumlah_tanggungan">Jumlah Tanggungan (orang)</label>
            <input type="number" class="form-control" wire:model="jumlah_tanggungan"  step="1">
            @error('jumlah_tanggungan') <span class="error">{{ $message }}</span> @enderror
        </div>


        <div class="form-group">
            <label for="prestasi">Prestasi</label>
            <select wire:model="prestasi" id="" class="form-control" >
                <option value="">--Pilih Salah Satu--</option>
                @foreach($prestasiLists as $prestasi)
                    <option value="{{$prestasi->kelompok}}">{{$prestasi->deskripsi}}</option>
                @endforeach
            </select>
            @error('prestasi') <span class="error">{{ $message }}</span> @enderror
        </div>


        <div class="form-group">
            <label for="lokasi_rumah">Lokasi Rumah (km)</label>
            <input type="number" class="form-control" wire:model="lokasi_rumah"  step="1">
            @error('lokasi_rumah') <span class="error">{{ $message }}</span> @enderror
        </div>

    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:click.prevent="simpan()">
            {{$mahasiswa_id ? 'Ubah' : 'Tambah'}}
        </button>
        <button type="submit" class="btn btn-primary" wire:click.prevent="batal()">
            Batal
        </button>
    </div>
</div>
<!-- /.card -->
