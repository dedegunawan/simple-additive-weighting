<div class="card">
    <div class="card-body table-responsive p-0" style="max-height: 700px;">
        <table class="table table-head-fixed text-nowrap table-bordered table-hover">
            <thead>
            <tr>
                <th class="text-center align-middle">Ranking</th>
                <th class="text-center align-middle">
                    Nama
                </th>
                <th class="text-center align-middle">
                    Perhitungan
                </th>
                <th class="text-center align-middle">
                    Hasil Akhir
                </th>
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
                @foreach ($ranking as $index => $urutan)
                    <tr>
                        <td class="text-center align-middle">{{$urutan}}</td>
                        <td class="text-center align-middle">
                            {{$normalisasi[$index]['mahasiswa']['nama']}} ({{$normalisasi[$index]['mahasiswa']['nim']}})
                        </td>

                        <td class="text-center align-middle">
                            ({{number_format($normalisasi[$index]['ipk_result'], 2, ".", ",")}}x{{$kriteria['ipk']}}%)
                            +
                            ({{number_format($normalisasi[$index]['penghasilan_result'], 2, ".", ",")}}x{{$kriteria['penghasilan']}}%)
                            +
                            ({{number_format($normalisasi[$index]['jumlah_tanggungan_result'], 2, ".", ",")}}x{{$kriteria['jumlah_tanggungan']}}%)
                            +
                            ({{number_format($normalisasi[$index]['prestasi_result'], 2, ".", ",")}}x{{$kriteria['prestasi']}}%)
                            +
                            ({{number_format($normalisasi[$index]['lokasi_rumah_result'], 2, ".", ",")}}x{{$kriteria['lokasi_rumah']}}%)
                        </td>
                        <td>
                            {{number_format($normalisasi[$index]['skor'], 2, ".", ",")}}
                        </td>

                    </tr>
                @endforeach
            @endif

            </tbody>
        </table>
    </div>
    <!-- /.card-body -->

</div>
<!-- /.card -->
