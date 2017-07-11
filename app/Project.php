<?php

namespace App;

use App\SubProjects;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
    * @param $table, nombre de la tabla de la base de datos
    */
    protected $table = 'projects';

    /**
    * @param $primaryKey, nombre del id de la tabla de la base de datos
    */
    protected $primaryKey = 'id_project';
    
    /**
    * @param $timestamps, especifica si se requiere fechas en la tabla.
    */
    public	$timestamps	=	false;
}
