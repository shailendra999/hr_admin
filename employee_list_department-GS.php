<? include ("inc/dbconnection.php"); ?>
<? include ("inc/function.php"); ?>
<?
$id = "";
$start = 0;
$id = $_GET["id"];
$check = $_GET["str"];
$deduction_date = "";
if ($check == "name") {

    echo $sql = "SELECT mpc_employee_master.*,mpc_department_employee.*,mpc_department_master.* FROM  " . $mysql_table_prefix . "employee_master ,mpc_department_employee,mpc_department_master where mpc_employee_master.rec_id=mpc_department_employee.emp_id and mpc_department_master.department_name like '$id%' order by department_name";
    /*
      echo $sql="SELECT mpc_employee_master.*,mpc_department_employee.*,mpc_department_master.* FROM  ".$mysql_table_prefix."employee_master ,mpc_department_employee,mpc_department_master where mpc_employee_master.rec_id=mpc_department_employee.emp_id and mpc_department_master.department_name like 'OPERATION' order by department_name";
     */
    /*
      Sir ka code.........
      $sql = "select * from mpc_employee_master,mpc_department_master,mpc_department_employee where mpc_employee_master.rec_id=mpc_department_employee.rec_id AND mpc_department_employee.dept_id = mpc_department_master.rec_id AND mpc_department_master.department_name='$id%'"; */

    /*
      echo $sql ="select mpc_employee_master.*,mpc_department_master.rec_id,mpc_department_employee.emp_id,mpc_department_employee.rec_id as department_id from mpc_employee_master,mpc_department_master,mpc_department_employee where mpc_employee_master.rec_id=mpc_department_employee.emp_id and mpc_department_master.department_name like '$id%' order by department_name";
     */
    /*
      echo $sql = "SELECT mpc_employee_master.*,mpc_department_employee.* FROM  ".$mysql_table_prefix."employee_master ,mpc_department_employee where mpc_employee_master.rec_id=mpc_department_employee.emp_id and first_name or mpc_department_master.department_name like '$id%' order by first_name";
     */
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
} else {
    echo $sql = "SELECT mpc_employee_master.*,mpc_department_employee.*,mpc_department_employee.rec_id as department_id FROM  " . $mysql_table_prefix . "employee_master,mpc_department_employee where mpc_employee_master.rec_id=mpc_department_employee.emp_id and ticket_no like '$id%' order by first_name ";
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
}
if (mysql_num_rows($result) > 0) {
    $sno = 1;
    ?>
    <form id="frm_emp_list" name="frm_emp_list" method="post" action="">
        <table width="100%" align="center" cellpadding="2" cellspacing="2" border="0" class="border">
            <tr class="blackHead">
                <td align="center">Employee Id</td>
                <td align="center">Employee Name</td>
                <td align="center">Department</td>
                <td align="center">From</td>
                <td align="center">To</td>
                <td align="center">Edit</td>
                <td align="center">Delete</td>
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
                        <?= getdeptDetail('department_name', 'rec_id', $row["dept_id"]) ?>
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
                    <td align="center"><a href="javascript:;" onClick="get_frm('edit_department_list.php', '<?= $row["department_id"] ?>', 'div_edit', '')"><img src="images/Modify.png" alt="Edit" title="Edit" border="0"></a>
                    </td>
                    <td align="center"><a href="javascript:;" onClick="overlay(<?= $row["department_id"] ?>);">
                            <img src="images/Delete.png" alt="Delete" title="Delete" border="0"></a>
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
        <tr class="blackHead">
            <td align="center">No Department Defined</td>
        </tr>
    </table>
    <?
}
?>
