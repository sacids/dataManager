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
        <div class="col-md-10 col-md-offset-1">

            <h1 class="text-center"><?php echo $post->title ?></h1><br/>

            <div class="post-date">
                May 26, 2014 | <a href="">Melissa Sing </a> <span><a href="">11 Comments</a></span>
            </div>

            <div class="post-intro">
                <?php echo $post->content ?>
            </div>

            <div class="post-date">
                tags | <a href="">JavaScript</a> , <a href="">jQuery</a> , <a href="">Angular</a>
                <span></span>
            </div>
            <ul class="social-links outline text-center">
                <li><a href="#link"><i class="icon-twitter"></i></a></li>
                <li><a href="#link"><i class="icon-facebook"></i></a></li>
                <li><a href="#link"><i class="icon-googleplus"></i></a></li>
            </ul>
            <br/>
        </div>
    </div>
</div>