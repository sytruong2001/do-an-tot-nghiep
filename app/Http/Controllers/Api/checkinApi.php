<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CheckInModel;
use App\Models\CustomersModel;
use App\Models\RoomModel;
use App\Models\User;
use App\Notifications\PaymentNotifycation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class checkinApi extends Controller
{
    // lấy thông tin chi tiết của phòng theo mã id
    public function getinfo($id)
    {
        $room = RoomModel::query()->where('id_room', $id)->get();
        $type_room = DB::table('type_room')->get();
        $json['room'] = $room;
        $json['type'] = $type_room;
        echo json_encode($json);
    }
    // thông tin chi tiết của phiếu đặt, nhận phòng theo mã id
    public function getCheckin($id)
    {
        $checkin = CheckInModel::query()->where('id_checkin_room', $id)->get();
        $type_room = DB::table('type_room')->get();
        $json['checkin'] = $checkin;
        $json['type'] = $type_room;
        echo json_encode($json);
    }

    // tạo mới phiếu đặt, nhận phòng
    public function create(Request $request)
    {
        // kiểm tra trong khoảng thời gian khách đặt, phòng khách đặt có còn trống hay không?
        $check_room = CheckInModel::query()
            ->where([
                ['time_start', '<=', $request->time_start],
                ['time_end', '>=', $request->time_end],
                ['status', '<>', 1],
                ['status', '<>', 3],
                ['id_room', $request->id_room],
            ])
            ->orWhere([
                ['time_end', '>=', $request->time_start],
                ['time_end', '<=', $request->time_end],
                ['status', '<>', 3],
                ['status', '<>', 1],
                ['id_room', $request->id_room],
            ])
            ->orWhere([
                ['time_start', '>=', $request->time_start],
                ['time_start', '<=', $request->time_end],
                ['status', '<>', 3],
                ['status', '<>', 1],
                ['id_room', $request->id_room],
            ])
            ->count();
        // nếu phòng còn trống thì thực hiện đặt phòng, nếu không thì quay lại và thông báo cho lễ tân biết thời gian không phù hợp
        // nếu thành công đặt phòng trạng thái phiếu đặt phòng sẽ là 2
        if ($check_room == 0) {
            $check_status_room = DB::table('rooms')->where('id_room', $request->id_room)->select('status')->first();
            $status_room = $check_status_room->status;
            if ($status_room == 0) {
                $create = DB::table('checkin')
                    ->insert([
                        'time_start' => $request->time_start,
                        'time_end' => $request->time_end,
                        'id_room' => $request->id_room,
                        'deposit' => 0,
                        'status' => 2,
                    ]);

                // $update_status_room = DB::table('rooms')
                //     ->where('id_room', $request->id_room)
                //     ->update([
                //         'status' => 1,
                //     ]);

                $get_id_checkin = CheckInModel::query()->orderByDesc('id_checkin_room')->first();
                $id_checkin = $get_id_checkin->id_checkin_room;

                for ($i = 1; $i <= $request->numb_adult; $i++) {
                    if ($request->get('name' . $i) != null) {
                        $create_customer = CustomersModel::create([
                            'name' => $request->get('name' . $i),
                            'identify_numb' => $request->get('identify' . $i),
                            'id_checkin_room' => $id_checkin,
                        ]);
                    }
                }
                $json['code'] = 200;
                echo json_encode($json);
            } else {
                $json['error'] = "Trạng thái phòng hiện không trống!";
                $json['code'] = 500;
                echo json_encode($json);
            }
        } else {
            $json['code'] = 201;
            echo json_encode($json);
        }
    }

    // xác nhận thực hiện thao tác nhận phòng theo mã id
    // trạng thái phiếu đặt phòng sẽ được chuyển về 0
    public function update($id)
    {
        $today = Carbon::today();
        $check_time = CheckInModel::query()
            ->where('id_checkin_room', $id)
            ->where('time_start', '>', $today)
            ->count();
        $get_time_start = CheckInModel::query()
            ->where('id_checkin_room', $id)
            ->select('time_start')
            ->first();
        $time_start = $get_time_start->time_start;
        if ($check_time == 0) {
            $update_status_checkin = DB::table('checkin')
                ->where('id_checkin_room', $id)
                ->update([
                    'status' => 0,
                ]);
            $json['code'] = 200;
            echo json_encode($json);
        } else {
            $json['code'] = 201;
            $json['time'] = $time_start;
            echo json_encode($json);
        }
    }

    // thao tác hủy đặt phòng
    // trạng thái phiếu đặt phòng sẽ được chuyển về 3
    public function cancel($id)
    {
        $update_status_checkin = DB::table('checkin')
            ->where('id_checkin_room', $id)
            ->update([
                'status' => 3,
            ]);
        $json['code'] = 200;
        echo json_encode($json);
    }

    // dành cho thanh toán online
    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    public function booking(Request $request)
    {
        $check_status_room = DB::table('rooms')->where('id_room', $request->id_room)->first();
        $nameRoom = $check_status_room->name;
        //Thông báo sau khi thanh toán tiền đặt cọc về email
        $user = User::first();

        $payment = [
            'title' => 'Thông báo xác nhận đặt phòng khách sạn SN',
            'infoCustomer' => 'Họ và tên khách hàng: ' . $request->name . ', Số CMT/CCCD: ' . $request->identify,
            'infoRoom' => 'Số phòng: ' . $nameRoom,
            'time' => 'Thời gian nhận phòng: ' . $request->time_start . ', Thời gian trả phòng: ' . $request->time_end,
            'price' => 'Tổng tiền: ' . ($request->deposit / 0.2) . 'VNĐ, Tiền đã đặt cọc: ' . $request->deposit . 'VNĐ',
            'text' => 'Xem chi tiết',
            'url' => url('/admin/nhan-phong'),

        ];
        Notification::send($user, new PaymentNotifycation($payment));

        $status_room = $check_status_room->status;
        if ($status_room == 0) {
            $create = DB::table('checkin')
                ->insert([
                    'time_start' => $request->time_start,
                    'time_end' => $request->time_end,
                    'id_room' => $request->id_room,
                    'deposit' => $request->deposit,
                    'status' => 2,
                ]);

            $get_id_checkin = CheckInModel::query()->orderByDesc('id_checkin_room')->first();
            $id_checkin = $get_id_checkin->id_checkin_room;


            $create_customer = CustomersModel::create([
                'name' => $request->name,
                'identify_numb' => $request->identify,
                'id_checkin_room' => $id_checkin,
            ]);
        }
        // api thanh toán bằng momo
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";


        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $amount = $request->deposit;
        $orderId = time() . "";
        $redirectUrl = "http://127.0.0.1:8000/camon/" . $id_checkin;
        $ipnUrl = "http://127.0.0.1:8000/";
        $extraData = "";

        $requestId = time() . "";
        $requestType = "payWithATM";
        // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json

        //Just a example, please check more in there
        echo json_encode($jsonResult['payUrl']);
    }

    // tìm kiếm phòng theo tên phòng
    public function searchRoom(Request $request)
    {
        $name = $request->get('name');
        $status = $request->get('status');
        $room = RoomModel::query()->join('checkin', 'rooms.id_room', '=', 'checkin.id_room')->where('rooms.name', 'like', '%' . $name . '%')->where('checkin.status', $status)->get();
        $type_room = DB::table('type_room')->get();
        $json['room'] = $room;
        $json['type'] = $type_room;
        echo json_encode($json);
    }

    // tìm kiếm phiếu đặt phòng theo số CMT/CCCD
    public function searchIdentify(Request $request)
    {
        $identify_numb = $request->get('identify_numb');
        $status = $request->get('status');
        $room = RoomModel::query()
            ->join('checkin', 'rooms.id_room', '=', 'checkin.id_room')
            ->join('customer', 'checkin.id_checkin_room', '=', 'customer.id_checkin_room')
            ->where('customer.identify_numb', 'like', '%' . $identify_numb . '%')
            ->where('checkin.status', $status)
            ->select('checkin.id_checkin_room', 'checkin.time_start', 'rooms.name')
            ->get();
        $json['room'] = $room;
        echo json_encode($json);
    }

    // tìm kiếm phòng trống theo ngày nhận, trả phòng
    public function searchDateCheckin(Request $request)
    {
        $checkin = CheckInModel::query()
            ->where([
                ['time_start', '<=', $request->start_date],
                ['time_end', '>=', $request->end_date],
                ['status', '<>', 1],
                ['status', '<>', 3],
            ])
            ->orWhere([
                ['time_end', '>=', $request->start_date],
                ['time_end', '<=', $request->end_date],
                ['status', '<>', 3],
                ['status', '<>', 1],
            ])
            ->orWhere([
                ['time_start', '>=', $request->start_date],
                ['time_start', '<=', $request->end_date],
                ['status', '<>', 3],
                ['status', '<>', 1],
            ])
            ->select('id_room')
            ->get();
        $array = [];
        foreach ($checkin as $value) {
            array_push($array, $value->id_room);
        }
        $room = RoomModel::with('type_room')->where('status', 0)->whereNotIn('id_room', $array)->get();
        $json['checkins'] = $array;
        $json['rooms'] = $room;
        echo json_encode($json);
    }
}
