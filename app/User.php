<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class User extends Model
{
    static public function getUsers() {
        $users =  DB::table('user')->get();
        
        return $users;
    }
}
