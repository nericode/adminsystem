<?php

namespace App\Http\Controllers;

use App\Directorie;
use Illuminate\Http\Request;
use App\Application\Common\Alert;
use App\Http\Requests\FileRequest;
use App\Application\Common\Archivist;
use App\Application\Service\FileUseCase;

class FileController extends Controller
{
    private $fileManager;

    private $alert;

    /**
    * default path
    */
    public $path = '/var/www/html/adminsystem/storage/app/';

    /**
    *
    * Contruct that initialize FileUseCase
    */
    function __construct()
    {
        $this->fileUseCase = new FileUseCase();
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
    	$this->fileUseCase->store($request->name, $pathName);

    	return $this->showView($request->path);
    }

    /**
    * delete a directory/file and show view
    * @return view
    */
    public function delete(Request $request)
    {
        $pathName = $request->path . DIRECTORY_SEPARATOR . $request->name;
    	$this->fileUseCase->delete($request->name, $pathName, $request->type);

    	return $this->showView($request->path);
    }

    /**
    * Upload a file and show view
    * @return view
    */
    public function upload(Request $request)
    {	
        $file = $request->file('file');
        $this->fileUseCase->upload($file, $request->path);

        return $this->showView($request->path);
        
    }

    /**
    * Download a file
    * @return download
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