<?php $this->load->view('header'); ?>
<div id="fb-root"></div>

<script type="text/javascript" src="<?= base_url('assets/js/actions.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/facebook.js') ?>"></script>
<input type="hidden" id="session-id" value="<?= $session; ?>"/>
<input type="hidden" id="page-account" value="1"/>

<article class="c2p-wrap">
    <h1>My Account Details</h1>
</article>
<script>
    $(document).ready(function() {
        $("section p").tooltip({position: {my: "left+15 center", at: "right center"}});
    });
</script>
<div id="text_para">
    <?php  /*    <div><a href="<?=site_url("payment/payments?id=".$user_id); ?>">Payment history</a></div> */ ?>
<article class="c2p-wrap">
    <h2>Site details:</h2>
    <form method="POST" action="<?= site_url('users/update_details') ?>" enctype="multipart/form-data" id="site_details">
        <input type="hidden" name="user_act" value="chg_site"/>
        <input type="hidden" name="site_id" value="<?= $site_id; ?>"/>
        <section class="rounded-bg">
            <p title="Site URL">URL:</p><p><input class="pass" type="text" name="link" value="<?= $site_link; ?>" id="change_pass"/></p>
            <p title="Your name">Name:</p><p><input class="pass" type="text" name="site" value="<?= $site_name; ?>" id="change_pass"/></p>
            <p title="Keywords describing your site">Keywords:</p><p><input class="pass" type="text" name="descr" value="<?= $site_keywords; ?>" id="change_pass"/></p>
            <p title="Your email address also used as a username to login">E-mail:</p><p><input class="pass" type="text" name="email"  value="<?= $site_email; ?>" id="change_pass"/></p>
            <p><input class="c2p-send" type="submit" name="go" id="form_update_site" value="Save"></p>
        </section>
    </form>

    <h2>Profile</h2>
    <form title="Personal information." method="POST" action="<?= site_url('users/edit_my_account') ?>" enctype="multipart/form-data" id="account_details">
        <input type="hidden" name="user_act" value="edit"/>
        <input type="hidden" name="client" value="<?= $this->session->userdata('user_client_id') ?>">
        <input type="hidden" name="id" value="<?= $this->session->userdata('user_id') ?>"/>
        <section class="rounded-bg"> 
            <!--<p>Is Public profile: <input type="checkbox" name="is_public" <?php if ($is_public > 0) { ?> checked <?php } ?> value="1"></p>-->
            <p title="Your email">E-mail:</p><p><input type="text" id="youremail" name="email" value="<?= ($email ? $email : set_value('email')); ?>"><?= form_error('email'); ?></p>
            <p title="Your Full Name">Name:</p><p><input type="text" id="yourname" name="name" value="<?= ($name ? $name : set_value('name')); ?>"></p>
            <p title="Your Street Address">Address:</p><p><input type="text" id="yourname" name="address" value="<?= ($address ? $address : set_value('address')); ?>"/></p>
            <p title="Your Country of residence">Country:</p>
            <p>
                <?php
                /*
                <input type="text" id="yourname" name="country" value="<?= ($country ? $country : set_value('country')); ?>"/>
                */
                ?>
                <select id="country" name="country">
                    <option value ="">Select Country</option>
                    <?php
                        foreach($countryList as $singleCountry)
                        {
                            ?>
                            <option <?= ($country == $singleCountry->id ? "selected = 'selected'" : "") ?> value="<?= $singleCountry->id ?>"><?=$singleCountry->country?></option>
                            <?php
                        }
                    ?>
                </select>
            </p>
            <p title="State">State/province:</p><p><input type="text" id="yourname" name="state_province" value="<?= ($state_prov ? $state_prov : set_value('state_prov')); ?>"/></p>
            <p>City:</p><p><input type="text" id="yourname" name="city" value="<?= ($city ? $city : set_value('city')); ?>"/></p>
            <p title="Your email">Postal code:</p><p><input type="text" id="yourname" name="postal" value="<?= ($postal ? $postal : set_value('postal')); ?>"/></p>
            <p title="Your Phone Number">Telephone:</p><p><input type="text" id="yourname" name="phone" value="<?= ($phone ? $phone : set_value('phone')); ?>"/></p>
<?php /*       <p>Twitter ID:</p><p><input type="text" id="yourname" name="twitter" value="<?= ($twitter ? $twitter : set_value('twitter')); ?>"/></p>
            <p>Facebook ID:</p><p><input type="text" id="yourname" id="facebook" name="facebook" value="<?= ($facebook ? $facebook : set_value('facebook')); ?>"/></p>
  */ ?>
            <p><input class="c2p-send" type="submit" name="go" id="form_update_user" value="Save"></p>
        </section>
    </form>

    <h2>Change Password:</h2>
    <form  title="Change your password." method="POST" action="<?= site_url('users/change_password') ?>" enctype="multipart/form-data" id="change_pass_form">
        <input type="hidden" name="user_act" value="chg_password"/>
        <section class="rounded-bg">
            <p title="Enter your new password">New password:</p><p><input class="pass" type="password" name="change_pass" id="change_pass"/></p>
            <p title="Enter your new password again to confirm">Confirm:</p><p><input class="pass" type="password" name="change_pass_r" id="change_pass"/></p>
            <p><input class="c2p-send" type="submit" name="go" id="form_update_password" value="Save"></p>
        </section>
    </form>
</article>
</div>
<?php $this->load->view("footer"); ?>