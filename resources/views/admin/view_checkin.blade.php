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
                    <legend>Quản lý đặt phòng -- Phòng chưa đặt trong 7 ngày kế tiếp</legend>
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
                    <div class="row">
                        <div class="col-md-3" id="search-type-room">

                        </div>
                        <div class="col-md-3" id="search-price-room">

                        </div>
                        <div class="col-sm-3">
                            <input type="text" name="datefilter" class="form-control input-sm" value=""
                                placeholder="Chọn ngày" />
                        </div>
                        <hr style="border: none">
                        <hr style="border: none">
                        <hr style="border: none">
                    </div>
                    <div class="row" id="rooms-content">
                        @foreach ($rooms as $data)
                            <div class="col-md-3" onclick="create({{ $data->id_room }})">
                                <div class="card card-user" style="background-color: gray">
                                    <div class="image">
                                        <img src="https://hotlinedatphong.com/wp-content/uploads/2020/10/khach-san-muong-thanh-holiday-mui-ne-24-800x450-1.jpg"
                                            alt="..." />
                                    </div>
                                    <h3 style="text-align: center; padding-bottom:10px"><b>{{ $data->name }}</b></h3>
                                    </h3>
                                </div>
                            </div>
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
    <script src="js/checkin.js"></script>
@endsection
@push('js')
    <script type="text/javascript">
        var search = function(start_date, end_date) {
            $.ajax({
                url: "api/admin/search-date-checkin",
                type: 'GET',
                dataType: 'json',
                data: {
                    start_date: start_date,
                    end_date: end_date,
                },
                success: function(res) {
                    console.log(res);
                    $("#rooms-content").html("");
                    res.rooms.forEach((item) => {
                        var htmlRoom = `
                <div class="col-md-3" onclick="create(${item.id_room})">
                    <div class="card card-user" style="background-color: gray">
                        <div class="image">
                            <img src="https://hotlinedatphong.com/wp-content/uploads/2020/10/khach-san-muong-thanh-holiday-mui-ne-24-800x450-1.jpg"
                                alt="..." />
                        </div>
                        <h3 style="text-align: center; padding-bottom:10px"><b>${item.name}</b></h3>
                    </div>
                </div>
                `;
                        $("#rooms-content").append(htmlRoom);

                    });
                },
            });
        }
        $('input[name="datefilter"]').daterangepicker({
            autoUpdateInput: false,
            // timePicker: true,
            minDate: moment(),
            // startDate: moment().startOf('hour'),
            // endDate: moment().startOf('hour').add(32, 'hour'),
            locale: {
                cancelLabel: 'Clear'
            },

            format: 'YYYY-MM-DD'
        });

        $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' -- ' + picker.endDate.format('YYYY-MM-DD'));
            check = true
            search(picker.startDate.format('YYYY-MM-DD'), picker.endDate.format('YYYY-MM-DD'));
        });

        $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    </script>
@endpush
