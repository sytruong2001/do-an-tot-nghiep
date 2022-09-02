<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CheckInModel;
use App\Models\CustomersModel;
use App\Models\PriceRoomModel;
use App\Models\RoomModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class checkinController extends Controller
{
    public function index()
    {
        $start_date = Carbon::today();
        $end_date = Carbon::today()->addDay(7);
        $checkin = CheckInModel::query()
            ->where([
                ['time_start', '<=', $start_date],
                ['time_end', '>=', $end_date],
                ['status', '<>', 1],
                ['status', '<>', 3],
            ])
            ->orWhere([
                ['time_end', '>=', $start_date],
                ['time_end', '<=', $end_date],
                ['status', '<>', 3],
                ['status', '<>', 1],
            ])
            ->orWhere([
                ['time_start', '>=', $start_date],
                ['time_start', '<=', $end_date],
                ['status', '<>', 3],
                ['status', '<>', 1],
            ])
            ->select('id_room')
            ->get();
        $array = [];
        foreach ($checkin as $value) {
            array_push($array, $value->id_room);
        }
        $data = RoomModel::with('type_room')->where('status', 0)->whereNotIn('id_room', $array)->get();
        // $data = RoomModel::query()
        //     ->where('status', 0)
        //     ->get();
        return view('admin.view_checkin', ['rooms' => $data]);
    }

    public function getInfo()
    {
        $data = CheckInModel::query()
            ->join('rooms', 'checkin.id_room', '=', 'rooms.id_room')
            ->where('checkin.status', 2)
            ->orderBy('checkin.time_start', 'asc')
            ->get();
        $start_date = Carbon::today();
        $get_info = CheckInModel::query()
            ->where('checkin.status', 2)
            ->whereDate('checkin.time_start', $start_date)
            ->count();
        return view('admin.view_booked', ['rooms' => $data, 'numb' => $get_info]);
    }

    public function searchCheckinToday()
    {
        $start_date = Carbon::today();
        $data = CheckInModel::query()
            ->join('rooms', 'checkin.id_room', '=', 'rooms.id_room')
            ->where('checkin.status', 2)
            ->whereDate('checkin.time_start', $start_date)
            ->get();
        $get_info = CheckInModel::query()
            ->where('checkin.status', 2)
            ->whereDate('checkin.time_start', $start_date)
            ->count();
        return view('admin.view_booked', ['rooms' => $data, 'numb' => $get_info]);
    }
    public function bookingRoom($id, $start, $end)
    {
        $data = RoomModel::query()
            ->where('id_room', $id)
            ->get();
        $get_id_type_room = DB::table('rooms')->where('id_room', $id)->first();
        $get_price_room = PriceRoomModel::where('id_type_room', $get_id_type_room->id_type_room)->get();
        return view('admin.view_detail_booking', ['rooms' => $data, 'id' => $id, 'start' => $start, 'end' => $end, 'price' => $get_price_room]);
    }
    public function thank($id)
    {
        $checkin = CheckInModel::query()
            ->join('rooms', 'checkin.id_room', '=', 'rooms.id_room')
            ->where('id_checkin_room', $id)->get();
        $customer = CustomersModel::query()->where('id_checkin_room', $id)->get();
        return view('customer.view_booking', [
            'detail_checkin' => $checkin,
            'detail_customer' => $customer,
        ]);
    }
}
