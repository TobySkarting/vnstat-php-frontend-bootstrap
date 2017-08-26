/**
 * Created by cvium on 26-08-2017.
 */

function updateServiceStatus() {
    $.ajax({url: 'services.php', success: function(result) {
        $('.services-tablebody').html(result);
    }});
}

$(document).ready(function() {
    updateServiceStatus();
    setInterval(updateServiceStatus, 3000);
});