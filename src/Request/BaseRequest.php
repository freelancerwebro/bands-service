<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseRequest
{
    public function __construct(protected ValidatorInterface $validator)
    {
    }

    public function validate(): ConstraintViolationListInterface
    {
        return $this->validator->validate($this);
    }
}