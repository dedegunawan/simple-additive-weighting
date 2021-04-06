<!-- general form elements -->
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Tambah Akun</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="form-group">
            <label for="email">Nama Lengkap</label>
            <input type="text" class="form-control" id="name" wire:model="name" placeholder="Nama Lengkap">
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="email">Alamat Email</label>
            <input type="email" class="form-control" id="email" wire:model="email" placeholder="Alamat Email">
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" wire:model="password" placeholder="Password">
            @error('password') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" class="form-control" id="password_confirmation" wire:model="password_confirmation" placeholder="Konfirmasi Password">
            @error('password_confirmation') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="password_confirmation">Level</label>
            <select wire:model="level_id" class="form-control">
                <option value="">--Filter level--</option>
                @foreach($levels as $level)
                    <option value="{{$level->id}}">{{$level->deskripsi}}</option>
                @endforeach
            </select>
            @error('level_id') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <x-custom-upload-component title="Upload foto" wire:model="foto" name="foto" accept="image/jpeg,image/png"></x-custom-upload-component>
            @error('foto') <span class="error">{{ $message }}</span> @enderror
        </div>

        @if ($foto)
            <div style="text-align: center">
                Photo Preview:
                <br>
                <img src="{{ $foto->temporaryUrl() }}" style="max-width: 100%;max-height: 200px;">
            </div>
        @elseif ($avatar)
            <div style="text-align: center">
                Photo Preview:
                <br>
                <img src="{{ $avatar }}" style="max-width: 100%;max-height: 200px;">
            </div>
        @endif

    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:click.prevent="store()">
            {{$user_id ? 'Ubah' : 'Tambah'}}
        </button>
        <button type="submit" class="btn btn-primary" wire:click.prevent="cancel()">
            Batal
        </button>
    </div>
</div>
<!-- /.card -->
