<?php

namespace App\Domain;

use App\Directorie;
use Illuminate\Http\Request;
use App\Http\Utils\FileUtils;

class FileManager
{	
    // default path
    public $path = '/var/www/html/adminsystem/storage/app';

	private $fileUtils;

	/**
	*
	* Contruct that initialize FileUtils
	*/
	function __construct()
	{
		$this->fileUtils = new FileUtils;
	}

    /**
    *
    * Store a directory
    * @param request
    */
    public function store(Request $request)
    {
    	$pathName = $request->path . DIRECTORY_SEPARATOR . $request->name;

    	if(!file_exists($pathName)) 
    	{
    		if(mkdir($pathName)) 
    		{
	    		$this->storeDirectorieDataBase($request->name, $pathName);
    		}
    	}
    }

    /**
    *
    * Store a directory of data base
    * @param request
    */
    private function storeDirectorieDataBase($name, $pathName)
    {
        $directorie = new Directorie;
        $directorie->name = $name;
        $directorie->path = $pathName;
        $directorie->save();
    }

    /**
    *
    * Delete a directory/file
    * @param request
    */
    public function delete(Request $request)
    {
        $pathName = $request->path . DIRECTORY_SEPARATOR . $request->name;

        if(file_exists($pathName)) 
        {
            if ($request->type == 'directory' ) 
            {
                $directories = $this->fileUtils->readDirectories($pathName);
                $files = $this->fileUtils->readFiles($pathName);

                if(count($directories) == 0 && count($files) == 0)
                {
                    if(rmdir($pathName))
                    {
                        $this->deleteDirectorieDataBase($request->name);
                    }
                }
                else
                {

                }
            }
            else if ($request->type == 'file')
            {
                if(unlink($pathName))
                {
                   // Nothing
                }
            }
        }
    }

    /**
    *
    * Delete a directory/file of data base
    * @param request
    */
    private function deleteDirectorieDataBase($name)
    {
        $directorie = Directorie::where('name', $name)->get();
        $mdirectorie = Directorie::find($directorie[0]->id_directorie);
        $mdirectorie->delete();
    }

    /**
    *
    * Upload a directory
    * @param request
    */
    public function upload(Request $request)
    {	
    	$document = $request->file('document');
    	
    	if($document != null) 
    	{
    		$realPath = substr($request->path, 37);
        	$request->document->storeAs($realPath, $document->getClientOriginalName());
		}
    }

    /**
    *
    * Get all directories with path
    * @param $path
    */
    public function getDirectories($path)
    {
        return $this->fileUtils->readDirectories($path);
    }

    /**
    *
    * Get all directories with files
    * @param $path
    */
    public function getFiles($path)
    {
        return $this->fileUtils->readFiles($path);
    }
}