<?php
/**
 * Created by PhpStorm.
 * User: cvium
 * Date: 26-08-2017
 * Time: 13:10
 */

require 'config.php';

$current_iface = $_GET['if'];

// Make sure we don't open ourselves up to bad things
if (in_array($current_iface, $iface_list)) {
    $rx1 = @file_get_contents("/sys/class/net/" . $current_iface . "/statistics/rx_bytes");
    $tx1 = @file_get_contents("/sys/class/net/" . $current_iface . "/statistics/tx_bytes");
    sleep(1);
    $rx2 = @file_get_contents("/sys/class/net/" . $current_iface . "/statistics/rx_bytes");
    $tx2 = @file_get_contents("/sys/class/net/" . $current_iface . "/statistics/tx_bytes");
    print  $rx1 . ',' . $tx1 . ";" . $rx2 . ',' . $tx2;
}