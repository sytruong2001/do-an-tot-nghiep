<style>
    * {
        box-sizing: border-box;
    }


    body {
        font-family: DejaVu Sans;
        border: 5px solid rgb(6, 103, 132);
        border-radius: 5px;
        color: rgb(6, 103, 132);
    }

    .title {
        text-align: center;
        text-transform: uppercase;
    }

    .title span {
        font-size: 15px;
    }

    hr {
        color: rgb(6, 103, 132);
    }

    .row::after {
        content: "";
        clear: both;
        display: table;
    }

    [class*="col-"] {
        float: left;
        padding-left: 15px;
        padding-bottom: 5px;
    }

    @media only screen and (min-width: 600px) {

        /* For tablets: */
        .col-s-1 {
            width: 8.33%;
        }

        .col-s-2 {
            width: 16.66%;
        }

        .col-s-3 {
            width: 25%;
        }

        .col-s-4 {
            width: 33.33%;
        }

        .col-s-5 {
            width: 41.66%;
        }

        .col-s-6 {
            width: 50%;
        }

        .col-s-7 {
            width: 58.33%;
        }

        .col-s-8 {
            width: 66.66%;
        }

        .col-s-9 {
            width: 75%;
        }

        .col-s-10 {
            width: 83.33%;
        }

        .col-s-11 {
            width: 91.66%;
        }

        .col-s-12 {
            width: 100%;
        }
    }

    @media only screen and (min-width: 768px) {

        /* For desktop: */
        .col-1 {
            width: 8.33%;
        }

        .col-2 {
            width: 16.66%;
        }

        .col-3 {
            width: 25%;
        }

        .col-4 {
            width: 33.33%;
        }

        .col-5 {
            width: 41.66%;
        }

        .col-6 {
            width: 50%;
        }

        .col-7 {
            width: 58.33%;
        }

        .col-8 {
            width: 66.66%;
        }

        .col-9 {
            width: 75%;
        }

        .col-10 {
            width: 83.33%;
        }

        .col-11 {
            width: 91.66%;
        }

        .col-12 {
            width: 100%;
        }
    }

    table {
        border: 2px solid lightblue;
        padding: 0px;

    }

    table td,
    table th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    table thead {
        background: lightblue;
    }
</style>
<div class="wrapper">
    <!-- Menu -->
    <div class="main-panel">
        <!-- Header -->
        <div class="main-content">
            <div class="container-fluid">
                <div class="title">
                    <h3>Hóa đơn thanh toán phí dịch vụ khách sạn</h3>
                    <span><i>Ngày: {{ $day }} Tháng: {{ $month }} Năm: {{ $year }}</i></span>
                </div>
                <hr>
                <div class="company">
                    <div class="row">
                        <div class="col-s-3">ĐƠN VỊ BÁN HÀNG</div>
                        <div class="col-s-1">:</div>
                        <div class="col-s-8">Dịch vụ khách sạn SN</div>
                    </div>
                    <div class="row">
                        <div class="col-s-3">ĐỊA CHỈ</div>
                        <div class="col-s-1">:</div>
                        <div class="col-s-8">115a- Đại Áng- Thanh Trì- Hà Nội- Việt Nam</div>
                    </div>
                    <div class="row">
                        <div class="col-s-3">SỐ ĐIỆN THOẠI</div>
                        <div class="col-s-1">:</div>
                        <div class="col-s-8">0359241554</div>
                    </div>
                </div>
                <hr>
                @foreach ($customers as $cus)
                    <div class="row">
                        <div class="col-s-12">Họ và tên khách hàng: <b>{{ $cus->name }}</b></div>
                    </div>
                    <div class="row">
                        <div class="col-s-12">Số CMT/ CCCD: <b>{{ $cus->identify_numb }}</b></div>
                    </div>
                @endforeach
                @foreach ($checkin as $check)
                    <div class="row">
                        <div class="col-s-12">Số phòng: <b>{{ $check->name }}</b></div>
                    </div>
                @endforeach
                @foreach ($checkout as $item)
                    <div class="row">
                        <div class="col-s-12">Thời gian thuê phòng: <b>{{ $item->time_start }}</b></div>
                    </div>
                    <div class="row">
                        <div class="col-s-12">Thời gian trả phòng: <b>{{ $item->time_end }}</b></div>
                    </div>
                @endforeach
                <div class="row">
                    <div class="fresh-datatables">
                        <table style="width:100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên sản phẩm, dịch vụ</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>#</th>
                                    <th>Thuê phòng</th>
                                    <th>1</th>
                                    <?php
                                    foreach ($services as $item1) {
                                        $money += $item1->price;
                                    }
                                    foreach ($additional_fee as $item2) {
                                        $money += $item2->price;
                                    }
                                    foreach ($checkout as $item3) {
                                        $money = $item3->sum_price - $money;
                                    }
                                    ?>
                                    <th>{{ number_format($money, 0, ',', '.') }} đ</th>
                                </tr>
                                @foreach ($services as $ser)
                                    <tr>
                                        <th>{{ $index++ }}</th>
                                        <th>{{ $ser->name }}</th>
                                        <th>{{ $ser->amount }}</th>
                                        <th>{{ number_format($ser->price, 0, ',', '.') }} đ</th>
                                    </tr>
                                @endforeach
                                @foreach ($additional_fee as $add)
                                    <tr>
                                        <th>{{ $index++ }}</th>
                                        <th>{{ $add->name }}</th>
                                        <th>{{ $add->amount }}</th>
                                        <th>{{ number_format($add->price, 0, ',', '.') }} đ</th>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" style="text-align: right">Tổng tiền:</th>
                                    <th>
                                        @foreach ($checkout as $out)
                                            {{ number_format($out->sum_price, 0, ',', '.') }} đ
                                        @endforeach
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        Số tiền viết bằng chữ:
                                        @if ($out->sum_price == 0)
                                            <i>không đồng</i>
                                        @else
                                            <i>
                                                {{ numberToString($out->sum_price) }} đồng.
                                            </i>
                                        @endif
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-s-6" style="text-align:center">
                        <b>Khách hàng</b><br>
                        (Ký và ghi rõ họ tên)
                    </div>
                    <div class="col-s-6" style="text-align:center">
                        <b>Quản lý khách sạn</b><br>
                        (Ký và ghi rõ họ tên)
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
function numberToString($a)
{
    $result = '';
    // please write your code here
    $a = (string) $a;
    $leng = strlen($a);

    if ($leng == 1) {
        return $map[$a];
    }
    $convert = chunkStringToArray($a);

    $count = count($convert);
    $j = $count;
    for ($i = 0; $i < $count; $i++) {
        if ($convert[$i] == '000') {
            $j--;
            continue;
        }
        if ($j % 4 == 0) {
            $result .= ' ' . numberToThousand($convert[$i]) . ' tỷ';
        } elseif ($j % 3 == 0) {
            $result .= ' ' . numberToThousand($convert[$i]) . ' triệu';
        } elseif ($j % 2 == 0) {
            $result .= ' ' . numberToThousand($convert[$i]) . ' nghìn';
        } else {
            $result .= ' ' . numberToThousand($convert[$i]);
        }
        $j--;
    }
    //replace if end number is 4
    $result = trim($result);
    if (substr($result, -3) == 'bon') {
        $result = substr($result, 0, -3) . 'tu';
    }
    return $result;
}

function numberToThousand($a)
{
    $a = (string) $a;
    $map = ['0' => 'không', '1' => 'một', '2' => 'hai', '3' => 'ba', '4' => 'bốn', '5' => 'năm', '6' => 'sáu', '7' => 'bảy', '8' => 'tám', '9' => 'chín'];
    $leng = strlen($a);
    $str = '';
    $j = $leng;
    if ($a == '10') {
        return 'muoi';
    }
    if ($leng == 2 && $a[0] == '1') {
        return trim("mươi {$map[$a[1]]}");
    }
    for ($i = 0; $i < $leng; $i++) {
        if ($j == 3) {
            $str .= " {$map[$a[$i]]} trăm";
        } elseif ($j == 2) {
            if ($a[$i] == '0' && $leng == 3 && $a[2] != '0') {
                $str .= ' linh';
            } elseif ($a[$i] != '0') {
                $str .= " {$map[$a[$i]]} mươi";
            }
        } else {
            if ($a[$i] != '0') {
                $str .= " {$map[$a[$i]]} ";
            }
        }

        $j--;
    }

    return trim($str);
}

function chunkStringToArray($a)
{
    $a = number_format((int) $a, 0);
    return explode(',', $a);
}

?>
