<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class BandControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function test_list_band(): void
    {
        $this->client->request('GET', '/band');
        $response = $this->client->getResponse();

        $this->assertResponseIsSuccessful();
        $content = $response->getContent();

        $this->assertJson($content);
        $this->assertJsonStringEqualsJsonString(
            '[]',
            $content
        );
    }

    public function test_create_band(): int
    {
        $this->client->request('POST', '/band', [], [], [], json_encode([
            'name' => 'The band',
            'origin' => 'USA',
            'city' => 'New York',
            'startYear' => 2002,
            'founders' => 'John Doe',
            'members' => 2,
            'presentation' => 'test',
        ]));
        $response = $this->client->getResponse();

        $this->assertSame($response->getStatusCode(), Response::HTTP_CREATED);
        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('id', $data);

        return $data['id'];
    }

    /**
     * @depends test_create_band
     */
    public function test_get_band($bandId)
    {
        $this->client->request('GET', "/band/$bandId");
        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $data = json_decode($response->getContent(), true);

        $this->assertEquals('The band', $data['name']);
        $this->assertEquals('USA', $data['origin']);
        $this->assertEquals('New York', $data['city']);
        $this->assertEquals(2002, $data['startYear']);
        $this->assertEquals('John Doe', $data['founders']);
        $this->assertEquals(2, $data['members']);
        $this->assertEquals('test', $data['presentation']);
    }

    /**
     * @depends test_create_band
     */
    public function test_update_band($bandId)
    {
        $this->client->request(
            'PUT',
            "/band/$bandId",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'name' => 'Updated Band',
                'origin' => 'UK',
                'city' => 'London',
            ])
        );

        $response = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $this->client->request('GET', "/band/$bandId");
        $response = $this->client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertEquals('Updated Band', $data['name']);
        $this->assertEquals('UK', $data['origin']);
        $this->assertEquals('London', $data['city']);
    }

    /**
     * @depends test_create_band
     */
    public function test_delete_band($bandId)
    {
        $this->client->request('DELETE', "/band/$bandId");
        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());

        // Verify deletion
        $this->client->request('GET', "/band/$bandId");
        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function test_delete_nonexistent_band()
    {
        $this->client->request('DELETE', '/band/100');
        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertStringContainsString('object not found', $response->getContent());
    }

    public function test_get_nonexistent_band()
    {
        $this->client->request('GET', '/band/100');
        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertStringContainsString('object not found', $response->getContent());
    }

    public function test_update_nonexistent_band()
    {
        $this->client->request(
            'PUT',
            '/band/100',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'name' => 'Updated Band',
                'origin' => 'UK',
                'city' => 'London',
            ])
        );

        $response = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertStringContainsString('Band not found', $response->getContent());
    }

    public function test_get_nonexistent_url()
    {
        $this->client->request('GET', '/non-existent-url');
        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertStringContainsString('No route found', $response->getContent());
    }
}
