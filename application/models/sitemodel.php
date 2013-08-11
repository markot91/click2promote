<?php
class SiteModel extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    /**
     * Set the start point for twitter 
     * @param int $site_is ID of the web site
     * @param int $twitt_id ID of the twitt/status got when the account was created
     */
    function set_start_twitter_id($site_id, $twitt_id) {
        return $this->db->query("UPDATE `sites` SET `sites`.twitter_start_id=$twitt_id WHERE `sites`.index='" . $site_id . "' ;");
    }
    /**
     * Get the start point for twitter 
     * @param int $site_is ID of the web site
     * @param int $twitt_id ID of the twitt/status got when the account was created
     * 
     * @return int ID of the twitter status
     */
    function get_start_twitter_id($site_id, $twitt_id) {
        $result = $this->db->query("SELECT twitter_start_id FROM `sites` WHERE `sites`.index = '$site_id' LIMIT 1;");
        $t_id = $result->row();
        return $t_id;
    }
}
?>
