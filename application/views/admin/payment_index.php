<?php $this->load->view('header'); ?>
<script type="text/javascript" src="<?= base_url('assets/scripts/actions.js') ?>"></script>
<input type="hidden" name="confirm_url" id="confirm_url" value="<?= site_url('payment/record') ?>">
<span id="header_para">Sign-up for an account/Renew your account :</span>
<div id="text_para">
    <table border="0" width="100%">
        <tr>
            <td>
                <div id="payment_go">
                    <div id="PayPal">
                        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="paypal">
                            <input type="hidden" name="cmd" value="_s-xclick">
                            <input type="hidden" name="hosted_button_id" value="SEPZAES2K3WRJ">
                            <table>
                                <tr><td><input type="hidden" name="on0" value="Click2Promote.Me packages">Click2Promote.Me packages</td></tr>
                                <tr><td><select name="os0" style="width: auto;">
                                            <option value="One week trial">One week trial $7.99 USD</option>
                                            <option value="6 months package">6 months package $11.95 USD</option>
                                            <option value="Short term package - 1 year">Short term package - 1 year $24.95 USD</option>
                                            <option value="Long term package - 2 years">Long term package - 2 years $36.95 USD</option>
                                        </select> </td></tr>
                            </table>
                            <input type="hidden" name="currency_code" value="USD">
                            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynow_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                            <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                            <input type="button" name="cancel" value="Do this later!" onclick="window.location = '<?= site_url('login'); ?>'">
                        </form>


                    </div>
                    <?php /*                    <div id="Payza">
                      <form method="post" action="https://secure.payza.com/checkout" id="payza">
                      One week
                      <input type="hidden" name="ap_productid" value="jSXcpBKGR/NzpRHaxZjfJw=="/>
                      <input type="hidden" name="ap_quantity" value="1"/>
                      <input type="image" name="ap_image" src="https://secure.payza.com/PayNow/7BA14D5FB333477F832BCDF24E07FDBAb0en.gif"/>
                      </form>

                      <form method="post" action="https://secure.payza.com/checkout" id="payza">
                      6 months package
                      <input type="hidden" name="ap_productid" value="S1J1b5r2CQ/L0NXssZTAGg=="/>
                      <input type="hidden" name="ap_quantity" value="1"/>
                      <input type="image" name="ap_image" src="https://secure.payza.com/PayNow/7BA14D5FB333477F832BCDF24E07FDBAb0en.gif"/>
                      </form>


                      <form method="post" action="https://secure.payza.com/checkout" id="payza">
                      Short term package - 1 year
                      <input type="hidden" name="ap_productid" value="8uZ/KqiW3v0yNvBtKc1WPQ=="/>
                      <input type="hidden" name="ap_quantity" value="1"/>
                      <input type="image" name="ap_image" src="https://secure.payza.com/PayNow/7BA14D5FB333477F832BCDF24E07FDBAb0en.gif"/>
                      </form>

                      <form method="post" action="https://secure.payza.com/checkout" id="payza">
                      Long term package - 2 years
                      <input type="hidden" name="ap_productid" value="qqOcNYmi5A6DHScSBcDt1w=="/>
                      <input type="hidden" name="ap_quantity" value="1"/>
                      <input type="image" name="ap_image" src="https://secure.payza.com/PayNow/7BA14D5FB333477F832BCDF24E07FDBAb0en.gif"/>
                      </form>

                      </div>
                     *
                     */ ?>
                </div>
            </td>
        </tr>
    </table>
</div>
<?php $this->load->view("footer"); ?>