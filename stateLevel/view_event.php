<?php
include("../connect.php");
session_start();
if(!(isset($_SESSION['St_user_id'])))
{
  header("location:../login.php");

}
$user_session = $_SESSION['St_user_id'];
?>
<!DOCTYPE html>
<html>
  <head>
    <title>View Events</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
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
    <link rel="stylesheet" type="text/css" href="../report-css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css" />
    <link rel="canonical" href="https://getbootstrap.com/docs/3.4/examples/starter-template/">
    <link rel="stylesheet" type="text/css" href="../css/main_table.css">

  <!--===============================================================================================-->
  </head>
  <body>
    <div class="limiter">
    <?php include '../header/header.php' ?>
      <div class="container-login100">
        <span class="login100-form-title">-> List of Events <-</span>
        <div class = "container">
          <form method="POST" action='view_event.php'>
            <div class="row">

              <div class="col-md-2">
                <div name="state" id="state" class="form-control" title="State">State </div>
              </div>
              <div class="col-md-2">
                  <select name="district" value =NULL data-live-search="true" id="district" class="form-control" title="Select district"> </select>
              </div>
              <div class="col-md-2">
                <select name="taluk" value=NULL data-live-search="true" id="taluk" class="form-control" title="Select taluk"> </select>
              </div>
              <div class="col-md-2">
                  <select name="panchayat" value=NULL data-live-search="true" id="panchayat" class="form-control" title="Select panchayat"> </select>
              </div>
              <div class="col-md-4">
						      <button class="login100-form-btn" name="apply">APPLY</button>
              </div>

            </div>
          </form>
                        
        <table>
						<thead>
							<tr class="table100-head">
								<th class="column1">Date of reporting</th>
								<th class="column2">Date of Event</th>
								<th class="column3">Event Name</th>
								<th class="column4">Event Theme</th>
								<th class="column5">Image</th>
							</tr>
						</thead>
						<tbody>
							<?php
              if(isset($_POST['apply']))
              {
                if($_POST['district']==NULL && $_POST['taluk']==NULL && $_POST['panchayat']==NULL)
                {
                  $sql = "SELECT * FROM `event` WHERE `User_id`='admin' ORDER BY `Event_date` LIMIT 20";
                }else if($_POST['district']!=NULL && $_POST['taluk']==NULL && $_POST['panchayat']==NULL)
                {
                  $post_district = $_POST['district'];
                  $sql = "SELECT * FROM `districts` INNER JOIN `event` ON `District_user_id`=`User_id` WHERE `District_id`='$post_district'";
                }else if($_POST['district']!=NULL && $_POST['taluk']!=NULL && $_POST['panchayat']==NULL)
                {
                  $post_district = $_POST['district'];
                  $post_taluk = $_POST['taluk'];
                  $sql = "SELECT * FROM `taluk` INNER JOIN `event` ON `Taluk_user_id`=`User_id` WHERE `District_id`='$post_district' AND `Taluk_id`='$post_taluk'";
                }else if($_POST['district']!=NULL && $_POST['taluk']!=NULL && $_POST['panchayat']!=NULL)
                {
                  $post_district = $_POST['district'];
                  $post_taluk = $_POST['taluk'];
                  $post_panchayat = $_POST['panchayat'];
                  $sql = "SELECT * FROM `panchayat` INNER JOIN `event` ON `Panchayat_user_id`=`User_id` WHERE `District_id`='$post_district' AND `Taluk_id`='$post_taluk' AND `Panchayat_id`='$post_panchayat'";
                }else{
                  echo "<script>alert('Please select the district')</script>";
                  echo "<script>window.open('view_event.php','_self')</script>";

                }
                  $run = mysqli_query($link,$sql);
                  while($rows = mysqli_fetch_array($run))
                  {
                    $event_id = $rows['Event_id'];
                    $rep_date = $rows['reporting_date'];
                    $event_date = $rows['Event_date'];
                    $event_name = $rows['Event_name'];
                    $event_theme = $rows['Event_theme'];
                    $event_pic = $rows['pic1'];
                    
                    echo "<tr>
                    <td class='column1'>$rep_date</td>
                    <td class='column2'>$event_date</td>
                    <td class='column3'>$event_name</td>
                    <td class='column4'>$event_theme</td>
                    <td class='column5'><a href='../reportImages/$event_pic' target='_blank'><img id='myImg' src='../reportImages/$event_pic' alt='No img' style='width:200%;max-width:300px;padding:3px'></a></td>
                    </tr>

                    ";
                    
                  }
              }
					
							?>						
						</tbody>
					</table>
        </div>
      </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>


    <script>
            $(document).ready(function () {
                $("#district").selectpicker();
  
                $("#taluk").selectpicker();

                $("#panchayat").selectpicker();
  
                load_data("bodyData");
  
                function load_data(type, category_id = "",category2_id="") {
                    $.ajax({
                        url: "fetch.php",
                        method: "POST",
                        data: { type: type, category_id: category_id,category2_id: category2_id},
                        dataType: "json",
                        success: function (data) {
                            var html = "";
                            for (var count = 0; count < data.length; count++) {
                                html += '<option value="' + data[count].id + '">' + data[count].name + "</option>";
                            }
                            if (type == "bodyData") {
                                $("#district").html(html);
                                $("#district").selectpicker("refresh");
                            } else if(type == "districtLeveldata"){
                                $("#taluk").html(html);
                                $("#taluk").selectpicker("refresh");
                            } else{
                                $("#panchayat").html(html);
                                $("#panchayat").selectpicker("refresh");
                            }
                        },
                    });
                }
  
                $(document).on("change", "#district", function () {
                    var category_id = $("#district").val();
                    load_data("districtLeveldata", category_id);
                });
                $(document).on("change","#taluk",function () {
                    var category_id = $("#district").val();
                    var category2_id = $("#taluk").val();
                    load_data("panchayatLeveldata",category_id,category2_id);
                })

            });
</script>
 
  </body>
</html>