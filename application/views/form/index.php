<div id="grid_padding" class="grid_11">

    <div class="table_list">
        <table class="table" cellspacing="0" cellpadding="0">
            <tr>
                <th>Form Name</th>
                <th>Form Id</th>
                <th>Created On</th>
                <th>Description</th>
                <th>XML</th>
            </tr>

            <?php
            $serial = 1;
            foreach ($forms as $form):?>
                <tr>
                    <td><?php echo $form->title; ?></td>
                    <td><?php echo $form->form_id; ?></td>
                    <td><?php echo date('d-m-Y H:i:s', strtotime($form->date_created)); ?></td>
                    <td><?php echo $form->description; ?></td>
                    <td><?php echo anchor_popup(base_url() . "assets/forms/definition/" . $form->filename, $form->filename); ?></td>
                </tr>
                <?php $serial++;
            endforeach; ?>
        </table>

    </div>
</div>
<div style="clear: both;"></div>
</div>            </div>
</div>
