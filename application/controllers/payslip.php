<?php
class Payslip extends CI_Controller {
 
    /**
    * Responsable for auto load the model
    * @return void
    */
	const VIEW_FOLDER = 'admin/payslip';
	 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Payslip_model');
      // $this->load->library("");
	    $this->load->library('MPDF54/mpdf');
		$this->load->library('curl');
		
		$config = Array(
		  'protocol' => 'smtp',
		  'smtp_host' => 'mail.nathanresearch.com',
		  'smtp_port' => 25,
		  'smtp_user' => 'hrms@nathanresearch.com', 
		  'smtp_pass' => 'hrms1@1#', 
		  'mailtype' => 'html',
		  'charset' => 'iso-8859-1',
		  'wordwrap' => TRUE
		);
		$this->load->library('email',$config);
        if(!$this->session->userdata('is_logged_in')){
            redirect('admin/login');
        }
    }
 
    /**
    * Load the main view with all the current model model's data.
    * @return void
    */
    public function index()
    {
        $generate_payslip_button    = $this->input->post('mysubmit'); 
		$re_generate_payslip_button = $this->input->post('regenerate_submit'); 
		
		//for Review post details
		$Review                   = $this->input->post('Review'); 
		$employee_id              = $this->input->post('employee_id');
        //date for view		
		$selected_month_view      = $this->input->post('selected_month_view'); 
		$selected_month_view_to   = $this->input->post('selected_month_view_to'); 
		//date for mail
		$selected_month_mail      = $this->input->post('selected_month_mail'); 
		$selected_month_mail_to   = $this->input->post('selected_month_mail_to'); 
		$month_gen_pay            = $this->input->post('month_gen_pay');
		//for mail send post details
		$sendmail                 = $this->input->post('sendmail'); 
		$mail_employee_id         = $this->input->post('mail_employee_id'); 
		$checkedSelectEmployee    = $this->input->post('optionValue'); 
		$mail_group_employee_id    = $this->input->post('mail_group_employee_id');
		
		
		
        //pagination settings
        $config['per_page']       = 5;
        $config['base_url']       = base_url().'admin/payslip';
        $config['use_page_numbers'] = TRUE;
        $config['num_links']      = 20;
        $config['full_tag_open']  = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open']   = '<li>';
        $config['num_tag_close']  = '</li>';
        $config['cur_tag_open']   = '<li class="active"><a>';
        $config['cur_tag_close']  = '</a></li>';

        //limit end
        if(isset($generate_payslip_button) && $generate_payslip_button=='Generate Payslip')
		{
         	$data['result']=$this->Payslip_model->generate_employee_payslip($month_gen_pay);
			$data['all_employee_details']=$this->Payslip_model->all_get_employee_details($month_gen_pay);
		}
		if(isset($re_generate_payslip_button)&& $re_generate_payslip_button=='Delete for Payslip Regenerate')
		{
			$data['delete_for_regenrate'] =$this->Payslip_model->re_generate_employee_payslip();
		}
		//$data['Review_employee'] =$employee_id;
	   
		if(isset($Review)&& $Review=='Review')
		{
			 $this->form_validation->set_rules('optionValue', 'Employee Name', 'required');
			 $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
				$empl=$checkedSelectEmployee;
				//for($i=0;$i<count($empl);$i++)
				//{
					$this->form_validation->set_rules('designation_id', 'Designation ID', 'required');
					/*$data['start_end_date']    = $this->Payslip_model->current_start_end_date($selected_month_view);
					$data['get_employee_details_value']=$this->Payslip_model->get_employee_details($empl,$selected_month_view);
					$data['data']=$data['get_employee_details_value'];
					$data['selected_date']=$selected_month_view;	*/
					//$data['start_end_date1']    = $this->Payslip_model->current_start_end_date1($selected_month_view,$selected_month_view_to);
					$data['get_employee_details_value1']=$this->Payslip_model->get_employee_details1($empl,$selected_month_view,$selected_month_view_to);
					if($data['get_employee_details_value1']!='empty')
					{
					//$data['Review_employee'] =$this->Payslip_model->select_emp_for_payslip($data['data'],$data['start_end_date']);
					$data['Review_employee'] =$this->Payslip_model->select_emp_for_payslip1($data['get_employee_details_value1']);
					}
					else
					{
					$data['Review_employee'] ='false';
					}
					//$data['test']=$data['get_employee_details_value1'];
					//$data['test1']=$data['get_employee_details_value'][1];
					
			//	}
				
			}
		}
		if(isset($sendmail)&& $sendmail=='Send')
		{
			/*
			$this->form_validation->set_rules('mail_employee_id', 'Employee', 'required');
			 $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
			 $data['selected_date_mail']=$selected_month_mail;	
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
				$data['employee_send']=$mail_employee_id;
				$data['start_end_date']    = $this->Payslip_model->current_start_end_date($selected_month_mail);
				
					if($mail_employee_id!='All')
					{
					$this->form_validation->set_rules('designation_id', 'Designation ID', 'required');
					$data['get_employee_details_value']=$this->Payslip_model->get_employee_details($mail_employee_id,$selected_month_mail);
					$data['data']=$data['get_employee_details_value'][0];
					
						if($data['start_end_date']!=0)
						{
							$data['sendmail_employee'] =$this->Payslip_model->select_emp_for_payslip($data['data'],$data['start_end_date']);
						}
						else
						{
							$data['sendmail_employee'] ="false";
						}
						
					}
					else
					{
							$this->form_validation->set_rules('designation_id', 'Designation ID', 'required');
							$data['all_get_employee_details_value']=$this->Payslip_model->all_get_employee_details($selected_month_mail);
					}
				 
			}	
			*/
			$this->form_validation->set_rules('mail_group_employee_id', 'Employee Name', 'required');
			$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
			 $data['selected_date_mail']=$selected_month_mail;	
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
			//$data['test']=$selected_month_mail;
			$empl_mail=$mail_group_employee_id;
			$data['all_value']=$this->Payslip_model->get_employee_details1($empl_mail,$selected_month_mail,$selected_month_mail_to);
			//$data['test']=$data['all_get_employee_details_value'];
			}
		
		}
	
	// for import file 
		//$import_file                 = $this->input->post('import_file'); $_FILES['myfile']['name']
		$import_file                 = $_FILES['import_file']['name']; 
		$submit_import_file          = $this->input->post('submit_import_file'); 

	    if(isset($import_file)&& $submit_import_file=='Submit Import file')
		{
			//$data['import_file_get'] =$import_file;
			$data['import_file_get']=$this->Payslip_model->import_file_get_details();
		}
		
		
		
		
         $data['get_all_employees'] = $this->Payslip_model->get_all_employees();
	  // $this->pagination->initialize($config);  
        //load the view
		if($this->session->userdata('user_group')=='2' || $this->session->userdata('user_group')=='3') {
			$data['main_content'] = 'employees/payslip/list';
		} else {
			$data['main_content'] = 'admin/payslip/list';
		}
		
		$this->load->view('includes/template', $data);  	
    }//index

  }