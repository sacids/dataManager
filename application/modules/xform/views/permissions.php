<header class="bg-gray-100">
    <div class="mx-auto py-3 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">
            <?= isset($project) ? $project->title : '' ?> > Form Permission - <?= $form->title ?>
        </h1>
    </div>
</header>

<header class="bg-gray-100">
    <div class="mx-auto py-0 px-4 sm:px-6">
        <div class="text-sm text-center text-gray-900">
            <ul class="flex flex-wrap">
                <li class="">
                    <a href="#" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Overview
                    </a>
                </li>

                <li class="">
                    <a href="<?= site_url("xform/form_data/" . $project->id . '/' . $form->id) ?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Table
                    </a>
                </li>

                <li class="">
                    <a href="<?= site_url("visualization/visualization/chart/" . $project->id . '/' . $form->id) ?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Charts
                    </a>
                </li>

                <li>
                    <a href="<?= site_url("visualization/visualization/map/" . $project->id . '/' . $form->id) ?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Map
                    </a>
                </li>

                <li class="">
                    <a href="<?= site_url("xform/mapping/" . $project->id . '/' . $form->id) ?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Mapping Fields
                    </a>
                </li>

                <li class="border-b-4 border-red-900">
                    <a href="<?= site_url("xform/permissions/" . $project->id . '/' . $form->id) ?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Permission
                    </a>
                </li>
            </ul>
            </ul>
        </div>
    </div>
</header>

<main class="bg-white h-full">
    <div class="mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-row flex-wrap mt-2">
            <div class="w-full md:w-1/4 text-sm text-left text-gray-800">

                <h4 class="uppercase mb-3">
                    <?= $this->lang->line("label_group_permissions") ?>
                </h4>
                <?php
                foreach ($group_perms as $key => $value) {
                    echo form_checkbox("perms[]", $key, (in_array($key, $current_perms)) ? TRUE : FALSE);
                    echo ucfirst($value) . "</br>";
                } ?>
            </div>

            <div class="w-full md:w-3/4 text-sm text-left text-gray-800">

                <h4 class="uppercase mb-3">
                    <?= $this->lang->line("label_user_permissions") ?>
                </h4>

                <table>
                    <tr>
                        <?php
                        $serial = 0;
                        foreach ($user_perms as $key => $value) {
                            if (($serial % 4) == 0) {
                                echo '</tr><tr>';
                            } ?>
                            <td>
                                <?= form_checkbox("perms[]", $key, (in_array($key, $current_perms)) ? TRUE : FALSE); ?>
                                <?= ucfirst($value); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>
                        <?php $serial++;
                        } ?>
                    </tr>
                </table>
            </div>

            <div class="flex items-start mt-3">
                <button type="submit" class="text-white bg-slate-800 hover:bg-red-900 focus:ring-4 font-medium rounded text-sm w-full sm:w-auto px-5 py-2.5 text-center">Submit</button>
            </div>
        </div>
    </div>
    <!-- /End replace -->
    </div>
</main>