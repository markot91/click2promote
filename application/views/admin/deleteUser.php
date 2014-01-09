<?php $this->load->view('header'); ?>
 <article class="c2p-wrap mt120 mb60">
        <section id="c2p-about">
            <section class="c2p-left">
                <h1>User Deleted</h1>
                <p>User "<?=$user_del['name']; ?>" was deleted successfully!</p>
                <input class="c2p-send" type="button" value="Go Back!" onclick="window.location='<?= site_url('/users'); ?>';" />
                <section class="mt120"></section>
            </section>
        </section>
    </article>
    <section class="mb60"></section>
<?php $this->load->view("footer"); ?>