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
                            {{-- change info --}}
                            <div class="tab-content">
                                <div id="icon-info" class="tab-pane active">
                                    <div class="card">
                                        <div class="content">
                                            <form method="POST" action="{{ url('api/change-info') }}" id="AdminInfoForm">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Họ và Tên:</label>
                                                            <input type="text" class="form-control" name="name"
                                                                value="{{ $info->name }}">
                                                            <span class="text-danger error-text name_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Giới tính:</label>
                                                            <select name="gender" id="gender" class="form-control">
                                                                <option value="0" class="form-control"
                                                                    @if ($info->gender == 0) selected @endif>
                                                                    Nam</option>
                                                                <option value="1" class="form-control"
                                                                    @if ($info->gender == 1) selected @endif>Nữ
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Số điện thoại:</label>
                                                            <input type="text" class="form-control" name="phone"
                                                                @if ($info->phone == '') placeholder="(Chưa có dữ liệu)" @else
                                                                value="{{ $info->phone }}" @endif>
                                                            <span class="text-danger error-text phone_error"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Ngày sinh:</label>
                                                            <input type="date" class="form-control" name="date_of_birth"
                                                                value="{{ $info->date_of_birth }}">
                                                            <span class="text-danger error-text dob_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Địa chỉ:</label>
                                                            <input type="text" class="form-control" name="address"
                                                                @if ($info->address == '') placeholder="(Chưa có dữ liệu)" @else
                                                            value="{{ $info->address }}" @endif>
                                                            <span class="text-danger error-text address_error"></span>
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
                                {{-- change password --}}
                                <div id="icon-account" class="tab-pane">
                                    <div class="card">
                                        <div class="content">
                                            <form action="{{ url('api/change-password') }}" method="POST" id="change_pass">
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
                                <a>
                                    <img class="avatar border-gray" src="{{ asset('img/AngelRosé.jpg') }}"
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
        $('#AdminInfoForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(document).find('span.error-text').text('');
                },
                success: function(data) {
                    if (data.status == 0) {
                        $.each(data.error, function(prefix, val) {
                            $('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        $('.admin_name').each(function() {
                            $(this).html($('#AdminInfoForm').find($('input[name="name"]'))
                                .val());
                        });
                        onFinishWizard();
                    }
                }
            });
        });


        $(function() {
            $('#change_pass').on('submit', function(e) {
                e.preventDefault();
                // console.log(1);
                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    processData: false,
                    dataType: 'json',
                    data: new FormData(this),
                    contentType: false,
                    beforeSend: function(error) {
                        $(document).find('span.error-text').text('');
                    },
                    success: function(data) {
                        // console.log(data)
                        if (data.status == 0) {
                            $.each(data.error, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        } else {
                            $('#change_pass')[0].reset();
                            onFinishWizard();

                        }
                    }
                });
            });
        });

        // const base_api = location.origin;

        // function loadData() {
        //     $.ajax({
        //         type: "GET",
        //         url: base_api + '/updated-activity',
        //         dataType: 'json',
        //         success: function(rs) {
        //             if (rs.status == 1) {
        //                 alertSuccess();
        //                 window.setTimeout(function() {
        //                     $("#alerts").fadeTo(500, 0).slideUp(500, function() {
        //                         $(this).remove();
        //                     });
        //                 }, 3000);
        //             }
        //         },
        //         error: function() {

        //             console.log(url)
        //         }
        //     });
        // }

        // function alertSuccess(message) {
        //     $('#alerts').append(
        //         '<div class="alert alert-success">' +
        //         '<button type="button" aria-hidden="true" class="close">×</button>' +
        //         '<span> Liên kết thành công</span>' +
        //         '</div>'
        //     );
        // }

        function onFinishWizard() {
            swal("Hoàn tất!", "Cập nhật thành công", "success");
        }
    </script>
@endpush
