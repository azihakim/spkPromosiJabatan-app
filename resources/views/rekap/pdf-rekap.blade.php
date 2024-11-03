<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Rekapitulasi Penilaian Karyawan</title>
	<style>
		body {
			font-family: Arial, sans-serif;
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

		@foreach ($totalNilaiPerDivisi->groupBy('divisi') as $divisi => $dataDivisi)
			<div class="division-header">Divisi: {{ $divisi }}</div>

			<table>
				<thead>
					<tr>
						<th>Ranking</th>
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
							<td>{{ number_format($data->total_nilai, 2) }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		@endforeach
	</div>

	<div class="footer">
		<p>&copy; {{ date('Y') }} - PT Titisan Sang Pangeran</p>
	</div>

</body>

</html>
