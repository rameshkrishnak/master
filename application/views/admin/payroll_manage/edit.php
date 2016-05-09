    <div class="container top">
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
            <?php echo ucwords(str_replace("_"," ",$this->uri->segment(2)));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">Update</a>
        </li>
      </ul>
      
      <div class="page-header">
        <h2>
          Updating <?php echo ucwords(str_replace("_"," ",$this->uri->segment(2)));?>
        </h2>
      </div>

 
      <?php
      //flash messages
      if($this->session->flashdata('flash_message')){
        if($this->session->flashdata('flash_message') == 'updated')
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Well done!</strong> salary details updated with success.';
          echo '</div>'; 
		 // set_time_limit(1000);
         // redirect('admin/payroll_manage/');			  
        }else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';
          echo '</div>';          
        }
      }
      ?>
      
      <?php
	 // print_r($get_employ_id);
      //form data
      $attributes = array('class' => 'form-horizontal', 'id' => '');
       $designation_list = array('' => "Select");
      foreach ($groups as $row)
      {
        $designation_list[$row['groups_id']] = $row['groups_name'];
      }
   //   echo $product[0]['employ_name'];
	  $employee_list=array('' => "Select");
	 
      
      //form validation
      echo validation_errors();
      $employee_id = $this->uri->segment(4);
	  $employee_id_get=trim($employee_id);
	   foreach($employee_name as $row_name)
	  {
		  $employee_list[$row_name['team_profile_id']]=$row_name['team_profile_full_name'];
		  $employee_list1[$row_name['team_profile_id']]=$row_name['team_profile_employee_id'];
		 
		  
	  }
	 //print_r($employee_list1);
	    $employee_id_no= $employee_list1[$employee_id];
      echo form_open('admin/payroll_manage/update/'.$this->uri->segment(4).'', $attributes);
	 // print_r($product);
	 // if()
      ?>
        <fieldset>
		<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td>
		<input type="hidden" name="employee_name" value="<?php echo $employee_id_get; ?>">
		<input type="hidden" name="employee_id_no" value="<?php echo $employee_id_no; ?>">
		<?php
         /* echo '<div class="control-group">';
            echo '<label for="designation_id" class="control-label">Designation</label>';
            echo '<div class="controls">';
			//print_r($groups);
			//exit;
            echo form_dropdown('designation_id', $designation_list, $product[0]['employ_design'], 'class="span2"');

            echo '</div>';
          echo '</div">';*/
        
          echo '<div class="control-group">';
            echo '<label for="employee_name" class="control-label">Employee Name</label>';
            echo '<div class="controls">';
            echo form_dropdown_default('employee_name', $employee_list,$employee_id_get, 'class="span2"');
            
            echo '</div>';
          echo '</div">';
		
		 
         ?> 
		   
		   
            <!--<div class="control-group">
            <label for="inputError" class="control-label">Employee Type</label>
            <div class="controls">
              <select class="span2" name="employ_type">
			  <option>Select</option>
			  <option value='1' <?php if($product[0]['employ_type']==1) echo 'selected'; else echo ''; ?>>Provision</option>
			  <option value='2' <?php if($product[0]['employ_type']==2) echo 'selected'; else echo ''; ?>>Permanent</option>
			  </select>
            </div>
          </div>-->
                   
          <div class="control-group">
            <label for="inputError" class="control-label">Basic Salary</label>
            <div class="controls">
              <input type="text" id="" name="basic_salary" value="<?php echo $product[0]['employ_basic_salary'] ?>">
              <!--<span class="help-inline">Cost Price</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">House Rent Allowance</label>
            <div class="controls">
              <input type="text" name="house_rent_allow" value="<?php echo $product[0]['employ_house_allow'] ?>">
              <!--<span class="help-inline">OOps</span>-->
            </div>
          </div>
		   <div class="control-group">
            <label for="inputError" class="control-label">Medical Allowance</label>
            <div class="controls">
              <input type="text" name="medical_allow" value="<?php echo $product[0]['employ_medical_allow'] ?>">
              <!--<span class="help-inline">OOps</span>-->
            </div>
          </div>
		  <div class="control-group">
            <label for="inputError" class="control-label">Conveyance</label>
            <div class="controls">
              <input type="text" name="conveyance" value="<?php echo $product[0]['employ_conveyance'] ?>">
              <!--<span class="help-inline">OOps</span>-->
            </div>
          </div>
		  <div class="control-group">
            <label for="inputError" class="control-label">Special Allowance</label>
            <div class="controls">
              <input type="text" name="special_allow" value="<?php echo $product[0]['employ_special_allow'] ?>">
              <!--<span class="help-inline">OOps</span>-->
            </div>
          </div>
		   <div class="control-group">
            <label for="inputError" class="control-label">Fuel Allowance</label>
            <div class="controls">
              <input type="text" name="fuel_allow" value="<?php echo $product[0]['employ_fuel_allow'] ?>">
              <!--<span class="help-inline">OOps</span>-->
            </div>
           </div>
		   <div class="control-group">
            <label for="inputError" class="control-label">Phone Bill Allowance</label>
            <div class="controls">
              <input type="text" name="phone_bill_allow" value="<?php echo $product[0]['employ_phone_allow'] ?>">
              <!--<span class="help-inline">OOps</span>-->
            </div>
           </div>
		   <div class="control-group">
            <label for="inputError" class="control-label">Other Allowance</label>
            <div class="controls">
              <input type="text" name="other_allow" value="<?php echo $product[0]['employ_other_allow'] ?>">
              <!--<span class="help-inline">OOps</span>-->
            </div>
           </div>
          </td><td style="padding-bottom:160px;">
		  <h4 style="margin-left:40px;">Deductions</h4>
		  <div class="control-group" style="margin-top:20px">
            <label for="inputError" class="control-label">Provident Fund</label>
            <div class="controls">
              <input type="text" name="provident_fund" value="<?php echo $product[0]['employ_deduct_provident'] ?>">
              <!--<span class="help-inline">OOps</span>-->
            </div>
           </div>
		   <div class="control-group">
            <label for="inputError" class="control-label">Tax Deduction</label>
            <div class="controls">
              <input type="text" name="tax_deduction" value="<?php echo $product[0]['employ_deduct_tax'] ?>">
              <!--<span class="help-inline">OOps</span>-->
            </div>
           </div>
		   <div class="control-group">
            <label for="inputError" class="control-label">Other Deduction</label>
            <div class="controls">
              <input type="text" name="other_deduction" value="<?php echo $product[0]['employ_other_deduct'] ?>">
              <!--<span class="help-inline">OOps</span>-->
            </div>
           </div>
		    <h4 style="margin-left:40px;">Total salary Details</h4>
			<div class="control-group" style="margin-top:20px">
            <label for="inputError" class="control-label">Gross Salary</label>
            <div class="controls">
              <input type="text" name="gross_salary" value="<?php echo $product[0]['employ_gross_sal'] ?>">
              <!--<span class="help-inline">OOps</span>-->
            </div>
           </div>
		   <div class="control-group">
            <label for="inputError" class="control-label">Total Deduction</label>
            <div class="controls">
              <input type="text" name="total_deduction" value="<?php echo $product[0]['employ_total_deduct'] ?>">
              <!--<span class="help-inline">OOps</span>-->
            </div>
           </div>
		   <div class="control-group">
            <label for="inputError" class="control-label">Net Salary</label>
            <div class="controls">
              <input type="text" name="net_salary" value="<?php echo $product[0]['employee_net_salary'] ?>">
              <!--<span class="help-inline">OOps</span>-->
            </div>
           </div>
		  </td></tr></table>
          <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <button class="btn" type="reset">Cancel</button>
          </div>
        </fieldset>

      <?php echo form_close(); ?>

    </div>
     