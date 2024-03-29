<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class servicesApi extends Controller
{
    // lấy thông tin chi tiết dịch vụ
    public function getinfo($id)
    {
        $data = DB::table('services')->where('id_service', $id)->get();
        echo json_encode($data);
    }
    // tạo mới dịch vụ
    public function create(Request $request)
    {
        $name = $request->get('nameService');
        $amount = $request->get('amountService');
        $price = $request->get('priceService');
        $idCheckinRoom = $request->get('idCheckinRoom');
        // $check = DB::table('services')->where('id_checkin_room', $name)->count();
        $create = DB::table('services')
            ->insert([
                'name' => $name,
                'amount' => $amount,
                'price' => $price * $amount,
                'id_checkin_room' => $idCheckinRoom,
                'status' => 0,
            ]);
        echo json_encode(200);
    }
    // cập nhật dịch vụ
    public function update(Request $request)
    {
        $name = $request->get('nameService');
        $amount = $request->get('amountService');
        $price = $request->get('priceService');
        $id = $request->get('id');
        $update = DB::table('services')
            ->where('id_service', $id)
            ->update([
                'name' => $name,
                'amount' => $amount,
                'price' => $price * $amount,
            ]);
        echo json_encode(200);
    }
    // xóa dịch vụ
    public function destroy($id)
    {
        $update = DB::table('services')
            ->where('id_service', $id)
            ->update([
                'status' => 1,
            ]);
        echo json_encode(200);
    }
}
