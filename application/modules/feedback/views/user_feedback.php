<div class="bg-gray-100">
    <div class="mx-auto py-2 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">Chats</h1>
    </div>

    <div class="mx-auto py-0 px-4 sm:px-6">
        <div class="text-sm text-left text-gray-900">
            <a hx-get="<?= site_url('feedback/form_data_preview/' . $form->form_id . '/' . $form_data->id); ?>" hx-target="#jembe" class="inline-block p-2 border-b-4 border-red-900">Data Preview</a>
            <a hx-get="<?= site_url('feedback/chats/' . $form->form_id . '/' . $form_data->meta_instanceID); ?>" hx-target="#jembe" class="inline-block p-2 border-b-4 border-transparent">Chats</a>
            <a hx-get="<?= site_url('feedback/case_info/' . $form->form_id . '/' . $form_data->meta_instanceID); ?>" hx-target="#jembe" class="inline-block p-2 border-b-4 border-transparent">Case Information</a>
        </div>
    </div>
</div>
</header>

<main class="bg-white h-[calc(100%-9rem)] flex overflow-hidden relative">
    <div class="flex-1 h-full overflow-y-scroll" id="jembe">
        <!-- content -->
        <div class="mx-auto px-4">
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
</main>