<?php
/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 20-Jun-16
 * Time: 12:16
 */

?>
<div class="container" style="margin-top: 60px;">
    <div class="row">
        <div class="col-md-8 col-lg-8 col-lg-offset-1 col-md-offset-1   ">

            <h1 class="text-center"><?php echo $post->title ?></h1><br/>

            <div class="post-date" style="margin-bottom: 10px;">
                <?php echo date("d M, Y g:i A", strtotime($post->date_created)) ?> | <span
                        class="text-info"><?= $post->first_name . " " . $post->last_name ?></span>
            </div>

            <div class="post-intro">
                <?php echo $post->content ?>
            </div>

            <!--<div class="post-date">
                tags | <a href="">JavaScript</a> , <a href="">jQuery</a> , <a href="">Angular</a>
                <span></span>
            </div>-->

            <ul class="social-links outline text-center">
                <li><a href="https://twitter.com/sacids"><i class="fa fa-twitter"></i></a></li>
                <li><a href="https://facebook.com/SACIDS/"><i class="fa fa-facebook"></i></a></li>
                <!--<li><a href="https://plus.google.com/+sacids"><i class="fa fa-google-plus"></i></a></li>-->
            </ul>
            <br/>
        </div>

        <div class="col-lg-3 col-md-3">

            <h3>Recent posts</h3>

            <?php foreach ($recent_posts as $p) { ?>

                <h4 style="font-weight: normal;"><?php echo anchor("blog/post/post_details/" . $p->id, $p->title); ?></h4>
                <div class=""><?php echo substr($p->content, 0, 50) ?></div>

            <?php } ?>

        </div>
    </div>
</div>