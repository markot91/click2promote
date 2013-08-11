<?php

class Login extends C2P_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->data['loginFailed'] = 0;
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_error_delimiters('<div id="error_msg">', '</div>');
        $this->data['err_mgs'] = '';
        if ($this->form_validation->run() == FALSE) {
            
        } else {
            if (!empty($username) && !empty($password)) {
                //load users model
                $this->load->model('UsersModel', 'users');
                //check if there is a user with that username and get user data if there is one
                if ($user_credentials = $this->users->get_user_name_login($username)) {
                    $one_row = $user_credentials;
                    //if password ok, redirect to Tutorials
                    if (($one_row->user_password == md5($password)) && ($one_row->user_enabled == 1)) {
                        $this->users->start_login_session($one_row->user_id);
                        $db_session = $this->users->get_login_session($one_row->user_id);
                        $count_sites = $this->users->get_count_sites();
                        $sessionData = array(
                            'username' => $one_row->user_username,
                            'user_id' => $one_row->user_id,
                            'user_client_id' => $one_row->user_client_id,
                            'user_name' => $one_row->user_name,
                            'user_enabled' => $one_row->user_enabled,
                            'user_department' => $one_row->user_department,
                            'user_phone' => $one_row->user_phone,
                            'user_permisions' => $one_row->user_permisions,
                            'user_points' => $one_row->points,
                            'user_logedin' => 'yesyesyes',
                            'user_db_sess' => $db_session->code,
                            'count_sites' => $count_sites,
                        );
                        $this->session->set_userdata($sessionData);
                        if ($sessionData['user_permisions'] > 2) {
                            redirect('admin');
                        } else {
                            redirect('home');
                        }
                    } else {
                        $this->data['err_mgs'] = 'Bad password! Please try again.';
                    }
                    $this->data['loginFailed'] = 0;
                } else {
                    $this->data['err_mgs'] = 'Username not found! Would you like to <a href="' . site_url('users/signup') . '"><u>register</u>?</a>';
                    $this->data['loginFailed'] = 1;
                }
            }
        }
        if ($this->user_id && ($this->user_perms > 0)) {
            redirect('home');
        } else {
            $this->load->view('login', $this->data);
        }
    }

    public function logout() {
        if ($this->user_id && ($this->user_perms > 0)) {
            $this->session->set_userdata(array('user_logedin' => 'no'));
            $this->load->model('UsersModel', 'users');
            $this->users->end_login_session($this->user_id);
            $this->session->sess_destroy();

            redirect('login');
        } else {
            redirect('home');
        }
    }

    //  SSO login
    public function email() {
        $code = $this->input->get('code');
        $id = $this->input->get('id');
        $user = $this->input->get('user');
        if (!empty($code) && !empty($id)) {
            //  lookup user by user id
            //  check if param 2==md5(user_name.user_email.user_id)
            //  if yes, login, create session
            $this->load->model('UsersModel', 'users');
            $user_details = $this->users->get_user_by_id_only($user);
            if (!empty($user_details)) {
                //  clear session record from DB
                //  weeklyemail.php inserted a record 
                //  when creating SSO URL
                $this->users->end_login_session($user);
                //  start a fresh session
                $this->users->start_login_session($user_details->user_id);
                $db_session = $this->users->get_login_session($user_details->user_id);
                $sessionData = array(
                    'username' => $user_details->user_username,
                    'user_id' => $user_details->user_id,
                    'user_client_id' => $user_details->user_client_id,
                    'user_name' => $user_details->user_name,
                    'user_enabled' => $user_details->user_enabled,
                    'user_department' => $user_details->user_department,
                    'user_phone' => $user_details->user_phone,
                    'user_permisions' => $user_details->user_permisions,
                    'user_points' => $user_details->points,
                    'user_logedin' => 'yesyesyes',
                    'user_db_sess' => $db_session->code
                );
                $this->session->set_userdata($sessionData);
                if ($sessionData['user_permisions'] > 2) {
                    redirect('admin');
                } else {
                    redirect('home');
                }
            }
        }
    }
}

?>