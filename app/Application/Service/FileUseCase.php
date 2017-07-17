<?php

namespace App\Application\Service;

use App\Directorie;
use Illuminate\Http\Request;
use App\Application\Common\Alert;
use App\Application\Common\Archivist;
use App\Application\Database\DatabaseRepository;

class FileUseCase
{	
    private $error = false;

    private $success = true;

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
            $this->alert->message('Ups!, el directorio con ese nombre ya existe', 'danger');
            return $this->error;
        }

        if(!mkdir($pathName, 0777)) 
        {
            $this->alert->message('Ups!, el directorio no se pudo crear', 'warning');
            return $this->error;
        }

        $this->databaseRepository->storeDirectorie($name, $pathName);
        $this->alert->message('Directorio creado con exito.', 'success');

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
            $this->alert->message('Ups!, hubo un error al intentar eliminar el archivo', 'danger');
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
            $this->alert->message('Ups!, el directorio no esta vacio', 'warning');
            return $this->error;
        }

        if(!rmdir($pathName))
        {
            $this->alert->message('Ups!, el directorio no se pudo eliminar', 'danger');
            return $this->error;
        }
        
        $this->databaseRepository->deleteDirectorie($name);
        $this->alert->message('Directorio eliminado.', 'success');
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
            $this->alert->message('Ups!, hubo un error al intentar elmininar el archivo', 'danger');
            return $this->error;
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
            $this->alert->message('Ups!, necesitas cargar un archivo', 'danger');
            return $this->error;
        }

        $realPath = substr($pathName, 37);
        $name     = $file->getClientOriginalName();
        $file->storeAs($realPath, $name);
        $this->alert->message('Archivo subido con exito', 'success');

        return $this->success;
    }

}