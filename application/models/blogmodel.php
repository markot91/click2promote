<?php
/**
 * Description of blogmodel
 *
 * @author Bojan
 */
class BlogModel extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    
    public function get_all(){
        $this->db->select('blog.*, users.user_name');
        $this->db->from('blog');
        $this->db->join('users', 'users.user_id = blog.user_id', 'left');
        $this->db->order_by('blog.id', 'blog.title');

        return $this->db->get();
    }
    
    /**
     * Returns all blog entries from the specifeid user_url_name
     * 
     * @param string $userUrlName blog user_url_name
     */
    public function getAllPublishedByUserUrlName($userUrlName)
    {
        $sql = "SELECT * FROM `blog` WHERE `blog`.published=1 AND `blog`.user_url_name = ? ORDER BY `blog`.createdon DESC;";
        return $this->db->query($sql, array($userUrlName));
    }
    
    public function getAllByUserId($userId)
    {
        $this->db->select('blog.*, users.user_name');
        $this->db->from('blog');
        $this->db->join('users', 'users.user_id = blog.user_id', 'left');
        $this->db->where('blog.user_id', $userId);
        $this->db->order_by('blog.id', 'blog.title');
        
        return $this->db->get();
    }
    
    public function getBySeoFriendlyUrl($userUrlName, $url)
    {
        $sql = "SELECT * FROM `blog` 
            WHERE `blog`.published=1 
            AND `blog`.user_url_name = ? 
            AND `blog`.url = ?
            ORDER BY `blog`.createdon DESC;";
        return $this->db->query($sql, array($userUrlName, $url));
    }
    
    public function get_5(){
        return
                $this->db->query("SELECT * FROM `blog` WHERE `blog`.published=1 ORDER BY `blog`.id DESC LIMIT 5;");
    }

    
    public function get_page($page_num){
        return
                $this->db->query("SELECT * FROM `blog` WHERE `blog`.published=1 ORDER BY `blog`.id DESC LIMIT ".$page_num.",10;");
    }
    
    public function getBlogById($id){
        $this->db->select('blog.*, users.user_name');
        $this->db->from('blog');
        $this->db->join('users', 'users.user_id = blog.user_id', 'left');
        $this->db->where('blog.id', $id);
        
        return $this->db->get();
    }
    
    public function getBlogByUrl($url){
        $this->db->select('blog.*, users.user_name');
        $this->db->from('blog');
        $this->db->join('users', 'users.user_id = blog.user_id', 'left');
        $this->db->where('blog.url', $url);
        
        return $this->db->get();
    }
    
    /**
     * Publish/unpublish a blog
     * 
     * @param bool $is_published Is published flag
     */
    public function publish($id, $is_published){
        /*
        $this->db->query("UPDATE `blog`
                            SET published='".$is_published."'
                            WHERE `blog`.id=" . $id . "; ");
         */
        $published;
        if ($is_published > 0)
            $published = 0;
        else
            $published = 1;
        
        $data = array(
           'published' => $published
        );
        
        $this->db->where('id', $id);
        $this->db->update('blog', $data);
    }
    
    /**
     * Update a blog entry
     * @param int $id blog id or url
     * @param array $data blog data
     */
    public function update($data, $id){
        if(is_numeric($id))
            $this->db->where('id', $id);
        else
            $this->db->where('url', $id);
        
        $this->db->update('blog', $data);
  
    }
    
    public function delete($id){
        /*
        $this->db->query("DELETE FROM `blog` WHERE `blog`.id=" . $id . " ; ");
         */
        $this->db->delete('blog', array('id' => $id));
        
        if ($this->db->affected_rows() == '1') {
            return true;
        }
        
        return false;
    }
    
    /**
     * Create a blog entry
     * @param string $title blog title
     * @param string $contents Blog contents
     * @param string $url Blog SEO friendly URL
     */
    public function create($title, $contents, $url, $published){
         $this->db->query("INSERT INTO blog(title,contents,url,published)
                           VALUES('" . $title . "','" . $contents . "','" . $url . "','" .$published . "'); ");
    }
    
    /**
     * Create a blog entry using Active Record
     */
    public function save($data)
    {
        // get Default value for URL if URL is empty
        if(empty($data['url']) || $data['url'] == '')
            $data['url'] = $this->getDefaultUrl($data['title']);
        
        $this->db->insert('blog', $data);
        
        if ($this->db->affected_rows() == '1') {
            return true;
        }
        
        return false;
    }
    
    /*
     * Calculates user_url_name for the blog table
     */
    public function getUserUrlName($userId)
    {
        $sql = "SELECT
            DISTINCT users.user_id,
            users.user_name,
            sites.site
            FROM users
            LEFT JOIN sites ON sites.user_id = users.user_id
            WHERE users.user_id = ?";
        $query = $this->db
                ->query($sql, array($userId))
                ->row();

        $userName = strtolower(preg_replace('/[^A-Za-z0-9_]/', '', $query->user_name));
        $siteName = strtolower(preg_replace('/[^A-Za-z0-9_]/', '', $query->site));
        $userUrlName = $userName.'_'.$siteName;
        
        return $userUrlName;
    }
    
    /*
     * Calculates default URL if URL is not given
     * This is the Title and the ID of the post
     */
    public function getDefaultUrl($title)
    {
        $id = NULL;
        $query = $this->db->query('SELECT id FROM blog ORDER BY id DESC LIMIT 1');
        if ($query->num_rows() > 0) {
            $result = $query->result();
            $id = $result[0]->id + 1;
        }
        else {
            $id = 1;
        }
        
        // cleaning title
        $patterns = array("/\s+/", "/\s([?.!])/");
        $replacer = array(" ","$1");
        $title = preg_replace($patterns, $replacer, $title);    //clear additional spaces
        $title = preg_replace('/[^A-Za-z0-9_ -]/', '', $title); //clear unwanted characters
                
        $title = strtolower(str_replace(' ', '-', $title)); //replace spaces with "-"
        // end of cleaning title
        
        $url = "$title-$id";
        
        return $url;
    }
    
    /*
     * Cleans URL of unwanted characters should all validations fail
     */
    public function cleanUrl($url)
    {
        $cleaned = strtolower(preg_replace('/[^A-Za-z0-9_\-]/', '', $url));
        
        return $cleaned;
    }
}

?>
