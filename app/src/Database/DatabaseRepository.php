<?php

namespace App\src\Database;

use App\File;

class DatabaseRepository
{
	/**
    *
    * Store a directory in data base
    * @param request
    */
    public function storeDirectorie($name, $pathName)
    {
        $file       = new File;
        $file->name = $name;
        $file->path = $pathName;
        $file->date_created = date('Y-m-d H:m:s');
        $file->type = 'directorie';
        $file->user_created = 'default';
        $file->save();
    }

     /**
    *
    * Delete a directory of data base
    * @param request
    */
    public function deleteDirectorie($name)
    {
        $file  = File::where('name', $name)->get();
        $mfile = File::find($file[0]->id_file);
        $mfile->delete();
    }
}