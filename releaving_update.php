<?php
include ("inc/dbconnection.php");
include ("inc/function.php");
$date_releaving = "";
$reason_realeaving = "";
$emp_id = "";
$id = $_POST["str1"];
if (isset($_POST["str4"])) {
    $date_releaving = getdbDateSepretoe($_POST["str4"]);
    $reason_realeaving = $_POST["str5"];
    $emp_id = $_POST["str6"];
}

//echo $weekly_off;
if ($id == 1) {
    $sql_check1 = "update " . $mysql_table_prefix . "account_detail set date_releaving  ='$date_releaving',
                reason_realeaving='$reason_realeaving' where emp_id='$emp_id'";

    $result_check1 = mysql_query($sql_check1) or die("Query Failed " . mysql_error());
    ?>
    <div id="div_update_releave">
        <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
            <tr>
                <td colspan="2" class="blackHead">Relieving Detail</td>
            </tr>
            <tr>
                <td align="left" valign="top">
                    <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                        <tr>
                            <td class="text_1">Date of Leaving</td>
                            <?= $date_releaving = getDatetime($date_releaving) ?>
                        </tr>
                        <tr>
                            <td class="text_1" valign="top">Reason</td>
                            <td>
                                <select id="reason_realeaving" name="reason_realeaving">
                                    <option value="1" selected="selected">Retirement</option>
                                    <option value="2" selected="selected">Department Disablement</option>
                                    <option value="3" selected="selected">Death in Service</option>
                                    <option value="4" selected="selected">Resignation</option>
                                    <option value="5" selected="selected">Termination</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </td>

            </tr>
            <tr>
                <td colspan="2" align="center">

                    <a onclick="post_frm('releaving_update.php', '0', 'div_update_releave', '', '<?= $date_releaving ?>', '<?= $reason_realeaving ?>', '<?= $emp_id ?>')">Edit</a>
                    <input type="hidden" name="emp_id" id="emp_id" value="<?= $emp_id ?>"/>
                </td>
            </tr>
        </table>
    </div>
    <?
} else if ($id == 0) {
    ?>
    <form action="" method="post" name="frm_releaving" id="frm_releaving">
        <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
            <tr>
                <td colspan="2" class="blackHead">Relieving Detail</td>
            </tr>
            <tr>
                <td align="left" valign="top">
                    <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                        <tr>
                            <td class="text_1">Date</td>
                            <td><input type="text" name="releaving_date" id="releaving_date" style="width:180px; height:20px;" readonly="readonly" value="<?= getDatetime($date_releaving) ?>"/>
                                <a href="javascript:void(0)" onclick="gfPop.fPopCalendar(document.frm_releaving.releaving_date);"><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="27" height="22" border="0" alt=""/></a></td>
                        </tr>
                        <tr>
                            <td class="text_1" valign="top">Reason</td>
                            <td>
                                <select id="releaving_reason" name="releaving_reason">
                                    <option value="1" selected="selected">Retirement</option>
                                    <option value="2" selected="selected">Department Disablement</option>
                                    <option value="3" selected="selected">Death in Service</option>
                                    <option value="4" selected="selected">Resignation</option>
                                    <option value="5" selected="selected">Termination</option>
                                </select>
                            </td>

                        </tr>
                    </table>
                </td>

            </tr>
            <tr>
                <td colspan="2" align="center">
                    <a onclick="post_frm('releaving_update.php', '1', 'div_update_releave', '', document.getElementById('releaving_date').value, document.getElementById('releaving_reason').value, '<?= $emp_id ?>')"><img src="images/btn_submit.png" border="0"/></a>
                    <input type="hidden" name="emp_id" id="emp_id" value="<?= $emp_id ?>"/>
                </td>
            </tr>
        </table>
    </form>
    <?
}
?>