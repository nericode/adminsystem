<?php

namespace App\src\Common;

use App\File;
use App\src\Exception\NotOpenDirectory;

class Archivist
{
	private $path;

	function __construct($path)
	{
        $this->path = $path;
	}

    /** Get an array of all values path
    * Example: Path: c:/htdocs/adminsystem/storage/myFolder
    * the values his, name: myFolder and pathName: c:/htdocs/adminsystem/storage/myFolder
    * it's to that can see the files in view with list.
    * Example of list: > Principal > myFolder > etc > etc ...
    */
    public function getPaths()
    {
        $paths     = array();
        $realPaths = array();
        $addPath   = "";

        $realPath  = substr($this->path, Archivist::getLengthSubsPath());
        $paths     = explode("\\", $realPath);


        foreach ($paths as $currentPath) {
            if($currentPath != "") {
                $addPath .= $currentPath . DIRECTORY_SEPARATOR;
                $realPaths[] = [
                    'pathName' => Archivist::getDefaultPath() . $addPath,
                    'name' => $currentPath
                ];
            }
        }

        return $realPaths;
    }

     /**
    * Get all data(files/directory)
    * @return an array with all files
    */
    public function getAllFiles()
    {
        $files              = array();
        $openDirectory      = opendir($this->path);
        $invisibleFileNames = array(".", "..", ".gitignore", "public");

        // Open directory
        if(!$openDirectory) {
            throw new NotOpenDirectory("No se pudeo abrir el directorio");
        }

        // Read files/directory into directory
        while($read = readdir($openDirectory)) {
            // Match with invisible files
            if(!in_array($read, $invisibleFileNames)) {
                $file  = File::where('name', $read)->get();

                if(count($file) > 0) {
                  $mfile = File::find($file[0]->id);

                  if(is_file($this->path . DIRECTORY_SEPARATOR . $read) &&
                      file_exists($this->path . DIRECTORY_SEPARATOR . $read)) {
                      $files[] = [
                          'name' => $read,
                          'type' => $mfile->type,
                          'user' => $mfile->user_created,
                          'size' => $this->fileSizeConvert(filesize($mfile->path)),
                          'filemtime' => $mfile->date_created
                      ];
                  }
                  else if(is_dir($this->path . DIRECTORY_SEPARATOR . $read) &&
                      file_exists($this->path . DIRECTORY_SEPARATOR . $read)) {
                      $files[] = [
                          'name' => $read,
                          'type' => $mfile->type,
                          'user' => $mfile->user_created,
                          'filemtime' => $mfile->date_created
                      ];
                  }
                }
            }
        }

		// Sort array by type.
		usort($files, array($this, 'orderType'));

        return $files;
    }

	/**
    * Sort array
    * @return integer
    */
    private static function orderType($a, $b)
    {
        return strcmp($a["type"], $b["type"]);
    }

    /** Valid if the archivist it's empty */
    public function isEmpty()
    {
        if (count($this->getAllFiles()) == 0) {
            return true;
        }

        return false;
    }

    /** Get default paht */
    public static function getDefaultPath()
    {
        return getcwd() . '/storage/app';
    }

    /** Get length max for the path by default */
    public static function getLengthSubsPath()
    {
        return 44;
    }

    /**
    * Converts bytes into human readable file size.
    *
    * @param string $bytes
    * @return string human readable file size (2,87 Мб)
    * @author Mogilev Arseny
    */
    private function fileSizeConvert($bytes)
    {
        $bytes = floatval($bytes);
            $arBytes = array(
                0 => array(
                    "UNIT" => "TB",
                    "VALUE" => pow(1024, 4)
                ),
                1 => array(
                    "UNIT" => "GB",
                    "VALUE" => pow(1024, 3)
                ),
                2 => array(
                    "UNIT" => "MB",
                    "VALUE" => pow(1024, 2)
                ),
                3 => array(
                    "UNIT" => "KB",
                    "VALUE" => 1024
                ),
                4 => array(
                    "UNIT" => "B",
                    "VALUE" => 1
                ),
            );

        foreach($arBytes as $arItem) {
            if($bytes >= $arItem["VALUE"]) {
                $result = $bytes / $arItem["VALUE"];
                $result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
                break;
            }
        }
        return $result;
    }
}
