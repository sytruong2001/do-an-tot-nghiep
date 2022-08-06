<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PriceRoomModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class priceRoomApi extends Controller
{
    public function getinfo($id)
    {
        if ($id !== "null") {
            $price_room = PriceRoomModel::query()
                ->with('type_room')->where('id_price_room', $id)->get();
            $type_room = DB::table('type_room')->get();
            $json['price'] = $price_room;
            $json['type'] = $type_room;
            echo json_encode($json);
        } else {
            $data = DB::table('price_room')->where('status', 0)->get();
            echo json_encode($data);
        }
    }
    public function create(Request $request)
    {
        $id_type_room = $request->get('id_type_room');
        $first_hour = $request->get('first_hour');
        $next_hour = $request->get('next_hour');
        $check = DB::table('price_room')->where('id_type_room', $id_type_room)->count();
        if ($check == 0) {
            $create = DB::table('price_room')
                ->insert([
                    'id_type_room' => $id_type_room,
                    'first_hour' => $first_hour,
                    'next_hour' => $next_hour,
                    'status' => 0,
                ]);
            echo json_encode(200);
        } else {
            echo json_encode(201);
        }
    }
    public function update(Request $request)
    {
        $id_type_room = $request->get('id_type_room');
        $first_hour = $request->get('first_hour');
        $next_hour = $request->get('next_hour');
        $id = $request->get('id');
        $update = DB::table('price_room')
            ->where('id_price_room', $id)
            ->update([
                'id_type_room' => $id_type_room,
                'first_hour' => $first_hour,
                'next_hour' => $next_hour,
            ]);
        echo json_encode(200);
    }
    public function lockOrUnlock($id)
    {
        // xem trạng thái hoạt động của bảng giá phòng theo id
        $check = DB::table('price_room')->where('id_price_room', $id)->select('status')->first();
        $status = $check->status;
        // xem trạng thái hoạt động của loại phòng theo id từ bảng giá phòng
        $get_id_type_room = DB::table('price_room')->where('id_price_room', $id)->select('id_type_room')->first();
        $id_type_room = $get_id_type_room->id_type_room;
        $check_type_room_status = DB::table('type_room')->where('id_type_room', $id_type_room)->select('status')->first();
        $type_room_status = $check_type_room_status->status;
        $get_type_room = DB::table('type_room')->where('id_type_room', $id_type_room)->select('name')->first();
        $type_room = $get_type_room->name;

        if ($type_room_status == 0) {
            if ($status == 1) {
                $update = DB::table('price_room')
                    ->where('id_price_room', $id)
                    ->update([
                        'status' => 0
                    ]);
            } else {
                $update = DB::table('price_room')
                    ->where('id_price_room', $id)
                    ->update([
                        'status' => 1
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
}