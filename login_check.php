<?php


    session_start();
 include("inc/dbconnection.php");
/*  $conn = @mysql_connect('localhost', 'root', '')or die("Couldn't connect to server.");
$db = @mysql_select_db('ssofts_lss', $conn)or die("Couldn't select database.");*/


    $login = $_POST['UserId'];
    $password = $_POST['Password'];
    if (isset($_REQUEST['page'])) {
        $page = $_REQUEST['page'];
		
    }
    if (isset($_REQUEST['emp_id'])) {
        $emid = $_REQUEST['emp_id'];
    }

    $query = "select * from    ".$mysql_table_prefix."login_master where UserName = '$login' and password = '$password'";
    $result = mysql_query($query) or die("Query Failed :" . mysql_error());
    $line = mysql_fetch_array($result);

    $UserName = $line['UserName'];
    $pass = $line['Password'];
    $LoginMasterId = $line['LoginId'];
    $UserType = $line['UserType'];
    $lower_user_type = strtolower($UserType);
	var_dump($lower_user_type );
    if ($login == $UserName && $password == $pass) {
        $_SESSION[$lower_user_type . '_mahima_session_rec_id']    = $line['LoginId'];
        $_SESSION[$lower_user_type . '_mahima_session_user_name'] = $line['UserName'];
        $_SESSION[$lower_user_type . '_mahima_session_user_type'] = $line['UserType'];
        $_SESSION["mahima_session_user_type"] = $lower_user_type;

        if (isset($_REQUEST['page'])) {
            $url = $page;
            echo "<script>";
            echo "location.href ='" . $url . "'";
            echo "</script>";
        } else {
            echo "<script>";
            echo "location.href = '" . $lower_user_type . "_homepage.php'";
            echo "</script>";
        }
    } 
	
	
	
	else {
		//session_destroy();
        if (isset($_SESSION[$lower_user_type . '_mahima_session_rec_id'])) {
            $id = $_SESSION[$lower_user_type . '_mahima_session_rec_id'];
            session_unset($id);
        }

        echo "<script>";
        echo "location.href = 'index.php?err=1'";
        echo "</script>";
    }
	
exit;
?>