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
    // lấy tất cả các phòng hiện đang trống hoặc chưa được đặt trong 7 ngày kế tiếp để thực hiện đặt phòng
    public function index()
    {
        $start_date = Carbon::today();
        $end_date = Carbon::today()->addDay(7);
        // lấy tất cả các phòng được đặt trong 7 ngày kế tiếp
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
        // lấy tất cả các phòng còn trống hoặc chưa được đặt
        $data = RoomModel::with('type_room')->where('status', 0)->whereNotIn('id_room', $array)->get();
        // $data = RoomModel::query()
        //     ->where('status', 0)
        //     ->get();
        return view('admin.view_checkin', ['rooms' => $data]);
    }

    // lấy thông tin các phòng cần được nhận phòng
    public function getInfo()
    {
        $data = CheckInModel::query()
            ->join('rooms', 'checkin.id_room', '=', 'rooms.id_room')
            ->where('checkin.status', 2)
            ->orderBy('checkin.time_start', 'asc')
            ->get();
        $start_date = Carbon::today();
        // số phòng cần nhận hôm nay
        $get_info = CheckInModel::query()
            ->where('checkin.status', 2)
            ->whereDate('checkin.time_start', $start_date)
            ->count();
        return view('admin.view_booked', ['rooms' => $data, 'numb' => $get_info]);
    }

    // lấy thông tin các phòng cần nhận ngày hôm nay
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

    // lấy thông tin phòng để thực hiện đặt phòng và thanh toán trả trước khi đặt phòng
    public function bookingRoom($id, $start, $end)
    {
        $data = RoomModel::query()
            ->where('id_room', $id)
            ->get();
        $get_id_type_room = DB::table('rooms')->where('id_room', $id)->first();
        $get_price_room = PriceRoomModel::where('id_type_room', $get_id_type_room->id_type_room)->get();
        return view('admin.view_detail_booking', ['rooms' => $data, 'id' => $id, 'start' => $start, 'end' => $end, 'price' => $get_price_room]);
    }

    // thông báo đặt phòng thành công và lấy thông tin phiếu đặt phòng vừa đặt
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