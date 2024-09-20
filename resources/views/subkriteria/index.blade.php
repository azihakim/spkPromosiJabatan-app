@extends('master')

@section('styles')
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
	<div class="col-sm-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Sub Kriteria</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li>
						<a href="{{ route('subkriteria.create') }}"
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
										<th>No</th>
										<th>Kriteria</th>
										<th>Nama</th>
										<th>Bobot</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($data as $rank => $item)
										<tr>
											<td>{{ $rank + 1 }}</td>
											<td>{{ $item->kriteria->nama }}</td>
											<td>{{ $item->kode }}</td>
											<td>{{ $item->bobot }}</td>

											<td>
												<a href="{{ route('subkriteria.edit', $item->id) }}" class="btn btn-warning btn-xs">Edit</a>
												<form action="{{ route('subkriteria.destroy', $item->id) }}" method="POST" style="display: inline">
													@csrf
													@method('DELETE')
													<button type="submit" class="btn btn-danger btn-xs"
														onclick="return confirm('Apakah Anda Yakin?')">Hapus</button>
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
