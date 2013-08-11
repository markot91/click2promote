<?php include 'header.php'; ?>
<article class="c2p-wrap mb60 mt120">
    <section id="c2p-about">
        <section class="c2p-left rounded-bg">
            <h1>Reset Password</h1> 
            <form id="reset_password" method="post" action="<?= site_url('/users/forgot_password'); ?>"> 
                <p>Please enter your e-mail, you will receive a new password shortly.</p>
                <input id="youremail" type="text" name="email_reset_pass" />
                <?php
                if (isset($invalidEmail)) {
                    echo ("<div><span>An e-mail with a new password has been sent. Please check your e-mail address.</span><div>");
                }
                ?>
                <input class="c2p-send" name="save" type="submit" value="Submit" /> 
            </form>
            <section class="mb60"></section>
        </section>
    </section>
</article>
<article class="c2p-wrap">
    <section id="c2p-about">
        <section class="c2p-left">
            <br/>
            <section class="mt120"></section>
        </section>
    </section>
</article>
<?php include 'footer.php'; ?>