@extends('master')
@section('title', 'Penilaian')
@section('content')
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Data Penilaian Divisi {{ $divisi }} | {{ $tgl_penilaian }}</h3>
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
							<th style="width: 5%; ">Rank</th>
							<th>Karyawan</th>
							<th>Nilai</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($penilaian as $item)
							<tr>
								<td style="text-align:center">{{ $item->peringkat }}</td>
								<td>{{ $item->karyawans->nama }}</td>
								<td>{{ $item->nilai }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>


			</div>
			<!-- /.card-body -->
		</div>
	</div>
@endsection
