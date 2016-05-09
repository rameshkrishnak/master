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
          Adding <?php echo ucfirst('Empolyee');?>
        </h2>
      </div>
 
      <?php
      //flash messages
      if(isset($flash_message)){
        if($flash_message == TRUE)
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong></strong> new employee created with success.';
          echo '</div>';       
        }else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong></strong> change a few things up and try submitting again.';
          echo '</div>';          
        }
      }
      ?>
      
      <?php
      //form data
      $attributes = array('class' => 'form-horizontal', 'id' => '','enctype'=>'multipart/form-data');
      $options_groups = array(0 => "select");
            foreach ($groups as $row)
            {
              $options_groups[$row['groups_id']] = $row['groups_name'];
            }
      //form validation
      echo validation_errors();
      
      echo form_open('admin/dashboard/add', $attributes);
      ?>
      <div style="width:50%;float:left;height: 358px;">
        <fieldset>
        <legend>Personal Information </legend>
          <div class="control-group">
            <label for="inputError" class="control-label">First Name</label>
            <div class="controls">
              <input type="text" id="" name="first_name" value="<?php echo set_value('first_name');  ?>" >
            <?php /*?> <?php echo '<div class="div">'. form_error('first_name').'</div>';?><?php */?>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Last Name</label>
            <div class="controls">
              <input type="text" id="" name="last_name" value="<?php echo set_value('last_name'); ?>">
              <!--<span class="help-inline">Cost Price</span>-->
            </div>
          </div>          
          <div class="control-group">
            <label for="inputError" class="control-label">Date of Birth</label>
            <div class="controls">
              <input type="datetime" id="db_date" class="db_date" name="db_date" value="<?php echo set_value('dob_date'); ?>" >
              <!--<span class="help-inline">Cost Price</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Gender</label>
            <div class="controls">
              
              <select name="gender" class="form-control" >
                            <option value="">Select Gender ...</option>
                            <option value="Male" >Male</option>
                            <option value="Female" >Female</option>
                        </select>
              <!--<span class="help-inline">OOps</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Phone No</label>
            <div class="controls">
              <input type="text" name="phone_no" value="<?php echo set_value('phone_no'); ?>"  >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
         <div class="control-group">
            <label for="inputError" class="control-label">Maratial Status</label>
            <div class="controls">
              <select name="maratial_status" class="form-control" >
                            <option value="">Select Status ...</option>
                            <option value="Married" >Married</option>
                            <option value="Un-Married" >Un-Married</option>
                            <option value="Widowed" >Widowed</option>
                            <option value="Divorced" >Divorced</option>
                        </select>
            </div>
          </div>
          
        </fieldset>
</div>
<div style="float:left;width:50%; height: 358px;">
<fieldset>
	<legend>Contact Details </legend>
    <div class="control-group">
            <label for="inputError" class="control-label">Permanent Address</label>
            <div class="controls">
              <textarea id="permanent_address" name="permanent_address"  class="form-control" ></textarea>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
     <div class="control-group">
            <label for="inputError" class="control-label">Local Address</label>
            <div class="controls">
              <textarea id="local_address" name="local_address" class="form-control" ></textarea>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">City</label>
            <div class="controls">
              <input type="text" name="city" value="<?php echo set_value('city'); ?>" class="form-control" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">state</label>
            <div class="controls">
              <input type="text" name="state" value="" class="form-control" value="<?php echo set_value('state'); ?>">
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Email ID</label>
            <div class="controls">
    			<input type="email"  name="email" value="<?php echo set_value('email'); ?>"  class="form-control">
    		 </div>
          </div>
    </fieldset>

</div>

<div style="width:50%;float:left;min-height:365px;">
<fieldset>

<legend>official status</legend>
<div class="control-group">
            <label for="inputError" class="control-label">Desiganation</label>
            <div class="controls">
    			<?php
                // echo form_label('Desiganation:', 'groups_id');
				 $group_selected='';
             	 echo form_dropdown('groups_id', $options_groups, $group_selected,'class="group_id"');
                
                ?>
                    <input type="hidden" id="team_profile_job_position_title" name="team_profile_job_position_title" value="">
    		 </div>
          </div>
          
           <div class="control-group">
            <label for="inputError" class="control-label">Jop Type</label>
            <div class="controls">
               <select name="job_title" class="form-control" >
                            <option value="">Select Title ...</option>
                            <option value="fulltime" >Full Time</option>
                            <option value="parttime" >Part Time</option>
                            <option value="dataentry" >Data Entry </option>
                            <option value="internship" >Internship</option>
                        </select>
              
              
            </div>
          </div>   
           <div class="control-group">
            <label for="inputError" class="control-label">Joining Date</label>
            <div class="controls">
              <input type="datetime" class="join_date" name="join_date"  value="<?php echo set_value('join_date'); ?>">
              <!--<span class="help-inline">Cost Price</span>-->
            </div>
          </div>   
          
          
</fieldset>

</div>
<div style="width:50%;float:left;min-height:365px;">
 </div>
<div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
          <!--  <button class="btn" type="reset">Cancel</button>-->
             <a href="<?php echo base_url(); ?>admin/dashboard/"><input type="button" value="Cancel"/> </a>
          </div>

      <?php echo form_close(); ?>

    </div>
     

     
     <script type="application/javascript">
	
	 </script>