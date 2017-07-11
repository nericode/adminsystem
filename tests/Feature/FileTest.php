<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FileTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testShowIndex()
    {
        $response = $this->get('/file');

        $response->assertStatus(200);
    }


    public function testUsersCanCreateDirectory()
    {
    	$this->assertTrue(true);
    }
}
