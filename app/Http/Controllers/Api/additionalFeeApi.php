<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class additionalFeeApi extends Controller
{
    // lấy thông tin chi tiết tổn thất
    public function getinfo($id)
    {
        $data = DB::table('additional_fee')->where('id_additional_fee', $id)->get();
        echo json_encode($data);
    }
    // tạo mới tổn thất
    public function create(Request $request)
    {
        $name = $request->get('nameAdditionalFee');
        $amount = $request->get('amountAdditionalFee');
        $price = $request->get('priceAdditionalFee');
        $idCheckinRoom = $request->get('idCheckinRoom');
        $create = DB::table('additional_fee')
            ->insert([
                'name' => $name,
                'amount' => $amount,
                'price' => $price * $amount,
                'id_checkin_room' => $idCheckinRoom,
                'status' => 0,
            ]);
        echo json_encode(200);
    }
    // cập nhật tổn thất
    public function update(Request $request)
    {
        $name = $request->get('nameAdditionalFee');
        $amount = $request->get('amountAdditionalFee');
        $price = $request->get('priceAdditionalFee');
        $id = $request->get('id');
        $update = DB::table('additional_fee')
            ->where('id_additional_fee', $id)
            ->update([
                'name' => $name,
                'amount' => $amount,
                'price' => $price * $amount,
            ]);
        echo json_encode(200);
    }
    // xóa tổn thất
    public function destroy($id)
    {
        $update = DB::table('additional_fee')
            ->where('id_additional_fee', $id)
            ->update([
                'status' => 1,
            ]);
        echo json_encode(200);
    }
}
