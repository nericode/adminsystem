<?php

namespace App\Http\Controllers;

use App\Directorie;
use App\Http\Requests\FileRequest;
use Illuminate\Http\Request;

use App\src\Common\Alert;
use App\src\Common\Archivist;
use App\src\Service\FileCommand;

class FileController extends Controller
{
<<<<<<< HEAD
    private $fileManager;

    private $alert;

    /**
    * default path
    */
    public $path = 'C:\xampp\htdocs\adminsystem\storage\app\\';
    //public $path = '/var/www/html/adminsystem/storage/app/';
=======
    private $fileCommand;
>>>>>>> 32d1fb9d17323a9db77a08568bb46fcc6af93776

    /**
    *
    * Contruct that initialize FileUseCase
    */
    function __construct()
    {   
        $this->fileCommand = new FileCommand();
    }

    /**
    * Show a index page
    * @return view
    */
    public function index()
    {
        return $this->showView('/var/www/html/adminsystem/storage/app/');
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
    	$this->fileCommand->store($request->name, $pathName);

    	return $this->showView($request->path);
    }

    /**
    * delete a directory/file and show view
    * @return view
    */
    public function delete(Request $request)
    {
        $pathName = $request->path . DIRECTORY_SEPARATOR . $request->name;
    	$this->fileCommand->delete($request->name, $pathName, $request->type);

    	return $this->showView($request->path);
    }

    /**
    * Upload a file and show view
    * @return view
    */
    public function upload(Request $request)
    {	
        $file = $request->file('file');
        $this->fileCommand->upload($file, $request->path);

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

        $directories = $archivist->getDirectories();
        $files       = $archivist->getFiles();
        $paths       = $archivist->getPaths();

        return view('file.home')
        ->with('directories', $directories)
        ->with('path', $path)
        ->with('files', $files)
        ->with('paths', $paths);
    }

}