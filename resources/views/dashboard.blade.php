@extends('master')

@section('styles')
    <style>
        hr.vertical-line {
            height: 100px;
            /* Atur tinggi garis vertikal */
            margin: 0 20px;
            /* Sesuaikan jarak dari elemen sebelumnya */
            border-left: 1px solid black;
            /* Atur warna dan ketebalan garis sesuai kebutuhan */
        }
    </style>
    <style>
        .formula-table {
            width: 100%;
            border-collapse: collapse;
        }

        .formula-table th,
        .formula-table td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }

        .formula-table th {
            background-color: #8CC152;
            color: white;
        }

        .formula-table .highlight {
            background-color: #E6E6E6;
        }
    </style>
@endsection

@section('content')
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
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <div class="text-center">
                                <img src="{{ asset('vendors/build/images/logo.png') }}" style="width: 150px">
                                <h1>Selamat Datang</h1>
                                <h2>Sistem Pendukung Keputusan</h2>
                                <hr>
                                <h2>Kriteria Penilaian dan Indikator Penilaian Karyawadn</h2>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Kriteria</th>
                                                <th>Sub Kriteria</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $item)
                                                <tr>
                                                    <td>{{ $item->nama }}</td>
                                                    <td>
                                                        <ul>
                                                            @foreach ($item->subKriterias as $sub)
                                                                <li>{{ $sub->nama }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-6">
                                    <table class="formula-table">
                                        <tr>
                                            <th colspan="2">Rumus</th>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Nilai sub Kriteria 1 = Nilai Kehadiran × Bobot Sub 1</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Nilai sub Kriteria 2 = Nilai Kehadiran × Bobot Sub 2</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Nilai sub Kriteria 3 = Nilai Kehadiran × Bobot Sub 3</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Nilai Akhir Kriteria = Nilai sub Kriteria 1 + Nilai sub
                                                Kriteria 2 + Skor Sub Kriteria 3</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Nilai Karyawan = <br> (Nilai Akhir Kriteria × Bobot Utama) /
                                                Jumlah Sub Kriteria</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
