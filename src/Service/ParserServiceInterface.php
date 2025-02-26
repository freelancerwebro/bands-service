<?php

declare(strict_types=1);

namespace App\Service;

interface ParserServiceInterface
{
    public function parse(string $filename): void;
}
