<?
include ("inc/dbconnection.php");
include ("inc/function.php");
$id = "";
$start = 0;
$id = $_GET["id"];
$check = $_GET["str"];

$deduction_date = "";
if ($check == "name") {
    $sql = "SELECT mpc_employee_master.*,mpc_salary_master.* FROM  " . $mysql_table_prefix . "employee_master ,mpc_salary_master where mpc_employee_master.emp_id=mpc_salary_master.emp_id and first_name != '' and first_name like '$id%' order by first_name";
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
}
if ($check == "id") {
    $sql = "SELECT mpc_employee_master.*,mpc_salary_master.*,mpc_salary_master.rec_id as salary_id FROM  " . $mysql_table_prefix . "employee_master ,mpc_salary_master where mpc_employee_master.emp_id=mpc_salary_master.emp_id and ticket_no like '%$id%' and first_name != '' order by ticket_no ";
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
} elseif ($check == "employee") {
    $sql = "SELECT mpc_employee_master.*,mpc_department_master.*,mpc_salary_master.*,mpc_salary_master.rec_id as salary_id FROM  " . $mysql_table_prefix . "employee_master,mpc_department_master,mpc_salary_master where mpc_employee_master.emp_id=mpc_salary_master.emp_id and mpc_department_master.rec_id = mpc_employee_master.department and department_name like '%$id%' and first_name != '' order by from_date ";
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
}
if (mysql_num_rows($result) > 0) {
    $sno = 1;
    ?>
    <form id="frm_emp_list" name="frm_emp_list" method="post" action="">
        <table width="100%" align="center" cellpadding="1" cellspacing="1" border="0" class="border employee_table" >
            <tr class="blackHead">
                <th align="center">Employee Id</th>
                <th align="center">Employee Name</th>
                <th align="center">Basic</th>
                <th align="center">HRA</th>
                <th align="center">LTA</th>
                <th align="center">convince</th>
                <th align="center">Medical</th>
                <th align="center">S/A</th>
                <th align="center">P/Tax</th>
                <th align="center">TDS</th>
                <th align="center">O/D</th>
                <th align="center">From</th>
                <th align="center">To</th>
            </tr>
            <?
            while ($row = mysql_fetch_array($result)) {
                ?>
                <tr <? if ($sno % 2 == 1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
                    <td align="center">
                        <?= $row["ticket_no"] ?>
                    </td>
                    <td align="center">
                        <?= $row["first_name"] ?> <?= $row["last_name"] ?> 
                    </td>
                    <td align="center">
                        <?= $row["basic"] ?>
                    </td>
                    <td align="center">
                        <?= $row["hra"] ?>
                    </td>
                    <td align="center">
                        <?= $row["leave_travel_allow"] ?>
                    </td>
                    <td align="center">
                        <?= $row["convence"] ?>
                    </td>
                    <td align="center">
                        <?= $row["medical"] ?>
                    </td>
                    <td align="center">
                        <?= $row["side_allowance"] ?>
                    </td>
                    <td align="center">
                        <?= $row["professional_tax"] ?>
                    </td>
                    <td align="center">
                        <?= $row["tds"] ?>
                    </td>
                    <td align="center">
                        <?= $row["other_deductions"] ?>
                    </td>
                    <td align="center">
                        <?= getDatetime($row["from_date"]) ?>
                    </td>
                    <td align="center">
                        <?
                        if ($row["to_date"] == '0000-00-00') {
                            echo 'TODAY';
                        } else {
                            echo getDatetime($row["to_date"]);
                        }
                        ?>
                    </td>
                </tr>
                <?
            }
            $emp_id = $row["emp_id"];
            $sno++;
            ?>   
        </table>
    </form>
    <?
} else {
    ?>
    <table width="100%" align="center" cellpadding="2" cellspacing="2" border="0" class="border">
        <tr class="blackHead Nosalary_table">
            <th align="center">No Salary Defined</th>
        </tr>
    </table>
    <?
}
?>
