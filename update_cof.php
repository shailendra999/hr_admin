<?php
//var_dump($_REQUEST);  
include("inc/hr_header.php");
?>

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
        <td align="left" valign="top" width="230px" style="padding-top:5px;">
            <? include ("inc/snb.php"); ?>
        </td> 
        <td style="padding-left:5px; padding-top:5px;" valign="top">
            <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                <tr>
                    <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/>COF Ragister</td>
                </tr>
                <tr><td>

                        <?php
                        $emp_id = $_REQUEST['emp_id'];
                        $name = $_REQUEST['name'];
                        $attandance = $_REQUEST['attendance_status'];
                        $date = $_REQUEST['date'];

                        if (isset($_POST['submit'])) {
                            $attendance = $_POST['attendance_status'];
                            $updated_date = $_POST['attendance_date'];
                            $pre_date = $_POST['pre_date'];
                            $reason = $_POST['reason'];
                            $que = mysql_query("UPDATE `ssofts_lss`.`mpc_attendence_master` SET `reason` = '$reason' , date = '$updated_date' WHERE `mpc_attendence_master`.`emp_id` ='$emp_id' and date='$date'");
                            if (!($que)) {
                                echo"Please add reason again";
                                die;
                            } else {
                                echo"Reason Successfully Added";
                                echo '<script>window.location="http://solutionsofts.com/lss/cofregister.php"</script>';
                            }
                        }
                        ?>
                        <form method="post" action="#">            
                            <table class="border">
                                <tr>
                                    <td>
                                        Employee Name
                                    </td>
                                    <td>
                                        <input type="text" name="emp_name" readonly value="<?php echo $name ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Attendance Status
                                    </td>
                                    <td>
                                        <input type="text"  readonly name="attendance_status" value="<?php echo $attandance ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Date
                                    </td>
                                    <td>
                                        <input type="text" name="attendance_date" value="<?php echo $date ?>" />
                                        <input type="hidden" name="pre_date" value="<?= $date ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Reason
                                    </td>
                                    <td>
                                        <textarea name="reason"></textarea>
                                    </td>
                                </tr>

                                <tr><td><input type="submit" name="submit" value="submit" /></td></tr>

                            </table>
                        </form>

                    </td></tr></table></td></tr></table>
<?php
include("inc/hr_footer.php");
?>