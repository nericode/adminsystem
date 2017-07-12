<?php

namespace Tests\Feature;

use App\Application\Service\FileManager;
use App\Application\Common\Archivist;


use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FileTest extends TestCase
{
    private $path = '/var/www/html/adminsystem/storage/app';

    public function test_show_index()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_a_user_can_create_a_directory()
    {
        $fileManager = new FileManager;
        $fileManager->store('test_one', $this->path);

        $archivist = new Archivist($this->path);
        $paths     = $archivist->paths();

        foreach ($paths as $mpath) {
            if ($mpath == 'test_one') {
                $this->assertTrue(true);
            }
        }
    }

    public function test_a_user_can_delete_a_directory()
    {
        $fileManager = new FileManager;
        $fileManager->delete('test_one', $this->path, 'directory');

    }

    public function test_a_user_can_upload_a_file()
    {
        $fileManager = new FileManager;
        $fileManager->upload(UploadedFile::fake()->image('avatar.jpg'), $this->path);
    }

    public function test_a_user_can_delete_a_file()
    {
        $fileManager = new FileManager;
        $fileManager->upload(UploadedFile::fake()->image('avatar.jpg'), $this->path, 'file');
    }
}
