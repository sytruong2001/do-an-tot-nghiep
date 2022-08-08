<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdditionalFeeModel;
use App\Models\CheckInModel;
use App\Models\CheckOutModel;
use App\Models\CustomersModel;
use App\Models\RoomModel;
use App\Models\ServicesModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class checkoutController extends Controller
{
    public function index()
    {
        // $today = Carbon::today();
        $data = RoomModel::query()
            ->join('checkin', 'rooms.id_room', '=', 'checkin.id_room')
            ->where('checkin.status', 0)
            // ->where('checkin.time_end', $today)
            ->get();
        return view('admin.view_checkout', ['rooms' => $data]);
    }

    public function history()
    {
        $data = CheckOutModel::query()
            ->with('checkin')
            ->orderByDesc('id_checkout_room')
            ->get();
        $customer = CustomersModel::query()
            ->get();
        $room = CheckInModel::query()
            ->join('rooms', 'checkin.id_room', '=', 'rooms.id_room')
            ->get();
        return view('admin.view_history', ['index' => 1, 'checkout' => $data, 'customer' => $customer, 'rooms' => $room]);
    }

    public function getInfo($id)
    {
        $get_info_checkin = CheckInModel::query()
            ->join("rooms", "checkin.id_room", "=", "rooms.id_room")
            ->where('id_checkin_room', $id)->get();
        $get_info_customer = CustomersModel::query()->where('id_checkin_room', $id)->get();
        $get_info_service = ServicesModel::query()->where([
            ['id_checkin_room', '=', $id],
            ['status', '=', 0],
        ])->get();
        $get_info_add = AdditionalFeeModel::query()->where([
            ['id_checkin_room', '=', $id],
            ['status', '=', 0],
        ])->get();
        // dd($get_info_add);
        return view('admin.view_all_checkout', [
            'checkin' => $get_info_checkin,
            'customers' => $get_info_customer,
            'services' => $get_info_service,
            'additional_fee' => $get_info_add,
            'index' => 1,
            'sum_services' => 0,
            'sum_additional-fee' => 0,
        ]);
    }

    public function print($id)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->print_checkout($id));
        return $pdf->stream();
    }

    public function print_checkout($id)
    {
        $dt = Carbon::now();
        $day = $dt->day;
        $month = $dt->month;
        $year = $dt->year;
        $get_info_checkin = CheckInModel::query()
            ->join("rooms", "checkin.id_room", "=", "rooms.id_room")
            ->where('id_checkin_room', $id)->get();
        $get_info_checkout = CheckOutModel::query()
            ->where('id_checkin_room', $id)->get();
        $get_info_customer = CustomersModel::query()->where('id_checkin_room', $id)->get();
        $get_info_service = ServicesModel::query()->where([
            ['id_checkin_room', '=', $id],
            ['status', '=', 0],
        ])->get();
        $get_info_add = AdditionalFeeModel::query()->where([
            ['id_checkin_room', '=', $id],
            ['status', '=', 0],
        ])->get();
        return view('admin.view_print', [
            'checkin' => $get_info_checkin,
            'checkout' => $get_info_checkout,
            'customers' => $get_info_customer,
            'services' => $get_info_service,
            'additional_fee' => $get_info_add,
            'index' => 1,
            'money' => 0,
            'day' => $day,
            'month' => $month,
            'year' => $year,
        ]);
    }
}