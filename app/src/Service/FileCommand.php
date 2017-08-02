<?php

namespace App\src\Service;

use App\Directorie;
use Illuminate\Http\Request;
use App\src\Common\Archivist;
use App\src\Database\DatabaseRepository;

class FileCommand
{	
    private $error = false;

    private $success = true;

    private $databaseRepository;

    function __construct()
    {
        $this->databaseRepository = new DatabaseRepository;
    }
    /**
    *
    * Store a directory
    * @param request
    */
    public function store($name, $pathName)
    {
        if(file_exists($pathName)) 
        {
            return $this->error;
        }

        if(!mkdir($pathName, 0777)) 
        {
            return $this->error;
        }

        $this->databaseRepository->storeDirectorie($name, $pathName);

        return $this->success;
    }


    /**
    *
    * Delete a directory/file
    * @param request
    */
    public function delete($name, $pathName, $type)
    {
        if(!file_exists($pathName)) 
        {
            return $this->error;
        }

        switch ($type) 
        {
            case 'directory':
                $this->deleteDirectory($pathName, $name);
                break;
            case 'file':
                $this->deleteFile($pathName);
                break;
        }

        return $this->success;
    }


    /**
    *
    * Delete a directory
    * @param pathName
    * @param name
    */
    private function deleteDirectory($pathName, $name)
    {
        $archivist   = new Archivist($pathName);

        if(!$archivist->isEmpty())
        {
            return $this->error;
        }

        if(!rmdir($pathName))
        {
            return $this->error;
        }
        
        $this->databaseRepository->deleteDirectorie($name);
    }

    /**
    *
    * Delete a file
    * @param pathName
    */
    private function deleteFile($pathName)
    {
        if(!unlink($pathName))
        {
            return $this->error;
        }

        return $this->success;
    }
   

    /**
    *
    * Upload a file
    * @param request
    */
    public function upload($file, $pathName)
    {	
        if($file == null) 
        {
            return $this->error;
        }

        $realPath = substr($pathName, 37);
        $name     = $file->getClientOriginalName();
        $file->storeAs($realPath, $name);

        return $this->success;
    }

}