<?php

class CountriesModel extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    /*
     * Get all data from Countries
     */
    
    public function getAllByCountrySort()
    {
        $this->db->select('*');
        $this->db->from('countries');
        $this->db->order_by('country');
        
        return $this->db->get();
    }
}

?>
