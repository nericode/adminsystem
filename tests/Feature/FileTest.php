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
        $store = $fileUseCase->store('test', $this->path . '/' . 'test');

        $this->assertSame(true, $store);

    }

    public function test_any_user_can_delete_a_directory()
    {
        $fileUseCase = new FileUseCase;
        $delete = $fileUseCase->delete('test',  $this->path . '/' . 'test', 'directory');
        
        $this->assertSame(true, $delete); 
    }

    public function test_any_user_can_upload_a_file()
    {
        $fileUseCase = new FileUseCase;
        $upload = $fileUseCase->upload(UploadedFile::fake()->image('avatar.jpg'), $this->path);

        $this->assertSame(true, $upload);
    }

    public function test_any_user_can_delete_a_file()
    {
        $fileUseCase = new FileUseCase;
        $delete = $fileUseCase->delete('avatar.jpg', $this->path . 'avatar.jpg', 'file');

        $this->assertSame(true, $delete);
    }

    public function test_a_fila_have_not_that_be_null()
    {
        $fileUseCase = new FileUseCase;
        $upload = $fileUseCase->upload(null, $this->path);

        $this->assertSame(false, $upload);
    }
}
