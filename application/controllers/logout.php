<?php

class Logout extends CI_Controller {

    /**
    * Check if the user is logged in, if he's not, 
    * send him to the login page
    * @return void
    */	
	function index()
	{
		$data = array(
				'user_name' => '',
				'user_id' => '',
				'user_group' => '',
				'is_logged_in' => false
			);
		
		$this->session->unset_userdata($data); 
		$this->session->sess_destroy();    
		redirect('admin');
	}

   
	
}