<?php
class Payslip_model extends CI_Model {
 
    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
		//require_once site_url('/application/models/MPDF54/mpdf.php');
		
    }

    /**
    * Get product by his is
    * @param int $product_id 
    * @return array
    */
   public function generate_employee_payslip()
   {
	  $query=$this->db->query("SELECT * FROM `payslip` WHERE  MONTH(curr_date_month)=MONTH(CURDATE())");
	  if($query->num_rows>0)
	  {
		  return 'Exist';
	  }
	  else
	  {
		  $query=$this->db->query("
			  INSERT INTO payslip (salary_id,team_profile_id,employee_id_no,employ_design,employ_name,employ_type,employ_basic_salary,employ_house_allow,employ_medical_allow,employ_conveyance,employ_special_allow,employ_fuel_allow,employ_phone_allow,employ_other_allow,employ_deduct_provident,employ_deduct_tax,employ_other_deduct,employ_gross_sal,employ_total_deduct,employee_net_salary)SELECT salary_id,team_profile_id,employ_id_no,employ_design,employ_name,employ_type,employ_basic_salary,employ_house_allow,employ_medical_allow,employ_conveyance,employ_special_allow,employ_fuel_allow,employ_phone_allow,employ_other_allow,employ_deduct_provident,employ_deduct_tax,employ_other_deduct,employ_gross_sal,employ_total_deduct,employee_net_salary FROM payroll_manage_salary");
			  $this->db->query("UPDATE payslip SET curr_date_month=CURDATE() where curr_date_month=''");
		  if($query)
		  {
			  return 'Success';
		  }
		  else
		  {
			return 'Failed';  
		  }
	  }
   } 
   
   public function re_generate_employee_payslip()
   {
	   $this->db->query("INSERT INTO payslip_history(curr_date_month, salary_id, team_profile_id, employ_design, employ_name, employ_type, employ_basic_salary, employ_house_allow, employ_medical_allow, employ_conveyance, employ_special_allow, employ_fuel_allow, employ_phone_allow, employ_other_allow, employ_deduct_provident, employ_deduct_tax, employ_other_deduct, employ_gross_sal, employ_total_deduct, employee_net_salary) SELECT curr_date_month, salary_id, team_profile_id, employ_design, employ_name, employ_type, employ_basic_salary, employ_house_allow, employ_medical_allow, employ_conveyance, employ_special_allow, employ_fuel_allow, employ_phone_allow, employ_other_allow, employ_deduct_provident, employ_deduct_tax, employ_other_deduct, employ_gross_sal, employ_total_deduct, employee_net_salary FROM payslip");
	   $delete_query=$this->db->query("DELETE FROM payslip where MONTH(curr_date_month)=MONTH(CURDATE())");
	   if($this->db->affected_rows()>0)
	   {
		   return 'Deleted';
	   }
	   else
	   {
		   return 'No_data';
	   }
   }
   
   public function tables()
	{
		$this->load->library('cezpdf');

		/*$db_data[] = array('name' => 'Jon Doe', 'phone' => '111-222-3333', 'email' => 'jdoe@someplace.com');
		$db_data[] = array('name' => 'Jane Doe', 'phone' => '222-333-4444', 'email' => 'jane.doe@something.com');
		$db_data[] = array('name' => 'Jon Smith', 'phone' => '333-444-5555', 'email' => 'jsmith@someplacepsecial.com');
		$db_data[] = array('name' => 'Jon Smith', 'phone' => '333-444-5555', 'email' => 'jsmith@someplacepsecial.com');
		$db_data[] = array('name' => 'Jon Doe', 'phone' => '111-222-3333', 'email' => 'jdoe@someplace.com');
		$db_data[] = array('name' => 'Jane Doe', 'phone' => '222-333-4444', 'email' => 'jane.doe@something.com');
		
		$col_names = array(
			'name' => 'Name',
			'phone' => 'Phone Number',
			'email' => 'E-mail Address',
			
			
		);*/
		$q=$this->db->query('SELECT team_profile_id, employ_design, employ_name FROM  payslip');
                //this data will be presented as table in PDF
		$db_data=array();
		foreach ($q->result_array() as $row) {
			$db_data[]=$row;
		}
                //this one is for table header
		$col_names=array(
			'team_profile_id'=>'Employee ID',
			'employ_design'=>'Designation',
			'employ_name'=>'Employee Name'
		);
		
		$this->cezpdf->ezTable($db_data, $col_names, 'Contact List', array('width'=>550));
		$this->cezpdf->ezStream();
		
		$pdfoutput=$this->cezpdf->ezOutput();
		$f=fopen("application/models/payslip_store/test.pdf", "wb");
		fwrite($f, $pdfoutput);
		fclose($f);
		
		

	}
	
	public function get_all_employees()
	{
		$this->db->select('team_profile_employee_id');
		$this->db->select('team_profile_full_name');
		$this->db->from('team_profile');
		$this->db->where('team_profile_status','active');
		$this->db->where('team_profile_nottoshow','0');
		if($this->session->userdata('user_group')==2 || $this->session->userdata('user_group')==3) {
		$this->db->where('team_profile_id',$this->session->userdata('user_id'));
		}
		$query = $this->db->get();
		return $query->result_array(); 	
		
	}
/*	public function select_emp_for_payslip($data,$start_end_date)
	{
		$get_details=array();
		$get_Payslip=array();
		//print_r($data);
		$start_end_date= explode("_",$start_end_date);
		$start_date = $start_end_date[0];
		$end_date   = $start_end_date[1];
		for($k=0;$k<count($data);$k++)
		{
			
			$employee_id_no               = $data[$k][0]['employee_id_no'];	
			$team_profile_employee_id     = $data[$k][0]['team_profile_employee_id'];
		if($team_profile_employee_id!='')
		{
			//echo $k.'hihi      :'.$data[$k][0]['employee_id_no'];
			$team_profile_id              = $data[$k][0]['team_profile_id'];
			
			$team_profile_full_name       = $data[$k][0]['team_profile_full_name'];
			$curr_date_month              = $data[$k][0]['curr_date_month'];
			$employ_basic_salary          = $data[$k][0]['employ_basic_salary'];
			$employ_deduct_tax            = $data[$k][0]['employ_deduct_tax'];
			$employ_house_allow           = $data[$k][0]['employ_house_allow'];
			$employ_deduct_provident      = $data[$k][0]['employ_deduct_provident'];
			$employ_conveyance            = $data[$k][0]['employ_conveyance'];
			$employ_medical_allow         = $data[$k][0]['employ_medical_allow'];
			$employ_other_allow           = $data[$k][0]['employ_other_allow'];
			$employ_gross_sal             = $data[$k][0]['employ_gross_sal'];
			$employ_total_deduct          = $data[$k][0]['employ_total_deduct'];
			$employee_net_salary          = $data[$k][0]['employee_net_salary'];
			
			
			//return $team_profile_full_name;
		 
		  $ch = curl_init();
		  //$url='http://localhost:8080/attendance.php?start_date='.$start_date.'&end_date='.$end_date;
		  $url='http://mgt.nathanresearch.com/project_mgt/attendance.php?start_date='.$start_date.'&end_date='.$end_date.'&emp_id='.$team_profile_employee_id;
		  $curl = curl_init($url);
		  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		  curl_setopt($ch, CURLOPT_HTTPGET, 1);
		  $curl_response = curl_exec($curl);
		  curl_close($curl);
		  $curl_response1=json_decode($curl_response);
		  $team_profile_id_arr  = array();    
		  $fullname_arr         = array();
		  $Status_arr           = array();
		  $COUNT1_arr           = array();
		  
		//print_r($curl_response1);
		  // Getting all employee status from api
			foreach($curl_response1 as $test)
			{
				  $team_profile_id_arr[] = $test->team_profile_employee_id; 
				  $fullname_arr[]		 = $test->fullname; 
				  $Status_arr[]		     = $test->Status; 
				  $COUNT1_arr[]	     	 = $test->COUNT; 
			}
		    // print_r($team_profile_id_arr);
		   print_r($team_profile_id_arr);
		 //  print_r($Status_arr);
		  // print_r($COUNT1_arr);
		  // When we give the employee id here you can get the count(IN,Leave,SL) of employee status 
			 $employ_id_count=array_count_values($team_profile_id_arr);
			// print_r($employ_id_count);
			// $employee_id=$data["team_profile_id"];
			$employee_id=trim($team_profile_employee_id);
			$count_eployee_status=$employ_id_count[$employee_id];

			$key_employee  = array_search($employee_id, $team_profile_id_arr);
			if($count_eployee_status==0)
			{
				$office_in_att=0;
				$office_in_att_leave=0;
				$office_in_att_sl=0;
			}
			for($i=1;$i<=$count_eployee_status;$i++)
			{
				//$employee_name =$fullname_arr[$key_employee];
				$employee_name = $fullname_arr[$key_employee];
				$status_atten  = $Status_arr[$key_employee];
				$count_atten   = $COUNT1_arr[$key_employee];
				
				//echo '<br>'.$employee_name; echo '<br>';echo $status_atten; echo '<br>'; echo $count_atten;
				 if($status_atten=='IN')
				 {
					 //$office_in     ='IN';
					 $office_in_att =$count_atten;
				 }
				
				 if($status_atten=='Leave')
				 {
					// $office_leave='Leave';
					 $office_in_att_leave=$count_atten;
				 }
				 if($status_atten=='SL')
				 {
					// $office_sl='Sick Leave';
					 $office_in_att_sl=$count_atten;
				 }
				 $key_employee=$key_employee+1;
			// echo $office_in_att;echo $office_in_att_leave;echo $office_in_att_sl;
			   if($office_in_att=='')
			   $office_in_att=0; 
			   if($office_in_att_leave=='')
			   $office_in_att_leave=0;
			   if($office_in_att_sl=='')
			   $office_in_att_sl=0;
				   
			}
			
		
$resultdata ='';
		$resultdata .= '<div align="center"><table cellpadding="3" cellspacing="0" border="1" width="80%">
                          <tr><td><b>NATHAN RESEARCH SYSTEMS PRIVATE LIMITED</b></td><td colspan="4" align="center">PAYSLIP</td></tr>
						  <tr><td colspan="5"><b>46B/16, SOUTH BOAG ROAD, T.NAGAR CHENNAI - 600 017</b></td></tr>
						  <tr><td colspan="2"><b>Employee Name &nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; </b>'.$team_profile_full_name.'</td><td><b>Employee ID :</b></td><td></td></tr>
						  <tr><td colspan="1"><b>Designation &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;</b></td><td align="center" colspan="3"><b>Employee Attendance for Pay Period of '.date("M-y",strtotime($curr_date_month)).'</b></td></tr>
						  <tr><td><b></b></td><td align="center"> IN : '.$office_in_att.'</td><td align="center">Leave : '.$office_in_att_leave.'</td><td align="center">Sick Leave : '.$office_in_att_sl.'</td></tr>
						  <tr><td align="center" colspan="2"><b>Earnings </b></td><td colspan="3" align="center"><b>Deductions</b></td></tr>
						  <tr><td><b>Detail</b></td><td align="right"><b>Amount in Rs</b></td><td><b>Detail</b></td><td colspan="2"  align="right"><b>Amount in Rs</b></td></tr>
						  <tr><td >Basic salary</td><td align="right">'.$employ_basic_salary.'</td><td>Income Tax</td><td colspan="2" align="right">'.$employ_deduct_tax.'</td></tr>
						  <tr><td>HRA</td><td align="right">'.$employ_house_allow.'</td><td>PF</td><td colspan="3" align="right">'.$employ_deduct_provident.'</td></tr>
						  <tr><td>Conveyance</td><td align="right" >'.$employ_conveyance.'</td><td colspan="3"></td></tr>
						  <tr><td>Medical </td><td align="right">'.$employ_medical_allow.'</td><td colspan="3"></td></tr>
						  <tr><td> Other Allowance</td><td align="right">'.$employ_other_allow.'</td><td colspan="3"></td></tr>
						  <tr><td>Total Earnings</td><td align="right">'.$employ_gross_sal.' </td><td>Total Deductions</td><td colspan="2" align="right">'.$employ_total_deduct.'</td></tr>
						   <tr></tr>
						    <tr><td>Net Pay </td><td align="right" >'.$employee_net_salary.'</td><td>Credit to </td><td colspan="2" align="center">Bank</td></tr>
							<tr></tr>
							<tr><td colspan="5">Ramachandran Viswanathan</td></tr>
						  <tr><td colspan="5">Director - Nathan Research Systems Private Limited</td></tr>
						  </table>
						   <p align="center" style="font-size:90%;font-style:italic">This is computer generated; no authentication required</p></div>
						  ';		   
			
		
		
		
						
			//echo 'No record found.';
			//return $url;
	    	$get_Payslip[]=$resultdata;
		 }	
		}
		
	  return $get_Payslip;
		
	}
*/
     public function select_emp_for_payslip1($data)
	{
		$get_details=array();
		$get_Payslip=array();
		//print_r($data);
		//echo count($data);
		//echo $employee_id_no               = $data[0][0]['employee_id_no'];		
		for($k=0;$k<count($data);$k++)
		{
			//echo count($data[$k]);
			//echo $data[$k][1]['employee_id_no'];
		for($l=0;$l<count($data[$k]);$l++)
		{			
			$curr_date_month               = $data[$k][$l]['curr_date_month'];	
			$team_profile_employee_id     = $data[$k][$l]['team_profile_employee_id'];
		if($team_profile_employee_id!='')
		{
			//echo $k.'hihi      :'.$data[$k][0]['employee_id_no'];
			$team_profile_id              = $data[$k][$l]['team_profile_id'];
			
			$team_profile_full_name       = $data[$k][$l]['team_profile_full_name'];
			$curr_date_month              = $data[$k][$l]['curr_date_month'];
			$employ_basic_salary          = $data[$k][$l]['employ_basic_salary'];
			$employ_deduct_tax            = $data[$k][$l]['employ_deduct_tax'];
			$employ_house_allow           = $data[$k][$l]['employ_house_allow'];
			$employ_deduct_provident      = $data[$k][$l]['employ_deduct_provident'];
			$employ_conveyance            = $data[$k][$l]['employ_conveyance'];
			$employ_medical_allow         = $data[$k][$l]['employ_medical_allow'];
			$employ_other_allow           = $data[$k][$l]['employ_other_allow'];
			$employ_gross_sal             = $data[$k][$l]['employ_gross_sal'];
			$employ_total_deduct          = $data[$k][$l]['employ_total_deduct'];
			$employee_net_salary          = $data[$k][$l]['employee_net_salary'];
			
		 $start_date  = date('Y-m-01', strtotime($curr_date_month));
		 $end_date   = date('Y-m-t', strtotime($curr_date_month));
				 
		  $ch = curl_init();
		  //$url='http://localhost:8080/attendance.php?start_date='.$start_date.'&end_date='.$end_date;
		  $url='http://mgt.nathanresearch.com/project_mgt/attendance.php?start_date='.$start_date.'&end_date='.$end_date.'&emp_id='.$team_profile_employee_id;
		  $curl = curl_init($url);
		  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		  curl_setopt($ch, CURLOPT_HTTPGET, 1);
		  $curl_response = curl_exec($curl);
		  curl_close($curl);
		  $curl_response1=json_decode($curl_response);
		  $team_profile_id_arr  = array();    
		  $fullname_arr         = array();
		  $Status_arr           = array();
		  $COUNT1_arr           = array();
		  
		  // Getting all employee status from api
			foreach($curl_response1 as $test)
			{
				  $team_profile_id_arr[] = $test->team_profile_employee_id; 
				  $fullname_arr[]		 = $test->fullname; 
				  $Status_arr[]		     = $test->Status; 
				  $COUNT1_arr[]	     	 = $test->COUNT; 
			}
		   
		   // print_r($team_profile_id_arr);
			$employ_id_count=array_count_values($team_profile_id_arr);
			$employee_id=trim($team_profile_employee_id);
			$count_eployee_status=$employ_id_count[$employee_id];

			$key_employee  = array_search($employee_id, $team_profile_id_arr);
			if($count_eployee_status==0)
			{
				$office_in_att=0;
				$office_in_att_leave=0;
				$office_in_att_sl=0;
			}
			for($i=1;$i<=$count_eployee_status;$i++)
			{
				$employee_name = $fullname_arr[$key_employee];
				$status_atten  = $Status_arr[$key_employee];
				$count_atten   = $COUNT1_arr[$key_employee];
				
			    if($status_atten=='IN')
				 {
					 //$office_in     ='IN';
					 $office_in_att =$count_atten;
				 }
				
				 if($status_atten=='Leave')
				 {
					// $office_leave='Leave';
					 $office_in_att_leave=$count_atten;
				 }
				 if($status_atten=='SL')
				 {
					// $office_sl='Sick Leave';
					 $office_in_att_sl=$count_atten;
				 }
				 $key_employee=$key_employee+1;
			
			   if($office_in_att=='')
			   $office_in_att=0; 
			   if($office_in_att_leave=='')
			   $office_in_att_leave=0;
			   if($office_in_att_sl=='')
			   $office_in_att_sl=0;
				   
			}
			
		
$resultdata ='';
		$resultdata .= '<div align="center"><table cellpadding="3" cellspacing="0" border="1" width="80%">
                          <tr><td><b>NATHAN RESEARCH SYSTEMS PRIVATE LIMITED</b></td><td colspan="4" align="center">PAYSLIP</td></tr>
						  <tr><td colspan="5"><b>46B/16, SOUTH BOAG ROAD, T.NAGAR CHENNAI - 600 017</b></td></tr>
						  <tr><td colspan="2"><b>Employee Name &nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; </b>'.$team_profile_full_name.'</td><td><b>Employee ID :</b></td><td>'.$all_value[$k][$l]["team_profile_employee_id"].'</td></tr>
						  <tr><td colspan="1"><b>Designation &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;</b></td><td align="center" colspan="3"><b>Employee Attendance for Pay Period of '.date("M-y",strtotime($curr_date_month)).'</b></td></tr>
						  <tr><td><b></b></td><td align="center"> IN : '.$office_in_att.'</td><td align="center">Leave : '.$office_in_att_leave.'</td><td align="center">Sick Leave : '.$office_in_att_sl.'</td></tr>
						  <tr><td align="center" colspan="2"><b>Earnings </b></td><td colspan="3" align="center"><b>Deductions</b></td></tr>
						  <tr><td><b>Detail</b></td><td align="right"><b>Amount in Rs</b></td><td><b>Detail</b></td><td colspan="2"  align="right"><b>Amount in Rs</b></td></tr>
						  <tr><td >Basic salary</td><td align="right">'.$employ_basic_salary.'</td><td>Income Tax</td><td colspan="2" align="right">'.$employ_deduct_tax.'</td></tr>
						  <tr><td>HRA</td><td align="right">'.$employ_house_allow.'</td><td>PF</td><td colspan="3" align="right">'.$employ_deduct_provident.'</td></tr>
						  <tr><td>Conveyance</td><td align="right" >'.$employ_conveyance.'</td><td colspan="3"></td></tr>
						  <tr><td>Medical </td><td align="right">'.$employ_medical_allow.'</td><td colspan="3"></td></tr>
						  <tr><td> Other Allowance</td><td align="right">'.$employ_other_allow.'</td><td colspan="3"></td></tr>
						  <tr><td>Total Earnings</td><td align="right">'.$employ_gross_sal.' </td><td>Total Deductions</td><td colspan="2" align="right">'.$employ_total_deduct.'</td></tr>
						   <tr></tr>
						    <tr><td>Net Pay </td><td align="right" >'.$employee_net_salary.'</td><td>Credit to </td><td colspan="2" align="center">Bank</td></tr>
							<tr></tr>
							<tr><td colspan="5">Ramachandran Viswanathan</td></tr>
						  <tr><td colspan="5">Director - Nathan Research Systems Private Limited</td></tr>
						  </table>
						   <p align="center" style="font-size:90%;font-style:italic">This is computer generated; no authentication required</p></div>
						  ';		   
			
		
		
		
						
			//echo 'No record found.';
			//return $url;
	    	
		 }	
		// $resultdata1=$resultdata;
		 $get_Payslip[]=$resultdata;
		}
	//	$get_Payslip[]=$resultdata;
	 }
		
	  return $get_Payslip;
		
	}
	
	 public function get_employee_details($employee_id,$selected_month_mail)
	 {
		   for($i=0;$i<count($employee_id);$i++)
		   {
		    $this->db->select('payslip.*');
			$this->db->select('team_profile.team_profile_employee_id');
			$this->db->select('team_profile.team_profile_full_name');
			//$this->db->select('groups.groups_name');
			$this->db->select('payslip.employ_type');
			$this->db->select('team_profile.team_profile_email');
			$this->db->select('team_profile.team_profile_telephone');
			
			$this->db->from('payslip');
			
			$this->db->join('team_profile', 'payslip.employee_id_no =  team_profile.team_profile_employee_id', 'inner');
			//$this->db->join('groups', 'groups.groups_id =  payslip.employ_design', 'inner');
			$this->db->where('team_profile.team_profile_employee_id',$employee_id[$i]);
			$this->db->where('team_profile.team_profile_status','Active');
			$this->db->where('team_profile.team_profile_nottoshow','0');
			$this->db->where("DATE_FORMAT(payslip.curr_date_month, '%Y-%m')=",$selected_month_mail);
			$query = $this->db->get();
			//return $query;
			$get_all_loop_result[]= $query->result_array();
		   }
		   return $get_all_loop_result;
	}
	 public function get_employee_details1($employee_id,$selected_month_mail,$selected_month_mail_to)
	 {
		 if(count($employee_id)>0)
		 {
		   for($i=0;$i<count($employee_id);$i++)
		   {
		    $this->db->select('payslip.*');
			$this->db->select('team_profile.team_profile_employee_id');
			$this->db->select('team_profile.team_profile_full_name');
			//$this->db->select('groups.groups_name');
			$this->db->select('payslip.employ_type');
			$this->db->select('team_profile.team_profile_email');
			$this->db->select('team_profile.team_profile_telephone');
			
			$this->db->from('payslip');
			
			$this->db->join('team_profile', 'payslip.employee_id_no =  team_profile.team_profile_employee_id', 'inner');
			//$this->db->join('groups', 'groups.groups_id =  payslip.employ_design', 'inner');
			$this->db->where('team_profile.team_profile_employee_id',$employee_id[$i]);
			$this->db->where('team_profile.team_profile_status','Active');
			$this->db->where('team_profile.team_profile_nottoshow','0');
			$this->db->where("DATE_FORMAT(payslip.curr_date_month, '%Y-%m') between '$selected_month_mail' and '$selected_month_mail_to'");
			$this->db->order_by("payslip_id");
			$query = $this->db->get();
			//return $query;
			$get_all_loop_result[]= $query->result_array();
		   }
		   return $get_all_loop_result;
		 }
		 else
		 {
		   return 'empty';	 
		 }
	}
	public function all_get_employee_details($month_gen_pay)
	{
		    $this->db->select('payslip.*');
			$this->db->select('team_profile.team_profile_id');
			$this->db->select('team_profile.team_profile_full_name');
			//$this->db->select('groups.groups_name');
			$this->db->select('payslip.employ_type');
			$this->db->select('team_profile.team_profile_email');
			$this->db->select('team_profile.team_profile_telephone');
			
			$this->db->from('payslip');
			
			$this->db->join('team_profile', 'payslip.team_profile_id =  team_profile.team_profile_id', 'inner');
			//$this->db->join('groups', 'groups.groups_id =  payslip.employ_design', 'inner');
			//$this->db->where('team_profile.team_profile_id',$employee_id);
			$this->db->where('team_profile.team_profile_status','Active');
			$this->db->where('team_profile.team_profile_nottoshow','0');
			$this->db->where("DATE_FORMAT(payslip.curr_date_month, '%Y-%m')=",$month_gen_pay);
			$query = $this->db->get();
			//return $query;
			return $query->result_array();
	}
	public function current_start_end_date($selected_month_view)
	{
		$this->db->select('curr_date_month');
		$this->db->from('payslip');
		$this->db->where("DATE_FORMAT(curr_date_month, '%Y-%m')=",$selected_month_view);
		$query = $this->db->get();
		
		$row=$query->result_array(); 
        if($query->num_rows()>0)
		{			
			foreach($query->result_array() as $row)
			{
				$start_date  = date('Y-m-01', strtotime($row['curr_date_month']));
				//$all_dates[] = $start_date;
				$end_date   = date('Y-m-t', strtotime($row['curr_date_month']));
				
			}
			// $query->result_array(); 	
			return $start_date.'_'.$end_date;
		}
		else
		{
			return '0';
		}
	}
	public function current_start_end_date1($selected_month_view,$selected_month_view_to)
	{
		$this->db->select('curr_date_month');
		$this->db->from('payslip');
		$this->db->where("DATE_FORMAT(curr_date_month, '%Y-%m') BETWEEN '$selected_month_view' and '$selected_month_view_to'");
		$this->db->group_by('curr_date_month');
		$this->db->order_by('payslip_id', 'asc');
		$query = $this->db->get();
		
		$row=$query->result_array(); 
        if($query->num_rows()>0)
		{			
			foreach($query->result_array() as $row)
			{
				//$start_date  = date('Y-m-01', strtotime($row['curr_date_month']));
				//$all_dates[] = $start_date;
				//$end_date   = date('Y-m-t', strtotime($row['curr_date_month']));
				$date_list[]=$row['curr_date_month'];
			}
			// $query->result_array(); 	
			return $date_list;
		}
		else
		{
			return '0';
		}
	}
	public function import_file_get_details()
	{
		
		//return $_FILES['import_file']['name'];
		$fname            = $_FILES['import_file']['name'];
		$file_arr         = explode(".", $fname);
		$extension        = trim( $file_arr[count($file_arr)-1] );
		$folderName       = date('m_Y');
		$filename         = "assets/import/".$folderName."/".$fname;
		if(($file_arr[0]=='NR_PAYROLL_GROSS') ||($file_arr[0]=='NR_PAYROLL_DET'))
		{
			if( strtolower($extension) == "csv" )
			{
			  $upload_dir       = "";
			
		    if(!is_dir("assets/import/".$folderName))
				{
					mkdir("assets/import/".$folderName,0777);
					$upload_dir ="assets/import/".$folderName."/";
		
				}
				else if(is_dir("assets/import/".$folderName))
				{
					$upload_dir ="assets/import/".$folderName."/";
				}
				else
				{
					$upload_dir = "assets/import/";
				}
				chmod($upload_dir, 0777);
			move_uploaded_file($_FILES["import_file"]["tmp_name"], $upload_dir . $_FILES["import_file"]["name"]);
			
			// path where your CSV file is located
			 //define('CSV_PATH','D:/wamp/www/hrms/assets/import/');
			//$csv_file = 'D:/wamp/www/hrms/assets/import/'.$folderName."/".$fname; 
		   // return $csv_file;
			
			
			 $handle = fopen($filename, "r");
			 $rep = array("'");
			 $cnt=0;
				 while (($data = fgetcsv($handle, 5000, ",")) !== FALSE)
				 {
					$cnt++;
					if($cnt>1)
					{
						//$num = count($data);
						//for ($c=0; $c < $num; $c++) {
						//  $col[$c] = $data[$c];
					//	}
						
						
						//print_r($data);
						//$Sl_no 	= stripslashes(str_replace($rep, " ", $data[0]));
						
						// $Sl_no = $data[0];
						/* $date_get   = $data[1];
						 $Emp_No   = $data[2];
						 $Emp_name = $data[3];
						 $Emp_basic_salary  = $data[3];*/
						// SQL Query to insert data into DataBase
						if($file_arr[0]=='NR_PAYROLL_GROSS')
						{
						  $date_get 	      		= stripslashes(str_replace($rep, " ", $data[1]));
						  $Emp_No 	       	    	= stripslashes(str_replace($rep, " ", $data[2]));
						  $Emp_name 	      		= stripslashes(str_replace($rep, " ", $data[3]));
						  $Emp_gross_sal         	= stripslashes(str_replace($rep, " ", $data[4]));
						 
						  $sql                ="SELECT * FROM  payslip WHERE STR_TO_DATE(`curr_date_month`,'%Y-%m')='".date('Y-m-00',strtotime($date_get))."' and employee_id_no like '$Emp_No%'";
						 
						  $query              = $this->db->query($sql);
						  $date_get           = date('Y-m-d',strtotime($date_get));  
						  $get_num_rows=$query->num_rows;
						  if($get_num_rows>0)
						  {
							$SQL_UPDATE_GROSS  = "UPDATE payslip SET employ_gross_sal='".$Emp_gross_sal."' WHERE curr_date_month='".$date_get."' and employee_id_no like '".$Emp_No."%'";
						    $query             = $this->db->query($SQL_UPDATE_GROSS);
							//return $SQL_UPDATE_GROSS;   
							  
						  }
						  else
						  {
							
							 $SQL_INSERT_GROSS  =  "INSERT INTO payslip(curr_date_month,employee_id_no,employ_name,employ_gross_sal) VALUES('$date_get','$Emp_No','$Emp_name','$Emp_gross_sal') ";
							 $query             =  $this->db->query($SQL_INSERT_GROSS);
							// return $SQL_INSERT_GROSS;
						  }
						  $msg="gross_insert";
						 // return $msg;
						  
						}
						else if($file_arr[0]=='NR_PAYROLL_DET')
						{
							//return 'I am NR_PAYROLL_DET';
							
							$date_get 	      		= stripslashes(str_replace($rep, " ", $data[1]));
							$Emp_ID 	       		= stripslashes(str_replace($rep, " ", $data[2]));
							$Emp_name 	      		= stripslashes(str_replace($rep, " ", $data[3]));
							$Emp_basic_salary 		= stripslashes(str_replace($rep, " ", $data[4]));
							$Emp_house_allow 	  	= stripslashes(str_replace($rep, " ", $data[5]));
							$Emp_medical_allow    	= stripslashes(str_replace($rep, " ", $data[6]));
							$Emp_conveyance 	    = stripslashes(str_replace($rep, " ", $data[7]));
							$Emp_special_allow 	    = stripslashes(str_replace($rep, " ", $data[8]));
							$Emp_fuel_allow 	    = stripslashes(str_replace($rep, " ", $data[9]));
							$Emp_phone_allow 	    = stripslashes(str_replace($rep, " ", $data[10]));
							$Emp_other_allow 	    = stripslashes(str_replace($rep, " ", $data[11]));
							$Emp_deduct_provident 	= stripslashes(str_replace($rep, " ", $data[12]));
							$Emp_deduct_tax 	    = stripslashes(str_replace($rep, " ", $data[13]));
							$Emp_other_deduct 	    = stripslashes(str_replace($rep, " ", $data[14]));
							//$Emp_gross_sal       	= stripslashes(str_replace($rep, " ", $data[15]));
							$Emp_total_deduct   	= stripslashes(str_replace($rep, " ", $data[16]));
							$Emp_net_salary 	    = stripslashes(str_replace($rep, " ", $data[17]));
							 
						    $sql="SELECT * FROM  payslip WHERE STR_TO_DATE(`curr_date_month`,'%Y-%m')='".date('Y-m-00',strtotime($date_get))."' and employee_id_no like '$Emp_No%'";
							 
							$query=$this->db->query($sql);
							$date_get=date('Y-m-d',strtotime($date_get));  
							$get_num_rows=$query->num_rows;
							if($get_num_rows>0)
							{
								//return 'exist';
								$SQL_UPDATE_GROSS  = "UPDATE payslip SET curr_date_month='$date_get',employ_name='$Emp_name',employee_id_no='$Emp_ID',employ_basic_salary='$Emp_basic_salary',employ_house_allow='$Emp_house_allow',employ_medical_allow='$Emp_medical_allow',employ_conveyance='$Emp_conveyance',employ_special_allow='$Emp_special_allow',employ_fuel_allow='$Emp_fuel_allow',employ_phone_allow='$Emp_phone_allow',employ_other_allow='$Emp_other_allow',employ_deduct_provident='$Emp_deduct_provident',employ_deduct_tax='$Emp_deduct_tax',employ_other_deduct='$Emp_other_deduct',employ_other_deduct='$Emp_deduct_tax',employee_net_salary='$Emp_net_salary' WHERE curr_date_month='".$date_get."' and employee_id_no like '".$Emp_ID."%'";
								$query             = $this->db->query($SQL_UPDATE_GROSS);
								
								$p_manage_sql="SELECT employ_basic_salary FROM  payroll_manage_salary WHERE employee_id_no like '$Emp_No%'";
							 
								$p_manage_query=$this->db->query($p_manage_sql);
								$p_manage_get_num_rows=$p_manage_query->num_rows;
								if($p_manage_get_num_rows>0)
								{
								
								} else {
									$SQL_INSERT_P_MANAGE  =  "INSERT INTO payroll_manage_salary SET curr_date_month='$date_get',employ_name='$Emp_name',employee_id_no='$Emp_ID',employ_basic_salary='$Emp_basic_salary',employ_house_allow='$Emp_house_allow',employ_medical_allow='$Emp_medical_allow',employ_conveyance='$Emp_conveyance',employ_special_allow='$Emp_special_allow',employ_fuel_allow='$Emp_fuel_allow',employ_phone_allow='$Emp_phone_allow',employ_other_allow='$Emp_other_allow',employ_deduct_provident='$Emp_deduct_provident',employ_deduct_tax='$Emp_deduct_tax',employ_other_deduct='$Emp_other_deduct',employ_other_deduct='$Emp_deduct_tax',employee_net_salary='$Emp_net_salary' WHERE curr_date_month='".$date_get."' and employee_id_no like '".$Emp_ID."%'";
									$query_p_manage  =  $this->db->query($SQL_INSERT_P_MANAGE);
								}
								
								//return $SQL_UPDATE_GROSS;
								$msg="details_update";
						      //  return $msg;
							}
							else
							{
								//return 'not exist';
								$msg="wait_gross";
						     //   return $msg;
							}
								
						}
					
					}
				}
		
		     }
		   return $msg;
		}
		else
		{
			$msg="correct_format";
		    return $msg;
		}
		/*	else if($fname=='NR_PAYROLL_DET')
			{
				
			}*/
			 fclose($handle);
			  
	
				

		
	}
  
}
?>	
