<section>
    <div class="container" id="content-middle">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 main">
                <div id="header-title">
                    <h3 class="title">User Profile</h3>
                </div>

                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li><a href="<?= site_url('dashboard'); ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                    <li class="active">User Profile</li>
                </ol>

                <div class="row">
                    <div class="col-lg-2">
                        <?php $this->load->view('auth/menu') ?>
                    </div>
                    <div class="col-lg-10">
                        <div class="panel panel-default">
                            <div class="panel-heading"><b>Profile</b></div>
                            <div class="panel-body">
                                <table class="table table-bordered table-responsive table-hover">
                                    <tbody>

                                    <tr>
                                        <td>Full name:</td>
                                        <td><?php echo $user->first_name . ' ' . $user->last_name; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Phone:</td>
                                        <td><?php echo $user->phone; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Email:</td>
                                        <td><?php echo $user->email; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Created On:</td>
                                        <td><?php echo date('d-m-Y H:i:s', $user->created_on); ?></td>
                                    </tr>

                                    <tr>
                                        <td>Roles:</td>
                                        <td><?php
                                            if (isset($user_groups) && $user_groups) {
                                                foreach ($user_groups as $value) {
                                                    echo '<p>' . $value->group->description . '</p>';
                                                }
                                            } ?></td>
                                    </tr>

                                    <tr>
                                        <td>Research Group:</td>
                                        <td><?php
                                            if (isset($research_group_members) && $research_group_members) {
                                                foreach ($research_group_members as $value) {
                                                    echo '<p>' . $value->group->name . '</p>';
                                                }
                                            } else {
                                                echo 'No assigned research group';
                                            } ?></td>
                                    </tr>

                                    <tr>
                                        <td>Last Login:</td>
                                        <td><?php echo date('d-m-Y H:i:s', $user->last_login); ?></td>
                                    </tr>


                                    </tbody>
                                </table>
                            </div>
                        </div><!--./end of panel-default -->

                        <!--Supervised students -->
                        <?php if (isset($students) && $students) { ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="title"> Supervised Students</h4>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th width="3%"></th>
                                        <th width="10%">StudentNo</th>
                                        <th width="17%">Name</th>
                                        <th width="5%">Gender</th>
                                        <th width="8%">Admitted</th>
                                        <th width="8%">Program</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $serial = 1;
                                    foreach ($students as $values) { ?>
                                        <tr>
                                            <td><?= $serial; ?></td>
                                            <td>
                                                <?php if (perms_role('students', 'details')) {
                                                    echo anchor('students/details/' . $values->student->id, $values->student->registration_number);
                                                } else {
                                                    echo $values->student->registration_number;
                                                } ?>
                                            </td>
                                            <td><?= $values->student->first_name . ' ' . $values->student->middle_name . ' ' . $values->student->surname; ?></td>
                                            <td align="center"><?= $values->student->gender; ?></td>
                                            <td><?= $values->academic_year->year; ?></td>
                                            <td><?= $values->program->code; ?></td>
                                        </tr>
                                        <?php
                                        $serial++;
                                    } ?>
                                    </tbody>
                                </table>
                                <?php } ?>
                            </div>
                        </div> <!-- .end of row -->
                        <!-- .end of students supervised -->
                    </div><!--./end of col-sm-9 -->
                </div><!--./end of row -->
            </div>
        </div>
    </div>
</section>


