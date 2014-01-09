<?php $this->load->view('header'); ?>
<script language="javascript" type="text/javascript" src="<?= base_url('assets/js/tablesorter/js/jquery.tablesorter.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/js/tablesorter/css/theme.default.css') ?>"/>
<script language="javascript" type="text/javascript" src="<?= base_url('assets/js/actions.js') ?>"></script>
<script language="javascript" type="text/javascript" src="<?= base_url('assets/js/style.js') ?>"></script>

<input type="hidden" id="user-home" value="2"/>
<input type="hidden" id="chart-url" value="<?= site_url('home/get_chart') ?>"/>
<input type="hidden" id="site-id" value="<?= $site_id ?>"/>
<input type="hidden" id="session-id" value="<?= $session; ?>"/>
<input type="hidden" id="schart" value="<?= $schart; ?>"/>
<article class="c2p-wrap mt120">
    <section>
        <section class="c2p-left mb20">
            <p id="header_para">
                Date: <?= date('d-M-Y'); ?>
                <span id="icons">
                    <span class="icon" title="Print this page"><a class="icon" href="#" onclick="javascript:window.print()"><img class="icon" src="<?= base_url('assets/image/print_icon.png') ?>"/></a></span>
                    <span class="icon" title="Get CSV file"><a class="icon" href="<?= site_url('home/get_csv?chart=' . $schart . '&site_id=' . $site_id . '&session_id=' . $session) ?>" ><img class="icon" src="<?= base_url('assets/image/doc-icon.png') ?>"/></a></span>
                    <span class="icon" title="Close this page"><a class="icon" href="#" onclick="javascript:window.close()"><img class="icon" src="<?= base_url('assets/image/close_icon.png') ?>"/></a></span>
                </span>
            </p>
        </section>
    </section>
</article>
<article class="c2p-wrap">
    <section id="c2p-about">
        <section class="c2p-left mb60">

            <div id="text_para_chart">

                <h4>Status report for the key word
                    <span id="user_web">
                        <a href="http://<?= $user_web; ?>" target="_blank"><?= $user_web; ?></a> 
                    </span> for the past month:
                </h4>
                <div id="table_holder">
                    <label for="chartfb_table" class="chartfb_table"><h2>Facebook</h2></label>
                    <table id="chartfb_table" class="chartfb_table tablesorter-default">
                        <thead>
                            <tr><th>Date</th><th>Number of appearances in search</th></tr>
                        </thead>
                        <tbody>
                        <img class="load" src="<?= base_url('assets/image/loading.gif') ?>">
                        </tbody>
                    </table>

                    <label for="charttw_table" class="charttw_table"><h2>Twitter</h2></label>
                    <table id="charttw_table" class="charttw_table tablesorter-default">
                        <thead>
                            <tr><th>Date</th><th>Number of appearances in search</th></tr>                            
                        </thead>
                        <tbody>
                        <img class="load" src="<?= base_url('assets/image/loading.gif') ?>">
                        </tbody>
                    </table>

                    <label for="chartgoogle_table" class="chartgoogle_table"><h2>Google</h2></label>
                    <table id="chartgoogle_table" class="chartgoogle_table tablesorter-default">
                        <thead>
                            <tr><th>Date</th><th>Number of appearances in search</th></tr>
                        </thead>
                        <tbody>
                        <img class="load" src="<?= base_url('assets/image/loading.gif') ?>">
                        </tbody>
                    </table>

                    <label for="chartbing_table" class="chartbing_table"><h2>Bing</h2></label>
                    <table id="chartbing_table" class="chartbing_table tablesorter-default">
                        <thead>
                            <tr><th>Date</th><th>Number of appearances in search</th></tr>
                        </thead>
                        <tbody>
                        <img class="load" src="<?= base_url('assets/image/loading.gif') ?>">                            
                        </tbody>
                    </table>

                    <label for="chartyoutube_table" class="chartyoutube_table"><h2>Youtube</h2></label>
                    <table id="chartyoutube_table" class="chartyoutube_table tablesorter-default">
                        <thead>
                            <tr><th>Date</th><th>Number of appearances in search</th></tr>
                        </thead>
                        <tbody>
                        <img class="load" src="<?= base_url('assets/image/loading.gif') ?>">                            
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </section>
</article>
<?php $this->load->view("footer"); ?>