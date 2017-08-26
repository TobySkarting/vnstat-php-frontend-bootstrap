<?php
/**
 * Created by PhpStorm.
 * User: cvium
 * Date: 26-08-2017
 * Time: 13:10
 */

require 'config.php';

header('Refresh: 1');
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

$current_iface = isset($_GET['if']) ? $_GET['if'] : $iface_list[0];

// Make sure we don't open ourselves up to bad things
if (in_array($current_iface, $iface_list)) {
    $rx1 = @file_get_contents("/sys/class/net/" . $current_iface . "/statistics/rx_bytes");
    $tx1 = @file_get_contents("/sys/class/net/" . $current_iface . "/statistics/tx_bytes");
    sleep(1);
    $rx2 = @file_get_contents("/sys/class/net/" . $current_iface . "/statistics/rx_bytes");
    $tx2 = @file_get_contents("/sys/class/net/" . $current_iface . "/statistics/tx_bytes");
    print  trim($rx1) . ',' . trim($tx1) . ";" . trim($rx2) . ',' . trim($tx2);
}