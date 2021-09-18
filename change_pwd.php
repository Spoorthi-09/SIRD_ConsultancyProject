<?php
    session_start();
    include("connect.php");
	if(!(isset($_SESSION['St_user_id']) || isset($_SESSION['District_user_id']) || isset($_SESSION['Taluk_user_id']) || isset($_SESSION['Panchayat_user_id'])))
	{
		header("location:login.php");

	}
	$msg= $choice=" ";
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true)
    {
    
        if(isset($_SESSION['St_user_id']))
        {    
            $user_session = $_SESSION['St_user_id'];
			$choice='admin';
        }
        if(isset($_SESSION['District_user_id']))
        {
            $user_session = $_SESSION['District_user_id'];
			$choice='district';
        }
        if(isset($_SESSION['Taluk_user_id']))
        {
            $user_session = $_SESSION['Taluk_user_id'];
			$choice='taluk';
        }
        if(isset($_SESSION['Panchayat_user_id']))
        {
            $user_session = $_SESSION['Panchayat_user_id'];
			$choice='panchayat';
        } 
    }  

	if(($_SERVER["REQUEST_METHOD"]=="POST") && isset($_POST["passwordChange"]))
	{
		$newpass = htmlentities($_POST["newpass"]);
		$confirmNewpass = htmlentities($_POST["confirmNewpass"]);

		if($newpass == $confirmNewpass)
		{
			if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $newpass)) {
				$msg = "Password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.";
			} 
			else 
			{
				$msg = "Your password is strong.";
				$new_pass = password_hash($newpass, PASSWORD_DEFAULT);
				switch($choice)
				{
					case 'admin': $sql="UPDATE `state` SET `St_password`='$new_pass' WHERE `St_user_id`='$user_session'";
								break;
					case 'district': $sql="UPDATE `districts` SET `District_password`='$new_pass' WHERE `District_user_id`='$user_session'";
								break;
					case 'taluk': $sql="UPDATE `taluk` SET `Taluk_password`='$new_pass' WHERE `Taluk_user_id`='$user_session'";
								break;
					case 'panchayat': $sql="UPDATE `panchayat` SET `Panchayat_password`='$new_pass' WHERE `Panchayat_user_id`='$user_session'";
								break;
					default : echo "User ID invalid";
				}
				
				$result=mysqli_query($link,$sql);
				if($result>0)
				{
					echo "<script>alert('Password Updated!')</script>";
					session_destroy();
					echo "<script>window.open('login.php','_self')</script>";

				}else{
					echo "<script>alert('Password not Updated!')</script>";

				}
				
			}

		}else{
			$msg = "Passwords do not match";
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/house.jpeg" alt="IMG">
					<div id="login_logo_text">ಅಬ್ದುಲ್ ನಜೀರ್ ಸಾಬ್ <br>ರಾಜ್ಯ ಗ್ರಾಮೀಣಾಭಿೃದ್ಧಿ ಮತ್ತು ಪಂಚಾಯತ್ ರಾಜ್ ಸಂಸ್ತೆ</div>
				</div>

				<form class="login100-form validate-form" method="POST">
					<span class="login100-form-title">
						Change Password
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
                    <input class="input100" type="password" name="newpass" placeholder="New Password" id="password">
					<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>                        
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="confirmNewpass" placeholder="Confirm new password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<span><?php echo $msg?></span>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" name = "passwordChange">Submit</button>
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

    <!-- password visibility script -->
    <script> 
    

    togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye / eye slash icon
    this.classList.toggle('bi-eye');
});
    
        // function mouseoverPass(obj) {
        // var obj = document.getElementById('myPassword');
        // obj.type = "text";
        // }
        // function mouseoutPass(obj) {
        // var obj = document.getElementById('myPassword');
        // obj.type = "password";
        // }
    </script>
	<script src="js/main.js"></script>

</body>

</html>