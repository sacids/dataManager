<div class="w-full h-full overflow-hidden">
    <div class="flex w-full justify-between text-sm text-gray-900 p-3 border-b">
        <div class="flex w-full">
            <div>
                <a hx-get="<?= site_url('feedback/form_data_preview/' . $form->form_id . '/' . $form_data->id); ?>" hx-target="#jembe" class="rounded-none px-2 py-2 text-gray-600 bg-gray-200 rounded-md hover:text-gray-900 hover:hover:bg-red-100 mr-2 cursor-pointer">
                    Data Preview
                </a>
            </div>

            <div>
                <a hx-get="<?= site_url('feedback/chats/' . $form->form_id . '/' . $form_data->meta_instanceID); ?>" hx-target="#jembe" class="rounded-none px-2 py-2 text-gray-600 bg-gray-200 rounded-md hover:text-gray-900 hover:hover:bg-red-100 mr-2 cursor-pointer">
                    Chats
                </a>
            </div>

            <div>
                <a hx-get="<?= site_url('feedback/case_info/' . $form->form_id . '/' . $form_data->meta_instanceID); ?>" hx-target="#jembe" class="rounded-none px-2 py-2 text-gray-600 bg-gray-200 rounded-md hover:text-gray-900 hover:hover:bg-red-100 mr-2 cursor-pointer">
                    Notification de cas
                </a>
            </div>
        </div>

        <div class="">
            <a class="text-red-700" @click="sideBarOpen=false">
                <i class="fa-regular fa-circle-xmark text-red-700 fa-lg"></i>
            </a>
        </div>
    </div>

    <div class="h-full w-full overflow-hidden" id="jembe">
        <!-- content -->
        <div class="flex flex-col flex-auto h-full overflow-y-scroll p-3">
            <?php if (isset($mapped_form_data) && $mapped_form_data) { ?>
                <table class="w-full text-sm text-left table-fixed">
                    <tbody class="border-b">
                        <?php foreach ($mapped_form_data as $val) { ?>
                            <tr class="border-b">
                                <td class="px-0 py-4 text-left font-normal text-sm text-gray-600 whitespace-nowrap"><?= $val['label'] ?></td>
                                <td class="px-0 py-4 text-left font-normal text-sm text-gray-600 whitespace-nowrap">
                                    <?php if (preg_match('/(\.jpg|\.png|\.bmp)$/', $val['value'])) {
                                        echo "<img src=' " . base_url() . "assets/forms/data/images/" . $val['value'] . "' style='max-width:100px;' />";
                                    } else {
                                        echo $val['value'];
                                    }?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
    </div>
</div>
<!-- 
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
</script> -->