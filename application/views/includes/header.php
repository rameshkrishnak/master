<?php //error_reporting(0);
header("cache-Control: no-store, no-cache, must-revalidate");
header("cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

?>
<!DOCTYPE html> 
<html lang="en-US">
<head>
  <title>HR Management</title>
  <meta charset="utf-8">
  <META HTTP-EQUIV="Pragma" CONTENT="no-cache"> <META HTTP-EQUIV="Expires" CONTENT="-1">
  <link href="<?php echo base_url(); ?>assets/css/admin/global.css" rel="stylesheet" type="text/css">
   <link href="<?php echo base_url(); ?>assets/css/admin/datepicker.css" rel="stylesheet" type="text/css">
   <script type="text/javascript" language="javascript">

function DisableBackButton() {
alert("Operation not allowed");
return false;
}
DisableBackButton();
window.onload = DisableBackButton;
window.onpageshow = function(evt) { if (evt.persisted) DisableBackButton() }
window.onunload = function() { void (0) }
</script>

</head>
<body>
	<div class="navbar navbar-fixed-top">
	  <div class="navbar-inner">
    <div style="float:left; padding:0px;margin: 3px 0px 0px 5px;">
            <img src="<?php echo base_url(); ?>assets/img/admin/logo.jpg" alt=""  width="" height="38px"/>
            </div> 
	    <div class="container">
    		   
	      <a class="brand" style="color:#FFF;">Human Resource Management</a>
	      <ul class="nav">
		   <?php if($this->session->userdata('user_group')==1 || $this->session->userdata('user_group')==4)
			 {
			  ?>
	        <li <?php if($this->uri->segment(2) == 'dashboard'){echo 'class="active"';}?>>
	          <a href="<?php echo base_url(); ?>admin/dashboard">Dashboard</a>
	        </li>
		
            <li <?php if($this->uri->segment(2) == 'groups'){echo 'class="active"';}?>>
	          <a href="<?php echo base_url(); ?>admin/groups">Groups</a>
	        </li>
		 <?php } ?>	
		 <?php if($this->session->userdata('user_group')==1 || $this->session->userdata('user_group')==5)
			 {
			  ?>
	        <li <?php if($this->uri->segment(2) == 'payroll_manage'){echo 'class="active"';}?>>
	          <a href="<?php echo base_url(); ?>admin/payroll_manage">Payroll</a>
	        </li>
			<li <?php if($this->uri->segment(2) == 'payslip'){echo 'class="active"';}?>>
	          <a href="<?php echo base_url(); ?>admin/payslip">Payslip</a>
	        </li>
			<li <?php if($this->uri->segment(2) == 'payslip_list'){echo 'class="active"';}?>>
	          <a href="<?php echo base_url(); ?>admin/payslip_list">Payslip List</a>
	        </li>
			<li <?php if($this->uri->segment(2) == 'payslip_history'){echo 'class="active"';}?>>
	          <a href="<?php echo base_url(); ?>admin/payslip_history">Payslip History</a>
	        </li>
		 <?php } ?>	
			<?php if($this->session->userdata('user_group')==2 || $this->session->userdata('user_group')==3)
			{
			  ?>
	       	<li <?php if($this->uri->segment(2) == 'payslip'){echo 'class="active"';}?>>
	          <a href="<?php echo base_url(); ?>admin/payslip">Payslip</a>
	        </li>
			
	  <?php } ?>	
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown">System <b class="caret"></b></a>
	          <ul class="dropdown-menu">
	            <li>
	              <a href="<?php echo base_url(); ?>logout">Logout</a>
	            </li>
	          </ul>
	        </li>
	      </ul>
	    </div>
	  </div>
	</div>	
