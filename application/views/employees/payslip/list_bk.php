       <script>
	function delete_confirm()
	{
		var deleteConfirm=confirm("Are you going to delete the employee payslip details");
		if(deleteConfirm==true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	</script>   
   <div class="container top">
	   <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("admin"); ?>">
            <?php echo ucfirst($this->uri->segment(1));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <?php echo ucfirst($this->uri->segment(2));?>
        </li>
      </ul>
      <?php 

		 //if(isset($result))
		// echo $result;
	    // if(isset($delete_for_regenrate))
		// echo $delete_for_regenrate;
	
	  ?>
      <div class="page-header users-header">
        <h2>
          <?php echo ucfirst($this->uri->segment(2));?> 
        
        </h2>
      </div>
      <?php
	
	      if(isset($result))
		   {
			   if($result=='Success')
			   {
					echo '<div class="alert alert-success">';
					echo '<a class="close" data-dismiss="alert">×</a>';
					echo '<strong>Payslip details has been generated for all employees.</strong>';
					echo '</div>';
									
			   }
			   else
			   {
				  echo '<div class="alert alert-error">';
                  echo '<a class="close" data-dismiss="alert">×</a>';
                  echo '<strong>Payslip details already exist. If you want to regenerate please delete the existing data. </strong>';
                  echo '</div>';   
			   }
			}
			
			if(isset($delete_for_regenrate))
		   {
			   if($delete_for_regenrate=='Deleted')
			   {
					echo '<div class="alert alert-success">';
					echo '<a class="close" data-dismiss="alert">×</a>';
					echo '<strong>Payslip details has been Deleted. If you want to create new payslip details for this month please click the generate payslip button</strong>';
					echo '</div>';
			   }
			   else
			   {
				  echo '<div class="alert alert-error">';
                  echo '<a class="close" data-dismiss="alert">×</a>';
                  echo '<strong>There is no details to delete this month.  </strong>';
                  echo '</div>';   
			   }
			}
			
	    if(isset($Review_employee))
		{
			  // echo $data['team_profile_email'];
			   if($data['team_profile_email']!='')
			   {
                echo $resultdata=$Review_employee;
		        $filedata = '<?php
				header("Content-Type: application/vnd.ms-excel");
				header("Content-disposition: attachment; filename=bagcollection.xls\n"); 
				?>';
				$filedata .= $resultdata;
				$myFile ="application/libraries/excelexport.php";
				$fh = fopen($myFile, 'w') or die("can't open file");
				fwrite($fh, $filedata);
				fclose($fh);
				//echo $resultdata;
				$mpdf = new mPDF('c','A4');
				$stylesheet = file_get_contents('application/libraries/pdfstyle.css');
				$mpdf->WriteHTML($stylesheet,1);
				$mpdf->WriteHTML($resultdata);
				$mpdf->Output('application/libraries/bagcollection.pdf','F');
				//redirect('application/libraries/bagcollection.pdf');
			   }
			   else
			   {
				   echo '<b>This employee payslip is not available</b>';
			   }
		}
		if(isset($sendmail_employee))
		{
               // print_r($data);
				 $email=$data['team_profile_email'];
				if($email!='')
				{
            	//print_r(employee_send);
			  //  print_r($get_employee_details_value);
                $resultdata=$sendmail_employee;
		        $filedata = '<?php
				header("Content-Type: application/vnd.ms-excel");
				header("Content-disposition: attachment; filename=bagcollection.xls\n"); 
				?>';
				$filedata .= $resultdata;
				$myFile ="application/libraries/excelexport.php";
				$fh = fopen($myFile, 'w') or die("can't open file");
				fwrite($fh, $filedata);
				fclose($fh);
				//echo $resultdata;
				$mpdf = new mPDF('c','A4');
				$stylesheet = file_get_contents('application/libraries/pdfstyle.css');
				$mpdf->WriteHTML($stylesheet,1);
				$mpdf->WriteHTML($resultdata);
				$mpdf->Output('application/libraries/payslip.pdf','F');
				//redirect('application/libraries/bagcollection.pdf');
				  $this->email->set_newline("\r\n");
				  $this->email->from('hrms@nathanresearch.com');
				  $this->email->to($email);
				  $subject='Payslip';
				  $message='Nathan Research';
				  $this->email->subject($subject);
				  $this->email->message($message);
					$this->email->attach('application/libraries/payslip.pdf');
				    if($this->email->send())
					 {
					  echo '<b>Email sent successfully</b>';
					 }
					 else
					{
					 show_error($this->email->print_debugger());
					}
				}
				else
				{
					echo '<b>The payslip was not generated for the given person<b>';
				}
		}
		if(isset($all_get_employee_details_value))
		{
			//print_r($all_get_employee_details_value);exit;
		$count_emplpoyee=count($all_get_employee_details_value);
		if($count_emplpoyee>0)
		{
			foreach($all_get_employee_details_value as $row )
			{
				$this->email->clear();
				//echo $row['team_profile_full_name'];
				$resultforSend ='';
				$filedata='';
				 if(isset($start_end_date))
					 {
					  // Getting the starting and ending date of current month
					  $start_end_date= explode("_",$start_end_date);
					  $start_date = $start_end_date[0];
					  $end_date   = $start_end_date[1];
					  $ch = curl_init();
					  //$url='http://localhost:8080/attendance.php?start_date='.$start_date.'&end_date='.$end_date;
					  $url='http://mgt.nathanresearch.com/project_mgt/attendance.php?start_date='.$start_date.'&end_date='.$end_date;
					  $curl = curl_init($url);
					  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					  curl_setopt($ch, CURLOPT_HTTPGET, 1);
					  $curl_response = curl_exec($curl);
					  curl_close($curl);
					  $curl_response1=json_decode($curl_response);
					  $team_profile_id_arr  = array();    
					  $fullname_arr         = array();
					  $Status_arr           = array();
					  $COUNT1_arr           = array();
					//  print_r($curl_response1);
						foreach($curl_response1 as $test)
						{
							  $team_profile_id_arr[] = $test->team_profile_id; 
							  $fullname_arr[]		 = $test->fullname; 
							  $Status_arr[]		     = $test->Status; 
							  $COUNT1_arr[]	     	 = $test->COUNT; 
						}
					 //  print_r($team_profile_id_arr);
					 //  print_r($fullname_arr);
					  // print_r($Status_arr);
					  // print_r($COUNT1_arr);
					  // When we give the employee id here you can get the count(IN,Leave,SL) of employee status 
						 $employ_id_count=array_count_values($team_profile_id_arr);
						 $employee_id=$row["team_profile_id"];
						 $count_eployee_status=$employ_id_count[$employee_id];
     					 $key_employee  = array_search($employee_id, $team_profile_id_arr);
									for($i=1;$i<=$count_eployee_status;$i++)
										{
											//$employee_name =$fullname_arr[$key_employee];
											$employee_name =$fullname_arr[$key_employee];
											$status_atten  =$Status_arr[$key_employee];
											$count_atten  =$COUNT1_arr[$key_employee];
											
											//echo '<br>'.$employee_name; echo '<br>';echo $status_atten; echo '<br>'; echo $count_atten;
											 if($status_atten=='IN')
											 {
												 //$office_in     ='IN';
												 $office_in_att =$count_atten;
											 }
											
											 if($status_atten=='Leave')
											 {
												// $office_leave='Leave';
												 $office_in_att_leave=$count_atten;
											 }
											 if($status_atten=='SL')
											 {
												// $office_sl='Sick Leave';
												 $office_in_att_sl=$count_atten;
											 }
											 $key_employee=$key_employee+1;
										// echo $office_in_att;echo $office_in_att_leave;echo $office_in_att_sl;
										   if($office_in_att=='')
										   $office_in_att=0; 
										   if($office_in_att_leave=='')
										   $office_in_att_leave=0;
										   if($office_in_att_sl=='')
										   $office_in_att_sl=0;
											   
										}
							  
					}
				//$this->email->clear();
		$resultforSend .= '<table cellpadding="3" cellspacing="0" border="1" width="80%">
                          <tr><td><b>NATHAN RESEARCH SYSTEMS PRIVATE LIMITED</b></td><td colspan="4" align="center">PAYSLIP</td></tr>
						  <tr><td colspan="5"><b>46B/16, SOUTH BOAG ROAD, T.NAGAR CHENNAI - 600 017</b></td></tr>
						  <tr><td colspan="2"><b>Employee Name &nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; </b>'.$row["team_profile_full_name"].'</td><td><b>Employee ID :</b></td><td></td></tr>
						  <tr><td colspan="1"><b>Designation &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;</b></td><td align="center" colspan="3"><b>Employee Attendance for Pay Period of '.date("M-y",strtotime($row["curr_date_month"])).'</b></td></tr>
						  <tr><td><b>Employee Attendance</b></td><td>Office IN : '.$office_in_att.'</td><td align="center">Leave : '.$office_in_att_leave.'</td><td align="center">Sick Leave : '.$office_in_att_sl.'</td></tr>
						  <tr><td align="center" colspan="2"><b>Earnings </b></td><td colspan="3" align="center"><b>Deductions</b></td></tr>
						  <tr><td><b>Detail</b></td><td align="right"><b>Amount in Rs</b></td><td><b>Detail</b></td><td colspan="2"  align="right"><b>Amount in Rs</b></td></tr>
						  <tr><td >Basic salary</td><td align="right">'.$row["employ_basic_salary"].'</td><td>Income Tax</td><td colspan="2" align="right">'.$row["employ_deduct_tax"].'</td></tr>
						  <tr><td>HRA</td><td align="right">'.$row["employ_house_allow"].'</td><td>PF</td><td colspan="3" align="right">'.$row["employ_deduct_provident"].'</td></tr>
						  <tr><td>Conveyance</td><td align="right" >'.$row["employ_conveyance"].'</td><td colspan="3"></td></tr>
						  <tr><td>Medical </td><td align="right">'.$row["employ_medical_allow"].'</td><td colspan="3"></td></tr>
						  <tr><td> Other Allowance</td><td align="right">'.$row["employ_other_allow"].'</td><td colspan="3"></td></tr>
						  <tr><td>Total Earnings</td><td align="right">'.$row["employ_gross_sal"].' </td><td>Total Deductions</td><td colspan="2" align="right">'.$row["employ_total_deduct"].'</td></tr>
						   <tr></tr>
						    <tr><td>Net Pay </td><td align="right" >'.$row["employee_net_salary"].'</td><td>Credit to </td><td colspan="2" align="center">Bank</td></tr>
							<tr></tr>
							<tr><td colspan="5">Ramachandran Viswanathan</td></tr>
						  <tr><td colspan="5">Director - Nathan Research Systems Private Limited</td></tr>
                 		</table>';
						//echo $resultforSend;exit;
						$filedata = '<?php
						header("Content-Type: application/vnd.ms-excel");
						header("Content-disposition: attachment; filename=bagcollection.xls\n"); 
						?>';
						$filedata .= $resultforSend;
						$myFile ="application/libraries/payslip.php";
						$fh = fopen($myFile, 'w') or die("can't open file");
						fwrite($fh, $filedata);
						fclose($fh);
						//echo $resultdata;
						$mpdf = new mPDF('c','A4');
						$stylesheet = file_get_contents('application/libraries/pdfstyle.css');
						$mpdf->WriteHTML($stylesheet,1);
						$mpdf->WriteHTML($resultforSend);
						$mpdf->Output('application/libraries/payslip.pdf','F');
						$mail_to     = $row["team_profile_email"];
						$subject=$row["team_profile_full_name"].' Payslip';
						$mail_content='test';
						$message ='Nathan Research';
						//$mail_sent_y = $fn->FnSentMailNotification($mail_to, $mail_subject, $mail_content, '', '', $attach_file, true, "test");
						//$mail_sent_y = $fn->FnSentMailNotification($mail_to, $mail_subject, $mail_content, $mailCCto, $mailBCCto, $attach_file, true, "material");
						$this->email->set_newline("\r\n");
						  $this->email->from('hrms@nathanresearch.com');
						  $this->email->to($mail_to);
						  $subject='Payslip';
						  $message='Nathan Research';
						  $this->email->subject($subject);
						  $this->email->message($message);
						  
						  
						 // $this->email->attach('');
						   if($mail_to!='')
						   {
							$this->email->attach('application/libraries/payslip.pdf');
							if($this->email->send())
							 {
								// $this->email->clear(TRUE);
								// $this->email->attach('');
							   // echo 'Email send.';
							 }
							 else
							{
							 show_error($this->email->print_debugger());
							}
						   }
						 $this->email->clear(TRUE);
			}
			echo '<b>Group Email sent successfully</b>';
		}
		else
		{
			echo '<b>There is no employee payslip to send</b>';
		}
		}
	   // Employee dropdown list for Review
	   
      $all_employees = array('' => "Select");
      foreach ($get_all_employees as $row)
      {
        $all_employees[$row['team_profile_id']] = $row['team_profile_full_name'];
      }
	 // Employee dropdown list for sending mail
	   
	  $all_employees_mail = array('' => "Select",'All'=>'All');
      foreach ($get_all_employees as $row)
      {
        $all_employees_mail[$row['team_profile_id']] = $row['team_profile_full_name'];
      }
	   echo validation_errors();
	    
	  ?>
      <div class="row">
        <div class="span12 columns">
          <div class="well">
           
              
              <?php
                echo '<table cellpadding="8" cellspacing="8" border="0" width="50%"><tr>
				<td><label for="female">Payslip Generates</label> </td><td>
				';			  
     		    $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform');
				 echo form_open('admin/payslip', $attributes);
				 
                $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Generate Payslip');
				
                echo form_submit($data_submit);
                echo form_close();
				echo '</td><td>';
				
				 $attributes1 = array('class' => 'form-inline reset-margin', 'id' => 'myform1');
				 echo form_open('admin/payslip', $attributes1);
				 
                $Regenerate_submit = array('name' => 'regenerate_submit', 'class' => 'btn btn-primary', 'value' => 'Delete for Payslip Regenerate');
				
                echo form_submit($Regenerate_submit);
                echo form_close();
				echo '</tr>
				
				<tr><td></td></tr>
				
				';
				
				
				 $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform2');
				 echo form_open('admin/payslip', $attributes);
				 echo '<tr><td><label for="female">Employee name</label> </td><td>';
				echo form_dropdown('employee_id', $all_employees, set_value('employee_id'), 'class="span2"');
				echo '</td><td>';
                $Review = array('name' => 'Review', 'class' => 'btn btn-primary', 'value' => 'Review');
				
                echo form_submit($Review);
                echo form_close();
				
				$attributes2 = array('class' => 'form-inline reset-margin', 'id' => 'myform3');
				echo form_open('admin/payslip', $attributes2);
				echo '</td>
				<tr>';
				 echo '<tr><td><label for="female">Employee</label> </td><td>';
				echo form_dropdown('mail_employee_id', $all_employees_mail, set_value('mail_employee_id'), 'class="span2"');
				echo '</td><td>';
                $sendmail = array('name' => 'sendmail', 'class' => 'btn btn-primary', 'value' => 'Send');
				
                echo form_submit($sendmail);
                echo form_close();
				echo '</td>
				
				
				
				
				<tr>
				</table>';
			  ?> 
          </div>

         

        

      </div>
    </div>