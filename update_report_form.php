<?php
session_start();
include("connect.php");
if(!(isset($_SESSION['St_user_id']) || isset($_SESSION['District_user_id']) || isset($_SESSION['Taluk_user_id']) || isset($_SESSION['Panchayat_user_id'])))
{
	header("location:login.php");

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
      <div class="container-login100">
        <div class="wrap-login100">
          <?php
            if(isset($_GET['e_id']))
            {
              $pic=" ";
              $event_id=$_GET['e_id'];
              $sql="SELECT * FROM `event` WHERE Event_id='$event_id'";
              $run = mysqli_query($link,$sql);
              while($row= mysqli_fetch_array($run))
              {
                $user_session=$row['User_id'];
                $event_name=$row['Event_name'];
                $event_theme=$row['Event_theme'];
                $event_date=$row['Event_date'];
                $event_details=$row['Event_details'];
                $pic = $row['pic1'];
                $db_pic = $row['pic1'];


                echo "
                <form method='post' enctype = 'multipart/form-data'>
              <span class='login100-form-title'>
                Report an event
              </span>
              <div class='item'>
                <p>Name</p>
                <div>
                  <input type='text' name='name' placeholder='Name' value=$event_name required/>
                </div>
              </div>
              <div class='item'>
                <p> Theme / Subject</p>
                <input type='text' name='theme' placeholder='Theme' value=$event_theme required/>
              </div>
              <div class='item'>
                <p>Date of conduction</p>
                <input type='date' name='date' value=$event_date required />
                <i class='fas fa-calendar-alt'></i>
              </div>
              <div class='item'>
                <p>What was done?</p>
                <textarea rows='5' name='content' >$event_details</textarea>
              </div>
              <input type='file' id='actual-btn' name='upload_image' hidden/>
              <label for='actual-btn' class='login100-form-btn'>Update Image</label>
              <span id='file-chosen'>$pic</span>
              
                <script>
                  const actualBtn = document.getElementById('actual-btn');

                  const fileChosen = document.getElementById('file-chosen');

                  actualBtn.addEventListener('change', function(){
                  fileChosen.textContent = this.files[0].name
                  })
                </script>
              <br>
              <div class='container-login100-form-btn'>
						    <button class='login100-form-btn' name='submit'>Update</button>
					    </div>
            </form>
                ";

                   

          if(isset($_POST['submit']))
          {
            $event_name=$_POST['name'];
            $event_theme=$_POST['theme'];
            $event_date=$_POST['date'];
            $event_details=$_POST['content'];
            $upload_image = $_FILES['upload_image']['name'];

            if(file_exists("reportImages/$upload_image"))
            {
              $update="UPDATE `event` SET `Event_name`='$event_name',`Event_theme`='$event_theme',`Event_date`='$event_date',`Event_details`='$event_details' WHERE `Event_id`='$event_id'";
            }else{
              $image_tmp = $_FILES['upload_image']['tmp_name'];
              srand(mktime());
              $random = rand(0,999999);

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
                  $flag = move_uploaded_file($image_tmp, "reportImages/$event_name.$random.png");
                } else {
                  foreach($errors as $error) {
                      echo '<script>alert("'.$error.'");</script>';
                      echo "<script>window.open('update_report_form.php','_self')</script>";
                  }
          
                  die(); //Ensure no more processing is done
                }
               if($flag)
               {
                $update="UPDATE `event` SET `Event_name`='$event_name',`Event_theme`='$event_theme',`Event_date`='$event_date',`Event_details`='$event_details',`pic1`='$event_name.$random.png' WHERE `Event_id`='$event_id'";
               }        
              }
            }             
              $result=mysqli_query($link,$update);
              if($result)
              {
                echo "<script>alert('Update Successful')</script>";
                unlink("reportImages/$db_pic");
                echo "<script>window.open('view_reported_events.php','_self')</script>";
  
              }else{
                echo "<script>alert('Update Not Successful')</script>";
              }
            }
          }
        }
      ?>
            
        </div>
      </div>
    </div>      
  </body>
</html>