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
                    <legend>Quản lý nhận phòng cần dọn dẹp & sửa chữa</legend>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="search-room"
                                placeholder="Nhập tên phòng bạn muốn tìm" oninput="searchRoom()">
                        </div>
                        <hr style="border: none">
                        <hr style="border: none">
                    </div>
                    <div class="row" id="rooms-content">
                        @foreach ($rooms as $data)
                            @if ($data->status == 2)
                                <div class="col-md-3" onclick="clean({{ $data->id_room }})">
                                    <div class="card card-user" style="background-color: rgb(177, 91, 15)">
                                        <div class="image">
                                            <img src="https://th.bing.com/th/id/OIP.OpuZaJhOd0JGZgVuAPtcWwHaD3?pid=ImgDet&rs=1"
                                                alt="..." />

                                        </div>
                                        <h3 style="text-align: center; padding-bottom:10px"><b>{{ $data->name }}</b>
                                        </h3>
                                    </div>
                                </div>
                            @elseif($data->status == 3)
                                <div class="col-md-3" onclick="fix({{ $data->id_room }})">
                                    <div class="card card-user" style="background-color: rgb(243, 14, 14)">
                                        <div class="image">
                                            <img src="{{ asset('img/bg9.jpg') }}" alt="..." />
                                        </div>
                                        <h3 style="text-align: center; padding-bottom:10px"><b>{{ $data->name }}</b>
                                        </h3>
                                    </div>
                                </div>
                            @endif
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
    <script src="js/rooms.js"></script>
@endsection
