<?php
class employee_model extends CI_Model {
 
    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }

    /**
    * Get product by his is
    * @param int $product_id 
    * @return array
    */
    public function get_employee_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('team_profile');
		
		$this->db->where('team_profile_groups_id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }

    /**
    * Fetch products data from the database
    * possibility to mix search, filter and order
    * @param int $manufacuture_id 
    * @param string $search_string 
    * @param strong $order
    * @param string $order_type 
    * @param int $limit_start
    * @param int $limit_end
    * @return array
    */
    public function get_employee($groups_id=null, $search_string=null, $order=null, $order_type='Asc', $limit_start, $limit_end)
    {
	    
		$this->db->select('team_profile.team_profile_id');
		$this->db->select('team_profile.team_profile_full_name');
		$this->db->select('team_profile.team_profile_job_position_title');
		$this->db->select('team_profile.team_profile_username');
		$this->db->select('team_profile.team_profile_status');
		$this->db->select('team_profile.team_profile_job_title');
		$this->db->select('team_profile.team_profile_telephone as manufacture_name');
		$this->db->from('team_profile');
		if($groups_id != null && $groups_id != 0){
			//$id = array(1);

			//$this->db->where_not_in('team_profile_id', $id);
			$this->db->where('team_profile_groups_id', $groups_id);
		}
		if($search_string){
			$this->db->like('team_profile_full_name', $search_string);
		}

		$this->db->join('groups', 'team_profile.team_profile_groups_id = groups.groups_id', 'inner');
		//$id = array(1);
	//	$this->db->where_not_in('groups.groups_id', $id);

		$this->db->group_by('team_profile.team_profile_id');

		if($order){
			$this->db->order_by('team_profile.team_profile_groups_id', $order_type);
		}else{
		    $this->db->order_by('team_profile_groups_id', $order_type);
		}
//$limit_start='1'; $limit_end='40';

		$this->db->limit($limit_start, $limit_end);
		//$this->db->limit('1', '40');


		$query = $this->db->get();
		
		return $query->result_array(); 	
   // print_r($query);
	}

    /**
    * Count the number of rows
    * @param int $manufacture_id
    * @param int $search_string
    * @param int $order
    * @return int
    */
	
	function get_employee_update($id) 
	{
		$this->db->select('team_profile.*');
		$this->db->from('team_profile');
		$this->db->where('team_profile_id', $id);
		
		$query = $this->db->get();
		return $query->result_array(); 	
		
		
	}
	
	
	
	
	
	
	
    function count_employee($groups_id=null, $search_string=null, $order=null)
    {
	 	$this->db->select('*');
		$this->db->from('team_profile');
		if($groups_id != null && $groups_id != 0){
			$id = array(1);

			$this->db->where_not_in('team_profile_groups_id', $id);
			//$this->db->where('team_profile_groups_id', $groups_id);
			//WHERE username NOT IN ('Frank', 'Todd', 'James')
		}
		if($search_string){
			$this->db->like('team_profile_full_name', $search_string);
		}
		if($order){
			$this->db->order_by('team_profile_full_name', 'Asc');
		}else{
		    $this->db->order_by('team_profile_id', 'Asc');
		}
		 $query = $this->db->get();
		// print_r( $query);
		return $query->num_rows();        
//		return $query->num_rows();        
    }

    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_employee($data)
    {
		$insert = $this->db->insert('team_profile', $data);
	    return $insert;
	}

    /**
    * Update product
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_employee($id, $data)
    {
		 $this->db->where('team_profile_id', $id);
		 $this->db->update('team_profile', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}

    /**
    * Delete product
    * @param int $id - product id
    * @return boolean
    */
	function delete_employee($id){
		$data=array('team_profile_status' =>'Inactive');
		$this->db->where('team_profile_id', $id);
		$this->db->update('team_profile',$data); 
	}
	
	
	function do_upload($id)
	{
		
		
        if (isset($_FILES["myfile"]) && !empty($_FILES['myfile']['name']))
        {
           $no_files = count($_FILES["myfile"]['name']);
		
			
						$this->load->library('upload');
						$query = $this->db->query('SELECT team_profile.* FROM team_profile where team_profile_id='.$id.'');
						$row = $query->row_array();
						$folderName=$row['team_profile_username'];	
					//	echo $folderName;
						if(!is_dir("assets/uploads/".$folderName))
						{
							mkdir("assets/uploads/".$folderName,0777);
							$upload_dir ="assets/uploads/".$folderName."/";
				
						}
						elseif(is_dir("assets/uploads/".$folderName))
						{
							$upload_dir ="assets/uploads/".$folderName."/";
						}
						else
						{
							$upload_dir = "assets/uploads/";
						}
						
						//echo $upload_dir;
									//	exit;
					//	$upload_dir = "assets/uploads/";
					
						if (isset($_FILES["myfile"]))
						 {
							 $no_files = count($_FILES["myfile"]['name']);
							
								for ($i = 0; $i < $no_files; $i++)
								 {
				
									if ($_FILES["myfile"]["error"][$i] > 0) 
									{
										//echo "Error: " . $_FILES["myfile"]["error"][$i] . "<br>";
										
									} 
									else 
									{
										//echo $_FILES["myfile"]["tmp_name"][$i];
									//	echo $upload_dir;
									//	exit;
										move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $upload_dir . $_FILES["myfile"]["name"][$i]);
									   // echo $_FILES["myfile"]["name"][$i] . "<br>";
									  // return true;
									}
								}
								
						}
					
					}
				
		
		}
	
	
	
 
}


?>	
