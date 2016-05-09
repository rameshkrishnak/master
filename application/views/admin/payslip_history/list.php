   <script src="<?php echo base_url(); ?>assets/js/jquery-1.7.1.min.js"></script>
    <!-- <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>  -->
 
	<link rel="stylesheet" href="<?php echo base_url();?>assets/js/script/jquery-ui.css">
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/script/jquery.mtz.monthpicker.js"></script>	
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
      background-color:#E6E6E6;
	}

	tr.style1:nth-of-type(even) {
      background-color:#E6E6E6;
	}
	
	</style>
	<script>
	
	jQuery.noConflict();
	jQuery(document).ready(function(jQuery) {
	jQuery('#list_history').on("click",function(){
		var date_history=$("#date_history").val();
		//alert(date_history);
		dataDetail={'date_history':date_history}
		  $.ajax({
		dataType:'html',
		data:dataDetail,
		type:'POST',
		url:'<?php echo base_url();?>ajax_process.php',
		success:function(data){
			$("#current_list").html(data);
			//alert(data);
		}
		});
		
	});
		
       jQuery('#date_history').monthpicker({pattern: 'yyyy-mm', 
    selectedYear: 2015,
    startYear: 2010,
    finalYear: 2025,});
	var options = {
    selectedYear: 2015,
    startYear: 2008,
    finalYear: 2018,
    openOnFocus: false // Let's now use a button to show the widget
	};
	
	
});
   
	</script>
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
              echo form_open('admin/payslip_history', $attributes);
     
             // echo form_label('Search:', 'search_string');
              echo form_input('search_string', $search_string_selected, 'style="width: 170px;
 float:left"');

             

             // echo form_label('Order by:', 'order');
             // echo form_dropdown('order', $options_sal_details, $order, 'class="span2"');
              

              
              echo '&nbsp;';
             // $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
             // echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span1"');
			  echo '&nbsp;';
              $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Search','style="float:left;"','id'=>'mysubmit'  );
              echo form_submit($data_submit);
             ?>
			  <input type="text" id="date_history" value='<?php echo date('Y-m'); ?>' style="margin-left:200px;"> <input type="button" id="list_history" class="btn btn-primary" value="Submit">
			 <?php 
             echo form_close();
			//print_r($test);
			
			
            ?>
           
          </div>
          <div class="resizable">
          <table class="table table-striped table-bordered table-condensed" id="current_list">
            <thead>
              <tr>
                <!--<th class="header">#</th>-->
               <!-- <th class="yellow header headerSortDown">Employee Designation</th>-->
                <th class="green header">Name</th>
                <!--<th class="red header">Employee Type</th>-->
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
				<th class="red header">Date</th>
               
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
                echo '<td>'.$row['team_profile_full_name'].'</td>';
				echo '<td>'.$row['employ_basic_salary'].'</td>';
                echo '<td>'.$row['employ_house_allow'].'</td>';
				/*echo '<td>'.$row['team_profile_job_title'].'</td>';*/
                echo '<td>'.$row['employ_medical_allow'].'</td>';
                echo '<td>'.$row['employ_conveyance'].'</td>';
				 echo '<td>'.$row['employ_other_allow'].'</td>';
				echo '<td>'.$row['employ_deduct_tax'].'</td>';
				echo '<td>'.$row['employ_deduct_provident'].'</td>';
				echo '<td>'.$row['employ_gross_sal'].'</td>';
				echo '<td>'.$row['employ_total_deduct'].'</td>';
				echo '<td>'.$row['employee_net_salary'].'</td>';
				echo '<td>'.date('d-M-Y',strtotime($row['curr_date_month'])).'</td>';
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