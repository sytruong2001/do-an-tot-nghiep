<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckOutModel extends Model
{
    public $timestamps = false;
    protected $fillable = [
        "time_start", "time_end", "id_checkin_room", "sum_price"
    ];

    protected $primaryKey = "id_checkout_room";
    protected $table = "checkout";
    public function checkin()
    {
        return $this->belongsTo(CheckInModel::class, "id_checkin_room");
    }
}