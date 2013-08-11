<?php include 'header.php'; ?>
<article class="c2p-wrap mt120">
    <section id="c2p-about">
        <section class="c2p-left rounded-bg">
            <h1>Email to: <?= !empty($user_email) ? $user_email : ""; ?></h1>
            <?php if (!empty($user_email)) { ?>
                <form method="post" action="<?= site_url('users/send_mail_to_user'); ?>" id="email_form">
                    <p>To:</p><input id="youremail" type="text" name="to" value=" <?= $user_email; ?>"/><br/>
                    <p>Subject:</p><input type="text" id="youremail" name="subject" value="Regarding "/><br/>
                    <p class="mt20">Message:</p><br/>
                    <textarea rows="10" name="message" class="c2p-mymessage" id="c2p-mymessage"></textarea>
                    <br/>
                    <input class="c2p-send mt20" type="submit" name="send" value="Send">
                </form>
                <?php
            }
            else if (!empty($message)) {
                echo $message;
            }
            else {
                echo "User not found!!!";
            }
            ?> 
            <section class="mt120"></section>
            <section class="mt120"></section>
        </section>
    </section>
</article>
<p id="header_para"></p>
<div id="text_para">

</div>
<?php include 'footer.php'; ?>