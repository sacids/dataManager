/**
 * Created by Godluck Akyoo on 2/23/2016.
 */

$(document).ready(function () {

    $("a.delete").click(function (e) {

        var confirmDelete = confirm("Are you sure you want to delete?");

        if (confirmDelete) {
            return true;
        } else {
            e.preventDefault();
        }

    });
});
