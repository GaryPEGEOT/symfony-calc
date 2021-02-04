<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CalculationQuery
{
    public const OPERATION_PATTERN = '/^[0-9+\-\/*\s().]+$/';

    #[Assert\NotBlank]
    #[Assert\Regex(pattern: self::OPERATION_PATTERN)]
    #[Assert\ExpressionLanguageSyntax()]
    public string $operation = '';
}
