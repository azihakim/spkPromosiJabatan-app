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
			<form action="{{ route('karyawan.store') }}" method="POST" enctype="multipart/form-data"
				class="form-label-left input_mask">
				@csrf
				<div class="form-group row">
					<div class="col-md-6 col-sm-6  form-group">
						<input required name="nama" type="text" class="form-control has-feedback-left" placeholder="Nama">
						<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
					</div>

					<div class="col-md-6 col-sm-6 form-group">
						<select required name="divisi" id="divisi" class="form-control" onchange="updateJabatanOptions()">
							<option value="" disabled selected>Pilih Divisi</option>
							<option value="Operasional">Operasional</option>
							<option value="Pembiayaan">Pembiayaan</option>
							<option value="TI">TI</option>
							<option value="Manajemen Risiko">Manajemen Risiko</option>
							<option value="Internal Audit">Internal Audit</option>
							<option value="Unit Khusus">Unit Khusus</option>
						</select>
						<span class="fa fa-building form-control-feedback right" aria-hidden="true"></span>
					</div>

					<div class="col-md-6 col-sm-6 form-group">
						<select required name="jabatan" id="jabatan" class="form-control has-feedback-left">
							<option value="" disabled selected>Pilih Jabatan</option>
						</select>
						<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
					</div>

					<div class="col-md-6 col-sm-6  form-group">
						<input required name="no_hp" type="text" class="form-control has-feedback-left" placeholder="Nomor telepon">
						<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
					</div>

					<div class="col-md-6 col-sm-6 form-group">
						<select required name="agama" class="form-control">
							<option value="" disabled selected>Pilih Agama</option>
							<option value="Islam">Islam</option>
							<option value="Kristen">Kristen</option>
							<option value="Katolik">Katolik</option>
							<option value="Hindu">Hindu</option>
							<option value="Buddha">Buddha</option>
							<option value="Konghucu">Konghucu</option>
						</select>
						<span class="fa fa-building form-control-feedback right" aria-hidden="true"></span>
					</div>

					<div class="col-md-6 col-sm-6 form-group">
						<select required name="jenis_kelamin" class="form-control">
							<option value="" disabled selected>Jenis Kelamin</option>
							<option value="Laki-laki">Laki-laki</option>
							<option value="Perempuan">Perempuan</option>
						</select>
						<span class="fa fa-building form-control-feedback right" aria-hidden="true"></span>
					</div>

					<div class="col-md-6 col-sm-6  form-group">
						<input required name="username" type="text" class="form-control has-feedback-left" placeholder="Username">
						<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
						@error('username')
							<div class="text-danger">{{ $message }}</div>
						@enderror
					</div>
					<div class="col-md-6 col-sm-6  form-group">
						<input required name="password" type="password" class="form-control has-feedback-left" placeholder="Password">
						<span class="fa fa-key form-control-feedback left" aria-hidden="true"></span>
					</div>
				</div>
				<div class="ln_solid"></div>
				<div class="form-group row">
					<div class="col-md-12 col-sm-12  offset-md-5">
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
			"TI": ["Asisten TI", "Kabag TI"],
			"Manajemen Risiko": ["Staff Manajemen Risiko", "Kabag Manajemen Risiko"],
			"Internal Audit": ["Staff Internal Audit", "Kabag Internal Audit"],
			"Unit Khusus": ["Staff Unit Khusus", "Kabag Unit Khusus"]
		};

		function updateJabatanOptions() {
			const divisiSelect = document.getElementById("divisi");
			const jabatanSelect = document.getElementById("jabatan");
			const selectedDivisi = divisiSelect.value;

			// Clear previous options
			jabatanSelect.innerHTML = '<option value="" disabled selected>Pilih Jabatan</option>';

			// Add new options based on selected divisi
			if (jabatanOptions[selectedDivisi]) {
				jabatanOptions[selectedDivisi].forEach(function(jabatan) {
					const option = document.createElement("option");
					option.value = jabatan;
					option.textContent = jabatan;
					jabatanSelect.appendChild(option);
				});
			}
		}
	</script>
	<script>
		function goBack() {
			window.history.back();
		}
	</script>
@endsection
