<?php

namespace App\Domain;

use App\File;
use App\Directorie;
use Illuminate\Http\Request;
use App\Http\Utils\FileUtils;

class FileManager
{	
    /**
    *
    * Store a directory
    * @param request
    */
    public function store(Request $request)
    {
    	$pathName = $request->path . DIRECTORY_SEPARATOR . $request->name;

    	if(!file_exists($pathName)) 
    	{
    		if(mkdir($pathName)) 
    		{
	    		$this->storeDirectorieDataBase($request->name, $pathName);
    		}
    	}
    }

    /**
    *
    * Store a directory of data base
    * @param request
    */
    private function storeDirectorieDataBase($name, $pathName)
    {
        $directorie = new Directorie;
        $directorie->name = $name;
        $directorie->path = $pathName;
        $directorie->save();
    }

    /**
    *
    * Delete a directory/file
    * @param request
    */
    public function delete(Request $request)
    {
        $pathName = $request->path . DIRECTORY_SEPARATOR . $request->name;

        if(file_exists($pathName)) 
        {
            if ($request->type == 'directory' ) 
            {
                $fileUtils = new FileUtils;

                $directories = $fileUtils->getDirectories($pathName);
                $files = $fileUtils->getFiles($pathName);

                if(count($directories) == 0 && count($files) == 0)
                {
                    if(rmdir($pathName))
                    {
                        $this->deleteDirectorieDataBase($request->name);
                    }
                }
            }
            else if ($request->type == 'file')
            {
                if(unlink($pathName))
                {
                   // Nothing
                }
            }
        }
    }

    /**
    *
    * Delete a directory of data base
    * @param request
    */
    private function deleteDirectorieDataBase($name)
    {
        $directorie = Directorie::where('name', $name)->get();
        $mdirectorie = Directorie::find($directorie[0]->id_directorie);
        $mdirectorie->delete();
    }

    /**
    *
    * Upload a file
    * @param request
    */
    public function upload(Request $request)
    {	
    	$file = $request->file('file');
    	
        if($file != null) 
        {
        	$realPath = substr($request->path, 37);
            $name = $file->getClientOriginalName();
        	$request->file->storeAs($realPath, $name);

            //$this->storeFileDataBase($name, $realPath);
        }
    }

    /**
    *
    * Store a file of data base
    * @param request
    */
    private function storeFileDataBase($name, $pathName)
    {
        $file = new File;
        $file->name = $name;
        $file->path = $pathName;
        $file->id_directorie = 1; // Change ID for ID dinamically
        $file->save();
    }

}