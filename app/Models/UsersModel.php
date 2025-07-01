<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersModel extends Model
{
    protected $table = "users";
    protected $fillable = ['id','username','name','email','password','phone','role','photo_profile'];
}
