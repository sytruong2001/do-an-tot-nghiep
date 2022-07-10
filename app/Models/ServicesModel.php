<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicesModel extends Model
{
    public $timestamps = false;
    protected $fillable = [
        "name", "amount", "price", "id_checkin_room"
    ];

    protected $primaryKey = "id_service";
    protected $table = "services";
    public function checkin()
    {
        return $this->belongsTo(CheckInModel::class, "id_checkin_room");
    }
}