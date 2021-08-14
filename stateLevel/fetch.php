<?php
include('../connect.php'); 
if (isset($_POST["type"])) {

    if ($_POST["type"] == "bodyData") {
        $sqlQuery = "SELECT * FROM `districts` ORDER BY District_name ASC";
        $resultset = mysqli_query($link, $sqlQuery) or die("database error:". mysqli_error($link));
        while( $row = mysqli_fetch_array($resultset) ) {
            $output[] = [
                'id' => $row["District_id"],
                'name' => $row["District_name"],
            ];
        }
        echo json_encode($output); 
    } else if($_POST["type"] == "districtLeveldata"){
        $sqlQuery2 = "SELECT * FROM `taluk` WHERE District_id = '" . $_POST["category_id"] . "' ORDER BY Taluk_name ASC";
        $resultset2 = mysqli_query($link, $sqlQuery2) or die("database error:". mysqli_error($link));
        while( $row2 = mysqli_fetch_array($resultset2) ) {
            $output[] = [
                'id' => $row2["Taluk_id"],
                'name' => $row2["Taluk_name"],
            ];
        }
        echo json_encode($output);
    }else{
        $sqlQuery3 = "SELECT * FROM `panchayat` WHERE District_id = '". $_POST["category_id"]."' AND Taluk_id = '" . $_POST["category2_id"] . "' ORDER BY Panchayat_name ASC";
        $resultset3 = mysqli_query($link, $sqlQuery3) or die("database error:". mysqli_error($link));
        while( $row3 = mysqli_fetch_array($resultset3) ) {
            $output[] = [
                'id' => $row3["Panchayat_id"],
                'name' => $row3["Panchayat_name"],
            ];
        }
        echo json_encode($output);
    }
}
  
?>