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
										<th>Jabatan</th>
										@if (auth()->user()->role == 'hrd')
											<th style="width: 20%">Aksi</th>
										@endif
									</tr>
								</thead>
								<tbody>
									@foreach ($karyawan as $item)
										<tr>
											<td>{{ $item->nama }}</td>
											<td>{{ $item->jabatan }}</td>
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
												</td>
											@endif
										</tr>
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
