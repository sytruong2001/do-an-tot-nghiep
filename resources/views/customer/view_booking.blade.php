@extends('layouts.layoutCustomer')

@section('content')
    <div class="main main-raised">
        <div class="container">
            <div class="section">
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
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script language="javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
    <script src="js/customer.js"></script>
@endsection
