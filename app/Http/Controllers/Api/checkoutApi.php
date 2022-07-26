<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdditionalFeeModel;
use App\Models\CheckInModel;
use App\Models\PriceRoomModel;
use App\Models\ServicesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class checkoutApi extends Controller
{
    public function getinfo($id)
    {
        $get_checkin = CheckInModel::query()
            ->join('rooms', 'checkin.id_room', '=', 'rooms.id_room')
            ->where('id_checkin_room', $id)
            ->get();
        $get_type_room = CheckInModel::query()
            ->join('rooms', 'checkin.id_room', '=', 'rooms.id_room')
            ->where('id_checkin_room', $id)
            ->select('rooms.id_type_room')
            ->first();
        $id_type_room = $get_type_room->id_type_room;

        $price_services = ServicesModel::select(DB::raw("SUM(price) as price_services"))
            ->where('id_checkin_room', $id)
            ->where('status', 0)
            ->get();

        $price_additional_fee = AdditionalFeeModel::select(DB::raw("SUM(price) as price_additional_fee"))
            ->where('id_checkin_room', $id)
            ->where('status', 0)
            ->get();
        $get_price = PriceRoomModel::query()
            ->where('id_type_room', $id_type_room)
            ->get();
        $json['checkin'] = $get_checkin;
        $json['price_hour'] = $get_price;
        $json['price_services'] = $price_services;
        $json['price_additional_fee'] = $price_additional_fee;
        echo json_encode($json);
    }

    public function create(Request $request)
    {
        $id_checkin_room = $request->get('id_checkin_room');
        $time_start = $request->get('time_start');
        $time_end = $request->get('time_end');
        $sum_price = $request->get('sum_price');

        $createCheckout = DB::table('checkout')
            ->insert([
                'time_start' => $time_start,
                'time_end' => $time_end,
                'id_checkin_room' => $id_checkin_room,
                'sum_price' => $sum_price,
            ]);
        $updateCheckin = DB::table('checkin')
            ->where('id_checkin_room', $id_checkin_room)
            ->update([
                'status' => 1,
            ]);
        $get_id_room = CheckInModel::query()->where('id_checkin_room', $id_checkin_room)->select('id_room')->first();
        $id_room = $get_id_room->id_room;
        $updateRoom = DB::table('rooms')
            ->where('id_room', $id_room)
            ->update([
                'status' => 2,
            ]);
        echo json_encode(200);
    }
}