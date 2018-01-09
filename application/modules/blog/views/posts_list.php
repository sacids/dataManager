<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 main">
            <div id="header-title">
                <h3 class="title">NewsLetter Posts List</h3>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                <li class="active">Posts List</li>
            </ol>

            <div class="row">
                <?php
                if ($this->session->flashdata('message') != '') {
                    echo '<div class="success_message">' . $this->session->flashdata('message') . '</div>';
                } ?>

                <div class="col-sm-12">

                    <?php if (isset($posts) && $posts) { ?>
                        <table class="table table-striped table-bordered table-responsive table-hover">
                            <tr>
                                <th width="4%"></th>
                                <th width="40%">Title</th>
                                <th width="14%">Author</th>
                                <th width="8%">Status</th>
                                <th width="10%">Created Date</th>
                                <th width="5%"><?= $this->lang->line("label_action"); ?></th>
                            </tr>

                            <?php
                            $serial = 1;
                            foreach ($posts as $post) { ?>
                                <tr>
                                    <td><?= $serial; ?></td>
                                    <td><?= $post->title; ?></td>
                                    <td><?= $post->user->first_name . ' ' . $post->user->last_name ?></td>
                                    <td><?= ($post->status = 'published') ? '<span class="label label-success">Published</span>' : '<span class="label label-warning">Draft</span>'; ?></td>
                                    <td><?= date('d-m-Y H:i:s', strtotime($post->date_created)); ?></td>
                                    <td>
                                        <?= anchor("blog/post/edit/" . $post->id, 'Edit'); ?>
                                    </td>
                                </tr>
                                <?php $serial++;
                            } ?>
                        </table>
                    <?php } else {
                        echo display_message('No any newsletter post yet!', 'danger');
                    } ?>
                </div>
            </div>

        </div>
    </div>
</div>