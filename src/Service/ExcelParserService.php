<?php

declare(strict_types=1);

namespace App\Service;

use App\Factory\BandFactory;
use App\Repository\BandRepository;
use PhpOffice\PhpSpreadsheet\IOFactory;

readonly class ExcelParserService implements ParserServiceInterface
{
    public function __construct(
        private BandRepository $bandRepository,
    ) {
    }

    public function parse(string $filename): void
    {
        $spreadsheet = IOFactory::load($filename);
        $spreadsheet = $spreadsheet->getActiveSheet();
        $dataArray =  $spreadsheet->toArray();
        array_shift($dataArray);

        foreach ($dataArray as $key => $row) {
            $this->saveOneRow($row);
        }
    }

    private function saveOneRow(array $row): void
    {
        $band = BandFactory::createOne([
            'name' => $row[0],
            'origin' => $row[1],
            'city' => $row[2],
            'startYear' => $row[3],
            'separationYear' => $row[4],
            'founders' => $row[5],
            'members' => $row[6],
            'musicalCurrent' => $row[7],
            'presentation' => $row[8],
        ]);

        $this->bandRepository->save($band->object());
    }
}