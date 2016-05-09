 <div class="container top">

      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("admin").'/'; ?>">
            <?php echo ucfirst($this->uri->segment(1));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <?php echo ucfirst($this->uri->segment(2));?>
        </li>
      </ul>

      <div class="page-header users-header">
        <h2>
          <?php echo ucfirst($this->uri->segment(2));?> 
          <a  href="<?php echo site_url("admin").'/'.$this->uri->segment(2); ?>/add" class="btn btn-success">Add a new</a>
        </h2>
      </div>
      
      <div class="row">
        <div class="span12 columns">
          <div class="well">
           
            <?php
           
            $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform');
           
            $options_groups = array(0 => "all");
            foreach ($groups as $row)
            {
              $options_groups[$row['groups_id']] = $row['groups_name'];
            }
            //save the columns names in a array that we will use as filter         
            //$options_employee = array();    
            //foreach ($employee as $array) {
              //foreach ($array as $key => $value) {
                //$options_employee[$key] = $key;
              //}
              //break;
            //}
			//print_r($options_groups);
          	  echo form_open('admin/dashboard', $attributes);
     
              echo form_label('Search:', 'search_string');
              echo form_input('search_string', $search_string_selected, 'style="width: 170px;
height: 26px;"');

              echo form_label('Filter by Designation:', 'groups_id');
              echo form_dropdown('groups_id', $options_groups, $group_selected, 'class="span2"');

             // echo form_label('Order by:', 'order');
              //echo form_dropdown('order', $options_products, $order, 'class="span2"');

              $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');

             // $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
              //echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span1"');

              echo form_submit($data_submit);

            echo form_close();
            ?>

          </div>

          <table class="table table-striped table-bordered table-condensed">
            <thead>
              <tr>
                <th class="header">#</th>
                <th class="yellow header headerSortDown">Name</th>
                <th class="green header">Designations</th>
                <th class="green header">Jop Type</th>
                <th class="red header">Username</th>
                <th class="red header">Status</th>
                <th class="red header">Phone No</th>
                <th class="red header">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($employee as $row)
              {
                echo '<tr>';
                echo '<td>'.$row['team_profile_id'].'</td>';
                echo '<td>'.$row['team_profile_full_name'].'</td>';
                echo '<td>'.$row['team_profile_job_position_title'].'</td>';
				echo '<td>'.$row['team_profile_job_title'].'</td>';
                echo '<td>'.$row['team_profile_username'].'</td>';
                echo '<td>'.$row['team_profile_status'].'</td>';
                echo '<td>'.$row['manufacture_name'].'</td>';
                echo '<td>
                  <a href="'.site_url("admin").'/dashboard/update/'.$row['team_profile_id'].'" class="btn btn-info">View & Edit</a>  
				  <a href="'.site_url("admin").'/dashboard/upload/'.$row['team_profile_id'].'" class="btn btn-info">Document Upload</a> 
                  <a href="'.site_url("admin").'/dashboard/delete/'.$row['team_profile_id'].'" class="btn btn-danger">Delete</a>
                </td>';
                echo '</tr>';
              }
              ?>      
            </tbody>
          </table>

          <?php echo '<div class="pagination">'.$this->pagination->create_links().'</div>'; ?>

      </div>
    </div>