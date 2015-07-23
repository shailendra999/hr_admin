<?php

////////******************  Check for session and authentication ******************////////
session_start();
if ($_SESSION["mahima_session_user_type"] != NULL) {
    $lower_user_type = $_SESSION["mahima_session_user_type"];
    $SessionLoginMasterId = $_SESSION[$lower_user_type . '_mahima_session_rec_id'];
    $SessionUserName = $_SESSION[$lower_user_type . '_mahima_session_user_name'];
    $SessionUserType = $_SESSION[$lower_user_type . '_mahima_session_user_type'];
    $SessionUserPlant = $_SESSION['session_user_plant'];
} else {
    //echo "<script language='javascript'>";
    //echo "document.location='index.php?err=2'";
    //echo "<>";
//	$newURL =   $_SERVER['HTTP_HOST'];
    header('Location:http://solutionsofts.com/demolss/index.php');
}
?>
