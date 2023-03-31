<!DOCTYPE html>
<html>
<head>
    <style>
        table{ border-spacing: 0; }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Laporan Nilai</title>
</head>
<body>
    <div class="container mt-5">
        <center><h2 class="text-center">Laporan Nilai</h2></center>
        <center>
            (Periode
            @foreach ($periode as $data)
                {{ $data === 'GANJIL' ? 'GASAL' : $data }}
            @endforeach
            )
        </center>
        <center>
            <p>Tanggal Cetak :
                @foreach ($date as $data)
                    {{ $data }}
                @endforeach
            </p>
        </center>
        <center>
            <p>Nama :
                @foreach ($name as $data)
                    {{ $data }}
                @endforeach
            </p>
        </center>
        <center>
            <p>Kelas :
                @foreach ($kelas as $data)
                    {{ $data }}
                @endforeach
            </p>
        </center>
        <table class="table table-bordered mb-5 mt-2">
            <thead>
                <tr class="table-danger">
                    <th scope="col">No</th>
                    <th scope="col">Pelajaran</th>
                    <th scope="col">Tugas</th>
                    <th scope="col">UTS</th>
                    <th scope="col">UAS</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1
                @endphp
                @foreach($nilai ?? '' as $data)
                <tr>
                    <th scope="row">{{ $no }}</th>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->tugas }}</td>
                    <td>{{ $data->uts }}</td>
                    <td>{{ $data->uas }}</td>
                </tr>
                @php
                    $no = $no + 1
                @endphp
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
