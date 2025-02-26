<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelFileValidator
{
    private array $expectedHeaders = ['Name', 'Origin', 'City', 'StartYear', 'SeparationYear', 'Founders', 'Members', 'MusicalCurrent', 'Presentation'];

    public function __construct(
        private readonly ValidatorInterface $validator
    ) { }

    public function validate(UploadedFile $file): array
    {
        $constraints = new Assert\File([
            'maxSize' => '5M',
            'mimeTypes' => [
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
                'application/vnd.ms-excel', // .xls
                'text/csv', // CSV
            ],
            'mimeTypesMessage' => 'Please upload a valid Excel (.xls, .xlsx) or CSV file',
        ]);

        $errors = $this->validator->validate($file, $constraints);

        if (count($errors) > 0) {
            throw new ValidatorException($errors[0]->getMessage(), 400);
        }

        $this->validateStructure($file);

        return [];
    }

    public function validateStructure(UploadedFile $file): void
    {
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [];
        foreach ($sheet->getRowIterator(1, 1) as $row) {
            foreach ($row->getCellIterator() as $cell) {
                if ($cell->getValue() !== null) {
                    $headers[] = $cell->getValue();
                }
            }
        }

        if (count($headers) !== count($this->expectedHeaders)) {
            throw new ValidatorException('Invalid Excel structure. Expected headers: ' . implode(', ', $this->expectedHeaders));
        }

        // Validate row data
        foreach ($sheet->getRowIterator(2) as $row) { // Start from row 2 (skip headers)
            $rowData = [];
            foreach ($row->getCellIterator() as $cell) {
                $rowData[] = ($cell->getValue() !== null) ? $cell->getValue() : null;
            }

            if (!empty($rowData[3]) && !filter_var($rowData[3], FILTER_VALIDATE_INT)) {
                throw new ValidatorException('Invalid StartYear on row: ' . $row->getRowIndex());
            }

            if (!empty($rowData[4]) && !filter_var($rowData[4], FILTER_VALIDATE_INT)) {
                throw new ValidatorException('Invalid SeparationYear on row: ' . $row->getRowIndex() . ', value:' . $rowData[4]);
            }
        }
    }
}
