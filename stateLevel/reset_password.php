<?php
include("../connect.php");
session_start();
if(!isset($_SESSION['St_user_id']))
{
	header("location:../login.php");
}
$msg=" ";
if(isset($_POST['reset']))
{
	$u_id = $_POST['user_id'];
	function find($table_name , $password , $user_id , $u_id){
		$link = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
		$sql="UPDATE $table_name SET $password = 'sird@1234' WHERE $user_id = '$u_id'";
		$run = mysqli_query($link,$sql);
		if($run)
		{
			echo "<script>alert('Password Reset Successful');</script>";
			echo "<script>window.open('state_index.html','_self')</script>";
		}else{
			echo "<script>alert('Password Reset Failed!!');</script>";

		}

	}

	$district = "SELECT `District_user_id` , `District_password` FROM `districts` WHERE `District_user_id` = '$u_id'";
	$taluk = "SELECT `Taluk_password`, `Taluk_user_id` FROM `taluk` WHERE `Taluk_user_id`='$u_id'";
	$panchayat = "SELECT `Panchayat_user_id` , `Panchayat_password` FROM `panchayat` WHERE `Panchayat_user_id` = '$u_id'";

	$run_district = mysqli_query($link,$district);
	$run_taluk = mysqli_query($link,$taluk);
	$run_panchayat = mysqli_query($link,$panchayat);
				
	$rows_district = mysqli_num_rows($run_district);
	$rows_taluk = mysqli_num_rows($run_taluk);
	$rows_panchayat = mysqli_num_rows($run_panchayat);

	if($rows_district)
	{
		find('districts','District_password', 'District_user_id',$u_id);
	}else if($rows_taluk)
	{
		find('taluk','Taluk_password', 'Taluk_user_id', $u_id);
	}else if($rows_panchayat)
	{
		find('panchayat','Panchayat_password', 'Panchayat_user_id' , $u_id);
	}else{
		$msg = "Invalid User ID";
	}

	
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Reset Password</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="../images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="../vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../css/util.css">
	<link rel="stylesheet" type="text/css" href="../css/main.css">
<!--===============================================================================================-->
</head>
<body> 
	
	<div class="limiter">
	<?php include '../header/header.php' ?>
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="../images/house.jpeg" alt="IMG">
					<div id="login_logo_text">ಅಬ್ದುಲ್ ನಜೀರ್ ಸಾಬ್ <br>ರಾಜ್ಯ ಗ್ರಾಮೀಣಾಭಿೃದ್ಧಿ ಮತ್ತು ಪಂಚಾಯತ್ ರಾಜ್ ಸಂಸ್ತೆ</div>
				</div>

				<form class="login100-form validate-form" method="post" onSubmit="return confirm('Confirm user password reset');">
					<span class="login100-form-title">
						Reset Password
					</span>
					<?php echo $msg ?>
					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="user_id" placeholder="User ID">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>
			
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" name="reset">Reset</button>
					</div>
					
					<div class="text-center p-t-136">
						<a class="txt2" href="#">
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/bootstrap/js/popper.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="../js/main.js"></script>

</body>
</html>