<?php $this->load->view('header'); ?>
<script type="text/javascript" src="<?= base_url('assets/scripts/actions.js') ?>"></script>
<input type="hidden" id="session-id" value="<?= $session; ?>"/>
<input type="hidden" id="page-account" value="1"/>
<?php if (!empty($site_link)) { ?>
    <p id="header_para">Details for <?= $site_name; ?></p>
    <div id="text_para">
        <table>
            <tr>
                <td id="share" colspan="4">
                    <!-- AddThis Button BEGIN -->
                    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-512871630de73405"></script>
                    <div class="addthis_toolbox addthis_default_style ">
                        <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                        <a class="addthis_button_tweet"></a>
                        <a class="addthis_button_pinterest_pinit"></a>
                        <a class="addthis_counter addthis_pill_style"></a>
                    </div>
                    <!-- AddThis Button END -->
                </td>
            </tr>
            <tr>
                <td colspan="2">Site details:</td>
            </tr>
            <tr>
                <td>URL : </td><td><a href="<?= $site_link; ?>" target="_blank"><?= $site_link; ?></a></td>
            </tr>
            <tr>
                <td>Name: </td><td><?= $site_name; ?></td>
            </tr>
            <tr>
                <td>Keywords: </td><td><?= $site_keywords; ?></td>
            </tr>
            <tr>
                <td>Contact e-mail: </td><td><?= $site_email; ?></td>
            </tr>
            <tr id="v_space30">
                <td>   </td>
            </tr>
            <tr id="v_space30">
                <td>   </td>
            </tr>
            <tr id="v_space">
                <td>   </td>
            </tr>
        </table>
        <?php if ($public > 0) { ?>
            <table>
                <tr>
                    <td>Owner details:</td><td></td>
                </tr>
                <tr>
                    <td>E-mail:</td><td><?= $email; ?></td>
                </tr>

                <tr>
                    <td>Name:</td><td><?= $name; ?></td>
                </tr>
                <tr>
                    <td>Country: </td><td><?= $country; ?></td>
                </tr>
                <tr>
                    <td>City:</td><td><?= $city; ?></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td>Twitter:</td><td><a id="soc_link" target="_blank" href="http://twitter.com/<?= $user_twitter; ?>"><?= $user_twitter; ?></a> <img id="soc_logo" src="<?= base_url("assets/img/facebook.png"); ?>"></td>
                </tr>
                <tr>
                    <td>Facebook:</td><td><a id="soc_link" target="_blank" href="http://www.facebook.com/<?= $user_facebook; ?>"><?= $user_facebook; ?></a> <img id="soc_logo" src="<?= base_url("assets/img/twitter.png"); ?>"></td>
                </tr>

            </table>
        <?php } ?>
    </div>
    <?php
} 
else {
    ?>
    <p id="header_para">Profile not found</p>
    <div id="text_para"> Please try again!</div>
    <?php
}
?>
<?php $this->load->view("footer"); ?>