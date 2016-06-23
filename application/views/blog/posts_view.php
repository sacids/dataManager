<?php
/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 20-Jun-16
 * Time: 11:19
 */
?>
<div class="container" style="margin-top: 60px;">
    <div class="row">

        <div class="col-md-10 col-md-offset-1">

            <?php foreach ($posts as $post) { ?>

                <article class="clearfix">
                    <div class="post-date"> <?php echo date("d M, Y g:i A", strtotime($post->date_created)) ?>
                        <!--| <a href="">Melissa Sing </a> <span><a href="">11 Comments</a></span>-->
                    </div>
                    <h2>
                        <a href="<?= base_url() . 'blog/post/post_details/' . $post->id ?>"><?php echo $post->title ?></a>
                    </h2>
                    <p>
                        <?php echo strip_tags(substr($post->content, 0, 300)) ?>
                        <a class="" href="<?= base_url() . 'blog/post/post_details/' . $post->id ?>">Read more</a>
                    </p>
                </article>

            <?php } ?>
        </div>
    </div>
</div>
