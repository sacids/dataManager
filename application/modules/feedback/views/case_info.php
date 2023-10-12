<!-- content -->
<div class="h-full w-full overflow-y-scroll p-3">
    <table class="w-full text-sm text-left table-fixed">
        <tbody class="border-b">
            <tr class="border-b">
                <td class="px-0 py-4 text-left font-normal text-sm text-gray-600 whitespace-nowrap">Case Attended</td>
                <td class="px-0 py-4 text-left font-normal text-sm text-gray-600 whitespace-nowrap">
                    <?= ($case->attended == 1) ?  '<span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded border border-green-400">Yes</span>' : '<span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded border border-red-400">No</span>'; ?>
                </td>
            </tr>

            <?php if ($case->attended == 1) { ?>
                <tr class="border-b">
                    <td class="px-0 py-4 text-left font-normal text-sm text-gray-600 whitespace-nowrap">Attended By</td>
                    <td class="px-0 py-4 text-left font-normal text-sm text-gray-600 whitespace-nowrap">
                    <?php
                        if($user){
                            echo $user->first_name.' '.$user->last_name;
                        }
                    ?>
                    </td>
                </tr>

                <tr class="border-b">
                    <td class="px-0 py-4 text-left font-normal text-sm text-gray-600 whitespace-nowrap">Attend Date</td>
                    <td class="px-0 py-4 text-left font-normal text-sm text-gray-600 whitespace-nowrap"><?php echo date('d-m-Y H:i:s', $case->updated_at); ?></td>
                </tr>

                <tr class="border-b">
                    <td class="px-0 py-4 text-left font-normal text-sm text-gray-600 whitespace-nowrap">Disease Detected</td>
                    <td class="px-0 py-4 text-left font-normal text-sm text-gray-600 whitespace-nowrap">
                        <?php
                            if($disease){
                                echo $disease->name;
                            }
                        ?>
                    </td>
                </tr>

                <tr class="border-b">
                    <td class="px-0 py-4 text-left font-normal text-sm text-gray-600 whitespace-nowrap">Other Disease</td>
                    <td class="px-0 py-4 text-left font-normal text-sm text-gray-600 whitespace-nowrap"><?= $case->other_disease; ?></td>
                </tr>

                <tr class="border-b">
                    <td class="px-0 py-4 text-left font-normal text-sm text-gray-600 whitespace-nowrap">Action Taken</td>
                    <td class="px-0 py-4 text-left font-normal text-sm text-gray-600 whitespace-nowrap"><?= $case->action_taken; ?></td>
                </tr>

                <tr class="border-b">
                    <td class="px-0 py-4 text-left font-normal text-sm text-gray-600 whitespace-nowrap">Reported to E-Mai</td>
                    <td class="px-0 py-4 text-left font-normal text-sm text-gray-600 whitespace-nowrap">
                        <?= ($case->reported_emai == 1) ?  '<span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded border border-green-400">Yes</span>' : '<span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded border border-red-400">No</span>'; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>