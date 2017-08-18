<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    /**
    * @param $table, nombre de la tabla de la base de datos
    */
    protected $table = 'users';

    /**
    * @param $primaryKey, nombre del id de la tabla de la base de datos
    */
    protected $primaryKey = 'id_user';
    
    /**
    * @param $timestamps, especifica si se requiere fechas en la tabla.
    */
    public	$timestamps = false;

    /**
    * Find if one user exists
    * @param $userID is user 
    * @param $password 
    * @return boolean
    */
    public static function exists($userID, $password)
    {
        $user  = Users::where('user_id', $userID)->where('password', $password)->get();

        if(count($user) > 0) 
        {
            return true;
        }

        return false;
    }
}
