<?php

namespace WyriHaximus\React\Tests;

use WyriHaximus\React\ProcessOutcome;
use PHPUnit\Framework\TestCase;

class ProcessOutcomeTest extends TestCase
{
    public function testBasic()
    {
        $outcome = new ProcessOutcome(123, 'abc', 'def');
        $this->assertSame(123, $outcome->getExitCode());
        $this->assertSame('abc', $outcome->getStderr());
        $this->assertSame('def', $outcome->getStdout());
    }
}