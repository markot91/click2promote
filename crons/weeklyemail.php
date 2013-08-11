<?php

if ($_GET['run'] == 'mysecret') {
    /*
     * Get user (id, email, name)
     * get site
     */

    $username = "root";
    $password = "";
    $hostname = "localhost";
//    $username = "agreg_rut";
//    $password = "csss";
//    $hostname = "webhomecamcom.fatcowmysql.com";
    $mysqli = mysqli_connect($hostname, $username, $password, "agregator");

    //  get all users and sites
    $res = mysqli_query($mysqli, "SELECT `sites`.index,`users`.user_id,`users`.user_name,`users`.user_email,`sites`.link FROM `users` JOIN `sites` on `users`.user_id=`sites`.user_id WHERE `users`.user_enabled=1 AND `users`.user_permisions<3 AND `users`.user_permisions>0 AND `sites`.data_collect=1 ORDER BY `sites`.index DESC");

    $user = array();
    $count = 0;
    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $user[$count] = $row;
            $count++;
        }
    }

    require_once './php_mailer/class.phpmailer.php';
    $mailer = new PHPMailer();
    $mailer->IsSMTP(); // telling the class to use SMTP
    $mailer->SMTPDebug = 1;                     // enables SMTP debug information (for testing)
    $mailer->SMTPAuth      = true;                  // enable SMTP authentication
    $mailer->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
    $mailer->Host = "smtp.web-homecam.com"; // sets the SMTP server
    $mailer->Port = 587;                    // set the SMTP port for the GMAIL server
    $mailer->Username = "info@click2promote.me"; // SMTP account username
    $mailer->Password = "Pass123!@#";        // SMTP account password
    $mailer->SetFrom('info@click2promote.me', 'Click2Promote.Me');
    $mailer->AddReplyTo('info@click2promote.me', 'Click2Promote.Me');
    $mailer->AddEmbeddedImage("assets/img/cp_small_logo_128x32.png",'logotop');
    
    //  for every user, get site detail, decode, send email
    foreach ($user as $one_site) {
        
        $body = file_get_contents('../email_templates/weeklyreport.html');
        //  get sites details
        $res = mysqli_query($mysqli, "SELECT data FROM `site_data` WHERE site_id=" . $one_site["index"] . " ORDER BY id DESC LIMIT 1");
        //  get it as row
        $row = $res->fetch_assoc();

        //  send mail to $one_site['user_email'] with name $one_site['user_name'] 
        //  for site $one_site['link'] , contains data $row['data'] (JSON format)
        //  using PHP Mailer
        
        //  first decode JSON object
        $site_data = json_decode($row['data']);
        
        //  create termporary login
        $code = rand(1000000, 9999999);
        $seccond_param = md5($one_site['user_name'].$one_site['user_email'].$one_site['user_id']);
        mysqli_query($mysqli,"INSERT INTO session(user_id,code) values('".$one_site['user_id']."','".$code."')");
        
        //  replace all variables in the template
        $body = str_replace("%code%", $code, $body);
        $body = str_replace("%user%", $seccond_param, $body);
        $body = str_replace("%user_id%", $one_site['user_id'], $body);
        $body = str_replace("?user_name?", $one_site['user_name'], $body);
        $body = str_replace("?user_email?", $one_site['user_email'], $body);
        $body = str_replace("?user_web?", $site_data->user_web, $body);
        $body = str_replace("?gog?", $site_data->gog, $body);
        $body = str_replace("?bn?", $site_data->bn, $body);
        $body = str_replace("?you?", $site_data->youtube, $body);
        $body = str_replace("?ax?", $site_data->ax, $body);
        $body = str_replace("?fb?", $site_data->fb, $body);
        $body = str_replace("?tw?", $site_data->tw, $body);        
        $body = str_replace("?mysp?", $site_data->mysp, $body);        
        
        //  assign receipient's address
        $mailer->AddAddress($one_site['user_email'], $one_site['user_name']);
        //subject
        $mailer->Subject = "Click2Promote.Me Weekly report for ".$site_data->user_web.".";
        //  assign body contents
        $mailer->MsgHTML($body);
//        print_r($body);
        $mailer->Send();
//        echo '<br/><br/><br/>';
    }
}
 else {
    header("Location: http://click2promote.me");
}
?>
