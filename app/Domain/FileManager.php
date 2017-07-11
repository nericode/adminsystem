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
    * Open a directory
    * @param request
    */
	public function open(Request $request)
    {
    	$this->path = $request->path . DIRECTORY_SEPARATOR . $request->name;
    }

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
    	
    	$this->path = $request->path;
    }

    private function storeDirectorieDataBase($name, $pathName)
    {
        $directorie = new Directorie;
        $directorie->name = $name;
        $directorie->path = $pathName;
        $directorie->save();
    }

    public function delete(Request $request)
    {
        $pathName = $request->path . DIRECTORY_SEPARATOR . $request->name;

        if ($request->type == 'directory' ) 
        {
            $directories = $this->fileUtils->readDirectories($pathName);

            if(count($directories) == 0)
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
    		
    	$this->path = $request->path;
    }

    private function deleteDirectorieDataBase($name)
    {
        $directorie = Directorie::where('name', $name)->get();
        $mdirectorie = Directorie::find($directorie[0]->id_directorie);
        $mdirectorie->delete();
    }

    public function upload(Request $request)
    {	
    	$documentFile = $request->file('document');
    	
    	if($documentFile != null) 
    	{
    		$document = $documentFile;
    		$realPath = substr($request->path, 37);
        	$request->document->storeAs($realPath, $document->getClientOriginalName());
		}
        
        $this->path = $request->path;

    }

    public function getDirectories()
    {
        return $this->fileUtils->readDirectories($this->path);
    }

    public function getFiles()
    {
        return $this->fileUtils->readFiles($this->path);
    }
}