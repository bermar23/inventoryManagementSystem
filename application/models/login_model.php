<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Description: Login model class
 */
class Login_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    public function validate(){
        $username = trim($this->input->post('username'));
		$password = trim($this->input->post('password'));
        
         // Prep the query
        //$this->db->where('userName', $username);
        //$this->db->where('password', $password);
        
        // Run the query
        //$query = $this->db->get('tblusers');
        $query = $this->db->get_where('tblusers', array('userName' => $username, 'password' => $password));
        
        if($query->num_rows == 1)
        {
            // If there is a user, then create session data
            $row = $query->row();
            $data = array(
                    'user_name' => $row->userName
                    );
            $this->session->set_userdata($data);            
            return true;
        }
        // If the previous process did not validate
        // then return false.
        return false;
    }
}
?>