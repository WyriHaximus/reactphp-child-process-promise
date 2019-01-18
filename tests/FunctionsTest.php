<?php

namespace WyriHaximus\React\Tests;

use Prophecy\Argument;
use React\EventLoop\Factory;
use WyriHaximus\React\ProcessOutcome;

class FunctionsTest extends \PHPUnit_Framework_TestCase
{
    public function testChildProcessPromise()
    {
        $loop = Factory::create();
        $process = $this->prophesize('React\ChildProcess\Process');
        $process->stderr = new ReadableStreamStub();
        $process->stdout = new ReadableStreamStub();
        $process->start($loop)->shouldBeCalled();
        /** @var callable $callback */
        $callback = null;
        $process->on('exit', Argument::that(function (callable $cb) use (&$callback) {
            $callback = $cb;
            return true;
        }))->shouldBeCalled();
        \WyriHaximus\React\timedPromise($loop, 1, $process)->then(function ($process) use (&$callback) {
            $process->stderr->emit('data', ['abc']);
            $process->stdout->emit('data', ['def']);
            $process->emit('exit', [123]);
            $callback(123);
        });
        $called = false;
        \WyriHaximus\React\childProcessPromise($loop, $process->reveal())->done(function ($result) use (&$called) {
            $this->assertEquals(new ProcessOutcome(123, 'abc', 'def'), $result);
            $this->assertSame(123, $result->getExitCode());
            $this->assertSame('abc', $result->getStderr());
            $this->assertSame('def', $result->getStdout());
            $called = true;
        });
        $loop->run();
        $this->assertTrue($called);
    }
}