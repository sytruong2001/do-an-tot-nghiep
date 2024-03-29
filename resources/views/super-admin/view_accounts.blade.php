@extends('layouts.dashboard.app')
@push('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
@endpush


@section('content')
    @if (session()->has('message'))
        <div class="alert alert-success" id="alerts">
            <button type="button" aria-hidden="true" class="close">×</button>
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="col-md-12">

        <div class="card">
            <div class="header">
                <legend>Danh sách nhân viên</legend>
            </div>
            <div class="content">
                <button type="button" class="btn btn-info btn-md" data-toggle="modal" onClick="add()">Thêm</button><br><br>
                <div class="fresh-datatables">
                    <table id="datatable_account" class="table table-striped table-no-bordered table-hover" cellspacing="0"
                        width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên</th>
                                <th>Ngày sinh</th>
                                <th>Giới tính</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Địa chỉ</th>
                                <th class="disabled-sorting text-right" style="text-align: center;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accounts_user as $data)
                                <tr>
                                    <td>
                                        <div style=' height: 100px; overflow: auto;'>
                                            {{ $index++ }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style=' height: 100px; overflow: auto;'>
                                            {{ $data->name }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style=' height: 100px; overflow: auto;'>
                                            @if ($data->date_of_birth == null)
                                                <i>(Chưa có thông tin)</i>
                                            @else
                                                {{ $data->date_of_birth }}
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div style=' height: 100px; overflow: auto;'>
                                            @if ($data->gender == 0)
                                                Nam
                                            @elseif($data->gender == 1)
                                                Nữ
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div style=' height: 100px; overflow: auto;'>
                                            {{ $data->email }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style=' height: 100px; overflow: auto;'>
                                            @if ($data->phone == null)
                                                <i>(Chưa có thông tin)</i>
                                            @else
                                                {{ $data->phone }}
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div style=' height: 100px; overflow: auto;'>
                                            @if ($data->address == null)
                                                <i>(Chưa có thông tin)</i>
                                            @else
                                                {{ $data->address }}
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-right" style="text-align: center;">
                                        <button class="btn btn-danger lock" onclick="lock({{ $data->user_id }})"
                                            style="height: 38px; width: 38px; padding: 0 8px 0 8px"><i
                                                class="fa fa-lock"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end card -->
        <div class="card">
            <div class="header">
                <legend>Danh sách nhân viên đang bị khóa</legend>
            </div>
            <div class="content">
                <div class="fresh-datatables">
                    <table id="datatable_account_locked" class="table table-striped table-no-bordered table-hover"
                        cellspacing="0" width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên</th>
                                <th>Ngày sinh</th>
                                <th>Giới tính</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Địa chỉ</th>
                                <th class="disabled-sorting text-right" style="text-align: center;">Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($accounts_user_loced as $data)
                                <tr>
                                    <td>
                                        <div style=' height: 100px; overflow: auto;'>
                                            {{ $index++ }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style=' height: 100px; overflow: auto;'>
                                            {{ $data->name }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style=' height: 100px; overflow: auto;'>
                                            @if ($data->date_of_birth == null)
                                                <i>(Chưa có thông tin)</i>
                                            @else
                                                {{ $data->date_of_birth }}
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div style=' height: 100px; overflow: auto;'>
                                            @if ($data->gender == 0)
                                                Nam
                                            @elseif($data->gender == 1)
                                                Nữ
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div style=' height: 100px; overflow: auto;'>
                                            {{ $data->email }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style=' height: 100px; overflow: auto;'>
                                            @if ($data->phone == null)
                                                <i>(Chưa có thông tin)</i>
                                            @else
                                                {{ $data->phone }}
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div style=' height: 100px; overflow: auto;'>
                                            @if ($data->address == null)
                                                <i>(Chưa có thông tin)</i>
                                            @else
                                                {{ $data->address }}
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-right" style="text-align: center;">
                                        <button class="btn btn-success lock" onclick="unlock({{ $data->user_id }})"
                                            style="height: 38px; width: 38px; padding: 0 8px 0 8px"><i
                                                class="fa fa-unlock"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="modal fade" id="insertForm" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form id="frm">
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
                                                    <input type="hidden" class="form-control" id="id"
                                                        name="id">
                                                    <label>Tên nhân viên:</label>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        required>
                                                    <span id="name_error" class="text-danger"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Địa chỉ email:</label>
                                                    <input type="email" class="form-control" id="email" name="email"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Mật khẩu:</label>
                                                    <input type="password" class="form-control" id="password"
                                                        name="password" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Ngày sinh:</label>
                                                    <input type="date" class="form-control" id="birth_of_date"
                                                        name="birth_of_date" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Giới tính:</label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input type="radio" id="gender1" name="gender"
                                                                value="0">Nam
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="radio" id="gender2" name="gender"
                                                                value="1">Nữ
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Số điện thoại:</label>
                                                    <input type="number" class="form-control" id="phone"
                                                        name="phone" required oninput="checkNumber()">
                                                    <span class="text-danger error-text phone"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Địa chỉ:</label>
                                                    <input type="text" class="form-control" id="address"
                                                        name="address" required>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" onclick="save()"
                                        id="button"></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end card -->

    </div> <!-- end col-md-12 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script language="javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
    <script src="js/accounts.js"></script>
@endsection
@push('js')
    <script>
        window.setTimeout(function() {
            $("#alerts").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 3000);
        $(document).ready(function() {
            $('#datatable_account').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "Tất cả"]
                ],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Tìm kiếm phòng",
                }

            });
        });
        $(document).ready(function() {
            $('#datatable_account_locked').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "Tất cả"]
                ],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Tìm kiếm phòng",
                }

            });
        });
    </script>
@endpush
