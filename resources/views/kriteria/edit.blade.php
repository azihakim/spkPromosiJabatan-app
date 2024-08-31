@extends('master')
{{-- @section('title', 'Penilaian') --}}
@section('content')
	<div class="row">
		<div class="col-2"></div>
		<div class="col-8">
			<div class="x_panel">
				<div class="x_title">
					<h2>Form Edit Kriteria</h2>
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
					<form action="{{ route('kriteria.update', $data->id) }}" method="POST" enctype="multipart/form-data"
						class="form-label-left input_mask">
						@csrf
						@method('PUT')
						<div class="form-group row">
							<div class="col-md-6 col-sm-6 form-group has-feedback">
								<input value="{{ $data->nama }}" required name="nama" type="text" class="form-control has-feedback-left"
									id="inputSuccess2" placeholder="Masukkan Nama Kriteria">
								<span class="fa fa-bar-chart form-control-feedback left" aria-hidden="true"></span>
							</div>

							<div class="col-md-6 col-sm-6 form-group has-feedback">
								<input value="{{ $data->kode }}" required name="kode" type="text" class="form-control has-feedback-left"
									id="inputSuccess2" placeholder="Masukkan Kode Kriteria">
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
	</div>
@endsection
@section('scripts')
	<script>
		document.addEventListener('DOMContentLoaded', (event) => {
			const inputElement = document.getElementById('inputSuccess3');

			inputElement.addEventListener('input', function() {
				let value = parseInt(this.value, 10);

				if (isNaN(value) || value <= 0 || value > 100) {
					this.setCustomValidity('Nilai harus antara 1 dan 100.');
					this.reportValidity();
				} else {
					this.setCustomValidity('');
				}
			});
		});
	</script>

	<script>
		function goBack() {
			window.history.back();
		}
	</script>
@endsection