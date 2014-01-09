<?php $this->load->view('header');?>

<section id="c2p-about">
	<article class="c2p-wrap">
             <section class="c2p-left">
                <?php foreach ($blog as $single_blog) { ?> 
                <h1><a href="<?=  site_url('blog/index/'.$single_blog->id)?>"><?= $single_blog->title; ?></a></h1>
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
            <section class="c2p-righ mt20">
                <?php if($this->session->userdata('user_id')): ?>
                    <?php if($this->session->userdata('user_permisions') > USER_LEVEL_MEDIUM): ?>
                    <h2>Administrator Operations</h2>
                    <p>
                        <a href="<?= site_url('blog/admin_list'); ?>">Manage Articles</a>
                    </p>
                    <?php endif; ?>
                <h2>Operations</h2>
                <p>
                    <a href="<?= site_url('blog/createblog'); ?>">Create New Article</a>
                </p>
                <p>
                    <a href="#">My Articles</a>
                </p>
                <?php endif; ?>
                <h2>Last Five Articles</h2>
                <?php foreach ($last_five as $single_line) { ?>                
                <p>
                    <a href="<?=site_url('blog/index/'.$single_line->id); ?>"><?=$single_line->title; ?></a>-(<?=date('d-m-Y', strtotime($single_line->createdon)); ?>)
                </p>
                <?php } ?>
            </section>
	</article>
</section>
<?php $this->load->view("footer"); ?>