<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\PriceRoomModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class priceRoomController extends Controller
{
    // lấy tất cả thông tin giá phòng
    public function index()
    {
        $data = PriceRoomModel::query()
            ->with('type_room')
            ->get();
        return view('super-admin.view_price_room', [
            'price_room' => $data,
            'index' => 1,
        ]);
    }
}
