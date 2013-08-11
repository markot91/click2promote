<?php require_once "header.php"; ?>
<script type="text/javascript" src="<?= base_url('assets/js/validate_signup.js') ?>"></script>
<section id="main_content">

    <span id="c2p-about-anchor">&nbsp;</span>
    <article class="c2p-wrap">
        <section id="c2p-about">
            <section class="c2p-left">
                <h1>Sign Up!</h1>
                <form id="mijnformuliertje" action="<?= site_url('users/signup'); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="check_email" id="check_email" value="<?= site_url('users/email_exist') ?>">
                    <input type="hidden" name="check_url" id="check_url" value="<?= site_url('users/site_exist') ?>">
                    <section class="rounded-bg">
                        <h2>Your information</h2>  
                        <input type="text" name="user_username" id="yourname" maxlength="100" value="Your Name" class="required" value="<?= set_value('user_username'); ?>"><?= form_error('user_username'); ?>
                        <input type="text" name="user_email" id="youremail" maxlength="100" value="Your E-mail" class="required" value="<?= set_value('user_email'); ?>"><?= form_error('user_email'); ?><div id="email_check"></div>
                    </section>
                    <section class="rounded-bg">
                        <h2>Choose a Password</h2>
                        <input type="password" name="user_password" id="password" maxlength="100" class="required" value="<?= set_value('user_password'); ?>"><?= form_error('user_password'); ?><div id="user_password_check"></div>
                        <input type="password" name="user_password1" id="password-again" maxlength="100" class="required" value="<?= set_value('user_password'); ?>"/> <?= form_error('user_password'); ?><div id="user_password_check1"></div> 
                    </section>
                    <section class="rounded-bg">
                        <h2>Your Website Info</h2>
                        <input type="text" name="site_name" id="sitename" maxlength="100" value="Your Site Name" class="required" value="<?= set_value('site_name'); ?>"><?= form_error('site_name'); ?>
                        <input type="text" name="site_url" id="siteurl" maxlength="100" value="Your Site URL" class="required" value="<?= set_value('site_url'); ?>"><?= form_error('site_url'); ?><div id="site_check"></div> 
                        <input type="text" name="site_desc" id="desc" maxlength="100" value="Short description of your site" class="required" value="<?= set_value('site_desc'); ?>"><?= form_error('site_desc'); ?>
                    </section>

                    <input class="c2p-send" id="complete_signup" type="submit" name="c2p-send" value="Complete Registration"> 
                    <p>By clicking "Complete Registration" you agree to the <a href="<?= site_url('home/terms'); ?>" target="_blank">Terms of use</a>. </p>
                    <p id="site_check">*All fields are mandatory. </p>

                </form>
            </section>
        </section>
    </article>
</section>
<?php require_once "footer.php"; ?>