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
				<h2>Penilaian</h2>
				@if (auth()->user()->role == 'operasional')
					<ul class="nav navbar-right panel_toolbox">
						<li>
							<a href="{{ route('penilaian.create') }}"
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
										<th>Divisi</th>
										<th>Tanggal Penilaian</th>
										<th>Status</th>
										<th style="width: 20%">Aksi</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($data as $item)
										<tr>
											<td>{{ $item->divisi }}</td>
											<td>{{ $item->tgl_penilaian }}</td>
											<td>
												@if ($item->status == '0')
													<span class="badge badge-danger">Belum di validasi</span>
												@else
													<span class="badge badge-success">Sudah di validasi</span>
												@endif
											</td>
											<td>
												<a href="{{ route('penilaian.show', [$item->divisi, $item->tgl_penilaian]) }}"
													class="btn btn-block btn-outline-info">Cek</a>
												@if (auth()->user()->role == 'operasional')
													<form action="{{ route('penilaian.destroy', [$item->divisi, $item->tgl_penilaian]) }}" method="POST"
														style="display:inline;">
														@csrf
														@method('DELETE')
														<button type="submit" class="btn btn-block btn-outline-danger">Hapus</button>
													</form>
												@endif
												@if (auth()->user()->role == 'direktur' && $item->status == '0')
													<form action="{{ route('penilaian.validasi', [$item->divisi, $item->tgl_penilaian]) }}" method="POST"
														style="display:inline;">
														@csrf
														@method('PUT')
														<button type="submit" class="btn btn-block btn-outline-warning">Simpan</button>
													</form>
												@endif
											</td>
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
