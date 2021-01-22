<script src="<?= base_url('assets/public/ckeditor/ckeditor.js') ?>"></script>

<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">Add New Story</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?= site_url('newsletters/lists') ?>">Newsletters Stories</a></li>
                <li class="active">Add new story</li>
            </ol>

            <div class="row">
                <div class="col-sm-12">
                    <?php if (validation_errors() != "") {
                        echo '<div class="alert alert-danger fade in">' . validation_errors() . '</div>';
                    } else if ($this->session->flashdata('message') != "") {
                        echo $this->session->flashdata('message');
                    } ?>

                    <?= form_open_multipart('newsletters/add_new', 'role="form"'); ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Title<span style="color: red;">*</span>
                                </label>
                                <?= form_input($name); ?>
                            </div>
                        </div>
                    </div><!--./row -->

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Edition</label>
                                <?php
                                $edition_options = array();
                                foreach ($edition_list as $value) {
                                    $edition_options[$value->id] = $value->title;
                                }
                                $edition_options = array('' => 'Choose edition') + $edition_options;
                                ?>
                                <?= form_dropdown("edition_id", $edition_options, set_value("edition_id"), 'class="form-control"'); ?>
                            </div>
                        </div>
                    </div><!--./row -->

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Featured Image <span style="color: red;">*</span></label>
                                <?= form_upload($attachment) ?>
                            </div>
                        </div>
                    </div><!--./row -->

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Story Content <span
                                            style="color: red;">*</span></label>
                                <?= form_textarea($story_content); ?>
                                <script>
                                    CKEDITOR.replace('story_content', {
                                        height: '500px',
                                        "extraPlugins": 'imagebrowser',
                                        "imageBrowser_listUrl": "<?= base_url('assets/uploads/media/image_lists.json')?>"
                                    });
                                </script>
                            </div>
                        </div>
                    </div><!--./row -->

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label><?= $this->lang->line("label_status") ?></label>
                                <?= form_dropdown("status", array("" => "Choose status", "draft" => "Draft", "published" => "Published"), set_value("status"), 'class="form-control"'); ?>
                            </div>
                        </div>
                    </div><!--./row -->

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <?= form_submit('submit', 'Save', array('class' => "btn btn-primary")); ?>
                                <?= anchor('newsletters/lists', 'Cancel', 'class="btn btn-warning"') ?>
                            </div> <!-- /form-group -->
                        </div>
                    </div><!--./row -->
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

