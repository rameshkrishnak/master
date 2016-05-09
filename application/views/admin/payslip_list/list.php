    <div class="container top">
    <style>
	.span1
	{
		margin-bottom:20px !important;
	}
	[draggable=true]
	{
    cursor: move;
    }
	.resizable 
	{
    //overflow-x: scroll;
    resize: both;
    max-width: 100%;
    max-height: auto;
	}
	
	tr.style:nth-of-type(odd) {
      background-color:#ccc;
	}
	tr.style:nth-of-type(even) {
      background-color:#E6E6E6;
	}
	
	</style>
	<script>
	function update(a)
	{
		
		var test=$(this).val();
		alert(test);
		return false;
	}
	$(document).ready(function() {

  alert ('Hello World');
	
});
	</script>
      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("admin"); ?>">
            <?php echo ucwords(str_replace("_"," ",$this->uri->segment(2))); ?>
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
			  //flash messages
			  if($flash_message!=''){
				if($flash_message == 1)
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
              echo form_open('admin/payslip_list', $attributes);
     
              echo form_label('Search:', 'search_string');
              echo form_input('search_string', $search_string_selected, 'style="width: 170px;
height: 26px;"');

             

             // echo form_label('Order by:', 'order');
             // echo form_dropdown('order', $options_sal_details, $order, 'class="span2"');
              

              
              echo '&nbsp;';
             // $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
             // echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span1"');
			  echo '&nbsp;';
              $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');
              echo form_submit($data_submit);

            echo form_close();
			//print_r($test);
            ?>

          </div>
          <div class="resizable">
          <table class="table table-striped table-bordered table-condensed">
            <thead>
              <tr>
                <!--<th class="header">#</th>-->
               <!-- <th class="yellow header headerSortDown">Employee Designation</th>-->
                <th class="green header">Name</th>
                <!--<th class="red header">Employee Type</th>-->
 <th class="red header" >Date</th>
                <th class="red header" >BS</th>
                <th class="red header">HRA</th>
				<th class="red header">MA</th>
				<th class="red header">CA</th>
				<th class="red header">OA</th>
				<th class="red header">IT</th>
				<th class="red header">PF</th>
				<th class="red header">GS</th>
				<th class="red header">TD</th>
				<th class="red header">NS</th>
                <th class="red header">Actions</th>
              </tr>
            </thead>
            <tbody>
			
              <?php
			 // print_r($employee_sal_details);
			 $i=1;
              foreach($employee_sal_details as $row)
              {
				$attributes2 = array('class' => 'form-inline reset-margin', 'id' => 'myform3');
				echo form_open('admin/payslip_list', $attributes2);
                echo '<tr class="style"><input type="hidden" class="" style="width:60px;" name="team_profile_id" value="'.$row['team_profile_id'].'">';
                echo '<td><input type="text" class="" readonly style="width:140px;" name="team_profile_name" value="'.$row['team_profile_full_name'].'"></td>';
echo '<td><input type="text" class="" readonly style="width:70px;" name="team_profile_name" value="'.$row['curr_date_month'].'"></td>';
				echo '<td><input type="text" style="width:60px" name="basic_salary" value="'.$row['employ_basic_salary'].'"></td>';
                echo '<td><input type="text" style="width:60px" name="house_allow" value="'.$row['employ_house_allow'].'"></td>';
				/*echo '<td>'.$row['team_profile_job_title'].'</td>';*/
                echo '<td><input type="text" style="width:60px" name="medical_allow" value="'.$row['employ_medical_allow'].'"></td>';
                echo '<td><input type="text" style="width:60px" name="conveyance" value="'.$row['employ_conveyance'].'"></td>';
				 echo '<td><input type="text" style="width:60px" name="other_allow" value="'.$row['employ_other_allow'].'"></td>';
				echo '<td><input type="text" style="width:60px" name="deduct_tax" value="'.$row['employ_deduct_tax'].'"></td>';
				echo '<td><input type="text" style="width:60px" name="deduct_provident" value="'.$row['employ_deduct_provident'].'"></td>';
				echo '<td><input type="text" style="width:60px" name="gross_sal" value="'.$row['employ_gross_sal'].'"></td>';
				echo '<td><input type="text" style="width:60px" name="total_deduct" value="'.$row['employ_total_deduct'].'"></td>';
				echo '<td><input type="text" style="width:60px" name="net_salary" value="'.$row['employee_net_salary'].'"></td>';
                
                echo '<td class="crud-actions">';
				$sendmail = array('name' => 'update', 'class' => 'btn btn-primary', 'value' => 'Update');
				
                echo form_submit($sendmail);
                echo form_close();
               /*<a href="" class="btn btn-info button_name_change" id="'.$row['team_profile_id'].'" onclick="return update('.$row['team_profile_id'].')">Edit</a>  
                  <a href="'.site_url("admin").'/payroll_manage/delete/'.$row['team_profile_id'].'" class="btn btn-danger">delete</a>*/
               echo '</td>';
                echo '</tr>';
				$i++;
				
              }
              ?>      
            </tbody>
          </table>
          </div>
          <?php echo '<div class="pagination">'.$this->pagination->create_links().'</div>'; ?>

      </div>
    </div>