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
                <legend>Lịch sử thuê phòng</legend>
            </div>
            <div class="content">
                <div class="fresh-datatables">
                    <table id="datatable_checkout" class="table table-striped table-no-bordered table-hover" cellspacing="0"
                        width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên khách hàng</th>
                                <th>Số phòng</th>
                                <th>Thời gian thuê</th>
                                <th>Thời gian trả</th>
                                <th>Tổng tiền</th>
                                <th class="disabled-sorting text-right" style="text-align: center;">Thao tác</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Tên khách hàng</th>
                                <th>Số phòng</th>
                                <th>Thời gian thuê</th>
                                <th>Thời gian trả</th>
                                <th>Tổng tiền</th>
                                <th class="text-right" style="text-align: center;">Thao tác</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($checkout as $data)
                                <tr>
                                    <td>
                                        <div style=' height: 100px; overflow: auto;'>
                                            {{ $index++ }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style=' height: 100px; overflow: auto;'>
                                            aaa
                                        </div>
                                    </td>
                                    <td>
                                        <div style=' height: 100px; overflow: auto;'>
                                            222
                                        </div>
                                    </td>
                                    <td>
                                        <div style=' height: 100px; overflow: auto;'>
                                            {{ $data->time_start }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style=' height: 100px; overflow: auto;'>
                                            {{ $data->time_end }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style='width: 200px; height: 100px; overflow: auto;'>
                                            {{ number_format($data->sum_price, 0, ',', '.') }} đ
                                        </div>
                                    </td>
                                    <td class="text-right" style="text-align: center;">
                                        <button type="button" class="btn btn-info btn-success btn-icon edit"
                                            data-toggle="modal" onclick=""><i class="fa fa-print"></i></button>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
            $('#datatable_checkout').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "Tất cả"]
                ],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Tìm kiếm",
                }

            });
        });
    </script>
@endpush
