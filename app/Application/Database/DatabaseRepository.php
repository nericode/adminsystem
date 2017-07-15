<?php

namespace App\Application\Database;

use App\File;
use App\Directorie;

class DatabaseRepository
{
	/**
    *
    * Store a directory in data base
    * @param request
    */
    public function storeDirectorie($name, $pathName)
    {
        $directorie       = new Directorie;
        $directorie->name = $name;
        $directorie->path = $pathName;
        $directorie->save();
    }

     /**
    *
    * Delete a directory of data base
    * @param request
    */
    public function deleteDirectorie($name)
    {
        $directorie  = Directorie::where('name', $name)->get();
        $mdirectorie = Directorie::find($directorie[0]->id_directorie);
        $mdirectorie->delete();
    }
}