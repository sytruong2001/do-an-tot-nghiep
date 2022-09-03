<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CheckInModel;
use App\Models\PriceRoomModel;
use App\Models\RoomModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomApi extends Controller
{
    // lấy thông tin chi tiết về phòng
    public function getinfo($id)
    {
        if ($id !== "null") {
            $room = RoomModel::query()
                ->with('type_room')->where('id_room', $id)->get();
            $type_room = DB::table('type_room')->get();
            $json['room'] = $room;
            $json['type'] = $type_room;
            echo json_encode($json);
        } else {
            $data = DB::table('type_room')->where('status', 0)->get();
            echo json_encode($data);
        }
    }
    // lấy trạng thái phòng
    public function getStatusRoom()
    {

        $checkin = RoomModel::query()->where('status', 0)->count();
        $checkout = CheckInModel::query()->where('status', 0)->count();
        $room = CheckInModel::query()->where('status', 2)->count();
        $clean = RoomModel::query()->where('status', 2)->count();
        $json['checkin'] = $checkin;
        $json['room'] = $room;
        $json['checkout'] = $checkout;
        $json['clean'] = $clean;
        echo json_encode($json);
    }
    // tạo mới phòng
    public function create(Request $request)
    {
        $id_type_room = $request->get('id_type_room');
        $name = $request->get('name');
        $adults = $request->get('adults');
        $children = $request->get('children');
        $check = DB::table('rooms')->where('name', $name)->count();
        if ($check == 0) {
            $create = DB::table('rooms')
                ->insert([
                    'id_type_room' => $id_type_room,
                    'name' => $name,
                    'adults' => $adults,
                    'children' => $children,
                    'status' => 0,
                ]);
            echo json_encode(200);
        } else {
            echo json_encode(201);
        }
    }
    // cập nhật thông tin phòng
    public function update(Request $request)
    {
        $id_type_room = $request->get('id_type_room');
        $name = $request->get('name');
        $adults = $request->get('adults');
        $children = $request->get('children');
        $id = $request->get('id');
        $checkNameRoom = RoomModel::query()->where('id_room', '<>', $id)->where('name', 'like', $name)->where('status', '<>', 5)->count();
        if ($checkNameRoom == 0) {
            $update = DB::table('rooms')
                ->where('id_room', $id)
                ->update([
                    'id_type_room' => $id_type_room,
                    'name' => $name,
                    'adults' => $adults,
                    'children' => $children,
                ]);
            $json['code'] = 200;
            $json['success'] = "Thay đổi thành công";
            echo json_encode($json);
        } else {
            $json['code'] = 501;
            $json['errorr'] = "Tên phòng đã tồn tại";
            echo json_encode($json);
        }
    }
    // ẩn hoặc bỏ ẩn đối với phòng
    public function lockOrUnlock($id)
    {
        // xem trạng thái hoạt động của bảng phòng theo id
        $check = DB::table('rooms')->where('id_room', $id)->select('status')->first();
        $status = $check->status;
        // xem trạng thái hoạt động của loại phòng theo id từ bảng giá phòng
        $get_id_type_room = DB::table('rooms')->where('id_room', $id)->select('id_type_room')->first();
        $id_type_room = $get_id_type_room->id_type_room;
        $check_type_room_status = DB::table('type_room')->where('id_type_room', $id_type_room)->select('status')->first();
        $type_room_status = $check_type_room_status->status;
        $get_type_room = DB::table('type_room')->where('id_type_room', $id_type_room)->select('name')->first();
        $type_room = $get_type_room->name;

        if ($type_room_status == 0) {
            if ($status == 5) {
                $update = DB::table('rooms')
                    ->where('id_room', $id)
                    ->update([
                        'status' => 0
                    ]);
            } else {
                $update = DB::table('rooms')
                    ->where('id_room', $id)
                    ->update([
                        'status' => 5
                    ]);
            }
            $json['code'] = 200;
            echo json_encode($json);
        } else {
            $error = "Thao tác này không thể thực hiện vì loại phòng '" . $type_room . "' hiện đang không có";
            $json['code'] = 201;
            $json['error'] = $error;
            echo json_encode($json);
        }
    }

    public function clean($id)
    {
        $update = DB::table('rooms')
            ->where('id_room', $id)
            ->update([
                'status' => 0,
            ]);
        echo json_encode(200);
    }

    public function searchRoom(Request $request)
    {
        $name = $request->get('name');
        $status = $request->get('status');
        $room = RoomModel::query()
            ->with('type_room')->where('rooms.name', 'like', '%' . $name . '%')->where('rooms.status', $status)->get();
        $type_room = DB::table('type_room')->get();
        $json['room'] = $room;
        $json['type'] = $type_room;
        echo json_encode($json);
    }

    public function searchTypeRoom($id)
    {
        $room = RoomModel::query()
            ->with('type_room')->where('id_type_room', $id)->where('rooms.status', 0)->get();
        $type_room = DB::table('type_room')->get();
        $json['room'] = $room;
        $json['type'] = $type_room;
        echo json_encode($json);
    }
    public function searchPriceRoom($id)
    {
        $get_id_type_room = PriceRoomModel::query()->where('id_price_room', $id)->select('id_type_room')->first();
        $id_type_room = $get_id_type_room->id_type_room;
        $room = RoomModel::query()
            ->with('type_room')->where('id_type_room', $id_type_room)->where('rooms.status', 0)->get();
        $type_room = DB::table('type_room')->get();
        $json['room'] = $room;
        $json['type'] = $type_room;
        echo json_encode($json);
    }

    public function searchBooking(Request $request)
    {
        $checkin = CheckInModel::query()
            ->where([
                ['time_start', '<=', $request->start],
                ['time_end', '>=', $request->end],
                ['status', '<>', 3],
                ['status', '<>', 1],
            ])
            ->orWhere([
                ['time_end', '>=', $request->start],
                ['time_end', '<=', $request->end],
                ['status', '<>', 3],
                ['status', '<>', 1],
            ])
            ->orWhere([
                ['time_start', '>=', $request->start],
                ['time_start', '<=', $request->end],
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
    public function getTimeEnd(Request $request)
    {
        $checkin = CheckInModel::query()
            ->where([
                ['time_start', '<=', $request->start],
                ['time_end', '>=', $request->end],
                ['status', '<>', 3],
                ['status', '<>', 1],
            ])
            ->orWhere([
                ['time_end', '>=', $request->start],
                ['time_end', '<=', $request->end],
                ['status', '<>', 3],
                ['status', '<>', 1],
            ])
            ->orWhere([
                ['time_start', '>=', $request->start],
                ['time_start', '<=', $request->end],
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