
<div class="grid_11" style="padding-top: 20px; text-align: left;">

    <div class="table_list">


        <table class="table" cellspacing="0" cellpadding="0">
            <tr>
                <th>S/n</th>
                <th>Group Name</th>
                <th>Group Description</th>
                <th>Action</th>
                </th>
            </tr>
            <?php
            $serial=1;
            foreach($groups as $values):?>
                <tr>
                    <td><?php echo $serial;?></td>
                    <td><?php echo $values->name;?></td>
                    <td><?php echo $values->description;?></td>
                    <td>
                        <a href="<?php echo base_url();?>index.php/auth/edit_group/<?php echo $values->id;?>" title="Edit">Edit</a> |
                        <a href="<?php echo base_url();?>index.php/auth/assign_privilege/<?php echo $values->id;?>" title="Assign Privilege">Privilege</a>

                    </td>
                </tr>
                <?php
                $serial++;
            endforeach;?>
        </table>

    </div>
</div>

</div>   </div> </div>
