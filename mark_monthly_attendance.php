<? include ("inc/hr_header.php"); ?>
<form method="post">
    <table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
        <tr>
            <td align="left" valign="top" width="230px" style="padding-top:5px;">
                <? include ("inc/snb.php"); ?>
            </td>

            <td style="padding-left:5px; padding-top:5px;">
                <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                    <tr>
                        <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp;Search Employee</td>
                    </tr>
                    <tr><td>Search Employee<input type="text" name="search" id="search" value="" /><input type="submit" name="submit" value="search" /></td></tr>
                    <tr><td>

                            <?php
                            if (isset($_POST['submit'])) {


                                $conn = mysql_connect('localhost', 'ssofts_mahima', 'HUUFNdWSmi].')or die("Couldn't connect to server.");
                                $db = mysql_select_db('ssofts_mah', $conn)or die("Couldn't select database.");
                                ?>
                                <table class="border" width="100%" align="center" border="0">
                                    <tbody>
                                        <tr class="blackHead">
                                            <td width="7%" align="center">Emp no.</td>
                                            <td width="21%" align="center">Employee Name</td>
                                            <td width="19%" align="center">Mark Attendance</td>

                                        </tr>
                                        <tr><td width="7%" align="center"><input type="text" name="employeeId" value="<?php echo $row['ticket_no']; ?>" /></td>

                                            <td width="21%" align="center"><?php echo $row['first_name']; ?>&nbsp;<?php echo $row['last_name']; ?></td>
                                            <td width="19%" align="center"><a href="http://solutionsofts.com/mah_database/mark_monthly_attendance.php?empno=<?php echo $row['ticket_no']; ?>&name=<?php echo $row['first_name']; ?>">Mark Monthly Attendance</a></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody></table>		
                        </td></tr>


                </table></td></tr></table></form>
<?php include("inc/hr_footer.php"); ?>
