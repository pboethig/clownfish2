<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TemplatesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetAll()
    {
        $response = $this->get('/api/templates');

        $templateList = $response->json();

        $response->assertStatus(200);

        $this->assertArrayHasKey('id', $templateList[0]);
        $this->assertArrayHasKey('name', $templateList[0]);
        $this->assertArrayHasKey('user_id', $templateList[0]);
        $this->assertArrayHasKey('project_id', $templateList[0]);
        $this->assertArrayHasKey('groups', $templateList[0]);
        $this->assertArrayHasKey('file_path', $templateList[0]);
        $this->assertArrayHasKey('file_type', $templateList[0]);
        $this->assertArrayHasKey('is_active', $templateList[0]);
        $this->assertArrayHasKey('import_table', $templateList[0]);
        $this->assertArrayHasKey('export_table', $templateList[0]);
        $this->assertArrayHasKey('adapter_class', $templateList[0]);
        $this->assertArrayHasKey('created_at', $templateList[0]);
        $this->assertArrayHasKey('updated_at', $templateList[0]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetById()
    {

        $response = $this->get('/api/templates');

        $templateList = $response->json();

        $getListResponse = $this->get('/api/templates/'.$templateList[0]['id']);

        $template = $getListResponse->json();

        $response->assertStatus(200);

        $this->assertArrayHasKey('id', $template);
        $this->assertArrayHasKey('name', $template);
        $this->assertArrayHasKey('user_id', $template);
        $this->assertArrayHasKey('project_id', $template);
        $this->assertArrayHasKey('groups', $template);
        $this->assertArrayHasKey('file_path', $template);
        $this->assertArrayHasKey('file_type', $template);
        $this->assertArrayHasKey('is_active', $template);
        $this->assertArrayHasKey('import_table', $template);
        $this->assertArrayHasKey('export_table', $template);
        $this->assertArrayHasKey('adapter_class', $template);
        $this->assertArrayHasKey('created_at', $template);
        $this->assertArrayHasKey('updated_at', $template);

        $this->assertEquals($templateList[0]['id'], $template['id']);

    }
}
