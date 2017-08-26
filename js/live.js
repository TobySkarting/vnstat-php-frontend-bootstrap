/**
 * Created by cvium on 26-08-2017.
 */

function poll() {
    $.ajax({url: "live.php", success: function(result) {
        addLiveDataToDom(result);
    }});
}

function formatBytes(bytes,decimals) {
    if(bytes == 0) return '0 Bytes';
    var k = 1024,
        dm = decimals || 2,
        sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
        i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

function addLiveDataToDom(result) {
    var results = result.split(";");
    var res1 = results[0].split(",");
    var res2 = results[1].split(",");
    var rx = formatBytes(res2[0] - res1[0]);
    var tx = formatBytes(res2[1] - res1[1]);
    $("#download").text("Download: " + rx + "/s");
    $("#upload").text("Upload: " + tx + "/s");
}

// Start polling
$(document).ready(setInterval(poll, 3000));