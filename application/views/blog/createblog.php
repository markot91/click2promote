<?php  $this->load->view('header');

// the header and/or the footer are causing problems when
// submitting the form

    /*
     * assigning attributes for the form. Assign the attributes
     * such as class name and id here rather than on the form
     * itself.
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
<section>
    <article class="c2p-wrap">
        <h1>Create New Post</h1>
        <?php echo validation_errors(); ?>
        
        <?php echo form_open('blog/createblog', $attributes); ?>
            <section class="rounded-bg">
                <h2>Post Details</h2>  
                <label class="required" for="blog_title">Title<span>*</span></label>
                <input type="text" name="blog[title]" id="blog_title" maxlength="100" class="required" value="<?php echo set_value('blog[title]'); ?>">
                <br/>
                <label class="required" for="blog_contents">Content<span>*</span></label>
                <br/>
                <textarea name="blog[contents]" id="blog_contents" cols="50" rows="15" class="required blog-contents">
                    <?php echo set_value('blog[contents]'); ?>
                </textarea>
                <br/>
                <label for="blog_url">SEO Friendly URL</label>
                <input type="text" name="blog[url]" id="blog_url" maxlength="100" value="<?php echo set_value('blog[url]'); ?>">
                <br/>
                <label class="required" for="blog_published">Publish Post?<span>*</span></label>
                <select class="required" name="blog[published]" id="blog_published">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </section>
            
            <input class="c2p-send" id="blog_create_submit" type="submit" name="blog[create_submit]" value="Create Post">
            <p id="site_check">*All fields are mandatory. </p>
        <?php echo form_close(); ?>
    </article>
</section>

<?php $this->load->view('footer'); ?>
