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
                        <div class="col-md-6">
                            <input type="text" class="form-control" value=""
                                placeholder="Nhập tên phòng bạn muốn tìm">
                        </div>
                        <div class="col-md-6">
                            <select name="idClass" class="form-control" onclick="alert('ahihi')">
                                <option style="text-align: center" value="">Phòng hôm nay cần trả</option>
                            </select>
                        </div>
                        <hr style="border: none">
                        <hr style="border: none">
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
@endsection
