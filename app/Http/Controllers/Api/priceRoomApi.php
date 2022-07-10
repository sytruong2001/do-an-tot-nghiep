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
            $data = DB::table('price_room')->get();
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
        $check = DB::table('price_room')->where('id_price_room', $id)->select('status')->first();
        $status = $check->status;
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
        echo json_encode($status);
    }
}