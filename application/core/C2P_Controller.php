<?php

class C2P_Controller extends CI_Controller {

    protected $data = array();
    protected $user_id;
    protected $user_perms;
    protected $count_approved_sites;

    public function __construct() {
        parent::__construct();
        $tmp_agent = $this->agent->agent_string();
        if (strstr($tmp_agent, 'Android') || strstr($tmp_agent, 'iPhone') || strstr($tmp_agent, 'iPad') || strstr($tmp_agent, 'BlackBerry')) {
            $this->data['user_agent'] = true;
        }
        else {
            $this->data['user_agent'] = false;
        }
        $this->user_id = $this->session->userdata('user_id');
        $this->user_perms = $this->session->userdata('user_permisions');
        $this->count_approved_sites = $this->session->userdata('count_sites');
        $home = site_url();
        if (!empty($this->user_id) && ($this->user_perms == 3)) {
            $home = 'admin';
        }
        if (!empty($this->user_id) && ($this->user_perms < 3)) {
            $home = 'home';
        }
        $this->data['home'] = $home;
        $this->data['user_for_menu'] = $this->user_id;
        $this->data['user_perms'] = $this->user_perms;
        $this->data['user_logedin'] = $this->session->userdata('user_logedin') ? $this->session->userdata('user_logedin') : false;
        $this->data['count_approved_sites'] = $this->count_approved_sites;
        require_once APPPATH.'libraries/OAuth.php';
        require_once APPPATH.'libraries/twitteroauth.php';
//        $this->load->library('TwitterOAuth');
    }

    //  helpers
    
    //  generate random password
    //  used when reseting user's password
    protected function generatePassword($length) {
        $password = "";
        $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
        $maxlength = strlen($possible);
        if ($length > $maxlength) {
            $length = $maxlength;
        }
        $i = 0;
        while ($i < $length) {
            $char = substr($possible, mt_rand(0, $maxlength - 1), 1);
            if (!strstr($password, $char)) {
                $password .= $char;
                $i++;
            }
        }
        return $password;
    }

    //  array of variables and values
    //  load a template from fie system and
    //  replace variables
    protected function loadTemplateAndReplace($content, $template) {
        //  load template
        $body = file_get_contents($template);
        // replace
        foreach ($content as $key => $value) {
            $body = str_replace("%$key%", $value, $body);
        }

        return $body;
    }

    //  send an email
    protected function sendMailPHPmailer($params) {
        $error = '';
        $config = $this->config->item('gmail_cred');
        $message = $this->loadTemplateAndReplace(
                $params, $params["template"]);
        require_once './php_mailer/class.phpmailer.php';

        $mailer = new PHPMailer();
        $mailer->IsHTML();
        $mailer->IsSMTP(); // telling the class to use SMTP
        $mailer->SMTPDebug = 1;                     // enables SMTP debug information (for testing)
        $mailer->SMTPAuth = true;                  // enable SMTP authentication
        $mailer->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
        $mailer->Host = $config['smtp_host']; // sets the SMTP server
        $mailer->Port = $config['smtp_port'];                    // set the SMTP port for the GMAIL server
        $mailer->Username = $config['smtp_user']; // SMTP account username
        $mailer->Password = $config['smtp_pass'];        // SMTP account password
        $mailer->SetFrom($config['smtp_user'], 'Click2Promote.Me');
        $mailer->AddReplyTo($config['smtp_user'], 'Click2Promote.Me');

        $mailer->AddAddress($params["to"], $params["to"]);
        $mailer->Subject = $params["subject"];
        $mailer->MsgHTML($message);
        try {
            $mailer->Send();
        }
        catch (Exception $e) {
            $error = $e->getTraceAsString();
        }
        return $error;
    }

    // send an email to a user via admin panel
    protected function sendEmailAdmin($params) {
        $error = '';
        $config = $this->config->item('gmail_cred');
        $message = $this->loadTemplateAndReplace(
                array(
            "user_name" => $params["to"],
            "user_message" => $params["message"]
                ), "email_templates/message_template.html");
        require_once './php_mailer/class.phpmailer.php';

        $mailer = new PHPMailer();
        $mailer->IsHTML();
        $mailer->IsSMTP(); // telling the class to use SMTP
        $mailer->SMTPDebug = 1;                     // enables SMTP debug information (for testing)
        $mailer->SMTPAuth = true;                  // enable SMTP authentication
        $mailer->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
        $mailer->Host = $config['smtp_host']; // sets the SMTP server
        $mailer->Port = $config['smtp_port'];                    // set the SMTP port for the GMAIL server
        $mailer->Username = $config['smtp_user']; // SMTP account username
        $mailer->Password = $config['smtp_pass'];        // SMTP account password
        $mailer->SetFrom($config['smtp_user'], 'Click2Promote.Me');
        $mailer->AddReplyTo($config['smtp_user'], 'Click2Promote.Me');

        $mailer->AddAddress($params["to"], $params["to"]);
        $mailer->Subject = $params["subject"];
        $mailer->MsgHTML($message);
        try {
            $mailer->Send();
        }
        catch (Exception $e) {
            $error = $e->getTraceAsString();
        }
        return $error;
    }

    protected function sendEmail($emailConf) {
        $this->load->library('email', $this->config->item('gmail_cred'));
        $this->email->set_newline("\r\n");
        $this->email->from('info@click2promote.me', 'Click2Promote');
        $this->email->to($emailConf['user_email']);
        $this->email->subject('Information about your Click2Pomote.ME account!');
        $this->email->message($emailConf['email_content']);
        $error = false;
        if (!$this->email->send()) {
            show_error($this->email->print_debugger());
            $error = $this->email->print_debugger();
        }
        return $error;
    }

    //  helper method to cehck if account expired
    protected function calc_expiration($today, $valid_to) {
        $today = explode('-', $today);
        $valid_to = explode('-', $valid_to);
        $years = $today[0] - $valid_to[0];
        $months = $today[1] - $valid_to[1];
        $days = $today[2] - $valid_to[2];

        return array('days' => $days, 'moths' => $months, 'years' => $years);
    }

    protected function getFacebookToken() {
        $options = array(CURLOPT_RETURNTRANSFER => true, // return web page
            CURLOPT_HEADER => false, // don't return headers
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1',
            CURLOPT_HTTPHEADER => array('Host: graph.facebook.com'),
            CURLOPT_VERBOSE => 1,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_FAILONERROR => 0,
            CURLOPT_FOLLOWLOCATION => true, // follow redirects
            CURLOPT_ENCODING => "", // handle compressed
            CURLOPT_USERAGENT => "test", // who am i
            CURLOPT_AUTOREFERER => true, // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120, // timeout on connect
            CURLOPT_TIMEOUT => 120, // timeout on response
            CURLOPT_MAXREDIRS => 10); // stop after 10 redirects
        $url = "https://graph.facebook.com/oauth/access_token?client_id=289760531082885&client_secret=632921cd6494b735b0d00dbddc07575f&grant_type=client_credentials";
        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    protected function getTwitterConnect() {
        $t_config = $this->config->item('twitter');
        $connection = new TwitterOAuth(
                $t_config['twitter_consumer_token'], 
                $t_config['twitter_consumer_secret'], 
                $t_config['twitter_access_token'], 
                $t_config['twitter_access_secret']
        );
        return $connection;
    }

}

?>
