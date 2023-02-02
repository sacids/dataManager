<div class="bg-gray-100">
    <div class="mx-auto py-2 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">
            User Mapping : <?= $user->first_name . " " . $user->last_name ?>
        </h1>
    </div>

    <div class="mx-auto py-0 px-4 sm:px-6">
        <div class="text-sm text-left text-gray-900">
            <?php
            foreach ($links as $key => $link) {
                echo $link;
            }
            ?>
        </div>
    </div>
</div>
</header>

<main class="bg-white h-full">
    <div class="mx-auto py-4 px-4 sm:px-6 lg:px-8">

        <?php if ($this->session->flashdata('message') != "") { ?>
            <div class="bg-teal-100 rounded-b text-teal-900 px-4 py-3 mb-4" role="alert">
                <div class="flex">
                    <div>
                        <p class="text-sm font-normal"><?= $this->session->flashdata('message'); ?></p>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if (isset($users) && count($users) > 0) { ?>
            <?= form_open(uri_string()); ?>
            <?= form_hidden("user_id", $user->id) ?>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3 mb-6 md:mb-0">
                    <table class="text-sm font-normal">
                        <tr>
                            <?php
                            $_options = [];
                            if (isset($users) && $users) {
                                foreach ($users as $key => $value) {
                                    $_options[$key] = $value->first_name . ' ' . $value->last_name;
                                }
                            }
                            echo form_dropdown('users[]', $_options, set_value('users[]', $mapped_users), 'data-placeholder="Select users...." class="bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 multiple-select" multiple');
                            ?>
                        </tr>
                    </table>
                </div>
            </div>
            <?= form_submit('save', 'Assign', array('class' => "text-white bg-slate-800 hover:bg-red-900 focus:ring-4 font-medium rounded text-sm w-full sm:w-auto px-5 py-2.5 text-center")); ?>

            <?= form_close(); ?>
        <?php } else {
            echo display_message('No filter found', 'warning');
        } ?>

    </div>
</main>