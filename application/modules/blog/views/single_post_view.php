<section>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Post Content Column -->
            <div class="col-lg-8">

                <!-- Title -->
                <h1 class="mt-4"><?= (isset($post) ? $post->title : '') ?></h1>

                <!-- Author -->
                <p class="lead">
                    by
                    <a href="#"><?= (isset($user) ? $user->first_name . ' ' . $user->last_name : 'Administrator') ?></a>
                </p>
                <hr>
                <!-- Date/Time -->
                <p><?= date("F d, Y g:i A", strtotime($post->date_created)) ?></p>
                <hr>

                <!-- Preview Image -->
                <img class="img-fluid rounded" src="http://placehold.it/900x300" alt="">
                <hr>

                <!-- Post Content -->
                <?= $post->content ?>
            </div>

            <!-- Sidebar Widgets Column -->
            <div class="col-md-4">

                <!-- Side Widget -->
                <!-- Begin fluid width widget -->
                <div class="panel panel-light">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <span class="glyphicon glyphicon-list-alt"></span>  Recent Posts
                        </h3>
                    </div>
                    <div class="panel-body">
                        <ul class="media-list">

                            <?php if (isset($recent_posts) && $recent_posts) {
                                foreach ($recent_posts as $p) { ?>
                                    <li class="media">
                                        <div class="media-body">
                                            <h4 class="media-heading">
                                                <?= anchor("blog/post/post_details/" . $p->id, $p->title, 'class="text-primary"'); ?>
                                            </h4>
                                        </div>
                                    </li>
                                <?php }
                            } ?>

                        </ul>
                        <a href="<?= site_url('blog') ?>" class="btn btn-default btn-block">More Blog Posts »</a>
                    </div>
                </div>
                <!-- End fluid width widget -->

            </div>

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->
</section>