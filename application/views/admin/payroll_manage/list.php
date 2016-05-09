    <div class="container top">
    
      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("admin"); ?>">
            <?php echo ucfirst($this->uri->segment(1)); ?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <?php echo ucwords(str_replace("_"," ",$this->uri->segment(2)));?>
        </li>
      </ul>

      <div class="page-header users-header">
       <h2>
          <?php echo ucwords(str_replace("_"," ",$this->uri->segment(2)));?> 
         
        </h2> <!-- <a  href="<?php echo site_url("admin").'/'.$this->uri->segment(2); ?>/add" class="btn btn-success">Add a new</a>  -->
      </div>
      
      <div class="row">
        <div class="span12 columns">
          <div class="well">
           
            <?php
           $order=array();
            $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform');
           
           
            //save the columns names in a array that we will use as filter         
            $options_sal_details = array();    
            foreach ($employee_sal_details as $array) {
              foreach ($array as $key => $value) {
                $options_sal_details[$key] = $key;
              }
              break;
            }
             // print_r($employee_sal_details);
              echo form_open('admin/payroll_manage', $attributes);
     
              echo form_label('Search:', 'search_string');
              echo form_input('search_string', $search_string_selected);

             

             // echo form_label('Order by:', 'order');
             // echo form_dropdown('order', $options_sal_details, $order, 'class="span2"');
              

              
              echo '&nbsp;';
              $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
              echo form_dropdown('order_type', $options_order_type, $order_type_selected);
			  echo '&nbsp;';
              $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');
              echo form_submit($data_submit);

            echo form_close();
			//print_r($test);
            ?>

          </div>

          <table class="table table-striped table-bordered table-condensed">
            <thead>
              <tr>
                <th class="header">#</th>
                <th class="yellow header headerSortDown">Employee Designation</th>
                <th class="green header">Employee Name</th>
                <!--<th class="red header">Employee Type</th>-->
                <th class="red header">Employee Email</th>
                <th class="red header">Employee Telephone</th>
                <th class="red header">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
			 // print_r($employee_sal_details);
              foreach($employee_sal_details as $row)
              {
                echo '<tr>';
                echo '<td>'.$row['team_profile_id'].'</td>';
				echo '<td>'.$row['team_profile_job_position_title'].'</td>';
                echo '<td>'.$row['team_profile_full_name'].'</td>';
				/*echo '<td>'.$row['team_profile_job_title'].'</td>';*/
                echo '<td>'.$row['team_profile_email'].'</td>';
                echo '<td>'.$row['team_profile_telephone'].'</td>';
                
                echo '<td class="crud-actions">
                  <a href="'.site_url("admin").'/payroll_manage/update/'.$row['team_profile_id'].'" class="btn btn-info">view & edit</a>  
                  <a href="'.site_url("admin").'/payroll_manage/delete/'.$row['team_profile_id'].'" class="btn btn-danger">delete</a>
                </td>';
                echo '</tr>';
              }
              ?>      
            </tbody>
          </table>

          <?php echo '<div class="pagination">'.$this->pagination->create_links().'</div>'; ?>

      </div>
    </div>