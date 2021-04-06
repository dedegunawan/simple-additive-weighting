<div class="card">
    <div class="card-body table-responsive p-0" style="max-height: 700px;">
        <table class="table table-head-fixed text-nowrap table-bordered table-hover">
            <thead>
            <tr>
                <th class="text-center align-middle">No.</th>
                @foreach($header as $h)
                    <th class="text-center align-middle">
                        {!! $h !!}
                    </th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @if($error_messages!='')
                <tr>
                    <td>
                        <div class="alert alert-danger">
                            {{$error_messages}}
                        </div>
                    </td>
                </tr>
            @else
                @foreach ($data_dasar as $key => $data)
                    <tr>
                        <td class="text-center align-middle">{{$key+1}}</td>
                        <td class="text-center align-middle">{{$data['mahasiswa']->nim}}</td>
                        <td class="text-center align-middle">{{$data['mahasiswa']->nama}}</td>
                        <td class="text-center align-middle">{{$data['ipk']->value}}</td>
                        <td class="text-center align-middle">{{$data['penghasilan']->value}}</td>
                        <td class="text-center align-middle">{{$data['jumlah_tanggungan']->value}}</td>
                        <td class="text-center align-middle">{{$data['prestasi']->value}}</td>
                        <td class="text-center align-middle">{{$data['lokasi_rumah']->value}}</td>
                    </tr>
                @endforeach
            @endif

            </tbody>
        </table>

        <ol class="mt-2">
            <li>IPK : Benefit</li>
            <li>Penghasilan Orang Tua / bln : Cost</li>
            <li>Jumlah Tanggungan : Benefit</li>
            <li>Prestasi : Benefit</li>
            <li>Lokasi Rumah (km) : Cost</li>
        </ol>
    </div>
    <!-- /.card-body -->

</div>
<!-- /.card -->
