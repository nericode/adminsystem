<?php

namespace App\Application\Service;

use App\File;
use App\Directorie;
use Illuminate\Http\Request;
use App\Application\Common\Archivist;

class FileManager
{	
    /**
    *
    * Store a directory
    * @param request
    */
    public function store($name, $pathName)
    {
    	if(!file_exists($pathName)) 
    	{
    		if(mkdir($pathName)) 
    		{
	    		$this->storeDirectorieDataBase($name, $pathName);
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
        $directorie       = new Directorie;
        $directorie->name = $name;
        $directorie->path = $pathName;
        $directorie->save();
    }

    /**
    *
    * Delete a directory/file
    * @param request
    */
    public function delete($name, $pathName, $type)
    {
        if(file_exists($pathName)) 
        {
            switch ($type) 
            {
                case 'directory':
                    $archivist   = new Archivist($pathName);
                    $directories = $archivist->directories();
                    $files       = $archivist->files();

                    if(count($directories) == 0 && count($files) == 0)
                    {
                        if(rmdir($pathName))
                        {
                            $this->deleteDirectorieDataBase($name);
                        }
                    }
                break;
                
                case 'file':
                    if(unlink($pathName))
                    {
                       // Notification deleted file
                    }
                break;
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
        $directorie  = Directorie::where('name', $name)->get();
        $mdirectorie = Directorie::find($directorie[0]->id_directorie);
        $mdirectorie->delete();
    }

    /**
    *
    * Upload a file
    * @param request
    */
    public function upload($file, $path)
    {	
        if($file != null) 
        {
        	$realPath = substr($path, 37);
            $name     = $file->getClientOriginalName();
        	$file->storeAs($realPath, $name);

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
        $file                = new File;
        $file->name          = $name;
        $file->path          = $pathName;
        $file->id_directorie = 1; // Change ID for ID dinamically
        $file->save();
    }

}