<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
            <link rel="icon" type="image/png" href="http://click2promote.me/assets/image/favicon.ico" />
            <title>Click2Promote | SEO Tool Extraordinaire</title>

            <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/screen.css'); ?>"/>
            <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/font-awesome.min.css'); ?>"/>
            <link href='http://fonts.googleapis.com/css?family=Quicksand|Sintony:400,700|Roboto:100,400,900' rel='stylesheet' type='text/css'/>
            <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/jquery-ui-1.10.3.custom.min.css') ?>" />
            <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/msgBoxLight.css') ?>" />

            <script type="text/javascript" src="<?= base_url('assets/js/jquery-2.0.1.min.js'); ?>"></script>
            <script type="text/javascript" src="<?= base_url('assets/js/jquery-ui-1.10.3.custom.min.js'); ?>"></script>
            <script type="text/javascript" src="<?= base_url('assets/js/c2p-clear-input.js'); ?>"></script>
            <script type="text/javascript" src="<?= base_url('assets/js/jquery.msgBox.js'); ?>"></script>
            <script type="text/javascript" src="<?= base_url('assets/js/actions.js'); ?>"></script>
            <script type="text/javascript">
                $(document).ready(function() {
                    $("#nav-slide").hide();
                    $(".show_hide").show();

                    $('.show_hide').click(function() {
                        $("#nav-slide").slideToggle();
                    });
                });
            </script>
            <!-- social sharing-->
            <script type="text/javascript">var switchTo5x = false;</script>
            <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
            <script type="text/javascript">stLight.options({publisher: "b633cb7f-d597-45d3-a971-f59bf340ae79", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
            <!-- social sharing-->

    </head>
    <body>
        <header>
            <article class="c2p-wrap">
                <a href="http://click2promote.me/">
                    <section id="c2p-logo">
                    </section>
                </a>
                <nav id="nav">
                    <ul>
                        <?php if ($user_logedin) { ?>
                            <li><a href="<?= site_url($home); ?>">Dashboard</a></li>
                            <?php if ($user_perms == 3) { ?>
                                <li><a href="<?= site_url('home/search'); ?>">Search</a></li>
                                <li><a href="<?= site_url('users'); ?>">Users</a></li>
                            <?php } ?>
                            <li><a href="#c2p-contact">Contact</a></li>
                            <li><a href="<?= site_url('users/edit_my_account'); ?>">Account</a></li>
                            <li><a href="<?= site_url('home/faq'); ?>">FAQ</a></li>
                            <li><a href="<?= site_url('blog'); ?>">Blog</a></li>
                            <li><a href="<?= site_url('login/logout'); ?>">Logout</a></li>
                        <?php } ?>
                        <?php if (!$user_logedin) { ?>
                            <li><a href="<?= site_url('home/index_nologin'); ?>">Home</a></li>
                            <li><a href="<?= site_url('home/index_nologin#c2p-about-anchor'); ?>">About</a></li>
                            <li><a href="#c2p-contact">Contact</a></li>
                            <li><a href="<?= site_url('login#c2p-about'); ?>">Login</a></li>
                            <li><a href="<?= site_url('home/faq'); ?>">FAQ</a></li>
                            <li><a href="<?= site_url('blog'); ?>">Blog</a></li>
                            <li><a href="<?= site_url('users/signup'); ?>">Signup</a></li>
                        <?php } ?>
                    </ul>
                </nav>
                <section id="nav-mobile">
                    <a class="show_hide" href="#"><h1><i class="icon-list"></i></h1></a>	
                </section>

                <section id="nav-slide">
                    <ul>
                        <?php if ($user_logedin) { ?>
                            <li><a href="<?= site_url($home); ?>">Dashboard</a></li>
                            <?php if ($user_perms == 3) { ?>
                                <li><a href="<?= site_url('home/search'); ?>">Search</a></li>
                                <li><a href="<?= site_url('users'); ?>">Users</a></li>
                            <?php } ?>
                            <li><a href="#c2p-contact">Contact</a></li>
                            <li><a href="<?= site_url('users/edit_my_account'); ?>">Account</a></li>
                            <li><a href="<?= site_url('home/faq'); ?>">FAQ</a></li>
                            <li><a href="<?= site_url('blog'); ?>">Blog</a></li>
                            <li><a href="<?= site_url('login/logout'); ?>">Logout</a></li>
                        <?php } ?>
                        <?php if (!$user_logedin) { ?>
                            <li><a href="<?= site_url('home/index_nologin'); ?>">Home</a></li>
                            <li><a href="<?= site_url('home/index_nologin#c2p-about-anchor'); ?>">About</a></li>
                            <li><a href="<?= site_url('home/index_nologin#c2p-contact'); ?>">Contact</a></li>
                            <li><a href="<?= site_url('login#c2p-about'); ?>">Login</a></li>
                            <li><a href="<?= site_url('users/signup'); ?>">Signup</a></li>
                            <li><a href="<?= site_url('home/faq'); ?>">FAQ</a></li>
                            <li><a href="<?= site_url('blog'); ?>">Blog</a></li>
                        <?php } ?>
                    </ul>
                </section>

                <div class="clear"></div>
            </article>
        </header>
        <div class="mb60"></div>


