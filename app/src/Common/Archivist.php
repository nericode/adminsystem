<?php

namespace App\src\Common;

use App\File;
use App\src\Exception\NotOpenDirectory;

class Archivist
{	
    public $defaultPath = 'C:\xampp\htdocs\adminsystem\storage\app\\';
	//public $defaultPath = '/var/www/html/adminsystem/storage/app/';

	private $path;

	function __construct($path)
	{
        $this->path = $path;
	}

    /** Get an array of all names and path names of a path */
    public function getPaths()
    {   
        $paths     = array();
        $realPaths = array();
        $addPath   = "";

        $realPath  = substr($this->path, 39);
        $paths     = explode("\\", $realPath);


        foreach ($paths as $currentPath)
        {
            if($currentPath != "")
            {
                $addPath .= $currentPath . DIRECTORY_SEPARATOR;
                $realPaths[] = [
                    'pathName' => $this->defaultPath . $addPath,
                    'name' => $currentPath
                ];
            }
        }

        return $realPaths;
    }

     /** 
    * Get all data(files/directory) 
    * @return an array with all files
    */
    public function getAllFiles()
    {
        $files              = array();
        $openDirectory      = opendir($this->path);
        $invisibleFileNames = array(".", "..", ".gitignore", "public");
        //$readDirectory = readdir($directory);

        // Open directory
        if(!$openDirectory) 
        { 
            throw new NotOpenDirectory("No se pudeo abrir el directorio");
        }
       
        // Read files/directory into directory
        while($read = readdir($openDirectory)) 
        {     
            // Match with invisible files
            if(!in_array($read, $invisibleFileNames)) 
            {
                $file  = File::where('name', $read)->get();
                $mfile = File::find($file[0]->id); 

                if(is_file($this->path . DIRECTORY_SEPARATOR . $read) &&
                    file_exists($this->path . DIRECTORY_SEPARATOR . $read)) 
                {
                    $files[] = [
                        'name' => $read,
                        'type' => $mfile->type,
                        'user' => $mfile->user_created,
                        'filemtime' => $mfile->date_created
                    ];
                }
                else if(is_dir($this->path . DIRECTORY_SEPARATOR . $read) &&
                    file_exists($this->path . DIRECTORY_SEPARATOR . $read)) 
                {   
                    $files[] = [
                        'name' => $read,
                        'type' => $mfile->type,
                        'user' => $mfile->user_created,
                        'filemtime' => $mfile->date_created
                    ];
                }
            }       
        }

        return $files;
    }

    /** Valid if the archivist is empty */
    public function isEmpty()
    {
        if (count($this->getAllFiles()) == 0) 
        {
            return true;
        }

        return false;
    }
}