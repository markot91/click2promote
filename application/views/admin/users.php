<?php $this->load->view('header'); ?>
<script language="javascript" type="text/javascript" src="<?= base_url('assets/js/actions.js') ?>"></script>

<input type="hidden" name="admin" id="admin" value="1"/>
<article class="c2p-wrap mt120">
    <section id="c2p-about">
        <section class="c2p-left">
            <h1>User management</h1>
            <br/>
            <?php
            if (!empty($all_users)) {
                ?>
                <table width="980" border="0" align="center" cellpadding="2" cellspacing="0">
                    <tr>
                        <td><p>ID</p></td>
                        <td><p>Name</p></td>
                        <td><p>Payment</p></td>
                        <td><p>Phone</p></td>
                        <td><p>E-Mail</p></td>
                        <td><p>Active</p></td>
                        <td colspan="4"><p>Actions</p></td>
                    </tr>
                    <?php
                    $color = "1";
                    foreach ($all_users as $one_user) {
                        $payment = '';

                        $colorCode = "#A4A4A4";
                        if ($color == 1) {
                            $colorCode = "#A4A4A4";
                            $color = 2;
                        }
                        else if ($color == 2) {
                            $colorCode = "#E6E6E6";
                            $color = 1;
                        }
                        $enable_disable = site_url('users/enable_disable?user=' . $one_user['id'] . '&session=' . $session . '&admin=1') . '&en_dis=' . (($one_user['user_enabled'] == 1) ? 'no' : 'yes');
                        if (!empty($one_user['payment'])) {
                            $payment = 'Plan:' . $one_user['payment']->payment_plan . ',<br/> Valid to :' . $one_user['payment']->valid_to;
                        }
                        echo "<tr class=\"wordbreak\" bgcolor='" . $colorCode . "'>
                             <td><p>" . $one_user['id'] . "</p></td>
                             <td><p>" . $one_user['name'] . "</p></td>
                             <td><p><a href=\"" . site_url('payment/payments?id=' . $one_user['id']) . "\">" . $payment . "</a></p></td>
                             <td><p>" . $one_user['user_phone'] . "</p></td>
                             <td><p>" . $one_user['user_email'] . "</p></td>
                             <td><p><a href=\"#\" url=\"" . $enable_disable . "\" id=\"actve_deactive\">" . (($one_user['user_enabled'] == 1) ? 'Yes' : 'No') . "</a></p></td>
                             <td><p><a href=" . site_url('users/edit?edit=' . $one_user['id']) . ">Edit</a></p></td>
                             <td><p><a href=" . site_url('users/delete?delete=' . $one_user['id'] . '&name=' . urlencode($one_user['name']) ) . ">Delete</a></p></td>
                             <td><p><a href=" . site_url('users/send_mail_to_user?id=' . $one_user['id']) . ">Send email</a></p></td>
                             <td><p><a id=\"reset_pass\" href=\"#\" url=" . site_url('users/resetPassword?email=' . $one_user['user_email'] . '&admin=1') . ">Reset password</a></p></td>
                    </tr>";
                    }
                    ?>		
                </table>
                <?php
            }
            ?>
            <section class="mt120"></section>
        </section>
    </section>
</article>
<?php $this->load->view("footer"); ?>