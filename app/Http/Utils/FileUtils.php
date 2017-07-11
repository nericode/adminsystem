<?php

namespace App\Http\Utils;
    
define('DIRECTORY','directory');
define('FILE','file');

class FileUtils
{
    /**
    * Read all children directory 
    * @param $path
    * @return array
    */
	public function readDirectories($rootPath)
    {
    	return $this->getData($rootPath, DIRECTORY);;
    }

    public function readFiles($rootPath) 
    {
        return $this->getData($rootPath, FILE);
    }

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