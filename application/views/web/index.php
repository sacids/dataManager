<section class="bg-white">
    <div class="container">
        <div class="row">

            <div class="col-lg-4">
                <img src="<?= base_url('assets/public/images/upload_new_form.png') ?>" width="100%"/>
                <h4 class="text-center"> Create Project</h4>
                <p class="text-center">
                    <a href="<?= site_url('create-project') ?>"
                       class="btn btn-maroon btn-sm">Read More <i class="fa fa-angle-double-right"></i>
                    </a></p>
            </div>

            <div class="col-lg-4">
                <img src="<?= base_url('assets/public/images/collect_data.png') ?>" width="100%"/>
                <h4 class="text-center">Collect online/offline data</h4>
                <p class="text-center"><a href="<?= site_url('collect-data') ?>"
                                          class="btn btn-maroon btn-sm">Read More <i
                                class="fa fa-angle-double-right"></i>
                    </a></p>
            </div>

            <div class="col-lg-4">
                <img src="<?= base_url('assets/public/images/visualize.png') ?>" width="100%"/>
                <h4 class="text-center">Visualize and Analyse data</h4>
                <p class="text-center"><a href="<?= site_url('analyze-data') ?>"
                                          class="btn btn-maroon btn-sm">Read More <i
                                class="fa fa-angle-double-right"></i>
                    </a></p>
            </div>

        </div>
    </div>
</section>

<div class="container-fluid">
    <div class="row">
        <hr/>
    </div>
</div>

<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h4>Success Stories</h4>
                <hr class="primary">
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Page Features -->
        <div class="row text-center">

            <?php
            if (isset($stories_lists)) {
                foreach ($stories_lists as $post) { ?>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card">
                            <?php if (file_exists('./assets/uploads/media/thumb_' . $post->media)) { ?>
                                <img class="card-img-top"
                                     src="<?= base_url('./assets/uploads/media/thumb_' . $post->media) ?>"
                                     alt="<?= $post->title ?>">
                            <?php } else { ?>
                                <img class="card-img-top" src="http://placehold.it/500x325" alt="">
                            <?php } ?>
                            <div class="card-body">
                                <h4 class="card-title">
                                    <a href="<?= site_url('newsletters/stories/post/' . $post->alias) ?>"><?= word_limiter($post->title, 6) ?></a>
                                </h4>
                                <p class="card-text"><?= strip_tags(word_limiter($post->story, 10)) ?></p>

                                <a href="<?= site_url('newsletters/stories/post/' . $post->alias) ?>"
                                   class="btn btn-default btn-sm">Read More <i class="fa fa-angle-double-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php }
            } ?>
        </div>
        <!-- /.row -->
    </div>
</section>

<section class="bg-primary">
    <div class="container text-center">
        <div class="call-to-action">
            <h4>Get involved with AfyaData.</h4>
            <hr class="white">
            <a href="https://play.google.com/store/apps/details?id=org.sacids.app.afyadata"
               class="btn btn-blue btn-xl">
                <i class="fa fa-android fa-lg"></i> Download App!</a>&nbsp;&nbsp;

            <a href="https://github.com/sacids/dataManager" class="btn btn-blue btn-xl">
                <i class="fa fa-github fa-lg"></i> Github Repository</a>
        </div>
    </div>
</section>