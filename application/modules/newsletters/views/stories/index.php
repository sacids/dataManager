<!-- Page Content -->
<section class="page-wrapper">
    <div class="container">
        <div class="page-header">
            <h5 class="section-title">
                <span>
                    <a href="#">Newsletter Stories</a>
                </span>
            </h5>
        </div>

        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php
                if (isset($stories) && $stories) {
                    foreach ($stories as $post) { ?>
                        <!-- Blog Post -->
                        <div class="card mb-4">
                            <?php if (file_exists('./assets/uploads/media/thumb_' . $post->media)) { ?>
                                <img class="card-img-top"
                                     src="<?= base_url('./assets/uploads/media/thumb_' . $post->media) ?>"
                                     alt="<?= $post->title ?>">
                            <?php } else { ?>
                                <img class="card-img-top" src="http://placehold.it/750x300" alt="<?= $post->title ?>">
                            <?php } ?>
                            <div class="card-body">
                                <h4 class="card-title">
                                    <a href="<?= site_url('newsletters/stories/post/' . $post->alias) ?>"><?= $post->title ?></a>
                                </h4>
                                <p class="card-text"><?= strip_tags(substr($post->story, 0, 300)) ?></p>
                                <a href="<?= site_url('newsletters/stories/post/' . $post->alias) ?>"
                                   class="btn btn-default btn-sm">Read More <i class="fa fa-angle-double-right"></i>
                                </a>
                            </div>
                            <div class="card-footer text-muted">
                                <?= 'Posted on ' . date("jS F, Y H:i", strtotime($post->date_created)) ?>
                                <span class="pull-right"><small><?= $post->edition->title ?></small></span>
                            </div>
                        </div>
                    <?php }
                } else {
                    echo display_message('No any matching story', 'warning');
                } ?>

                <!-- Pagination -->
                <?php if (!empty($links)): ?>
                    <div class="widget-foot">
                        <?= $links ?>
                        <div class="clearfix"></div>
                    </div>
                <?php endif; ?>
            </div><!--./col-md-8 -->

            <!-- Sidebar Widgets Column -->
            <div class="col-md-4">
                <!-- Search Widget -->
                <div class="panel panel-danger my-4">
                    <div class="panel-heading">
                        <i class="fa fa-search"></i>
                        Search
                    </div>

                    <div class="panel-body">
                        <?= form_open('newsletters/stories', 'role="form"') ?>
                        <div class="input-group">
                            <input type="text" name="keyword" id="keyword" class="form-control"
                                   placeholder="Search for...">
                            <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit" name="search">Go!</button>
                        </span>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div><!--./panel -->

                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <i class="fa fa-info-circle"></i>
                        Get in Touch
                    </div>
                    <div class="panel-body">
                        <p>
                            Are you interested in know more about AfyaData?
                            Are you want to use AfyaData tool for data collection?
                            Contact us at the number or email address below
                        </p>

                        <p>
                            <i class="fa fa-envelope hue"></i> <a
                                    href="mailto:afyadata@sacids.org">afyadata@sacids.org</a><br/>
                            <i class="fa fa-phone hue"></i> +255 783 555 386
                        </p>
                    </div>
                </div><!--./panel -->

            </div><!--./col-md-4 -->

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->
</section>