<?php

declare(strict_types=1);

namespace App\Tests\Integration\Validator;

use App\Validator\ExcelFileValidator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ExcelFileValidatorTest extends KernelTestCase
{
    private ExcelFileValidator $excelFileValidator;

    private const BASE_PATH = __DIR__.'/../../_files/';

    protected function setUp(): void
    {
        self::bootKernel();
        $validator = static::getContainer()->get(ValidatorInterface::class);
        $this->excelFileValidator = new ExcelFileValidator($validator);
    }

    public function test_valid_excel_file()
    {
        $file = new UploadedFile(self::BASE_PATH.'valid.xlsx', 'valid.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', null, true);

        $errors = $this->excelFileValidator->validate($file);

        $this->assertEmpty($errors, 'Valid Excel/CSV file should pass validation.');
    }

    public function test_invalid_file_type()
    {
        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessage('Please upload a valid Excel (.xls, .xlsx) or CSV file');

        $file = new UploadedFile(self::BASE_PATH.'invalidFile.txt', 'invalidFile.txt', 'text/plain', null, true);

        $this->excelFileValidator->validate($file);
    }

    public function test_invalid_file_size()
    {
        $this->expectException(ValidatorException::class);

        $file = new UploadedFile(self::BASE_PATH.'invalidFileSize.csv', 'invalidFileSize.csv', 'text/csv', null, true);

        $this->excelFileValidator->validate($file);
    }

    public function test_invalid_file_structure()
    {
        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessage('Invalid Excel structure. Expected headers: Name, Origin, City, StartYear, SeparationYear, Founders, Members, MusicalCurrent, Presentation');

        $file = new UploadedFile(self::BASE_PATH.'invalidFileStructure.csv', 'invalidFileStructure.csv', 'text/csv', null, true);

        $this->excelFileValidator->validate($file);
    }
}
