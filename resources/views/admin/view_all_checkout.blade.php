@extends('layouts.dashboard.app')
@push('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
@endpush


@section('content')
    <div class="col-md-12">

        <div class="card">
            <div class="header">
                <legend>Thông tin thuê phòng</legend>
            </div>
            <div class="content">
                @include('admin.view_detail_checkin')
            </div>
        </div> <!-- end card -->

    </div> <!-- end col-md-12 -->

    <div class="col-md-6">

        <div class="card">
            <div class="header">
                <legend>Danh sách dịch vụ đã sử dụng</legend>
            </div>
            <div class="content">
                @include('admin.view_services')
            </div>
        </div> <!-- end card -->

    </div> <!-- end col-md-6 -->
    <div class="col-md-6">

        <div class="card">
            <div class="header">
                <legend>Danh sách phụ phí</legend>
            </div>
            <div class="content">
                @include('admin.view_additional_fee')
            </div>
        </div> <!-- end card -->

    </div> <!-- end col-md-6 -->
@endsection
@push('js')
    {{-- <script>
        window.setTimeout(function() {
            $("#alerts").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 3000);
    </script> --}}
@endpush
