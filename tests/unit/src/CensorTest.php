<?php

use PHPUnit\Framework\TestCase;
use Startcode\Censor\Censor;

class CensorTest extends TestCase
{

    public function testCensor() : void
    {
        $aCensor = (new Censor(['very', 'bad']))
            ->setCensorMark('*')
            ->censor('some very bad string');

        $this->assertEquals('some very bad string', $aCensor->getOriginalString());
        $this->assertEquals('some **** *** string', $aCensor->getCleanedString());
        $this->assertTrue($aCensor->isCensoredString());
        $this->assertEquals(['very', 'bad'], $aCensor->getForbiddenMatches());
    }

    public function testCensorSpecific1() : void
    {
        $aCensor = (new Censor(['very', 'bad']))
            ->setCensorMark('*')
            ->censor('some very baÐ string');

        $this->assertEquals('some very baÐ string', $aCensor->getOriginalString());
        $this->assertEquals('some **** **** string', $aCensor->getCleanedString());
        $this->assertTrue($aCensor->isCensoredString());
        $this->assertEquals(['very', 'baÐ'], $aCensor->getForbiddenMatches());
    }

    public function testCensorSpecific2() : void
    {
        $aCensor = (new Censor(['very', 'bad']))
            ->setCensorMark('*')
            ->censor('some very bÂd string');

        $this->assertEquals('some very bÂd string', $aCensor->getOriginalString());
        $this->assertEquals('some **** **** string', $aCensor->getCleanedString());
        $this->assertTrue($aCensor->isCensoredString());
        $this->assertEquals(['very', 'bÂd'], $aCensor->getForbiddenMatches());
    }

    public function testCensorSpecific3() : void
    {
        $aCensor = (new Censor(['very', 'bad']))
            ->setCensorMark('*')
            ->censor('some very 8ad string');

        $this->assertEquals('some very 8ad string', $aCensor->getOriginalString());
        $this->assertEquals('some **** *** string', $aCensor->getCleanedString());
        $this->assertTrue($aCensor->isCensoredString());
        $this->assertEquals(['very', '8ad'], $aCensor->getForbiddenMatches());
    }

    public function testCensorDifferentCensorMark() : void
    {
        $aCensor = (new Censor(['very', 'bad']))
            ->setCensorMark('-')
            ->censor('some very bad string');

        $this->assertEquals('some very bad string', $aCensor->getOriginalString());
        $this->assertEquals('some ---- --- string', $aCensor->getCleanedString());
        $this->assertTrue($aCensor->isCensoredString());
        $this->assertEquals(['very', 'bad'], $aCensor->getForbiddenMatches());
    }

    public function testCensorIfNoWordsFound() : void
    {
        $aCensor = (new Censor(['very', 'bad']))
            ->setCensorMark('*')
            ->censor('some good string');

        $this->assertEquals('some good string', $aCensor->getOriginalString());
        $this->assertEquals('some good string', $aCensor->getCleanedString());
        $this->assertFalse($aCensor->isCensoredString());
        $this->assertEquals([], $aCensor->getForbiddenMatches());
    }

    public function testCensorIfNoWordsSet() : void
    {
        $aCensor = (new Censor([]))
            ->setCensorMark('*')
            ->censor('some good string');

        $this->assertEquals('some good string', $aCensor->getOriginalString());
        $this->assertEquals('some good string', $aCensor->getCleanedString());
        $this->assertFalse($aCensor->isCensoredString());
        $this->assertEquals([], $aCensor->getForbiddenMatches());
    }

    public function testCensorIfStringNotSet() : void
    {
        $aCensor = (new Censor([]))
            ->setCensorMark('*');

        $this->assertEquals('', $aCensor->getOriginalString());
        $this->assertEquals('', $aCensor->getCleanedString());
        $this->assertFalse($aCensor->isCensoredString());
        $this->assertEquals([], $aCensor->getForbiddenMatches());
    }

}
