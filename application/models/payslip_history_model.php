<?php
class Payslip_history_model extends CI_Model {
 
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
   
  public function get_employee_sal_details($search_name)
    {   $current_month=date('m');
	    $this->db->select('payslip_history.*,team_profile.*');
		$this->db->from('payslip_history');
		$this->db->join('team_profile','team_profile.team_profile_id=payslip_history.team_profile_id','inner');
		$this->db->where('MONTH(CURDATE())',$current_month);
		if($search_name!='')
		$this->db->like('team_profile_full_name',$search_name);	
        $this->db->group_by('payslip_id');	
		$this->db->order_by('team_profile.team_profile_id', 'Asc');
		$query = $this->db->get();
		
		return $query->result_array(); 	
    }
	
}
?>	
