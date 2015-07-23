<script>
    $.ajax({
        alert(data.message);
        window.close();              
        }
    });
    </script>
<?php
include("inc/hr_header.php");
?>
 <table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
        <td align="left" valign="top" width="230px" style="padding-top:5px;">
            <? include ("inc/snb.php"); ?>
        </td> 
        <td style="padding-left:5px; padding-top:5px;" valign="top">
            <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                <tr><td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/>COF Ragister</td></tr>
                <tr><td>
                        <form method="post">
                            <table><tr><td>Availed Date</td><td><input type="text" name="availed_date" data-beatpicker-format="['DD','MM','YYYY']" data-beatpicker="true"/></td></tr>
                                <tr><td>Reason</td><td><textarea name="reason"></textarea></td></tr>
                                <!--<tr><td><input type="submit" name="submit" value="submit" onclick="get_frm_attendence('get_employee_attendance_list.php', '<?= $date ?>', 'div_employee_last', '<?= $id ?>&str7=<?= $shift ?>', document.getElementById('attendace').value, document.getElementById('designation').value, '<?= $type ?>');closeWin();"/></td></tr>-->
                                <tr><td><input type="submit" name="submit" value="submit" onsubmit="closeWin()"/></td></tr>
                            </table>
                        </form>
                        <?php
                        if (isset($_POST['submit'])) {
                            $ip = $_SERVER['REMOTE_ADDR'];
                            $good_work = "";
                            $txt_date = date("d-m-Y");
                            $id = $_GET["str"];
                            $status = $_POST["str4"];
                            $badli_as = $_POST["str5"];
                            $type = $_POST["str6"];
                            $shift = $_REQUEST['shift'];
                            $emp_id = $_REQUEST['emp_id'];
                            $leave_taken = $_REQUEST['leave_taken'];
                            $availed_date = $_POST['availed_date'];
                            $reason = $_POST['reason'];
                            $que=mysql_query("select emp_id from mpc_employee_master where ticket_no='$emp_id'");
                            $row=mysql_fetch_array($que);
                            $emp_id=$row['emp_id'];
                            if ($leave_taken == "") {
                                $sql_check = mysql_query("insert into " . $mysql_table_prefix . "attendence_master set	
			emp_id ='$emp_id',attendance_status='C/OFF',date ='$txt_date',badli_as ='$badli_as',
			shift ='$shift',good_work ='$good_work',InsertBy ='$id',InsertDate =now(),IpAddress ='$ip',
			avail_date='$availed_date',reason='$reason'");
                            } else {
                                $que = mysql_query("UPDATE mpc_attendence_master SET `avail_date` = '$availed_date',`reason` = '$reason' WHERE `mpc_attendence_master`.`emp_id` ='$emp_id'");
                            }
                        }
                        ?>


                    </td></tr>
            </table></td></tr></table>
<?php
include("inc/hr_footer.php");
?>
<script>
function closeWin() {
    myWindow.close();
}
</script>
