<?php

namespace WyriHaximus\React\Tests;

use Evenement\EventEmitterTrait;
use React\Stream\ReadableStreamInterface;
use React\Stream\WritableStreamInterface;

final class ReadableStreamStub implements ReadableStreamInterface
{
    use EventEmitterTrait;

    public function isReadable()
    {
        // TODO: Implement isReadable() method.
    }

    public function pause()
    {
        // TODO: Implement pause() method.
    }

    public function resume()
    {
        // TODO: Implement resume() method.
    }

    public function pipe(WritableStreamInterface $dest, array $options = array())
    {
        // TODO: Implement pipe() method.
    }

    public function close()
    {
        // TODO: Implement close() method.
    }
}