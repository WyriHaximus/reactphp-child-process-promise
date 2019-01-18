<?php

namespace WyriHaximus\React\Tests;

use Evenement\EventEmitter;
use Phake;
use React\EventLoop\Factory;
use WyriHaximus\React\ProcessOutcome;

class FunctionsTest extends \PHPUnit_Framework_TestCase
{
    public function testChildProcessPromise()
    {
        $loop = Factory::create();
        $process = Phake::partialMock('React\ChildProcess\Process', [
            'uptime',
        ]);
        $process->stderr = new ReadableStreamStub();
        $process->stdout = new ReadableStreamStub();
        Phake::when($process)->start($loop)->thenReturnCallback(function () use ($process, $loop) {
            \WyriHaximus\React\futurePromise($loop, $process)->then(function ($process) {
                $process->stderr->emit('data', ['abc']);
                $process->stdout->emit('data', ['def']);
                $process->emit('exit', [123]);
            });
        });

        $called = false;
        \WyriHaximus\React\childProcessPromise($loop, $process)->done(function ($result) use (&$called) {
            //$this->assertEquals(new ProcessOutcome(123, 'abc', 'def'), $result);
            $this->assertSame(123, $result->getExitCode());
            $this->assertSame('abc', $result->getStderr());
            $this->assertSame('def', $result->getStdout());
            $called = true;
        });
        $loop->run();
        $this->assertTrue($called);
    }
}