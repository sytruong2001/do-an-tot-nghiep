@extends('layouts.layoutCustomer')

@section('content')
    <div class="main main-raised">
        <div class="container">
            <div class="section">
                <div class="row">
                    <div class="col-md-12">
                        <form id="frm">
                            <div class="content content-full-width">
                                <ul class="nav nav-tabs">
                                    <li role="presentation" class="active">
                                        <a href="#icon-info" data-toggle="tab"><i class="fa fa-info"></i> Thông tin thuê
                                            phòng</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div id="icon-info" class="tab-pane active">
                                        <div class="card">
                                            <div class="content">
                                                <div class="row">
                                                    <div class="col-md-1">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Thời gian nhận phòng</label>
                                                            @foreach ($price as $item)
                                                                <input type="hidden" class="form-control" id="first"
                                                                    name="first" value="{{ $item->first_hour }}" readonly>
                                                                <input type="hidden" class="form-control" id="next"
                                                                    name="next" value="{{ $item->next_hour }}" readonly>
                                                            @endforeach
                                                            <input type="date" class="form-control" id="time_start"
                                                                name="time_start" value="{{ $start }}" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Thời gian trả phòng</label>
                                                            <input type="date" class="form-control" id="time_end"
                                                                name="time_end" value="{{ $end }}" disabled>
                                                            <span class="text-danger error-text time_end_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Tổng thời gian( giờ)</label>
                                                            <input type="number" class="form-control" id="total_time"
                                                                name="total_time" value="" disabled>
                                                            <span class="text-danger error-text time_total_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-1">
                                                    </div>
                                                    <div class="col-md-10">
                                                        @foreach ($rooms as $room)
                                                            <div class="form-group">
                                                                <label>Số phòng</label>
                                                                <input type="hidden" class="form-control" id="id-room"
                                                                    name="id-room" value="{{ $room->id_room }}" disabled>
                                                                <input type="text" class="form-control" id="name-room"
                                                                    name="name-room" value="{{ $room->name }}" disabled>
                                                            </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-1">
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label>Họ và Tên</label>
                                                            <input type="text" class="form-control" id="name-cus"
                                                                name="name-cus" value="">
                                                            <span class="text-danger error-text name_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label>Số CMT/CCCD</label>
                                                            <input type="number" class="form-control" id="identify"
                                                                name="identify" value="">
                                                            <span class="text-danger error-text identify_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Tổng tiền:</label>
                                                            <input type="text" class="form-control" id="total"
                                                                name="total" disabled>
                                                            <span class="text-danger error-text total_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Tiền đặt cọc(20% tổng tiền):</label>
                                                            <input type="hidden" class="form-control" id="deposit"
                                                                name="deposit" value="" disabled>
                                                            <input type="text" class="form-control" id="tien-coc"
                                                                name="tien-coc" value="" disabled>
                                                            <span class="text-danger error-text total_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button class="btn btn-success" id="payment">Thanh
                                                            toán qua MOMO</button>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script language="javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
    <script src="js/detail_booking.js"></script>
@endsection
