<?php

namespace Deployer;

use Deployer\Host\Localhost;
use Deployer\Task\Context;

require_once __DIR__ . '/resolve_cli_arguments.php';

/**
 * Upload file or directory to host
 * Unlike deployer's upload function, the parameters for rsync correct are escaped here to support relative paths
 * for the SSH config and keys.
 *
 * @param string $source
 * @param string $destination
 * @param array  $config
 *
 * @throws Exception\Exception
 */
function rsyncUpload($source, $destination, array $config = []): void
{
    $rsync = Deployer::get()->rsync;
    $host = Context::get()->getHost();
    $source = parse($source);
    $destination = parse($destination);

    if ($host instanceof Localhost) {
        $rsync->call($host->getHostname(), $source, $destination, $config);
    } else {
        if (!isset($config['options']) || !is_array($config['options'])) {
            $config['options'] = [];
        }

        $sshArguments = resolveCliArguments($host->getSshArguments()->getCliArguments());
        if (empty($sshArguments) === false) {
            $config['options'][] = "-e 'ssh $sshArguments'";
        }

        if ($host->has("become")) {
            $config['options'][]  = "--rsync-path='sudo -H -u " . $host->get('become') . " rsync'";
        }

        $rsync->call($host->getHostname(), $source, "$host:$destination", $config);
    }
}