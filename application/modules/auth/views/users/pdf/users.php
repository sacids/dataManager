<table>
    <tr>
        <td width="100%" align="center">
            <img src="<?= base_url('assets/img/logo_icon.png') ?>" width="75"/>
            <h3>UNIVERSITY OF DAR ES SALAAM</h3>
            <h4>POSTGRADUATE MANAGEMENT INFORMATION SYSTEM (PMIS)</h4>
        </td>
    </tr>
</table>

<table>
    <tr>
        <td width="100%" align="left">
            <h5>SYSTEM USERS REPORT</h5>

            <?php if (isset($department) && $department) {
                echo '<h6>DEPARTMENT : ' . strtoupper($department->name) . ' (' . $department->short_name . ')' . '</h6>';
            } ?>

            <?php if (isset($group) && $group) {
                echo '<h6>USERS GROUP : ' . strtoupper($group->name) . '</h6>';
            } ?>
        </td>
    </tr>
</table>
<br/>
<br/>

<?php if (isset($users) && $users) { ?>
    <table width="100%">
        <tr bgcolor="#EEEEEE">
            <th width="5%"
                style="height:15px; border: 0.5px solid #808080; text-align:left; font-size: 60%; font-weight: bold;">
                &nbsp;&nbsp;&nbsp;&nbsp;#
            </th>
            <th width="25%"
                style="height:15px; vertical-align: middle; border: 0.5px solid #808080; text-align:left; font-size: 60%; font-weight: bold;">
                &nbsp;&nbsp;FULL NAME
            </th>
            <th width="20%"
                style="height:15px; vertical-align: middle; border: 0.5px solid #808080; text-align:left; font-size: 60%; font-weight: bold;">
                &nbsp;&nbsp;EMAIL
            </th>
            <th width="12%"
                style="height:15px; vertical-align: middle; border: 0.5px solid #808080; text-align:left; font-size: 60%; font-weight: bold;">
                &nbsp;&nbsp;PHONE
            </th>
            <th width="12%"
                style="height:15px; vertical-align: middle; border: 0.5px solid #808080; text-align:left; font-size: 60%; font-weight: bold;">
                &nbsp;&nbsp;USERNAME
            </th>
            <th width="10%"
                style="height:15px; vertical-align: middle; border: 0.5px solid #808080; text-align:left; font-size: 60%; font-weight: bold;">
                &nbsp;&nbsp;REG DATE
            </th>

            <th width="10%"
                style="height:15px; vertical-align: middle; border: 0.5px solid #808080; text-align:left; font-size: 60%; font-weight: bold;">
                &nbsp;&nbsp;STATUS
            </th>
        </tr>

        <?php
        $serial = 1;
        foreach ($users as $values) {
            if (($serial % 2) == 0) {
                $bg_color = "#f1f1f1";
            } else {
                $bg_color = "#FFF";
            }
            ?>
            <tr bgcolor="<?php echo $bg_color; ?>">
                <td style="text-align:left; height:15px; border: 0.5px solid #808080; font-size: 70%;">
                    &nbsp;<?php echo $serial; ?></td>
                <td style="text-align:left; height:15px; border: 0.5px solid #808080; font-size: 70%;">
                    &nbsp;<?= $values->first_name . ' ' . $values->last_name ?></td>
                <td style="text-align:left; height:15px; border: 0.5px solid #808080; font-size: 70%;">
                    &nbsp;<?= $values->email; ?></td>
                <td style="text-align:left; height:15px; border: 0.5px solid #808080; font-size: 70%;">
                    &nbsp;<?= $values->phone; ?></td>
                <td style="text-align:left; height:15px; border: 0.5px solid #808080; font-size: 70%;">
                    &nbsp;<?= $values->username; ?></td>
                <td style="text-align:left; height:15px; border: 0.5px solid #808080; font-size: 70%;">
                    &nbsp;<?= date('d-m-Y', $values->created_on) ?></td>
                <td style="text-align:left; height:15px; border: 0.5px solid #808080; font-size: 70%;">
                    &nbsp;<?= ($values->active) ? 'ACTIVE' : 'INACTIVE' ?></td>
            </tr>
            <?php
            $serial++;
        } ?>
    </table>
<?php } ?>
