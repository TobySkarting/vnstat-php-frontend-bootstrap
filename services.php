<?php
/**
 * Created by PhpStorm.
 * User: cvium
 * Date: 26-08-2017
 * Time: 17:20
 */

require 'config.php';

$username = getUser();
function processExists($processName, $username) {
    $exists= false;
    exec("ps axo user:20,pid,pcpu,pmem,vsz,rss,tty,stat,start,time,comm|grep $username | grep -iE $processName | grep -v grep", $pids);
    if (count($pids) > 0) {
        $exists = true;
    }
    return $exists;
}

$services = [];
foreach($service_list as $service) {
    $services[] = '<div class="service">' . $service . ': ' . (processExists($service) ? 'UP' : 'DOWN') . '</div>';
}