<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CheckInModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class checkoutApi extends Controller
{
    public function getinfo($id)
    {
        $get_checkin = CheckInModel::query()->where('id_checkin_room', $id)->get();
        // $type_room = DB::table('type_room')->get();
        $json['checkin'] = $get_checkin;
        // $json['type'] = $type_room;
        echo json_encode($json);
    }
}