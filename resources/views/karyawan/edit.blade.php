@extends('master')
{{-- @section('title', 'Penilaian') --}}
@section('content')
	<div class="x_panel">
		<div class="x_title">
			<h2>Form Edit Karyawan</h2>
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
			<form action="{{ route('karyawan.update', $data->id) }}" method="POST" enctype="multipart/form-data"
				class="form-label-left input_mask">
				@csrf
				@method('PUT')
				<div class="form-group row">
					<div class="col-md-6 col-sm-6 form-group has-feedback">
						<input value="{{ $data->nama }}" name="nama" type="text" class="form-control has-feedback-left"
							id="inputSuccess2" placeholder="Nama">
						<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
					</div>

					<div class="col-md-6 col-sm-6 form-group">
						<select required name="divisi" id="divisi" class="form-control" onchange="updateJabatanOptions()">
							<option value="" disabled>Pilih Divisi</option>
							<option value="Internal Audit" {{ $data->divisi == 'Internal Audit' ? 'selected' : '' }}>Internal Audit</option>
							<option value="Marketing" {{ $data->divisi == 'Marketing' ? 'selected' : '' }}>Marketing</option>
							<option value="Manajemen Resiko" {{ $data->divisi == 'Manajemen Resiko' ? 'selected' : '' }}>Manajemen Resiko
							</option>
							<option value="IT" {{ $data->divisi == 'IT' ? 'selected' : '' }}>IT</option>
							<option value="Pembiayaan" {{ $data->divisi == 'Pembiayaan' ? 'selected' : '' }}>Pembiayaan</option>
							<option value="Operasional" {{ $data->divisi == 'Operasional' ? 'selected' : '' }}>Operasional</option>
						</select>
						<span class="fa fa-building form-control-feedback right" aria-hidden="true"></span>
					</div>

					<div class="col-md-6 col-sm-6 form-group">
						<select required name="jabatan" id="jabatan" class="form-control has-feedback-left">
							<option value="" disabled>Pilih Jabatan</option>
						</select>
						<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
					</div>

					<div class="col-md-6 col-sm-6 form-group">
						<input required name="no_hp" type="text" class="form-control has-feedback-left" placeholder="Nomor telepon"
							value="{{ $data->no_hp }}">
						<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
					</div>

					<div class="col-md-6 col-sm-6 form-group">
						<select required name="agama" class="form-control">
							<option value="" disabled {{ $data->agama ? '' : 'selected' }}>Pilih Agama</option>
							<option value="Islam" {{ $data->agama == 'Islam' ? 'selected' : '' }}>Islam</option>
							<option value="Kristen" {{ $data->agama == 'Kristen' ? 'selected' : '' }}>Kristen</option>
							<option value="Katolik" {{ $data->agama == 'Katolik' ? 'selected' : '' }}>Katolik</option>
							<option value="Hindu" {{ $data->agama == 'Hindu' ? 'selected' : '' }}>Hindu</option>
							<option value="Buddha" {{ $data->agama == 'Buddha' ? 'selected' : '' }}>Buddha</option>
							<option value="Konghucu" {{ $data->agama == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
						</select>
					</div>

					<div class="col-md-6 col-sm-6 form-group">
						<select required name="jenis_kelamin" class="form-control">
							<option value="" disabled {{ $data->jenis_kelamin ? '' : 'selected' }}>Jenis Kelamin</option>
							<option value="Laki-laki" {{ $data->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
							<option value="Perempuan" {{ $data->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
						</select>
						<span class="fa fa-building form-control-feedback right" aria-hidden="true"></span>
					</div>

					<div class="col-md-6 col-sm-6 form-group">
						<input required name="username" type="text" class="form-control has-feedback-left" placeholder="Username"
							value="{{ $user->username }}">
						<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
					</div>
					<div class="col-md-6 col-sm-6 form-group">
						<input name="password" type="password" class="form-control has-feedback-left" placeholder="Password">
						<span class="fa fa-key form-control-feedback left" aria-hidden="true"></span>
					</div>
				</div>
				<div class="ln_solid"></div>
				<div class="form-group row">
					<div class="col-md-12 col-sm-12 offset-md-5">
						<button type="submit" class="btn btn-success">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection
@section('scripts')
	<script>
		const jabatanOptions = {
			"Operasional": ["Driver", "Akunting", "Asisten Adm.Pembiayaan", "Administrasi Pembiayaan", "Customer Service",
				"Teller", "Kabag Operasional"
			],
			"Pembiayaan": ["Asisten Account Officer", "Account Officer", "Analis Pembiayaan", "Kabag Pembiayaan"],
			"IT": ["Asisten IT", "Kabag IT"],
			"Manajemen Resiko": ["Staff Manajemen Resiko", "Kabag Manajemen Resiko"],
			"Internal Audit": ["Staff Internal Audit", "Kabag Internal Audit"],
			"Marketing": ["Staff Martkering", "Kabag Marketing"]
		};

		function updateJabatanOptions() {
			const divisiSelect = document.getElementById("divisi");
			const jabatanSelect = document.getElementById("jabatan");
			const selectedDivisi = divisiSelect.value;

			// Clear previous options
			jabatanSelect.innerHTML = '<option value="" disabled>Pilih Jabatan</option>';

			// Add new options based on selected divisi
			if (jabatanOptions[selectedDivisi]) {
				jabatanOptions[selectedDivisi].forEach(function(jabatan) {
					const option = document.createElement("option");
					option.value = jabatan;
					option.textContent = jabatan;
					if (jabatan === "{{ $data->jabatan }}") {
						option.selected = true;
					}
					jabatanSelect.appendChild(option);
				});
			}
		}

		// Call this function on page load to set the initial value
		document.addEventListener("DOMContentLoaded", function() {
			const divisiSelect = document.getElementById("divisi");
			if (divisiSelect.value) {
				updateJabatanOptions();
			}
		});

		function goBack() {
			window.history.back();
		}
	</script>
@endsection
