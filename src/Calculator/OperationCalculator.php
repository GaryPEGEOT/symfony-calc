<?php

namespace App\Calculator;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class OperationCalculator
{
    public function __construct(private ExpressionLanguage $expressionLanguage)
    {
    }

    public function calculate(string $operation): float
    {
        $result = $this->expressionLanguage->evaluate($operation);

        return (float) $result;
    }
}
