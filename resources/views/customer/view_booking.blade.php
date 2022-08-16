@extends('layouts.layoutCustomer')

@section('content')
    <div class="main main-raised">
        <div class="container">
            <div class="section">
                @if (isset($detail_checkin))
                    <div class="row">
                        <div class="col-md-12" style="text-align: center; color:aquamarine">
                            <h2>Thông tin thuê phòng thành công!</h2>
                        </div>

                    </div>
                    <br>
                    @foreach ($detail_customer as $customer)
                        <div class="row">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-2">
                                Tên khách hàng
                            </div>
                            <div class="col-md-3">
                                <b>: {{ $customer->name }}</b>
                            </div>
                            <div class="col-md-2">
                                Số CMT/CCCD
                            </div>
                            <div class="col-md-3">
                                <b>: 00{{ $customer->identify_numb }}</b>
                            </div>
                        </div>
                    @endforeach
                    <br>
                    @foreach ($detail_checkin as $checkin)
                        <div class="row">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-2">
                                Ngày nhận
                            </div>
                            <div class="col-md-3">
                                <b>: {{ $checkin->time_start }}</b>
                            </div>
                            <div class="col-md-2">
                                Ngày trả
                            </div>
                            <div class="col-md-3">
                                <b>: {{ $checkin->time_end }}</b>
                            </div>
                        </div>
                    @endforeach
                    <br>
                    <div class="row">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-10">
                            Cám ơn quý khách hàng đã lựa chọn sử dụng dịch vụ của Khách sạn SN
                            <i>
                                <a href="http://127.0.0.1:8000/" style="text-decoration: none">Về trang chủ</a>
                            </i>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-4" style="font-size:30px" id="check-in">

                        </div>
                        <div class="col-md-4" style="font-size:30px" id="check-out">

                        </div>
                        <div class="col-md-2">
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-4" style="background: orangered; height: 60px; border-radius: 5px;">
                            <div class="input-group" onclick="searchRoomNow()">
                                <span class="input-group-addon">
                                    <h4>
                                        <b>
                                            <i class="fa fa-search"></i> Tìm kiếm phòng
                                        </b>
                                    </h4>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                        </div>
                    </div>
                    <hr>
                    <div class="row" id="room-content">
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script language="javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
    <script src="js/customer.js"></script>
@endsection
