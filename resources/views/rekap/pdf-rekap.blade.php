<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Rekapitulasi Penilaian Karyawan</title>
	<style>
		body {
			font-family: 'DejaVu Sans', Arial, sans-serif;
			font-size: 12px;
			margin: 0;
			padding: 0;
		}

		.header,
		.footer {
			text-align: center;
			margin-top: 20px;
		}

		.content {
			margin: 20px;
		}

		table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 10px;
		}

		table,
		th,
		td {
			border: 1px solid black;
			padding: 8px;
			text-align: center;
		}

		th {
			background-color: #f2f2f2;
		}

		.division-header {
			text-align: left;
			font-weight: bold;
			margin-top: 10px;
		}
	</style>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

	<div class="header">
		<h2>Rekapitulasi Penilaian Karyawan</h2>
		<p>Tanggal Penilaian: {{ $tgl_dari }} sampai {{ $tgl_sampai }}</p>
	</div>

	<div class="content">
		@php
			$currentDivision = null;
			$rank = 1;
		@endphp

		{{-- @foreach ($totalNilaiPerDivisi->groupBy('divisi') as $divisi => $dataDivisi)
			<div class="division-header">Divisi: {{ $divisi }}</div>

			<table>
				<thead>
					<tr>
						<th>Ranking</th>
						<th>Nama</th>
						<th>Total Nilai</th>
					</tr>
				</thead>
				<tbody>
					@php
						// Sort dataDivisi berdasarkan total_nilai dari yang tertinggi
						$sortedData = $dataDivisi->sortByDesc('total_nilai');
						$rank = 1; // Reset rank untuk setiap divisi baru
					@endphp
					@foreach ($sortedData as $data)
						<tr>
							<td>{{ $rank++ }}</td>
							<td>{{ $data->karyawans->nama }}</td>
							<td>{{ number_format($data->total_nilai, 2) }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		@endforeach --}}

		@foreach ($totalNilaiPerDivisi->groupBy('divisi') as $divisi => $dataDivisi)
			<h3 class="mt-4">Divisi: {{ $divisi }}</h3>

			<table class="table table-bordered table-striped">
				<thead class="thead-dark">
					<tr>
						<th>Rank</th>
						<th>Karyawan</th>
						<th>Nilai</th>
						<th>Tingkat Pendidikan</th>
						<th>Kompetensi</th>
						<th>Tekanan Waktu</th>
						<th>Absensi</th>
						<th>Tanggung Jawab</th>
					</tr>
				</thead>
				<tbody>
					@php
						$rank = 1; // Inisialisasi rank
					@endphp
					@foreach ($dataDivisi as $data)
						<tr>
							<td>{{ $rank++ }}</td>
							<td>{{ $data->nama_karyawan }}</td>
							<td>{{ number_format($data->total_nilai, 2) }}</td>
							@foreach ($data->kriteria as $kriteria)
								<td>{{ $kriteria['rentang_subkriteria'] ?? '-' }}</td>
							@endforeach
						</tr>
					@endforeach
				</tbody>
			</table>
		@endforeach
		<hr>
		<h2>Grafik Penilaian Karyawan</h2>

		@foreach ($grafik['grafikData'] as $divisi => $tanggalData)
			<h2>Divisi: {{ $divisi }}</h2>
			@foreach ($tanggalData as $tanggal => $data)
				<h4>Tanggal Penilaian: {{ $tanggal }}</h4>
				<div style="width: 100%; margin: auto; padding-bottom: 20px;">
					<!-- Tampilkan gambar grafik -->
					<img src="{{ storage_path('app/public/' . $chartImages[$divisi][$tanggal]) }}"
						alt="Grafik Nilai Divisi {{ $divisi }} - Tanggal {{ $tanggal }}" style="width: 100%">
				</div>
			@endforeach
		@endforeach




	</div>


</body>

</html>
