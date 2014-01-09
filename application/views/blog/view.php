<?php $this->load->view('header'); ?>
<section>
    <article class="c2p-wrap">
        <h1>Blog Posts</h1>
        <section>
            <?php if (count($blog) == 0): ?>
            <p>No posts available.</p>
            <?php endif; ?>
            <?php foreach ($blog as $single_blog) { ?> 
                <h1>
                    <a href="<?= site_url('blog/view/'.$single_blog->user_url_name.'/'.$single_blog->url)?>">
                        <?= $single_blog->title; ?>
                    </a>
                </h1>
                <p><?= $single_blog->contents; ?></p>
                <br /><br />
                <p>Share this blog post with your friends :</p>
                        <span class='st_sharethis_large' displayText='ShareThis'></span>
                        <span class='st_email_large' displayText='Email'></span></li>
                        <span class='st_facebook_large' displayText='Facebook'></span>
                        <span class='st_twitter_large' displayText='Tweet'></span>
                        <span class='st_linkedin_large' displayText='LinkedIn'></span>
                        <span class='st_googleplus_large' displayText='Google +'></span>
                        <span class='st_digg_large' displayText='Digg'></span>
                        <span class='st_delicious_large' displayText='Delicious'></span>
                <?php } ?>
        </section>
    </article>
</section>
<?php $this->load->view('footer'); ?>