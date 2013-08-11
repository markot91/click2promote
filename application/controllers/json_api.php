<?php

class Json_api extends CI_Controller {

    private $data = array();

    public function __construct() {
        parent::__construct();
        $tmp_agent = $this->agent->agent_string();
        if (strstr($tmp_agent, 'Android') || strstr($tmp_agent, 'iPhone') || strstr($tmp_agent, 'iPad') || strstr($tmp_agent, 'BlackBerry')) {
            $this->data['user_agent'] = true;
        } else {
            $this->data['user_agent'] = false;
        }
    }

    function index() {

    }

    function get_account_details(){
        $user_id = $this->input->post('user_id');
        $session_id = $this->input->post('session_id');
        if(!empty($user_id) && !empty($session_id)){
                $User = array();
                $this->load->model('UsersModel','users');
                $db_session=$this->users->get_login_session($session_id);
                if($db_session->code == $session_id){
                        $user = $this->users->get_user_by_id($user_id);

                        $this->data['user_id'] = $user->user_id;
                        $this->data['email'] = $user->user_email;
                        $this->data['username'] = $user->user_username;
                        $this->data['name'] = $user->user_name;
                        $this->data['address'] = $user->user_address;
                        $this->data['postal'] = $user->user_postal_code;
                        $this->data['city'] = $user->user_city;
                        $this->data['country'] = $user->user_country;
                        $this->data['state_prov'] = $user->user_state_prov;
                        $this->data['phone'] = $user->user_phone;

                        $site = $this->users->get_site_by_userid($this->session->userdata('user_id'));
                        $this->data['site_name'] = !empty($site->site)?$site->site:'';
                        $this->data['site_keywords'] = !empty($site->descr)?$site->descr:'';
                        $this->data['site_link'] = !empty($site->link)?$site->link:'';
                        $this->data['site_email'] = !empty($site->email)?$site->email:'';
                        $this->data['site_id'] = !empty($site->index)?$site->index:'';
                        $this->data['error'] = "0";

                        echo json_encode($this->data);

                }
                else{
                    echo '{"get_account_details":"FAIL","error":"invalid_session"}';
                }
        }
    }
    
    function edit_my_account() {
        $user_id = $this->input->post('user_id');
        $session_id = $this->input->post('session_id');
        if (!empty($user_id) && !empty($session_id)) {
            $User = array();
            $this->load->model('UsersModel', 'users');
            $db_session=$this->users->get_login_session($session_id);
//      if there's a post
            if (($this->input->post('user_act') == 'edit')&& ($session_id == $db_session->code)) {
                $username= $this->input->post('name');
                $email= $this->input->post('email');
                $User['session'] = $this->session->userdata('user_db_sess');
                $sess_data = $this->session->all_userdata();
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
                $User['user_enabled'] = 1;
                $User['user_permisions'] = '1';
                if (!empty($username) && !empty($email)) {
                    $this->users->update_user($User);
                    echo '{"details_update":"OK","error":"0"}';
                    die();
                } else {
                    echo '{"details_update":"FAIL","error":"validation_error"}';
                    die();
                }
            }
        } else {
            redirect('login');
        }
    }

    function change_password() {

        $this->load->model('UsersModel', 'users');
        $session_id = $this->input->post('session_id');
        $user_id = $this->input->post('user_id');
        $change_pass = $this->input->post('change_pass');
        $change_pass_r = $this->input->post('change_pass_r');
        
        if (!empty($change_pass) && !empty($change_pass_r) && !empty($session_id)) {
            $db_session=$this->users->get_login_session($user_id);
            if (($change_pass == $change_pass_r)&& ($db_session->code==$session_id)) {
                $this->data['user_id'] = $this->session->userdata('user_id');
                $this->data['user_password'] = md5($change_pass);
                $this->users->update_password($this->data);
                echo '{"password_change":"OK","error":"0"}';
            } else {
                echo '{"password_change":"FAIL","error":"pass_dont_match"}';
            }
        } else {
            echo '{"password_change":"FAIL","error":"no_data_rcvd"}';
        }
    }

    function update_details() {
        $session_id = $this->input->post('session_id');
        $user_id = $this->input->post('user_id');
        $this->load->model('UsersModel', 'users');

        if ($this->input->post('user_act') == "chg_site") {
            $site = $this->input->post('site');
            $link = $this->input->post('link');
            $descr = $this->input->post('descr');
            $email = $this->input->post('email');
            $index = $this->input->post('site_id');
            $form_session = $this->input->post('session_id');
            $db_session = $this->users->get_login_session($user_id);

            if ((!empty($site) || !empty($link) ) && !empty($descr) && ($form_session == $db_session->code)) {
                $this->data['site'] = $site;
                $this->data['link'] = $link;
                $this->data['descr'] = $descr;
                $this->data['email'] = $email;
                $this->data['index'] = $index;
                $this->users->user_udate_site($this->data);
                echo '{"site_details_changed":"OK"}';
            } else {
                echo '{"site_details_changed":"validation error"}';
            }
        }
    }

    function get_chart() {
        $this->load->model('UsersModel', 'users');
        $session_id = $this->input->post('session_id');
        $user_id = $this->input->post('user_id');
        $index = $this->input->post('site_id');

        $db_session = $this->users->get_login_session($user_id);

        if (!empty($user_id) && !empty($session_id) ) {
            $output = '[';
            if (($session_id == $db_session->code)) {
                $chart = $this->users->get_site_stats_five_months($index);
                foreach ($chart->result() as $one) {
                    $output .= $one->data . ',';
                }
                $output = rtrim($output, ',');
                $output .= ']';
                echo $output;
            } else {
                echo '{"site_details_changed":"FAIL","error":"validation error"}';
            }
        }
    }

    function get_chart_interval() {
        $this->load->model('UsersModel', 'users');

        $session_id = $this->input->post('session_id');
        $user_id = $this->input->post('user_id');
        $site_id = $this->input->post('site_id');
        $date_from = $this->input->post('from');
        $date_to = $this->input->post('to');

        $db_session = $this->users->get_login_session($user_id);

        if (!empty($user_id) && !empty($session_id) ) {
            $output = '[';
            if (($session_id == $db_session->code)) {
                $chart = $this->users->get_site_stats_interval($site_id,$date_from,$date_to);
                foreach ($chart->result() as $one) {
                    $output .= $one->data . ',';
                }
                $output = rtrim($output, ',');
                $output .= ']';
                echo $output;
            } else {
                echo '{"site_details_changed":"FAIL","error":validation error"}';
            }
        }
    }
    
    function get_site_id() {
        $this->load->model('UsersModel', 'users');
        $session_id = $this->input->post('session_id');
        $user_id = $this->input->post('user_id');
        $db_session = $this->users->get_login_session($user_id);
        $this->data = array();
        if ($this->input->post()) {
            if (($session_id == $db_session->code)) {
                $site_iddb= $this->users->get_site_by_userid($user_id);
                echo '{"site_id":"'.$site_iddb->index.'","error":"0"}';
            } else {
                echo '{"site_id":"FAIL","error":"error_bad_user_id"}';
            }
        }
    }

    function get_sites() {
        $this->load->model('UsersModel', 'users');
        $db_session = $this->users->get_login_session($this->session->userdata('user_id'));
        $this->data = array();
        if ($this->input->post()) {
            $index = $this->input->post('site_id');
            $form_session = $this->input->post('session_id');
            $output = '[';
            if (($form_session == $db_session->code)) {
                $chart = $this->users->get_site_stats_five_months($index);
                foreach ($chart->result() as $one) {
                    $output .= $one->data . ',';
                }
                $output = rtrim($output, ',');
                $output .= ']';
                echo $output;
            } else {
                echo '{"site_details_changed":"validation error"}';
            }
        }
    }

    function login(){
            $this->data['loginFailed'] = 0;
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $password = trim($password);
            if(!empty($username) && !empty($password)){
            //load users model
              $this->load->model('UsersModel','users');
              //check if there is a user with that username and get user data if there is one
              if(( $user_credentials = $this->users->get_user_name_login($username)) ){
                 $one_row = $user_credentials;
                    //if password ok, redirect to Tutorials
                 if( ($one_row->user_password == md5($password)) &&
                     ($one_row->user_enabled == 1)){
                            $this->users->start_login_session($one_row->user_id);

                            $db_session=$this->users->get_login_session($one_row->user_id);
                            $sessionData = array(
                               'username'  => $one_row->user_username,
                               'user_id'     => $one_row->user_id,
                               'user_client_id' => $one_row->user_client_id,
                               'user_name'     => $one_row->user_name,
                               'user_enabled'     => $one_row->user_enabled,
                               'user_department'     => $one_row->user_department,
                               'user_phone'     => $one_row->user_phone,
                               'user_permisions'     => $one_row->user_permisions,
                               'user_points'     => $one_row->points,
                               'user_logedin'     => 'yesyesyes',
                               'user_db_sess'      => $db_session->code
                            );
                            $this->session->set_userdata($sessionData);
                            echo '{"login":"OK","user_id":"'.$one_row->user_id.'","session":"'.$db_session->code.'","error":"0"}';
                     }
                     else{
                        echo '{"login":"FAIL","error":"bad_password"}';
                     }
                    }
                    else{
                        echo '{"login":"FAIL","error":"bad_username"}';
                        $this->data['loginFailed'] = 1;
                    }
              }
              else{
                  echo '{"login":"FAIL","error":"no_credentials"}';
              }
    }

    function logoff(){
            $user_id = $this->input->post('user_id');
            $session_id = $this->input->post('session_id');
            if(!empty($user_id) && !empty($session_id)){
            //load users model
                $this->load->model('UsersModel','users');
                $db_session=$this->users->get_login_session($user_id);
                    if($db_session->code == $session_id){
                        $this->users->end_login_session($user_id);
                        $this->session->sess_destroy();
                        echo '{"logoff":"OK","error":"0"}';
                    }else{
                        echo '{"logoff":"FAIL","error":"bad_session_id"}';
                    }
              }
              else{
                  echo '{"logoff":"FAIL","error":"no_session_id"}';
              }
    }
}

?>