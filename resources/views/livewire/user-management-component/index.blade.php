<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-1 mt-1">
                <div class="input-group">
                    <button class="btn btn-primary btn-block" wire:click="create()">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>

            <div class="col-3 mt-1">
                <div class="input-group">
                    <input type="text" wire:model="search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                        <button class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-3 mt-1">
                <div class="input-group">
                    <select wire:model="level_filter" class="form-control">
                        <option value="">--Filter level--</option>
                        @foreach($levels as $level)
                            <option value="{{$level->id}}">{{$level->deskripsi}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @if($search || $level_filter)
                <div class="col-1 mt-1">
                    <div class="input-group">
                        <button class="btn btn-primary btn-block" wire:click="clearFilter()">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
            @endif
        </div>

        @if($users->lastPage() > 1)
            <div class="row">
                <div class="col-12 mt-3 ">
                    {{$users->links()}}
                </div>
            </div>
        @endif

    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0" style="max-height: 700px;">
        <table class="table table-head-fixed text-nowrap">
            <thead>
            <tr>
                <th>ID *</th>
                <th>Foto</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Level</th>
                <th>Opsi</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td><img src="{{$user->avatar_url}}" alt="Image" style="max-width: 60px;max-height: 60px;"></td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->level->deskripsi}}</td>
                    <td>
                        <a href="#" wire:click.prevent="edit({{$user->id}})" class="btn btn-primary" title="Edit Data">
                            <i class="fa fa-pencil-alt"></i>
                        </a>
                        <a href="#" onclick="deleteConfirmation(event, {{$user->id}})" wire.click="" class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->

    @if($users->lastPage() > 1)
        <div class="card-footer">
            <div class="row">
                <div class="col-12 mt-3 ">
                    {{$users->links()}}
                </div>
            </div>
        </div>

    @endif

</div>
<!-- /.card -->


@push('js')
    <script>
        function deleteConfirmation(event, id) {
            event.preventDefault();
            var cf = confirm('Apakah anda yakin akan menghapus data ?');
            if (cf) @this.call('delete', id);
        }
    </script>
@endpush
