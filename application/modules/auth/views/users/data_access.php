<div class="bg-gray-100">
    <div class="mx-auto py-2 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">
            Assign Data Access : <?= $user->first_name . " " . $user->last_name . " - " . $user_groups ?>
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

        <?php if (isset($permissions_list) && count($permissions_list) > 0) { ?>
            <?= form_open(uri_string()); ?>
            <?= form_hidden("user_id", $user->id) ?>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3 mb-6 md:mb-0">
                    <table class="text-sm font-normal">
                        <tr>
                            <?php
                            $serial = 0;
                            foreach ($permissions_list as $key => $value) {
                                if (($serial % 4) == 0) {
                                    echo '</tr><tr>';
                                } ?>
                                <td>
                                    <?= form_checkbox("permissions[]", $value->id, (in_array($value->id, $assigned_perms)) ? TRUE : FALSE); ?>
                                    <?= $value->title ?>&nbsp;&nbsp;&nbsp;
                                </td>
                            <?php $serial++;
                            } ?>
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