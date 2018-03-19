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
            <!-- Post Content Column -->
            <div class="col-lg-8">
                <!-- Title -->
                <h4 class="mt-4 text-primary"><?= (isset($story) ? $story->title : '') ?></h4>

                <!-- Author -->
                <p>By
                    <?= (isset($user) ? $user->first_name . ' ' . $user->last_name : 'Administrator') ?>
                </p>
                <hr>
                <!-- Date/Time -->
                <?= date("jS F, Y H:i", strtotime($story->date_created)) ?>
                <span class="pull-right"><small><?= $edition->title ?></small></span>
                <hr>

                <!-- Preview Image -->
                <?php if (file_exists('./assets/uploads/media/thumb_' . $story->media)) { ?>
                    <img class="img-fluid rounded"
                         src="<?= base_url('./assets/uploads/media/thumb_' . $story->media) ?>"
                         alt="<?= $story->title ?>">
                <?php } else { ?>
                    <img class="img-fluid rounded" src="http://placehold.it/900x300" alt="<?= $story->title ?>">
                <?php } ?>
                <hr>

                <!-- Post Content -->
                <?= $story->story ?>

                <hr>
                <!-- Comments Form -->
                <div class="panel panel-light">
                    <div class="panel-heading">
                        <i class="fa fa-comments-o"></i>
                        Comments
                    </div>

                    <div class="panel-body">
                        <div id="disqus_thread"></div>
                        <script>

                            /**
                             *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                             *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
                            /*
                            var disqus_config = function () {
                            this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
                            this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                            };
                            */
                            (function () { // DON'T EDIT BELOW THIS LINE
                                var d = document, s = d.createElement('script');
                                s.src = 'https://afyadata.disqus.com/embed.js';
                                s.setAttribute('data-timestamp', +new Date());
                                (d.head || d.body).appendChild(s);
                            })();
                        </script>
                        <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments
                                powered by Disqus.</a></noscript>
                    </div>
                </div>
            </div>

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

                <!-- Begin fluid width widget -->
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <i class="fa fa-list"></i>
                        Recent Posts
                    </div>
                    <div class="panel-body">
                        <ul class="media-list">
                            <?php if (isset($recent_posts) && $recent_posts) {
                                foreach ($recent_posts as $p) { ?>
                                    <li class="media">
                                        <div class="media-body">
                                            <h6 class="media-heading">
                                                <?= anchor("newsletters/stories/post/" . $p->alias, $p->title, 'class="text-primary"'); ?>
                                            </h6>
                                        </div>
                                    </li>
                                <?php }
                            } ?>

                        </ul>
                        <a href="<?= site_url('newsletters/stories') ?>" class="btn btn-default btn-block">More
                            Newsletter Stories
                            »</a>
                    </div>
                </div>
                <!-- End fluid width widget -->
            </div><!--./col-md-4 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</section>