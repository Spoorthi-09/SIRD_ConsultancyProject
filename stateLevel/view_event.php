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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    <link rel="stylesheet" type="text/css" href="../css/main_table.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>

  <!--===============================================================================================-->
  </head>
  <style>
    .btn-outline-success{color:#28a745;background-color:transparent;background-image:none;border-color:#28a745}.btn-outline-success:hover{color:#fff;background-color:#28a745;border-color:#28a745}.btn-outline-success.focus,.btn-outline-success:focus{box-shadow:0 0 0 3px rgba(40,167,69,.5)}.btn-outline-success.disabled,.btn-outline-success:disabled{color:#28a745;background-color:transparent}.btn-outline-success.active,.btn-outline-success:active,.show>.btn-outline-success.dropdown-toggle{color:#fff;background-color:#28a745;border-color:#28a745}
    .my-2 {float:right;}

  </style>
  <body>
    
    <div class="limiter">
    <?php include '../header/header.php' ?>
      <div class="container-login100">
        <span class="login100-form-title" id="display"></span>
        <marquee id="marquee" style="color:black"><h3></h3></marquee>
        <div class = "container">
          <form method="POST" enctype='multipart/form-data'>

            <div class="row">
              <div class="col-md-3">
                <div name="state" id="state" class="form-control" title="State">State </div>            
              </div>
              <div class="col-md-3">
                  <select name="district" value =NULL data-live-search="true" id="district" class="form-control" title="Select district"> </select>
              </div>
              <div class="col-md-3">
                <select name="taluk" value=NULL data-live-search="true" id="taluk" class="form-control" title="Select taluk"> </select>
              </div>
              <div class="col-md-3">
                  <select name="panchayat" value=NULL data-live-search="true" id="panchayat" class="form-control" title="Select panchayat"> </select>
              </div>
            </div>

            <br>
            <div class="row">
              <div class="col-md-3">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar">
                    </i>
                  </div>
                  <input class="form-control" id="from_date" name="from_date" placeholder="From Date" type="text"/>
                </div>  
              </div>
              <div class="col-md-3">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar">
                    </i>
                  </div>
                  <input class="form-control" id="to_date" name="to_date" placeholder="To Date" type="text"/>
                </div> 
              </div>
              <div class="col-md-3">
						      <!-- <button class="login100-form-btn" name="download">DOWNLOAD EVENTS</button> -->
                  <center><label><input type="checkbox" name="download" id="">Download</label></center>
              </div>
              <div class="col-md-3">
						      <button class="login100-form-btn" name="apply">APPLY</button>
              </div>
            </div>

          </form>
                        
						<?php
              if(isset($_POST['apply']))
              {
                
                $output="";

                // <!--====================State filter=================================================-->

                if($_POST['district']==NULL && $_POST['taluk']==NULL && $_POST['panchayat']==NULL)
                {
                  // ( To Date and From Date missing ) or ( Only To Date missing)
                  if(($_POST['from_date']==NULL && $_POST['to_date']==NULL) || ($_POST['from_date']==NULL && $_POST['to_date']!=NULL))
                  {
                    $sql = "SELECT * FROM `event` INNER JOIN `state` WHERE `User_id`='admin' ORDER BY `Event_date` DESC LIMIT 20";
                    echo "<script>var marquee = document.getElementById('marquee');
                                marquee.innerText = 'Latest 20 events are displayed!'</script>";
                  }
                  // To Date missing
                  else if($_POST['from_date']!=NULL && $_POST['to_date']==NULL){
                    $datestring = $_POST['from_date'];
                    $date_arr = explode('/',$datestring);
                    $sql = "SELECT * FROM `event` INNER JOIN `state` WHERE `User_id`='admin' AND `Event_date` BETWEEN '$date_arr[2]-$date_arr[1]-$date_arr[0]' AND ('$date_arr[2]-$date_arr[1]-$date_arr[0]' + INTERVAL 30 DAY) ORDER BY `Event_date`";
                    echo "<script>var marquee = document.getElementById('marquee');
                                marquee.innerText = 'Latest 30 events from $datestring are displayed!'</script>";
                  }
                  // To Date and From Date specified
                  else if($_POST['from_date']!=NULL && $_POST['to_date']!=NULL)
                  {
                    $from_date = $_POST['from_date'];
                    $to_date = $_POST['to_date'];
                    $fromarr = explode('/',$from_date);
                    $toarr = explode('/',$to_date);
                    $sql = "SELECT * FROM `event` INNER JOIN `state` WHERE `User_id`='admin' AND `Event_date` BETWEEN '$fromarr[2]-$fromarr[1]-$fromarr[0]' AND '$toarr[2]-$toarr[1]-$toarr[0]' ORDER BY `Event_date`";
                    echo "<script>var marquee = document.getElementById('marquee');
                                marquee.innerText = 'Events from $from_date to $to_date are displayed!'</script>";
                  }
                  
                  $run = mysqli_query($link,$sql);
                  $row_sql = mysqli_fetch_array($run);
                  $location = $row_sql['St_name'];
                  echo "<script>var display = document.getElementById('display');
                                display.innerText = 'SIRD'</script>";
                }

                // <!--====================District filter=================================================-->

                else if($_POST['district']!=NULL && $_POST['taluk']==NULL && $_POST['panchayat']==NULL)
                {
                  $post_district = $_POST['district'];

                  // ( To Date and From Date missing ) or ( Only To Date missing)
                  if(($_POST['from_date']==NULL && $_POST['to_date']==NULL) || ($_POST['from_date']==NULL && $_POST['to_date']!=NULL))
                  {
                    $sql = "SELECT * FROM `districts` INNER JOIN `event` ON `District_user_id`=`User_id` WHERE `District_id`='$post_district' ORDER BY `Event_date` DESC LIMIT 20";
                    echo "<script>var marquee = document.getElementById('marquee');
                                marquee.innerText = 'Latest 20 events are displayed!'</script>";
                  }
                  // To Date missing
                  else if($_POST['from_date']!=NULL && $_POST['to_date']==NULL){
                    $datestring = $_POST['from_date'];
                    $date_arr = explode('/',$datestring);
                    $sql = "SELECT * FROM `districts` INNER JOIN `event` ON `District_user_id`=`User_id` WHERE `District_id`='$post_district' AND `Event_date` BETWEEN '$date_arr[2]-$date_arr[1]-$date_arr[0]' AND ('$date_arr[2]-$date_arr[1]-$date_arr[0]' + INTERVAL 30 DAY) ORDER BY `Event_date`";
                    echo "<script>var marquee = document.getElementById('marquee');
                                marquee.innerText = 'Latest 30 events from $datestring are displayed!'</script>";
                  }
                  // To Date and From Date specified
                  else if($_POST['from_date']!=NULL && $_POST['to_date']!=NULL)
                  {
                    $from_date = $_POST['from_date'];
                    $to_date = $_POST['to_date'];
                    $fromarr = explode('/',$from_date);
                    $toarr = explode('/',$to_date);
                    $sql = "SELECT * FROM `districts` INNER JOIN `event` ON `District_user_id`=`User_id` WHERE `District_id`='$post_district' AND `Event_date` BETWEEN '$fromarr[2]-$fromarr[1]-$fromarr[0]' AND '$toarr[2]-$toarr[1]-$toarr[0]' ORDER BY `Event_date`";
                    echo "<script>var marquee = document.getElementById('marquee');
                                marquee.innerText = 'Events from $from_date to $to_date are displayed!'</script>";
                  }
                  $run = mysqli_query($link,$sql);
                  $row_sql = mysqli_fetch_array($run);
                  $location = $row_sql['District_name'];

                  $sql1 = "SELECT `District_name` from `districts` WHERE `District_id`='$post_district'";
                  $run1 = mysqli_query($link,$sql1);
                  $row1 = mysqli_fetch_array($run1);
                  $district = $row1['District_name'];
                  echo "<script>var display = document.getElementById('display');
                                display.innerText = 'SIRD -> '+ '$district'</script>";
                }

                // <!--====================Taluk filter=================================================-->

                else if($_POST['district']!=NULL && $_POST['taluk']!=NULL && $_POST['panchayat']==NULL)
                {
                  $post_district = $_POST['district'];
                  $post_taluk = $_POST['taluk'];

                  // ( To Date and From Date missing ) or ( Only To Date missing)
                  if(($_POST['from_date']==NULL && $_POST['to_date']==NULL) || ($_POST['from_date']==NULL && $_POST['to_date']!=NULL)){
                    $sql = "SELECT * FROM `taluk` INNER JOIN `event` ON `Taluk_user_id`=`User_id` WHERE `District_id`='$post_district' AND `Taluk_id`='$post_taluk' ORDER BY `Event_date` DESC LIMIT 20";
                    echo "<script>var marquee = document.getElementById('marquee');
                                marquee.innerText = 'Latest 20 events are displayed!'</script>";
                  }
                  // To Date missing
                  else if($_POST['from_date']!=NULL && $_POST['to_date']==NULL){
                    $datestring = $_POST['from_date'];
                    $date_arr = explode('/',$datestring);
                    $sql = "SELECT * FROM `taluk` INNER JOIN `event` ON `Taluk_user_id`=`User_id` WHERE `District_id`='$post_district' AND `Taluk_id`='$post_taluk' AND `Event_date` BETWEEN '$date_arr[2]-$date_arr[1]-$date_arr[0]' AND ('$date_arr[2]-$date_arr[1]-$date_arr[0]' + INTERVAL 30 DAY) ORDER BY `Event_date`";
                    echo "<script>var marquee = document.getElementById('marquee');
                                marquee.innerText = 'Latest 30 events from $datestring are displayed!'</script>";
                  }
                  // To Date and From Date specified
                  else if($_POST['from_date']!=NULL && $_POST['to_date']!=NULL)
                  {
                    $from_date = $_POST['from_date'];
                    $to_date = $_POST['to_date'];
                    $fromarr = explode('/',$from_date);
                    $toarr = explode('/',$to_date);
                    $sql = "SELECT * FROM `taluk` INNER JOIN `event` ON `Taluk_user_id`=`User_id` WHERE `District_id`='$post_district' AND `Taluk_id`='$post_taluk' AND `Event_date` BETWEEN '$fromarr[2]-$fromarr[1]-$fromarr[0]' AND '$toarr[2]-$toarr[1]-$toarr[0]' ORDER BY `Event_date`";
                    echo "<script>var marquee = document.getElementById('marquee');
                                marquee.innerText = 'Events from $from_date to $to_date are displayed!'</script>";
                  }
                  
                  $run = mysqli_query($link,$sql);
                  $row_sql = mysqli_fetch_array($run);
                  $location = $row_sql['Taluk_name'];

                  $sql1 = "SELECT `District_name`,`Taluk_name` FROM `districts` INNER JOIN `taluk` ON `districts`.`District_id`=`taluk`.`District_id` WHERE `Taluk_id`='$post_taluk'";
                  $run1 = mysqli_query($link,$sql1);
                  $row1 = mysqli_fetch_array($run1);
                  $district = $row1['District_name'];
                  $taluk = $row1['Taluk_name'];
                  echo "<script>var display = document.getElementById('display');
                                display.innerText = 'SIRD -> '+ '$district -> '+ '$taluk'</script>";
                }
                
                // <!--====================Panchayat filter=================================================-->

                else if($_POST['district']!=NULL && $_POST['taluk']!=NULL && $_POST['panchayat']!=NULL)
                {
                  $post_district = $_POST['district'];
                  $post_taluk = $_POST['taluk'];
                  $post_panchayat = $_POST['panchayat'];

                  // ( To Date and From Date missing ) or ( Only To Date missing)
                  if(($_POST['from_date']==NULL && $_POST['to_date']==NULL) || ($_POST['from_date']==NULL && $_POST['to_date']!=NULL))
                  {
                    $sql = "SELECT * FROM `panchayat` INNER JOIN `event` ON `Panchayat_user_id`=`User_id` WHERE `District_id`='$post_district' AND `Taluk_id`='$post_taluk' AND `Panchayat_id`='$post_panchayat' ORDER BY `Event_date` DESC LIMIT 20";
                    echo "<script>var marquee = document.getElementById('marquee');
                                marquee.innerText = 'Latest 20 events are displayed!'</script>";
                  }
                  // To Date missing
                  else if($_POST['from_date']!=NULL && $_POST['to_date']==NULL){
                    $datestring = $_POST['from_date'];
                    $date_arr = explode('/',$datestring);
                    $sql = "SELECT * FROM `panchayat` INNER JOIN `event` ON `Panchayat_user_id`=`User_id` WHERE `District_id`='$post_district' AND `Taluk_id`='$post_taluk' AND `Panchayat_id`='$post_panchayat' AND `Event_date` BETWEEN '$date_arr[2]-$date_arr[1]-$date_arr[0]' AND ('$date_arr[2]-$date_arr[1]-$date_arr[0]' + INTERVAL 30 DAY) ORDER BY `Event_date`";
                    echo "<script>var marquee = document.getElementById('marquee');
                                marquee.innerText = 'Latest 30 events from $datestring are displayed!'</script>";
                  }
                  // To Date and From Date specified
                  else if($_POST['to_date']!=NULL && $_POST['from_date']!=NULL)
                  {
                    $from_date = $_POST['from_date'];
                    $to_date = $_POST['to_date'];
                    $fromarr = explode('/',$from_date);
                    $toarr = explode('/',$to_date);
                    $sql = "SELECT * FROM `panchayat` INNER JOIN `event` ON `Panchayat_user_id`=`User_id` WHERE `District_id`='$post_district' AND `Taluk_id`='$post_taluk' AND `Panchayat_id`='$post_panchayat' AND `Event_date` BETWEEN '$fromarr[2]-$fromarr[1]-$fromarr[0]' AND '$toarr[2]-$toarr[1]-$toarr[0]' ORDER BY `Event_date`";
                    echo "<script>var marquee = document.getElementById('marquee');
                                marquee.innerText = 'Events from $from_date to $to_date are displayed!'</script>";
                  }
                  
                  $run = mysqli_query($link,$sql);
                  $row_sql = mysqli_fetch_array($run);
                  $location = $row_sql['Panchayat_name'];

                  $sql1 = "SELECT `District_name`,`Taluk_name`,`Panchayat_name` FROM `districts` INNER JOIN `panchayat` ON `districts`.`District_id`=`panchayat`.`District_id` INNER JOIN `taluk` ON `taluk`.`Taluk_id`=`panchayat`.`Taluk_id` WHERE `Panchayat_id`='$post_panchayat'";
                  $run1 = mysqli_query($link,$sql1);
                  $row1 = mysqli_fetch_array($run1);
                  $district = $row1['District_name'];
                  $taluk = $row1['Taluk_name'];
                  $panchayat = $row1['Panchayat_name'];
                  echo "<script>var display = document.getElementById('display');
                                display.innerText = 'SIRD -> '+ '$district -> '+ '$taluk -> '+'$panchayat'</script>";

                }else{
                  echo "<script>alert('Please select the district')</script>";
                  echo "<script>window.open('view_event.php','_self')</script>";

                }

                $output .="<table id='tb1demo'>
                <thead>
                  <tr class='table100-head'>
                    <th class='column1'>Location</th>
                    <th class='column2'>Date of Event</th>
                    <th class='column3'>Event Name</th>
                    <th class='column4'>Event Theme</th>
                    <th class='column5'>Image</th>
                  </tr>
                </thead>
                <tbody>";

                  while($rows = mysqli_fetch_array($run))
                  {
                    $event_id = $rows['Event_id'];
                    $rep_date = $rows['reporting_date'];
                    $event_date = $rows['Event_date'];
                    $event_name = $rows['Event_name'];
                    $event_theme = $rows['Event_theme'];
                    $event_pic = $rows['pic1'];
                    
                    $output .= "<tr>
                    <td class='column1'>$location</td>
                    <td class='column2'>$event_date</td>
                    <td class='column3'>$event_name</td>
                    <td class='column4'>$event_theme</td>
                    <td class='column5'><a href='../reportImages/$event_pic' target='_blank'><img id='myImg' src='../reportImages/$event_pic' alt='No img' style='width:100%;max-width:100px;max-height:100px;padding:3px'></a></td>
                    </tr>

                    ";
                    
                  }
                  $output .= "</tbody>
                          </table>"; 
                              
                    
                    echo $output;
                }
                if(isset($_POST['download']))
                {
                  echo "<script>
                  $('#tb1demo').table2excel({
                    filename:'$location.xls',
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: false
                });
                    </script>";
                }
					
							?>						
        </div>
      </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>

    <script>
            $(document).ready(function () {

              

                $("#district").selectpicker();
  
                $("#taluk").selectpicker();

                $("#panchayat").selectpicker();
  
                load_data("bodyData");

                var to_date=$('input[name="to_date"]'); //our date input has the name "date"
                var from_date=$('input[name="from_date"]'); //our date input has the name "date"
                var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
                var options={
                  format: 'dd/mm/yyyy',
                  container: container,
                  todayHighlight: true,
                  autoclose: true,
                };
                to_date.datepicker(options).val();
                from_date.datepicker(options).val();
  
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
                $('.datepicker').datepicker();

            });
</script>

  </body>
</html>