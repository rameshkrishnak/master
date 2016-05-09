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
        $generate_payslip_button = $this->input->post('mysubmit'); 
		$re_generate_payslip_button = $this->input->post('regenerate_submit'); 
		
		//for Review post details
		$Review = $this->input->post('Review'); 
		$employee_id = $this->input->post('employee_id'); 
		
		//for mail send post details
		$sendmail = $this->input->post('sendmail'); 
		$mail_employee_id=$this->input->post('mail_employee_id'); 
        //pagination settings
        $config['per_page'] = 5;
        $config['base_url'] = base_url().'admin/payslip';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        //limit end
        if(isset($generate_payslip_button) && $generate_payslip_button=='Generate Payslip')
		{
         	$data['result']=$this->Payslip_model->generate_employee_payslip();
			$data['all_employee_details']=$this->Payslip_model->all_get_employee_details();
		}
		if(isset($re_generate_payslip_button)&& $re_generate_payslip_button=='Delete for Payslip Regenerate')
		{
			$data['delete_for_regenrate'] =$this->Payslip_model->re_generate_employee_payslip();
		}
		//$data['Review_employee'] =$employee_id;
	   
		if(isset($Review)&& $Review=='Review')
		{
			 $this->form_validation->set_rules('employee_id', 'Employee Name', 'required');
			 $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
				$this->form_validation->set_rules('designation_id', 'Designation ID', 'required');
				$data['start_end_date']    = $this->Payslip_model->current_start_end_date();
				$data['get_employee_details_value']=$this->Payslip_model->get_employee_details($employee_id);
				$data['data']=$data['get_employee_details_value'][0];
				$data['Review_employee'] =$this->Payslip_model->select_emp_for_payslip($data['data'],$data['start_end_date']);
			}
		}
		if(isset($sendmail)&& $sendmail=='Send')
		{
			$this->form_validation->set_rules('mail_employee_id', 'Employee', 'required');
			 $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
				$data['employee_send']=$mail_employee_id;
				if($mail_employee_id!='All')
				{
				$data['start_end_date']    = $this->Payslip_model->current_start_end_date();
				$this->form_validation->set_rules('designation_id', 'Designation ID', 'required');
				$data['get_employee_details_value']=$this->Payslip_model->get_employee_details($mail_employee_id);
				$data['data']=$data['get_employee_details_value'][0];
				$data['sendmail_employee'] =$this->Payslip_model->select_emp_for_payslip($data['data'],$data['start_end_date']);
				}
				else
				{
				$this->form_validation->set_rules('designation_id', 'Designation ID', 'required');
				$data['all_get_employee_details_value']=$this->Payslip_model->all_get_employee_details($mail_employee_id);
				}
			}	
		}
		
		
         $data['get_all_employees'] = $this->Payslip_model->get_all_employees();
	  // $this->pagination->initialize($config);  
        //load the view
        $data['main_content'] = 'admin/payslip/list';
		$this->load->view('includes/template', $data);  	
    }//index

  }