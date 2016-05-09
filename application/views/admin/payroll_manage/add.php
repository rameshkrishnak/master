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
          <a href="#">New</a>
        </li>
      </ul>
      
      <div class="page-header">
        <h2>
          Adding <?php echo ucfirst($this->uri->segment(2));?>
        </h2>
      </div>
 
      <?php
      //flash messages
      if(isset($flash_message)){
        if($flash_message == TRUE)
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Well done!</strong>salary details created with success.';
          echo '</div>'; 
           	  
        }else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Oh snap!</strong> change a few things up and try submitting again or the employee already exist.';
          echo '</div>';          
        }
      }
      ?>
      
      <?php
      //form data
      $attributes = array('class' => 'form-horizontal', 'id' => '');
      $designation_list = array('' => "Select");
      foreach ($groups as $row)
      {
        $designation_list[$row['groups_id']] = $row['groups_name'];
      }
      
	  $employee_list=array('' => "Select");
	  foreach($employee_name as $row_name)
	  {
		  $employee_list[$row_name['team_profile_id']]=$row_name['team_profile_full_name'];
	  }
      //form validation
      echo validation_errors();
      
      echo form_open('admin/payroll_manage/add', $attributes);
      ?>
        <fieldset>
		<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td>
		<?php
          echo '<div class="control-group">';
            echo '<label for="designation_id" class="control-label">Employee Designation</label>';
            echo '<div class="controls">';
			//print_r($groups);
			//exit;
            echo form_dropdown('designation_id', $designation_list, set_value('groups'), 'class="span2"');

            echo '<span style="color:red; bottom:16px; position:relative"> *</span></div>';
          echo '</div">';
         
          echo '<div class="control-group">';
            echo '<label for="employee_name" class="control-label">Employee Name</label>';
            echo '<div class="controls">';
            echo form_dropdown('employee_name', $employee_list, set_value('employee_name'), 'class="span2"');

            echo '<span style="color:red; bottom:16px; position:relative"> *</span></div>';
          echo '</div">';
         ?> 
            <div class="control-group">
            <label for="inputError" class="control-label">Employee Type</label>
            <div class="controls">
              <select class="span2" name="employ_type">
			  <option>Select</option>
			  <option value='1'>Provision</option>
			  <option value='2'>Permanent</option>
			  </select>
			  <span style="color:red; bottom:6px; position:relative"> *</span>
            </div>
          </div>
                   
          <div class="control-group">
            <label for="inputError" class="control-label">Basic Salary</label>
            <div class="controls">
              <input type="text" id="" name="basic_salary" value="<?php echo set_value('basic_salary'); ?>">
             <span style="color:red; bottom:6px; position:relative"> *</span>
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">House Rent Allowance</label>
            <div class="controls">
              <input type="text" name="house_rent_allow" value="<?php echo set_value('house_rent_allow'); ?>">
              <span style="color:red; bottom:6px; position:relative"> *</span>
            </div>
          </div>
		   <div class="control-group">
            <label for="inputError" class="control-label">Medical Allowance</label>
            <div class="controls">
              <input type="text" name="medical_allow" value="<?php echo set_value('medical_allow'); ?>">
              <span style="color:red; bottom:6px; position:relative"> *</span>
            </div>
          </div>
		   <div class="control-group">
            <label for="inputError" class="control-label">Conveyance</label>
            <div class="controls">
              <input type="text" name="conveyance" value="<?php echo set_value('conveyance'); ?>">
              <span style="color:red; bottom:6px; position:relative"> *</span>
            </div>
          </div>
		  <div class="control-group">
            <label for="inputError" class="control-label">Special Allowance</label>
            <div class="controls">
              <input type="text" name="special_allow" value="<?php echo set_value('special_allow'); ?>">
              <!--<span class="help-inline">OOps</span>-->
            </div>
          </div>
		   <div class="control-group">
            <label for="inputError" class="control-label">Fuel Allowance</label>
            <div class="controls">
              <input type="text" name="fuel_allow" value="<?php echo set_value('fuel_allow'); ?>">
              <!--<span class="help-inline">OOps</span>-->
            </div>
           </div>
		   <div class="control-group">
            <label for="inputError" class="control-label">Phone Bill Allowance</label>
            <div class="controls">
              <input type="text" name="phone_bill_allow" value="<?php echo set_value('phone_bill_allow'); ?>">
              <!--<span class="help-inline">OOps</span>-->
            </div>
           </div>
		   <div class="control-group">
            <label for="inputError" class="control-label">Other Allowance</label>
            <div class="controls">
              <input type="text" name="other_allow" value="<?php echo set_value('other_allow'); ?>">
              <span style="color:red; bottom:6px; position:relative"> *</span>
            </div>
           </div>
		   
		   </td><td style="padding-bottom:160px;">
		   
          <div class="control-group">
		  <h4 style="margin-left:40px;">Deductions</h4>
		  <div class="control-group" style="margin-top:20px">
            <label for="inputError" class="control-label">Provident Fund</label>
            <div class="controls">
              <input type="text" name="provident_fund" value="<?php echo set_value('provident_fund'); ?>">
              <span style="color:red; bottom:6px; position:relative"> *</span>
            </div>
           </div>
		   <div class="control-group">
            <label for="inputError" class="control-label">Tax Deduction</label>
            <div class="controls">
              <input type="text" name="tax_deduction" value="<?php echo set_value('tax_deduction'); ?>">
              <span style="color:red; bottom:6px; position:relative"> *</span>
            </div>
           </div>
		   <div class="control-group">
            <label for="inputError" class="control-label">Other Deduction</label>
            <div class="controls">
              <input type="text" name="other_deduction" value="<?php echo set_value('other_deduction'); ?>">
              <span style="color:red; bottom:6px; position:relative"> *</span>
            </div>
           </div>
		    <h4 style="margin-left:40px">Total salary Details</h4>
			<div class="control-group" style="margin-top:20px">
            <label for="inputError" class="control-label">Gross Salary</label>
            <div class="controls">
              <input type="text" name="gross_salary" value="<?php echo set_value('gross_salary'); ?>">
              <span style="color:red; bottom:6px; position:relative"> *</span>
            </div>
           </div>
		   <div class="control-group">
            <label for="inputError" class="control-label">Total Deduction</label>
            <div class="controls">
              <input type="text" name="total_deduction" value="<?php echo set_value('total_deduction'); ?>">
              <span style="color:red; bottom:6px; position:relative"> *</span>
            </div>
           </div>
		   <div class="control-group">
            <label for="inputError" class="control-label">Net Salary</label>
            <div class="controls">
              <input type="text" name="net_salary" value="<?php echo set_value('net_salary'); ?>">
              <span style="color:red; bottom:6px; position:relative"> *</span>
            </div>
           </div>
		   </td></tr></table>
          <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <button class="btn" type="reset">Cancel</button>
          </div>
		  </div>
        </fieldset>

      <?php echo form_close(); ?>

    </div>
     