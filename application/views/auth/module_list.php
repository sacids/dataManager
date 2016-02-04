<div id="grid_padding" class="grid_11" >

    <div >
        <table class="table" cellspacing="0" cellpadding="0" width="60%">
            <tr>
                <th></th>
                <th>Module Name</th>
                <th></th>
            </tr>

            <?php
            $serial=1;
            foreach ($modules as $values):?>
                <tr>
                    <td><?php echo $serial;?></td>
                    <td><?php echo $values->name;?></td>
                    <td>
                        <?php echo anchor("auth/edit_module/".$values->id, 'Edit') ;?> |
                        <?php echo anchor("auth/delete_module/".$values->id, 'Delete') ;?>
                    </td>
                </tr>
                <?php
                $serial++;
            endforeach;?>


        </table>

    </div>
</div>
<div style="clear: both;"></div>
</div>            </div>
</div>
