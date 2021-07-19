<?php

declare(strict_types=1);

namespace Startcode\Censor\Exceptions;

class InvalidCensorMarkException extends \Exception
{

    public function __construct(string $value, string $validValues)
    {
        parent::__construct(
            sprintf('Invalid censor mark %s, valid values are %s', $value, $validValues),
            6001
        );
    }

}
