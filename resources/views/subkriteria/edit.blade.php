@extends('master')
{{-- @section('title', 'Penilaian') --}}
@section('content')
    <div class="x_panel">
        <div class="x_title">
            <h2>Form Tambah Kriteria</h2>
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
                    <div class="col-sm-4">
                        Nama Sub Kriteria
                        <div class="form-group">
                            <div class="input-group date" id="myDatepicker">
                                <input placeholder="Nama Sub Kriteria" value="{{ $subKriteria->nama }}" name="nama"
                                    type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        Bobot Sub Kriteria
                        <div class="form-group">
                            <div class="input-group date" id="myDatepicker">
                                <input placeholder="Bobot Sub Kriteria" value="{{ $subKriteria->bobot }}" name="bobot"
                                    type="text" class="form-control">
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-4">
                        Kriteria:
                        <div class="form-group">
                            <select class="form-control" id="kriteria_id" name="kriteria_id" required>
                                @foreach ($kriterias as $kriteria)
                                    <option value="{{ $kriteria->id }}"
                                        {{ $subKriteria->kriteria_id == $kriteria->id ? 'selected' : '' }}>
                                        {{ $kriteria->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <h4>Penilaian</h4>
                @foreach (json_decode($subKriteria->penilaian, true) as $penilaian)
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <input placeholder="Rentang" value="{{ $penilaian['rentang'] }}" name="rentang[]"
                                    type="text" class="form-control">

                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <input placeholder="Bobot Sub Kriteria" value="{{ $penilaian['skor'] }}" name="skor[]"
                                    type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                @endforeach
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
        function goBack() {
            window.history.back();
        }
    </script>
@endsection
