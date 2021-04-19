<!-- Begin Page Content -->
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Assign Permission - <?= $group->description ?></h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= site_url('auth/groups/lists') ?>">Roles</a></li>
                <li class="breadcrumb-item active">Assign Permission</li>
            </ol>

            <div class="row">
                <div class="col-lg-12">
                    <?php if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <div class="pure-form">
                        <?= form_open(uri_string()) ?>
                        <?php if (isset($perms) && $perms) {
                            foreach ($perms as $key => $value) { ?>
                                <h5 class="title"> <?= $key; ?></h5>

                                <?= form_hidden('classes[]', $key) ?>
                                <table>
                                    <tr>
                                        <?php
                                        $serial = 0;
                                        foreach ($value as $k => $v) :
                                            if (($serial % 10) == 0) {
                                                echo "</tr><tr>";
                                            } ?>
                                            <td>
                                                <?php
                                                echo form_checkbox("perms[]", $v[1], (in_array($v[1], $assigned_perms)) ? TRUE : FALSE);
                                                echo '<label>' . $v[2] . '</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                                ?>
                                            </td>
                                            <?php
                                            $serial++;
                                        endforeach; ?>&nbsp;
                                    </tr>
                                </table>
                        <?php }
                        } ?>

                        <div class="row">
                            <div class="col-sm-6">
                                <?= form_submit('save', 'Save', array('class' => "btn btn-primary btn-sm")); ?>
                                <?= anchor('auth/groups/lists', 'Cancel', 'class="btn btn-danger btn-sm"') ?>
                            </div><!-- end of col-sm-10 -->
                        </div>
                        <!--./end of row -->
                        <?= form_close(); ?>
                    </div> <!-- /.pure-form -->
                </div><!-- ./col-lg-12 -->
            </div>
            <!--./row -->
        </div>
    </div>
</div>
<!-- /.container-fluid -->