/**
 * Created by cvium on 26-08-2017.
 */

// Shamelessly stolen from QuickBox
function processExists($processName, $username) {
    $exists= false;
    exec("ps axo user:20,pid,pcpu,pmem,vsz,rss,tty,stat,start,time,comm|grep $username | grep -iE $processName | grep -v grep", $pids);
    if (count($pids) > 0) {
        $exists = true;
    }
    return $exists;
}