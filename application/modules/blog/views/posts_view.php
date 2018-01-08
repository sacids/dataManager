<!-- Page Content -->
<section>
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php
                if (isset($posts) && $posts) {
                    foreach ($posts as $post) { ?>
                        <!-- Blog Post -->
                        <div class="card mb-4">
                            <img class="card-img-top" src="http://placehold.it/750x300" alt="Card image cap">
                            <div class="card-body">
                                <h2 class="card-title">
                                    <a href="<?= site_url('blog/post/post_details/' . $post->id) ?>"><?= $post->title ?></a>
                                </h2>
                                <p class="card-text"><?= strip_tags(substr($post->content, 0, 300)) ?></p>
                                <a href="<?= site_url('blog/post/post_details/' . $post->id) ?>"
                                   class="btn btn-info">Read More <i class="fa fa-chevron-right"></i> </a>
                            </div>
                            <div class="card-footer text-muted">
                                <?= 'Posted on ' . date("F d, Y g:i A", strtotime($post->date_created)) ?>
                                by
                                <a href="#"><?= $post->user->first_name . ' ' . $post->user->last_name ?></a>
                            </div>
                        </div>
                    <?php }
                } ?>

                <!-- Pagination -->
                <ul class="pagination justify-content-center mb-4">
                    <li class="page-item">
                        <a class="page-link" href="#">&larr; Older</a>
                    </li>
                    <li class="page-item disabled">
                        <a class="page-link" href="#">Newer &rarr;</a>
                    </li>
                </ul>
            </div><!--./col-md-8 -->

            <!-- Sidebar Widgets Column -->
            <div class="col-md-4">
                <!-- Search Widget -->
                <div class="panel panel-light my-4">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <span class="glyphicon glyphicon-search"></span>  Search
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for...">
                            <span class="input-group-btn">
                  <button class="btn btn-secondary" type="button">Go!</button>
                </span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->
</section>