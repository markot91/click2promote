<?php

class Admin extends C2P_Controller {

    public function __construct() {
        parent::__construct();
    }
    public function index() {
        if ($this->user_id && ($this->user_perms > USER_LEVEL_MEDIUM)) {
            $this->load->model('UsersModel', 'user');
            $this->data['session'] = $this->session->userdata('user_db_sess');
            $this->data['user_id'] = $this->user_id;
            $approved_sites = $this->user->get_30_sites_approved();
            $not_approved_sites = $this->user->get_all_sites_not_approved();
            $pages = $this->count_approved_sites / 30;
            

            $this->data['pages'] = (int) $pages;
            $this->data['approved'] = array();
            $this->data['not_approved'] = array();
            //  approved sites
            foreach ($approved_sites->result() as $site) {
                $user = $this->user->get_user_by_id_only($site->user_id);
                $this->data['approved'][$site->index]['id'] = $site->index;
                $this->data['approved'][$site->index]['image_path'] = $site->image_path;
                $this->data['approved'][$site->index]['uploaded'] = $site->uploaded;
                $this->data['approved'][$site->index]['descr'] = $site->descr;
                $this->data['approved'][$site->index]['link'] = $site->link;
                $this->data['approved'][$site->index]['site'] = $site->site;
                $this->data['approved'][$site->index]['email'] = $site->email;
                $this->data['approved'][$site->index]['user_id'] = $site->user_id;
                $this->data['approved'][$site->index]['username'] = !empty($user->user_username) ? $user->user_name : "NaN";
                $this->data['approved'][$site->index]['data_collect'] = $site->data_collect;
//                $this->data['approved'][$site->index]['payment'] = $this->user->get_user_payment($site->user_id);
                ;
            }
            //  not approved sites
            foreach ($not_approved_sites->result() as $site) {
                $user = $this->user->get_user_by_id_only($site->user_id);
                $this->data['not_approved'][$site->index]['id'] = $site->index;
                $this->data['not_approved'][$site->index]['image_path'] = $site->image_path;
                $this->data['not_approved'][$site->index]['uploaded'] = $site->uploaded;
                $this->data['not_approved'][$site->index]['descr'] = $site->descr;
                $this->data['not_approved'][$site->index]['link'] = $site->link;
                $this->data['not_approved'][$site->index]['site'] = $site->site;
                $this->data['not_approved'][$site->index]['email'] = $site->email;
                $this->data['not_approved'][$site->index]['user_id'] = $site->user_id;
                $this->data['not_approved'][$site->index]['username'] = !empty($user->user_username) ? $user->user_name : "NaN";
//                $this->data['not_approved'][$site->index]['payment'] = $this->user->get_user_payment($site->user_id);
                ;
            }
            $this->load->view('admin/admin', $this->data);
        }
        else {
            redirect('login');
        }
    }

    public function get_next_30_approved() {
        if ($this->user_id && ($this->user_perms > USER_LEVEL_MEDIUM)) {

            $this->load->model('UsersModel', 'user');
            $session = $this->input->post('session_id');
            $page_start = $this->input->post('page');
            $html_output = '';
            if (!empty($session) && !empty($page_start)) {
                $this->data['session'] = $this->session->userdata('user_db_sess');
                $last_site_id = $this->user->get_last_approved_site_id();
                $approved_sites = $this->user->get_next_30_sites_approved($last_site_id, $page_start);

                $i = 1;
                foreach ($approved_sites->result() as $site) {
                    $payment = $this->user->get_user_payment($site->user_id);
                    $html_output = $html_output . '<div id="cell">' . 
                            '<span class="num">' . ($i++) . ':</span>' .
                            '<a href="http://' . $site->link . '" target="_blank">' . $site->link . '</a>,' . $site->site;
                    $html_output = $html_output . 'User ID: <a href="' . site_url("users/edit?edit=" . $site->user_id) . '">' . $site->user_id . '</a>, user e-mail:' . $site->email . ' ';
                    if (!empty($payment)) {
                        $html_output = $html_output . 'Payment plan:' . $payment->payment_plan . ', ';
                        $html_output = $html_output . 'Valid to : ' . $payment->valid_to;
                    }
                    $html_output = $html_output . '<a href="http://twitter.com/home?status=' . $site->link . '" id="twit" title="Share on twitter" target="_blank"><img src="' . base_url('assets/image/twitter.png') . '"  alt="Share on Twitter" width="32" height="32" /></a>';
                    $html_output = $html_output . '<a href="http://digg.com/submit?phase=2&url=' . $site->link . '" id="digg" title="Share on Digg" target="_blank"><img src="' . base_url('assets/image/digg.png') . '"  alt="Share on Digg" width="32" height="32" /></a>';
                    $html_output = $html_output . '<a href="http://www.facebook.com/sharer.php?u=' . $site->link . '" id="facebook" title="Share on Facebook" target="_blank"><img src="' . base_url('assets/image/facebook.png') . '"  alt="Share on facebook" width="32" height="32" /></a>';
                    $html_output = $html_output . '<a href="http://stumbleupon.com/submit?url=' . $site->link . '" id="stumbleupon" title="Share on Stumbleupon" target="_blank"><img src="' . base_url('assets/image/stumbleupon.png') . '"  alt="Share on Stumbleupon" width="32" height="32" /></a>';
                    $html_output = $html_output . '<form id="clear_form" method="POST" enctype="multipart/form-data" action="' . site_url('/admin/admin_action/') . '">' .
                            '<input type="hidden" name="id" value="' . $site->index . '">' .
                            '<input type="hidden" name="user_id" value="' . $site->user_id . '">' .
                            '<input type="submit" name="delete" value="Delete">' .
                            '<input type="submit" name="disapprove" value="Disapprove">' .
                            '</form>' .
                            '<a href="#" id="get_stats_one_site">Update details .</a>' .
                            '<hr style="border-color: green;"/>';
//                            '<a href="#">Toggle "getStats()"[' . $site->data_collect . '].</a>';
                            $html_output = $html_output . '</div>';
                }
                echo $html_output;
            }
            else {
                redirect('login');
            }
        }
        else {
            redirect('login');
        }
    }

    public function admin_action() {
        if ($this->user_id && ($this->user_perms > USER_LEVEL_MEDIUM)) {
            $this->load->model('UsersModel', 'user');
            $command = $this->input->post();
            //  if admin and there's a post command
            if (!empty($command['id'])) {
                //  approve the site
                if (!empty($command['approve'])) {
                    $this->user->approve_site($command['id']);
                    $site = $this->user->get_site_by_id($command['id']);
                    $user = $this->user->get_user_by_id($command['user_id']);
                    if (!empty($user)) {
                        try {
                            $message = ' Congratulations, your web site:<em style="font-weight: bold">"' . $site->link . '"</em> has been approved!<br/>' .
                                    ' You can log in to your account and start following the results of your marketing campaigns.';
                            $this->user->enable_user($user->user_id);
                            $email_params = array(
                                "subject" => "Your site has been approved!",
                                "to" => $user->user_email,
                                "message" => $message,
                            );
                            $this->sendEmailAdmin($email_params);
                        }
                        catch (Exception $e) {
                            log_message($e->getMessage());
                        }
                    }
                }
                if (!empty($command['disapprove'])) {
                    $this->user->approve_site($command['id']);
                    $site = $this->user->un_approve_site($command['id']);
                }
                if (!empty($command['delete'])) {
                    $this->user->approve_site($command['id']);
                    $site = $this->user->delete_site($command['id']);
                }
                redirect('admin');
            }
        }
        else {
            redirect('login');
        }
    }

    //  only run as admin, once per week
    public function admin_set_data() {
        $user = $this->user_id;
        //    if admin
        if ($this->user_id && ($this->user_perms == USER_LEVEL_ADMIN)) {
            $this->load->model('UsersModel', 'user');
            $sites = $this->user->get_all_sites_approved();
            var_export($sites->result(), true);
            $all_stats = array();
            foreach ($sites->result() as $one_site) {
                if (!empty($one_site->link) && !empty($one_site->index) && !empty($one_site->data_collect) && ($one_site->data_collect == 1)) {
                    //  add keywords to getStats()
                    //  column in the database
                    try {
                        $all_stats = $this->getStats($one_site->index, $one_site->link);
                        $all_stats = json_encode($all_stats);
                        $todays_date = date('Y-m-d h:i:s');
                        $this->user->set_site_stats(array('site_id' => $one_site->index, 'data' => $all_stats, 'datecollected' => $todays_date));
                    }
                    catch (Exception $e) {
                        log_message('info', "admin_set_data:" . $one_site->index . " - " . $one_site->link);
                    } log_message('info', "admin_set_data:getStats" . var_export($all_stats, TRUE));
                }
            }
            echo '{"get_all_data":"OK"}' . var_export($all_stats, TRUE);
            die();
        }
        else if ($this->user_id && ($this->user_perms == USER_LEVEL_ADMIN)) {
            redirect('admin');
        }
        else {
            redirect('login');
        }
    }

    //  only run as admin, once per week
    public function get_stats() {
        //  capture POST variables
        $user = $this->input->post('user_id');
        $admin_id = $this->input->post('admin_id');
        $session = $this->input->post('session');
        $site_index = $this->input->post('index');
        $site_link = $this->input->post('link');

        $this->load->model('UsersModel', 'user');
        $user_from_db = $this->user->get_user_by_id_only($admin_id);
        //    if 
        if (!empty($user_from_db->user_id) && ($user_from_db->user_permisions == USER_LEVEL_ADMIN)) {
            //  if URL exists
            if (!( $all_site_data = $this->user->site_exists($site_link))) {
                $site_user = $this->user->get_user_by_id_only($user);
                if (!empty($site_user)) {
                    $all_stats = array();
                    try {
                        $all_stats = $this->getStats($site_index, $site_link);
                        $all_stats = json_encode($all_stats);
                        $todays_date = date('Y-m-d h:i:s');
                        $this->user->set_site_stats(array('site_id' => $site_index, 'data' => $all_stats, 'datecollected' => $todays_date));
                        echo '{"status":"OK", "error":"0","site_id":"' . $site_index . '"}';
                    }
                    catch (Exception $e) {
                        log_message('info', "admin_set_data:" . $site_index . " - " . $site_link);
                    }
                }
            }
            else {
                echo '{"status":"error","reason":"site doesn\'t exist."}';
            }
        }
        else {
            redirect('login');
        }
    }

    private function getFacebook($qry) {
        $token = $this->getFacebookToken();
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
        $url = "https://graph.facebook.com/search?q=$qry&type=post&" . $token;
        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $output = curl_exec($ch);
        curl_close($ch);
        if (!empty($output)) {
            $el = json_decode($output, true);
            if (!empty($el['data'])) {
            return count($el['data']);
        }
        else {
            return 0;
        }
    }
            else {
                return 0;
            }
        }
        
    private function getFacebookGroups($qry) {
        $token = $this->getFacebookToken();
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
        $url = "https://graph.facebook.com/search?q=$qry&type=group&" . $token;
        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $output = curl_exec($ch);
        curl_close($ch);
        if (!empty($output)) {
            $el = json_decode($output, true);
            if (!empty($el['data'])) {
                return count($el['data']);
            }
            else {
                return 0;
            }
        }
        else {
            return 0;
        }
    }
    
    private function getFacebookPages($qry) {
        $token = $this->getFacebookToken();
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
        $url = "https://graph.facebook.com/search?q=$qry&type=page&" . $token;
        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $output = curl_exec($ch);
        curl_close($ch);
        if (!empty($output)) {
            $el = json_decode($output, true);
            if (!empty($el['data'])) {
                return count($el['data']);
            }
            else {
                return 0;
            }
        }
        else {
            return 0;
        }
    }

    
    
    private function getTwitter($qry,$site_id) {
        $this->load->model('UsersModel', 'user');
        $this->load->model('SiteModel', 'site');
        $t_connection = new stdClass();
        $content = new stdClass();
        //  get the site
        $site = $this->user->get_site_by_id($site_id);
        $srch_opts = array("q"=>$qry, "count"=>"100");
        //  check for last tweet id
        if(!empty($site->twitter_start_id)){
            $srch_opts["since_id"] = $site->twitter_start_id;
        }
        try{
            $t_connection = $this->getTwitterConnect();
            $content = $t_connection->get("search/tweets",$srch_opts);
        }
        catch(Exception $e){
            
        }
        if (!empty($content->statuses)) {
            $this->site->set_start_twitter_id($site_id,$content->search_metadata->max_id_str);
            return count($content->statuses);
        }
        else {
            return 0;
        }
    }

    private function getBing($qry) {
        $url = "http://www.bing.com/search?q=" . $qry;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1');
        $output = curl_exec($ch);
        curl_close($ch);
        $DOM = new DOMDocument();
        if (!empty($output)) {
            $pos = strpos($output, 'id="count"');
            if ($pos) {
                $mysp = strip_tags(substr($output, $pos, 300));
                preg_match_all('/[0-9,]+/', $mysp, $matches);
                $the_match = str_replace(',', '', $matches[0][0]);
                return $the_match;
            }
            else {
                return 0;
            }
        }
    }

    private function getGoogle($qry) {
        $url = "http://www.google.com/search?q=" . $qry;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.0) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.75 Safari/535.7');
        $output = curl_exec($ch);
        curl_close($ch);
        if (!empty($output)) {
            $pos = strpos($output, 'id=resultStats>');
            $gog = strip_tags(substr($output, $pos + 17, 1000));
            $gog = strtolower($gog);
            preg_match_all('/[0-9,]+/', $gog, $matches);
            $the_match = str_replace(',', '', $matches[0][0]);
            return $the_match;
        }
    }

    private function getYoutube($qry) {
        $url = "http://www.youtube.com/results?search_query=" . $qry;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.0) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.75 Safari/535.7');
        $output = curl_exec($ch);
        curl_close($ch);
        if (!empty($output)) {
            $pos = strpos($output, 'class="num-results">');
            $youtube = strip_tags(substr($output, $pos + 20, 1000));
            $youtube = strtolower($youtube);
            preg_match_all('/[0-9,]+/', $youtube, $matches);
            $the_match = str_replace(',', '', $matches[0][0]);
            return $the_match;
        }
    }

    private function getStats($id, $link) {

        $qry = urlencode($link);

        $this->data['user_web'] = $link;
        $this->data['fb'] = '0';
        $this->data['fbg'] = '0';   //facebook groups
        $this->data['fbp'] = '0';   //facebook pages
        $this->data['tw'] = '0';
        $this->data['bn'] = '0';
        $this->data['gog'] = '0';
        $this->data['ax'] = '0';
        $this->data['mysp'] = '0';
        $this->data['volu'] = '0';
        $this->data['mamma'] = '0';
        $this->data['yahoo'] = '0';
        $this->data['date'] = date('Y-m-d h:i:s');

        //  search facebook
        $output = $this->getFacebook($qry);
        if (!empty($output)) {
            $this->data['fb'] = $output;
        }
        //  search facebook
        //  search facebook groups
        $output = $this->getFacebookGroups($qry);
        if (!empty($output)) {
            $this->data['fbg'] = $output;
        }
        //  search facebook groups
        //  search facebook pages
        $output = $this->getFacebookPages($qry);
        if (!empty($output)) {
            $this->data['fbp'] = $output;
        }
        //  search facebook pages
        //  search twitter
        $output = $this->getTwitter($qry, $id);
        if (!empty($output)) {
            $this->data['tw'] = $output;
        }
        //  search twitter
        //  search Bing
        $output = $this->getBing($qry);
        if (!empty($output)) {
            $this->data['bn'] = $output;
        }
        //  search Bing
        //  search Google
        $output = $this->getGoogle($qry);
        if (!empty($output)) {
            $this->data['gog'] = $output;
        }
        //  search Google
        //  search Youtube
        $output = $this->getYoutube($qry);
        if (!empty($output)) {
            $this->data['youtube'] = $output;
        }
        //  search Youtube
        return $this->data;
    }

}

?>