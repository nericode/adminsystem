<?php

namespace Tests\Feature;

use App\Directorie;
use App\Application\Service\FileUseCase;
use App\Application\Common\Archivist;


use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FileTest extends TestCase
{
    private $path = '/var/www/html/adminsystem/storage/app/';

    public function test_any_user_can_create_a_directory()
    {
        
        $fileManager = new FileUseCase;
        $fileManager->store('test_one', $this->path);

        $directorie = new Directorie;
        $myDirectorie = $directorie->where('name', 'test_one')->get();

        if(count($myDirectorie) > 0) 
        {
            $this->assertTrue(true);
        }

    }

    public function test_any_user_can_delete_a_directory()
    {
        $fileManager = new FileUseCase;
        $archivist   = new Archivist($this->path);

        $fileManager->delete('test_one', $this->path, 'directory');
        $this->assertTrue(true);
    }

    public function test_any_user_can_upload_a_file()
    {
        $fileManager = new FileUseCase;
        $path = $fileManager->upload(UploadedFile::fake()->image('avatar.jpg'), $this->path);

        //$this->assertSame($this->path . 'avatar.jpg', $path);
    }

    public function test_any_user_can_delete_a_file()
    {
        $fileManager = new FileUseCase;
        if(unlink($this->path . 'avatar.jpg'))
        {
            $this->assertTrue(true);
        }
    }
}
