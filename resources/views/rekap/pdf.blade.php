<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Rekap Penilaian</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			margin: 20px;
		}

		h1,
		h3 {
			text-align: center;
		}

		table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 20px;
		}

		th,
		td {
			border: 1px solid #000;
			padding: 8px;
			text-align: left;
		}

		th {
			background-color: #f2f2f2;
		}

		.divisi-section {
			margin-bottom: 30px;
		}
	</style>
</head>

<body>
	<h1>Rekap Penilaian</h1>
	<h3>Tanggal Penilaian: {{ $request->tglPenilaian }}</h3>
	<h3>Divisi: {{ implode(', ', $request->divisi) }}</h3>

	@foreach ($request->divisi as $divisi)
		<div class="divisi-section">
			<h3>Divisi: {{ $divisi }}</h3>
			<table>
				<thead>
					<tr>
						<th>Karyawan</th>
						<th>Peringkat</th>
						<th>Nilai</th>
					</tr>
				</thead>
				<tbody>
					@php
						// Filter penilaian berdasarkan divisi saat ini
						$penilaianDivisi = $penilaian->where('divisi', $divisi);
					@endphp

					@if ($penilaianDivisi->isEmpty())
						<tr>
							<td colspan="5" style="text-align: center;">Tidak ada data untuk divisi ini.</td>
						</tr>
					@else
						@foreach ($penilaianDivisi as $item)
							<tr>
								<td>{{ $item->karyawans->nama }}</td>
								<td>{{ $item->peringkat }}</td>
								<td>{{ $item->nilai }}</td>
							</tr>
						@endforeach
					@endif
				</tbody>
			</table>
		</div>
	@endforeach
</body>

</html>
