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
            <form action="{{ route('subkriteria.store') }}" method="POST" enctype="multipart/form-data"
                class="form-label-left input_mask">
                @csrf
                <div class="form-group row">
                    <div class="col-sm-4">
                        Nama Sub Kriteria
                        <div class="form-group">
                            <div class="input-group date" id="myDatepicker">
                                <input required placeholder="Nama Sub Kriteria" name="nama" type="text"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        Bobot Sub Kriteria
                        <div class="form-group">
                            <div class="input-group date">
                                <input required placeholder="Bobot Sub Kriteria" name="bobot" type="number"
                                    class="form-control" min="1" onkeypress="preventMinus(event)" max="100">
                            </div>
                        </div>
                    </div>



                    <div class="col-sm-4">
                        Kriteria:
                        <div class="form-group">
                            <select class="form-control" id="kriteria_id" name="kriteria_id" required>
                                <option value=""></option>
                                @foreach ($kriterias as $kriteria)
                                    <option value="{{ $kriteria->id }}">
                                        {{ $kriteria->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <h4>Penilaian</h4>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <input required placeholder="Rentang" name="rentang[]" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <select class="form-control skor" name="skor[]" required>
                                <option value=""></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <input required placeholder="Rentang" name="rentang[]" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <select class="form-control skor" name="skor[]" required>
                                <option value=""></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <input required placeholder="Rentang" name="rentang[]" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <select class="form-control skor" name="skor[]" required>
                                <option value=""></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
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
@endsection
@section('scripts')
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
