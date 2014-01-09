<?php
class Users extends C2P_Controller {
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $this->data['all_users'] = array();
        if ($this->user_id && ($this->user_perms == USER_LEVEL_ADMIN)) {
            $this->load->model('UsersModel', 'user');
            $user_data = $this->user->get_all_users();
            foreach ($user_data->result() as $user) {
                $this->data['all_users'][$user->user_id]['payment'] = '';//$this->user->get_user_payment($user->user_id);
                $this->data['all_users'][$user->user_id]['id'] = $user->user_id;
                $this->data['all_users'][$user->user_id]['user_name'] = $user->user_username;
                $this->data['all_users'][$user->user_id]['name'] = $user->user_name;
                $this->data['all_users'][$user->user_id]['user_phone'] = $user->user_phone;
                $this->data['all_users'][$user->user_id]['user_email'] = $user->user_email;
                $this->data['all_users'][$user->user_id]['user_enabled'] = $user->user_enabled;
                $this->data['all_users'][$user->user_id]['user_permisions'] = $user->user_permisions;
            }
            $this->data['session'] = $this->session->userdata('user_db_sess');
            $this->load->view('admin/users', $this->data);
        }
        else {
            redirect('login');
        }
    }
    //  admin only, delete user
    public function delete() {
        if ($this->user_id && ($this->user_perms == USER_LEVEL_ADMIN)) {
            if ($this->input->get()) {
                if ($this->input->get('delete')) {
                    $user_id = $this->input->get('delete');
                    $this->load->model('UsersModel', 'user');
                    $this->user->delete_user($user_id);
                    $this->data['user_del']['user_id'] = $user_id;
                    $this->data['user_del']['name'] = urldecode($this->input->get('name'));
                    $this->load->view('admin/deleteUser', $this->data);
                }
            }
            else {
                redirect('users');
            }
        }
        else {
            redirect('login');
        }
    }
    //  admin, edit user
    public function edit() {
        if ($this->user_id && ($this->user_perms == USER_LEVEL_ADMIN)) {

            $User = array();
            $this->load->model('UsersModel', 'user');
            $this->load->library('form_validation');
            $this->load->helper('form');
            
           // load Countries
            $this->load->model('CountriesModel', 'countries');
            $countryList = $this->countries->getAllByCountrySort();
            $this->data['countryList'] = $countryList->result();
            // end of load Countries

            $this->form_validation->set_error_delimiters('<div id="error_msg_newUser">', '</div>');
//      if there's a post
            if ($this->input->post('user_act') == 'edit') {
                $User['session'] = $this->session->userdata('user_db_sess');
                $sess_data = $this->session->all_userdata();
                $this->form_validation->set_rules('name', 'Username', 'required');
                $this->form_validation->set_rules('email', 'email', 'required|valid_email');
                $User['user_id'] = $this->input->post('id');
                $User['user_username'] = $this->input->post('username');
                $User['user_name'] = $this->input->post('name');
                $User['user_email'] = $this->input->post('email');
                $User['user_address'] = $this->input->post('address');
                $User['user_country'] = $this->input->post('country');
                $User['user_state_prov'] = $this->input->post('state_province');
                $User['user_city'] = $this->input->post('city');
                $User['user_postal_code'] = $this->input->post('postal');
                $User['user_phone'] = $this->input->post('phone');
                $User['user_twitter'] = $this->input->post('twitter');
                $User['user_facebook'] = $this->input->post('facebook');
                $User['user_enabled'] = 1;
                $User['user_permisions'] = '1';
                if ($this->form_validation->run() == FALSE) {
                    echo '{"details_update":"validation_error"}';
                    die();
                }
                else {
                    $this->user->update_user($User);
                    echo '{"details_update":"OK"}';
                    die();
                }
            }
            $user_id = $this->input->get('edit');
            if (!empty($user_id)) {
                $user = $this->user->get_user_by_id($user_id);
                $this->data['session'] = $this->session->userdata('user_db_sess');
                $this->data['email'] = $user->user_email;
                $this->data['username'] = $user->user_username;
                $this->data['name'] = $user->user_name;
                $this->data['address'] = $user->user_address;
                $this->data['postal'] = $user->user_postal_code;
                $this->data['city'] = $user->user_city;
                $this->data['country'] = $user->user_country;
                $this->data['state_prov'] = $user->user_state_prov;
                $this->data['phone'] = $user->user_phone;
                $this->data['twitter'] = $user->user_twitter;
                $this->data['facebook'] = $user->user_facebook;

                $site = $this->user->get_site_by_userid($user_id);
                $this->data['site_name'] = !empty($site->site) ? $site->site : '';
                $this->data['site_keywords'] = !empty($site->descr) ? $site->descr : '';
                $this->data['site_link'] = !empty($site->link) ? $site->link : '';
                $this->data['site_email'] = !empty($site->email) ? $site->email : '';
                $this->data['site_id'] = !empty($site->index) ? $site->index : '';

                $this->load->view('user/myAccount', $this->data);
            }
            else {
                redirect('home');
            }
        }
        else {
            redirect('login');
        }
    }
    //  allow our users to edit their account details
    public function edit_my_account() {

        if ($this->user_id && ($this->user_perms == USER_LEVEL_USER)) {

            $User = array();
            $this->load->model('UsersModel', 'user');
            $this->load->library('form_validation');
            $this->load->helper('form');
            
            // load Countries
            $this->load->model('CountriesModel', 'countries');
            $countryList = $this->countries->getAllByCountrySort();
            $this->data['countryList'] = $countryList->result();
            // end of load Countries

            $this->form_validation->set_error_delimiters('<div id="error_msg_newUser">', '</div>');
//      if there's a post
            if ($this->input->post('user_act') == 'edit') {
                $User['session'] = $this->session->userdata('user_db_sess');
                $sess_data = $this->session->all_userdata();
                $this->form_validation->set_rules('name', 'Username', 'required');
                $this->form_validation->set_rules('email', 'email', 'required|valid_email');
                $User['user_id'] = $this->input->post('id');
                $User['user_username'] = $this->input->post('username');
                $User['user_name'] = $this->input->post('name');
                $User['user_email'] = $this->input->post('email');
                $User['user_address'] = $this->input->post('address');
                $User['user_country'] = $this->input->post('country');
                $User['user_state_prov'] = $this->input->post('state_province');
                $User['user_city'] = $this->input->post('city');
                $User['user_postal_code'] = $this->input->post('postal');
                $User['user_phone'] = $this->input->post('phone');
                $User['user_twitter'] = $this->input->post('twitter');
                $User['user_facebook'] = $this->input->post('facebook');
                $User['is_public'] = $this->input->post('is_public');
                $User['user_enabled'] = 1;
                $User['user_permisions'] = '1';
                if ($this->form_validation->run() == FALSE) {
                    echo '{"details_update":"validation_error"}';
                    die();
                }
                else {
                    $this->user->update_user($User);
                    echo '{"details_update":"OK"}';
                    die();
                }
            }
            $user = $this->user->get_user_by_id($this->user_id);

            $this->data['session'] = $this->session->userdata('user_db_sess');
            $this->data['email'] = $user->user_email;
            $this->data['username'] = $user->user_username;
            $this->data['name'] = $user->user_name;
            $this->data['address'] = $user->user_address;
            $this->data['postal'] = $user->user_postal_code;
            $this->data['city'] = $user->user_city;
            $this->data['country'] = $user->user_country;
            $this->data['state_prov'] = $user->user_state_prov;
            $this->data['phone'] = $user->user_phone;
            $this->data['twitter'] = $user->user_twitter;
            $this->data['facebook'] = $user->user_facebook;
            $this->data['is_public'] = $user->public;

            $site = $this->user->get_site_by_userid($this->user_id);
            $this->data['site_name'] = !empty($site->site) ? $site->site : '';
            $this->data['site_keywords'] = !empty($site->descr) ? $site->descr : '';
            $this->data['site_link'] = !empty($site->link) ? $site->link : '';
            $this->data['site_email'] = !empty($site->email) ? $site->email : '';
            $this->data['site_id'] = !empty($site->index) ? $site->index : '';
            $this->data['user_id'] = $this->user_id;
            $this->load->view('user/myAccount', $this->data);
        }
        else {
            redirect('login');
        }
    }
    //  loads user profile
    //  TODO : make view nice
    public function user_account() {
        if ($this->user_id && ($this->user_perms >= USER_LEVEL_USER)) {
            $this->load->model('UsersModel', 'user');
            $user_id = $this->input->get('id');
            $site_id = $this->input->get('site_id');
            $initial_qry = $this->input->get('srch_qry');
            $this->data['session'] = $this->session->userdata('user_db_sess');
            $this->data['initial_qry'] = $initial_qry;

            $site = $this->user->get_site_by_id($site_id);
            $this->data['user_id'] = $site->user_id;
            $this->data['site_name'] = !empty($site->site) ? $site->site : '';
            $this->data['site_keywords'] = !empty($site->descr) ? $site->descr : '';
            $this->data['site_link'] = !empty($site->link) ? $site->link : '';
            $this->data['site_email'] = !empty($site->email) ? $site->email : '';
            $this->data['site_id'] = !empty($site->index) ? $site->index : '';

            if ($user_id > 0) {
                $user = $this->user->get_user_by_id($user_id);
                $this->data['user_id'] = $user->user_id;
                $this->data['email'] = $user->user_email;
                $this->data['username'] = $user->user_username;
                $this->data['name'] = $user->user_name;
                $this->data['city'] = $user->user_city;
                $this->data['country'] = $user->user_country;
            }
            $this->load->view('user/user_profile', $this->data);
        }
        else {
            redirect('login');
        }
    }
//  admin send custom message to user
    public function send_mail_to_user() {
        $this->data['user'] = array();
        if ($this->user_id && ($this->user_perms > 1)) {
            $this->load->model('UsersModel', 'user');
            $id_from_request = $this->input->get("id");
            if ($this->input->post()) {
                $params = $this->input->post();
                if (!empty($params["to"]) && !empty($params["subject"]) && !empty($params["message"])) {
                    // send email
                    $error = $this->sendEmailAdmin($params);
                    if ($error) {
                        $this->data['message'] = $error;
                    }
                    else {
                        $this->data['message'] = "e-mail sent!";
                    }
                }
            }
            else if (!empty($id_from_request)) {
                $user = $this->user->get_user_by_id_only($id_from_request);
                $this->data['payment'] = '';//$this->user->get_user_payment($user->user_id);
                $this->data['id'] = $user->user_id;
                $this->data['user_name'] = $user->user_username;
                $this->data['name'] = $user->user_name;
                $this->data['user_phone'] = $user->user_phone;
                $this->data['user_email'] = $user->user_email;
                $this->data['user_enabled'] = $user->user_enabled;
                $this->data['user_permisions'] = $user->user_permisions;
            }
            $this->load->view('admin/mail_user', $this->data);
        }
        else {
            redirect('login');
        }
    }
    //  TODO : site profile, is working, but needs styling
    public function profile() {
        $this->load->model('UsersModel', 'user');
        $site_id = $this->input->get('site_id');
        $this->data['session'] = $this->session->userdata('user_db_sess');

        $site = $this->user->get_site_by_id($site_id);
        if (!empty($site)) {
            $user_id = $site->user_id;
            $user_profile = $this->user->get_user_by_id_only($site->user_id);
            $this->data['user_id'] = $site->user_id;
            $this->data['site_name'] = !empty($site->site) ? $site->site : '';
            $this->data['site_keywords'] = !empty($site->descr) ? $site->descr : '';
            $this->data['site_link'] = !empty($site->link) ? $site->link : '';
            $this->data['site_email'] = !empty($site->email) ? $site->email : '';
            $this->data['site_id'] = !empty($site->index) ? $site->index : '';

            $this->data['public'] = $user_profile->public;
            if ($user_profile->public > 0) {
                $this->data['user_id'] = !empty($user_profile->user_id) ? $user_profile->user_id : " ";
                $this->data['email'] = !empty($user_profile->user_email) ? $user_profile->user_email : " ";
                $this->data['username'] = !empty($user_profile->user_username) ? $user_profile->user_username : " ";
                $this->data['name'] = !empty($user_profile->user_name) ? $user_profile->user_name : " ";
                $this->data['city'] = !empty($user_profile->user_city) ? $user_profile->user_city : " ";
                $this->data['country'] = !empty($user_profile->user_country) ? $user_profile->user_country : "";
                $this->data['user_twitter'] = !empty($user_profile->user_twitter) ? $user_profile->user_twitter : "";
                $this->data['user_facebook'] = !empty($user_profile->user_facebook) ? $user_profile->user_facebook : "";
            }
        }
        $this->load->view('user/profile', $this->data);
    }
    //  TODO : only works for admin now
    public function search() {
        if ($this->user_id && ($this->user_perms > USER_LEVEL_USER)) {
            $this->data['all_users'] = array();
            if ($this->input->post('search') && $this->input->post('user_by_name')) {
                $srch_query = $this->input->post('user_by_name');
                $this->load->model('UsersModel', 'user');
                $user_data = $this->user->find_user($srch_query, $this->session->userdata('user_client_id'));
                foreach ($user_data as $user) {
                    $current_role = '';
                    $this->data['all_users'][$user->user_id]['id'] = $user->user_id;
                    $this->data['all_users'][$user->user_id]['name'] = $user->user_name;
                    $this->data['all_users'][$user->user_id]['user_name'] = $user->user_username;
                    $this->data['all_users'][$user->user_id]['user_department'] = $user->user_department;
                    $this->data['all_users'][$user->user_id]['user_phone'] = $user->user_phone;
                    $this->data['all_users'][$user->user_id]['user_email'] = $user->user_email;
                    $this->data['all_users'][$user->user_id]['user_enabled'] = $user->user_enabled;
                    $this->data['all_users'][$user->user_id]['user_permisions'] = $user->user_permisions;
                    $this->data['all_users'][$user->user_id]['user_permisions_c'] = $current_role;
                }
            }
            $this->load->view('users', $this->data);
        }
        else {
            redirect('login');
        }
    }
    //  admin reset password
    //  TODO : put email content in cofig or DB
    public function resetPassword() {
        $this->load->model('UsersModel', 'user');
        $get = $this->input->get();
        if (!empty($get['email']) && !empty($get['admin'])) {
            $user_email = $get['email'];
            $user = $this->user->get_user_by_email($user_email);
            $user_info = array();
            if (isset($user->user_id)) {
                $this->data['user_id'] = $user->user_id;
                $this->data['user_email'] = $user->user_email;
                $users_generated_password = $this->generatePassword(8);
                $this->data['user_password'] = md5($users_generated_password);
                $this->user->update_password($this->data);
                $seccond_param = md5(($user->user_name) . ($user->user_email) . ($user->user_id));
                $code = $this->user->start_login_session($user->user_id);

                $user_info['user_email'] = $user->user_email;
                $user_info['user_username'] = $user->user_username;
                $user_info['user_name'] = $user->user_name;
                $user_info['user_pass'] = $users_generated_password;
                $user_info['email_content'] = '<html><body><p>Hello ' . $user_info['user_name'] . ',</p> <p>Your new password for your Click2Promote.Me account has been changed.</p>
                        <p>Your new password is: ' . $user_info['user_pass'] . '</p> 
                        <p>After You logg in, please change your password.</p>
                        <a href="http://' . site_url("/login/email?code=" . $code . "&id=" . $seccond_param . "&user=" . $user->user_id) . '" target="_blank" style="color: #ffffff;">Login</a>
                        </body></html>';
                $a = $this->sendEmail($user_info);
                if ($a == false) {
                    echo '{"reset_password":"OK","status":"password_sent"}';
                }
                else {
                    echo '{"reset_password":"error","status":"error_mail_not_sent"}';
                }
            }
            else {
                $user_info['invalidEmail'] = 1;
                echo '{"reset_password":"error","status":"error_no_such_user"}';
            }
        }
        else {
            echo '{"reset_password":"error","status":"error_no_data"}';
        }
    }
    //  allow the user to reset his password
    public function forgot_password() {
        $this->load->model('UsersModel', 'user');
        $user_info = array();
        $user_info['user_agent'] = $this->data['user_agent'];
        $get = $this->input->post();
        if (!empty($get['email_reset_pass'])) {
            $user = $this->user->get_user_by_email($get['email_reset_pass']);
            if (isset($user->user_id)) {
                $this->data['user_id'] = $user->user_id;
                $this->data['user_email'] = $user->user_email;
                //generate random password
                $users_generated_password = $this->generatePassword(8);
                //  md5 of random password
                $this->data['user_password'] = md5($users_generated_password);
                //  write to DB
                $this->user->update_password($this->data);
                //  URL parameters
                $seccond_param = md5(($user->user_name) . ($user->user_email) . ($user->user_id));
                $code = $this->user->start_login_session($user->user_id);

                $user_info['user_email'] = $user->user_email;
                $user_info['to'] = $user->user_email;
                $user_info['user_username'] = $user->user_username;
                $user_info['user_name'] = $user->user_name;
                $user_info['user_pass'] = $users_generated_password;
                $user_info['new_password'] = $users_generated_password;
                $user_info['subject'] = "Click2Promote.Me password changed!";
                $user_info['template'] = "email_templates/email_password_template.html";
                $user_info['login_link'] = site_url("/login/email?code=" . $code . "&id=" . $seccond_param . "&user=" . $user->user_id);
                try {
                    $this->sendMailPHPmailer($user_info);
                    $user_info['invalidEmail'] = 2;
                    $this->load->view('user/passwordResetted', $user_info);
                }
                catch (Exception $e) {
                    $user_info['invalidEmail'] = 1;
                    $this->load->view('user/resetPassword', $user_info);
                }
            }
            else {
                $user_info['invalidEmail'] = 1;
            }
        }
        else {
            $this->load->view('resetPassword', $user_info);
        }
    }
    //  signup
    //  TODO : Add message to config or DB
    public function signup() {
        //load helper URL
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('UsersModel', 'user');
        $done = false;
        //  required fields
        $this->form_validation->set_rules('user_username', 'Username', 'required|trim');
        $this->form_validation->set_rules('user_password', 'Password', 'required|trim');
        $this->form_validation->set_rules('user_password1', 'Password', 'required|trim');
        $this->form_validation->set_rules('user_email', 'e-mail', 'required|valid_email|trim');
        $this->form_validation->set_rules('site_url', 'Web Site URL', 'required|trim');
        $this->form_validation->set_rules('site_name', 'Web Site Name', 'required|trim');
        $this->form_validation->set_rules('site_desc', 'Web Site Description', 'required|trim');

        $this->form_validation->set_error_delimiters('<div id="error_msg">', '</div>');
        $user_info = $this->input->post();
        if ($this->form_validation->run() == FALSE) {
            
        }
        else {
            if ($user_info['user_password'] == $user_info['user_password1']) {
                $this->session->set_userdata($user_info);
                $done = TRUE;
                $this->user->create_user($user_info);
                $user_info['user_id'] = $this->user->get_user_by_username($user_info['user_email']);
                try {
                    $this->user->create_site($user_info);
                    
                    $this->load->model('SiteModel', 'site');
                    try{
                        $site_id = $this->user->get_site_by_userid($user_info['user_id']);
                        $t_connection = $this->getTwitterConnect();
                        $content = $t_connection->get("search/tweets",array("q"=>$user_info['site_url'], "count"=>"1","result_type"=>"recent"));
                        $this->site->set_start_twitter_id($site_id, $content->search_metadata->max_id_str);
                    }
                    catch(Exception $e){
                        log_message('error', $e->getMessage());
                    }
                    $this->load->view('signup/signup_finish', $this->data);
                    try {
                        $big_message = "<p>Click2Promote.Me will help you to track and plan your online marketing campaigns.</p>" .
                                "<p>Your username is: <em style=\"font-weight: bold\">" . $user_info['user_email'] . "</em><br/>" .
                                "Your password is: <em style=\"font-weight: bold\">" . $user_info['user_password'] . "</em><br/>" .
                                '<p>You can continue to your account here <a style="color:black;" href="' . site_url("/login") . '">Login</a></p>' .
                                "<p>There is a waiting period for approval, according to the <a href=\"http://click2promote.me/index.php/home/terms\" target=\"_blank\">Terms of use</a>." .
                                " You will get an email as soon as your site is approved.<br/>" .
                                "If you have any questions, you can email us at <a href=\"mailto:info@click2promote.me\">info@click2promote.me</a></p>" .
                                "<p>" . date('M-Y') . " </p>";
                        $signup_message = array(
                            "to" => $user_info['user_email'],
                            "user_name" => $user_info['user_username'],
                            "subject" => "Welcome to Click2Promote.Me!",
                            "user_message" => $big_message,
                            "template" => "email_templates/message_template.html"
                        );
                        $this->sendMailPHPmailer($signup_message);
                    }
                    catch (Exception $e) {
                        redirect('error');
                    }
                }
                catch (Exception $e) {
                    redirect('error');
                }
            }
        }
        if ($done != TRUE) {
            $this->load->view('signup/signup', $this->data);
        }
    }
    // the following public methods
    //  
    //  are AJAX only
    //  
    //  used to check validity of
    //  a single parameter
    //  and to change one or a collection of fields
    public function email_exist() {
        $this->load->model('UsersModel', 'user');
        $e_mail = $this->input->get('email');
        $is_email = $this->user->get_user_by_email($e_mail);
        if (empty($is_email->user_email) || ($is_email->user_email != $e_mail)) {
            echo '{"response":"OK"}';
        }
        else if ($is_email->user_email == $e_mail) {
            echo '{"response":"exist"}';
        }
    }
    //  check if the web site URL exists in DB
    public function site_exist() {
        $this->load->model('UsersModel', 'user');
        $url = $this->input->get('url');
        $site_exist = $this->user->site_exists(trim($url));
        if (empty($site_exist->link)) {
            echo '{"response":"OK"}';
        }
        else {
            echo '{"response":"exist"}';
        }
    }
    //  allow the user to change the site details
    public function update_details() {
        $this->load->model('UsersModel', 'user');
        $db_session = $this->user->get_login_session($this->user_id);
        if ($this->input->post('user_act') == "chg_site") {
            $site = $this->input->post('site');
            $link = $this->input->post('link');
            $descr = $this->input->post('descr');
            $email = $this->input->post('email');
            $index = $this->input->post('site_id');
            $form_session = $this->input->post('session_id');

            if ((!empty($site) || !empty($link) ) && !empty($descr) && ($form_session == $db_session->code)) {
                $this->data['site'] = $site;
                $this->data['link'] = $link;
                $this->data['descr'] = $descr;
                $this->data['email'] = $email;
                $this->data['index'] = $index;
                $this->user->user_udate_site($this->data);
                echo '{"site_details_changed":"OK"}';
            }
            else {
                echo '{"site_details_changed":"validation error"}';
            }
        }
    }

    public function vote_for_site() {

        $this->load->model('UsersModel', 'users');

        if ($this->input->post('user_act') == "vote") {
            $this->data['user_ip'] = $this->input->ip_address();
            $this->data['u_agent'] = $this->agent->agent;
            $site_voted = $this->input->post('site_voted');
            $site_voter = $this->input->post('site_voter');

            $db_session = $this->users->get_login_session($this->user_id);
            $form_session = $this->input->post('session_id');

            if (!empty($site_voted) && !empty($site_voter) && ($form_session == $db_session->code)) {
                $this->data['votes'] = $this->users->get_one_site_votes($site_voted);
                if (!empty($this->data['votes']->votes)) {
                    $this->data['votes'] = $this->data['votes']->votes + 1;
                }
                else {
                    $this->data['votes'] = 1;
                }
                $this->data['index'] = $site_voted;
                $this->data['user_id'] = $this->user_id;
                $this->data['user_points'] = $this->session->userdata('user_points');

                $this->users->update_user_points($this->data['user_id'], $this->data['user_points']);
                $this->users->vote_for_site($this->data);

                echo '{"vote_success":"OK"}';
            }
            else {
                echo '{"vote_failure":"not_all_parameters_where_supplied"}';
            }
        }
    }

    //  allow the user to change the password
    public function change_password() {
        $this->load->model('UsersModel', 'user');
        if ($this->input->post('change_pass_r')) {
            $change_pass = $this->input->post('change_pass');
            $change_pass_r = $this->input->post('change_pass_r');
            if ($change_pass == $change_pass_r) {
                $this->data['user_id'] = $this->user_id;
                $this->data['user_password'] = md5($change_pass);
                $this->user->update_password($this->data);
                echo '{"password_change":"OK"}';
            }
            else {
                echo '{"password_change":"pass_dont_match"}';
            }
        }
        else {
            echo '{"password_change":"no_data_rcvd"}';
        }
    }

    //  TODO: Profile page for SEO professionals
    public function make_profile_public() {
        $this->load->model('UsersModel', 'users');
        $db_session = $this->users->get_login_session($this->user_id);
        $session = $this->input->post("session");
        $user_id = $this->input->post("user_id");
        $is_public = $this->input->post("is_public");
        if (($session == $db_session) && !empty($user_id)) {
            try {
                $this->users->user_profile_public($user_id, $is_public);
                echo '{"site_details_changed":"OK"}';
            }
            catch (Exception $e) {
                echo '{"site_details_changed":"no_such_user"}';
            }
        }
        else {
            echo '{"site_details_changed":"validation error"}';
        }
    }

    //  admin enable/diable users
    public function enable_disable() {
        if ($this->user_id && ($this->user_perms == USER_LEVEL_ADMIN)) {
            $this->load->model('UsersModel', 'user');
            // if there's a post
            $get = $this->input->get();
            $User['session'] = $this->session->userdata('user_db_sess');
            if (($get['admin'] == '1') && ($get['session'] == $User['session']) && !empty($get['user']) && !empty($get['en_dis'])) {
                $user = $this->user->get_user_by_id($get['user']);
                if (!empty($user)) {
                    $status = 'enabled';
                    if ($get['en_dis'] == 'yes') {
                        $this->user->enable_user($get['user']);
                    }
                    else if ($get['en_dis'] == 'no') {
                        $status = 'disabled';
                        $this->user->disable_user($get['user']);
                    }
                    $this->user->update_user($User);
                    echo '{"user":"OK","status":"' . $status . '"}';
                }
                else {
                    echo '{"user":"error","status":"error_no_such_user"}';
                }
            }
            else {
                echo '{"user":"error","status":"error_no_input_params"}';
            }
        }
    }
    //  check if promo period ended
    //  date loaded from config
    public function promocount() {
        $this->load->model('UsersModel', 'user');
        $config = $this->config->item('promo_period_start');
        $promo = $this->user->promo($config);
        echo json_encode($promo);
    }
}

?>