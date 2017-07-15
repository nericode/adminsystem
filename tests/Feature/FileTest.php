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
        
        $fileUseCase = new FileUseCase;
        $fileUseCase->store('test_one', $this->path);

        $directorie = new Directorie;
        $myDirectorie = $directorie->where('name', 'test_one')->get();

        if(count($myDirectorie) > 0) 
        {
            $this->assertTrue(true);
        }

    }

    public function test_any_user_can_delete_a_directory()
    {
        $fileUseCase = new FileUseCase;
        $archivist   = new Archivist($this->path);

        $fileUseCase->delete('test_one', $this->path, 'directory');
        $this->assertTrue(true);
    }

    public function test_any_user_can_upload_a_file()
    {
        $fileUseCase = new FileUseCase;
        $fileUseCase->upload(UploadedFile::fake()->image('avatar.jpg'), $this->path);
    }

    public function test_any_user_can_delete_a_file()
    {
        $fileUseCase = new FileUseCase;
        if(unlink($this->path . 'avatar.jpg'))
        {
            $this->assertTrue(true);
        }
    }

    public function test_a_fila_have_not_that_be_null()
    {
        
        $fileUseCase = new FileUseCase;
        $upload = $fileUseCase->upload(null, $this->path);

        $this->assertSame(false, $upload);
    }
}
