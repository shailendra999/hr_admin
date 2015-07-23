<?php
//if (isset($_POST['mon_submit'])) {
include ("inc/dbconnection.php");
include ("inc/function.php");
?>
<tr>
    <td>
        <?php // This code for daity attendance//   ?>
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
                    ?>

                    <?php /* ?> <select>

                      <?php
                      $que=mysql_query("SELECT * FROM `mpc_leave_master` WHERE emp_type='$employee_type' ");
                      while($a=mysql_fetch_array($que))
                      {?>
                      <?php  echo $a['leave_name'];   ?>
                      <option value="<?php echo $a;?>" <?php if ($data['attendance'][$i] == $a) { echo 'selected="selected"'; } ?> ><?php echo $a['leave_name']; ?></option>
                      <?php 	}    echo "<pre>" ;print_r($a);?>
                      </select>
                      <?php */ ?>



                    <?php foreach ($data['name'] as $d) {
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
                                    <option value="A">Absent</option>
                                    <!--<option value="c/off">Compensatory Off(c/off)</option>-->
                                    <!--<option value="C/OFF" target="popup" onclick="window.open('coffavail.php?emp_id=<?= $id ?>&$data['attendance'][$i] == $a['leave_name'] ?>&shift=<?= $shift ?>', '', 'width=600,height=400')">C/OFF</option>-->
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
                    <?php /* ?>    <?
                      if ($type != "Staff") {

                      }
                      ?>
                      <?php echo $attendance[$i]; ?>
                      <td align="center">
                      <select name="attendace[]" id="attendace">
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
                      ?><?php */ ?>
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