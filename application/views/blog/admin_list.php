<?php $this->load->view('header'); ?>
<script language="javascript" type="text/javascript" src="<?= base_url('assets/js/tablesorter/js/jquery.tablesorter.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/js/tablesorter/css/theme.default.css') ?>"/>
<style>
    #blog_list{
     
    }
    #blog_list th {
        font-weight: bold;
        padding-bottom: 10px;
    }
    #blog_list th, #blog_list td {
        width: 180px;
        text-align: center;
    }
</style>
<script>
    $(function(){
        $('blog_list').tablesorter({ sortList: [[0,0], [1,0]] });
    })
</script>
<section id="c2p-about">
	<article class="c2p-wrap">
            <br/>
            <a href="<?= site_url('blog/newblog/') ?>">Create New Entry</a>
            <a href="<?= site_url('blog/admin_list/') ?>">Admin List</a>
            <a href="<?= site_url('blog') ?>">Back to Blog</a>
            <br/><br/>
            <?php //A Create Entry for user_id Link is displayed if
                  // there is a parameter in the url
                  if (!empty($selectedUserId) && !empty($selectedUserName)):
            ?>
                <a href="<?= site_url('blog/newblog/'.$selectedUserId); ?>">
                    Create New Entry for <?php echo $selectedUserName; ?>
                </a>
            <?php endif; ?>
             <section class=" mt120 mb60">
                 <?php if(count($blog) < 1): #no blog records have been found ?>
                 <p>There is no data to be displayed.</p>
                 <?php else: ?>
                <table id="blog_list">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>URL</th>
                        <th>User URL Name</th>
                        <th>Published</th>
                        <th>Created</th>
                        <th colspan="3">Operations</th>
                    </tr>  
                <?php foreach ($blog as $single_blog) { ?> 
                <tr>
                    <td>
                        <a href="<?= site_url("blog/index/".$single_blog->id);?>" target="_blank">
                            <?= $single_blog->id; ?>
                        </a>
                    </td>
                    <td><?= $single_blog->title; ?></td>
                    <td>
                        <a href="<?= site_url("blog/admin_list/".$single_blog->user_id); ?>">
                            <?= $single_blog->user_name; ?>
                        </a>      
                    </td>
                    <td><?= $single_blog->url; ?></td>
                    <td><?= $single_blog->user_url_name; ?></td>
                    <td><?= ($single_blog->published == 1 ? 'Yes':'No'); ?></td>
                    <td><?= $single_blog->createdon; ?></td>
                    <td>
                        <a href="<?=  site_url("blog/edit/".$single_blog->id);?>">Edit</a>
                    </td>
                    <td>
                        <a href="<?= site_url("blog/delete/".$single_blog->id);?>" onclick="return confirmDialog();">Delete</a>
                    </td>
                    <td>
                        <a href="<?= site_url("blog/publish/".$single_blog->id."/".$single_blog->published);?>">
                            <?= ($single_blog->published == 1 ? 'Unpublish':'Publish'); ?>
                        </a>
                    </td>
                </tr>
                <?php } ?>
                </table>
                <?php endif; ?>
            </section>
	</article>
</section>
<?php $this->load->view('footer'); ?>
<script>
    function confirmDialog() {
        return confirm("Are you sure you want to delete this record?");
    }
</script>