<div>
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
			<br>
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

			<div class="form-group row">
				<div class="col-sm-12">
					<button wire:click="hasilAkhir" type="submit" class="btn btn-success">Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
