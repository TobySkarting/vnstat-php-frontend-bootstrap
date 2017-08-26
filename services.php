<?php
/**
 * Created by PhpStorm.
 * User: cvium
 * Date: 26-08-2017
 * Time: 17:20
 */

require_once 'config.php';

// Shamelessly stolen from QuickBox
function processExists($processName) {
    $exists= false;
    exec("ps axo user:20,pid,pcpu,pmem,vsz,rss,tty,stat,start,time,comm|grep -iE $processName | grep -v grep", $pids);
    if (count($pids) > 0) {
        $exists = true;
    }
    return $exists;
}

foreach($service_list as $service) {
    print '<tr>';
    print '<td class="service">' . $service . '</td>';
    print '<td class="status">' . (processExists($service) ? 'UP' : 'DOWN') . '</td>';
    print '</tr>';
}

