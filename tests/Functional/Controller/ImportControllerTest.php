<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

class ImportControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    private const BASE_PATH = __DIR__.'/../../_files/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function test_valid_excel_file_upload()
    {
        $filePath = self::BASE_PATH.'valid.xlsx';

        $this->client->request('POST', '/import', [], [
            'file' => new UploadedFile(
                $filePath,
                'valid.xlsx',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                null,
                true
            ),
        ]);

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Excel import was successfully executed!']),
            $response->getContent()
        );
    }

    public function test_invalid_file_upload()
    {
        $filePath = self::BASE_PATH.'invalidFile.txt';

        $this->client->request('POST', '/import', [], [
            'file' => new UploadedFile(
                $filePath,
                'invalidFile.txt',
                'text/plain',
                null,
                true
            ),
        ]);

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
        $this->assertStringContainsString('Please upload a valid Excel', $response->getContent());
    }

    public function test_empty_file_upload()
    {
        $this->client->request('POST', '/import', [], []);

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertStringContainsString('No file uploaded', $response->getContent());
    }
}
