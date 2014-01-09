<?php $this->load->view('header'); ?>
<script type="text/javascript" src="<?= base_url('assets/js/tinymce/tinymce.min.js'); ?>"></script>

<script type="text/javascript">
    tinymce.init({
        selector:'textarea.blog-contents',
        plugins: "link, image"
    });

</script>
<?php
/*
 * Form attributes go here
 */
    $attributes = array('class' => '', 'id' => 'create-blog-form');
    $urlParam = !empty($id) ? $id : '';
    $formUrl = 'blog/newblog/'.$urlParam;
?>
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
                 <?php if(!empty($user) && !empty($id)):?>
                    <h2>
                        Creating new entry for: <?php echo $user->user_name." ($id)"; ?>
                    </h2>
                 <?php endif; ?>
                 <?php echo validation_errors(); echo"<br/><br/>"; ?>
                 
                    <?php echo form_open($formUrl, $attributes); ?>
                    <p>
                        <label for="blog_published">Publish</label>
                        <input id="blog_published" name="blog[published]" checked type="checkbox" value="1">
                    </p>
                    <p></p>
                    <p>
                        <label for="blog_url">URL (SEO friendly URL):</label>
                        <input class="form-text-field" name="blog[url]" id="blog_url" type="text" value="<?php echo set_value('blog[url]'); ?>" />
                    </p>
                    <p>
                        <label for="blog_title">Title: </label><br/>
                        <input class="form-text-field" id="blog_title" name="blog[title]" type="text" value="<?php echo set_value('blog[title]'); ?>" />
                    </p>
                    <p>
                        <label for="blog_contents">Content: </label><br/>
                        <textarea id="blog_contents" name="blog[contents]" class="blog-contents" cols="100" rows="15">
                            <?php echo set_value('blog[contents]'); ?>
                        </textarea>
                    </p>
                    <p>
                        <input class="c2p-send" id="blog_create_submit" name="blog[create_submit]" type="submit" value="Save" />
                        <a href="<?= site_url('blog/admin_list'); ?>" class="c2p-forgot">Cancel</a>
                    </p>
                    <?php echo form_close(); ?>
                    
            </section>
	</article>
</section>
<?php $this->load->view('footer'); ?>
