    <div class="container top">
      
      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("admin"); ?>">
            <?php echo ucfirst($this->uri->segment(1));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li>
          <a href="<?php echo site_url("admin").'/'.$this->uri->segment(2); ?>">
            <?php echo ucfirst($this->uri->segment(2));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">Update</a>
        </li>
      </ul>
      
      <div class="page-header">
        <h2>
          Updating <?php echo ucfirst($this->uri->segment(2));?>
        </h2>
      </div>

 
      <?php
      //flash messages
      if($this->session->flashdata('flash_message')){
        if($this->session->flashdata('flash_message') == 'updated')
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Well done!</strong> employee updated with success.';
          echo '</div>';       
        }else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';
          echo '</div>';          
        }
      }
      ?>
      
      <?php
      //form data
	 // print_r($data);
      $attributes = array('class' => 'form-horizontal', 'id' => '');
      $options_manufacture = array('' => "Select");
      foreach ($employee_designation as $row)
      {
        $options_manufacture[$row['groups_id']] = $row['groups_name'];
      }

      //form validation
      echo validation_errors();
//print_r($employee_details);
      echo form_open('admin/dashboard/update/'.$this->uri->segment(4).'', $attributes);
      ?>
        <div style="width:50%;float:left;height: 450px;">
        <fieldset>
        <legend>Employee Dedails</legend>
          <div class="control-group">
            <label for="inputError" class="control-label">Name</label>
            <div class="controls">
              <input type="text" id="" name="team_profile_full_name" value="<?php echo $employee_details[0]['team_profile_full_name']; ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <!--<div class="control-group">
            <label for="inputError" class="control-label">Designation</label>
            <div class="controls">
              <input type="text" id="" name="stock" value="<?php /*?><?php echo $employee_details[0]['team_profile_job_position_title']; ?><?php */?>">
              <!--<span class="help-inline">Cost Price</span>
            </div>
          </div>  --> 
         <?php
          echo '<div class="control-group">';
            echo '<label for="inputError" class="control-label">Designation</label>';
            echo '<div class="controls">';
              //echo form_dropdown('manufacture_id', $options_manufacture, '', 'class="span2"');
              
              echo form_dropdown('groups_id', $options_manufacture, $employee_designation[0]['groups_name'],'class="group_id"');

            echo '</div>';//manufacture_name
          echo '</div"><br/>';
          ?>
         <input type="hidden" id="team_profile_job_position_title" name="team_profile_job_position_title" value="<?php echo $employee_details[0]['team_profile_job_position_title'];?>">
         
          <div class="control-group">
            <label for="inputError" class="control-label">Username</label>
            <div class="controls">
              <input type="text" id="" name="team_profile_username" value="<?php echo $employee_details[0]['team_profile_username'];?>">
              <!--<span class="help-inline">Cost Price</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Status</label>
            <div class="controls">
            
            
            <?php 
				$status=	$employee_details[0]['team_profile_status']; 
				$options = array('Active' => 'Active', 'Inactive' => 'Inactive');
				echo form_dropdown('status', $options, $status);
		
			?>
              <!--<span class="help-inline">OOps</span>-->
            </div>
          </div>
        
          
          <div class="control-group">
            <label for="inputError" class="control-label">Phone No</label>
            <div class="controls">
              <input type="text" name="team_profile_telephone" value="<?php echo $employee_details[0]['team_profile_telephone']; ?>">
              <!--<span class="help-inline">OOps</span>-->
            </div>
          </div>
           <div class="control-group">
            <label for="inputError" class="control-label">City</label>
            <div class="controls">
              <input type="text" name="city" value="<?php echo $employee_details[0]['team_profile_city']; ?>" class="form-control" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
         
          <div class="control-group">
            <label for="inputError" class="control-label">Email ID</label>
            <div class="controls">
    			<input type="email"  name="email" value="<?php echo $employee_details[0]['team_profile_email']; ?>"  class="form-control">
    		 </div>
          </div>
        </fieldset>
</div>
<div style="width:50%;float:left;height: 450px;">
 <fieldset>
 <legend></legend>
  <div class="control-group">
            <label for="inputError" class="control-label">state</label>
            <div class="controls">
              <input type="text" name="state" value="" class="form-control" value="<?php echo $employee_details[0]['team_profile_state']; ?>">
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
 <div class="control-group">

            <label for="inputError" class="control-label">Gender</label>
            <div class="controls">
              
               
            <?php 
				$status=	$employee_details[0]['team_profile_gender']; 
				$options = array(''=>'Select','Male' => 'Male', 'Female' => 'Female');
				echo form_dropdown('gender', $options, $status);
		
			?>
             
              <!--<span class="help-inline">OOps</span>-->
            </div>
          </div>
   
         <div class="control-group">
            <label for="inputError" class="control-label">Maratial Status</label>
            <div class="controls">
            
                
            <?php 
				$status=	$employee_details[0]['team_profile_maratial_status']; 
				$options = array(''=>'Select','Married' => 'Married', 'Un-Married' => 'Un-Married', 'Widowed' => 'Widowed', 'Divorced' => 'Divorced');
				echo form_dropdown('maratial_status', $options, $status);
		
			?>
            
            
       
            </div>
          </div>
           <div class="control-group">
            <label for="inputError" class="control-label">Permanent Address</label>
            <div class="controls">
              <textarea id="permanent_address" name="permanent_address"  class="form-control" ><?php echo $employee_details[0]['team_profile_address']; ?></textarea>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
     <div class="control-group">
            <label for="inputError" class="control-label">Local Address</label>
            <div class="controls">
              <textarea id="local_address" name="local_address" class="form-control" ><?php echo $employee_details[0]['team_profile_present_address']; ?></textarea>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
        
          
           <div class="control-group">
            <label for="inputError" class="control-label">Jop Title</label>
            <div class="controls">
            
                 
            <?php 
				$status=	$employee_details[0]['team_profile_job_title']; 
				$options = array(''=>'Select','fulltime' => 'fulltime', 'parttime' => 'parttime', 'dataentry' => 'dataentry', 'internship' => 'internship');
				echo form_dropdown('job_title', $options, $status);
		
			?>
            </div>
          </div>   
           <div class="control-group">
            <label for="inputError" class="control-label">Joining Date</label>
            <div class="controls">
              <input type="datetime" class="join_date" name="join_date"  value="<?php echo $employee_details[0]['team_profile_join_date']; ?>">
              <!--<span class="help-inline">Cost Price</span>-->
            </div>
          </div>   

</fieldset>

</div>
<div style="width:100%;">
 <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
           <a href="<?php echo base_url(); ?>admin/dashboard/"><input type="button" value="Cancel"/> </a>
          </div>

</div>
      <?php echo form_close(); ?>

    </div>
     