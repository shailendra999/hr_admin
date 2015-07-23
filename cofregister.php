<?php
include("inc/hr_header.php");
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $("#flip").click(function () {
            $("#panel").slideToggle("slow");
        });
    });
</script>
<style> 
    #panel,#flip
    {
        padding:5px;
        text-align:center;
        background-color:#e5eecc;
        border:solid 1px #c3c3c3;
    }
    #panel
    {
        padding:50px;
        display:none;
    }
    select,input[type="text"]{height:36px !important; width:185px !important;margin:5px 0;}
    input[type='text']{
        border-radius:5px;
        width:235px !important;
        height:35px !important;
        padding-left:2px !important;
        color:#6d6d6d !important;
    } 
</style>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
        <td align="left" valign="top" width="230px" style="padding-top:5px;">
            <? include ("inc/snb.php"); ?>
        </td> 
        <td style="padding-left:5px; padding-top:5px;" valign="top">
            <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                <tr>
                    <td align="center" class="gray_bg">
                        &nbsp;
                        <a href="#" style="text-decoration:none;color:gray;">
                            Attendance Master-> 
                        </a>
                        C/OFF Registered
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php
                        include("inc/dbconnection.php");
                        ?>

                        <div style="overflow:scroll;height:350px;width:100%; margin-top:10px;">
                            <table>
                                <tr>
                                    <td>Name</td>
                                    <td>
                                        <input type="radio" name="name" id="name">
                                    </td>
                                    <td>Id</td>
                                    <td>
                                        <input type="radio" name="name" id="id">
                                    </td>
                                    <td>
                                        <input type="text" name="txt_value" id="txt_value" />
                                    </td>
                                    <td>

                                    </td>
                                    <td>    
                                        <select id="dep_ref" name="dep_ref">
                                            <option value="0">
                                                Select Department
                                            </option>

                                            <?php
                                            $data = array();
                                            $index = array();
                                            $query = mysql_query("SELECT mpc_department_master.rec_id, mpc_department_master.reference_id, mpc_department_master.department_name FROM mpc_department_master ORDER BY department_name");

                                            while ($row = mysql_fetch_assoc($query)) {
                                                $id = $row["rec_id"];
                                                $parent_id = $row["reference_id"] === 0 ? "0" : $row["reference_id"];
                                                $data[$id] = $row;
                                                $index[$parent_id][] = $id;
                                            }

                                            function display($parent_id, $level, $index1, $data1) {
                                                $parent_id = $parent_id === 0 ? "0" : $parent_id;
                                                if (isset($index1[$parent_id])) {
                                                    foreach ($index1[$parent_id] as $id) {
                                                        echo '<option value=' . $data1[$id]["rec_id"] . '>' . str_repeat("_", $level) . $data1[$id]["department_name"] . '</option>';
                                                        display($id, $level + 1, $index1, $data1);
                                                    }
                                                }
                                            }

                                            display(0, 0, $index, $data);
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="button" name="sub" id="sub" value="search" onclick="coff_ajax()" />
                                    </td>
                                </tr>
                                </form>
                                <script>
                                    function coff_ajax() {
                                        var name = document.getElementById('name');
                                        var id = document.getElementById('id');
                                        var txt = document.getElementById('txt_value').value;
                                        var dep_ref = document.getElementById('dep_ref').value;
                                        var check_val = '';			//	alert(name);
                                        if (name.checked == true || id.checked == true) {
                                            if (txt == null || txt == "")
                                            {
                                                return false;
                                            }
                                            if (name.checked == true) {
                                                check_val = 'first_name';
                                            }
                                            if (id.checked == true) {
                                                check_val = 'ticket_no';
                                            }
                                            if (dep_ref != "0")
                                            {
                                                $.ajax({
                                                    type: 'POST',
                                                    url: "ajax_cofregister.php",
                                                    cache: false,
                                                    data: {
                                                        check: check_val,
                                                        txt: txt,
                                                        dll_dep: dep_ref
                                                    },
                                                    success: function (response)
                                                    {
                                                        document.getElementById('table').innerHTML = response;
                                                    }
                                                });
                                            }
                                            else if (dep_ref == "0")
                                            {
                                                $.ajax({
                                                    type: 'POST',
                                                    url: "ajax_cofregister.php",
                                                    cache: false,
                                                    data: {
                                                        check: check_val,
                                                        txt: txt

                                                    },
                                                    success: function (response)
                                                    {
                                                        document.getElementById('table').innerHTML = response;
                                                    }
                                                });
                                            }

                                        }
                                    }

                                </script>
                            </table>
                            <div id="table" >
                                <table width="100%" cellspacing="2" cellpadding="2" border="0" align="center"class="border">
                                    <tr bgcolor="#f3fbd2" class="tableTxt"><th align="center">Name</th>
                                        <th align="center">Attendance_Status</th>
                                        <th align="center">Avail Date</th>
                                        <th align="center">Holiday Date</th>
                                        <th align="center">Reason</th>
                                        <th align="center">EDIT REASON</th>
                                    </tr>
                                    <?php
                                    $que = mysql_query("select mpc_attendence_master.*,mpc_employee_master.first_name,mpc_employee_master.last_name from mpc_attendence_master,mpc_employee_master where mpc_attendence_master.attendance_status='C/OFF' and mpc_employee_master.emp_id=mpc_attendence_master.emp_id");
                                    while ($row = mysql_fetch_array($que)) {
                                        ?>
                                        <tr class="tableTxt" bgcolor="#F8F8F8"><td>
                                                <?php echo $row['first_name'] ?>&nbsp;<?php echo $row['last_name'] ?>
                                            </td><td align="center"><?php echo $row['attendance_status'] ?></td>
                                            <td align="center"><?php echo $row['date'] ?></td>
                                            <td align="center"><?php echo $row['avail_date'] ?></td>
                                            <td align="center"><?php echo $row['reason'] ?></td>
                                            <td align="center"><a href="update_cof.php?emp_id=<?php echo $row['emp_id'] ?>&name=<?php echo $row['first_name'] ?><?php echo $row['last_name'] ?>&attendance_status=<?php echo $row['attendance_status'] ?>&date=<?php echo $row['date'] ?>"><img border="0" title="Edit" alt="Edit" src="images/Modify.png"></a></td>
                                            <td align="center">PAID</td>
                                        </tr>
                                        <?php
                                    }
                                    $query1 = mysql_query("Select * from mpc_shift_detail");
                                    while ($result1 = mysql_fetch_array($query1)) {
                                        $off_day = $result1['off_day'];
                                        $e_id = $result1['emp_id'];
//                                        "select * from mpc_attendence_master where emp_id = '$e_id'";
                                        $query2 = mysql_query("select * from mpc_attendence_master where emp_id = '$e_id'");
                                        while ($row2 = mysql_fetch_array($query2)) {
                                            $date = new DateTime($row2['date']);
                                            $weekofday = $date->format('l');
                                            if ($off_day == $weekofday) {
                                                $status = $row2['attendance_status'];
                                                if ($status == 'P') {
                                                    
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </table>

                                <div id="flip">BALANCE C/OFF CLICK HERE</div></div>
                            <div id="panel"><div>
                                    <?php
                                    $que = mysql_query("select mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_attendence_master.*,
                                                        mpc_holiday_master.holiday_date from mpc_employee_master,
                                                        mpc_attendence_master,mpc_holiday_master 
                                                        where mpc_attendence_master.date=mpc_holiday_master.holiday_date
                                                        AND mpc_employee_master.emp_id=mpc_attendence_master.emp_id
                                                        AND mpc_attendence_master.attendance_status = 'p'");
                                    ?>
                                    <table width="100%" cellspacing="2" cellpadding="2" border="0" align="center"class="border">
                                        <tr bgcolor="#f3fbd2" class="tableTxt">
                                            <th align="center">Name</th>
                                            <th align="center">Attendance_Status</th>
                                            <th align="center">Holiday Date</th>
                                        </tr>       
                                        <?php
                                        while ($row = mysql_fetch_array($que)) {
                                            $emp_id = $row['emp_id'];
                                            $holiday_date = $row['holiday_date'];
                                            $effectiveDate = date('Y-m-d', strtotime("+3 months", strtotime($holiday_date)));
                                            $current_date = date('Y-m-d');
                                            $ques = mysql_query("select * from mpc_attendence_master where attendance_status='C/OFF' AND emp_id = $emp_id AND avail_date = '$holiday_date'");
                                            $num_rows = mysql_num_rows($ques);
                                            if ($num_rows == 0) {
                                                if (strtotime($current_date) < strtotime($effectiveDate)) {
                                                    ?>
                                                    <tr class="tableTxt" bgcolor="#F8F8F8">
                                                        <td>
                                                            <?php echo $row['first_name'] ?>&nbsp;<?php echo $row['last_name'] ?>
                                                        </td>
                                                        <td align="center">
                                                            <?php echo $row['attendance_status'] ?>
                                                        </td>
                                                        <td align="center"><?php echo $row['holiday_date'] ?></td>
                                                        <td align="center"><a id="pay" href="http://solutionsofts.com/lss/mark_attendance.php?emp_id=<?= $emp_id ?>&date=<?= $holiday_date ?>"><p>PAY</p></a></td>
                                                        <td align="center"><a href="http://solutionsofts.com/lss/cofregister.php?emp_id=<?= $emp_id ?>&date=<?= $holiday_date ?>">Delete</a></td>
                                                    </tr>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <tr class="tableTxt" bgcolor="#F8F8F8">
                                                        <td>
                                                            <?php echo $row['first_name'] ?>&nbsp;<?php echo $row['last_name'] ?>
                                                        </td>
                                                        <td align="center">
                                                            <?php echo $row['attendance_status'] ?>
                                                        </td>
                                                        <td align="center"><?php echo $row['holiday_date'] ?></td>
                                                        <td align="center">Expired </td>
                                                        <td align="center"><a href="http://solutionsofts.com/lss/cofregister.php?emp_id=<?= $emp_id ?>&date=<?= $holiday_date ?>">Delete</a></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        }
                                        $query1 = mysql_query("Select * from mpc_shift_detail");
                                        while ($result1 = mysql_fetch_array($query1)) {
                                            $off_day = $result1['off_day'];
                                            $e_id = $result1['emp_id'];
                                            $query2 = mysql_query("select mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_attendence_master.* from mpc_attendence_master,mpc_employee_master where mpc_attendence_master.emp_id = '$e_id' and mpc_employee_master.emp_id = '$e_id' AND mpc_attendence_master.emp_id = mpc_attendence_master.emp_id ");
                                            while ($row2 = mysql_fetch_array($query2)) {
                                                $date = new DateTime($row2['date']);
                                                $weekofday = $date->format('l');
                                                if ($off_day == $weekofday) {
                                                    $status = $row2['attendance_status'];
                                                    $ques = mysql_query("select * from mpc_attendence_master where attendance_status='C/OFF' AND emp_id = $e_id AND avail_date = '$row2[date]'");
                                                    $num_rows = mysql_num_rows($ques);
                                                    if ($num_rows == 0) {
                                                        if ($status == 'P') {
                                                            if (strtotime($current_date) < strtotime($effectiveDate)) {
                                                                ?>
                                                                <tr class="tableTxt" bgcolor="#F8F8F8">
                                                                    <td>
                                                                        <?php echo $row2['first_name']
                                                                        ?>&nbsp;<?php echo $row2['last_name'] ?>
                                                                    </td>
                                                                    <td align="center">
                                                                        <?php echo $row2['attendance_status'] ?>
                                                                    </td>
                                                                    <td align="center"><?php echo $wdate = $row2['date'] ?></td>
                                                                    <td align="center"><a id="pay" href="http://solutionsofts.com/lss/mark_attendance.php?emp_id=<?= $e_id ?>&date=<?= $wdate ?>"><p>PAY</p></a></td>
                                                                    <td align="center"><a href="http://solutionsofts.com/lss/cofregister.php?emp_id=<?= $e_id ?>&date=<?= $wdate ?>">Delete</a></td>
                                                                </tr>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <tr class="tableTxt" bgcolor="#F8F8F8">
                                                                    <td>
                                                                        <?php echo $row['first_name'] ?>&nbsp;<?php echo $row['last_name'] ?>
                                                                    </td>
                                                                    <td align="center">
                                                                        <?php echo $row['attendance_status'] ?>
                                                                    </td>
                                                                    <td align="center"><?php echo $row['holiday_date'] ?></td>
                                                                    <td align="center">Expired </td>
                                                                    <td align="center"><a href="http://solutionsofts.com/lss/cofregister.php?emp_id=<?= $emp_id ?>&date=<?= $holiday_date ?>">Delete</a></td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
//                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                            <?php
                            if (isset($_GET['emp_id'])) {
                                $emp_id = $_GET['emp_id'];
                                $date = $_GET['date'];
                                $que = mysql_query("delete from mpc_attendence_master where emp_id='$emp_id' and date='$date'");
                                if (!($que)) {
                                    echo"Data is not deleted";
                                } else {
                                    echo '<script>window.location="http://solutionsofts.com/lss/cofregister.php"</script>';
                                }
                            }
                            ?>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php
include("inc/hr_footer.php");
?>