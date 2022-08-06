<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomModel;
use Illuminate\Http\Request;

class checkinController extends Controller
{
    public function index()
    {
        $data = RoomModel::query()
            ->where('status', 0)
            ->get();
        return view('admin.view_checkin', ['rooms' => $data]);
    }
}