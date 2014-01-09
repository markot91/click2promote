<?php $this->load->view('header'); ?>

<?php
/*
 * Form attributes go here
 */
    $attributes = array('class' => '', 'id' => 'create-blog-form');
    
?>
<script type="text/javascript" src="<?= base_url('assets/js/tinymce/tinymce.min.js'); ?>"></script>

<script type="text/javascript">
    tinymce.init({
        selector:'textarea.blog-contents',
        plugins: "link, image"
    });

</script>
<style>
    #blog_list{
     
    }
    #blog_list th, #blog_list td {
        width: 180px;
        text-align: center;
    }
</style>
<section id="c2p-about">
	<article class="c2p-wrap">
             <section class="mt120 mb60">
                 <?php echo validation_errors(); echo"<br/><br/>"; ?>
                 
                 <?php if (count($blog) < 1): ?>
                 <p>This blog entry does not exist.</p>
                 <?php else: ?>
                    
                 <p>By: <?= $blog->user_name; ?>, User ID: <?= $blog->user_id; ?></p>
                    <p>Entry ID: <?= $blog->id; ?>, Created On : <?= $blog->createdon; ?></p>
                    <br/>
                    <?php echo form_open('blog/edit/'.$blogId, $attributes); ?>
                    <p>
                        <label for="blog_published">Published</label>
                        <input id="blog_published" name="blog[published]" type="checkbox" <?= $blog->published == 1 ? 'checked':''; ?> value="1" >
                    </p>
                    <p></p>
                    <p>
                        <label for="blog_url">URL (SEO friendly URL):</label>
                        <input class="form-text-field" name="blog[url]" id="blog_url" type="text" value="<?= set_value('blog[url]', $blog->url); ?>" />
                    </p>
                    <p>
                        <label for="blog_title">Title: </label><br/>
                        <input class="form-text-field" id="blog_title" name="blog[title]" type="text" value="<?= set_value('blog[title]', $blog->title); ?>">
                    </p>
                    <p>
                        <label for="blog_contents">Content: </label><br/>
                        <textarea class="blog-contents" id="blog_contents" name="blog[contents]" cols="100" rows="15"><?= set_value('blog[contents]', $blog->contents); ?></textarea>
                    </p>
                    <p>
                        <input class="c2p-send" id="blog_create_submit" name="blog[create_submit]" type="submit" value="Save" />
                        <a href="<?= site_url('blog/admin_list'); ?>" class="c2p-forgot">Cancel</a>
                    </p>
                    <?php echo form_close(); ?>
                    
                 <?php endif; ?>
            </section>
	</article>
</section>
<?php $this->load->view('footer'); ?>
