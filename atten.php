<?php include ("inc/hr_header.php"); ?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
    function myfunction(a)
    {
        var id = document.getElementById('idd').value;
        var emp_id = document.getElementById('emp_id').value;
        if (a == 'C/OFF')
        {
            window.open("coffavail.php?emp_id=" + id + "&attemdance=" + a);

        }

    }
</script>
<script>
    $(document).ready(function () {
        $("#ooo").hide();
        $("#mon").hide();
        $('#attendance_typer').on('change', function () {
            if (this.value == 'Monthly')
            {
                $("#ooo").hide();
                $("#mon").show();
            }
            else if (this.value == "Daily")
            {
                $("#mon").hide();
                $('#ooo').show();
            }
            else if (this.value == 0)
            {
                $("#ooo").hide();
                $("#mon").hide();
            }
        });
    });
</script>
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

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
        <td align="left" valign="top" width="230px" style="padding-top:5px;">
            <? include ("inc/snb.php"); ?>
        </td>
        <td style="padding-left:5px; padding-top:5px; vertical-align:top">
            <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                <tr>
                    <td class="text_1" style="padding-left:15px;" width="12%">
                        Attendance Type
                        <span class="red">
                            *
                        </span>
                    <td>
                        <Select id="attendance_typer">
                            <option value="0">
                                --select--
                            </option>
                            <option value="Monthly">
                                Monthly
                            </option>
                            <option value="Daily">
                                Daily
                            </option>
                        </Select>
                    </td>
                    <td>Import Attendance</td>
                    <td>

                        <form name="atten_imp" id="atten_imp" action="upload_atten.php" method="post" enctype="multipart/form-data">
                            <?php
                            if ($year = $_GET['id'] == $current_year) {
                                $last_month = date('n');
                                $month = $last_month;
                            }
                            $current_year = date('Y');

                            $last_month = 12;
                            $month = 01;
                            ?>
                            <select id="month" name="month" style="width:150px; height:20px;">
                                <?
                                for ($i = 01; $i <= $last_month; $i++) {
                                    $j = sprintf("%02d", $i);
                                    ?>
                                    <option value="<?= $j ?>"><?= date("F", mktime(0, 0, 0, $i, 1, 0)) ?></option>
                                    <?
                                }
                                ?>
                            </select>
                            <input type="file" name="attenace_imp" id="attendance_imp"/>
                            <input type="submit" name="save_imp" id="save_imp" value="Upload"/>
                        </form>
                    </td>
                </tr>
            </table>
            <table>
                <tr id="ooo">
                    <td >
                        <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%">
                            <tr>
                                <td align="center" class="gray_bg">&nbsp; <a href="#" style="text-decoration:none;color:gray;">Attendance master-> </a>attendance as per date for all employee</td>
                            </tr>
                            <tr>
                                <td>
                                    <form id="frm_emp_list" name="frm_emp_list" method="POST" >
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                                            <tr>
                                                <td width="100%" colspan="2" align="center">
                                                    <table cellpadding="0" cellspacing="0" border="0" align="center" class="loginbg" >
                                                        <tr>
                                                            <td class="text_1" style="padding-left:15px;" width="12%">Attendance Date<span class="red">*</span></td>
                                                            <td width="15%">
                                                                <input type="text" name="txt_date" id="txt_date" value="<?= $date ?>" style="width:100px; height:20px;"data-beatpicker="true" data-beatpicker-format="['DD','MM','YYYY']"/>
                                                            </td>
                                                            <td width="7%" class="text_1" style="padding-right:15px; text-align:right;">
                                                                Type
                                                                <span class="red">
                                                                    *
                                                                </span>
                                                            </td>
                                                            <td width="13%">

                                                                <select id="employee_type" name="employee_type" onChange="shift_check(this)" style="width:100px; height:25px;" onkeydown="if (event.keyCode && event.keyCode == 13) {

                                                                        }">
                                                                    <option value="">---Select---</option>
                                                                    <?php
                                                                    $que = mysql_query("select type_name from mpc_employee_type_master");

                                                                    while ($row = mysql_fetch_array($que)) {
                                                                        ?>
                                                                        <option value="<?php echo $row['type_name'] ?>"><?php echo $row['type_name']; ?> </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>
                                                            <td width="13%" class="text_1" style="padding-right:15px; text-align:right;">
                                                                Emp Id
                                                            </td>
                                                            <td width="17%" align="left" style="padding-left:20px;">
                                                                <div id="dealy_div_txt_autocomplete">
                                                                    <input type="text" name="employee_id" id="employee_id" value="">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input type="submit" name="dealy_submit" id="dealy_submit" value="submit" onclick="return validate()"  >
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!--My Code Start fro herer-->

                <tr>
                    <td>
                        <?php // This code for daily attendance//       ?>
                        <?php
                        if (isset($_POST['dealy_submit'])) {
                            $date = $_POST['txt_date'];
                            $date = getdbDate($date);
                            $date = str_replace("/", "-", $date);
                            $employee_type = $_POST['employee_type'];
//                            $shift = $_POST['shift_detail'];
                            $id = $_POST['employee_id'];

                            if (isset($_POST['start'])) {
                                if ($_POST['start'] == 'All') {
                                    $start = 0;
                                } else {
                                    $start = $_POST['start'];
                                }
                            } else {
                                $start = 0;
                            }
                            $day = substr($_POST["str"], 0, 2);
                            $month = substr($_POST["str"], 3, 2);
                            $year = substr($_POST["str"], 6, 4);
                            $weekly_day = date("l", mktime(0, 0, 0, $month, $day, $year));
                            $holiday = getHoliday('holiday_name', $date);
                            $id = $_POST['employee_id'];
                            $data = array();
                            if (!empty($id)) {
                                $sql = "Select * from mpc_employee_master where ticket_no = '$id'";

                                $result_doc = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
                                if (mysql_num_rows($result_doc) > 0) {

                                    $row = mysql_fetch_array($result_doc);
                                    $first_name = $row['first_name'];
                                    $last_name = $row['last_name'];
                                    $emp_id['0'] = $row['emp_id'];
                                    $data['name']['0'] = $first_name . $last_name;
                                    $sql = "select * from mpc_attendence_master where emp_id = '$emp_id[0]' and date = '$date'";
                                    $result_doc = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
                                    if ($rows = mysql_num_rows($result_doc) > 0) {
                                        //$rows = mysql_fetch_array($result_doc);

                                        $data['ticket_no']['0'] = $id;
                                        $attendance = $rows['attendance_status'];
                                        $data['attendance'] = $attendance;
                                    }
                                    $data['ticket_no']['0'] = $id;
                                } else {
                                    echo "no record found";
                                }
                            } else {

                                $sql = "Select ticket_no,first_name,last_name,emp_id from mpc_employee_master where empType='$employee_type'";
                                $result_doc = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
                                if (mysql_num_rows($result_doc) > 0) {
                                    while ($row = mysql_fetch_assoc($result_doc)) {
                                        $first_name = $row['first_name'];
                                        $emp_id = $row['emp_id'];
                                        $data['emp_id'][] = $emp_id;
                                        $last_name = $row['last_name'];
                                        $data['name'][] = $first_name . $last_name;
                                        $ticket_no = $row['ticket_no'];
                                        $data['ticket_no'][] = $ticket_no;
                                        $qwe = "Select attendance_status from mpc_attendence_master where emp_id='$emp_id' and date='$date'";
                                        $quee = mysql_query($qwe);
                                        $rows = mysql_fetch_row($quee);
                                        $attendance_status = $rows[0];
                                        $data['attendance'][] = $attendance_status;
                                    }//while loop
                                }// if loop
                                else {
                                    echo "no record found";
                                }
                                //if condition
                            }//else condition
                            //End here
                            ?>
                            <!--  <div>     -->

                            <form action="" method="post">
                                <table align="center" width="100%" border="0" class="border">
                                    <tr class="blackHead">
                                        <th width="6%" align="center">S.No.</th>
                                        <th width="7%" align="center">Emp no.</th>
                                        <th width="21%" align="center">Employee Name</th>
                                        <?
                                        if ($type != "Staff") {
                                            
                                        }
                                        ?>
                                        <th width="19%" align="center">Shift</th>
                                        <th width="19%" align="center">Attendance</th>
                                    </tr>
                                    <?php
                                    $sno = 1;
                                    $i = 0;

                                    foreach ($data['name'] as $d) {
                                        ?>
                                        <tr  class="tableTxt">
                                            <td align="center"><?= $sno ?></td>
                                            <td align="center"><input type="text" id="idd" name="idd[]" readonly="readonly" value="<?= $data['ticket_no'][$i] ?>"  />
                                                <input type="hidden" name="emp_id[]" id="emp_id" value="<?= $data['emp_id'][$i] ?>" /></td>
                                            <td align="center"><?= $d ?></td>
                                            <td align="center"><?= $shift ?></td>
                                            <td align="center">
                                                <select name="attendace[]" id="attendace" onchange="myfunction(this.value)">
                                                    <option value="P" <?php
                                                    if ($data['attendance'][$i] == $a['leave_name']) {
                                                        echo 'selected="selected"';
                                                    }
                                                    ?>>Present</option>
                                                    <option value="P/2">Present/2</option>
                                                    <option value="A">Absent</option>
                                                    <option value="HCL">Half Day</option>
                                                    <option value="C/OFF" >
                                                        C/OFF
                                                    </option>
                                                    <?php
                                                    $que = mysql_query("SELECT * FROM `mpc_leave_master` WHERE emp_type='$employee_type' ");
                                                    while ($a = mysql_fetch_array($que)) {
                                                        ?>
                                                        <option value="<?php echo $a['leave_name']; ?>" <?
                                                        if ($data['attendance'][$i] == $a['leave_name']) {
                                                            echo 'selected="selected"';
                                                        }
                                                        ?> ><?php echo $a['leave_name']; ?></option>
                                                            <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <?
                                        $sno++;
                                        $i++;
                                    }
                                    ?>
                                    <tr bgcolor="#F8F8F8">
                                        <td colspan="8" align="center"><input type="hidden" name="txt_date" id="txt_date" value="<?= $date ?>" />
                                            <input type="hidden" id="shift" name="shift" value="<?= $shift ?>"  />
                                            <input type="submit" src="images/btn_submit.png" name="btn_attend" id="btn_attend" value="Submit" /></td>
                                    </tr>

                                    <!--My Code start from here -->
                                </table>
                            </form>
                        <?php } ?>

                    </td>
                </tr>
                <!--End here-->
                <!--Monthly html strart from here -->
                <tr id="mon">
                    <td>
                        <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                            <tr>
                                <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Mark Attendance</td>
                            </tr>
                            <tr>
                                <td class="heading" valign="top" style="padding-top:5px;">
                                    <form id="frm_emp_list" name="frm_emp_list" method="GET" action="#">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                                            <tr>
                                                <td width="100%" colspan="2" align="center">
                                                    <table cellpadding="0" cellspacing="0" border="0" align="center" class="loginbg" style="margin-bottom:20px;">
                                                        <tr>
                                                            <td class="text_1" style="padding-left:15px;" width="12%">Attendance From Date<span class="red">*</span></td>
                                                            <td width="15%">
                                                                <input type="text" name="mon_txt_date" id="mon_txt_date" data-beatpicker-position="['right','*']" data-beatpicker-format="['DD','MM','YYYY']"  value="<?= $date ?>" data-beatpicker="true" style="width:100px; height:25px;" />  </td>
                                                            <td class="text_1" style="padding-left:15px;" width="12%">Attendance To Date<span class="red">*</span></td>
                                                            <td width="15%">
                                                                <input type="text" name="mon_txt_date1" id="mon_txt_date1" data-beatpicker-position="['right','*']" data-beatpicker-format="['DD','MM','YYYY']"  value="<?= $date ?>" style="width:100px; height:25px;" data-beatpicker="true" /></td>
                                                            <td width="7%" class="text_1" style="padding-right:15px; text-align:right;">Type <span class="red">*</span></td>
                                                            <td width="13%">
                                                                <select name="mon_employee_type" id="mon_employee_type" onChange="shift_check(this)" style="width:100px; height:25px;" onkeydown="if (event.keyCode && event.keyCode == 13) {

                                                                        }">

                                                                    <option value="">---Select---</option>
                                                                    <?php
                                                                    $que = mysql_query("select type_name from mpc_employee_type_master");

                                                                    while ($row = mysql_fetch_array($que)) {
                                                                        ?>

                                                                        <option value="<?php echo $row['type_name'] ?>" ><?php echo $row['type_name']; ?> </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>

                                                            <td width="25%" class="text_1" style="padding-right:15px; text-align:right;"> Emp Id<span class="red">*</span></td>
                                                            <td width="24%" align="left" style="padding-left:20px;">
                                                                <div id="div_txt_autocomplete">
                                                                    <input type="text" name="mon_employee_id" id="mon_employee_id" value="">
                                                                </div> 
                                                            </td>
                                                            <td>
                                                                <!--input type="submit" name="mon_submit" id="mon_submit" value="submit"-->
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div>
                                                        <p>
                                                            <a href="javascript:show_popup()" class="eventDetail impAtt" >
                                                                Import Attendance
                                                            </a>&nbsp;
                                                            <label class="btn" for="modal-1"> 
                                                                ?
                                                            </label>
                                                        </p>
                                                    </div>
                                                    <input class="modal-state" id="modal-1" type="checkbox" />
                                                    <div class="modal">
                                                        <label class="modal__bg" for="modal-1"></label>
                                                        <div class="modal__inner">
                                                            <label class="modal__close" for="modal-1"></label>
                                                            <center>
                                                                <h2>CSV File Formate</h2>
                                                                <table bordercolordark="#000000" border="5px">
                                                                    <tr>
                                                                        <td>id</td><td>110</td></tr>
                                                                    <tr><td>EmpId</td><td>2015105</td></tr>
                                                                    <tr><td>Name</td><td>MR. Been</td></tr>
                                                                    <tr><td>1</td><td>P</td></tr>
                                                                    <tr><td>2</td><td>A</td></tr>
                                                                    <tr><td>3</td><td>CL</td></tr>
                                                                    <tr><td>:</td><td>ML,LWP,HD,L etc</td></tr>
                                                                    <tr><td>:</td><td>LC</td></tr>
                                                                    <tr><td>31</td><td>P</td></tr>
                                                                    <tr><td>Date</td><td>DD-MM-YY</td></tr>
                                                                </table>
                                                            </center>
                                                        </div>
                                                    </div>
                                                    <!-- End herer-->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div id="div_employee_list" style="height:200px;overflow:auto;width:100%;padding-top:10px;"align="center">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div id="div_employee_last" style="height:200px;overflow:auto;width:100%;padding-top:10px;"align="center"> 
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <div id="vpb_pop_up_background"></div>
                                        <div id="vpb_signup_pop_up_box">
                                            <p>
                                                <a href="javascript:hide_popup()" style="float:right;">
                                                    close
                                                </a>
                                            </p>
                                            <div id="form">
                                                <?php
//Upload File
                                                if (isset($_POST['submit'])) {
                                                    $file_name = $_FILES['filename']['tmp_name'];
                                                    if (empty($file_name)) {
                                                        echo "PLz Select file";
                                                        ?><script>
                                                                    alert("PLz Select file");
                                                        </script>
                                                        <?
                                                        return false;
                                                    }
                                                    $type = explode(".", $_FILES['filename']['tmp_name']);
                                                    if (strtolower(end($type)) != 'csv') {
                                                        echo "Plz enter csv file";
                                                        return false;
                                                    } else {
                                                        $handle = fopen($_FILES['filename']['tmp_name'], "r");
                                                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                                            if (!empty($data[34])) {
                                                                $date = getdbDate($data[34]);
                                                                $date = str_replace("/", "-", $date);
                                                                $date = explode("-", $date);
                                                                $year = $date[0];
                                                                $month = $date[1];
                                                            }

                                                            $sql1 = "SELECT `emp_id` FROM `mpc_employee_master` WHERE `ticket_no` = $data[1]";
                                                            $result = mysql_query($sql1) or die(mysql_error());
                                                            if (mysql_num_rows($result) > 0) {
                                                                $row = mysql_fetch_array($result);
                                                                $empid = $row[0];

                                                                $j = 1;
                                                                for ($c = 3; $c < 34; $c++) {
                                                                    $status = $data[$c];
                                                                    $date = $year . '-' . $month . '-' . $j;
                                                                    $j++;
                                                                    if (!empty($status) and $empid != '0' and $empid != NULL) {
                                                                        $import = "INSERT into mpc_attendence_master(rec_id,emp_id,attendance_status,date) values('','$empid','$status','$date')";
                                                                        $i++;
                                                                        mysql_query($import) or die(mysql_error());
                                                                    }
                                                                }
                                                            }
                                                        }

                                                        fclose($handle);

                                                        print "Import done";

                                                        //view upload form
                                                    }
                                                } else {

                                                    print "Upload new csv by browsing to file and clicking on Upload<br />\n";

                                                    print "<form enctype='multipart/form-data' action='' method='post'>";

                                                    print "File name to import:<br />\n";

                                                    print "<input size='50' type='file' name='filename'><br />\n";

                                                    print "<input type='submit' name='upload_submit' value='Upload'></form>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
<!--for inserting and updating the data as per daya-->
<?php
if (isset($_POST['btn_attend'])) {
    $attendace = $_POST['attendace'];
    $ticket_no = $_POST['emp_id'];
    $date = $_POST['txt_date'];
    $shift = $_POST['shift'];
    $emp_id = $_POST['idd'];
    $i = 0;
    foreach ($emp_id as $emp_id) {
//        echo $emp_id;
        $sql = mysql_query("select emp_id from mpc_employee_master where ticket_no='$emp_id'");
        $r = mysql_fetch_array($sql);
        $sql = "select * from mpc_attendence_master where emp_id = '$r[emp_id]' and date = '$date'";

        $result_doc = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

        if ($rows = mysql_num_rows($result_doc) > 0) {
            $sql_check_update = "update " . $mysql_table_prefix . "attendence_master set	
				attendance_status='$attendace[$i]',badli_as ='$badli_as',
				shift ='$shift'where emp_id ='$r[emp_id]' and date ='$date'";

            $result_check_update = mysql_query($sql_check_update) or die("Query Failed " . mysql_error());

            if (!$result_check_update) {
                echo "Data is not inserted ";
            } else {

                echo "Data is inserted..";
            }
        } else {
            $sqll = mysql_query("insert into mpc_attendence_master (emp_id,attendance_status,shift,date,time,time_out) values ('$r[emp_id]','$attendace[$i]','$shift','$date','now()','now()') ");

            if (!$sqll) {
                ?>
                echo "Data is not inserted ";
                } else {
                ?>
                <?php
                echo "Data is inserted..";
            }
        }
        $i++;
    }

    if (!$result_check_update and ! $sqll) {
        ?> 
        <center>
            <?php echo "There is some error plz check it ...."; ?>
            <center>
                <?php
            } else {
                ?>
                <center>
                    <?php echo "successful"; ?>
                </center>
                <?php
            }
            include ("inc/hr_footer.php");
        }
        ?>
        <!--My code end here-->
        <!--  my code for magring two page in one page....-->
        <link rel="stylesheet" type="text/css" href="inc/popup.css">
        <script>
            $(function () {
                $('.footer').hide();
            });
        </script>
        <?
        $date = "";
        ?>
        <script type="text/javascript" src="javascript/form.js"></script>
        <script type="text/javascript" src="javascript/popup.js"></script>
        <style>
            #vpb_pop_up_background {
                background: none repeat scroll 0 0 #000000;
                border: 1px solid #cecece;
                display: none;
                height: 100%;
                left: 0;
                opacity: 0.4;
                position: fixed;
                top: 0;
                width: 100%;
                z-index: 99999999;
            }
            #vpb_signup_pop_up_box {
                background-color: #ffffff;
                border: 1px solid #000000;
                border-radius: 15px;
                box-shadow: 0 0 20px #000000;
                display: none;
                font-family: Verdana, Geneva, sans-serif;
                font-size: 11px;
                padding: 10px 20px;
                position: absolute;
                right: 30%;
                top: 0;
                width: 420px;
                z-index: 2147483647;
                margin-top:250px;
            }
            #vpb_signup_pop_up_box {
                display:none;
            }
        </style>
        <script>
            function show_popup()
            {
                document.getElementById('vpb_pop_up_background').style.display = "block";
                document.getElementById('vpb_signup_pop_up_box').style.display = "block";
            }
            function hide_popup()
            {
                document.getElementById('vpb_pop_up_background').style.display = "none";
                document.getElementById('vpb_signup_pop_up_box').style.display = "none";
            }
        </script>
        <?
////////////////////// Markin attendence //////////////
        if (isset($_POST['btn_attend'])) {

            $emp_id = $_POST['emp_id'];
            $emp_name = $_POST['emp_name'];
            $txt_date = getdbDate($_POST['txt_date']);
            $txt_todate = getdbDate($_POST['txt_todate']);
            echo "----" . $diff = abs(strtotime($txt_todate) - strtotime($txt_date));

            $ip = $_SERVER['REMOTE_ADDR'];
            $i = 1;
            foreach ($emp_id as $id) {
                $id;
                $hr = $_POST['fldHour_' . $i];
                $min = $_POST['fldMin_' . $i];

                $hr_out = $_POST['out_Hour_' . $i];
                $min_out = $_POST['out_Min_' . $i];


                $status = $_POST['attendace' . $id];

                $good_work = $_POST['good_work_' . $id];
                $sec = "00";

                $time = $hr . ":" . $min . ":" . $sec;
                $time_out = $hr_out . ":" . $min_out . ":" . $sec;

                $sql_check = "insert into " . $mysql_table_prefix . "attendence_master set	
				emp_id ='$id',emp_name='$emp_name',attendance_status='$status',
																			date ='$txt_date',
																			todate ='$txt_todate',

																			time ='$time',
																			time_out ='$time_out',
																			good_work ='$good_work',
																			InsertBy ='$id',
																			InsertDate =now(),
																			IpAddress ='$ip'";

                $result_check = mysql_query($sql_check) or die("Query Failed " . mysql_error());
                $i++;
            }
        }
        ?>
        <script>
            function shift_check(str)
            {
                if (str.value == "Staff")
                {
                    document.getElementById('div_txt_autocomplete').innerHTML = "<input type=\"text\" value=\"\" id=\"mon_employee_id\" onkeyup=\"get_frm('get_employee_list_monthly.php',this.value+'&type='+document.getElementById('mon_employee_type').value+'&shift=A'+'&sdate='+document.getElementById('mon_txt_date1').value,'div_employee_list',document.getElementById('mon_txt_date').value);\" onkeydown=\"if(event.keyCode && event.keyCode == 13){if(document.getElementById(\'attendace\')){document.getElementById(\'attendace\').focus();}else{if(document.getElementById(\'update_emp\')){document.getElementById(\'update_emp\').focus();}else{alert(\'Wrong Id'\)}}}\"/>";
                }
                else if (str.value == "Worker")
                {
                    document.getElementById('div_txt_autocomplete').innerHTML = "<input type=\"text\" value=\"\" id=\"mon_employee_id\" onkeyup=\"get_frm('get_employee_list_monthly.php',this.value+'&type='+document.getElementById('mon_employee_type').value+'&shift='+A+'&sdate='+document.getElementById('mon_txt_date1').value,'div_employee_list',document.getElementById('mon_txt_date').value);\" onkeydown=\"if(event.keyCode && event.keyCode == 13){if(document.getElementById(\'designation\')){document.getElementById(\'designation\').focus();}else{if(document.getElementById(\'update_emp\')){document.getElementById('').focus();}else{alert(\'Wrong Id'\);}}}\"/>";
                }
            }</script>
        <script>
            function validate_attendence()
            {
                document.getElementById('mon_employee_id').value;
                return(
                        checkString(document.frm_emp_list.mon_txt_date, "Date", false) &&
                        checkString(document.frm_emp_list.mon_employee_type, "Employee Type", false) &&
                        checkString(document.frm_emp_list.mon_txt_date1, "S_date", false) &&
                        checkString(document.frm_emp_list.mon_employee_id, "Employee id", false)
                        );
            }
        </script> 
        <?
        $current_date = date('d');
        $current_month = date('m');
        $current_year = date('Y');
        ?>
        <div data-role="main" class="ui-content">
            <div data-role="popup" id="myPopup"> </div>
            <DIV id=modal style="DISPLAY: none;">
                <div style="padding: 0px; background-color: rgb(37, 100, 192); visibility: visible; position: relative; width: 222px; height: 202px; z-index: 10002; opacity: 1;">
                    <div onClick="Popup.hide('modal')" style="padding: 0px; background: transparent url(./images/close.gif) no-repeat scroll 0%; visibility: visible; position: absolute; left: 201px; top: 1px; width: 20px; height: 20px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; cursor: pointer; z-index: 10004;" id="adpModal_close"></div>
                    <div style="padding: 0px; background: transparent url(resize.gif) no-repeat scroll 0%; visibility: visible; position: absolute; width: 9px; height: 9px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; cursor: nw-resize; z-index: 10003;" id="adpModal_rsize"></div>
                    <div style="padding: 0px; overflow: hidden; background-color: rgb(140, 183, 231); visibility: visible; position: absolute; left: 1px; top: 1px; width: 220px; height: 20px; font-family: arial; font-style: normal; font-variant: normal; font-weight: bold; font-size: 9pt; line-height: normal; font-size-adjust: none; font-stretch: normal; color: rgb(15, 15, 15); cursor: move;" id="adpModal_adpT"></div>
                    <div style="border-style: inset; border-width: 0px; padding: 8px; overflow: hidden; background-color: rgb(118, 201, 238); visibility: visible; position: absolute; left: 1px; top: 21px; width: 204px; height: 164px; font-family: MS Sans Serif; font-style: normal; font-variant: normal; font-weight: bold; font-size: 11pt; line-height: normal; font-size-adjust: none; font-stretch: normal; color: rgb(28, 94, 162);" id="adpModal_adpC">
                        <center>
                            <p>
                            <div id="div_message"></div>
                            </p>
                            <p style="font-size: 10px; color: rgb(253, 80, 0);">To gain access to the page behind the popup must be closed</p>
                        </center>
                    </div>
                </div>
            </DIV>
            <iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:5000; position:absolute; left:-500px; top:0px;"> </iframe>
            <? include ("inc/hr_footer.php"); ?>


            <!--My code End here-->
