<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <h3>Feedback List</h3>
            <div class="table_list">

                <div class="pull-right" style="margin-bottom: 10px;">
                    <?php echo form_open("feedback/feedback_list", 'class="form-inline" role="form"'); ?>

                    <div class="form-group">

                        <?php
                        $data_name = array(
                            'name' => 'name',
                            'id' => 'name',
                            'class' => "form-control",
                            'placeholder' => "Form Name"
                        );
                        echo form_input($data_name); ?>
                    </div>

                    <div class="form-group">
                        <select class="form-control" id="from" name="from">
                            <option value="">Choose user from</option>
                            <?php foreach ($user as $value) { ?>
                                <option
                                    value="<?= $value->id ?>"><?= $value->first_name . ' ' . $value->last_name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="to" name="to">
                            <option value="">Choose user to</option>
                            <?php foreach ($user as $value) { ?>
                                <option
                                    value="<?= $value->id ?>"><?= $value->first_name . ' ' . $value->last_name ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <?php echo form_submit("search", "Search", 'class="btn btn-primary"'); ?>
                        </div>
                    </div>
                    <?php echo form_close(); ?>

                    <?php echo validation_errors(); ?>
                </div>

                <?php if (!empty($feedback)) { ?>

                    <table class="table table-striped table-responsive table-hover table-bordered">
                        <tr>
                            <th><?php echo $this->lang->line("label_form_name"); ?></th>
                            <th><?php echo $this->lang->line("label_instance_id"); ?></th>
                            <th><?php echo $this->lang->line("label_from"); ?></th>
                            <th><?php echo $this->lang->line("label_to"); ?></th>
                            <th><?php echo $this->lang->line("label_feedback_date"); ?></th>
                            <th><?php echo $this->lang->line("label_action"); ?></th>
                        </tr>

                        <?php
                        $serial = 1;
                        foreach ($feedback as $value) { ?>
                            <tr>
                                <td><?php echo $value->title; ?></td>
                                <td><?php echo $value->instance_id; ?></td>
                                <td><?php echo $value->uf_fname . ' ' . $value->uf_lname; ?></td>
                                <td><?php echo $value->ut_fname . ' ' . $value->uf_lname; ?></td>
                                <td><?php echo date('d-m-Y H:i:s', strtotime($value->date_created)); ?></td>
                                <td>
                                    <?php echo anchor("feedback/user_feedback/" . $value->instance_id, "Conversation", 'class = "btn btn-primary btn-xs"'); ?>
                                </td>
                            </tr>
                            <?php $serial++;
                        } ?>
                    </table>

                <?php } else { ?>
                    <div class="fail_message">You don't have any recent chat to display</div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>