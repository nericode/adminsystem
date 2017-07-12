<?php

namespace App\Application\Common;


class Archivist
{	
	private $defaultPath = '/var/www/html/adminsystem/storage/app';

	private $path;

	function __construct($path)
	{
		$this->path = $path;
	}

	/**
    *
    * Get all directories with path
    * @param $path
    */
    public function directories()
    {
        return $this->getData($this->path, 'directory');
    }

    /**
    *
    * Get all directories with path
    * @param $path
    */
    public function files()
    {
        return $this->getData($this->path, 'file');
    }

    /**
    *
    * Get all path pieces with path
    * @param $path
    */
    public function paths()
    {   
        $addPath   = "";
        $realPaths = array();
        $paths     = array();

        $realPath  = substr($this->path, 37);
        $paths     = explode("/", $realPath);


        foreach ($paths as $mpath)
        {
            $addPath .= $mpath . DIRECTORY_SEPARATOR;
            $realPaths[] = $this->defaultPath . $addPath;
        }

        return $realPaths;
    }

    /**
    *
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
}