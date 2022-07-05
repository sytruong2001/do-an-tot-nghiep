{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}
@extends('layouts.dashboard.app')
@push('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
@endpush


@section('content')
    <div class="col-md-12">

        <div class="card">
            <div class="header">
                <legend>Danh sách tài khoản bị khóa</legend>
            </div>
            <div class="content">
                <div class="fresh-datatables">
                    <table id="datatable_user" class="table table-striped table-no-bordered table-hover" cellspacing="0"
                        width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Lý do bị khóa</th>
                                <th>Người khóa</th>
                                <th class="disabled-sorting text-right" style="text-align: center;">Thao tác</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Lý do bị khóa</th>
                                <th>Người khóa</th>
                                <th class="text-right" style="text-align: center;">Thao tác</th>
                            </tr>
                        </tfoot>
                        <tbody>

                        </tbody>
                    </table>
                </div>

                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Thông tin chi tiết</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="content">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="text" class="form-control" disabled id="email_info"
                                                        value="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Họ và Tên</label>
                                                    <input type="text" class="form-control" disabled id="name_info"
                                                        value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Ngày sinh</label>
                                                    <input type="text" class="form-control" disabled id="date_info"
                                                        value="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Quốc gia</label>
                                                    <input type="text" class="form-control" disabled id="region_info"
                                                        value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Số điện thoại</label>
                                                    <input type="text" class="form-control" disabled id="phone_info"
                                                        value="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Số chứng minh thư</label>
                                                    <input type="text" class="form-control" disabled id="idn_info"
                                                        value="">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>UID</label>
                                                    <input type="text" class="form-control" disabled id="uid_info"
                                                        value="">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Số coin</label>
                                                    <input type="text" class="form-control" disabled id="coin_info"
                                                        value="">
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end card -->

    </div> <!-- end col-md-12 -->
    <div class="col-md-12">

        <div class="card">
            <div class="header">
                <legend>Danh sách tài khoản gửi yêu cầu mở khóa</legend>
            </div>
            <div class="content">
                <div class="fresh-datatables">
                    <table id="datatable_user_req" class="table table-striped table-no-bordered table-hover" cellspacing="0"
                        width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Số CMT/CCCD</th>
                                <th>Lần nạp 1</th>
                                <th>Số tiền(VND)</th>
                                <th>Lần nạp 2</th>
                                <th>Số tiền(VND)</th>
                                <th>Lần nạp 3</th>
                                <th>Số tiền(VND)</th>
                                <th class="disabled-sorting text-right" style="text-align: center;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Thông tin chi tiết</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="content">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="text" class="form-control" disabled id="email1_info"
                                                        value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Số CMT/CCCD</label>
                                                    <input type="text" class="form-control" disabled id="identify_info"
                                                        value="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>#3 lần nạp gần nhất</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Lần thứ 1</label>
                                                    <input type="text" class="form-control" disabled id="date_1_info"
                                                        value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Số tiền lần 1</label>
                                                    <input type="text" class="form-control" disabled id="money_1_info"
                                                        value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Lần thứ 2</label>
                                                    <input type="text" class="form-control" disabled id="date_2_info"
                                                        value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Số tiền lần 2</label>
                                                    <input type="text" class="form-control" disabled id="money_2_info"
                                                        value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Lần thứ 3</label>
                                                    <input type="text" class="form-control" disabled id="date_3_info"
                                                        value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Số tiền lần 3</label>
                                                    <input type="text" class="form-control" disabled id="money_3_info"
                                                        value="">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end card -->

    </div> <!-- end col-md-12 -->
@endsection


@push('js')
@endpush
