<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoUserModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'date_of_birth',
        'gender',
    ];
    protected $table    = 'info_user';
    public $timestamps  = false;

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
}