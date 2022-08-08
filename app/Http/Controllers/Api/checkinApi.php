<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CheckInModel;
use App\Models\CustomersModel;
use App\Models\RoomModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class checkinApi extends Controller
{
    public function getinfo($id)
    {
        $room = RoomModel::query()->where('id_room', $id)->get();
        $type_room = DB::table('type_room')->get();
        $json['room'] = $room;
        $json['type'] = $type_room;
        echo json_encode($json);
    }

    public function create(Request $request)
    {
        $check_status_room = DB::table('rooms')->where('id_room', $request->id_room)->select('status')->first();
        $status_room = $check_status_room->status;
        if ($status_room == 0) {
            $create = DB::table('checkin')
                ->insert([
                    'time_start' => $request->time_start,
                    'time_end' => $request->time_end,
                    'id_room' => $request->id_room,
                    'status' => 0,
                ]);

            $update_status_room = DB::table('rooms')
                ->where('id_room', $request->id_room)
                ->update([
                    'status' => 1,
                ]);

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
    }

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

    public function searchDateCheckin(Request $request)
    {
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $checkin = CheckInModel::query()
            ->where('time_start', '>=', $start_date)
            ->where('time_end', '<=', $end_date)
            ->where('status', 0)
            ->select('id_room')
            ->get();
        $check = CheckInModel::query()
            ->where('time_start', '>=', $start_date)
            ->where('time_end', '<=', $end_date)
            ->where('status', 0)
            ->count();
        $resultArray = [];
        if ($check != 0) {
            foreach ($checkin as $item) {
                $query = DB::table('rooms')
                    ->where('rooms.id_room', '<>', $item->id_room)
                    ->where('rooms.status', 0)
                    ->get();
                array_push($resultArray, $query);
            }
        } else {
            $query = DB::table('rooms')
                ->where('rooms.status', 0)
                ->get();
            array_push($resultArray, $query);
        }

        $type_room = DB::table('type_room')->get();
        $json['room'] = $resultArray;
        $json['type'] = $type_room;
        echo json_encode($json);
    }
}