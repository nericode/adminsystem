<?php

namespace App\Http\Controllers;

use App\Domain\FileManager;
use Illuminate\Http\Request;


class FileController extends Controller
{
	private $fileManager;
	

	/**
	*
	* Contruct that initialize FileManager
	*/
	function __construct()
	{
		$this->fileManager = new FileManager();
	}

	/**
	* Show a index page
	* @return view
	*/
    public function index()
    {
    	return $this->showView($this->fileManager->path);
    }

    /**
    * open a directory and show view
    * @return view
    */
    public function open(Request $request)
    {
    	$this->fileManager->open($request);
        return $this->showView($request->path . DIRECTORY_SEPARATOR . $request->name);
    }

    /**
    * store a directory and show view
    * @return view
    */
    public function store(Request $request)
    {
    	$this->fileManager->store($request);
    	return $this->showView($request->path);
    }

    /**
    * delete a directory/file and show view
    * @return view
    */
    public function delete(Request $request)
    {
    	$this->fileManager->delete($request);
    	return $this->showView($request->path);
    }

    /**
    * upload a file and show view
    * @return view
    */
    public function upload(Request $request)
    {	
        $this->fileManager->upload($request);
        return $this->showView($request->path);
        
    }

    /**
    * Show a view
    * @return view
    */
    public function showView($path = '')
    {
        $directories = $this->fileManager->getDirectories();
        $files = $this->fileManager->getFiles();

        return view('file.home')->with('directories', $directories)
        ->with('path', $path)->with('files', $files);
    }

}