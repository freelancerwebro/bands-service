<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

final class ExcelImportDto
{
    public function __construct(
        //#[Assert\NotBlank]
        #[Assert\File(
            maxSize: '2048k',
            mimeTypes: [
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ],
            extensions: ['xls', 'xlsx'],
            extensionsMessage: 'Please upload a valid xls/xlsx file.'
        )]
        public ?File $file = null,
    ) {
    }
}