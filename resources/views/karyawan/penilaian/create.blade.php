@extends('master')
{{-- @section('title', 'Penilaian') --}}
@section('content')
	<div class="x_panel">
		<div class="x_title">
			<h2>Form Tambah Karyawan</h2>
			<ul class="nav navbar-right panel_toolbox">
				<li>
					<a onclick="goBack()">
						<i class="fa fa-close"></i>
					</a>
				</li>
			</ul>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<br>
			<form action="{{ route('penilaiankaryawan.store', $karyawan->id) }}" method="POST" enctype="multipart/form-data"
				class="form-label-left input_mask">
				@csrf
				<div class="form-group row">
					<div class="col-md-6 col-sm-6 form-group">
						<input disabled value="{{ $karyawan->nama }}" name="nama" type="text" class="form-control has-feedback-left"
							placeholder="Nama">
						<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
					</div>

					<div class="col-md-6 col-sm-6 form-group has-feedback">
						<input disabled value="{{ $karyawan->jabatan }}" name="jabatan" type="text" class="form-control"
							id="inputSuccess3" placeholder="Jabatan">
						<span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
					</div>
				</div>

				<div class="form-group row">
					@foreach ($kriteriaPenilaian as $k)
						<div class="col-md-2 col-sm-2 col-xs-2">
							<span class="form-control-feedback left" aria-hidden="true">{{ $k['kode'] }}</span>
							<select class="form-control has-feedback-left" name="penilaianData[{{ $karyawan->id }}][{{ $k['kode'] }}]">
								<option value="">{{ $k['nama'] }}</option>
								@foreach ($k['sub_kriterias'] as $subKriteria)
									<?php
									// Ambil nilai penilaian sebelumnya berdasarkan kode kriteria (contoh: C1, C2)
									$penilaianSebelumnya = isset($penilaian[$karyawan->id][$k['kode']]) ? $penilaian[$karyawan->id][$k['kode']] : null;
									?>
									<option value="{{ $subKriteria['bobot'] }}"
										{{ (string) $penilaianSebelumnya === (string) $subKriteria['bobot'] ? 'selected' : '' }}>
										{{ $subKriteria['rentang'] }}
									</option>
								@endforeach
							</select>
						</div>
					@endforeach
				</div>

				<div class="ln_solid"></div>

				<div class="ln_solid"></div>
				<div class="form-group row">
					<div class="col-md-12 col-sm-12  offset-md-5">
						<button type="submit" class="btn btn-success">Simpan</button>
					</div>
				</div>

			</form>
		</div>
	</div>
@endsection
@section('scripts')
	<script>
		function goBack() {
			window.history.back();
		}
	</script>
@endsection
