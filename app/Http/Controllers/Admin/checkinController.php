<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CheckInModel;
use App\Models\RoomModel;
use Illuminate\Http\Request;

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
}