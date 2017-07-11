<?php

namespace App\Http\Utils;

class FileUtils
{

    /**
    * Read all children directory 
    * @param $path
    * @return array
    */
	public function readDirectories($rootPath)
    {
    	return $this->getData($rootPath, 'directorie');;
    }

    public function readFiles($rootPath) 
    {
        return $this->getData($rootPath, 'file');
    }

    private function getData($rootPath = '', $type = '')
    {
        // Open directory
        if($directory = opendir($rootPath)) 
        { 
            $array = array();
            $invisibleFileNames = array(".", "..", ".gitignore", "public");

            // Read files into directory
            while($files = readdir($directory)) 
            {     
                // Match with invisible files
                if(!in_array($files, $invisibleFileNames)) 
                {
                    // Validation if file, and add a array
                    if ($type == 'file') {
                        if(is_file($rootPath . DIRECTORY_SEPARATOR . $files) &&
                            file_exists($rootPath . DIRECTORY_SEPARATOR . $files)) 
                        {
                            $array[] = $files;
                        }
                    }
                     // Validation if direcotorie, and add a array
                    else if ($type == 'directorie') 
                    {
                        if(is_dir($rootPath . DIRECTORY_SEPARATOR . $files) &&
                            file_exists($rootPath . DIRECTORY_SEPARATOR . $files)) 
                        {   
                            $array[] = $files;
                        }
                    }
                }       
            }
        }

        return $array;
    }

}