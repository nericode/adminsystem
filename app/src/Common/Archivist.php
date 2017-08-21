<?php

namespace App\src\Common;

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

	/** Get all directories into archivist */
    public function getDirectories()
    {
        return $this->getAllDirectories($this->path, 'directory');
    }

    /** Get all files into archivist */
    public function getFiles()
    {
        return $this->getAllFiles($this->path, 'file');
    }

    /** Get an array of all names and path names of a path */
    public function getPaths()
    {   
        $paths     = array();
        $realPaths = array();
        $addPath   = "";

        $realPath  = substr($this->path, 40);
        $paths     = explode("\\", $realPath);


        foreach ($paths as $currentPath)
        {
            if($currentPath != "")
            {
                $addPath .= $currentPath . DIRECTORY_SEPARATOR;
                $realPaths[] = [
                    'pathName' => $this->defaultPath . $addPath,
                    'name' => $currentPath,
                ];
            }
        }

        return $realPaths;
    }

    /** 
    * Get all data(files/directory) 
    * @param $path
    * @param $type
    * @return an array with all directories
    */
    private function getAllDirectories($rootPath = '', $type = '')
    {
        $directories        = array();
        $openDirectory      = opendir($rootPath);
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
                switch ($type) 
                {
                    case 'directory':
                        if(is_dir($rootPath . DIRECTORY_SEPARATOR . $read) &&
                            file_exists($rootPath . DIRECTORY_SEPARATOR . $read)) 
                        {   
                            $directories[] = $read;
                        }
                    break;
                }
            }       
        }

        return $directories;
    }

     /** 
    * Get all data(files/directory) 
    * @param $path
    * @param $type
    * @return an array with all files
    */
    private function getAllFiles($rootPath = '', $type = '')
    {
        $files              = array();
        $openDirectory      = opendir($rootPath);
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
                switch ($type) 
                {
                    case 'file':
                        if(is_file($rootPath . DIRECTORY_SEPARATOR . $read) &&
                            file_exists($rootPath . DIRECTORY_SEPARATOR . $read)) 
                        {
                            $files[] = $read;
                        }
                    break;
                }
            }       
        }

        return $files;
    }

    /** Valid if the archivist is empty */
    public function isEmpty()
    {
        if (count($this->getDirectories()) == 0 && count($this->getFiles()) == 0) 
        {
            return true;
        }

        return false;
    }
}