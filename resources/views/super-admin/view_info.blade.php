@extends('layouts.dashboard.app')
@push('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
@endpush


@section('content')
    <div id="alerts"></div>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Thông tin cá nhân</h4>
                        </div>
                        <div class="content content-full-width">
                            <ul role="tablist" class="nav nav-tabs">
                                <li role="presentation" class="active">
                                    <a href="#icon-info" data-toggle="tab"><i class="fa fa-info"></i> Info</a>
                                </li>
                                <li>
                                    <a href="#icon-account" data-toggle="tab"><i class="fa fa-user"></i> Account</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div id="icon-info" class="tab-pane active">
                                    <div class="card">
                                        <div class="content">
                                            <form method="POST" action="{{ url('api/admin/change-info') }}"
                                                id="AdminInfoForm">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Họ và Tên</label>
                                                            <input type="text" class="form-control" name="name"
                                                                value="{{ $info->name }}">
                                                            <span class="text-danger error-text name_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Số điện thoại</label>
                                                            <input type="text" class="form-control" name="phone"
                                                                value="{{ $info->phone }}">
                                                            <span class="text-danger error-text phone_error"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary" data-dismiss="modal">Sửa
                                                        thông tin</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div id="icon-account" class="tab-pane">
                                    <div class="card">
                                        <div class="content">
                                            <form action="" method="POST" id="change_pass">
                                                @csrf
                                                <input type="text" name="id" hidden value="{{ $info->id }}">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Mật khẩu cũ</label>
                                                            <input type="password" class="form-control" id="old_pass"
                                                                name="old_pass">
                                                            <span class="text-danger error-text old_pass_error"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Mật khẩu mới</label>
                                                            <input type="password" class="form-control" id="new_pass"
                                                                name="new_pass">
                                                            <span class="text-danger error-text new_pass_error"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Nhập lại mật khẩu mới</label>
                                                            <input type="password" class="form-control" id="re_new_pass"
                                                                name="re_new_pass">
                                                            <span class="text-danger error-text re_new_pass_error"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-user">
                        <div class="image">
                            <img src="{{ asset('img/full-screen-image-3.jpeg') }}" alt="..." />
                        </div>
                        <div class="content">
                            <div class="author">
                                <a href="#">
                                    <img class="avatar border-gray" src="{{ asset('img/default-avatar.png') }}"
                                        alt="..." />

                                    <h4 class="title">{{ $info->name }}<br />
                                        <small>{{ $info->email }}</small>
                                    </h4>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div> <!-- end col-md-12 -->
@endsection

@push('js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
@endpush
