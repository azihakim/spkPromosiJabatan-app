@extends('master')
{{-- @section('title', 'Penilaian') --}}
@section('content')
	@if (session('error'))
		<div class="alert alert-error">
			{{ session('error') }}
		</div>
	@endif

	<div class="col-2"></div>
	<div class="col-8">
		<div class="x_panel">
			<div class="x_title">
				<h2>Form Tambah Kriteria</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li>
						<a class="close-link" onclick="goBack()">
							<i class="fa fa-close"></i> Batal
						</a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<br>
				<form action="{{ route('kriteria.store') }}" method="POST" enctype="multipart/form-data"
					class="form-label-left input_mask">
					@csrf
					<div class="form-group row">
						<div class="col-md-6 col-sm-6 form-group has-feedback">
							<input required name="nama" type="text" class="form-control has-feedback-left" id="inputSuccess2"
								placeholder="Masukkan Nama Kriteria">
							<span class="fa fa-bar-chart form-control-feedback left" aria-hidden="true"></span>
						</div>

						<div class="col-md-6 col-sm-6 form-group has-feedback">
							<input required name="kode" type="text" class="form-control has-feedback-left" id="inputSuccess2"
								placeholder="Masukkan Kode Kriteria">
							<span class="fa fa-bar-chart form-control-feedback left" aria-hidden="true"></span>
						</div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group row">
						<div class="col-md-12 col-sm-12 offset-md-5">
							<button type="submit" class="btn btn-success">Simpan</button>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
	<div class="col-2"></div>
@endsection
@section('scripts')
	<script>
		function preventMinus(event) {
			if (event.key === '-' || event.keyCode === 45) {
				event.preventDefault();
			}
		}
	</script>
	<script>
		function goBack() {
			window.history.back();
		}
	</script>
@endsection
