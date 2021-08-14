<!DOCTYPE html>
<html>
  <head>
    <title>Workplace Complaint Form</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
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
  <!--===============================================================================================-->
  </head>
  <body>
    <div class="limiter">
      <div class="container-login100">
        <!-- <div class="wrap-login100"> -->
        <span class="login100-form-title">
                -> List of Events <-
              </span>
            <div class = "container">
        <div class="row">
            <form action="" method="POST">
                            <div class="col-md-2">
                            <select name="state" data-live-search="true" id="state" class="form-control" title="Select state body">
                                <option value="all">All</option>
                                <?php
                                    if($num > 0){
                                        while($row = mysqli_fetch_array($run)){
                                ?>
                                            <option value="<?php echo $row['St_id'];?>"><?php echo $row['St_name'] ?></option>
                                <?php
                                        }
                                        }
                                ?>
                            </select>
                            </div>
                            <div class="col-md-2">
                                <select name="district" data-live-search="true" id="district" class="form-control" title="Select district"> </select>
                            </div>
                            <div class="col-md-2">
                                <select name="taluk" data-live-search="true" id="taluk" class="form-control" title="Select taluk"> </select>
                            </div>
                            <div class="col-md-2">
                                <select name="panchayat" data-live-search="true" id="panchayat" class="form-control" title="Select panchayat"> </select>
                            </div>
                            <div class="col-md-4">
                                <input type="button" value="APPLY">
                            </div>
                        </form>
                        
         <!-- </div> -->
        </div>
        </div>
        <div class="wrap-login100">
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