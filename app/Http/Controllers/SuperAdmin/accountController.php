<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\InfoUserModel;
use App\Models\User;
use Illuminate\Http\Request;

class accountController extends Controller
{
    public function index()
    {
        $get_user = User::query()
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('info_user', 'users.id', '=', 'info_user.user_id')
            ->where('model_has_roles.role_id', '=', 2)
            ->get();
        // dd($get_user);
        return view('super-admin.view_accounts', [
            'accounts_user' => $get_user,
            'index' => 1,
        ]);
    }
    public function getInfo($id)
    {
        $check_info_user = InfoUserModel::query()->where('user_id', $id)->count();
        if ($check_info_user == 0) {
            $info = User::query()
                ->where('id', $id)
                ->first();
        } else {
            $info = User::query()
                ->join('info_user', 'users.id', '=', 'info_user.user_id')
                ->where('user_id', $id)
                ->first();
        }

        // dd($info);
        return view('super-admin.view_info', [
            'info' => $info,
        ]);
    }
}