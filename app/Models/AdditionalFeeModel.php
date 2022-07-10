<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalFeeModel extends Model
{
    public $timestamps = false;
    protected $fillable = [
        "name", "amount", "price", "id_checkin_room"
    ];

    protected $primaryKey = "id_additional_fee";
    protected $table = "additional_fee";
    public function checkin()
    {
        return $this->belongsTo(CheckInModel::class, "id_checkin_room");
    }
}