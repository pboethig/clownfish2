<?php

namespace Tests\Feature;

use App\Models\Template;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TemplatesTest extends TestCase
{

    use DatabaseTransactions;

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


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreate()
    {

        $template=
            [
                'id'=>  null,
                'name'=>  'functionaltest',
                'user_id'=>  1,
                'project_id'=>  1,
                'file_path'=>  '/filepath',
                'file_type'=>  '/xlsx',
                'is_active'=>  true,
                'import_table'=>  'import_table',
                'export_table'=>  'export_table',
                'adapter_class'=>  'adapter_class',
            ];

        $response = $this->post( '/api/templates', $template);

        $response->assertStatus(201);

        $response = $this->delete( '/api/templates/'.$response->json()['id'], []);

        $response->assertStatus(200);

    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUpdate()
    {


        $template=
            [
                'id'=>  null,
                'name'=>  'functionaltest',
                'user_id'=>  1,
                'project_id'=>  1,
                'file_path'=>  '/filepath',
                'file_type'=>  '/xlsx',
                'is_active'=>  true,
                'import_table'=>  'import_table',
                'export_table'=>  'export_table',
                'adapter_class'=>  'adapter_class',
            ];

        $response = $this->post( '/api/templates', $template);

        $data = $response->json();

        $template=
            [
                'id'=>  $data['id'],
                'name'=>  'functionaltestUpdate',
                'user_id'=>  1,
                'project_id'=>  1,
                'file_path'=>  '/filepath',
                'file_type'=>  '/xlsx',
                'is_active'=>  true,
                'import_table'=>  'import_table',
                'export_table'=>  'export_table',
                'adapter_class'=>  'adapter_class',
            ];

        $response = $this->put( '/api/templates/'.$template['id'], $template);

        $data = $response->json();

        $this->assertEquals($data['name'], $template['name']);

        $getResponse = $this->get('/api/templates/'.$data['id']);

        $data = $getResponse->json();

        $data['name']="anothername";

        $response = $this->put( '/api/templates/'.$data['id'], $data);

        $this->assertEquals($data['name'], $response->json()['name']);

        $response->assertStatus(200);
    }
}
