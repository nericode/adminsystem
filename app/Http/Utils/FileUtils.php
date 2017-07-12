<?php

namespace App\Http\Utils;
    
define('DIRECTORY','directory');
define('FILE','file');

class FileUtils
{

    /**
    * default path
    */
    public $path = '/var/www/html/adminsystem/storage/app';

    /**
    *
    * Get all directories with path
    * @param $path
    */
    public function getDirectories($path)
    {
        return $this->getData($path, DIRECTORY);
    }

    /**
    *
    * Get all directories with path
    * @param $path
    */
    public function getFiles($path)
    {
        return $this->getData($path, FILE);
    }

    /**
    *
    * Get all path pieces with path
    * @param $path
    */
    public function getPaths($path)
    {   
        $addPath = "";
        $realPaths = array();
        $paths = array();

        $realPath = substr($path, 37);
        $paths = explode("/", $realPath);


        foreach ($paths as $mpath)
        {
            $addPath .= $mpath . DIRECTORY_SEPARATOR;
            $realPaths[] = $this->path . $addPath;
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
                        case FILE:
                            if(is_file($rootPath . DIRECTORY_SEPARATOR . $archivist) &&
                                file_exists($rootPath . DIRECTORY_SEPARATOR . $archivist)) 
                            {
                                $array[] = $archivist;
                            }
                        break;

                        case DIRECTORY:
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