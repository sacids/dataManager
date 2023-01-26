<header class="bg-gray-100">
    <div class="mx-auto py-3 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">
        <?= isset($project) ? $project->title : '' ?> > Mapping Form Field - <?= $form->title ?>
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

                <li >
                    <a href="<?= site_url("visualization/visualization/map/" . $project->id . '/' . $form->id) ?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Map
                    </a>
                </li>

                <li class="border-b-4 border-red-900">
                    <a href="<?= site_url("xform/mapping/" . $project->id . '/' . $form->id)?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Mapping Fields
                    </a>
                </li>

                <li class="">
                    <a href="<?= site_url("xform/permissions/" . $project->id . '/' . $form->id)?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
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
            <div class="w-full">

                <div class="relative overflow-x-auto">
                    <?php if ($this->session->flashdata('message') != "") { ?>
                        <div class="bg-teal-100 rounded-b text-teal-900 px-4 py-3 mb-4" role="alert">
                            <div class="flex">
                                <div>
                                    <p class="text-sm font-normal"><?= $this->session->flashdata('message'); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <table class="w-full text-sm text-left">
                        <thead class="text-left text-sm font-medium text-gray-700  bg-white border-b">
                            <tr>
                                <th scope="col" class="py-3">Hide</th>
                                <th scope="col" class="py-3">Mapping To</th>
                                <?php if ($form->allow_dhis == 1) : ?>
                                    <th class="text-center">Dhis2 Data Element</th>
                                <?php endif; ?>
                                <th scope="col" class="py-3">Question/Label</th>
                                <th scope="col" class="py-3">Field Type</th>
                                <th scope="col" class="py-3">Chart use</th>
                                <th scope="col" class="py-3">Option</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white border-b hover:bg-gray-50">
                            <?php

                            $form_specific_options = [
                                '' => "Select Option",
                                'male case' => "Male Case",
                                'male death' => "Male Death",
                                'female case' => "Female Case",
                                'female death' => "Female Death"
                            ];

                            $field_type_options = [
                                'TEXT' => "Text",
                                'INT' => "Number",
                                "GPS" => "GPS Location",
                                "DATE" => "DATE",
                                "DALILI" => 'Symptoms',
                                "LAT" => "Latitude",
                                "LONG" => "Longitude",
                                "IDENTITY" => "Username/Identity",
                                "IMAGE" => "Image",
                                "DISTRICT" => "District",
                                "SPECIE" => "Specie",
                            ];

                            $use_in_chart_options = [1 => 'Yes', 0 => 'No'];

                            foreach ($table_fields as $tf) {
                                echo "<tr class='bg-white border-b hover:bg-gray-50'>";
                                echo "<td class='py-3'>" . form_checkbox("hide[]", $tf['id'], ($tf['hide'] == 1)) . "</td>";
                                echo "<td><em>{$tf['col_name']}</em></td>";
                                if ($form->allow_dhis == 1) {
                                    echo "<td>" . form_input("data_element[]", (!empty($tf['dhis_data_element']) ? $tf['dhis_data_element'] : null), 'class="bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"') . "</td>";
                                }
                                echo "<td>" . form_hidden("ids[]", $tf['id']) . " " . form_input("label[]", (!empty($tf['field_label']) ? $tf['field_label'] : $tf['field_name']), 'class="bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"') . "</td>";
                                echo "<td>" . form_dropdown("field_type[]", $field_type_options, $tf['field_type']) . "</td>";
                                echo "<td>" . form_dropdown("chart_use[]", $use_in_chart_options, $tf['chart_use']) . "</td>";
                                echo "<td>" . form_dropdown("type[]", $form_specific_options, $tf['type']) . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <div class="flex items-start mt-3">
                        <button type="submit" class="text-white bg-slate-800 hover:bg-red-900 focus:ring-4 font-medium rounded text-sm w-full sm:w-auto px-5 py-2.5 text-center">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /End replace -->
    </div>
</main>