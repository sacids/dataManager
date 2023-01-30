<div class="text-sm text-center text-gray-900">
    <ul class="flex flex-wrap border-b-2 border-white">
        <li class="">
            <a data-id="<?= $form_data->id; ?>" form-id="<?= $form->form_id; ?>" id="btn-data-preview" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                Data Preview
            </a>
        </li>

        <li class="">
            <a instance-id="<?= $form_data->meta_instanceID; ?>" form-id="<?= $form->form_id; ?>" id="btn-chat" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                Chats
            </a>
        </li>

        <li class="">
            <a class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                Location
            </a>
        </li>

        <li class="">
            <a id="close-offcanvas" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                Close
            </a>
        </li>
    </ul>
</div>

<script>
    $(document).ready(function() {
        //close canvas
        $(document).on('click', '#close-offcanvas', function(event) {
            $('#offcanvas-wrp').animate({
                width: "hide"
            });
        });

        //data preview
        $(document).on('click', '#btn-data-preview', function(event) {
            event.preventDefault();

            $('#offcanvas-wrp').animate({
                width: "show"
            });

            var formId = $(this).attr('form-id');
            var dataId = $(this).attr('data-id');
            var url = window.location.origin + '/feedback/form_data_preview/' + formId + '/' + dataId;

            var jqXHR = $.ajax({
                type: "GET",
                url: url,
            }).done(function(data) {
                //offcanvas
                $('#offcanvas-wrp').html(data);

            }).fail(function(jqXHR, textStatus, errorThrown) {
                alert('Failed to update progress');
                if (console && console.log) {
                    console.log("Loading Ajax: " + textStatus + ", " + errorThrown);
                }
            });

        });

        //chating preview
        $(document).on('click', '#btn-chat', function(event) {
            event.preventDefault();

            $('#offcanvas-wrp').animate({
                width: "show"
            });

            var formId = $(this).attr('form-id');
            var instanceId = $(this).attr('instance-id');
            var url = window.location.origin + '/feedback/chats/' + formId + '/' + instanceId;

            var jqXHR = $.ajax({
                type: "GET",
                url: url,
            }).done(function(data) {
                //offcanvas
                $('#offcanvas-wrp').html(data);

            }).fail(function(jqXHR, textStatus, errorThrown) {
                alert('Failed to update progress');
                if (console && console.log) {
                    console.log("Loading Ajax: " + textStatus + ", " + errorThrown);
                }
            });
        });



    });
</script>