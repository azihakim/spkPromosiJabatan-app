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
	<div class="x_panel">
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
	</div>
@endsection

@section('scripts')
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script>
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
	</script>
@endsection
