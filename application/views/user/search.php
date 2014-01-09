<?php $this->load->view('header'); ?>
<script language="javascript" type="text/javascript" src="<?= base_url('assets/scripts/actions.js') ?>"></script>
<article class="c2p-wrap mt120">
    <section id="c2p-about">
        <section class="c2p-left rounded-bg">
            <h1>Looking for something? Try searching Click2Promote.ME's database.</h1>
            <form  class="" method="post" enctype="multipart/form-data" action="<?= $form_action ?>" id="search_form">
                <input type="text" name="search_qry" value="<?= $initial_qry; ?>"id="youremail"><br/>
                <input type="submit" name="search_button_keyw" class="c2p-send" value="Go!">
                <a href="#" id="advanced_search_show">Advanced search options</a>
                <div id="advanced_search">
                    <input type="checkbox" name="searchop[]" value="url">Search by URL
                    <input type="checkbox" name="searchop[]" value="key">Search by keywords
                    <input type="checkbox" name="searchop[]" value="name">Search by name
                </div>
                <div>
                    <?php if ($found == true) { ?>
                    <p class="mt20 mb20">Found <?= $total->total; ?> results matching your criteria.</p>
                        <?php
                    }
                    else {
                        if ($search == true) {
                            ?>
                            It seems that we don't have that in the database. Would you be interested in another serach?
                            <?php
                        }
                    }
                    ?>
                </div>
            </form>
            <p id="search_results">
                <?php
                if ($found == true) {
                    $i = 1;
                    foreach ($result as $one_site) {
                        $short = (!empty($one_site->descr) ? $one_site->descr : $one_site->link);
                        if (strlen($short) > 14) {
                            $short = substr($short, 0, 14) . '...';
                        }
                        $profile = " <a href=\"" . site_url('users/user_account?id=' . $one_site->user_id . '&site_id=' . $one_site->index . "&srch_qry=" . $initial_qry) . "\" id=\"search_link_profile\">Go to profile</a>";
                        echo "<p title=\"http://{$one_site->link}\" id=\"result_row\"><b>" . ($i++) . "</b>:" .
                        $profile .
                        " ||| <a title=\"http://{$one_site->link}\" href=\"http://{$one_site->link}\" target=\"_blank\" id=\"search_link\">" . $short . "</a>" .
                        "</p>";
                    }
                }
                ?>
            </p>
            <p>
                <?php
                $count = 0;
                for ($i = 1; $i < ($pages - 1); $i++) {
                    $count++;
                    $page_number = $i;
                    if (!empty($active_page) && ($active_page == $i)) {
                        $page_number = '<u>' . $i . '</u>';
                    }
                    echo '<a href="' . site_url('home/search_paged?search_qry=' . $initial_qry . '&page=' . $i) . '" id="search_page_link">' . $page_number . '</a>';
                    if ($count > 20) {
                        $count = 0;
                        echo '<br/><br/>';
                    }
                }
                echo '<br/><br/>';
                ?>
            </p>

            </p>
            <section class="mt120"></section>
        </section>
    </section>
</article>

<script>
    if ($('a#page')) {
        $('a#page').live('click', function(e) {
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
<?php $this->load->view("footer"); ?>