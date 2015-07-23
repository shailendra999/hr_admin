<?php
include("inc/hr_header.php");
?>

<script>
    function validate()
    {
        var txt_date = document.getElementById('txt_date').value;
        var employee_type = document.getElementById('employee_type').value;
        var attendance_type = document.getElementById('attendance_type').value;

        {
            alert("Please select the attendance type");
            return false;
        }
        if (txt_date == "")
        {
            alert("Please select the date");
            return false;
        }
        if (employee_type == "")
        {
            alert("Please select the Employee Type");
            return false;
        }
    }
</script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
        <td align="left" valign="top" width="230px" style="padding-top:5px;">
            <?php
            include ("inc/snb.php");
            $emp_id = $_REQUEST['emp_id'];
            $que = mysql_query("select ticket_no,first_name,last_name from mpc_employee_master where emp_id='$emp_id'");
            $ro = mysql_fetch_array($que);
            $ticket_no = $ro['ticket_no'];
            $name = $ro['first_name'] . $ro['last_name'];
            ?>
        </td>
        <td style="padding-left:5px; padding-top:5px; vertical-align:top">
            <table>
                <tr id="ooo">
                    <td >
                        <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%">
                            <tr>
                                <td align="center" class="gray_bg">&nbsp; <a href="#" style="text-decoration:none;color:gray;">Attendance master-> </a>attendance as per date for all employee</td>
                            </tr>

                        </table>
                    </td>
                </tr>

                <!--My Code Start fro herer-->

                <tr>
                    <td>
                        <?php // This code for dealy attendance//   ?>
                        <!--  <div>     -->
                        <form action="" method="post">
                            <table align="center" width="100%" border="0" class="border">
                                <tr class="blackHead">
                                    <th width="19%" align="center">Date</th>
                                    <th width="7%" align="center">Emp no.</th>
                                    <th width="21%" align="center">Employee Name</th>
                                    <?
                                    if ($type != "Staff") {
                                        
                                    }
                                    ?>
                                    <!--<th width="19%" align="center">Shift</th> -->
                                    <th width="19%" align="center">Attendance</th>
                                </tr>
                                <tr  class="tableTxt">
                                    <td width="15%">
                                        <input type="text" name="txt_date" id="txt_date" style="width:100px; height:20px;"data-beatpicker="true" data-beatpicker-format="['DD','MM','YYYY']"/>
                                    </td>
                                    <td align="center"><input type="text" id="idd" name="idd" readonly="readonly" value="<?= $ticket_no; ?>"  />
                                    </td>
                                    <td align="center"><?= $name ?></td>
                                    <!--<td align="center"><?= $shift ?></td>-->
                                    <td align="center">
                                        <select name="attendace" id="attendace">
                                            <option value="C/OFF" >
                                                C/OFF
                                            </option>
                                        </select> 
                                    </td>
                                </tr>
                                <tr bgcolor="#F8F8F8">
                                    <td colspan="8" align="center">
                                        <!--input type="hidden" name="txt_date" id="txt_date" value="<?= $date ?>" /-->
                                        <input type="hidden" id="shift" name="shift" value="<?= $shift ?>"  />
                                        <input type="submit" src="images/btn_submit.png" name="btn_attend" id="btn_attend" value="Submit" /></td>
                                </tr>

                                <!--My Code start from here -->
                            </table>
                        </form>
                        <?php // }  ?>

                    </td>
                </tr>

                <!--for inserting and updating the data as per daya-->
                <?php
                if (isset($_POST['btn_attend'])) {
                    $date = getdbDate($_POST['txt_date']);

                    $date = str_replace("/", "-", $date);
                    $attendace = $_POST['attendace'];
                    $ticket_no = $_POST['emp_id'];
                    $shift = $_POST['shift'];
                    $emp_id = $_POST['idd'];
                    $avail_date = $_GET['date'];
                    $avail_date = str_replace("/", "-", $avail_date);


                    $sql = mysql_query("select emp_id from mpc_employee_master where ticket_no='$emp_id'");
                    $r = mysql_fetch_array($sql);
                    $sql = "select * from mpc_attendence_master where emp_id = '$r[emp_id]' and date = '$date'";
                    $result_doc = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
                    if ($rows = mysql_num_rows($result_doc) > 0) {

                        $sql_check_update = "update " . $mysql_table_prefix . "attendence_master set attendance_status='$attendace',
                                                badli_as ='$badli_as',shift ='$shift',avail_date = '$avail_date' where emp_id ='$r[emp_id]' and date ='$date'";
                        $result_check_update = mysql_query($sql_check_update) or die("Query Failed " . mysql_error());

                        if (!$result_check_update) {
                            echo "Data is not inserted ";
                        } else {

                            echo "Data is inserted..";
                        }
                    } else {

                        $sqll = mysql_query("insert into mpc_attendence_master (emp_id,attendance_status,date,time,time_out,avail_date) values ('$r[emp_id]','$attendace','$date','now()','now()','$avail_date')");

                        if (!$sqll) {

                            echo "Data is not inserted ";
                        } else {
                            echo "Data is inserted..";
                        }
                    }
                    $i++;

                    if (!$result_check_update and ! $sqll) {
                        ?>
                        <center>
                            <?php echo "There is some error plz check it ...."; ?>
                        </center>
                        <?php
                    } else {
                        ?>
                        <center>
                            <?php echo "Successful"; ?>
                        </center>
                        <?php
                    }
                    include ("inc/hr_footer.php");
                }
                ?>