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
    <h1>Halaman Kosong</h1>
@endsection
