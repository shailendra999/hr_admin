<?php

include("inc/check_session.php");
include("inc/dbconnection.php");
include("inc/function.php");

if (isset($_POST['save_data']) == 1) {
    $arrear_date = $_POST['arrear_month'];
    $emp_t = $_POST['emp_id'];
    $select = mysql_query("select emp_id from mpc_employee_master where ticket_no = '$emp_t'");
    $fetch = mysql_fetch_array($select);
    $emp_id = $fetch['emp_id'];
    $arrear_res = $_POST['arrear_res'];
    $pay_date = $_POST['pay_date'];
    $arrear_amount = $_POST['arrear_amount'];
//    echo "INSERT INTO `mpc_arrear_master` (`arrear_month`, `emp_id`, `arrear_pay`, `arrear_amount`,`arrear_reason`,`status`) VALUES ('$arrear_date', '$emp_id', '$pay_date', '$arrear_amount', '$arrear_res','1')";

    $insert = mysql_query("INSERT INTO `mpc_arrear_master` (`arrear_month`, `emp_id`, `arrear_pay`, `arrear_amount`,`arrear_reason`,`status`) VALUES ('$arrear_date', '$emp_id', '$pay_date', '$arrear_amount', '$arrear_res','1')");
    ?>

    <script>
        window.location.href = 'arrear.php';
    </script>

    <?php

}
?>
	