@extends('layouts.dashboard.app')
@push('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
@endpush


@section('content')
    <div id="alerts">
    </div>
    <div class="col-md-12">

        <div class="card">
            <div class="header">
                <legend>Danh sách phòng</legend>
            </div>
            <div class="content">
                <button type="button" class="btn btn-info btn-md" data-toggle="modal" onClick="add()">Thêm</button><br><br>
                <div class="fresh-datatables">
                    <table id="datatable_room" class="table table-striped table-no-bordered table-hover" cellspacing="0"
                        width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Số phòng</th>
                                <th>Loại phòng</th>
                                <th>Số lượng người lớn</th>
                                <th>Số lượng trẻ nhỏ</th>
                                <th>Trạng thái phòng</th>
                                <th class="disabled-sorting text-right" style="text-align: center;">Thao tác</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Số phòng</th>
                                <th>Loại phòng</th>
                                <th>Số lượng người lớn</th>
                                <th>Số lượng trẻ nhỏ</th>
                                <th>Trạng thái phòng</th>
                                <th class="text-right" style="text-align: center;">Thao tác</th>
                            </tr>
                        </tfoot>
                        <tbody>

                            @foreach ($room as $data)
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
                                            {{ $data->type_room->name }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style=' height: 100px; overflow: auto;'>
                                            {{ $data->adults }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style=' height: 100px; overflow: auto;'>
                                            {{ $data->children }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style=' height: 100px; overflow: auto;'>
                                            @if ($data->status == 5)
                                                <span style="color:red">Đang khóa</span>
                                            @else
                                                <span style="color:blue">Đang hoạt động</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-right" style="text-align: center;">
                                        <button type="button" class="btn btn-info btn-warning btn-icon edit"
                                            data-toggle="modal" onclick="edit({{ $data->id_room }})"><i
                                                class="fa fa-file-text-o"></i></button>
                                        @if ($data->status == 5)
                                            <button class="btn btn-success lock" onclick="unlock({{ $data->id_room }})"
                                                style="height: 38px; width: 38px; padding: 0 8px 0 8px"><i
                                                    class="fa fa-unlock"></i></button>
                                        @else
                                            <button class="btn btn-danger lock" onclick="lock({{ $data->id_room }})"
                                                style="height: 38px; width: 38px; padding: 0 8px 0 8px"><i
                                                    class="fa fa-lock"></i></button>
                                        @endif
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
                                                    <input type="hidden" class="form-control" id="id_room"
                                                        name="id_room">
                                                    <label>Số phòng:</label>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        required>
                                                    <span id="room_error" class="text-danger"></span>
                                                    <label>Chọn loại phòng:</label>
                                                    <select class="form-control" id="type_room"
                                                        name="type_room"></select><br>
                                                    <span id="type_room_error" class="text-danger"></span>
                                                    <label>Số lượng người lớn:</label>
                                                    <input type="number" class="form-control" id="adults" name="adults"
                                                        placeholder="Nhập giá trị..." pattern="[0-9]*" required
                                                        oninput="checkNumber()">
                                                    <span class="text-danger error-text adults"></span><br>
                                                    <label>Số lượng trẻ nhỏ:</label>
                                                    <input type="number" class="form-control" id="children"
                                                        name="children" placeholder="Nhập giá trị..." pattern="[0-9]*"
                                                        required required oninput="checkNumber()">
                                                    <span class="text-danger error-text children"></span><br>
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
    <script src="js/rooms.js"></script>
@endsection
@push('js')
    <script>
        window.setTimeout(function() {
            $("#alerts").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 3000);
        $(document).ready(function() {
            $('#datatable_room').DataTable({
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
