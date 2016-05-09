 <div class="container top">

      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("admin"); ?>">
            <?php echo ucfirst($this->uri->segment(1));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="<?php echo site_url("admin"); ?>">
          <?php echo ucfirst($this->uri->segment(2));?>
           </a> 
        </li>
      </ul>

      <div class="page-header users-header">
        <h2>
          <?php echo ucfirst($this->uri->segment(3));?> 
         
        </h2>
      </div>
      
      <div class="row">
        <div class="span12 columns">
          <div class="well">
            <div class="message_box">
             <?php
      //flash messages
      if($this->session->flashdata('flash_message')){
		  
		 // echo $this->session->flashdata('flash_message');
        if($this->session->flashdata('flash_message') == 'updated')
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Well done!</strong> employee updated with success.';
          echo '</div>';       
        }else if($this->session->flashdata('flash_message') == 'not_updated')
		{
			/*echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>File and Document</strong> are required ';
          	echo '</div>'; */
		}
		else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';
          echo '</div>';          
        }
      }
      ?>
            <?php
            if (isset($success) && strlen($success)) {
                echo '<div class="success">';
                echo '<p>' . $success . '</p>';
                echo '</div>';
            }
 
            if (isset($errors) && strlen($errors)) {
                echo '<div class="error">';
                echo '<p>' . $errors . '</p>';
                echo '</div>';
            }
 
            if (validation_errors()) {
                echo validation_errors('<div class="error">', '</div>');
            }
            ?>
        </div>
        <div>
           <?php  echo validation_errors();
		     $attributes = array('class' => 'form-horizontal','enctype'=>'multipart/form-data', 'id' => 'frm_upld');  ?>
           
          
       <?php /*?>    <?php   echo form_open('admin/dashboard/upload/'.$this->uri->segment(4).'', $attributes);?><?php */?>
                   <!-- <span id='spn_inputs'> 
                        <input type="file" name="myfile"><br>
                        <input type="file" name="myfile1[]"><br>
                        <input type="file" name="myfile2[]"><br>
                    </span>
                    <input type="submit"   value="Upload File(s)">
                </form>-->
                
           <?php     echo form_open('admin/dashboard/upload/'.$this->uri->segment(4).'', $attributes);
      ?>
       
         
          
           <div class="control-group">
            <label for="inputError" class="control-label">Resume</label>
            <div class="controls">
    			<input type="file"  name="myfile[]" value=""  class="form-control" >
    		 </div>
          </div>
          
           <div class="control-group">
            <label for="inputError" class="control-label">Offer Letter</label>
            <div class="controls">
    			<input type="file"  name="myfile[]" value=""  class="form-control" >
    		 </div>
          </div>
          
          
           <div class="control-group">
            <label for="inputError" class="control-label">Joining Letter</label>
            <div class="controls">
    			<input type="file"  name="myfile[]" value=""  class="form-control">
    		 </div>
          </div>
          
           
           <div class="control-group">
            <label for="inputError" class="control-label">Document</label>
            <div class="controls">
    			<input type="file"  name="myfile[]" value=""  class="form-control" >
    		 </div>
          </div>
           
           <div class="control-group">
            <label for="inputError" class="control-label">Photo</label>
            <div class="controls">
    			<input type="file"  name="myfile[]" value=""  class="form-control">
    		 </div>
          </div>
          
          
                <div style="width:100%;">
                
                
                
 <div class="form-actions">
            <button class="btn btn-primary" type="submit" >Save changes</button>
           <!-- <button class="btn" type="reset">Cancel</button>-->
            <a href="<?php echo base_url(); ?>admin/dashboard/"><input type="button" value="Cancel"/> </a>
          </div>

</div>
      <?php echo form_close(); ?>

                
        </div> 




















          
          </div>
         </div>
       </div>
          
 </div>
 <script>

 </script>
 
 