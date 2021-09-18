<?php 
session_start();
include("connect.php");
if(!(isset($_SESSION['St_user_id']) || isset($_SESSION['District_user_id']) || isset($_SESSION['Taluk_user_id']) || isset($_SESSION['Panchayat_user_id'])))
{
	header("location:login.php");

}

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true)
{

	if(isset($_SESSION['St_user_id']))
	{    
		$user_session = $_SESSION['St_user_id'];
	}
	if(isset($_SESSION['District_user_id']))
	{
		$user_session = $_SESSION['District_user_id'];
	}
	if(isset($_SESSION['Taluk_user_id']))
	{
		$user_session = $_SESSION['Taluk_user_id'];
	}
	if(isset($_SESSION['Panchayat_user_id']))
	{
		$user_session = $_SESSION['Panchayat_user_id'];
	} 
}  
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Table V01</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main_table.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
	<?php include 'header/header.php' ?>
		<div class="container-table100">
			<div class="wrap-table100">
				<div class="table100">
					<table>
						<thead>
							<tr class="table100-head">
								<th class="column1">Date of reporting</th>
								<th class="column2">Date of Event</th>
								<th class="column3">Event Name</th>
								<th class="column4">Event Theme</th>
								<th class="column5">Update</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$sql = "SELECT * FROM `event` WHERE `User_id`='$user_session' ORDER BY `Event_date` DESC";
								$run = mysqli_query($link,$sql);
								while($rows = mysqli_fetch_array($run))
								{
									$event_id = $rows['Event_id'];
									$rep_date = $rows['reporting_date'];
									$event_date = $rows['Event_date'];
									$event_name = $rows['Event_name'];
									$event_theme = $rows['Event_theme'];
									
									echo "<tr>
									<td class='column1'>$rep_date</td>
									<td class='column2'>$event_date</td>
									<td class='column3'>$event_name</td>
									<td class='column4'>$event_theme</td>
									<td class='column5'><a style = 'text-decoration:none;cursor:pointer;color:#3897f0;' href = 'update_report_form.php?e_id=$event_id'>View/Update</a></td>
									</tr>";
								}									
							?>						
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>


	

<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>