<?php

namespace App\Tests\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BandControllerTest extends WebTestCase
{
    public function testBandsList(): void
    {
        $client = static::createClient();
        $client->request('GET', '/band');
        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        $content = $response->getContent();

        $this->assertJson($content);
        $this->assertJsonStringEqualsJsonString(
            '[]',
            $content
        );
    }

    public function testBandCreate(): void
    {
        $client = static::createClient();
        $client->request('POST', '/band', [], [], [], json_encode([
            'name' => 'The band',
            'origin' => 'USA',
            'city' => 'New York',
            'startYear' => 2002,
            'founders' => 'John Doe',
            'members' => 2,
            'presentation' => 'test'
        ]));
        $response = $client->getResponse();

        $this->assertSame($response->getStatusCode(), 201);
    }
}
