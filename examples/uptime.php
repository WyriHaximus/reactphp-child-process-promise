<?php

use React\ChildProcess\Process;
use React\EventLoop\Factory;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';


$loop = Factory::create();

\WyriHaximus\React\childProcessPromise($loop, new Process('uptime'))->then(function ($result) {
    var_export($result);
});

$loop->run();
