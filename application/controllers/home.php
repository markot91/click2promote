<?php

class Home extends C2P_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index_nologin() {
        $this->load->model('UsersModel', 'userModel');
        $this->load->view('home', $this->data);
    }

    public function terms() {
        $this->load->view('terms', $this->data);
    }

    public function faq() {
        $this->load->view('faq', $this->data);
    }

    public function about() {
        $this->load->view('about', $this->data);
    }

    public function index() {
        if ($this->user_id && (($this->user_perms > 0) && (($this->user_perms < 3)) )) {
//                        get_site_by_userid
            $this->load->model('UsersModel', 'userModel');
            //      get the site
            $site = $this->userModel->get_site_by_userid($this->user_id);
            $db_result = '';
            //  get the site stats, store in a temp. variable
            if (!empty($site->index)) {
                $tmp = $this->userModel->get_site_stats($site->index);
                $db_result = $tmp->result();
            }
            $st = !empty($db_result) ? $db_result : '';
            //  decode the stats
            if (!empty($st[0])) {
                $tmp_stats = json_decode($st[0]->data);
            }

            $this->data['fb'] = !empty($tmp_stats->fb) ? number_format($tmp_stats->fb, 1, '.', ',') : 0;
            $this->data['tw'] = !empty($tmp_stats->tw) ? number_format($tmp_stats->tw, 1, '.', ',') : 0;
            $this->data['bn'] = !empty($tmp_stats->bn) ? number_format($tmp_stats->bn, 1, '.', ',') : 0;
            $this->data['gog'] = !empty($tmp_stats->gog) ? number_format($tmp_stats->gog, 1, '.', ',') : 0;
            $this->data['youtube'] = !empty($tmp_stats->youtube) ? number_format($tmp_stats->youtube, 1, '.', ',') : 0;
            //  used to display the url/keyword
            $this->data['user_web'] = $site->link;
            $this->data['site_id'] = $site->index;
            $this->data['session'] = $this->session->userdata('user_db_sess');
            $this->data['user_name'] = $this->session->userdata('username');
            $session_id_from_post = $this->input->post('session_id');
            $site_id_from_post = $this->input->post('site_id');

            if (!empty($site_id_from_post) && !empty($session_id_from_post)) {
                $this->data['chart_url'] = site_url('json_api/get_chart');
            }
            else {
                $this->data['chart_url'] = site_url('home/get_chart');
            }
            $this->load->view('land', $this->data);
        }
        else if ($this->user_id && ($this->user_perms == 3)) {
            redirect('admin');
        }
        else {
            redirect('login');
        }
    }

    public function reports() {
        if ($this->user_id && (($this->user_perms > 0) && (($this->user_perms < 3)) )) {
            //  get_site_by_userid
            $this->load->model('UsersModel', 'userModel');
            //      get the site
            $site = $this->userModel->get_site_by_userid($this->user_id);
            //  get the site stats, store in a temp. variable
            $tmp = $this->userModel->get_site_stats($site->index);
            $db_result = $tmp->result();
            $st = !empty($db_result) ? $db_result : null;
            //  used to display the url/keyword
            $this->data['user_web'] = $site->link;
            $this->data['site_id'] = $site->index;
            $this->data['session'] = $this->session->userdata('user_db_sess');
            $this->data['user_name'] = $this->session->userdata('username');
            $this->data['schart'] = $this->input->get('chart');
            $this->load->view('reports', $this->data);
        }
        else if ($this->user_id && ($this->user_perms == 3)) {
            redirect('admin');
        }
        else {
            redirect('login');
        }
    }

    public function get_chart_interval() {
        $user = $this->user_id;
        if ($user && (($this->user_perms > 0) && (($this->user_perms < 3)) )) {
            $this->data = array();
            $this->load->model('UsersModel', 'userModel');
            $db_session = $this->userModel->get_login_session($user);

            $date_from = date('Y-m-d',  strtotime($this->input->post('from')));
            $date_to = date('Y-m-d',  strtotime($this->input->post('to')));
            $site_id = $this->input->post('site_id');
            if (!empty($date_from) && !empty($date_to) && !empty($site_id)) {
                $form_session = $this->input->post('session_id');
                $output = '[';
                if (($form_session == $db_session->code)) {
                    $chart = $this->userModel->get_site_stats_interval($site_id, $date_from, $date_to);
                    foreach ($chart->result() as $one) {
                        $output .= $one->data . ',';
                    }
                    $output = rtrim($output, ',');
                    $output .= ']';
                    echo $output;
                }
                else {
                    echo '{"get_cart_interval":"bad_session"}';
                }
            }
        }
        else if ($user && ($this->user_perms == 3)) {
            redirect('users/admin');
        }
        else {
            redirect('login');
        }
    }

    public function get_chart() {
        $this->load->model('UsersModel', 'users');
        $db_session = $this->users->get_login_session($this->user_id);
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
            }
            else {
                echo '{"get_chart":"bad_session"}';
            }
        }
    }

    //  get report as CSV file - download
    public function get_csv() {
        $relate = array(
            "chartfb" => "fb",
            "charttw" => "tw",
            "chartbing" => "bn",
            "chartgoogle" => "gog",
            "chartyoutube" => "youtube"
        );
        $this->load->model('UsersModel', 'users');
        $db_session = $this->users->get_login_session($this->user_id);
        $this->data = array();
        $service = $this->input->get('chart');
        $index = $this->input->get('site_id');
        $form_session = $this->input->get('session_id');
        if (!empty($service) && !empty($index) && !empty($form_session)) {
            $output = "service_code,stats,date \n";
            if (($form_session == $db_session->code)) {
                $chart = $this->users->get_site_stats_five_months($index);
                foreach ($chart->result() as $one) {
                    $tmpoutput = (array) json_decode($one->data);
                    $output .=$relate[$service] . ','
                            . $tmpoutput[$relate[$service]] . ','
                            . $tmpoutput['date'] . "\n";
                }
                header("Content-type: text/csv");
                header("Content-Disposition: attachment; filename=file.csv");
                header("Pragma: no-cache");
                header("Expires: 0");
                echo $output;
            }
            else {
                echo '{"get_csv":"bad_session"}';
            }
        }
    }

    //  TODO: AJAX call, to be implemented
    public function get_sites() {
        $this->load->model('UsersModel', 'users');
        $db_session = $this->users->get_login_session($this->user_id);
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
            }
            else {
                echo '{"get_sites":"bad_session"}';
            }
        }
    }

    public function contact() {
        $contact_info = $this->input->post();
        if (!empty($contact_info)) {
            if (!empty($contact_info['email']) && !empty($contact_info['poraka'])) {
                $message = "Message from &nbsp;" . $contact_info['email'] . "<br/>" .
                            $contact_info['poraka'];

                try {
                    $response = $this->sendMailPHPmailer(
                            array(
                                "subject"=>'Click2Pomote.ME: Message from user : ' . $contact_info['email'],
                                "to" => "druid0101@gmail.com",
                                "user_name" => "admin",
                                "user_message" => $message,
                                "template" => "email_templates/message_template.html"
                            )
                    );
                }
                catch (Exception $e) {
                    error_log(var_export($e->getMessage(), true));
                }
            }
        }
        redirect('home');
    }

    public function search() {
        if ($this->user_id && (($this->user_perms > 0) )) {
            $search_qry = $this->input->post();
            //  make it empty, initial value
            $this->data['initial_qry'] = '';
            $this->data['form_action'] = '';
            $this->data['initial_qry_desc'] = $this->data['initial_qry_url'] = $this->data['initial_qry_keyw'] = '';
            $this->data['result'] = 'Looking for fun? Games? Dates? Money? Try our search engine, who knows, maybe you\'ll get lucky!';
            $this->data['found'] = false;
            $this->data['pages'] = 0;
            $this->data['search'] = false;
            if (!empty($search_qry)) {
                $srch = "0";
                $this->data['search'] = true;
                $this->load->model('UsersModel', 'userModel');
                $srch = $this->userModel->search_database($search_qry['search_qry']);
                $this->data['result'] = $srch['result'];
                $this->data['total'] = $srch['total'];
                $this->data['pages'] = ($srch['total']->total / 20);
                if ($srch['total']->total > 0) {
                    $this->data['found'] = true;
                }
                $this->data['initial_qry'] = $search_qry['search_qry'];
            }
            $this->load->view('search', $this->data);
        }
        else {
            redirect('login');
        }
    }

    public function search_paged() {
        if ($this->user_id && (($this->user_perms > 0) )) {
            $search_qry = $this->input->get();
            //  make it empty, initial value
            $this->data['initial_qry'] = '';

            $this->data['pages'] = 0;
            $this->data['form_action'] = site_url('home/search');
            $this->data['initial_qry_desc'] = $this->data['initial_qry_url'] = $this->data['initial_qry_keyw'] = '';
            $this->data['result'] = 'Looking for fun? Games? Dates? Money? Try our search engine, who knows, maybe you\'ll get lucky!';
            $this->data['found'] = false;
            $this->data['search'] = false;
            if (!empty($search_qry['page']) && !empty($search_qry['search_qry'])) {
                $srch = "0";
                $this->load->model('UsersModel', 'userModel');
                $srch = $this->userModel->search_paged($search_qry['search_qry'], $search_qry['page']);
                $this->data['result'] = $srch['result'];
                $this->data['total'] = $srch['total'];
                $this->data['active_page'] = $search_qry['page'];
                $this->data['pages'] = ($srch['total']->total / 20);
                if ($srch['total']->total > 0) {
                    $this->data['found'] = true;
                }
                $this->data['initial_qry'] = $search_qry['search_qry'];
            }
            $this->load->view('search', $this->data);
        }
        else {
            redirect('login');
        }
    }

    //  only run as admin, once per week
    public function admin_set_data() {
        $user = $this->user_id;
        //    if admin
        if ($this->user_id && ($this->user_perms == 3)) {
            $this->load->model('UsersModel', 'userModel');
            $sites = $this->userModel->get_all_sites_approved();
            $all_stats = array();
            foreach ($sites->result() as $one_site) {
                if (!empty($one_site->link) && !empty($one_site->index)) {
                    $all_stats = $this->getStats($one_site->index, $one_site->link);
                    $all_stats = json_encode($all_stats);
                    $this->userModel->set_site_stats(array('site_id' => $one_site->index, 'data' => $all_stats));
                }
            }
            echo '{"get_all_data":"OK"}';
            die();
        }
        else if ($this->user_id && ($this->user_perms == 3)) {
            redirect('users/admin');
        }
        else {
            redirect('login');
        }
    }

}

?>