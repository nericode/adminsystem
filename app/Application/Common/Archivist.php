<?php

namespace App\Application\Common;


class Archivist
{	
	public $defaultPath = '/var/www/html/adminsystem/storage/app/';

	private $path;

	function __construct($path)
	{
		$this->path = $path;
	}

	/** Get all directories into archivist */
    public function directories()
    {
        return $this->getData($this->path, 'directory');
    }

    /** Get all files into archivist */
    public function files()
    {
        return $this->getData($this->path, 'file');
    }

    /** Get an array of all names and path names of a path */
    public function paths()
    {   
        $addPath   = "";
        $realPaths = array();
        $paths     = array();

        $realPath  = substr($this->path, 38);
        $paths     = explode("/", $realPath);


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
    */
    private function getData($rootPath = '', $type = '')
    {
        // Open directory
        if($directory = opendir($rootPath)) 
        { 
            $array = array();
            $invisibleFileNames = array(".", "..", ".gitignore", "public");

            // Read files/directory into directory
            while($archivist = readdir($directory)) 
            {     
                // Match with invisible files
                if(!in_array($archivist, $invisibleFileNames)) 
                {
                    switch ($type) 
                    {
                        case 'file':
                            if(is_file($rootPath . DIRECTORY_SEPARATOR . $archivist) &&
                                file_exists($rootPath . DIRECTORY_SEPARATOR . $archivist)) 
                            {
                                $array[] = $archivist;
                            }
                        break;

                        case 'directory':
                            if(is_dir($rootPath . DIRECTORY_SEPARATOR . $archivist) &&
                                file_exists($rootPath . DIRECTORY_SEPARATOR . $archivist)) 
                            {   
                                $array[] = $archivist;
                            }
                        break;
                    }
                }       
            }
        }

        return $array;
    }

    /** Valid if the archivist is empty */
    public function isEmpty()
    {
        if (count($this->directories()) == 0 && count($this->files()) == 0) 
        {
            return true;
        }

        return false;
    }
}