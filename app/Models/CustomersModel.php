<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomersModel extends Model
{
    public $timestamps = false;
    protected $fillable = [
        "name", "identify_numb", "id_checkin_room"
    ];

    protected $primaryKey = "id_customer";
    protected $table = "customer";
    public function checkin()
    {
        return $this->belongsTo(CheckInModel::class, "id_checkin_room");
    }
}