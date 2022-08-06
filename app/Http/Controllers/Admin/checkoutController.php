<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdditionalFeeModel;
use App\Models\CheckInModel;
use App\Models\CheckOutModel;
use App\Models\CustomersModel;
use App\Models\RoomModel;
use App\Models\ServicesModel;
use Illuminate\Http\Request;

class checkoutController extends Controller
{
    public function index()
    {
        $data = RoomModel::query()
            ->join('checkin', 'rooms.id_room', '=', 'checkin.id_room')
            ->where('checkin.status', 0)
            ->get();
        return view('admin.view_checkout', ['rooms' => $data]);
    }

    public function history()
    {
        $data = CheckOutModel::query()
            ->with('checkin')
            ->get();
        return view('admin.view_history', ['index' => 1, 'checkout' => $data]);
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
}