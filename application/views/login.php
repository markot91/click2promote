<?php require_once "header.php"; ?>
<article id="c2p-intro">
    <section class="c2p-wrap">
        <h1>The Do It Yourself tool for SEO(1.0b)</h1>
        <article class="c2p-icons">
            <section id="c2p-track"><div class="c2p-track-icon"></div><h2>Tracking</h2></section>
            <section id="c2p-promote"><div class="c2p-promote-icon"></div><h2>Promoting</h2></section>
            <section id="c2p-analyze"><div class="c2p-analyze-icon"></div><h2>Analyzing</h2></section>
        </article>
        <div class="mb60"></div>
        <div class="clear"></div>
    </section>
</article>
<article class="c2p-wrap ">
    <section id="c2p-about">
        <section class="c2p-left">
            <h1>Login to your Account!</h1>
        </section>
    </section>
</article>

<article class="c2p-wrap">
    <section id="c2p-about">
        <section class="c2p-left">
            <?= form_open('login', array('id' => 'login')); ?>
            <section class="rounded-bg">
                <h2>Login with your e-mail address and password!</h2>  
                <p><label for="username">E-mail address:</label></p><p><input id="youremail" name="username" type="text" class="required" value="<?= set_value('username'); ?>"/></p>
                <?= form_error('username'); ?>
                <p><label for="password">Password:</label></p><p><input id="password" name="password" type="password" class="required" value="<?= set_value('password'); ?>"/></p>
                <?= form_error('password'); ?>
                <p><label class="error_msg_newUser"><?= $err_mgs; ?></label></p>
                <div id="error"><?php set_value('error_msg') ?></div>
                <input class="c2p-send" id="login_button" name="submit" type="submit" value="Login" />
                <a href="<?= site_url('users/forgot_password'); ?>" class="c2p-forgot">I Forgot My Password!</a>
            </section>
            </form>
        </section>
    </section>
</article>
<?php require_once "footer.php"; ?>