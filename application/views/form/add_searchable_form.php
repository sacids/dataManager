<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div id="header-title">
                <h3 class="title">Add searchable form</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li class="active">Add searchable form</li>
            </ol>


            <div class="row">
                <div class="col-sm-12">
                    <?php if (validation_errors() != "") {
                        echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                    } ?>

                    <?php echo form_open('xform/add_searchable_form', 'role="form"'); ?>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Form name <span style="color: red;">*</span></label>
                            <select name="form_id" id="form_id" class="form-control"
                                    onchange="suggest_form();">
                                <option value="">Choose form</option>
                                <?php foreach ($form_list as $value) { ?>
                                    <option value="<?= $value->id ?>" <?= set_select('form_id', $value->id) ?>><?= $value->title ?></option>

                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Search field <span style="color: red;">*</span></label>
                            <select name="search_field" id="search_field" class="form-control">
                                <option value="">Choose search field</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>


        </div>
    </div>
</div>