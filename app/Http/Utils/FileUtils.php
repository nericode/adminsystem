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
        // Open directory
    	if($directory = opendir($rootPath)) 
    	{ 
    		$directories = array();
            $invisibleFileNames = array(".", "..", "public");

            // Read files into directory
	    	while($files = readdir($directory)) 
	    	{     
                // Whether not match with invisible files, 
                // verify thay are directory
                if(!in_array($files, $invisibleFileNames)) 
                {
                    // Validation if directory, and add a array
                    if(is_dir($rootPath . DIRECTORY_SEPARATOR . $files) &&
                       file_exists($rootPath . DIRECTORY_SEPARATOR . $files)) 
                    {
                        $directories[] = $files;
                    }
                } 		
	    	}
    	}

    	return $directories;
    }

    public function readFiles($rootPath) 
    {
        // Open directory
        if($directory = opendir($rootPath)) 
        { 
            $files = array();
            $invisibleFileNames = array(".", "..", ".gitignore");

            // Read files into directory
            while($mfiles = readdir($directory)) 
            {     
                // Match with invisible files
                if(!in_array($mfiles, $invisibleFileNames)) 
                {
                    // Validation if directory, and add a array
                    if(is_file($rootPath . DIRECTORY_SEPARATOR . $mfiles) &&
                       file_exists($rootPath . DIRECTORY_SEPARATOR . $mfiles)) 
                    {
                        $files[] = $mfiles;
                    }

                }       
            }
        }

        return $files;

    }

}