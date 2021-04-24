<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title"><?= $user->first_name . " " . $user->last_name ?> : Mapping of Users</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?= site_url('auth/users/lists') ?>">Users</a></li>
                <li class="active">Mapping of users</li>
            </ol>


            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">

                    <?php if (validation_errors() != "") {
                        echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                    } else if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <?php if (isset($users) && count($users) > 0) { ?>
                        <?= form_open(uri_string()); ?>
                        <?= form_hidden("user_id", $user->id) ?>
                        <table>
                            <tr>
                                <?php
                                $serial = 0;
                                foreach ($users as $key => $value) {
                                    if (($serial % 6) == 0) {
                                        echo '</tr><tr>';
                                    } ?>
                                    <td>
                                        <?= form_checkbox("users[]", $value->id, (in_array($value->id, $mapped_users)) ? TRUE : FALSE); ?>
                                        <?= $value->first_name . ' ' . $value->last_name ?>&nbsp;&nbsp;
                                    </td>
                                    <?php $serial++;
                                } ?>
                            </tr>
                        </table>
                        <div style="margin-top: 15px;"></div>
                        <?= form_submit('save', 'Map', array('class' => "btn btn-primary")); ?>
                        <?= anchor('auth/users/lists', 'Cancel', 'class="btn btn-danger"'); ?>

                        <?= form_close(); ?>
                    <?php } else {
                        echo display_message('No filter found', 'warning');
                    } ?>
                </div><!--./col-sm-12 -->
            </div><!--./row -->
        </div>
    </div>
</div>