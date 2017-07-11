<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
    * @param $table, nombre de la tabla de la base de datos
    */
    protected $table = 'files';

    /**
    * @param $primaryKey, nombre del id de la tabla de la base de datos
    */
    protected $primaryKey = 'id_file';
    
    /**
    * @param $timestamps, especifica si se requiere fechas en la tabla.
    */
    public	$timestamps	=	false;
}
