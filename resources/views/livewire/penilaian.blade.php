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

				<div class="row">
					<div class="col-sm-4">
						<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>

						<select class="form-control has-feedback-left">
							<option disabled selected>Pilih Divisi</option>
							@foreach ($divisis as $item)
								<option value="{{ $item->jabatan }}">{{ $item->jabatan }}</option>
							@endforeach
						</select>
					</div>

					<div class="col-sm-2">
						<button wire:click="pilihKaryawan" class="btn btn-primary">Next</button>
					</div>
				</div>

				<div class="col-sm-12">
					<div class="ln_solid"></div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-md-3 col-sm-3 ">Default Input</label>
					<div class="col-md-9 col-sm-9 ">
						<input type="text" class="form-control" placeholder="Default Input">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-md-3 col-sm-3 ">Disabled Input </label>
					<div class="col-md-9 col-sm-9 ">
						<input type="text" class="form-control" disabled="disabled" placeholder="Disabled Input">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-md-3 col-sm-3 ">Read-Only Input</label>
					<div class="col-md-9 col-sm-9 ">
						<input type="text" class="form-control" readonly="readonly" placeholder="Read-Only Input">
					</div>
				</div>
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
										@if ($i != $j)
											@php
												$key = $kriteria[$i] . $kriteria[$j];
											@endphp
											<input type="number" wire:model="comparisons.{{ $key }}" class="form-control" />
										@else
											N/A
										@endif
									</td>
								@endforeach
							</tr>
						@endforeach
					</tbody>
				</table>
			@endif

			<div class="form-group row">
				<div class="col-sm-12">
					<button wire:click="hasilAkhir" type="submit" class="btn btn-success">Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
