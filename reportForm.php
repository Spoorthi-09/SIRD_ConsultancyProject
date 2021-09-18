<?php 
  session_start();
include("connect.php");
$check = " ";
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
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"]))
    {
      $name = htmlentities($_POST["name"]);
      $theme = htmlentities($_POST["theme"]);
      $date = htmlentities($_POST["date"]);
      $content = htmlentities($_POST["content"]);
      $upload_image = $_FILES['upload_image']['name'];
      $image_tmp = $_FILES['upload_image']['tmp_name'];
      srand(mktime());
      $random = rand(0,999999);
      $flag=false;


      if(strlen($upload_image)>=1)
      {   
        $errors     = array();
        $maxsize    = 10097152;
        $acceptable = array(
            'image/jpeg',
            'image/jpg',
            'image/png'
        );   
        
        if(($_FILES['upload_image']['size'] >= $maxsize) || ($_FILES["upload_image"]["size"] == 0)) {
          $errors[] = 'File too large. File must be less than 10 megabytes.';
        }
  
        if((!in_array($_FILES['upload_image']['type'], $acceptable)) && (!empty($_FILES["upload_image"]["type"]))) {
          $errors[] = 'Invalid file type. Only JPG and PNG types are accepted.';
        }
        if(count($errors) === 0) {
          $flag = move_uploaded_file($image_tmp, "reportImages/$name.$random.png");
        } else {
          foreach($errors as $error) {
              echo '<script>alert("'.$error.'");</script>';
              echo "<script>window.open('reportForm.php','_self')</script>";
          }
  
          die(); //Ensure no more processing is done
        }
      }
        if($flag)
        {
          $sql = "INSERT INTO `event`(`Event_name`, `Event_theme`, `Event_date`, `Event_details`, `User_id`,`pic1`) VALUES ('$name','$theme','$date','$content','$user_session','$name.$random.png')";
        }else{
          $sql = "INSERT INTO `event`(`Event_name`, `Event_theme`, `Event_date`, `Event_details`, `User_id`) VALUES ('$name','$theme','$date','$content','$user_session')";
        }
          $result=mysqli_query($link,$sql);
          if($result)
          {
            echo "<script>alert('Report upload successful')</script>";
            if($user_session == 'admin')
            {
              echo "<script>window.open('stateLevel/state_index.html','_self')</script>";
            }else{
              echo "<script>window.open('user_index.html','_self')</script>";
            }    
          }else{
            echo "<script>alert('Report upload not Successful')</script>";
          }
    }
  ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Event Report Form</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
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
    <link rel="stylesheet" type="text/css" href="report-css/style.css">
  <!--===============================================================================================-->
  </head>
  <body>
    <div class="limiter">
      <?php include 'header/header.php' ?>
      <div class="container-login100">
        <div class="wrap-login100">
            <form method="post" enctype = "multipart/form-data">
              <span class="login100-form-title">
                Report an event
              </span>
              <div class="item">
                <p>Name</p>
                <div>
                  <input type="text" name="name" placeholder="Name" required/>
                </div>
              </div>
              <div class="item">
                <p> Theme / Subject</p>
                <input type="text" name="theme" placeholder="Theme" required/>
              </div>
              <div class="item">
                <p>Date of conduction</p>
                <input type="date" name="date" required />
                <i class="fas fa-calendar-alt"></i>
              </div>
              <div class="item">
                <p>What was done?</p>
                <textarea rows="5" name="content"></textarea>
              </div>
              <input type="file" id="actual-btn" name="upload_image" hidden/>
              <label for="actual-btn" class="login100-form-btn">Upload Image</label>
              <span id="file-chosen">No file chosen <span style="font-size:12px">( Choose file(png/jpg/jpeg) with size less than 10MB )</span></span>
              
                <script>
                  const actualBtn = document.getElementById('actual-btn');

                  const fileChosen = document.getElementById('file-chosen');

                  actualBtn.addEventListener('change', function(){
                  fileChosen.textContent = this.files[0].name
                  })
                </script>
              <br>
              <div class="container-login100-form-btn">
						    <button class="login100-form-btn" name="submit">Submit</button>
					    </div>
            </form>
        </div>
      </div>
    </div>      
  </body>
</html>