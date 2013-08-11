<?php

class UsersModel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /*     * ********************* users   ********************** */

    function get_all_users() {
        return $this->db->query("SELECT * FROM `users` ORDER BY `users`.user_id ASC;");
    }

    function get_user_by_id_only($user_id) {
        $result = $this->db->query("SELECT * FROM `users` WHERE `users`.user_id = $user_id ;");
        $user = $result->row();
        return $user;
    }

    function get_user_name_login($user_name) {
        $user_row = $this->db->query("SELECT * FROM `users` WHERE `users`.user_username = '" . $user_name . "';");
        return $user_row->row();
    }

    function get_user_by_username($user_name) {
        $qry = $this->db->query("SELECT user_id FROM `users` WHERE `users`.user_username = '" . $user_name . "' LIMIT 1;");
        $row = $qry->row();
        return $row->user_id;
    }

    function get_user_by_id($user_id) {
        $result = $this->db->query("SELECT * FROM `users` WHERE `users`.user_id = '" . $user_id . "';");
        $user = $result->result();
        return !empty($user[0]) ? $user[0] : null;
    }

    function get_user_by_email($user_email) {
        $result = $this->db->query("SELECT * FROM `users` WHERE `users`.user_email LIKE '%" . $user_email . "%';");
        $user = $result->result();
        return (isset($user[0]) ? $user[0] : null);
    }

    function get_password($user_username) {
        return
                $this->db->query("SELECT user_password FROM `users` WHERE `users`.user_username = '" . $user_username . "' ;");
    }

    function check_if_username_exists($user_username) {
        return
                $this->db->query("SELECT user_username FROM `users` WHERE `users`.user_username = '" . $user_name . "';");
    }

    function create_user($user_credentials) {
        $this->db->query("INSERT INTO
                        `users`(user_username,
				user_name,
				user_gender,
				user_phone,
				user_email,
				user_password,
				user_enabled,
				user_permisions,
				user_department,
				user_country,
				user_city,
				user_state_prov,
				user_postal_code,
                                user_address)
                         values('" . $user_credentials['user_email'] . "',
                                '" . $user_credentials['user_username'] . "',
				'0',
				'N/A',
				'" . $user_credentials['user_email'] . "',
				'" . md5($user_credentials['user_password']) . "',
				'0',
				'1',
				'0',
				'N/A',
				'N/A',
				'N/A',
				'N/A',
				'N/A');");
    }

    function update_user($user_credentials) {
        $this->db->query("UPDATE
		`users` SET
				user_username = '" . $user_credentials['user_email'] . "',
				user_name = '" . $user_credentials['user_name'] . "',
				user_phone = '" . $user_credentials['user_phone'] . "',
				user_email = '" . $user_credentials['user_email'] . "',
				user_enabled = '" . $user_credentials['user_enabled'] . "',
				user_permisions = '" . $user_credentials['user_permisions'] . "',
				user_country = '" . $user_credentials['user_country'] . "',
				user_city = '" . $user_credentials['user_city'] . "',
				user_state_prov = '" . $user_credentials['user_state_prov'] . "',
				user_postal_code = '" . $user_credentials['user_postal_code'] . "',
				user_address = '" . $user_credentials['user_address'] . "',
				user_twitter = '" . $user_credentials['user_twitter'] . "',
				user_facebook = '" . $user_credentials['user_facebook'] . "',
				public = '" . $user_credentials['is_public'] . "'
				WHERE
				`users`.user_id = '" . $user_credentials['user_id'] . "'; ");
    }

    function find_user($username) {
        $qry = $this->db->query("SELECT * FROM `users` WHERE LOWER(`users`.user_name) LIKE '%" . strtolower($username) . "%' GROUP BY `users`.user_id ASC;");
        return $qry->result();
    }

    function update_regular_user($user_credentials) {
        $this->db->query("UPDATE `users` SET
				user_username = '" . $user_credentials['user_username'] . "',
				user_email = '" . $user_credentials['user_email'] . "'
				WHERE
				`users`.user_id = '" . $user_credentials['user_id'] . "'; ");
    }

    function user_profile_public($user_id, $is_public) {
        $this->db->query("UPDATE `users`
                          SET 
                          public='" . $is_public . "',
                          WHERE `users`.user_id=" . $user_id . "; ");
    }

    function update_password($user_credentials) {
        $this->db->query("UPDATE `users` SET
				user_password = '" . $user_credentials['user_password'] . "'
				WHERE
				`users`.user_id = '" . $user_credentials['user_id'] . "'; ");
    }

    function enable_user($user_id) {
        return
                $this->db->query("UPDATE `users` SET `users`.user_enabled = 1 WHERE `users`.user_id = '" . $user_id . "' ;");
    }

    function disable_user($user_id) {
        return
                $this->db->query("UPDATE `users` SET `users`.user_enabled = 0 WHERE `users`.user_id = '" . $user_id . "' ;");
    }

    function update_user_points($user_id, $points) {
        return
                $this->db->query("UPDATE `users` SET `users`.points=$points WHERE `users`.user_id = '" . $user_id . "' ;");
    }

    function delete_user($user_id) {
        return
                $this->db->query("DELETE FROM `users` WHERE `users`.user_id = '" . $user_id . "' ;");
    }

    function promo($promo_date) {
        $result = $this->db->query("SELECT count(*) as count FROM `users` WHERE `users`.date_created>'$promo_date';");
        $count = $result->row();
        return $count;
    }

    /*     * ********************* users   ********************** */


    /*     * ********************* sites   ********************** */

    function get_count_sites() {
        $qry = $this->db->query("SELECT COUNT(*) as count_sites  FROM `sites` WHERE `sites`.admin = 'true';");
        $site = $qry->row();
        return $site->count_sites;
    }

    function create_site($site) {
        $url = strtolower(trim($site['site_url']));
        $url = str_replace("http://", '', $url);
        $this->db->query("INSERT INTO
                                 sites(link, site, descr, email, uploaded, admin,user_id)
                                 values('http://" . $url. "',
                                        '" . $site['site_name'] . "',
                                        '" . $site['site_desc'] . "',
                                        '" . $site['user_email'] . "',
                                        '" . date('d/M/Y h:i:s') . "',
					'false',
                                        '" . $site['user_id'] . "');
                                ");
    }

    function site_exists($site_url) {
        $result = $this->db->query("SELECT * FROM `sites` WHERE `sites`.link='http://" . strtolower($site_url) . "';");
        $site = $result->result();
        return !empty($site[0]) ? $site[0] : '';
    }

    function get_site_by_userid($user_id) {
        $result = $this->db->query("SELECT * FROM `sites` WHERE `sites`.user_id = '" . $user_id . "' LIMIT 1;");
        $site = $result->result();
        return !empty($site[0]) ? $site[0] : '';
    }

    function get_five_sites_approved_() {
        return
                $this->db->query("SELECT * FROM `sites` WHERE `sites`.admin = 'true' ORDER BY `sites`.index DESC LIMIT 20;");
    }

    function get_all_sites_approved() {
        return
                $this->db->query("SELECT * FROM `sites` WHERE `sites`.admin = 'true';");
    }

    function get_next_30_sites_approved($last_id, $page) {
        $page_from = $page * 30;
        $start = $last_id - $page_from;
        return
                $this->db->query("SELECT * FROM `sites` WHERE `sites`.admin = 'true' and `sites`.index<=$start order by `sites`.index desc limit 30;");
    }

    function get_15_sites_approved() {
        return
                $this->db->query("SELECT * FROM `sites` WHERE `sites`.admin = 'true' order by `sites`.index desc limit 15;");
    }

    function get_30_sites_approved() {
        return
                $this->db->query("SELECT * FROM `sites` WHERE `sites`.admin = 'true' order by `sites`.index desc limit 30;");
    }

    function get_all_sites_not_approved() {
        return
                $this->db->query("SELECT * FROM `sites` WHERE `sites`.admin='false';");
    }

    function get_site_by_id($site_id) {
        $result = $this->db->query("SELECT * FROM `sites` WHERE `sites`.index=" . $site_id . ";");
        $site = $result->result();
        return !empty($site[0]) ? $site[0] : "";
    }

    function get_last_approved_site_id() {
        $id = $this->db->query("SELECT * FROM `sites` WHERE `sites`.admin = 'true' order by `sites`.index desc limit 1;");
        $the_result = $id->result();
        return $the_result[0]->index;
    }

    function user_udate_site($site) {
        $this->db->query("UPDATE `sites`
                          SET 
                          descr='" . $site['descr'] . "',
                          link='" . $site['link'] . "',
                          site='" . $site['site'] . "',
                          email='" . $site['email'] . "'
                          WHERE `sites`.index=" . $site['index'] . "; ");
    }

    function user_update_site_uid($site) {
        $this->db->query("UPDATE `sites`
                          SET 
                          email='" . $site['email'] . "'
                          WHERE `sites`.index=" . $site['index'] . "; ");
    }

    function approve_site($site_id) {
        $this->db->query("UPDATE `sites`
                          SET admin='true'
                          WHERE `sites`.index=" . $site_id . "; ");
    }

    function delete_site($site_id) {
        $this->db->query("DELETE FROM `sites` WHERE `sites`.index=" . $site_id . " ; ");
    }

    function un_approve_site($site_id) {
        $this->db->query("UPDATE `sites`
                                SET admin='false'
				WHERE `sites`.index=" . $site_id . "; ");
    }

    function set_site_stats($site_stats) {
        $this->db->query("INSERT INTO
                                 site_data(site_id, data)
                                 values('" . $site_stats['site_id'] . "',
                                        '" . $site_stats['data'] . "');
                                ");
    }

    function get_site_stats($site_id) {
        return $this->db->query("SELECT * FROM `site_data` WHERE `site_data`.site_id='$site_id' ORDER BY id DESC LIMIT 1;");
    }

    function get_site_stats_five_months($site_id) {
        return $this->db->query("SELECT data FROM `site_data` WHERE `site_data`.site_id='$site_id' ORDER BY id DESC LIMIT 20;");
    }

    function get_site_stats_interval($site_id, $from, $to) {
        $q = $this->db->query("SELECT data FROM `site_data` WHERE `site_data`.site_id='$site_id' AND datecollected>'$from' AND datecollected<'$to' ORDER BY id DESC LIMIT 20;");
        return $q;
    }

    function search_database($query) {
        if ($query == '') {
            $result = $this->db->query("SELECT * FROM `sites` ORDER BY `sites`.index ASC LIMIT 20;");
            $total = $this->db->query("SELECT count(*) as total FROM `sites` ;");
        }
        else {
            $result = $this->db->query("SELECT * FROM `sites` WHERE `sites`.site LIKE '%$query%' OR `sites`.descr LIKE '%$query%' OR `sites`.link LIKE '%$query%' ORDER BY `sites`.index ASC LIMIT 20;");
            $total = $this->db->query("SELECT count(*) as total FROM `sites` WHERE `sites`.site LIKE '%$query%' OR `sites`.descr LIKE '%$query%' OR `sites`.link LIKE '%$query%';");
        }
        $total_sites = $total->row();
        $total_sites = $total->row();
        $site = $result->result();

        return array('result' => $site, 'total' => $total_sites);
    }

    function search_paged($query, $page) {
        $page_from = $page * 20;
        if (empty($query)) {
            $result = $this->db->query("SELECT * FROM `sites` ORDER BY `sites`.index ASC LIMIT $page_from,20;");
            $total = $this->db->query("SELECT count(*) as total FROM `sites` ;");
        }
        else {
            $result = $this->db->query("SELECT * FROM `sites` WHERE `sites`.site LIKE '%$query%' OR `sites`.descr LIKE '%$query%' OR `sites`.link LIKE '%$query%' ORDER BY `sites`.index ASC LIMIT $page_from,20;");
            $total = $this->db->query("SELECT count(*) as total FROM `sites` WHERE `sites`.site LIKE '%$query%' OR `sites`.descr LIKE '%$query%' OR `sites`.link LIKE '%$query%';");
        }
        $total_sites = $total->row();
        $site = $result->result();

        return array('result' => $site, 'total' => $total_sites);
    }

    function search_by_url($query_url) {
        $result = $this->db->query("SELECT * FROM `sites` WHERE `sites`.link LIKE '%$query_url%';");
        $total = $this->db->query("SELECT count(*) as total FROM `sites` WHERE `sites`.link LIKE '%$query_url%';");
        $total_sites = $total->result();
        $site = $result->result();
        return array('result' => $site, 'total' => $total_sites);
    }

    function search_by_keyw($query_keyword) {
        $result = $this->db->query("SELECT * FROM `sites` WHERE `sites`.keywords LIKE '%$query_keyword%';");
        $total = $this->db->query("SELECT count(*) as total FROM `sites` WHERE `sites`.keywords LIKE '%$query_keyword%';");
        $total_sites = $total->result();
        $site = $result->result();
        return array('result' => $site, 'total' => $total_sites);
    }
    /*     * ********************* sites   ********************** */

    

    /*     * ********************* session   ********************** */
    function start_login_session($user_id) {
        $code = rand(1000000, 9999999);
        $this->db->query("INSERT INTO
                                 session(user_id,code)
                                 values('" . $user_id . "',
                                        '" . $code . "');
                                ");
        return $code;
    }

    function get_login_session($user_id) {
        $row = $this->db->query("SELECT * FROM `session` 
                                WHERE `session`.user_id= '" . $user_id . "' 
                                AND code>0 ORDER BY id DESC;");
        return $row->row();
    }

    function end_login_session($user_id) {
        $this->db->query("UPDATE `session` 
                                SET code=0
				WHERE `session`.user_id = '" . $user_id . "'; ");
    }
    /*     * ********************* session   ********************** */

}

?>