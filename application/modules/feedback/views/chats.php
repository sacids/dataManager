<!-- content -->
<div class="h-full w-full overflow-hidden">
    <div class="h-[calc(100%-280px)] overflow-y-scroll">
        <div class="grid grid-cols-12 gap-y-2 p-3">
            <?php foreach ($feedback as $values) {
                if ($values->sender == "user") {
                    $class_1 = "col-start-1 col-end-8 p-3 rounded-lg";
                    $class_2 = "flex flex-row items-center";
                } else {
                    $class_1 = "col-start-6 col-end-13 p-3 rounded-lg";
                    $class_2 = "flex items-center justify-start flex-row-reverse";
                } ?>

                <div class="<?php echo $class_1; ?>">
                    <div class="<?php echo $class_2; ?>">
                        <div class="relative ml-3 text-sm bg-white py-2 px-4 rounded-xl">
                            <div><?= $values->message ?></div>
                            <div>
                                <?= time_ago($values->date_created); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="col-start-6 col-end-13 p-3 rounded-lg" id="new-message-div" style="display: none;">
                <div class="flex items-center justify-start flex-row-reverse">
                    <div class="relative ml-3 text-sm bg-white py-2 px-4 rounded-xl">
                        <div id="new-message"></div>
                        <div>
                            0 second ago
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="myform" class="border-t" role="form" enctype="multipart/form-data">
        <input type="hidden" name="instance_id" value="<?= $form_data->meta_instanceID; ?>">

        <div class="flex flex-row items-center h-16 rounded-xl bg-white w-full px-4">
            <div>
                <button class="flex items-center justify-center text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                    </svg>
                </button>
            </div>

            <div class="flex-grow ml-4">
                <div class="relative w-full">
                    <input type="text" name="message" id="message" class="bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pl-4 h-12" required />
                    <button class="absolute flex items-center justify-center h-full w-12 right-0 top-0 text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="ml-4">
                <button type="submit" name="submit" class="flex items-center justify-center bg-red-900 hover:bg-red-800 rounded-sm text-white px-5 py-2 flex-shrink-0">
                    <span class="">Send</span>
                    <span class="ml-2">
                        <svg class="w-4 h-4 transform rotate-45 -mt-px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>

                    </span>
                </button>
            </div>
        </div>
    </form>

    <div id="success-messages" class="mx-3"></div>
    <div id="error-messages" class="mx-3"></div>
</div>


<script type="text/javascript">
    $(document).ready(function() {

        //hang on event of form with id=myform
        $("#myform").submit(function(e) {
            e.preventDefault();

            // Activate the loading spinner
            // $('.loading-spinner').toggleClass('active');

            // FormData object 
            var data = new FormData(this);

            //post data 
            $.ajax({
                type: "POST",
                url: window.location.origin + '/feedback/new_chat',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 800000,
                success: function(response) {
                    response = JSON.parse(response);
                    console.log(response);
                    //hide error msg
                    $("#error-messages").css('display', 'none');

                    //show success msg
                    $('#success-messages').css('display', '');
                    $("#success-messages").html("<div class='bg-teal-100 text-teal-900 rounded-b text-teal-900 px-4 py-3'>" + response.success_msg + "</div>");

                    //new message
                    $('#new-message-div').css('display', '');
                    $('#new-message').html(response.message);

                    $('#message').text("");

                    // Deactivate Loading Spinner
                    // $('.loading-spinner').toggleClass('active');
                },
                error: function(e) {
                    //hide success msg
                    $('#success-messages').css('display', 'none');

                    //new message
                    $('#new-message-div').css('display', 'none');

                    //show error msg
                    $("#error-messages").html("<div class='bg-red-100 text-red-900 rounded-b text-teal-900 px-4 py-3'>" + response.error_msg + "</div>");
                },
            });
        });

    });
</script>