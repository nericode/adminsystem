<?php

namespace App\Http\Controllers;

use App\Domain\FileManager;
use Illuminate\Http\Request;
use App\Http\Utils\FileUtils;

class FileController extends Controller
{
    private $fileManager;

    /**
    * default path
    */
    public $path = '/var/www/html/adminsystem/storage/app';

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
    	return $this->showView($this->path);
    }

    /**
    * open a directory and show view
    * @return view
    */
    public function open(Request $request)
    {   
        return $this->showView($request->path);
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
    * Upload a file and show view
    * @return view
    */
    public function upload(Request $request)
    {	
        $this->fileManager->upload($request);
        return $this->showView($request->path);
        
    }

    /**
    * Download a file
    * @return view
    */
    public function download(Request $request)
    {   
        return response()->download($request->path);
    }


    /**
    * Show a view
    * @return view
    */
    public function showView($path = '')
    {
        $fileUtils = new FileUtils;

        $directories = $fileUtils->getDirectories($path);
        $files = $fileUtils->getFiles($path);
        $paths = $fileUtils->getPaths($path);

        return view('file.home')->with('directories', $directories)
        ->with('path', $path)->with('files', $files)->with('paths', $paths);
    }

}