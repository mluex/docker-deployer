<?php

namespace Deployer;

/**
 * Expand leading tilde (~) symbol in given path.
 * @author Anton Medvedev <anton@medv.io>
 */
function parse_home_dir(string $path): string
{
    if ('~' === $path || 0 === strpos($path, '~/')) {
        if (isset($_SERVER['HOME'])) {
            $home = $_SERVER['HOME'];
        } elseif (isset($_SERVER['HOMEDRIVE'], $_SERVER['HOMEPATH'])) {
            $home = $_SERVER['HOMEDRIVE'] . $_SERVER['HOMEPATH'];
        } else {
            return $path;
        }

        return $home . substr($path, 1);
    }

    return $path;
}
