<?php
class payroll_manage_model extends CI_Model {
 
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
    public function get_manufacture_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('manufacturers');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }    

    /**
    * Fetch manufacturers data from the database
    * possibility to mix search, filter and order
    * @param string $search_string 
    * @param strong $order
    * @param string $order_type 
    * @param int $limit_start
    * @param int $limit_end
    * @return array
    */
    public function get_employ_payroll_detail($search_string=null, $order=null, $order_type='Asc', $limit_start=null, $limit_end=null)
    {
	    
		$this->db->select('*');
		$this->db->from('payroll_manage_salary');

		if($search_string){
			$this->db->like('employ_name', $search_string);
		}
		$this->db->group_by('salary_id');

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('salary_id', $order_type);
		}

        if($limit_start && $limit_end){
          $this->db->limit($limit_start, $limit_end);	
        }

        if($limit_start != null){
          $this->db->limit($limit_start, $limit_end);    
        }
        
		$query = $this->db->get();
		
		return $query->result_array(); 	
    }

    /**
    * Count the number of rows
    * @param int $search_string
    * @param int $order
    * @return int
    */
    function count_manufacturers($search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from('manufacturers');
		if($search_string){
			$this->db->like('name', $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('id', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }

    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_payroll_details($data)
    {
		//print_r($data);
		//echo 'hihi'.$data['employ_name'].'';exit;
		$this->db->select('*');
		$this->db->from('payroll_manage_salary');
		$this->db->where('employ_name',$data['employ_name']);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return 0;
		}
		else
		{
			$insert = $this->db->insert('payroll_manage_salary', $data);
			return $insert;
	 	}
	}

    /**
    * Update manufacture
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_manufacture($id, $data)
    {
		$this->db->where('id', $id);
		$this->db->update('manufacturers', $data);
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
    * Delete manufacturer
    * @param int $id - manufacture id
    * @return boolean
    */
	function delete_manufacture($id){
		$this->db->where('id', $id);
		$this->db->delete('manufacturers'); 
	}
	function select_designation()
	{
		$this->db->select('groups_id, groups_name');
		$this->db->from('groups');
		$this->db->order_by('groups_id', "asc");
		$query = $this->db->get();
		if($query)
		{
			$query = $query->result_array();
			return $query;
		}
	}
	function select_employee_name()
	{
		$this->db->select('team_profile_full_name,team_profile_id,team_profile_employee_id');
		$this->db->from('team_profile');
		$query=$this->db->get();
		if($query)
		{
			$query=$query->result_array();
			return $query;
		}
	}
	
	 public function get_employee_sal_details($salary_id=null, $search_string=null, $order=null, $order_type='Asc', $limit_start, $limit_end)
    {
	 // SELECT TP.team_profile_full_name,GP.groups_name,PMS.employ_type,TP.team_profile_email,TP.team_profile_telephone FROM  payroll_manage_salary AS PMS INNER JOIN team_profile AS TP ON PMS.`team_profile_id`=TP.team_profile_id INNER JOIN groups AS GP ON PMS.employ_design=GP.groups_id  
	   /* $this->db->select('payroll_manage_salary.salary_id');
		$this->db->select('team_profile.team_profile_id');
		$this->db->select('team_profile.team_profile_full_name');
		$this->db->select('groups.groups_name');
		$this->db->select('payroll_manage_salary.employ_type');
		$this->db->select('team_profile.team_profile_email');
		$this->db->select('team_profile.team_profile_telephone');*/
		$this->db->select('*');
				
		//$this->db->select('team_profile.groups_name as designation');
		$this->db->from('team_profile');
		// if($salary_id != null && $salary_id != 0){
			 $this->db->where('team_profile_status', 'Active');
		// }
		if($search_string){
			$this->db->like('team_profile_full_name', $search_string);
			$this->db->or_like('team_profile_email', $search_string);
			$this->db->or_like('team_profile_telephone', $search_string);
			$this->db->or_like('team_profile_job_position_title', $search_string);
		}

		//$this->db->join('team_profile', 'payroll_manage_salary.team_profile_id =  team_profile.team_profile_id', 'inner');
		//$this->db->join('groups', 'groups.groups_id =  payroll_manage_salary.employ_design', 'inner');
        
		$this->db->group_by('team_profile_id');
        $this->db->order_by('team_profile_id', $order_type);
		// if($order){
			// $this->db->order_by($order, $order_type);
		// }else{
		    // $this->db->order_by('team_profile.team_profile_id', $order_type);
		// }
		


		//$this->db->limit($limit_start, $limit_end);
		//$this->db->limit('4', '4');


		$query = $this->db->get();
		
		return $query->result_array(); 	
    }
	 public function get_employee_result($id)
    {
		$this->db->select('*');
		$this->db->from('payroll_manage_salary');
		$this->db->where('team_profile_id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }
	
	function update_salary_details($id, $data)
    {
		$this->db->select('team_profile_id');
		$this->db->from('payroll_manage_salary');
		$this->db->where_in('team_profile_id',$id);
		$query = $this->db->get();
		//$query->result_array();
		$test=$query->num_rows();
		//return $test;
		if($test>0)
		{
			//return 0;
			$this->db->where('team_profile_id', $id);
			$this->db->update('payroll_manage_salary', $data);
			$report = array();
			$report['error'] = $this->db->_error_number();
			$report['message'] = $this->db->_error_message();
			if($this->db->affected_rows()==1){
				return true;
			}else{
				return false;
			}
		}
		else
		{
			$insert = $this->db->insert('payroll_manage_salary', $data);
			//return $insert;
			if($this->db->affected_rows()==1)
			  return true;
            else
              return false;				
	 	}
		
	}
	function search_sal_details_emp($search_string=null,$order,$order_type='Asc',$limit_start,$limit_end)
	{
		$this->db->select('team_profile.team_profile_full_name');
		$this->db->select('team_profile.team_profile_email');
		$this->db->select('team_profile.team_profile_telephone');
		$this->db->select('team_profile.team_profile_telephone');
		$this->db->from('team_profile');
		if($search_string){
			$this->db->like('team_profile.team_profile_full_name', $search_string);
		}
		$this->db->limit($limit_start, $limit_end);
	}
	function count_payroll_details($search_string=null, $order=null)
    {
		$this->db->select('payroll_manage_salary.salary_id');
		$this->db->select('team_profile.team_profile_id');
		$this->db->select('team_profile.team_profile_full_name');
		$this->db->select('groups.groups_name');
		$this->db->select('payroll_manage_salary.employ_type');
		$this->db->select('team_profile.team_profile_email');
		$this->db->select('team_profile.team_profile_telephone');
				
		//$this->db->select('team_profile.groups_name as designation');
		$this->db->from('payroll_manage_salary');
		// if($salary_id != null && $salary_id != 0){
			// $this->db->where('salary_id', $salary_id);
		// }
		if($search_string){
			$this->db->like('team_profile.team_profile_full_name', $search_string);
		}

		$this->db->join('team_profile', 'payroll_manage_salary.team_profile_id =  team_profile.team_profile_id', 'inner');
		$this->db->join('groups', 'groups.groups_id =  payroll_manage_salary.employ_design', 'inner');

		$this->db->group_by('payroll_manage_salary.team_profile_id');
		$this->db->order_by('payroll_manage_salary.salary_id', 'Asc');
		
		$query = $this->db->get();
		return $query->num_rows();        
    }
	function delete_payroll($id){
		$this->db->where('team_profile_id', $id);
		$this->db->delete('payroll_manage_salary'); 
	}
	function get_employ_id_function($id)
	{
		$this->db->select('team_profile_employee_id');
		$this->db->from('team_profile');
		$this->db->where('team_profile_id', $id);
		$query = $this->db->get();
		return $query->row(); 
	}
 
}
?>	
