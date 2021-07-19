<?php

declare(strict_types=1);

namespace Startcode\Censor;

class Censor
{

    private array $forbiddenWords;

    private CensorMark $censorMark;

    private array $censorChecks = [];

    private string $originalString = '';

    private string $cleanedString = '';

    private array $forbiddenMatches = [];

    public function __construct(array $forbiddenWords)
    {
        $this->forbiddenWords = $forbiddenWords;
        $this->censorMark = new CensorMark('*');
    }

    public function setCensorMark(string $censorMarkString) : self
    {
        $this->censorMark = new CensorMark($censorMarkString);
        return $this;
    }

    public function censor(string $string, bool $fullWords = false) : self
    {
        $this->originalString = html_entity_decode($string);
        $this->initCensorChecks($fullWords);

        $counter      = 0;
        $foundMatches = [];
        $this->cleanedString   = preg_replace_callback(
            $this->censorChecks,
            function ($matches) use (&$counter, &$foundMatches) {
                $foundMatches[$counter++] = $matches[0];
                return str_repeat((string) $this->censorMark, strlen($matches[0]));

            },
            $this->originalString
        );
        $this->forbiddenMatches = $foundMatches;

        return $this;
    }

    public function getOriginalString() : string
    {
        return $this->originalString;
    }

    public function getCleanedString(): string
    {
        return $this->cleanedString;
    }

    public function getForbiddenMatches(): array
    {
        return $this->forbiddenMatches;
    }

    public function isCensoredString() : bool
    {
        return count($this->forbiddenMatches) > 0;
    }

    private function initCensorChecks(bool $fullWords = false) : void
    {
        $forbiddenWords = $this->forbiddenWords;

        //TODO add setter for various types of censor checks
        $alphabetRegex = CensorChecks::getAlphabetChecks();

        $censorChecks = [];
        for ($i = 0, $iMax = count($forbiddenWords); $i < $iMax; $i++) {
            $censorChecks[$i] = $fullWords
                ? '/\b' . $this->replace($alphabetRegex, $forbiddenWords[$i]) . '\b/i'
                : '/'   . $this->replace($alphabetRegex, $forbiddenWords[$i]) . '/i';
        }

        $this->censorChecks = $censorChecks;
    }

    private function replace(array $alphabetRegex, $word)
    {
        return str_ireplace(array_keys($alphabetRegex), array_values($alphabetRegex), $word);
    }
    
}
