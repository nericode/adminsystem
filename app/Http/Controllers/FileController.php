<?php

namespace App\Http\Controllers;

use App\Directorie;
use Illuminate\Http\Request;
use App\Application\Common\Archivist;
use App\Application\Service\FileManager;

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
        $pathName = $request->path . DIRECTORY_SEPARATOR . $request->name;
    	$this->fileManager->store($request->name, $pathName);

    	return $this->showView($request->path);
    }

    /**
    * delete a directory/file and show view
    * @return view
    */
    public function delete(Request $request)
    {
        $pathName = $request->path . DIRECTORY_SEPARATOR . $request->name;
    	$this->fileManager->delete($request->name, $pathName, $request->type);

    	return $this->showView($request->path);
    }

    /**
    * Upload a file and show view
    * @return view
    */
    public function upload(Request $request)
    {	
        $file = $request->file('file');
        $this->fileManager->upload($file, $request->path);

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
        $archivist   = new Archivist($path);

        $directories = $archivist->directories();
        $files       = $archivist->files();
        $paths       = $archivist->paths();

        return view('file.home')
        ->with('directories', $directories)
        ->with('path', $path)
        ->with('files', $files)
        ->with('paths', $paths);
    }

}