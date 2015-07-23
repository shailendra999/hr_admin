<?php
include('inc/dbconnection.php');
include('inc/function.php');
$id = "";
$id = $_GET["id"];
$date_releaving = "";
$reason_realeaving = "";
$sql = "SELECT * FROM  mpc_account_detail where emp_id  = '$id'";
$result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
if (mysql_num_rows($result) > 0) {
    while ($row = mysql_fetch_array($result)) {
        $date_releaving = $row['date_releaving'];
        $reason_realeaving = $row['reason_realeaving'];
        $reason_realeaving = $reason_realeaving;
    }
}
if ($date_releaving != "0000-00-00 00:00:00") {
    if ($date_releaving != "") {
        $date_releaving = getDatetime($date_releaving);
    }
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
                            <td><?= $date_releaving ?></td>
                        </tr>
                        <tr>
                            <td class="text_1" valign="top">Reason</td>
                            <td>
                                <select id="reason_realeaving" disabled name="reason_realeaving">
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
                <td>

                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="button" name="edit" id="edit" onclick="post_frm('releaving_update.php', '0', 'div_update_releave', '', '<?= $date_releaving ?>', '<?= str_replace(array("\r\n", "\r", "\n", "\t"), "<br>", $reason_realeaving); ?>', '<?= $id ?>')" value="Edit"/>
                </td>
            </tr>
        </table>
    </div>
    <?
} else {
    ?>

    <div id="div_insert_releave" style="display:block;">
        <form action="" method="post" name="frm_releaving" id="frm_releaving">
            <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                <tr>
                    <td colspan="2" class="blackHead">Relieving Detail</td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                            <tr>
                                <td class="text_1">Date of Leaving</td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
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
                        <a onclick="post_frm('releaving_update.php', '1', 'div_insert_releave', '', document.getElementById('releaving_date').value, document.getElementById('releaving_reason').value, '<?= $id ?>')"><img src="images/btn_submit.png" border="0"/></a>
                        <input type="hidden" name="emp_id" id="emp_id" value="<?= $id ?>"/>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <?php
}
?>