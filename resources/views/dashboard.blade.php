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
						<div class="card-box table">
							<div class="text-center">
								{{-- <img src="{{ asset('vendors/build/images/logo.png') }}" style="width: 150px"> --}}
								<h1> PT BPR Syariah Al-Falah</h1>
								<h1>Selamat Datang</h1>
								<h2>Sistem Pendukung Keputusan</h2>
								<h2>Promosi Jabatan</h2>
								<hr>
								{{-- <h2>Kriteria Penilaian dan Indikator Penilaian Karyawan</h2> --}}
							</div>
							{{-- <div class="row ">
								<img style="width: 60%" src="{{ asset('vendors/build/images/struktur.png') }}" alt="" class="mx-auto">

							</div>
							<br> --}}
							<div class="text-center">
								{{-- <hr> --}}
								<h2>Penilaian SPK</h2>
							</div>
							<div class="row">
								<div class="col-3">
									<table border="1" cellpadding="5" cellspacing="0">
										<thead>
											<tr style="background-color: #c3e6cb;">
												<th>Kode</th>
												<th>Keterangan</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>C1</td>
												<td>Tingkat Pendidikan</td>
											</tr>
											<tr>
												<td>C2</td>
												<td>Kompetensi</td>
											</tr>
											<tr>
												<td>C3</td>
												<td>Tekanan Waktu</td>
											</tr>
											<tr>
												<td>C4</td>
												<td>Presensi kehadiran</td>
											</tr>
											<tr>
												<td>C5</td>
												<td>Tanggung Jawab Pekerjaan</td>
											</tr>
										</tbody>
									</table>

								</div>
								<div class="col-3">
									<table border="1" cellpadding="5" cellspacing="0">
										<thead>
											<tr style="background-color: #c3e6cb;">
												<th>Kode</th>
												<th>Keterangan</th>
												<th>Nilai</th>
											</tr>
										</thead>
										<tbody>
											<!-- Tingkat Pendidikan -->
											<tr>
												<td colspan="3" style="background-color: #f8f9fa; text-align: center;">Tingkat Pendidikan</td>
											</tr>
											<tr style="background-color: #f8d7da;">
												<td>C1.1</td>
												<td>SMA/SMK</td>
												<td>1</td>
											</tr>
											<tr style="background-color: #f8d7da;">
												<td>C1.2</td>
												<td>D3/S1</td>
												<td>2</td>
											</tr>
											<tr style="background-color: #f8d7da;">
												<td>C1.3</td>
												<td>S1/S2</td>
												<td>3</td>
											</tr>

											<!-- Kompetensi -->
											<tr>
												<td colspan="3" style="background-color: #f8f9fa; text-align: center;">Kompetensi</td>
											</tr>
											<tr style="background-color: #fff3cd;">
												<td>C2.1</td>
												<td>&lt;80</td>
												<td>1</td>
											</tr>
											<tr style="background-color: #fff3cd;">
												<td>C2.2</td>
												<td>81-90</td>
												<td>2</td>
											</tr>
											<tr style="background-color: #fff3cd;">
												<td>C2.3</td>
												<td>91-100</td>
												<td>3</td>
											</tr>
										</tbody>
									</table>

								</div>
								<div class="col-3">
									<table border="1" cellpadding="5" cellspacing="0">
										<thead>
											<tr style="background-color: #c3e6cb;">
												<th>Kode</th>
												<th>Keterangan</th>
												<th>Nilai</th>
											</tr>
										</thead>
										<tbody>
											<!-- Tekanan Waktu -->
											<tr>
												<td colspan="3" style="background-color: #f8f9fa; text-align: center;">Tekanan Waktu</td>
											</tr>
											<tr style="background-color: #d4edda;">
												<td>C3.1</td>
												<td>1-5</td>
												<td>1</td>
											</tr>
											<tr style="background-color: #d4edda;">
												<td>C3.2</td>
												<td>6-12</td>
												<td>2</td>
											</tr>
											<tr style="background-color: #d4edda;">
												<td>C3.3</td>
												<td>&gt;12</td>
												<td>3</td>
											</tr>

											<!-- Presensi kehadiran -->
											<tr>
												<td colspan="3" style="background-color: #f8f9fa; text-align: center;">Presensi kehadiran</td>
											</tr>
											<tr style="background-color: #cce5ff;">
												<td>C4.1</td>
												<td>75-80%</td>
												<td>1</td>
											</tr>
											<tr style="background-color: #cce5ff;">
												<td>C4.2</td>
												<td>81-85%</td>
												<td>2</td>
											</tr>
											<tr style="background-color: #cce5ff;">
												<td>C4.3</td>
												<td>&gt;85%</td>
												<td>3</td>
											</tr>
										</tbody>
									</table>

								</div>
								<div class="col-3">
									<table border="1" cellpadding="5" cellspacing="0">
										<thead>
											<tr style="background-color: #c3e6cb;">
												<th>Kode</th>
												<th>Keterangan</th>
												<th>Nilai</th>
											</tr>
										</thead>
										<tbody>
											<!-- Tanggung Jawab Pekerjaan -->
											<tr>
												<td colspan="3" style="background-color: #f8f9fa; text-align: center;">Tanggung Jawab Pekerjaan</td>
											</tr>
											<tr style="background-color: #ffeeba;">
												<td>C5.1</td>
												<td>Rendah</td>
												<td>1</td>
											</tr>
											<tr style="background-color: #ffeeba;">
												<td>C5.2</td>
												<td>Sedang</td>
												<td>2</td>
											</tr>
											<tr style="background-color: #ffeeba;">
												<td>C5.3</td>
												<td>Tinggi</td>
												<td>3</td>
											</tr>
										</tbody>
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
