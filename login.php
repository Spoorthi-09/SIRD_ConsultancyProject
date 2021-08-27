<?php
include ("connect.php");
$echo=" ";
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true){
	session_destroy();
	header("location:login.php");
    exit;
}
function session_login($db_user_id,$user_id)
{
	session_start();
	$_SESSION["loggedin"]=true;
	$_SESSION[$db_user_id]=$user_id;

	echo '<script>';
  	echo 'console.log('. json_encode( $db_user_id ) .')';
  	echo '</script>';
	// echo "<script>console.log('db user in session login ='.$db_user_id.' user id in session login'.$user_id')</script>;

}
if(isset($_POST['login']) && ($_SERVER["REQUEST_METHOD"] == "POST")){
    
    $user_id = $_POST["user_id"];
	$pass=$_POST["pass"];
    
	if($user_id == 'admin')
	{
		$sql = "select St_user_id,St_password from state where St_user_id='$user_id' ";
		$result=mysqli_query($link,$sql);
		$row = mysqli_fetch_array($result);
		if(mysqli_num_rows($result)==1)
		{
			$hash = $row['St_password'];
			if(password_verify($pass,$hash))
			{
				// session_start();
				// $_SESSION["loggedin"]=true;
				// $_SESSION['St_user_id']=$user_id;
				session_login('St_user_id',$user_id);
				header("location:stateLevel/state_index.html");
				
			}else if($pass == 'sird@1234' && $row['St_password'] == $pass)
			{
				// session_start();
				// $_SESSION["loggedin"]=true;
				// $_SESSION['St_user_id']=$user_id;
				session_login('St_user_id',$user_id);
				echo "<script>window.open('change_pwd.php','_self')</script>";
			}else{
			echo "<script>alert('Your User ID or password is incorrect.')</script>";
			}
		}
	}else
	{


		$district = "SELECT `District_user_id` , `District_password` FROM `districts` WHERE `District_user_id` = '$user_id'";
		$taluk = "SELECT `Taluk_password`, `Taluk_user_id` FROM `taluk` WHERE `Taluk_user_id`='$user_id'";
		$panchayat = "SELECT `Panchayat_user_id` , `Panchayat_password` FROM `panchayat` WHERE `Panchayat_user_id` = '$user_id'";

		$run_district = mysqli_query($link,$district);
		$run_taluk = mysqli_query($link,$taluk);
		$run_panchayat = mysqli_query($link,$panchayat);
				
		$rows_district = mysqli_num_rows($run_district);
		$rows_taluk = mysqli_num_rows($run_taluk);
		$rows_panchayat = mysqli_num_rows($run_panchayat);

		function hash_pass($db_user_id , $user_id , $rows_type , $pass , $hash)
		{
			if($pass == 'sird@1234')
			{
				if($rows_type)
				{
					session_login($db_user_id,$user_id);
				}
				echo "<script>window.open('change_pwd.php','_self')</script>";
			}else if(password_verify($pass,$hash)){
				if($rows_type)
				{
					session_login($db_user_id,$user_id);
				}
				echo "<script>window.open('user_index.html','_self')</script>";
			}
		}

		if($rows_district)
		{
			$row_district = mysqli_fetch_array($run_district);
			$hash= $row_district['District_password'];
			hash_pass('District_user_id', $user_id , '$rows_district' , $pass , $hash);
		}else if($rows_taluk)
		{
			$row_taluk = mysqli_fetch_array($run_taluk);
			$hash= $row_taluk['Taluk_password'];
			hash_pass('Taluk_user_id', $user_id , '$rows_taluk' , $pass , $hash);
		}else if($rows_panchayat)
		{
			$row_panchayat = mysqli_fetch_array($run_panchayat);
			$hash= $row_panchayat['Panchayat_password'];
			hash_pass('Panchayat_user_id', $user_id , '$rows_panchayat' , $pass , $hash);
		}

		else{
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