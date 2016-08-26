/**
 * Created by Renfrid-Sacids on 6/2/2016.
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
