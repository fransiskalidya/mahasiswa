<html>
    <head>
        <title>Sistem Informasi Mahasiswa</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left mt-2">
                        <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
                        <br>
                        <h1 align="center">KARTU HASIL STUDI (KHS)</h1>
                    </div>
                    <br><br>
                    <div class="float-left my-2">
                        <p><strong>Nama :</strong> {{ $Mahasiswa->Nama }}</p>
                        <p><strong>NIM :</strong> {{ $Mahasiswa->Nim }}</p>
                        <p><strong>Kelas :</strong> {{ $Mahasiswa->kelas->nama_kelas }}</p>
                    </div>
                </div>
            </div>

            <table class="table table-bordered">
                <tr>
                    <th>Mata Kuliah</th>
                    <th>SKS</th>
                    <th>Semester</th>
                    <th>Nilai</th>
                </tr>
                <br><br>
                @foreach ($Mahasiswa->matakuliah as $matkul)
                <tr style="margin-top: 90px">
                    <td>{{ $matkul->nama_matkul }}</td>
                    <td>{{ $matkul->sks }}</td>
                    <td>{{ $matkul->semester }}</td>
                    <td>{{ $matkul->pivot->nilai }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </body>
</html>
