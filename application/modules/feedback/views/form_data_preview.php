<!-- content -->
<div class="h-full w-full overflow-y-scroll p-3">
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
                            } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
</div>