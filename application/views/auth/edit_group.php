<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">

            <h3>Edit Group</h3>

            <?php
            if ($this->session->flashdata('message') != '') {
                echo display_message($this->session->flashdata('message'));
            }
            ?>

            <div class="col-sm-8">
                <form action="" class="form-horizontal" role="form" method="post" accept-charset="utf-8">

                    <div class="form-group">
                        <label> <label for="group_name">Group Name:<span>*</span></label> </label>
                        <input type="text" name="group_name" value="<?php echo $group->name; ?>"
                               class="form-control" id="group_name"/>
                    </div>
                    <?php echo form_error('group_name'); ?>

                    <div class="form-group">
                        <label> <label for="description">Description:</label> </label>
								<textarea name="description" id="description"
                                          class="form-control"><?php echo $group->description; ?></textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>