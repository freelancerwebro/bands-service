<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;
class ImportExcelRequest
{
    #[Assert\NotBlank]
    #[Assert\File(
        maxSize: '2048k',
        mimeTypes: [
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ],
        extensions: ['xls', 'xlsx'],
        extensionsMessage: 'Please upload a valid xls/xlsx file.'
    )]
    public $file = null;
}