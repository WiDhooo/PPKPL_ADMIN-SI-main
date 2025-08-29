<!DOCTYPE html>
<html>
<head>
    <title>Data Pengajar</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        img { width: 60px; height: 60px; object-fit: cover; }
    </style>
</head>
<body>
    <h2>Data Pengajar</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIP</th>
                <th>Jabatan</th>
                <th>Pengalaman</th>
                <th>Pendidikan</th>
                <th>Mata Pelajaran</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($guru as $i => $g)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $g->nama }}</td>
                <td>{{ $g->nip }}</td>
                <td>{{ $g->jabatan }}</td>
                <td>{{ $g->pengalaman }} tahun</td>
                <td>{{ $g->pendidikan_terakhir }}</td>
                <td>{{ $g->mata_pelajaran }}</td>
                <td>
                    @if($g->gambar)
                
                        <img src="{{ asset('gambar/' . $g->gambar) }}" alt="foto">

                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
