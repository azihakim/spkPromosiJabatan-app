@extends('master')

@section('styles')
@endsection

@section('content')
	<div class="col-md-12 col-sm-12">
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
		<div class="x_panel">
			<div class="x_title">
				<h2>Karyawan</h2>
				@if (auth()->user()->role == 'hrd')
					<ul class="nav navbar-right panel_toolbox">
						<li>
							<a href="{{ route('karyawan.create') }}"
								style="text-decoration: none; transition: color 0.3s; color: rgb(76, 75, 75);">
								<i class="fa fa-plus"></i> Tambah
							</a>
						</li>
					</ul>
				@endif
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="col-sm-12">
						<div class="card-box table-responsive">
							<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
								width="100%">
								<thead>
									<tr>
										<th>Nama</th>
										<th>Divisi</th>
										<th>Penilaian</th>
										@if (auth()->user()->role == 'hrd')
											<th style="width: 20%">Aksi</th>
										@endif
									</tr>
								</thead>
								<tbody>
									@foreach ($karyawan as $divisi => $employees)
										<tr>
											<td colspan="4" style="font-weight: bold;">{{ $divisi }}</td> <!-- Display Division Name -->
										</tr>
										@foreach ($employees as $item)
											<tr>
												<td>{{ $item->nama }}</td>
												<td>{{ $item->divisi }}</td>
												<td style="text-align: center">
													@if ($item->penilaianDb->last() && $item->penilaianDb->last()->tgl_penilaian == null)
														<span class="badge badge-warning">Penilaian Belum</span>
													@else
														@if ($item->penilaianDb->last() && $item->penilaianDb->last()->tgl_penilaian)
															<span class="badge badge-success">
																{{ \Carbon\Carbon::parse($item->penilaianDb->last()->tgl_penilaian)->format('d F Y') }}
															</span>
														@else
															<span class="badge badge-warning">Belum Dinilai</span>
														@endif
													@endif
												</td>
												@if (auth()->user()->role == 'hrd')
													<td style="text-align: center">
														<div class="col-md-6">
															<a href="{{ route('karyawan.edit', $item->id) }}" class="btn-hover">
																<i class="fa fa-pencil"></i> Edit
															</a>
														</div>
														<div class="col-md-6">
															<a href="{{ route('penilaiankaryawan.create', $item->id) }}" class="btn-hover">
																<i class="fa fa-gears"></i> Penilaian
															</a>
														</div>
														<div class="col-md-6">
															<form action="{{ route('karyawan.destroy', $item->id) }}" method="POST"
																onsubmit="return confirm('Are you sure you want to delete this employee?');">
																@csrf
																@method('DELETE')
																<button type="submit" class="btn-hover" style="background: none; border: none; color: red;">
																	<i class="fa fa-trash"></i> Hapus
																</button>
															</form>
														</div>
													</td>
												@endif
											</tr>
										@endforeach
									@endforeach
								</tbody>
							</table>


						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
