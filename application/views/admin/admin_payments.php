<?php $this->load->view('header'); ?>
<article class="c2p-wrap mt120 mb60">
    <section id="c2p-about">
        <section class="c2p-left">
            <h1>Payment history</h1>
            <p>
                <?php
                foreach ($payments as $one_payment) {
                    echo '<p>' . $one_payment->user_name . ' - ' . $one_payment->user_email . ' - ' . $one_payment->payment_plan . ' - ' . $one_payment->date . ' - ' . $one_payment->valid_to . '</p>';
                }
                ?>
            </p>
            <section class="mt120"></section>
        </section>
    </section>
</article>
<article class="c2p-wrap">
    <section id="c2p-about">
        <section class="c2p-left">
            <br/>
            <section class="mt20"></section>
        </section>
    </section>
</article>
<?php $this->load->view("footer"); ?>