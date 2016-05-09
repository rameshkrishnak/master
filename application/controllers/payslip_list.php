<?php
class payslip_list extends CI_Controller {
 
    /**
    * Responsable for auto load the model
    * @return void
    */
	const VIEW_FOLDER = 'admin/payslip_list';
	 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Payslip_list_model');
       //  $this->load->model('products_model');
        
        if(!$this->session->userdata('is_logged_in')){
            redirect('admin/login');
        } else if ($this->session->userdata('is_logged_in') && ($this->session->userdata('user_group')=='2' || $this->session->userdata('user_group')=='3')){
            redirect('admin/payslip');
        }
    }
 
    /**
    * Load the main view with all the current model model's data.
    * @return void
    */
    public function index()
    {

        //all the posts sent by the view
		    $update              = $this->input->post('update');
			$mysubmit              = $this->input->post('mysubmit');
			 
			if(($update!=false) && ($update=='Update'))
			{
				$team_profile_id     = $this->input->post('team_profile_id');
				$updateValues  =  array(
				//'team_profile_id' => $this->input->post('team_profile_name'),
				'employ_basic_salary'      => $this->input->post('basic_salary'),       
				'employ_house_allow'       => $this->input->post('house_allow'),
				'employ_medical_allow'     => $this->input->post('medical_allow'), 			
				'employ_conveyance'        => $this->input->post('conveyance'), 
				'employ_other_allow'       => $this->input->post('other_allow'), 
				'employ_deduct_tax'        => $this->input->post('deduct_tax'), 
				'employ_deduct_provident'  => $this->input->post('deduct_provident'),
				'employ_gross_sal'         => $this->input->post('gross_sal'), 
				'employ_total_deduct'      => $this->input->post('total_deduct'),
				'employee_net_salary'      => $this->input->post('net_salary')); 
				 
				
				//pagination settings
				$config['per_page'] = 5;
				$config['base_url'] = base_url().'admin/payslip_list';
				$config['use_page_numbers'] = TRUE;
				$config['num_links'] = 20;
				$config['full_tag_open'] = '<ul>';
				$config['full_tag_close'] = '</ul>';
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="active"><a>';
				$config['cur_tag_close'] = '</a></li>';

				//limit end
				$page = $this->uri->segment(3);
				 $data['test']=$updateddata;

					//fetch sql data into arrays
				$return_result=$this->Payslip_list_model->update_payslip_list($team_profile_id,$updateValues);  
				if($return_result==true){
                    $data['flash_message'] = TRUE; 
                }else{
                    $data['flash_message'] = FALSE; 
                }   
			}
          		
            $search_string = $this->input->post('search_string'); 			
			//$config['total_rows'] = $data['count_products'];
            //$data['test']=$search_string;
			$data['employee_sal_details'] = $this->Payslip_list_model->get_employee_sal_details($search_string);
			//initializate the panination helper 
			$this->pagination->initialize($config);   
			
			//load the view
			$data['main_content'] = 'admin/payslip_list/list';
			$this->load->view('includes/template', $data);  
				
    }//index

    
   
  

}