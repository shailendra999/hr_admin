<?php
include("inc/dbconnection.php");
$leave_id = $_REQUEST['leave'];
$designation_id = $_REQUEST['designation'];
$select = mysql_query("select * from mpc_leave_designation where leave_id = $leave_id AND designation_id = $designation_id");
if (mysql_num_rows($select) > 0) {
    echo "<p style = 'color:red'>This leave is already assigned to designation</p>";
    die;
}
$sql = mysql_query("select * from mpc_leave_master where id = $leave_id ");
?>
<select name="dll_leaves" id="dll_leaves" onchange="monthlyApplicable(this.value)">
    <?php
    while ($row = mysql_fetch_array($sql)) {
        $number_of_leaves = $row['total_leaves'];
        for ($i = 0; $i <= $number_of_leaves; $i++) {
            ?>
            <option value='<?= $i ?>'><?= $i ?></option>
            <?php
        }
    }
    ?>
</select>

