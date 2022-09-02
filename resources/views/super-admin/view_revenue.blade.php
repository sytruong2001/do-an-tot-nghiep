@extends('layouts.dashboard.app')
@push('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
@endpush

@section('content')
    <div class="col-md-4">
        <div class="card">
            <div class="content">
                <h2>Loại phòng: {{ $type }}</h2>
            </div>
        </div> <!-- end card -->

    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="content">
                <h2>Phòng: {{ $room }}</h2>
            </div>
        </div> <!-- end card -->

    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="content">
                <h2>Nhân viên: {{ $user }}</h2>
            </div>
        </div> <!-- end card -->

    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <div class="col col-sm-9">
                    <legend>Doanh thu</legend>
                </div>
                <div class="col col-sm-3">
                    <input type="text" name="datefilter" class="form-control input-sm" value=""
                        placeholder="Chọn ngày" />
                </div>
            </div>
            <div class="content">
                <canvas id="myChart" height="100px"></canvas>
            </div>
        </div> <!-- end card -->

    </div> <!-- end col-md-12 -->
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
        });

        var labels = {{ Js::from($labels) }};
        var rev = {{ Js::from($data) }};
        const data = {
            labels: labels,
            datasets: [{
                label: 'Doanh thu',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: rev,
                tension: 0.2
            }]
        };
        const config = {
            type: 'bar',
            data: data,
            options: {}
        };

        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
        // load_detail_data(users);

        var check = false;

        var search = function(start_date, end_date) {
            $.ajax({
                url: "/superadmin/search-rev",
                type: 'GET',
                dataType: 'json',
                data: {
                    start_date: start_date,
                    end_date: end_date,
                },
                success: function(res) {
                    console.log(res.labels);
                    // load_detail_data(res.result.users);
                    myChart.data.labels = res.labels;
                    myChart.data.datasets[0].data = res.data;
                    myChart.update();
                },
            });
        }

        $('input[name="datefilter"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            },
            ranges: {
                'Hôm nay': [moment(), moment()],
                '7 ngày vừa qua': [moment().subtract(6, 'days'), moment()],
                '30 ngày vừa qua': [moment().subtract(29, 'days'), moment()],
                'Tháng này': [moment().startOf('month'), moment().endOf('month')],
                'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                    'month')],
                'Quý này': [moment().startOf('quarter'), moment().endOf('quarter')],
                'Quý trước': [moment().subtract(1, 'quarter').startOf('quarter'), moment().subtract(1, 'quarter')
                    .endOf('quarter')
                ],
                'Năm nay': [moment().startOf('year'), moment().endOf('year')],
                'Năm trước': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf(
                    'year')]
            },
            format: 'YYYY-MM-DD'
        });

        $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            check = true
            search(picker.startDate.format('YYYY-MM-DD'), picker.endDate.format('YYYY-MM-DD'));
        });

        $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    </script>
@endpush
