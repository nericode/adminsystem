<?php

namespace App\src\Database;

use App\File;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        
        $file->name = $name;
        $file->path = $pathName;
        $file->type = 'directory';
        $file->user_created = $user->name;
        $file->date_created = date('Y-m-d H:m:s');
        
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
        $mfile = File::find($file[0]->id);
        $mfile->delete();
    }
}