<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InfoUserModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountApi extends Controller
{
    public function getinfo($id)
    {
        if ($id !== "null") {
            $room = User::query()->with('info_user')->where('users.id', $id)->get();
            echo json_encode($room);
        } else {
            $data = DB::table('type_room')->get();
            echo json_encode($data);
        }
    }
    public function create(Request $request)
    {
        $birth_of_date = $request->get('birth_of_date');
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');
        $address = $request->get('address');
        $gender = $request->get('gender');
        $phone = $request->get('phone');
        $check = DB::table('users')->where('email', $email)->count();
        if ($check == 0) {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            $user->assignRole('admin');
            $get_id_user = User::query()->orderByDesc('id')->first();
            $user_id = $get_id_user->id;
            $info_user = InfoUserModel::create([
                'phone' => $phone,
                'date_of_birth' => $birth_of_date,
                'address' => $address,
                'gender' => $gender,
                'user_id' => $user_id,
            ]);

            echo json_encode($user_id);
        } else {
            echo json_encode(201);
        }
    }
    public function update(Request $request)
    {
        $id_type_room = $request->get('id_type_room');
        $name = $request->get('name');
        $adults = $request->get('adults');
        $children = $request->get('children');
        $id = $request->get('id');
        $update = DB::table('rooms')
            ->where('id_room', $id)
            ->update([
                'id_type_room' => $id_type_room,
                'name' => $name,
                'adults' => $adults,
                'children' => $children,
            ]);
        echo json_encode(200);
    }
    public function lockOrUnlock($id)
    {
        // xem trạng thái hoạt động của bảng phòng theo id
        $check = DB::table('rooms')->where('id_room', $id)->select('status')->first();
        $status = $check->status;
        // xem trạng thái hoạt động của loại phòng theo id từ bảng giá phòng
        $get_id_type_room = DB::table('rooms')->where('id_room', $id)->select('id_type_room')->first();
        $id_type_room = $get_id_type_room->id_type_room;
        $check_type_room_status = DB::table('type_room')->where('id_type_room', $id_type_room)->select('status')->first();
        $type_room_status = $check_type_room_status->status;
        $get_type_room = DB::table('type_room')->where('id_type_room', $id_type_room)->select('name')->first();
        $type_room = $get_type_room->name;

        if ($type_room_status == 0) {
            if ($status == 5) {
                $update = DB::table('rooms')
                    ->where('id_room', $id)
                    ->update([
                        'status' => 0
                    ]);
            } else {
                $update = DB::table('rooms')
                    ->where('id_room', $id)
                    ->update([
                        'status' => 5
                    ]);
            }
            $json['code'] = 200;
            echo json_encode($json);
        } else {
            $error = "Thao tác này không thể thực hiện vì loại phòng '" . $type_room . "' hiện đang không có";
            $json['code'] = 201;
            $json['error'] = $error;
            echo json_encode($json);
        }
    }
}