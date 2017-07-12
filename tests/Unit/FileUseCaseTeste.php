<?php

namespace Tests\Unit;

use App\Application\Service\FileManager;
use App\Http\Utils\FileUtils;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FileUseCaseTeste extends TestCase
{
    /**
     * User create directory
     *
     * @return void
     */
    public function test_a_user_can_create_a_directory()
    {
    	$fileManager = new FileManager;
    	$fileManager->store('test_one', '/var/www/html/adminsystem/storage/app');

    	$fileUtils = new FileUtils;
    	$paths = $fileUtils->getPaths($path);

    	foreach ($paths as $path) {
    		if ($path == 'test_one') {
    			$this->assertTrue(true);
    		}
    	}
    }
}
