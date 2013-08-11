<?php include 'header.php'; ?>
<script type="text/javascript" src="<?= base_url('assets/scripts/actions.js') ?>"></script>
<input type="hidden" id="session-id" value="<?= $session; ?>"/>
<input type="hidden" id="page-account" value="1"/>
<p id="header_para">Details</p>
<div id="text_para">
    <form method="post" enctype="multipart/form-data" id="back_form" action="<?= site_url('home/search') ?>">
        <input type="hidden" name="search_qry" value="<?= $initial_qry; ?>">
        <input type="submit" name="search_button" value="Back to search results">
    </form>
    <table>
        <tr>
            <td colspan="2">Site details:</td>
        </tr>
        <tr>
            <td>URL : </td><td><?= $site_link; ?></td>
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
    <?php if (!empty($user_id)) { ?>
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

        </table>
    <?php } ?>
    <form method="post" enctype="multipart/form-data" id="back_form" action="<?= site_url('home/search') ?>">
        <input type="hidden" name="search_qry" value="<?= $initial_qry; ?>">
        <input type="submit" name="search_button" value="Back to search results">
    </form>
</div>
<?php include 'footer.php'; ?>