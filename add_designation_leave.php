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

    function changeLdays(leave, designation) {
//        alert(leave);
        $.ajax({
            type: 'POST',
            url: "ajax_drop_leave.php",
            cache: false,
            data: {
                leave: leave,
                designation: designation
            },
            success: function (response)
            {
                if (response == "<p style = 'color:red'>This leave is already assigned to designation</p>") {
                    document.getElementById('btn_submit').disabled = true;
                } else {
                    document.getElementById('btn_submit').disabled = false;
                }
                document.getElementById('td_select').innerHTML = response;
            }
        });

    }
    function monthlyApplicable(number) {
        $.ajax({
            type: 'POST',
            url: "ajax_monthly_leaves.php",
            cache: false,
            data: {
                number: number
            },
            success: function (response)
            {
                document.getElementById('monthly').innerHTML = response;
            }
        });
    }

    function carryForward(carry) {
//        alert(carry);
        document.getElementById('carry_value').disabled = false;
        if (carry == 1) {
            document.getElementById('carry_value').placeholder = "Number of years";
        } else {
//            document.getElementById('carry_value').disabled = false;
            document.getElementById('carry_value').placeholder = "Number of Months";
        }
    }
</script>
<?php
$Page = "add_designation_leave.php";
$PageTitle = "Setting";
$PageFor = "Setting";
$PageKey = "id";
$PageKeyValue = "";
$Message = "";
if (isset($_POST["btn_submit"])) {
    $PageKeyValue = $_POST[$PageKey];
    /* $pl = $_POST["pl"];
      $cl = $_POST["cl"]; */
    $monthly_applicable = $_POST['monthly_applicable'];
    $dll_leave = $_POST["dll_leave"];

    $count = count($dll_designation = $_POST["dll_designation"]);
    $dll_leaves = $_POST["dll_leaves"];
    $carry_type = $_POST["carry_type"];
    $carry_value = $_POST["carry_value"];

    if ($PageKeyValue == "") {
//        $sql = "insert into mpc_setting set pl = '$pl',cl = '$cl'";
        for ($i = 0; $i < $count; $i++) {
            $sql = "insert into mpc_leave_designation (leave_id,designation_id,number_of_leaves,carry_type,carry_value,monthly_applicable) values ('$dll_leave','$dll_designation[$i]','$dll_leaves','$carry_type','$carry_value','$monthly_applicable')";
            mysql_query($sql) or die("Error in " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
        }

        $Message = "$PageFor Inserted";
    } else {
        if ($mode != "subcategory") {
            for ($i = 0; $i < $count; $i++) {
                $sql = "update mpc_leave_designation set leave_id = '$dll_leave',designation_id = '$dll_designation[$i]',number_of_leaves='$dll_leaves',carry_type='$carry_type',carry_value='$carry_value',monthly_applicable='$monthly_applicable' where $PageKey = '$PageKeyValue'";
                mysql_query($sql) or die("Error in " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
            }
            $Message = "$PageFor Updated";
        }
    }
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
    $sql = "delete from mpc_leave_designation where $PageKey = '" . $PageKeyValue . "'";
    mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
    $Message = "Leave Sucessfully Deleted";
    redirect("$Page?Message=$Message");
}
$employee_type = "";
$pl = "";
$cl = "";
if (isset($_GET[$PageKey])) {

    $sql = "select *,id as rec_id from mpc_leave_designation where $PageKey = '" . $_GET[$PageKey] . "'";
    $result = mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
    if (mysql_num_rows($result) > 0) {
        $row = mysql_fetch_array($result);
        $PageKeyValue = $row[$PageKey];
        $id = $row["id"];
        $leave_id = $row["leave_id"];
        $des_id = $row["designation_id"];
        $carry_type = $row["carry_type"];
        $carry_type_val = $row["carry_value"];
        $total_leaves = $row["number_of_leaves"];
        $monthly_applicables = $row['monthly_applicable'];
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
                    <td align="center" class="gray_bg">
                        <img src="images/bullet.gif" width="15" height="22"/> &nbsp;Leave Master
                    </td>
                </tr>
                <tr>
                    <td height="400px" valign="top" style="padding-top:0px; padding-left:0px;">
                        <table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td align="center" class="border">
                                    <div align="center" style="height:470px; padding-top:30px;">
                                        <div id="div_message"><?= $Message ?></div>

                                        <form id="frm_category" name="frm_category" action="<?= $Page ?>" method="post">
                                            <table align="center" cellpadding="1" cellspacing="1" border="0" width="70%" style="border:#CCCCCC solid 1px;">
                                                <tr>
                                                    <td>Leave Name</td>
                                                    <td>
                                                        <select id="dll_leave" name="dll_leave" >
                                                            <option value="-1">Select Leave</option>
                                                            <?php
                                                            $select = mysql_query("select * from mpc_leave_master");
                                                            while ($row = mysql_fetch_array($select)) {
                                                                ?>
                                                                <option value="<?= $row['id'] ?>"<?php
                                                                if ($leave_id == $row['id']) {
                                                                    echo "selected";
                                                                }
                                                                ?>>
                                                                            <?= $row['leave_name'] ?>
                                                                </option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        Designation
                                                    </td>
                                                    <td>
                                                        <select multiple name="dll_designation[]" id="dll_designation" onchange="changeLdays(dll_leave.value, this.value)" >
                                                            <?php
                                                            $query = mysql_query("select * from mpc_designation_master");
                                                            while ($rows = mysql_fetch_array($query)) {
                                                                ?>
                                                                <option value="<?= $rows['rec_id'] ?>" <?php
                                                                if ($rows['rec_id'] == $des_id) {
                                                                    echo "selected";
                                                                }
                                                                ?>>
                                                                            <?= $rows['designation_name'] ?>
                                                                </option>

                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Assign Number Of Leaves</td>
                                                    <td id="td_select">
                                                        <select name="dll_leaves" id="dll_leaves">
                                                            <?php
                                                            $select_days = mysql_query("Select total_leaves from mpc_leave_master where id = $leave_id");
                                                            while ($ro = mysql_fetch_array($select_days)) {
                                                                $tot_leaves = $ro['total_leaves'];
                                                            }
                                                            for ($i = 0; $i <= $tot_leaves; $i++) {
                                                                ?>
                                                                <option value="<?= $i ?>" <?php
                                                                if ($i == $total_leaves) {
                                                                    echo "selected";
                                                                }
                                                                ?>>
                                                                            <?= $i ?>
                                                                </option>
                                                                <?
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Monthly Applicable Leaves</td>
                                                    <td id="monthly">
                                                        <select name="monthly_applicable" id="monthly_applicable">
                                                            <?php
                                                            for ($j = 0; $j <= $tot_leaves; $j++) {
                                                                ?>
                                                                <option value="<?= $j ?>" 
                                                                <?php
                                                                if ($j == $monthly_applicables) {
                                                                    echo "selected";
                                                                }
                                                                ?>>
                                                                            <?= $j ?>
                                                                </option>
                                                                <?php
                                                            }
                                                            ?>                                                      
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>carry forward Leave Type</td>
                                                    <td>
                                                        <input type="radio" name="carry_type" id="carry_type" value="1"
                                                        <?php
                                                        if ($carry_type == 1) {
                                                            echo "checked";
                                                        }
                                                        ?> onclick="carryForward(this.value)"/>Yearly

                                                        <input type="radio" name="carry_type" id="carry_type" value="2" onclick="carryForward(this.value)"
                                                        <?php
                                                        if ($carry_type == 2) {
                                                            echo "checked";
                                                        }
                                                        ?>/>Monthly
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>

                                                    </td>
                                                    <td>
                                                        <input type="text" name="carry_value" id="carry_value" <?php
                                                        if (isset($carry_type_val)) {
                                                            ?>
                                                                   value="<?= $carry_type_val ?>"
                                                               <?php } else {
                                                                   ?>
                                                                   disabled = "true"
                                                               <?php } ?>/>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan = "3" align = "center" bgcolor = "#E2EBF0" height = "25">
                                                        <input type = "hidden" id = "mode" name = "mode" value = "<?= $mode ?>"/>
                                                        <input type = "hidden" id = "<?= $PageKey ?>" name = "<?= $PageKey ?>" value = "<?= $PageKeyValue ?>" />
                                                        <input type = "submit" id = "btn_submit" name = "btn_submit" value = "Submit" class = "btn_bg" />
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                        <div id = "div_category_list" style = "overflow:scroll;height:300px;width:950px">
                                            <table align = "center" width = "100%" style = "border:#CCCCCC solid 1px;" cellpadding = "1" cellspacing = "1">
                                                <tr>
                                                    <td class = "h_text">Leave Name</td>
                                                    <td class = "h_text">Designation Name</td>
                                                    <td class = "h_text">Total Days</td>
                                                    <td class = "h_text">Assign Leaves</td>
                                                    <td class = "h_text">Carry Type</td>
                                                    <td class = "h_text">Edit</td>
                                                    <td class = "h_text">Delete</td>
                                                </tr>
                                                <?
                                                $sql = "select *,mpc_leave_designation.id as ids from mpc_leave_designation,mpc_leave_master,mpc_designation_master where mpc_leave_designation.designation_id = mpc_designation_master.rec_id AND mpc_leave_master.id = mpc_leave_designation.leave_id ";
                                                $result = mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
                                                if (mysql_num_rows($result) > 0) {

                                                    $num = mysql_num_rows($result) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

                                                    while ($row = mysql_fetch_array($result)) {
                                                        ?>
                                                        <tr bgcolor="#F2F7F9">
                                                            <?php ?>
                                                            <td class="Text01"><?= $row["leave_name"] ?></td>
                                                            <td class="Text01"><?= $row["designation_name"] ?></td>
                                                            <td class="Text01"><?= $row["total_leaves"] ?></td>
                                                            <td class="Text01"><?= $row["number_of_leaves"] . "Days" ?></td>
                                                            <td class="Text01"><?php
                                                                if ($row['carry_type'] == 1) {
                                                                    echo "Yearly Upto " . $row['carry_value'];
                                                                } elseif ($row['carry_type'] == 2) {
                                                                    echo "Monthly Upto " . $row['carry_value'];
                                                                }
                                                                ?></td>
                                                            <td class="Text01"><a href="add_designation_leave.php?id=<?= $row['ids'] ?>&mode=edit">Edit</a></td>
                                                            <td class="Text01"><a href="javascript:;" onClick="overlay(<?= $row['ids'] ?>);">Delete</a></td>
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
        <p class="form_msg">Are you sure to delete this Plant</p>
        <form name="frm_del" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
            <input type="submit" class="submit" name="btn_delete" id="btn_delete" value="Yes" />
            <input type="button" class="submit" onClick="overlay();" name="btn_close" id="btn_close" value="No" />
        </form>
    </div>
</div>
<? include ("inc/hr_footer.php"); ?>	