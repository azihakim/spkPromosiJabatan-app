<div class="col-sm-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>Penilaian <small>Fuzzy AHP</small></h2>
			<ul class="nav navbar-right panel_toolbox">
				<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i
							class="fa fa-wrench"></i></a>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item" href="#">Settings 1</a>
						<a class="dropdown-item" href="#">Settings 2</a>
					</div>
				</li>
				<li><a class="close-link"><i class="fa fa-close"></i></a>
				</li>
			</ul>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			@if ($step == 1)
				@if (session('error'))
					<div class="alert alert-error">
						{{ session('error') }}
					</div>
				@endif
				<div class="row">
					<div class="col-sm-4">
						<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>

						<select wire:model="selectedDivisi" wire:change="pilihDivisi" class="form-control has-feedback-left">
							<option disabled selected value="Pilih Divisi">Pilih Divisi</option>
							@foreach ($divisis as $item)
								<option value="{{ $item->divisi }}" @if (in_array($item->divisi, $divisiTerpilih)) selected @endif>
									{{ $item->divisi }}
								</option>
							@endforeach
						</select>
					</div>
					<div class="col-sm-4">
						<div class="col-md-11 xdisplay_inputx form-group row has-feedback">
							<input type="date" class="form-control has-feedback-left" wire:model="tanggal">
							<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
						</div>
					</div>
				</div>

				@if ($nilaiKaryawan)
					<div class="form-horizontal form-label-left">
						<div class="ln_solid"></div>
						@foreach ($listKaryawan as $karyawan)
							<div class="form-group row">
								<label class="control-label col-md-1 col-sm-1 col-xs-1">{{ $karyawan->nama }}</label>
								@foreach ($kriteriaPenilaian as $k)
									<div class="col-md-2 col-sm-2 col-xs-2">
										<span class="form-control-feedback left" aria-hidden="true">{{ $k['kode'] }}</span>
										<select class="form-control has-feedback-left"
											wire:model="penilaianData.{{ $karyawan->id }}.{{ $k['kode'] }}">
											<option value="">{{ $k['nama'] }}</option>
											@foreach ($k['sub_kriterias'] as $subKriteria)
												<option value="{{ (int) $subKriteria['bobot'] }}"
													{{ isset($penilaianData[$karyawan->id][$k['kode']]) &&
													$penilaianData[$karyawan->id][$k['kode']] === (int) $subKriteria['bobot']
													    ? 'selected'
													    : '' }}>
													{{ $subKriteria['rentang'] }}
												</option>
											@endforeach
										</select>
										@if (isset($errors['penilaianData.' . $karyawan->id . '.' . $k['kode']]))
											<span class="text-danger">{{ $errors['penilaianData.' . $karyawan->id . '.' . $k['kode']] }}</span>
										@endif
									</div>
								@endforeach
							</div>
							<div class="ln_solid"></div>
						@endforeach
					</div>
				@endif
			@elseif ($step == 2)
				<table class="table">
					<thead style="text-align: center">
						<tr>
							<th>Kriteria</th>
							@foreach ($kriteria as $criterion)
								<th>{{ $criterion }}</th>
							@endforeach
						</tr>
					</thead>
					<tbody>
						@foreach ($kriteria as $i => $criterion)
							<tr>
								<td style="text-align: center">{{ $criterion }}</td>
								@foreach ($kriteria as $j => $otherCriterion)
									<td style="text-align: center">
										@php
											// Menentukan key berdasarkan kriteria
											$key = $kriteria[$i] . $kriteria[$j];
										@endphp

										@if ($i != $j)
											<!-- Input untuk membandingkan dua kriteria yang berbeda -->
											<input type="number" wire:model="comparisons.{{ $key }}" class="form-control" />
											@if (isset($errors["comparisons.$key"]))
												<span class="text-danger">{{ $errors["comparisons.$key"] }}</span>
											@endif
										@else
											<!-- Input untuk kriteria yang sama, nilai tetap 1 -->
											<input type="number" wire:model="comparisons.{{ $key }}" class="form-control" />
											@if (isset($errors["comparisons.$key"]))
												<span class="text-danger">{{ $errors["comparisons.$key"] }}</span>
											@endif
										@endif
									</td>
								@endforeach
							</tr>
						@endforeach

					</tbody>
				</table>
			@endif

			<div class="form-group row">
				@if ($nilaiKaryawan && $step == 1)
					<div class="actionBar">
						<button wire:click="step2" class="buttonNext btn btn-warning">Next</button>
					</div>
				@elseif ($step == 2)
					<div class="actionBar">
						<button wire:click="step1" class="buttonNext btn btn-danger">Kembali</button>
						<button wire:click="hasilAkhir" class="buttonNext btn btn-success">Simpan</button>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>
