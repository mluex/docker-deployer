<?php

namespace Deployer;

use Deployer\Host\Localhost;
use Deployer\Task\Context;

require_once __DIR__ . '/parse_home_dir.php';

function resolveCliArguments(string $arguments): string
{
    return preg_replace_callback(
        '/(\s)(~\/.+?)(\s)/',
        function($matches) {
            return $matches[1] . parse_home_dir($matches[2]) . $matches[3];
        },
        $arguments
    );
}