<? include ("inc/hr_header.php"); ?>
<?
$Message = "";
$dept_id = "";
?>
<script>
    function overlay(RecordId)
    {
        e1 = document.getElementById("overlay");
        document.getElementById("hidden_overlay").value = RecordId;
        e1.style.visibility = (e1.style.visibility == "visible") ? "hidden" : "visible";

    }
</script>
<?
$Page = "add_designation.php";
$PageTitle = "Add Designation";
$PageFor = "Designation";
$PageKey = "rec_id";
$PageKeyValue = "";
$Message = "";
if (isset($_POST["btn_submit"])) {
    $PageKeyValue = $_POST[$PageKey];
    $Name = $_POST["Name"];
    $employee_type = $_POST["employee_type"];
    $ref_dep = $_POST["ref_dep"];
    if ($PageKeyValue == "") {
        $sql = "insert into mpc_designation_master set designation_name = '$Name',emp_category = '$employee_type',department_id = '$ref_dep'";
        mysql_query($sql) or die("Error in " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
        $Message = "$PageFor Inserted";
    } else {
        if ($mode != "subcategory") {
            $sql = "update mpc_designation_master set designation_name = '$Name',emp_category = '$employee_type',department_id = '$ref_dep'
			where $PageKey = '$PageKeyValue'";
            mysql_query($sql) or die("Error in " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
            $Message = "$PageFor Updated";
        }
    }
    //redirect("$Page?Message=$Message");
}

$PageKeyValue = "";
$ReferenceId = "";
$mode = "";
if (isset($_GET["mode"])) {
    $mode = $_GET["mode"];
}
if (isset($_GET["Message"])) {
    $Message = $_GET["Message"];
}

if (isset($_POST["btn_delete"])) {

    $PageKeyValue = $_POST["hidden_overlay"];
    $sql = "delete from mpc_designation_master where $PageKey = '" . $PageKeyValue . "'";
    mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
    $Message = "Designation Sucessfully Deleted";
    redirect("$Page?Message=$Message");
}
$employee_type = "";
$Name = "";
if (isset($_GET[$PageKey])) {
    $sql = "select * from mpc_designation_master where $PageKey = '" . $_GET[$PageKey] . "'";
    $result = mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
    if (mysql_num_rows($result) > 0) {
        $row = mysql_fetch_array($result);
        $PageKeyValue = $row[$PageKey];
        $Name = $row["designation_name"];
        $employee_type = $row["emp_category"];
        echo $department = $row["department_id"];
    }
}
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
        <td align="left" valign="top" width="230px" style="padding-top:5px;">
            <? include ("inc/setting_snb.php"); ?>
        </td>

        <td style="padding-left:5px; padding-top:5px;">
            <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                <tr>
                    <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp;Add Designation</td>
                </tr>
                <tr>
                    <td height="400px" valign="top" style="padding-top:40px; padding-left:40px;">
                        <table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td align="center" class="border">
                                    <div align="center" style="height:470px; padding-top:30px;">
                                        <div id="div_message"><?= $Message ?></div>
                                        <form id="frm_category" name="frm_category" action="<?= $Page ?>" method="post">
                                            <table align="center" cellpadding="1" cellspacing="1" border="0" width="60%" style="border:#CCCCCC solid 1px;">
                                                <tr>
                                                 <td class="paas_text" bgcolor="#E2EBF0">Employee Type</td>
                                                    <td align="left" bgcolor="#F2F7F9" style="padding-left:10px;">
                                                     <select id="employee_type" name="employee_type">
                                                     <?php 
												$que=mysql_query("select type_name from mpc_employee_type_master");
												while($row=mysql_fetch_array($que))
												 {
												 ?>
                                                            <option value="<?php echo $row['type_name']?>"  <?
                                                            if ($employee_type == $ow['type_name'] ) {
                                                                echo 'selected="selected"';
                                                            }
                                                            ?> ><?php  echo $row['type_name'];  ?> </option><?php } ?>
                                                         </select>
                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Reference Department</td>
                                                    <td>

                                                        <select id="ref_dep" name="ref_dep">
                                                            <option value="">Select Department</option>
                                                            <?php
                                                            $data = array();
                                                            $index = array();
                                                            $query = mysql_query("SELECT mpc_department_master.rec_id, mpc_department_master.reference_id, mpc_department_master.department_name FROM mpc_department_master ORDER BY department_name");

                                                            while ($row = mysql_fetch_assoc($query)) {
                                                                $id = $row["rec_id"];
                                                                $parent_id = $row["reference_id"] === 0 ? "0" : $row["reference_id"];
                                                                $data[$id] = $row;
                                                                $index[$parent_id][] = $id;
                                                            }

                                                            function display($parent_id, $level, $index1, $data1, $department) {
                                                                $parent_id = $parent_id === 0 ? "0" : $parent_id;
                                                                if (isset($index1[$parent_id])) {
                                                                    foreach ($index1[$parent_id] as $id) {
//                                                                        echo '<option value=' . $data1[$id]["rec_id"] . '>' . str_repeat("_", $level) . $data1[$id]["department_name"] . '</option>';
                                                                        ?>
                                                                        <option value='<?php echo $data1[$id]["rec_id"]; ?>'
                                                                        <?php
                                                                        if ($data1[$id]["rec_id"] == $department) {
                                                                            echo "selected";
                                                                        }
                                                                        ?>>
                                                                                    <?php echo str_repeat("_", $level) . $data1[$id]["department_name"] ?>
                                                                        </option>
                                                                        <?php
                                                                        display($id, $level + 1, $index1, $data1, $department);
                                                                    }
                                                                }
                                                            }

                                                            display(0, 0, $index, $data, $department);
                                                            ?>
                                                        </select>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="paas_text" bgcolor="#E2EBF0">Designation</td>
                                                    <td align="left" bgcolor="#F2F7F9" style="padding-left:10px;">
                                                        <input type="text" id="Name" name="Name" value="<?= $Name ?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" align="center" bgcolor="#E2EBF0" height="25">
                                                        <input type="hidden" id="mode" name="mode" value="<?= $mode ?>"/>
                                                        <input type="hidden" id="<?= $PageKey ?>" name="<?= $PageKey ?>" value="<?= $PageKeyValue ?>" />
                                                        <input type="submit" id="btn_submit" name="btn_submit" value="Submit" class="btn_bg" />
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                        <div id="div_category_list"  style="overflow:scroll;height:300px;width:650px">
                                            <table align="center" width="80%" style="border:#CCCCCC solid 1px;" cellpadding="1" cellspacing="1">
                                                <tr>
                                                    <td class="h_text">Designation Name</td>
                                                    <td class="h_text">Department Name</td>
                                                    <td class="h_text">Employee Type</td>
                                                    <td class="h_text">Edit</td>
                                                    <td class="h_text">Delete</td>
                                                </tr>
                                                <?
                                                $sql = "select * from  mpc_designation_master order by emp_category ";
                                                $result = mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
                                                if (mysql_num_rows($result) > 0) {

                                                    $num = mysql_num_rows($result) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

                                                    while ($row = mysql_fetch_array($result)) {
                                                        ?>
                                                        <tr bgcolor="#F2F7F9">
                                                            <td class="Text01">
                                                                <?= $row["designation_name"] ?>
                                                            </td>
                                                            <td class="Text01">
                                                                <?
                                                                $select = mysql_query("Select * from mpc_department_master where rec_id = $row[department_id]");
                                                                $num_rows = mysql_num_rows($select);
                                                                if ($num_rows > 0) {
                                                                    $rows = mysql_fetch_array($select);
                                                                    echo $rows['department_name'];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="Text01">
                                                                <?= $row["emp_category"] ?>
                                                            </td>
                                                            <td class="Text01">
                                                                <a href="add_designation.php?rec_id=<?= $row['rec_id'] ?>&mode=edit">
                                                                    Edit
                                                                </a>
                                                            </td>
                                                            <td class="Text01">
                                                                <a href="javascript:;" onClick="overlay(<?= $row['rec_id'] ?>);">
                                                                    Delete
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <?
                                                    }
                                                }
                                                ?>
                                            </table>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="padding-bottom:5px;"><img src="images/pageBtm.jpg" width="1000" height="10"/></td>
                </tr>
            </table>

        </td>
    </tr>
</table>
</td>
</tr>
</table>
<div id="overlay">
    <div>
        <p class="form_msg">Are you sure to delete this Designation</p>
        <form name="frm_del" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
            <input type="submit" class="submit" name="btn_delete" id="btn_delete" value="Yes" />
            <input type="button" class="submit" onClick="overlay();" name="btn_close" id="btn_close" value="No" />
        </form>
    </div>
</div>
<? include ("inc/hr_footer.php"); ?>	