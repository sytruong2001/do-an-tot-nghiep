@extends('layouts.dashboard.app')
@push('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
@endpush


@section('content')
    <div id="alerts"></div>
    <div class="main-content">
        <div class="container-fluid">

            <div class="card">
                <div class="header">
                    <legend>Quản lý trả phòng</legend>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <select name="idClass" class="form-control">
                                <option style="text-align: center" value="">--------------------</option>
                                <option style="text-align: center" value="">--------------------</option>
                                <option style="text-align: center" value="">--------------------</option>
                                <option style="text-align: center" value="">--------------------</option>
                                <option style="text-align: center" value="">--------------------</option>
                            </select>
                        </div>
                        <hr>
                    </div>
                    <div class="row">
                        @foreach ($rooms as $data)
                            {{-- <div class="col-md-2" onclick="create({{ $data->id_checkin_room }})"> --}}
                            <a href="/admin/detail-checkout/{{ $data->id_checkin_room }}">
                                <div class="col-md-2">
                                    <div class="card card-user" style="background-color: lightgreen">
                                        <div class="image">
                                            <img src="{{ asset('img/bg9.jpg') }}" alt="..." />
                                        </div>
                                        <h3 style="text-align: center; padding-bottom:10px"><b>{{ $data->name }}</b></h3>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="insertForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLongTitle"></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script language="javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
    <script src="js/checkout.js"></script>
@endsection
