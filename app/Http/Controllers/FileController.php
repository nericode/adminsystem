<?php

namespace App\Http\Controllers;

use App\Directorie;
use Illuminate\Http\Request;
use App\Http\Requests\FileRequest;
use Illuminate\Support\Facades\Auth;


use App\src\Common\Alert;
use App\src\Common\Archivist;
use App\src\Service\FileCommand;

class FileController extends Controller
{
    private $fileCommand;

    /**
    *
    * Contruct that initialize FileUseCase
    */
    function __construct()
    {
        $this->middleware('auth');
        $this->fileCommand = new FileCommand();
    }

    /**
    * Show a index page
    * @return view
    */
    public function index()
    {
        return $this->showView(Archivist::getDefaultPath());
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
    public function showView($path = "")
    {
        $archivist   = new Archivist($path);

        $files       = $archivist->getAllFiles();
        $paths       = $archivist->getPaths();

        return view('file.home')
        ->with('path', $path)
        ->with('files', $files)
        ->with('paths', $paths);
    }


}
