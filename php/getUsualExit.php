<?php
    session_start();
    if(!isset($_SESSION["u_id"])){
        header("location:login.php");
    }else{
	    include("../connect.php");
	    $sql = "SELECT COUNT";
	    if ($result = $conn->query($sql)) {
	    	$dataArray = array();
            while ($row_3 = mysqli_fetch_assoc($result)){
                $dataArray[] = $row_3;
            }
            echo json_encode($dataArray);
	    }else{
		    echo $conn->error;
	    }
        mysqli_close($conn);
    }
?>