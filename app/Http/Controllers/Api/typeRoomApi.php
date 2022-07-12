<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Json;

class typeRoomApi extends Controller
{
    public function getinfo($id)
    {
        if ($id !== "null") {
            $data = DB::table('type_room')->where('id_type_room', $id)->get();
        } else {
            $data = DB::table('type_room')->get();
        }
        echo json_encode($data);
    }
    public function create(Request $request)
    {
        $name = $request->get('name');
        $check = DB::table('type_room')->where('name', $name)->count();
        if ($check == 0) {
            $create = DB::table('type_room')
                ->insert([
                    'name' => $name,
                    'status' => 0,
                ]);
            echo json_encode(200);
        } else {
            echo json_encode(201);
        }
    }
    public function update(Request $request)
    {
        $name = $request->get('name');
        $id = $request->get('id');
        $update = DB::table('type_room')
            ->where('id_type_room', $id)
            ->update([
                'name' => $name,
            ]);
        echo json_encode(200);
    }
    public function lockOrUnlock($id)
    {
        $check = DB::table('type_room')->where('id_type_room', $id)->select('status')->first();
        $status = $check->status;
        if ($status == 1) {
            $update_type_room = DB::table('type_room')
                ->where('id_type_room', $id)
                ->update([
                    'status' => 0
                ]);
        } else {
            $update_type_room = DB::table('type_room')
                ->where('id_type_room', $id)
                ->update([
                    'status' => 1
                ]);
            $update_price_room = DB::table('price_room')
                ->where('id_type_room', $id)
                ->update([
                    'status' => 1
                ]);
            $update_room = DB::table('rooms')
                ->where('id_type_room', $id)
                ->update([
                    'status' => 5
                ]);
        }
        echo json_encode($status);
    }
}