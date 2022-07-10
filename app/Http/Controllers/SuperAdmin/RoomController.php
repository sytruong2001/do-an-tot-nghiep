<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {

        return view('super-admin.view_rooms', [
            // 'accounts_user' => $accounts_user,
        ]);
    }
}