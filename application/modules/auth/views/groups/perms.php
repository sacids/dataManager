<div class="bg-gray-100">
    <div class="mx-auto py-2 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">Manage Permission</h1>
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

<main class="bg-white h-[calc(100%-9rem)] flex overflow-hidden relative">
    <div class="flex-1 h-full overflow-y-scroll">
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

            <?= form_open(uri_string()) ?>
            <?php if (isset($perms) && $perms) {
                foreach ($perms as $key => $value) { ?>
                    <h5 class="uppercase"> <?= $key; ?></h5>
                    <?= form_hidden('classes[]', $key) ?>
                    <table class="">
                        <tr>
                            <?php
                            $serial = 0;
                            foreach ($value as $k => $v) :
                                if (($serial % 5) == 0) {
                                    echo "</tr><tr>";
                                } ?>
                                <td>
                                    <?php
                                    echo form_checkbox("perms[]", $v[1], (in_array($v[1], $assigned_perms)) ? TRUE : FALSE);
                                    echo '<span>' . $v[2] . '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                    ?>
                                </td>
                                <?php
                                $serial++;
                            endforeach; ?>&nbsp;
                        </tr>
                    </table>
            <?php }
            } ?>

            <div class="flex items-start my-2">
                <button type="submit" name="save" class="text-white bg-slate-800 hover:bg-red-900 focus:ring-4 font-medium rounded text-sm w-full sm:w-auto px-5 py-2.5 text-center">Assign</button>
            </div>
            <?= form_close(); ?>

        </div>
    </div>
</main>