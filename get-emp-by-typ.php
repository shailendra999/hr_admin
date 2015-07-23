<? include ("inc/dbconnection.php"); ?>
<?php
if (isset($_GET['id'])) {
    $empType = $_GET['id'];
    if ($empType == "all") {
        $filter_sql = '';
    } else {
        $filter_sql = "AND mpc_employee_master.empType = '$empType'";
    }
}
if (isset($_GET['id']) && isset($_GET['str'])) {
    $empType = $_GET['id'];
    $ticket = $_GET['str'];
    if ($empType == "all") {
        $empType = '';
        $sql = mysql_query("SELECT mpc_employee_master.*, mpc_department_master.* FROM mpc_department_master,mpc_employee_master WHERE mpc_department_master.rec_id = mpc_employee_master.department AND mpc_employee_master.ticket_no like '%$ticket%'");
    }
} else {
    $sql = mysql_query("SELECT mpc_employee_master.*, mpc_department_master.* FROM mpc_department_master,mpc_employee_master WHERE mpc_department_master.rec_id = mpc_employee_master.department AND mpc_employee_master.empType = '$empType' AND mpc_employee_master.ticket_no like '%$ticket%'");
}
while ($row_emp = mysql_fetch_array($sql)) {
    ?>
    <tr>
        <td>
            <?php echo $row_emp['ticket_no']; ?>
        </td>
        <td>
            <?php echo ucfirst($row_emp['first_name']) . "&nbsp;" . ucfirst($row_emp['last_name']); ?>
        </td>
        <td>
            <?php
            $q = mysql_query("Select * from mpc_department_master where rec_id = $row_emp[department]");
            $row = mysql_fetch_array($q);
            echo ucfirst($row['department_name']);
            ?>
        </td>
        <td>
            <div class="categoryitems subLinks" style="height:auto;">
                <select name="attendace[]" id="attendace" onchange="myfunction(this.value)">
                    <option value="P" <?php
                    if ($data['attendance'][$i] == $a['leave_name']) {
                        echo 'selected="selected"';
                    }
                    ?>>Present</option>
                    <option value="P/2">Present/2</option>
                    <option value="A">Absent</option>
                    <option value="HCL">Half Day</option>
                    <option value="C/OFF">C/OFF</option>
                    <?php
                    $que = mysql_query("SELECT * FROM `mpc_leave_master` ");
                    while ($a = mysql_fetch_array($que)) {
                        ?>
                        <option value="<?php echo $a['leave_name']; ?>" <?php
                        if ($data['attendance'][$i] == $a['leave_name']) {
                            echo 'selected="selected"';
                        }
                        ?> ><?php echo $a['leave_name']; ?></option>
                            <?php } ?>
                </select>
            </div>
        </td>

    </tr>
    <?php
    $count ++;
}
?>