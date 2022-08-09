<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckInModel extends Model
{
    public $timestamps = false;
    protected $fillable = [
        "time_start", "time_end", "id_room", "deposit", "status",
    ];

    protected $primaryKey = "id_checkin_room";
    protected $table = "checkin";

    public function additional_fee()
    {
        return $this->hasMany(AdditionalFeeModel::class, "id_checkin_room");
    }
    public function checkout()
    {
        return $this->hasOne(CheckOutModel::class, "id_checkin_room");
    }
    public function customer()
    {
        return $this->hasMany(CustomersModel::class, "id_checkin_room");
    }
    public function service()
    {
        return $this->hasMany(ServicesModel::class, "id_checkin_room");
    }
}