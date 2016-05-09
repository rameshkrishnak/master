<?php 
//echo 'hihi';
error_reporting(0);
//online
$link = mysql_connect("localhost","nathanr_hrms","n@th@nhrm51@1#");
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

//mysql_close($link);
mysql_select_db("nathanr_hrms_dev",$link) or die('Could not select database.');
//local
/*$link = mysql_connect("localhost","root","");
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
//mysql_close($link);
mysql_select_db("hrmgt_db",$link) or die('Could not select database.');*/
$history_year=date('Y',strtotime($_REQUEST['date_history']));
$history_month=date('m',strtotime($_REQUEST['date_history']));
if(isset($_REQUEST['date_history']))
{	
$queryresult=mysql_query("SELECT payslip_history.*,team_profile.* FROM payslip_history 
	inner join team_profile on team_profile.team_profile_id=payslip_history.team_profile_id
	where YEAR(curr_date_month)='$history_year' and MONTH(curr_date_month)='$history_month'");
	if(mysql_num_rows($queryresult)>0)
	{
		echo '
		<table class="table table-striped table-bordered table-condensed">
            <thead>
              <tr>
               <th class="green header">Name</th>
               <th class="red header">BS</th>
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
		';
		while($row_history_list=mysql_fetch_array($queryresult))
		{
			echo '<tr class="style1"><td>'.$row_history_list['team_profile_full_name'].'</td>
			          <td>'.$row_history_list['employ_basic_salary'].'</td>
					  <td>'.$row_history_list['employ_house_allow'].'</td>
					  <td>'.$row_history_list['employ_medical_allow'].'</td>
					  <td>'.$row_history_list['employ_conveyance'].'</td>
					  <td>'.$row_history_list['employ_other_allow'].'</td>
					  <td>'.$row_history_list['employ_deduct_tax'].'</td>
					  <td>'.$row_history_list['employ_deduct_provident'].'</td>
					  <td>'.$row_history_list['employ_gross_sal'].'</td>
					  <td>'.$row_history_list['employ_total_deduct'].'</td>
					  <td>'.$row_history_list['employee_net_salary'].'</td>
					  <td>'.$row_history_list['employee_net_salary'].'</td>
					  <td>'.date('d-M-Y',strtotime($row_history_list['curr_date_month'])).'</td>
			      </tr>';
			
		
		}
		echo '  </tbody>
          </table>';
	}
	else
	{
		echo '<p align="center" class="alert alert-error"><b>There is no data</b></p>';
	}
//	echo $_REQUEST['date_history'];
}

?>