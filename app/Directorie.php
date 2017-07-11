<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Directorie extends Model
{
    /**
    * @param $table, nombre de la tabla de la base de datos
    */
    protected $table = 'directories';

    /**
    * @param $primaryKey, nombre del id de la tabla de la base de datos
    */
    protected $primaryKey = 'id_directorie';
    
    /**
    * @param $timestamps, especifica si se requiere fechas en la tabla.
    */
    public	$timestamps	=	false;
}
