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
            <form action="{{ route('karyawan.update', $data->id) }}" method="POST" enctype="multipart/form-data"
                class="form-label-left input_mask">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <div class="col-md-6 col-sm-6  form-group has-feedback">
                        <input value="{{ $data->nama }}" name="nama" type="text"
                            class="form-control has-feedback-left" id="inputSuccess2" placeholder="Nama">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                    </div>

                    <div class="col-md-6 col-sm-6  form-group has-feedback">
                        <input value="{{ $data->jabatan }}" name="jabatan" type="text" class="form-control"
                            id="inputSuccess3" placeholder="Jabatan">
                        <span class="fa fa-user form-control-feedback
                            right"
                            aria-hidden="true"></span>
                    </div>

                    <div class="col-md-6 col-sm-6  form-group">
                        <input required name="username" type="text" class="form-control has-feedback-left"
                            placeholder="Username" value="{{ $user->username }}">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-6 col-sm-6  form-group">
                        <input name="password" type="password" class="form-control has-feedback-left"
                            placeholder="Password">
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
        function goBack() {
            window.history.back();
        }
    </script>
@endsection
