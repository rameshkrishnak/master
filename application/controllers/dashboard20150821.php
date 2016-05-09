<?php
class Dashboard extends CI_Controller {
 
    /**
    * Responsable for auto load the model
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
        //$this->load->model('products_model');
		 $this->load->model('employee_model');
       // $this->load->model('manufacturers_model');
		$this->load->model('desg_model');
        if(!isset($this->session->userdata('is_logged_in'))){

            redirect('admin/login');
        }

    }
 
    /**
    * Load the main view with all the current model model's data.
    * @return void
    */
    public function index()
    {

        //all the posts sent by the view
        $groups_id = $this->input->post('groups_id');        
         $search_string = $this->input->post('search_string');     
		 $order=$search_string;   
        //$order = $this->input->post('order'); 
        //$order_type = $this->input->post('order_type'); 

        //pagination settings
        $config['per_page'] = 10;
        $config['base_url'] = base_url().'admin/dashboard';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 100;
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
		$order_type='Asc';
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
		
        if($groups_id !== false && $search_string !== false && $order !== false || $this->uri->segment(3) == true){ 
           
            /*
            The comments here are the same for line 79 until 99

            if post is not null, we store it in session data array
            if is null, we use the session data already stored
            we save order into the the var to load the view with the param already selected       
            */

            if($groups_id !== 0){
                $filter_session_data['group_selected'] = $groups_id;
            }else{
                $groups_id = $this->session->userdata('group_selected');
            }
            $data['group_selected'] = $groups_id;

            if($search_string){
                $filter_session_data['search_string_selected'] = $search_string;
            }else{
                $search_string = $this->session->userdata('search_string_selected');
            }
            $data['search_string_selected'] = $search_string;

            if($order){
                $filter_session_data['order'] = $order;
            }
            else{
                $order = $this->session->userdata('order');
            }
            $data['order'] = $order;

            //save session data into the session
            $this->session->set_userdata($filter_session_data);

            //fetch manufacturers data into arrays
            //$data['manufactures'] = $this->manufacturers_model->get_manufacturers();
			$data['groups'] = $this->desg_model->get_groups();
            //$data['count_products']= $this->products_model->count_products($manufacture_id, $search_string, $order);
			$data['count_employee']= $this->employee_model->count_employee($groups_id, $search_string, $order);
			//print_r($data);
			//exit;
            $config['total_rows'] = $data['count_employee'];
     
            //fetch sql data into arrays
            if($search_string){
                if($order){
                    $data['employee'] = $this->employee_model->get_employee($groups_id, $search_string, $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                     $data['employee'] = $this->employee_model->get_employee($groups_id, $search_string, '', $order_type, $config['per_page'],$limit_end);           
                }
            }else{
                if($order){
                     $data['employee'] = $this->employee_model->get_employee($groups_id, '', $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                     $data['employee'] = $this->employee_model->get_employee($groups_id, '', '', $order_type, $config['per_page'],$limit_end);        
                }
            }
			//print_r($data);

        }else{

            //clean filter data inside section
            $filter_session_data['manufacture_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['group_selected'] = 0;
            $data['order'] = 'id';

            //fetch sql data into arrays
            $data['groups'] = $this->desg_model->get_groups();
            $data['count_employee']= $this->employee_model->count_employee();
			
            $data['employee'] = $this->employee_model->get_employee('', '', '', $order_type, $config['per_page'],$limit_end);        
            $config['total_rows'] = $data['count_employee'];
//print_r($data);
        }//!isset($manufacture_id) && !isset($search_string) && !isset($order)

        //initializate the panination helper 
		//print_r($config);
        $this->pagination->initialize($config);   

        //load the view
        $data['main_content'] = 'admin/dashboard/list';
		//print_r($data);
		
        $this->load->view('includes/template', $data);  

    }//index

    public function add()
    {
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {

            //form validation
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required');
            $this->form_validation->set_rules('db_date', 'Date Of Birth', 'required');
            $this->form_validation->set_rules('gender', 'Gender', 'required');
            $this->form_validation->set_rules('phone_no', 'phone No', 'required|numeric');
			$this->form_validation->set_rules('maratial_status','Maratial Status','required');
			$this->form_validation->set_rules('permanent_address','permanent_address','required');
			$this->form_validation->set_rules('local_address','present address','required');
			$this->form_validation->set_rules('state','State','required');
			$this->form_validation->set_rules('city', 'city', 'required');
            $this->form_validation->set_rules('email', 'email', 'required');
			$this->form_validation->set_rules('groups_id','Groups Name','required');
			$this->form_validation->set_rules('job_title', 'Job Title', 'required');
            $this->form_validation->set_rules('join_date', 'Join Date', 'required');
			
           // $this->form_validation->set_rules('offer_letter', 'Offer Letter', 'required');
           // $this->form_validation->set_rules('Joining_letter', 'Joining letter', 'required');
           // $this->form_validation->set_rules('certifation', 'certifation//pervious details', 'required');
			/*$this->form_validation->set_rules('maratial_status','Maratial Status','required');
			$this->form_validation->set_rules('present_address','Present Address','required');
			$this->form_validation->set_rules('local_address','local_address','required');
			$this->form_validation->set_rules('state','State','required');*/
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
				$first_name =$this->input->post('first_name');
				$last_name =$this->input->post('last_name');
				$fullname=$first_name.$last_name;
                $data_to_store = array(
                    'team_profile_full_name' => $fullname,
                    'team_profile_dob' => $this->input->post('db_date'),
                    'team_profile_gender' => $this->input->post('gender'),
                    'team_profile_telephone' => $this->input->post('phone_no'),        
                    'team_profile_maratial_status'=>$this->input->post('maratial_status'),
					'team_profile_present_address'=>$this->input->post('local_address'),
					'team_profile_address'=>$this->input->post('permanent_address'),
					'team_profile_state'=>$this->input->post('state'),
					 'team_profile_city'=>$this->input->post('city'),
					'team_profile_email'=>$this->input->post('email'),
					'team_profile_present_address'=>$this->input->post('local_address'),
					
					'team_profile_groups_id'=>$this->input->post('groups_id'),
					'team_profile_job_position_title'=>$this->input->post('team_profile_job_position_title'),
					'team_profile_job_title'=>$this->input->post('job_title'),
					'team_profile_join_date'=>$this->input->post('join_date'),
					
					
					);
                //if the insert has returned true then we show the flash message
				//print_r($data_to_store);
				//exit;
                if($this->employee_model->store_employee($data_to_store)){
                    $data['flash_message'] = TRUE; 
					
                }else{
                    $data['flash_message'] = FALSE; 
                }

            }

        }
        //fetch manufactures data to populate the select field
      	$data['groups'] = $this->desg_model->get_designation();
        //load the view
        $data['main_content'] = 'admin/dashboard/add';
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
  //echo $id ;
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form validation
            $this->form_validation->set_rules('team_profile_full_name', 'Name', 'required');
            $this->form_validation->set_rules('groups_id', 'Designation', 'required');
            $this->form_validation->set_rules('team_profile_username', 'Username', 'required');
            $this->form_validation->set_rules('status', 'status', 'required');
            //$this->form_validation->set_rules('team_profile_telephone', 'Phone NO', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
    
                $data_to_store = array(
                    'team_profile_full_name' => $this->input->post('team_profile_full_name'),
                    'team_profile_groups_id' => $this->input->post('groups_id'),
                    'team_profile_username' => $this->input->post('team_profile_username'),
                    'team_profile_status' => $this->input->post('status'),          
                    'team_profile_telephone' => $this->input->post('team_profile_telephone'),
					'team_profile_city' => $this->input->post('city'),
                    'team_profile_state' => $this->input->post('state'),
                    'team_profile_email' => $this->input->post('email'),
                    'team_profile_gender' => $this->input->post('gender'),          
                    'team_profile_maratial_status' => $this->input->post('maratial_status'),
					'team_profile_address' => $this->input->post('permanent_address'),
                    'team_profile_present_address' => $this->input->post('local_address'),
					'team_profile_job_position_title'=>$this->input->post('team_profile_job_position_title'),
                    'team_profile_job_title' => $this->input->post('job_title'),
                    'team_profile_join_date' => $this->input->post('join_date')          
                    
                );
				//print_r( $data_to_store);
				//exit;
                //if the insert has returned true then we show the flash message
                if($this->employee_model->update_employee($id, $data_to_store) == TRUE){
                   $this->session->set_flashdata('flash_message', 'updated');
                }else{
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
                redirect('admin/dashboard/update/'.$id.'');

            }//validation run

        }

        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data

        //product data 
        $data['employee_id'] = $this->employee_model->get_employee_by_id($id);
        //fetch manufactures data to populate the select field
        //$data['employee_details'] = $this->manufacturers_model->get_manufacturers();
		
		$data['employee_details'] = $this->employee_model->get_employee_update($id);   
		//print_r($data);
		$data['employee_designation']= $this->desg_model->get_designation();
        //load the view
		//print_r($data['employee_designation']);
        $data['main_content'] = 'admin/dashboard/edit';
		//print_r($data);
        $this->load->view('includes/template', $data);            

    }//update

    /**
    * Delete product by his id
    * @return void
    */
	
	
	
	  
    public function upload()
    {
        //product id 
        $id = $this->uri->segment(4);
	if(isset($_FILES['myfile']['name']))
	{
		$get=array_filter($_FILES['myfile']['name']);
		
	}
		//print_r($_FILES['myfile']['name']);
		if(!empty($get))
		{
			$this->employee_model->do_upload($id);
			
		}else
		{ 
		$this->session->set_flashdata('flash_message', 'not_updated');
		
				/*$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size']    = '100';
					$config['max_width']  = '1024';
					$config['max_height']  = '768';
					
					// You can give video formats if you want to upload any video file.
					
					$this->load->library('upload', $config);
						if ( ! $this->employee_model->do_upload($id))
						{
								$this->session->set_flashdata('flash_message', 'not_updated');
						}
						else
						{
							$this->employee_model->do_upload($id);
						
					
						}*/
		
			
		}
		
		
           
	 	$data['main_content'] = 'admin/dashboard/upload';
        $this->load->view('includes/template', $data);  
		
		
		
		
		
		
		
		
		
		
		
		
	}
    public function delete()
    {
        //product id 
        $id = $this->uri->segment(4);
        $this->employee_model->delete_employee($id);
        redirect('admin/dashboard');
    }//edit

}