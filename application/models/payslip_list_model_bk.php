<?php
class Payslip_list_model extends CI_Model {
 
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
    {
	    $this->db->select('payslip.*,team_profile.*');
		$this->db->from('payslip');
		$this->db->join('team_profile','team_profile.team_profile_id=payslip.team_profile_id','inner');
		if($search_name!='')
		$this->db->like('team_profile_full_name',$search_name);	
		$this->db->order_by('team_profile.team_profile_id', 'Asc');
		$query = $this->db->get();
		
		return $query->result_array(); 	
    }
	function update_payslip_list($id, $data)
    {
		$this->db->where('team_profile_id', $id);
		$this->db->update('payslip', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}
}
?>	
