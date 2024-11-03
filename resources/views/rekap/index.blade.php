@extends('master')

@section('styles')
	<style>
		/* Style for loading overlay */
		.loading-overlay {
			display: none;
			/* Hidden by default */
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(255, 255, 255, 0.8);
			z-index: 9999;
			align-items: center;
			justify-content: center;
			font-size: 1.5em;
			color: #333;
		}
	</style>
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
	<div class="x_panel">
		<div class="x_title">
			<h2>Rekap Penilaian</h2>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<br>
			<form action="{{ route('rekap.penilaian') }}" method="POST" class="form-label-left input_mask" id="rekapForm">
				@csrf
				<div class="row">
					<div class="col-sm-4 form-group has-feedback">
						<label>Tanggal Dari :</label>
						<input id="tglDari" name="tgl_dari" class="date-picker form-control" placeholder="dd-mm-yyyy" type="date"
							required="required">
					</div>
					<div class="col-sm-4 form-group has-feedback">
						<label>Tanggal Sampai :</label>
						<input id="tglSampai" name="tgl_sampai" class="date-picker form-control" placeholder="dd-mm-yyyy" type="date"
							required="required">
					</div>
				</div>


				<div class="ln_solid"></div>
				<div class="form-group row">
					<div class="col-sm-12 offset-sm-5">
						<button type="submit" class="btn btn-success">Rekap</button>
					</div>
				</div>

			</form>
		</div>
	</div>
	<!-- Loading Overlay -->
	<div class="loading-overlay" id="loadingOverlay">
		<div>Sedang melakukan rekap, tunggu...</div>
	</div>

	{{-- <div class="x_panel">
		<div class="x_title">
			<h2>Rekap Penilaian</h2>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<br>
			<form action="{{ route('rekap.rekap') }}" method="POST" class="form-label-left input_mask" id="rekapForm">
				@csrf
				<div class="row">
					<div class="col-sm-3 form-group has-feedback">
						<select class="form-control has-feedback-left" id="tglPenilaian" required name="tglPenilaian">
							<option value="">Pilih Tanggal Penilaian</option>
							@foreach ($tgl_penilaian as $item)
								<option value="{{ $item }}">{{ $item }}</option>
							@endforeach
						</select>
						<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
					</div>
					<div class="col-sm-9">
						<label>Pilih Divisi :</label>
						<div id="checkboxDivisi" class="row">
							<!-- Checkbox divisi akan diisi melalui AJAX -->
						</div>
					</div>
				</div>


				<div class="ln_solid"></div>
				<div class="form-group row">
					<div class="col-sm-12 offset-sm-5">
						<button type="submit" class="btn btn-success">Rekap</button>
					</div>
				</div>

			</form>

		</div>
	</div> --}}
@endsection

@section('scripts')
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<script>
		document.addEventListener("DOMContentLoaded", function() {
			const tglDariInput = document.getElementById("tglDari");
			const tglSampaiInput = document.getElementById("tglSampai");

			tglDariInput.addEventListener("change", function() {
				const tglDari = tglDariInput.value;
				tglSampaiInput.min = tglDari; // Set minimum date for 'Tanggal Sampai' based on 'Tanggal Dari'
				if (tglSampaiInput.value < tglDari) {
					tglSampaiInput.value = tglDari;
				}
			});

			tglSampaiInput.addEventListener("change", function() {
				const tglSampai = tglSampaiInput.value;
				tglDariInput.max = tglSampai; // Set maximum date for 'Tanggal Dari' based on 'Tanggal Sampai'
				if (tglDariInput.value > tglSampai) {
					tglDariInput.value = tglSampai;
				}
			});
		});
	</script>

	<script>
		document.addEventListener("DOMContentLoaded", function() {
			const rekapForm = document.getElementById("rekapForm");
			const loadingOverlay = document.getElementById("loadingOverlay");

			rekapForm.addEventListener("submit", function() {
				// Show loading overlay when form is submitted
				loadingOverlay.style.display = "flex";

				// Hide the loading overlay after 0.5 seconds
				setTimeout(function() {
					loadingOverlay.style.display = "none";
				}, 500); // 500 milliseconds = 0.5 seconds
			});

			// Optional: Hide overlay when PDF download is initiated
			window.addEventListener("focus", function() {
				loadingOverlay.style.display = "none";
			});
		});
	</script>
	{{-- <script>
		$(document).ready(function() {
			$('#tglPenilaian').change(function() {
				const selectedDate = $(this).val();

				// Clear previous checkboxes
				$('#checkboxDivisi').empty();

				if (selectedDate) {
					$.ajax({
						url: "{{ route('divisi.by.date') }}",
						method: "GET",
						data: {
							tgl_penilaian: selectedDate
						},
						success: function(response) {
							if (response.length > 0) {
								response.forEach(function(divisi) {
									const checkbox = `
                                <div class="checkbox col-sm-2">
                                    <label>
                                        <input type="checkbox" name="divisi[]" value="${divisi}"> ${divisi}
                                    </label>
                                </div>
                            `;
									$('#checkboxDivisi').append(checkbox);
								});
							} else {
								$('#checkboxDivisi').append(
									'<p>Tidak ada divisi untuk tanggal ini.</p>');
							}
						},
						error: function(xhr) {
							console.error(xhr);
							alert('Terjadi kesalahan saat mengambil data.');
						}
					});
				}
			});
		});
	</script> --}}
@endsection
