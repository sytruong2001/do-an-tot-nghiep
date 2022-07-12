<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomModel extends Model
{
    public $timestamps = false;
    protected $fillable = [
        "name", "adults", "children", "id_type_room", "status"
    ];

    protected $primaryKey = "id_room";
    protected $table = "rooms";
    public function type_room()
    {
        return $this->belongsTo(TypeRoomModel::class, "id_type_room");
    }
}