<?php
include ("connect.php");
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true){
    header("location:login.php");
    exit;
}
if(isset($_POST['login']) && ($_SERVER["REQUEST_METHOD"] == "POST")){
    
    $user_id = $_POST["user_id"];
    $pass = $_POST["pass"];
    
	if($user_id == 'admin')
	{
		$sql = "select St_user_id,St_password from state where St_user_id='$user_id' AND St_password='$pass' ";
		$result=mysqli_query($link,$sql);
		if(mysqli_num_rows($result)==1)
		{
			session_start();
			$_SESSION["loggedin"]=true;
			$_SESSION['St_user_id']=$user_id;
			
			if($pass == 'sird@1234')
			{
				echo "<script>window.open('change_pwd.php','_self')</script>";
			}else{
				header("location:stateLevel/state_index.html");
			}
		}else{
			echo "<script>alert('Your User ID or password is incorrect.')</script>";
		}

	}else{


		$district = "SELECT `District_user_id` , `District_password` FROM `districts` WHERE `District_user_id` = '$user_id' AND `District_password`='$pass' ";
		$taluk = "SELECT `Taluk_password`, `Taluk_user_id` FROM `taluk` WHERE `Taluk_password`='$pass' AND `Taluk_user_id`='$user_id'";
		$panchayat = "SELECT `Panchayat_user_id` , `Panchayat_password` FROM `panchayat` WHERE `Panchayat_user_id` = '$user_id' AND `Panchayat_password`='$pass' ";

		$run_district = mysqli_query($link,$district);
		$run_taluk = mysqli_query($link,$taluk);
		$run_panchayat = mysqli_query($link,$panchayat);
		
		
		$rows_district = mysqli_num_rows($run_district);
		$rows_taluk = mysqli_num_rows($run_taluk);
		$rows_panchayat = mysqli_num_rows($run_panchayat);

		if($rows_district || $rows_taluk || $rows_panchayat)
		{
			if($pass == 'sird@1234')
			{
				if($rows_district)
				{
					session_start();
					$_SESSION["loggedin"]=true;
					$_SESSION['District_user_id']=$user_id;
				}else if($rows_taluk)
				{
					session_start();
					$_SESSION["loggedin"]=true;
					$_SESSION['Taluk_user_id']=$user_id;
				}else if($rows_panchayat)
				{
					session_start();
					$_SESSION["loggedin"]=true;
					$_SESSION['Panchayat_user_id']=$user_id;
				}
				echo "<script>window.open('change_pwd.php','_self')</script>";
			}else{
				echo "<script>window.open('reportForm.php','_self')</script>";
			}
		}else{
			echo "<script>alert('Your User ID or password is incorrect.')</script>";
			echo "<script>window.open('login.php','_self')</script>";
		}
	}
  }


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
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
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/pp-1.jpg" alt="IMG">
				</div>

				<form class="login100-form validate-form" method="post">
					<span class="login100-form-title">
						Login
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="user_id" placeholder="User ID">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="pass" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" name="login">Login</button>
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
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>