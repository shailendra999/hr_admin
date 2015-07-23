<? include ("inc/hr_header.php"); ?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
        <td align="left" valign="top" width="230px" style="padding-top:5px;">
            <? include ("inc/snb.php"); ?>
        </td>
        <td style="padding-left:5px; padding-top:5px;">
            <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                <tr>
                    <td align="center" class="gray_bg">&nbsp; <a href="#" style="text-decoration:none;color:gray;">Attendance master-> </a>mark attendance</td>
                </tr>
                <tr>
                    <td class="heading" valign="top" style="padding-top:5px;">
             <form id="frm_emp_list" name="frm_emp_list" method="POST" >
             <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                    <tr>
                                    <td width="100%" colspan="2" align="center"><table cellpadding="0" cellspacing="0" border="0" align="center" class="loginbg">
                                            <tr>
                                                <td class="text_1" style="padding-left:15px;" width="12%">Attendence Date<span class="red">*</span></td>
                                                <td width="15%"><input type="text"
                                                                       name="txt_date" id="txt_date" value="<?= $date ?>" style="width:100px; height:20px;"data-beatpicker="true" data-beatpicker-format="['DD','MM','YYYY']"/></td>
                                                <td width="7%" class="text_1" style="padding-right:15px; text-align:right;">Type<span class="red">*</span></td>
                                                <td width="13%"><select name="employee_type" id="employee_type" onChange="shift_check(this)" style="width:100px; height:25px;" onkeydown="if (event.keyCode && event.keyCode == 13) {
                                                            document.getElementById('shift_detail').focus();
                                                        }">
                                                        <option value="">---Select---</option>
                                                        <option value="Staff">Staff</option>
                                                        <option value="Worker">Worker</option>
                                                    </select></td>
                                                <td width="16%" align="left" style="padding-left:20px;"><div id="div_shift">
                                                        <select name="shift_detail" id="shift_detail" onkeydown="if (event.keyCode && event.keyCode == 13) {
                                                                    document.getElementById('employee_id').focus();
                                                                }">
                                                            <option value="">---Select---</option>
                                                            <option value="A">A</option>
                                                            <option value="B">B</option>
                                                            <option value="C">C</option>
                                                            <option value="G">G</option>
                                                        </select>
                                                    </div></td>
                                                  <!-- <td>All</td>
                                                                          <td><input type="radio" name="rd" id="rd" value=""></td>  -->

<td width="13%" class="text_1" style="padding-right:15px; text-align:right;">Emp Id<!--<span class="red">*</span> --></td>
                                                <td width="17%" align="left" style="padding-left:20px;"><div id="div_txt_autocomplete">
                                                        <input type="text" name="employee_id" id="employee_id" value="">
                                                        <!--onfocus="validate_attendence();"/> --> 
                                                    </div></td>
                                                <td><input type="submit" name="submit" value="submit"></td>
                                            </tr>
                                        </table></td>
                                </tr>
                    
                    </table>
                        </form>
                        <?
                    if (isset($_POST['submit'])) {
                        $date = $_POST['txt_date'];
                        $date = getdbDate($date);
                        $date = str_replace("/", "-", $date);
                        $employee_type = $_POST['employee_type'];
                        $shift = $_POST['shift_detail'];
                        $id = $_POST['employee_id'];
                        //my code start from here

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
                                $first_name = $row['first_name'] . "<br>";
                                $last_name = $row['last_name'] . "<br>";
                                $emp_id['0'] = $row['emp_id'] . "<br>";
                                $data['name']['0'] = $first_name . $last_name . "<br>";
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
                                    ?>
                                                                <!--<th width="11%" align="center">Badli as</th> -->
                                    <?
                                }
                                ?>
                                <th width="19%" align="center">Shift</th>
                                <th width="19%" align="center">Attendance</th>
                                <!--   <td width="6%" align="center">All<input type="checkbox" name="mak" id="mal"></td>
                                                                 <td width="11%" align="center">Update</td>--> 
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
                                    <?
                                    if ($type != "Staff") {
                                        ?>
                                                                    <!--<td><? //if($row_doc['badli_as']==""){echo 'None';}else{ echo getdesignationMaster('designation_name','rec_id',$row_doc['badli_as']); }       ?></td>-->
                                        <?
                                    }
                                    ?>
                                    <!--<td align="center"></td>-->
                                    <?php echo $attendance[$i]; ?>
                                    <td align="center">
                                        <select name="attendace[]" id="attendace">
                                            <?php //if($status == 'Active') { echo 'selected="selected"'; } ?>
                                            <?php
                                            ?>
                                            <option value="P"<?
                                            if ($data['attendance'][$i] == 'P') {
                                                echo 'selected="selected": false';
                                            }
                                            ?>>Present</option>
                                            <option value="Cl" <?
                                            if ($data['attendance'][$i] == 'Cl') {
                                                echo 'selected="selected": false';
                                            }
                                            ?>>Casual Leave</option>
                                            <option value="hCl" <?
                                            if ($data['attendance'][$i] == 'HCL') {
                                                echo 'selected="selected" : false';
                                            }
                                            ?>>Half Casual Leave</option>
                                            <option value="Pl" <?
                                            if ($data['attendance'][$i] == 'PL') {
                                                echo 'selected="selected" :false';
                                            }
                                            ?>>Prelilage Leave</option>
                                            <option value="C/OFF" target="popup" onclick="window.open('coffavail.php?emp_id=<?= $id ?>&leave_taken=<?= $leave_taken ?>&shift=<?= $shift ?>', '', 'width=600,height=400')">C/OFF</option>
                                            <option value="ML" <?
                                            if ($data['attendance'][$i] == 'ML') {
                                                echo 'selected="selected": false';
                                            }
                                            ?>>Medical Leave</option>
                                            <option value="HD" <?
                                            if ($data['attendance'][$i] == 'HD') {
                                                echo 'selected="selected": false';
                                            }
                                            ?>>Half Day</option>
                                            <option value="AL" <?
                                            if ($data['attendance'][$i] == 'AL') {
                                                echo 'selected="selected": false';
                                            }
                                            ?>>Absent Without lEave</option>
                                            <option value="AW" <?
                                            if ($data['attendance'][$i] == 'AW') {
                                                echo 'selected="selected": false';
                                            }
                                            ?>>Allow to Work</option>
                                            <option value="OD" <?
                                            if ($data['attendance'][$i] == 'OD') {
                                                echo 'selected="selected": false';
                                            }
                                            ?>>Out Of Station</option>
                                            <option value="S" <?
                                            if ($data['attendance'][$i] == 'S') {
                                                echo 'selected="selected": false';
                                            }
                                            ?>>Suspend</option>
                                            <option value="R" <?
                                            if ($data['attendance'][$i] == 'R') {
                                                echo 'selected="selected": false';
                                            }
                                            ?>>Return</option>
                                        </select></td>
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
                        <?php }
                        ?>
                    
                    
                    
                    
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>