<?php

namespace App\Application\Service;

use App\File;
use App\Directorie;
use Illuminate\Http\Request;
use App\Application\Common\Alert;
use App\Application\Common\Archivist;
use App\Application\Database\DatabaseRepository;

class FileUseCase
{	
    private $alert;

    private $databaseRepository;

    function __construct()
    {
        $this->alert              = new Alert;
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
            $this->alert->message('Ups!, el directorio con ese nombre ya existe.', 'danger');
            return true;
        }

        if(mkdir($pathName, 0777)) 
        {
            $this->databaseRepository->storeDirectorie($name, $pathName);
            $this->alert->message('Directorio creado con exito.', 'success');
        }
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
            $this->alert->message('Ups!, hubo un error', 'danger');
            return true;
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
    }


    /**
    *
    * Delete a directory
    * @param pathName
    * @param name
    */
    public function deleteDirectory($pathName, $name)
    {
        $archivist   = new Archivist($pathName);
        if(!$archivist->isEmpty())
        {
            $this->alert->message('Ups!, el directorio no esta vacio', 'warning');
            return true;
        }

        if(rmdir($pathName))
        {
            $this->databaseRepository->deleteDirectorie($name);
            $this->alert->message('Directorio eliminado.', 'success');
        }
    }

    /**
    *
    * Delete a file
    * @param pathName
    */
    public function deleteFile($pathName)
    {
        if(!unlink($pathName))
        {
            $this->alert->message('Ups!, hubo un error', 'danger');
        }

        $this->alert->message('Archivo eliminado con exito', 'success');
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
            $this->alert->message('Ups!, hubo un error', 'danger');
            return true;
        }

        $realPath = substr($pathName, 37);
        $name     = $file->getClientOriginalName();
        $file->storeAs($realPath, $name);
        $this->alert->message('Archivo subido con exito', 'success');
    }


    /**
    *
    * Store a file in data base
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