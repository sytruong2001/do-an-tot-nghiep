<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeRoomModel extends Model
{
    public $timestamps = false;
    protected $fillable = [
        "name", "status",
    ];

    protected $primaryKey = "id_type_room";
    protected $table = "type_room";
    public function room()
    {
        return $this->hasMany(RoomModel::class, "id_type_room");
    }
    public function price_room()
    {
        return $this->hasOne(PriceRoomModel::class, "id_type_room");
    }
}