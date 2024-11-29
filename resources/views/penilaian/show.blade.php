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

				<table id="datatable" class="table table-striped table-bordered" style="width:100%">
					<thead>
						<!-- Baris Header Utama -->
						<tr>
							<th rowspan="2" style="width: 5%; text-align: center; vertical-align: middle;">Rank</th>
							<th rowspan="2" style="text-align: center; vertical-align: middle;">Karyawan</th>
							<th rowspan="2" style="text-align: center; vertical-align: middle;">Nilai</th>
							<th colspan="{{ count($kriteria) }}" style="text-align: center; vertical-align: middle;">Detail Kriteria</th>
						</tr>
						<!-- Baris Header Sub-Kriteria -->
						<tr>
							@foreach ($kriteria as $k)
								<th style="text-align: center; vertical-align: middle;">{{ $k->nama }}</th>
							@endforeach
						</tr>
					</thead>
					<tbody>
						@foreach ($penilaian as $item)
							<tr>
								<td style="text-align:center; vertical-align: middle;">{{ $item->peringkat }}</td>
								<td style="vertical-align: middle;">{{ $item->karyawans->nama }}</td>
								<td style="text-align:center; vertical-align: middle;">{{ $item->nilai }}</td>
								@foreach ($kriteria as $k)
									<td style="text-align: center; vertical-align: middle;">
										@php
											$nilai = $item->nilai_kriteria[$k->kode] ?? null;
											$rentang = $nilai ? $subKriteriaMapping[$k->id][$nilai] ?? '-' : '-';
										@endphp
										{{ $rentang }}
									</td>
								@endforeach
							</tr>
						@endforeach
					</tbody>
				</table>



				{{-- <div class="table-responsive">
					<!-- Tabel Nilai Kriteria -->
					<table class="table table-striped table-bordered" style="width:100%">
						<thead>
							<tr>
								<th>Karyawan</th>
								@foreach ($kriteria as $k)
									<th>{{ $k->nama }}</th>
								@endforeach
							</tr>
						</thead>
						<tbody>
							@foreach ($penilaian as $item)
								<tr>
									<td>{{ $item->karyawans->nama }}</td>
									@foreach ($kriteria as $k)
										<td>
											@php
												$nilai = $item->nilai_kriteria[$k->kode] ?? null;
												$rentang = $nilai ? $subKriteriaMapping[$k->id][$nilai] ?? '-' : '-';
											@endphp
											{{ $rentang }}
										</td>
									@endforeach
								</tr>
							@endforeach
						</tbody>
					</table>
				</div> --}}


			</div>
			<!-- /.card-body -->
		</div>
	</div>
@endsection
