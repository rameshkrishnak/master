<?php
class payslip_history extends CI_Controller {
 
    /**
    * Responsable for auto load the model
    * @return void
    */
	const VIEW_FOLDER = 'admin/payslip_history';
	 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Payslip_history_model');
       //  $this->load->model('products_model');
        
        if(!$this->session->userdata('is_logged_in')){
            redirect('admin/login');
        } else if ($this->session->userdata('is_logged_in') && ($this->session->userdata('user_group')=='2' || $this->session->userdata('user_group')=='3')){
            redirect('admin/payslip','refresh');
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
			 
			   		
            $search_string = $this->input->post('search_string'); 			
			//$config['total_rows'] = $data['count_products'];
            //$data['test']=$search_string;
			$data['employee_sal_details'] = $this->Payslip_history_model->get_employee_sal_details($search_string);
			//initializate the panination helper 
			$this->pagination->initialize($config);   
			
			//load the view
			$data['main_content'] = 'admin/payslip_history/list';
			$this->load->view('includes/template', $data);  
				
    }//index

    
   
  

}