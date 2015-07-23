<?php
session_start();
$user_name = $_SESSION['hr_mahima_session_user_name'];
$folder = explode("/", $_SERVER["PHP_SELF"]);
$folder = $folder[1];
$id = $_GET["id"];
?><div id="div_update_releave">
    <form action="" method="post">
        <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
            <tr>
                <td colspan="2" class="blackHead">Edit Request</td>
            </tr>
            <tr>
                <td align="left" valign="top">
                    <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                        <tr>
                            <td class="text_1" valign="top">Request Date</td>
                            <td><?= date("Y-m-d") ?></td>
                        </tr>
                        <tr>
                            <td class="text_1" valign="top">Reason</td>
                            <td><textarea id="req_reason" name="req_reason"></textarea></td>
                        </tr>
                        <tr>
                            <td class="text_1" valign="top">Details</td>
                            <td>
                                <textarea id="req_details" name="req_details"></textarea>
                                <?php $page = "employee_detail.php?emp_id=$id" ?>
                                <input type="hidden" name="emp_id" id="emp_id" value="<?= $id ?>"/>
                                <input type="hidden" name="req_page" id="req_page" value="<?= $page ?>"/>
                                <input type="hidden" name="req_plant" id="req_plant" value="<?= $folder ?>"/>
                                <input type="hidden" name="req_user" id="req_user" value="<?= $user_name ?>"/>
                            </td>
                        </tr>
                    </table>
                </td>

                <td>

                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" name="save_request" id="save_request" value="Request"/>
                    <!--<input type="button" name="request" id="request" onclick="post_frm('edit_request_save.php', '0', 'div_update_releave', '', '<?= $date ?>', '<?= str_replace(array("\r\n", "\r", "\n", "\t"), "<br>", $reason_realeaving); ?>', '<?= $id ?>')" value="Request"/>-->
                </td>
            </tr>
        </table>
    </form>
</div>
