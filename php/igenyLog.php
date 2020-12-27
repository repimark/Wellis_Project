<?php
    session_start();
    if(!isset($_SESSION["u_id"])){
        header("location:login.php");
    }else{
	    include("../connect.php");
	    $muvelet = $conn->real_escape_string($_POST["muv"]);
        $username = $conn->real_escape_string($_SESSION["u_name"]);
        $datum = $conn->real_escape_string($_POST["datum"]);
        $pozicio = $conn->real_escape_string($_POST["pid"]);
	    $sql = "INSERT INTO `igenyvaltozas_log` (`iv_id`, `iv_datum`, `u_name`, `iv_muvelet`, `p_id`) VALUES (NULL, '$datum', '$username', '$muvelet', '$pozicio')";
	    if ($conn->query($sql)) {
	    	echo "Sikerült";
	    }else{
		    echo $conn->error;
	    }
        mysqli_close($conn);
    }
?>