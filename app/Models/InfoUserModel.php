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
        'region',
        'birth_of_date',
    ];
    protected $table    = 'info_user';
    public $timestamps  = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}