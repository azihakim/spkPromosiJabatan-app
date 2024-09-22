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
				<ul class="nav navbar-right panel_toolbox">
					<li>
						<a href="{{ route('penilaian.create') }}"
							style="text-decoration: none; transition: color 0.3s; color: rgb(76, 75, 75);">
							<i class="fa fa-plus"></i> Tambah
						</a>
					</li>
				</ul>
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
										<th style="width: 20%">Aksi</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($data as $item)
										<tr>
											<td>{{ $item->divisi }}</td>
											<td>{{ $item->tgl_penilaian }}</td>
											<td>
												<a href="{{ route('penilaian.show', [$item->divisi, $item->tgl_penilaian]) }}"
													class="btn btn-block btn-outline-info">Cek</a>
												<form action="{{ route('penilaian.destroy', [$item->divisi, $item->tgl_penilaian]) }}" method="POST"
													style="display:inline;">
													@csrf
													@method('DELETE')
													<button type="submit" class="btn btn-block btn-outline-danger">Hapus</button>
												</form>
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
