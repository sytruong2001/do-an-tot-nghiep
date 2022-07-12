<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\RoomModel;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $data = RoomModel::query()
            ->with('type_room')
            ->get();

        return view('super-admin.view_rooms', [
            'room' => $data,
            'index' => 1,
        ]);
    }
}