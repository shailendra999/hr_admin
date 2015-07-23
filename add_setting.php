<?php
include ("inc/hr_header.php");
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
    function check(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>
<?php
$Page = "add_setting.php";
$PageTitle = "Setting";
$PageFor = "Setting";
$PageKey = "id";
$PageKeyValue = "";
$Message = "";
if (isset($_POST["btn_submit"])) {
    $PageKeyValue = $_POST[$PageKey];
    /* $pl = $_POST["pl"];
      $cl = $_POST["cl"]; */
    $txt_leave = $_POST["txt_leave"];
    $emp_type = $_POST["emp_type"];
    $num_leaves = $_POST["num_leaves"];
    $lname = $_POST['lname'];
    if ($PageKeyValue == "") {
//        $sql = "insert into mpc_setting set pl = '$pl',cl = '$cl'";
        $sql = "insert into mpc_leave_master (leave_name,emp_type,total_leaves) values ('$txt_leave','$emp_type','$num_leaves')";
        mysql_query($sql) or die("Error in " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
        $Message = "$PageFor Inserted";
    } else {
        if ($mode != "subcategory") {

            $sql = "update mpc_leave_master set leave_name = '$txt_leave',emp_type = '$emp_type',total_leaves='$num_leaves' where $PageKey = '$PageKeyValue'";
            mysql_query($sql) or die("Error in " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
            $sql1 = "update mpc_attendence_master set attendance_status = '$txt_leave' where attendance_status = '$lname'";
            mysql_query($sql1) or die("Error in " . $sql1 . "<br>" . mysql_errno() . " : " . mysql_error());
            $Message = "$PageFor Updated";
        }
    }
    //redirect("$Page?Message = $Message");
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
    $sql = "delete from mpc_leave_master where $PageKey = '" . $PageKeyValue . "'";
    mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
    $Message = "Leave Sucessfully Deleted";
    redirect("$Page?Message = $Message");
}
$employee_type = "";
$pl = "";
$cl = "";
if (isset($_GET[$PageKey])) {
    $sql = "select * from mpc_leave_master where $PageKey = '" . $_GET[$PageKey] . "'";
    $result = mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
    if (mysql_num_rows($result) > 0) {
        $row = mysql_fetch_array($result);
        $PageKeyValue = $row[$PageKey];
        $employee_type = $row["emp_type"];
        $leave_name = $row["leave_name"];
        $emp_type = $row["emp_type"];
        $total_leaves = $row["total_leaves"];
    }
}
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
        <td align="left" valign="top" width="230px" style="padding-top:5px;
            ">
                <? include ("inc/setting_snb.php"); ?>
        </td>

        <td style="padding-left:5px;
            padding-top:5px;
            ">
            <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                <tr>
                    <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp;Leave Master</td>
                </tr>
                <tr>
                    <td height="400px" valign="top" style="padding-top:40px;
                        padding-left:40px;
                        ">
                        <table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td align="center" class="border">
                                    <div align="center" style="height:470px;
                                         padding-top:30px;
                                         ">
                                        <div id="div_message"><?= $Message ?></div>

                                        <form id="frm_category" name="frm_category" action="<?= $Page ?>" method="post" >
                                            <table align="center" cellpadding="1" cellspacing="1" border="0" width="60%" style="border:#CCCCCC solid 1px;">
                                                <tr>
                                                    <td>Leave Name</td>
                                                    <td>
                                                        <input type="hidden" name="lname" id="lname" value="<?= $leave_name ?>"/>
                                                        <input type="text" name="txt_leave" id="txt_leave" value="<?= $leave_name ?>"/>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        employee Type
                                                    </td>
                                                    <td>
                                                        <select id="emp_type" name="emp_type">
                                                            <?php
                                                            $que = mysql_query("select type_name from mpc_employee_type_master");
                                                            while ($row = mysql_fetch_array($que)) {
                                                                ?>
                                                                <option value="<?php echo $row['type_name'] ?>"  <?
                                                                //if ($emp_type == $ow['type_name'] ) {
                                                                //   echo 'selected';
                                                                //}
                                                                ?> ><?php echo $row['type_name']; ?> </option><?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Number Of Leaves</td>
                                                    <td>
                                                        <input type="text" name="num_leaves" id="num_leaves" value="<?= $total_leaves ?>"  onkeypress="return check(event)" /><i>Days/Month</i>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" align="center" bgcolor="#E2EBF0" height="25">
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
                                                    <td class="h_text">Employee Type</td>
                                                    <td class="h_text">Leave Name</td>
                                                    <td class="h_text">Total Days</td>
                                                    <td class="h_text">Edit</td>
                                                    <td class="h_text">Delete</td>
                                                </tr>
                                                <?
                                                $sql = "select * from  mpc_leave_master";
                                                $result = mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
                                                if (mysql_num_rows($result) > 0) {

                                                    $num = mysql_num_rows($result) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

                                                    while ($row = mysql_fetch_array($result)) {
                                                        ?>
                                                        <tr bgcolor="#F2F7F9">
                                                            <td class="Text01"><?= $row["emp_type"] ?></td>
                                                            <td class="Text01"><?= $ln = $row["leave_name"] ?></td>
                                                            <td class="Text01"><?= $row["total_leaves"] . "Days" ?></td>
                                                            <td class="Text01"><a href="add_setting.php?id=<?= $row['id'] ?>&mode=edit&lname=<?= $ln ?>">Edit</a></td>
                                                            <td class="Text01"><a href="javascript:;" onClick="overlay(<?= $row['id'] ?>);">Delete</a></td>
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
<div id="overlay">
    <div>
        <p class="form_msg">Are you sure to delete this Plant</p>
        <form name="frm_del" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
            <input type="submit" class="submit" name="btn_delete" id="btn_delete" value="Yes" />
            <input type="button" class="submit" onClick="overlay();" name="btn_close" id="btn_close" value="No" />
        </form>
    </div>
</div>
<? include ("inc/hr_footer.php"); ?>	