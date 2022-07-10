<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class typeRoomController extends Controller
{
    public function index()
    {
        $data = DB::table('type_room')->get();
        return view('super-admin.view_type_room', [
            'type_room' => $data,
            'index' => 1,
        ]);
    }
}