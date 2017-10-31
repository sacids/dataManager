<?php
/**
 * Created by PhpStorm.
 * User: akyoo
 * Date: 31/10/2017
 * Time: 07:45
 */

?>

<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Assign Permissions
                    to <?= $user->first_name . " " . $user->last_name . " - " . $user_groups ?></h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><?= anchor('dashboard', 'Dashboard') ?></li>
                <li><?= anchor('auth', 'Auth') ?></li>
                <li class="active">Assign Permissions</li>
            </ol>

            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <?= get_flashdata() ?>
                    <?= form_open("auth/accesscontrol/assign_permission/" . $user->id) ?>
                    <?= form_hidden("user_id", $user->id) ?>
                    <?php
                    foreach ($permissions as $permission) {
                        echo "<label>";
                        echo form_checkbox("permissions[]", $permission->id) . "&nbsp;";
                        echo $permission->title. "&nbsp;&nbsp;&nbsp;</label>";
                    }
                    ?>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Assign Permissions</button>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>

        </div>
    </div>
</div>