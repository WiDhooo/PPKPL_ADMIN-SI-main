@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Data Santri</h1>
    <table class="min-w-full bg-white border border-gray-300">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b border-gray-300">NIK</th>
                <th class="py-2 px-4 border-b border-gray-300">Nama Santri</th>
                <th class="py-2 px-4 border-b border-gray-300">Usia</th>
                <th class="py-2 px-4 border-b border-gray-300">Jenis Kelamin</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($santris as $santri)
            <tr>
                <td class="py-2 px-4 border-b border-gray-300">{{ $santri->nik }}</td>
                <td class="py-2 px-4 border-b border-gray-300">{{ $santri->nama_santri }}</td>
                <td class="py-2 px-4 border-b border-gray-300">
                    @php
                        $birthDate = \Carbon\Carbon::parse($santri->tanggal_lahir);
                        $age = $birthDate->age;
                    @endphp
                    {{ $age }} tahun
                </td>
                <td class="py-2 px-4 border-b border-gray-300">
                    {{ $santri->jenis_kelamin == 'P' ? 'Perempuan' : 'Laki-laki' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
