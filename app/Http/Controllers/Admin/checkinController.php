<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CheckInModel;
use App\Models\PriceRoomModel;
use App\Models\RoomModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class checkinController extends Controller
{
    public function index()
    {
        $data = RoomModel::query()
            ->where('status', 0)
            ->get();
        return view('admin.view_checkin', ['rooms' => $data]);
    }

    public function getInfo()
    {
        $data = CheckInModel::query()
            ->join('rooms', 'checkin.id_room', '=', 'rooms.id_room')
            ->where('checkin.status', 2)
            ->get();
        return view('admin.view_booked', ['rooms' => $data]);
    }
    public function bookingRoom($id, $start, $end)
    {
        $data = RoomModel::query()
            ->where('id_room', $id)
            ->get();
        $get_id_type_room = DB::table('rooms')->where('id_room', $id)->first();
        $get_price_room = PriceRoomModel::where('id_type_room', $get_id_type_room->id_type_room)->get();
        return view('admin.view_detail_booking', ['rooms' => $data, 'start' => $start, 'end' => $end, 'price' => $get_price_room]);
    }
}