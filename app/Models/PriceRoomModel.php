<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceRoomModel extends Model
{
    public $timestamps = false;
    protected $fillable = [
        "first_hour", "next_hour", "id_type_room", "status"
    ];

    protected $primaryKey = "id_price_room";
    protected $table = "price_room";
    public function type_room()
    {
        return $this->belongsTo(TypeRoomModel::class, "id_type_room");
    }
}