<?php require_once "header.php"; ?>

<script type="text/javascript" src="<?=base_url("assets/js/actions.js"); ?>"></script>
<script type="text/html" id="session-id"><?=$session; ?></script>
<script type="text/html" id="user-id"><?=$user_id; ?></script>
<script type="text/html" id="get_stats_single"><?=site_url('/admin/get_stats/'); ?></script>

<div id="text_para" class="mt120" style="margin-left: 60px;">
    <h2> Admin Dashboard!</h2>
    <div class="mb20 mt20" id="get_all_site_data">
        <a href="<?=site_url('admin/admin_set_data') ?>" target="_blank">Get All site data.</a>
    </div>
    <hr/>

    <div id="sites">
        <h2>Not approved:</h2>
        <div id="one_site">
            <?php
            $i = 1;
            foreach ($not_approved as $one) {

                echo '<div id="cell">' .
                        '<span class="num">' . ($i++) . ': </span>'.
                        '<a href="' . $one['link'] . '" target="_blank">' . $one['link'] . '</a>,' . $one['site'].
                        'User ID:  '.
                        '<a href="' . site_url("users/edit?edit=" . $one['user_id']) . '">(' . $one['user_id'] . ')'.$one['username'].'</a>'.
                        ', user e-mail:' . $one['email'] . ' <br/>';
                if (!empty($one['payment'])) {
                    echo 'Payment plan:' . $one['payment']->payment_plan;
                }
                echo '<form id="clear_form" method="POST" enctype="multipart/form-data" action="' . site_url('/admin/admin_action/') . '">' .
                    '<input type="hidden" name="id" value="' . $one['id'] . '">' .
                    '<input type="hidden" name="user_id" value="' . $one['user_id'] . '">' .
                    '<input type="submit" name="approve" value="Approve">' .
                    '<input type="submit" name="delete" value="Delete">' .
                    '</form>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <hr/>
    <div id="sites" class="approved">
        <h2>Approved:</h2>
        <div id="one_site">
            <?php
            $i = 1;
            foreach ($approved as $one) {
                echo '<div id="cell">'.
                        '<span class="num">' . ($i++) . ':</span>'.
                        '<a href="' . $one['link'] . '" target="_blank">' . $one['link'] . '</a>,' . $one['site'].
                        'User ID: '.
                        '<a href="' . site_url("users/edit?edit=" . $one['user_id']) . '">(' . $one['user_id'] . ')'.$one['username'].'</a>'.
                        ', user e-mail:' . $one['email'] . ' ';
                if (!empty($one['payment'])) {
                    echo 'Payment plan:' . $one['payment']->payment_plan;
                }
                echo '<a href="http://twitter.com/home?status=' . $one['link'] . '" id="twit" title="Share on twitter" target="_blank"><img src="' . base_url('assets/image/twitter.png') . '"  alt="Share on Twitter" width="32" height="32" /></a>';
                echo '<a href="http://digg.com/submit?phase=2&url=' . $one['link'] . '" id="digg" title="Share on Digg" target="_blank"><img src="' . base_url('assets/image/digg.png') . '"  alt="Share on Digg" width="32" height="32" /></a>';
                echo '<a href="http://www.facebook.com/sharer.php?u=' . $one['link'] . '" id="facebook" title="Share on Facebook" target="_blank"><img src="' . base_url('assets/image/facebook.png') . '"  alt="Share on facebook" width="32" height="32" /></a>';
                echo '<a href="http://stumbleupon.com/submit?url=' . $one['link'] . '" id="stumbleupon" title="Share on Stumbleupon" target="_blank"><img src="' . base_url('assets/image/stumbleupon.png') . '"  alt="Share on Stumbleupon" width="32" height="32" /></a>';
                echo '<form id="clear_form" method="POST" enctype="multipart/form-data" action="' . site_url('/admin/admin_action/') . '">' .
                        '<input type="hidden" name="id" value="' . $one['id'] . '">' .
                        '<input type="hidden" name="link" value="' . $one['link'] . '">' .
                        '<input type="hidden" name="user_id" value="' . $one['user_id'] . '">' .
                        '<input type="submit" name="delete" value="Delete">' .
                        '<input type="submit" name="disapprove" value="Disapprove">' .
                        '</form>';
                echo '<a href="#" id="get_stats_one_site">Update details .</a>';
                echo '<hr style="border-color: green;"/>';
                // echo '<a href="#">Toggle "getStats()"['.$one['data_collect'].'].</a>';
                echo '</div>';
            }
            ?>
        </div>
        <span id="page_links">
            <?php
            for ($i = 1; $i < $pages; $i++) {
                echo '<a href="#" id="page" class="page_link">' . $i . '</a>';
            }
            ?>
        </span>
    </div>
</div>
<script>
    if ($('a#page')) {
        $('a#page').on('click', function(e) {
            e.preventDefault();
            $('.page_link').css('font-weight', 'normal');
            $(this).css('font-weight', 'bolder');
            $.post("admin/get_next_30_approved",
                    {
                        session_id: $('#session-id').html(),
                        page: $(this).html()
                    },
            function(data) {
                $('.approved #one_site').html(data);
            }
            );
        });
    }
</script>
<?php require_once "footer.php"; ?>