<div>
    <div class="x_panel">
        <div class="x_title">
            <h2>Form Design <small>different form elements</small></h2>
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
            @foreach ($karyawans as $karyawan)
                <div class="form-group row">
                    <div class="col-md-6 col-sm-6 form-group has-feedback">
                        <input disabled wire:model="nama_karyawan.{{ $karyawan->id }}" type="text"
                            class="form-control has-feedback-left" placeholder="Nama">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                    </div>

                    <div class="col-md-6 col-sm-6 form-group has-feedback">
                        <input disabled wire:model="jabatan_karyawan.{{ $karyawan->id }}" type="text"
                            class="form-control" placeholder="Jabatan">
                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="form-group row">
                    @foreach ($subkriteria as $item)
                        <div class="col-md-2 col-sm-2 form-group">
                            <label for="fullname">{{ $item->nama }} :</label>
                            <select class="form-control"
                                wire:model="nilai.{{ $karyawan->id }}.{{ $item->id }}.{{ $item->nama }}"
                                type="number" id="fullname">
                                <option></option>
                                @foreach ($item->penilaian as $penilaian)
                                    <option value="{{ $penilaian['skor'] }}">{{ $penilaian['skor'] }} ||
                                        {{ $penilaian['rentang'] }}</option>
                                @endforeach
                            </select>
                            {{-- <label for="fullname">{{ $item->nama }} :</label>
                            <input wire:model="nilai.{{ $karyawan->id }}.{{ $item->id }}.{{ $item->nama }}"
                                type="number" id="fullname" class="form-control" required=""> --}}
                        </div>
                        @error('nilai.' . $karyawan->id . '.' . $item->id . '.' . $item->nama)
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    @endforeach
                </div>
                <div class="ln_solid"></div>
            @endforeach

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="form-group row">
                <div class="col-sm-12">
                    <button wire:click="hasilAkhir" type="submit" class="btn btn-success">Simpan</button>
                </div>
            </div>

        </div>
    </div>
</div>
