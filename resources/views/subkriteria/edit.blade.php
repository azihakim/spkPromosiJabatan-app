@extends('master')
{{-- @section('title', 'Penilaian') --}}
@section('content')
	<div class="col-sm-3"></div>
	<div class="col-sm-6">
		<div class="x_panel">
			<div class="x_title">
				<h2>Form Tambah Sub Kriteria</h2>
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
				<form action="{{ route('subkriteria.update', $subKriteria->id) }}" method="POST" enctype="multipart/form-data"
					class="form-label-left input_mask">
					@csrf
					@method('PUT')
					<div class="form-group row">
						<div class="col-sm-6">
							<label for="kriteria_id">Kriteria:</label>
							<div class="form-group">
								<select class="form-control" id="kriteria_id" name="kriteria_id" required>
									<option value="{{ $subKriteria->kriteria->id }}" selected>{{ $subKriteria->kriteria->nama }}</option>
									@foreach ($kriterias as $kriteria)
										<option value="{{ $kriteria->id }}" kode_kriteria="{{ $kriteria->kode }}">
											{{ $kriteria->nama }}
										</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>

					<h4>Keterangan</h4>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<input required placeholder="Rentang" name="rentang" type="text" class="form-control"
									value="{{ $subKriteria->rentang }}">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<select class="form-control skor" name="bobot" required>
									<option value="1" {{ $subKriteria->bobot == 1 ? 'selected' : '' }}>1</option>
									<option value="2" {{ $subKriteria->bobot == 2 ? 'selected' : '' }}>2</option>
									<option value="3" {{ $subKriteria->bobot == 3 ? 'selected' : '' }}>3</option>
								</select>
							</div>
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
	</div>
	<div class="col-sm-3"></div>
@endsection
@section('scripts')
	<script>
		document.getElementById('kriteria_id').addEventListener('change', function() {
			let selectedKriteria = this.options[this.selectedIndex];
			let kodeKriteria = selectedKriteria.getAttribute('kode_kriteria');

			// AJAX request to get the next available sub-kriteria code
			fetch(`/get-next-sub-kriteria/${kodeKriteria}`)
				.then(response => response.json())
				.then(data => {
					// Update the kode_sub_kriteria input field with the new value
					document.getElementById('kode_sub_kriteria').value = data.kode_sub_kriteria;
				})
				.catch(error => console.error('Error fetching sub-kriteria:', error));
		});
	</script>
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
	<script>
		document.querySelectorAll('.skor').forEach(function(select) {
			select.addEventListener('change', function() {
				validateScores();
			});
		});

		function validateScores() {
			const scores = [];
			let valid = true;
			document.querySelectorAll('.skor').forEach(function(select) {
				const value = select.value;
				if (value !== '') {
					if (scores.includes(value)) {
						valid = false;
					}
					scores.push(value);
				}
			});

			if (!valid) {
				alert('Nilai skor tidak boleh sama.');
				document.querySelectorAll('.skor').forEach(function(select) {
					if (scores.filter(v => v === select.value).length > 1) {
						select.value = '';
					}
				});
			}
		}

		document.getElementById('form-skors').addEventListener('submit', function(event) {
			const scores = [];
			let valid = true;
			document.querySelectorAll('.skor').forEach(function(select) {
				const value = select.value;
				if (value !== '') {
					if (scores.includes(value)) {
						valid = false;
					}
					scores.push(value);
				}
			});

			if (!valid || scores.length !== 3) {
				alert('Nilai skor harus unik dan hanya boleh 1, 2, atau 3.');
				event.preventDefault(); // Mencegah form submit jika validasi gagal
			}
		});
	</script>
@endsection
