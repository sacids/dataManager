<div class="flex flex-row justify-between">
    <div class="flex flex-row text-sm text-gray-900">
        <div>
            <a data-id="<?= $form_data->id; ?>" form-id="<?= $form->form_id; ?>" id="btn-data-preview" class="px-2 py-2 text-gray-600 bg-gray-200 rounded-md hover:text-gray-900 hover:hover:bg-red-100 mr-2">
                Data Preview
            </a>
        </div>

        <div>
            <a instance-id="<?= $form_data->meta_instanceID; ?>" form-id="<?= $form->form_id; ?>" id="btn-chat" class="px-2 py-2 text-gray-600 bg-gray-200 rounded-md hover:text-gray-900 hover:hover:bg-red-100 mr-2">
                Chats
            </a>
        </div>

        <div>
            <a class="px-2 py-2 text-gray-600 bg-gray-200 rounded-md hover:text-gray-900 hover:hover:bg-red-100">
                Location
            </a>
        </div>
    </div>

    <div class="">
        <a id="close-offcanvas" class="text-red-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </a>
    </div>
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