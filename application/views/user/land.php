<?php $this->load->view('header'); ?>
<script language="javascript" type="text/javascript" src="<?= base_url('assets/js/actions.js') ?>"></script>
<script language="javascript" type="text/javascript" src="<?= base_url('assets/js/jqplot/excanvas.min.js') ?>"></script>
<script language="javascript" type="text/javascript" src="<?= base_url('assets/js/jqplot/jquery.jqplot.min.js') ?>"></script>
<script language="javascript" type="text/javascript" src="<?= base_url('assets/js/jqplot/plugins/jqplot.categoryAxisRenderer.min.js') ?>"></script>
<script language="javascript" type="text/javascript" src="<?= base_url('assets/js/jqplot/plugins/jqplot.barRenderer.min.js') ?>"></script>
<script language="javascript" type="text/javascript" src="<?= base_url('assets/js/jqplot/plugins/jqplot.canvasTextRenderer.min.js') ?>"></script>
<script language="javascript" type="text/javascript" src="<?= base_url('assets/js/jqplot/plugins/jqplot.dragable.min.js') ?>"></script>
<script language="javascript" type="text/javascript" src="<?= base_url('assets/js/jqplot/plugins/jqplot.highlighter.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/js/jqplot/jquery.jqplot.min.css') ?>" />
<script>
    $(document).ready(function() {
        if (!is_mobile() ) {
//            $("#sortable").sortable();
//            $("#sortable").disableSelection();
            $("[class$=-bar]").tooltip({position: {my: "left+15 center", at: "right center"}});
            $(".ui-state-default div").tooltip({position: {my: "left+15 center", at: "right center"}});
        }
    });
</script>
<input type="hidden" id="user-home" value="1"/>
<input type="hidden" id="chart-url" value="<?= $chart_url ?>"/>
<input type="hidden" id="site-id" value="<?= $site_id ?>"/>
<input type="hidden" id="session-id" value="<?= $session; ?>"/>

<div id="c2p-dashboard-stats">

    <section class="c2p-wrap">
        <h2><?= $user_web; ?></i>'s dashboard</h2>
        <div id="text_para_chart">
            <section id="c2p-dashboard">
                <br />
                <h3>Report for 
                    <span id="user_web">
                        <a href="http://<?= $user_web; ?>" target="_blank"><?= $user_web; ?></a> 
                    </span> for the past week: 
                </h3>
            </section>
        </div>
        <section id="stats">
            <p id="service" class="fb-bar" title="A larger number is better, that means more Facebook users are interested in your site." ><?= $fb; ?> appearances in public <a href="http://www.facebook.com" target="_blank">Facebook</a> searches.</p>
            <p id="service" class="tw-bar" title="A larger number is better, that means more Twitter users are interested in your site."><?= $tw; ?> appearances in public <a href="http://www.twitter.com" target="_blank">Twitter</a> searches.</p>
            <p id="service" class="bn-bar" title="A larger number is better."><?= $bn; ?> appearances on <a href="http://www.bing.com" target="_blank">Bing</a> searches.</p>
            <p id="service" class="gog-bar" title="A larger number is better."><?= $gog; ?> appearances on <a href="http://www.google.com" target="_blank">Google</a> searches.</p>
            <p id="service" class="youtube-bar" title="A larger number is better."><?= $youtube; ?> appearances on <a href="http://www.youtube.com" target="_blank">Youtube</a> searches.</p>
        </section>

        <section id="news">
            <a class="twitter-timeline" data-dnt="true" href="https://twitter.com/click2promote" data-widget-id="302292271255130112">Tweets by @click2promote</a>
            <script>!function(d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (!d.getElementById(id)) {
                        js = d.createElement(s);
                        js.id = id;
                        js.src = "//platform.twitter.com/widgets.js";
                        fjs.parentNode.insertBefore(js, fjs);
                    }
                }(document, "script", "twitter-wjs");
            </script>
        </section>
    </section>
</div>

<article id="c2p-set-date">
    <section class="c2p-wrap">
        <span id="choose_interval">
            <form id="report_interval" action="<? echo site_url('home/get_chart_interval'); ?>" method="post">
                <h3>Choose a date interval:
                    <input type="hidden" name="site_id" value="<?= $site_id ?>"/>
                    <input type="hidden" name="session_id" value="<?= $session; ?>"/>
                    <input type="text" name="from" id="date_from">
                    to <input type="text" name="to" id="date_to">
                    <input type="submit" value="Get report" id="submit_report_interval" class="c2p-send submit-button">
                </h3>
            </form>
        </span>
    </section>
</article>

<article class="c2p-wrap">
    <div id="other_users">
        <h2>
            Here you can see the rankings of your
            web site in the most popular search engines and social networks.
        </h2>
        <h4>
            Click on any chart to get detailed information about the previous period.
        </h4>
    </div>    
    <div id="other_users">
        <h4>
            <br/><br/>
        </h4>
    </div>
    <div id="chart_holder">
        <ul id="sortable">
            <li class="ui-state-default"><div id="chartfb" title="A larger number is better, that means more Facebook users are interested in your site." ><img class="load" src="<?= base_url('assets/image/loading.gif') ?>"></div></li>
            <li class="ui-state-default"><div id="charttw" title="A larger number is better, that means more Twitter users are interested in your site."><img class="load" src="<?= base_url('assets/image/loading.gif') ?>"></div></li>
            <li class="ui-state-default"><div id="chartgoogle" title="A larger number is better."><img class="load" src="<?= base_url('assets/image/loading.gif') ?>"></div></li>
            <li class="ui-state-default"><div id="chartbing" title="A larger number is better."><img class="load" src="<?= base_url('assets/image/loading.gif') ?>"></div></li>
            <li class="ui-state-default"><div id="chartyoutube" title="A larger number is better."><img class="load" src="<?= base_url('assets/image/loading.gif') ?>"></div></li>
        </ul>
    </div>
</div>
</article>
<?php $this->load->view("footer"); ?>