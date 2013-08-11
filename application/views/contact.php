<?php require_once "header.php"; ?>
<script type="text/javascript" src="<?php echo base_url('assets/scripts/actions.js') ?>"></script>
<div class="mb60"></div>
<section id="c2p-contact">
    <article class="c2p-wrap gray">
        <section class="c2p-left">
            <h1>Contact Click2Promote</h1>
            <form id="mijnformuliertje" action="#" method="post">
                <input type="text" name="c2p-myemail" id="c2p-myemail" maxlength="100" value="Your E-mail">
                <textarea class="c2p-mymessage" id="c2p-mymessage" rows="10" cols="20" name="poraka"></textarea>
                <input id="c2p-send" class="c2p-send" type="submit" name="c2p-send" value="Send message">
            </form>
            <div class="mb20"></div>
        </section>
    </article>  
</section>

<?php require_once "footer.php"; ?>