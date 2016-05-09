<?php
class payroll_manage extends CI_Controller {
 
    /**
    * Responsable for auto load the model
    * @return void
    */
	const VIEW_FOLDER = 'admin/payroll_manage';
	 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('payroll_manage_model');
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
        $team_profile_id = $this->input->post('team_profile_id');        
        $search_string = $this->input->post('search_string');        
        $order = $this->input->post('order'); 
        $order_type = $this->input->post('order_type'); 

        //pagination settings
        $config['per_page'] = 5;
        $config['base_url'] = base_url().'admin/payroll_manage';
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

        //math to get the initial record to be select in the database
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0){
            $limit_end = 0;
        } 

        //if order type was changed
        if($order_type){
            $filter_session_data['order_type'] = $order_type;
        }
        else{
            //we have something stored in the session? 
            if($this->session->userdata('order_type')){
                $order_type = $this->session->userdata('order_type');    
            }else{
                //if we have nothing inside session, so it's the default "Asc"
                $order_type = 'Asc';    
            }
        }
        //make the data type var avaible to our view
        $data['order_type_selected'] = $order_type;        


        //we must avoid a page reload with the previous session data
        //if any filter post was sent, then it's the first time we load the content
        //in this case we clean the session filter data
        //if any filter post was sent but we are in some page, we must load the session data

        //filtered && || paginated
		$order='salary_id';
        if($search_string !== false && $order !== false){ 
           
            /*
            The comments here are the same for line 79 until 99

            if post is not null, we store it in session data array
            if is null, we use the session data already stored
            we save order into the the var to load the view with the param already selected       
            */

            
           

            if($search_string){
                $filter_session_data['search_string_selected'] = $search_string;
            }else{
                $search_string = $this->session->userdata('search_string_selected');
            }
            $data['search_string_selected'] = $search_string;

            

            //save session data into the session
            $this->session->set_userdata($filter_session_data);

            //fetch manufacturers data into arrays
            

            $data['count_products']= $this->payroll_manage_model->count_payroll_details($search_string, $order);
            $config['total_rows'] = $data['count_products'];

            //fetch sql data into arrays
            if($search_string){
                if($order){
                    $data['employee_sal_details'] = $this->payroll_manage_model->get_employee_sal_details('', $search_string, '', $order_type, $config['per_page'],$limit_end);        
                    $data['employee_sal_details'] = $this->payroll_manage_model->get_employee_sal_details('', $search_string, '', $order_type, $config['per_page'],$limit_end);        
                    $data['employee_sal_details'] = $this->payroll_manage_model->get_employee_sal_details('', $search_string, '', $order_type, $config['per_page'],$limit_end);        
                }else{
                    $data['employee_sal_details'] = $this->payroll_manage_model->get_employee_sal_details('', $search_string, '', $order_type, $config['per_page'],$limit_end);           
                }
            }else{
                if($order){
                    $data['employee_sal_details'] = $this->payroll_manage_model->get_employee_sal_details('', '', $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                    $data['employee_sal_details'] = $this->payroll_manage_model->get_employee_sal_details('', '', '', $order_type, $config['per_page'],$limit_end);        
                }
            }

        }else{

            //clean filter data inside section
            $filter_session_data['manufacture_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['manufacture_selected'] = 0;
            $data['order'] = 'id';

            //fetch sql data into arrays
            $data['edit_payroll_details'] = $this->payroll_manage_model->get_employ_payroll_detail();
          //  $data['count_products']= $this->products_model->count_products();
            $data['employee_sal_details'] = $this->payroll_manage_model->get_employee_sal_details('', '', '', $order_type, $config['per_page'],$limit_end);   
            $data['edit_payroll_details'] = $this->payroll_manage_model->get_employ_payroll_detail();			
            //$config['total_rows'] = $data['count_products'];

        }//!isset($manufacture_id) && !isset($search_string) && !isset($order)

        //initializate the panination helper 
        $this->pagination->initialize($config);   
        
        //load the view
        $data['main_content'] = 'admin/payroll_manage/list';
		$this->load->view('includes/template', $data);  	
    }//index

    public function add()
    {
		$data['groups']          =  $this->payroll_manage_model->select_designation();
		$data['employee_name']   =  $this->payroll_manage_model->select_employee_name();
       
		
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {

            //form validation
            $this->form_validation->set_rules('designation_id', 'Designation ID', 'required');
            $this->form_validation->set_rules('employee_name', 'Employee Name', 'required');
			$this->form_validation->set_rules('employ_type', 'Employee Type', 'required');
            $this->form_validation->set_rules('basic_salary', 'Basic Salary', 'required|numeric');
            $this->form_validation->set_rules('house_rent_allow', 'House Rent Allowance', 'required|numeric');
			$this->form_validation->set_rules('conveyance', 'Conveyance', 'required|numeric');
			$this->form_validation->set_rules('medical_allow', 'Medical Allowance', 'required|numeric');
			//$this->form_validation->set_rules('medical_allow', 'Special Allowance', 'required|numeric');
			//$this->form_validation->set_rules('fuel_allow', 'Fuel Allowance', 'required|numeric');
			//$this->form_validation->set_rules('phone_bill_allow', 'Phone Bill Allowance', 'required|numeric');
			$this->form_validation->set_rules('other_allow', 'Other Allowance', 'required|numeric');
			$this->form_validation->set_rules('provident_fund', 'Provident Fund', 'required|numeric');
			$this->form_validation->set_rules('tax_deduction', 'Tax Deduction', 'required|numeric');
			$this->form_validation->set_rules('other_deduction', 'Other Deduction', 'required|numeric');
			$this->form_validation->set_rules('gross_salary', 'Gross Salary', 'required|numeric');
			$this->form_validation->set_rules('total_deduction', 'Total Deduction', 'required|numeric');
			$this->form_validation->set_rules('net_salary', 'Net Salary', 'required|numeric');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
                $data_to_store = array(
			    	'team_profile_id' => $this->input->post('employee_name'),
                    'employ_design' => $this->input->post('designation_id'),
                    'employ_name' => $this->input->post('employee_name'),
                    'employ_type' => $this->input->post('employ_type'),
                    'employ_basic_salary' => $this->input->post('basic_salary'),          
                    'employ_house_allow' => $this->input->post('house_rent_allow'),
					'employ_medical_allow' => $this->input->post('medical_allow'),
					'employ_conveyance' => $this->input->post('conveyance'),
					'employ_special_allow' => $this->input->post('special_allow'),
					'employ_fuel_allow' => $this->input->post('fuel_allow'),
					'employ_phone_allow' => $this->input->post('phone_bill_allow'),
					'employ_other_allow' => $this->input->post('other_allow'),
					'employ_deduct_provident' => $this->input->post('provident_fund'),
					'employ_deduct_tax' => $this->input->post('tax_deduction'),
					'employ_other_deduct' => $this->input->post('other_deduction'),
					'employ_gross_sal' => $this->input->post('gross_salary'),
					'employ_total_deduct' => $this->input->post('total_deduction'),
					'employee_net_salary' => $this->input->post('net_salary')
					
                );
                //if the insert has returned true then we show the flash message
				$data['test']=$data_to_store;
				$return_result=$this->payroll_manage_model->store_payroll_details($data_to_store);
				if($return_result==true){
                    $data['flash_message'] = TRUE; 
                }else{
                    $data['flash_message'] = FALSE; 
                }
           
            }

        }
        //fetch manufactures data to populate the select field
       // $data['manufactures'] = $this->payroll_manage_model->get_manufacturers();
        //load the view
        $data['main_content'] = 'admin/payroll_manage/add';
        $this->load->view('includes/template', $data);  
    }       

    /**
    * Update item by his id
    * @return void
    */
    public function update()
    {
        //product id 
        $id = $this->uri->segment(4);
         
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form validation
			//$this->form_validation->set_rules('designation_id', 'Designation ID', 'required');
            $this->form_validation->set_rules('employee_name', 'Employee Name', 'required');
			//$this->form_validation->set_rules('employ_type', 'Employee Type', 'required');
            $this->form_validation->set_rules('basic_salary', 'Basic Salary', 'required|numeric');
            $this->form_validation->set_rules('house_rent_allow', 'House Rent Allowance', 'required|numeric');
			$this->form_validation->set_rules('medical_allow', 'Medical Allowance', 'required|numeric');
			//$this->form_validation->set_rules('special_allow', 'Special Allowance', 'required|numeric');
			//$this->form_validation->set_rules('fuel_allow', 'Fuel Allowance', 'required|numeric');
			//$this->form_validation->set_rules('phone_bill_allow', 'Phone Bill Allowance', 'required|numeric');
			$this->form_validation->set_rules('other_allow', 'Other Allowance', 'required|numeric');
			$this->form_validation->set_rules('provident_fund', 'Provident Fund', 'required|numeric');
			$this->form_validation->set_rules('tax_deduction', 'Tax Deduction', 'required|numeric');
			$this->form_validation->set_rules('other_deduction', 'Other Deduction', 'required|numeric');
			$this->form_validation->set_rules('gross_salary', 'Gross Salary', 'required|numeric');
			$this->form_validation->set_rules('total_deduction', 'Total Deduction', 'required|numeric');
			$this->form_validation->set_rules('net_salary', 'Net Salary', 'required|numeric');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
    
                $data_to_store = array(
					//'employ_design' => $this->input->post('designation_id'),
					'team_profile_id' => $this->input->post('employee_name'),
                   // 'employ_type' => $this->input->post('employ_type'),
                    'employ_basic_salary' => $this->input->post('basic_salary'),
                    'employ_house_allow' => $this->input->post('house_rent_allow'),
                    'employ_medical_allow' => $this->input->post('medical_allow'),   
					'employ_conveyance' => $this->input->post('conveyance'),   					
                    'employ_special_allow' => $this->input->post('special_allow'),
					'employ_fuel_allow' => $this->input->post('fuel_allow'),
					'employ_phone_allow' => $this->input->post('phone_bill_allow'),
					'employ_other_allow' => $this->input->post('other_allow'),
					'employ_deduct_provident' => $this->input->post('provident_fund'),
					'employ_deduct_tax' => $this->input->post('tax_deduction'),
					'employ_other_deduct' => $this->input->post('other_deduction'),
					'employ_gross_sal' => $this->input->post('gross_salary'),
					'employ_total_deduct' => $this->input->post('total_deduction'),
					'employee_net_salary' => $this->input->post('net_salary'),
					'employ_id_no' => $this->input->post('employee_id_no')
                );
                //if the insert has returned true then we show the flash message
				
                if($this->payroll_manage_model->update_salary_details($id, $data_to_store) == TRUE){
                    $this->session->set_flashdata('flash_message', 'updated');
                }else{
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
				 // echo base_url();exit;
                //redirect(base_url().'admin/payroll_manage/update/'.$id);
                header('Location:'.base_url().'admin/payroll_manage/update/'.$id);
            }//validation run

        }

        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data
        $data['groups']          =  $this->payroll_manage_model->select_designation();
		$data['employee_name']   =  $this->payroll_manage_model->select_employee_name();
        //product data 
        $data['product'] = $this->payroll_manage_model->get_employee_result($id);
        //fetch manufactures data to populate the select field
       // $data['manufactures'] = $this->payroll_manage_model->get_manufacturers();
        //load the view
        $data['main_content'] = 'admin/payroll_manage/edit';
        $this->load->view('includes/template', $data);            

    }//update

    /**
    * Delete product by his id
    * @return void
    */
    public function delete()
    {
        //product id 
        $id = $this->uri->segment(4);
        $this->payroll_manage_model->delete_payroll($id);
        redirect('admin/payroll_manage');
    }//edit

}