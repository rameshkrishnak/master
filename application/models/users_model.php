<?php

class Users_model extends CI_Model {

    /**
    * Validate the login's data with the database
    * @param string $user_name
    * @param string $password
    * @return void
    */
	function validate($user_name, $password)
	{
		//$password='21232f297a57a5a743894a0e4a801fc3';
		//echo "select * from team_profile where team_profile_username = '" . $user_name . "' and team_profile_password = '" .$password . "'";
		  $sql = "select * from team_profile where team_profile_username = '" . $user_name . "' and team_profile_password = '" .$password. "' and  team_profile_groups_id in(1,2,3,4,5)";
		
		/*$this->db->where('team_profile_username', $user_name);
		$this->db->where('team_profile_password', base64_encode($password));*/
		$query = $this->db->query($sql);
		
		//$query = $this->db->get('team_profile');
		//print_r($query);
		if($query->num_rows == 1)
		{
			return true;
		}		
	}	function getlogin($user_name, $password)	{		$sql = "select team_profile_groups_id,team_profile_id from team_profile where team_profile_username = '" . $user_name . "' and team_profile_password = '" .$password. "' and  team_profile_groups_id in(1,2,3,4,5)"; 		$query = $this->db->query($sql);		$rs=$query->row();		return $rs;	}

    /**
    * Serialize the session data stored in the database, 
    * store it in a new array and return it to the controller 
    * @return array
    */
	function get_db_session_data()
	{
		$query = $this->db->select('user_data')->get('ci_sessions');
		$user = array(); /* array to store the user data we fetch */
		foreach ($query->result() as $row)
		{
		    $udata = unserialize($row->user_data);
		    /* put data in array using username as key */
		    $user['user_name'] = $udata['user_name']; 
		    $user['user_id'] = $udata['user_id']; 
		    $user['user_group'] = $udata['user_group']; 
		    $user['is_logged_in'] = $udata['is_logged_in']; 
		}
		return $user;
	}
	
    /**
    * Store the new user's data into the database
    * @return boolean - check the insert
    */	
	function create_member()
	{

		$this->db->where('user_name', $this->input->post('username'));
		$query = $this->db->get('membership');

        if($query->num_rows > 0){
        	echo '<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>';
			  echo "Username already taken";	
			echo '</strong></div>';
		}else{

			$new_member_insert_data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'email_addres' => $this->input->post('email_address'),			
				'user_name' => $this->input->post('username'),
				'pass_word' => md5($this->input->post('password'))						
			);
			$insert = $this->db->insert('membership', $new_member_insert_data);
		    return $insert;
		}
	      
	}//create_member
}

