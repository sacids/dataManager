/**
 * Created by Renfrid-Sacids on 4/18/2016.
 */
// JavaScript Document
function submitdata() {
    var message  = document.getElementById("message").value;
    var instance_id  = document.getElementById("instance_id").value;
    // Returns successful data submission message when the entered information is stored in database.
    var dataString = 'message=' + message + 'instance_id=' + instance_id;
    if (message == '') {
        alert("Feedback message should not be empty");
        exit;
    }
    else {
        // AJAX code to submit form.
        $.ajax({
            type: "POST",
            url: "<?= base_url();?>feedback/submit_feedback",
            data: dataString,
            cache: false,
            success: function(html) {
                alert(html);
            }
        });
    }
    return false;
}

