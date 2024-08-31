@extends('master')
@section('title', 'Penilaian')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Penilaian</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <table id="datatable-buttons" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Karyawan</th>
                        <th>Tanggal Penilaian</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penilaian as $rank => $item)
                        @php
                            $data = json_decode($item->data);
                        @endphp
                        <tr>
                            <td>{{ $rank + 1 }}</td> {{-- Menampilkan ranking berdasarkan urutan --}}
                            <td>{{ $data->nama_karyawan }}</td> {{-- Menampilkan nama karyawan --}}
                            <td>{{ $item->tgl_penilaian }}</td> {{-- Menampilkan tanggal penilaian --}}
                            <td>
                                <pre>{{ $data->total_nilai }}</pre>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


        </div>
        <!-- /.card-body -->
    </div>
@endsection
