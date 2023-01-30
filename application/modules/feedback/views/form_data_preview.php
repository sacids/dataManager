<!--./tabs -->
<div class="px-4 py-4">
    <?php $this->load->view('menu_bar'); ?>

    <!-- content -->
    <div class="mt-4">
        <div class="flex flex-col flex-auto h-full">
            <div class="flex flex-col flex-auto flex-shrink-0 h-full">
                <?php if (isset($mapped_form_data) && $mapped_form_data) { ?>
                    <table class="w-full text-sm text-left table-fixed">
                        <tbody class="border-b">
                            <?php foreach ($mapped_form_data as $val) { ?>
                                <tr class="border-b">
                                    <td class="px-0 py-4 text-left font-normal text-sm text-gray-600 whitespace-nowrap"><?= $val['label'] ?></td>
                                    <td class="px-0 py-4 text-left font-normal text-sm text-gray-600 whitespace-nowrap"><?= $val['value'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        </div>
    </div>
</div>