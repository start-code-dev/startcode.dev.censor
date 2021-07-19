<?php

declare(strict_types=1);

namespace Startcode\Censor;

use Startcode\Censor\Exceptions\InvalidCensorMarkException;

class CensorMark
{

    private string $value;

    /**
     * @throws InvalidCensorMarkException
     */
    public function __construct(string $value)
    {
        $validValues = ['*', '_', 'x', '-'];
        if (!in_array($value, $validValues, true)) {
            throw new InvalidCensorMarkException($value, json_encode($validValues));
        }
        $this->value = $value;
    }

    public function __toString() : string
    {
        return $this->value;
    }

}
