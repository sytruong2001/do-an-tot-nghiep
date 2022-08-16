<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InfoUserModel;
use App\Models\User;
use App\Notifications\PaymentNotifycation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

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

    // chưa sử dụng
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

    function changeInfo(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'phone' => ['required', 'min:10', 'max:10'],
        ], [
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.min' => 'Số điện thoại phải đủ 10 chữ số',
            'phone.max' => 'Số điện thoại phải đủ 10 chữ số',
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $query = User::find(Auth::user()->id)->update([
                'name' => $request->name,
            ]);
            $check = InfoUserModel::query()->where('user_id', Auth::user()->id)->count();
            if ($check == 0) {
                $info_user = InfoUserModel::query()->create([
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'date_of_birth' => $request->date_of_birth,
                    'gender' => $request->gender,
                    'user_id' => Auth::user()->id,
                ]);
            } else {
                $info_user = InfoUserModel::query()->where('user_id', Auth::user()->id)->update([
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'date_of_birth' => $request->date_of_birth,
                    'gender' => $request->gender,
                ]);
            }

            $user = User::first();

            $payment = [
                'title' => 'Thông báo xác nhận đặt phòng khách sạn SN',
                'infoCustomer' => 'Họ và tên khách hàng: ' . $user->name . ', Số CMT/CCCD: 0012015230',
                'infoRoom' => 'Số phòng: P101s',
                'time' => 'Thời gian nhận phòng: 2022-08-16, Thời gian trả phòng: 2022-08-18',
                'price' => 'Tổng tiền: 1.000.000, Tiền đã đặt cọc: 200.000',
                'text' => 'Xem chi tiết',
                'url' => url('/superadmin/account'),

            ];
            Notification::send($user, new PaymentNotifycation($payment));

            if (!$query && !$info_user) {
                return response()->json(['status' => 0, 'msg' => 'Lỗi.']);
            } else {
                return response()->json(['status' => 1, 'msg' => 'Sửa thành công.']);
            }
        }
    }
    public function changePassword(Request $request)
    {
        //Validate form

        $validator = \Validator::make($request->all(), [
            'old_pass' => [
                'required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        return $fail(__('Mật khẩu không đúng'));
                    }
                },
                'min:7',
                'max:30'
            ],
            'new_pass' => 'required|min:7|max:30',
            're_new_pass' => 'required|same:new_pass'
        ], [
            'old_pass.required' => 'Nhập mật khẩu hiện tại',
            'old_pass.min' => 'Mật khẩu yêu cầu 8 ký tự trở lên',
            'new_pass.required' => 'Nhập mật khẩu mới',
            'new_pass.min' => 'Mật khẩu yêu cầu 8 ký tự trở lên',
            're_new_pass.required' => 'Xác nhận mật khẩu mới',
            're_new_pass.same' => 'Mật khẩu không khớp với mật khẩu mới'
        ]);
        if (!$validator->passes()) {

            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {

            $update = User::find(Auth::user()->id)->update(['password' => \Hash::make($request->new_pass)]);

            if (!$update) {
                return response()->json(['status' => 0, 'msg' => 'Đổi mật khẩu thất bại']);
            } else {
                return response()->json(['status' => 1, 'msg' => 'Đổi mật khẩu thành công']);
            }
        }
    }

    public function lockOrUnlock($id)
    {
        // xem trạng thái hoạt động của bảng phòng theo id
        $check = DB::table('model_has_roles')->where('model_id', $id)->select('role_id')->first();
        $role = $check->role_id;

        if ($role == 2) {
            $update = DB::table("model_has_roles")
                ->where('model_id', $id)
                ->update([
                    'role_id' => 3,
                ]);
        } else {
            $update = DB::table("model_has_roles")
                ->where('model_id', $id)
                ->update([
                    'role_id' => 2,
                ]);
        }
        $json['code'] = 200;
        echo json_encode($json);
    }
}