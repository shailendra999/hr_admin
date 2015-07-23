<?php
include ("inc/dbconnection.php");
include ("inc/function.php");

$id = "";
$add_div = "";
$hidden_value = "";
$ticket_id = $_GET["id"];
$type = $_GET["type"];
$date = getdbDate($_GET["str"]);
$date = str_replace("/", "-", $date);
$id = getemployeeDetailByTicket('emp_id', $ticket_id);
$day = substr($_GET["str"], 0, 2);
$month = substr($_GET["str"], 3, 2);
$year = substr($_GET["str"], 6, 4);

$shift = $_GET["shift"];

if (isset($_GET['start'])) {
    if ($_GET['start'] == 'All') {
        $start = 0;
    } else {
        $start = $_GET['start'];
    }
} else {
    $start = 0;
}
$day = substr($_GET["str"], 0, 2);
$month = substr($_GET["str"], 3, 2);
$year = substr($_GET["str"], 6, 4);
$weekly_day = date("l", mktime(0, 0, 0, $month, $day, $year));
$holiday = getHoliday('holiday_name', $date);
$sql = "Select * from mpc_employee_master where emp_id = '$id' and empType = '$type'";

$result_doc = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

if (mysql_num_rows($result_doc) > 0) {

    $row = mysql_fetch_array($result_doc);
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];

    $sql = "select * from mpc_attendence_master where emp_id = '$id' and date = '$date'";
    $result_doc = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
    if (mysql_num_rows($result_doc) > 0) {

        $emp_type = $row['empType'];
        $doj = $row['date_joining'];
        $doj_array = explode("-", $doj);
        $doj_month = $doj_array[1];
        $now = strtotime("01-01-01"); // or your date as well
        $your_date = strtotime($doj);
        $datediff = $now - $your_date;
        $pre_days = floor($datediff / (60 * 60 * 24));

        if ($pre_days > 0) {
            $sub = 365 - $pre_days;
        } else {
            $sub = 365 + $pre_days;
        }

        echo $tot = round((($sub / 3) * 2) / 20);

        $sno = 1;
        ?>
        <table align="center" width="100%" border="0" class="border">
            <tr class="blackHead">
                <td width="6%" align="center">S.No.</td>
                <td width="7%" align="center">Emp no.</td>
                <td width="21%" align="center">Employee Name</td>
                <?
                if ($type != "Staff") {
                    ?>
                    <td width="11%" align="center">Badli as</td>
                    <?
                }
                ?>
                <td width="19%" align="center">Shift</td>
                <td width="19%" align="center">Attendance</td>
                <td width="11%" align="center">Update</td>
            </tr>
            <?
            while ($row_doc = mysql_fetch_array($result_doc)) {
                ?>
                <tr <? if ($sno % 2 == 1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
                    <td align="center"><?= $sno ?></td>
                    <td align="center"><?= $ticket_id ?></td>
                    <td align="center"><?= $first_name ?><?= $last_name ?></td>
                    <?
                    if ($type != "Staff") {
                        ?>    
                        <td>
                            <?
                            if ($row_doc['badli_as'] == "") {
                                echo 'None';
                            } else {
                                echo getdesignationMaster('designation_name', 'rec_id', $row_doc['badli_as']);
                            }
                            ?>
                        </td>
                        <?
                    }
                    ?>
                    <td align="center"><?= $row_doc['shift'] ?></td> 
                    <td align="center"><?= $row_doc['attendance_status'] ?>  </td> 
                    <td>
                        <a href="javascript:;" onclick="get_frm_focus('get_employee_list_udate.php', '<?= $id ?>&type=<?= $type ?>&shift=<?= $shift ?>', 'div_employee_list', '<?= $date ?>');" id="update_emp" ><p style="color:black">update</p></a>
                    </td>
                </tr> 
                <?
                $sno++;
            }
            ?>           	    
        </table>
        <?
    } else {

        if ($holiday != "") {
            ?>
            <table align="center" width="100%" border="0" class="border">
                <tr class="blackHead" >
                    <td align="center">
                        <a href="javascript:;" onclick="get_frm_focus('get_employee_list_udate.php', '<?= $id ?>&type=<?= $type ?>&shift=<?= $shift ?>', 'div_employee_list', '<?= $date ?>');" id="update_emp">Holiday:<?= $holiday ?></a>
                    </td>    
                </tr>
            </table>
            <?
        } else if ($weekly_day == getweeklyoffDetail('off_day', $id, $date)) {
            ?>
            <table align="center" width="100%" border="0" class="border">
                <tr class="blackHead" >
                    <td align="center">
                        Weekly OFF:<?= $weekly_day ?>
                    </td>    
                </tr>
            </table>
            <?
        } else {


            $query_count = "select count(*) as count from " . $mysql_adm_table_prefix . "document_master where DocumentFor = '$id'";

            $result_doc = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
            $query_count = $query_count;
            $result_q = mysql_query($query_count);
            $row_count = mysql_fetch_array($result_q);
            $numrows = $row_count['count'];
            $count = ceil($numrows / $row_limit);

            $sno = 1;
            ?>
            <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
                <tr class="navigation_row">
                    <td class="headingSmall">
                        <div style="margin:1px;text-align:left;" >
                            <?
                            if (!$count == 0) {
                                ?>
                                <?= $numrows ?> results found
                                <?
                            }
                            ?>
                        </div>
                    </td>   
                </tr>
            </table> 
            <div> 
                <table align="center" width="100%" border="0" class="border">
                    <tr class="blackHead">
                        <td width="6%" align="center">S.No.</td>
                        <td width="7%" align="center">Emp no.</td>
                        <td width="21%" align="center">Employee Name</td>
                        <?
                        if ($type != "Staff") {
                            ?>
                            <td width="11%" align="center">Badli as</td>
                            <?
                        }
                        ?>
                        <td width="19%" align="center">Attendance</td>
                    </tr>

                    <tr <? if ($sno % 2 == 1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
                        <td align="center"><?= $sno ?></td>
                        <td align="center"><?= $ticket_id ?></td>
                        <td align="center"><?= $first_name ?>&nbsp;<?= $last_name ?></td>
                        <?
                        if ($type != "Staff") {
                            ?>
                            <td>
                                <?
                                $sql = "SELECT * FROM  mpc_designation_master where emp_category  = '$type' order by designation_name";
                                $result_city = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
                                if (mysql_num_rows($result_city) > 0) {
                                    ?>
                                    <select name="designation" id="designation" onkeydown="if (event.keyCode && event.keyCode == 13) {
                                                document.getElementById('attendace').focus();
                                            }">
                                        <option value="">--Select--</option>
                                        <?
                                        while ($row_city = mysql_fetch_array($result_city)) {
                                            ?> 
                                            <option value="<?= $row_city['rec_id'] ?>"><?= $row_city['designation_name'] ?></option>
                                            <?
                                        }
                                        ?>
                                    </select>
                                    <?
                                }
                                ?>
                            </td>
                            <?
                        } else {
                            ?>
                        <input type="hidden" name="designation" id="designation" value=""/>
                        <?
                    }
                    ?>
                    <td align="center">              
                        <?
//                        echo "yeee";
                        $leave_taken = getleavecheck("$date", $row_doc['emp_id']);
                        ?>
                        <select name="attendace" id="attendace" onchange="if (event.keyCode == 13)
                                    get_frm_attendence('get_employee_attendance_list.php', '<?= $date ?>', 'div_employee_last', '<?= $id ?>&str7=<?= $shift ?>', document.getElementById('attendace').value, document.getElementById('designation').value, '<?= $type ?>')">
                            <option value="P">Present</option>
                            <option value="CL" <?
                            if ($leave_taken == 'CL') {
                                echo 'selected="selected"';
                            }
                            ?>>Casual Leave</option>
                            <option value="CL" <?
                            if ($leave_taken == 'CL') {
                                echo 'selected="selected"';
                            }
                            ?>>Half Casual Leave</option>
                            <option value="PL" <?
                            if ($leave_taken == 'PL') {
                                echo 'selected="selected"';
                            }
                            ?>>
                                PL</option>
                            <option value="C/OFF" target="popup" onclick="window.open('coffavail.php?emp_id=<?= $id ?>&leave_taken=<?= $leave_taken ?>&shift=<?= $shift ?>', '', 'width=600,height=400')">C/OFF</option>
                            <option value="ML">Medical Leave</option>
                            <option value="HD">Half Day</option>
                            <option value="AL">Absent Without lEave</option>
                            <option value="AW">Allow to Work</option>
                            <option value="OD">Out Of Station</option>
                            <option value="S">Suspend</option>
                            <option value="R">Return</option>
                        </select>
                    </td>
                    </tr>
                    <input type="hidden" id="count_row" name="count_row" value="<?= mysql_num_rows($result_doc) ?>"/> 
                    <tr bgcolor="#F8F8F8">
                        <td colspan="8" align="center">
                            <!-- Function for submit --->

                            <input type="button" src="images/btn_submit.png" name="btn_attend" id="btn_attend" value="Submit" onClick="get_frm_attendence('get_employee_attendance_list.php', '<?= $date ?>', 'div_employee_last', '<?= $id ?>&str7=<?= $shift ?>', document.getElementById('attendace').value, document.getElementById('designation').value, '<?= $type ?>')"/>

                            <!-- Function for submit --->
                        </td>
                    </tr>    	    
                </table>
            </div>
            
            <?
        }
    }
	//my code is from here
	?>
     <?php
 $ToDate = getdbDate($_GET["str"]);
$ToDate = str_replace("/", "-", $ToDate);
$day = substr($_GET["str"], 0, 2);
$month = substr($_GET["str"], 3, 2);
$year = substr($_GET["str"], 6, 4);
 $FromDate=$year."-".$month."-01";

/*$FromDate=getdbDate($_POST['FromDate']);
$ToDate=getdbDate($_POST['ToDate']);
$FromDate = str_replace("/","-",$FromDate);
$ToDate = str_replace("/","-",$ToDate);   */
@include("inc/dbc$ToDate$ToDate$ToDate$ToDateonnection.php");
?>
<div style="overflow:scroll;height:300px;">
<table border="0" align="center" width="100%" style="overflow-y:scroll;" class="border">
					<tbody><tr class="blackHead">
					   <td align="center" width="6%">Employee Id</td>
					   <td align="center" width="7%">Insert Date</td>
                       <td align="center" width="8%">Employee Name</td>
					   <td align="center" width="21%">AttandanceStatus</td>
					   <td align="center" width="19%">Shift</td>


    					
				 <?php /* $que = mysql_query("SELECT mpc_attendence_master.*,mpc_employee_master.first_name,mpc_employee_master.last_name
FROM `mpc_attendence_master` inner join `mpc_employee_master` on mpc_employee_master.emp_id = mpc_attendence_master.emp_id
WHERE `date` between '$FromDate' and '$ToDate'"); */?>

				<?php 
	/*echo  "SELECT mpc_attendence_master.*,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_employee_master.ticket_no
FROM `mpc_attendence_master` inner join `mpc_employee_master` on mpc_attendence_master.emp_id =   mpc_employee_master.emp_id
WHERE `date` between '$FromDate' and '$ToDate' and emp_id=''$id";
	*/
	/*echo "SELECT mpc_attendence_master.*,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_employee_master.emp_id
FROM `mpc_attendence_master` inner join `mpc_employee_master` on mpc_attendence_master.emp_id =   mpc_employee_master.emp_id
WHERE ticket_no='$id' and `date` between '$FromDate' and '$ToDate' ticket_no='$id'";
	*/
	
	
	
	
	/*
	$que = mysql_query("SELECT mpc_attendence_master.*,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_employee_master.emp_id
FROM `mpc_attendence_master` inner join `mpc_employee_master` on mpc_attendence_master.emp_id =   mpc_employee_master.emp_id
WHERE ticket_no='$id' and `date` between '$FromDate' and '$ToDate' ticket_no='$id'");
	*/
/*	
	$que = mysql_query("SELECT mpc_attendence_master.*,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_employee_master.ticket_no
FROM `mpc_attendence_master` inner join `mpc_employee_master` on mpc_attendence_master.emp_id =   mpc_employee_master.emp_id
WHERE `date` between '$FromDate' and '$ToDate' and emp_id='$id'"); 
//print_r($que);
*/
if($day>1)
{
	/*$que=mysql_query("SELECT mpc_attendence_master.*,mpc_employee_master.first_name,mpc_employee_master.last_name FROM mpc_attendence_master, mpc_employee_master where mpc_attendence_master.emp_id = mpc_employee_master.emp_id AND date BETWEEN '$FromDate' AND '$ToDate'");
	*/
	"SELECT mpc_attendence_master.*,mpc_attendence_master.date,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_employee_master.emp_id FROM mpc_attendence_master, mpc_employee_master where mpc_attendence_master.emp_id = mpc_employee_master.emp_id AND date BETWEEN '$FromDate' AND '$ToDate' AND mpc_employee_master.emp_id='$id'";
	
	
	   $que=mysql_query("SELECT mpc_attendence_master.date,mpc_attendence_master.attendance_status,mpc_attendence_master.shift,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_employee_master.emp_id FROM mpc_attendence_master, mpc_employee_master where mpc_attendence_master.emp_id = mpc_employee_master.emp_id AND date BETWEEN '$FromDate' AND '$ToDate' AND mpc_employee_master.emp_id='$id'") ;
	  
	  	  	   $que1=mysql_query("Select date from mpc_attendence_master where emp_id='$id' AND date BETWEEN '$FromDate' AND '$ToDate''");
	   
	   
	   
}
else if($day == 1)
{
	$month;
	$year; 
	$month--;
	$date=$year."-".$month."-01";
	$FromDate=date($day)."<br>";
	$ToDate=date($day)."<br>";
    $FromDate=$year."-".$month."-01";
	$last_day_this_month  = date('Y-m-t');
//	$last_day_$month_2010;
	
	echo "$day = One"."SELECT mpc_attendence_master.*,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_employee_master.emp_id FROM mpc_attendence_master, mpc_employee_master where mpc_attendence_master.emp_id = mpc_employee_master.emp_id AND YEAR(Date) = '$year' AND MONTH(Date) = '$month' AND mpc_employee_master.emp_id='$id'";
	
	$que=mysql_query("SELECT mpc_attendence_master.*,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_employee_master.emp_id FROM mpc_attendence_master, mpc_employee_master where mpc_attendence_master.emp_id = mpc_employee_master.emp_id AND YEAR(Date) = '$year' AND MONTH(Date) = '$month' AND mpc_employee_master.emp_id='$id' ");

$last_day_this_month  = date('Y-m-t');


}

?>
<?php
$rows=mysql_num_rows($que);
$row = mysql_fetch_array($que);
$name=$row['first_name'];
$surname=$row['last_name']; 
$ticket_id = $_GET["id"];
$type = $_GET["type"];
$shift=$row['shift'];   
$day;
for($i=1;$i<=$day;$i++){
     echo $Dt=$year."-".$month."-".$i;
	 if($i<=$rows)
     {
		 
     while($row = mysql_fetch_array($que))
	      {
			  echo "Date=".$row[date];
			  var_dump($DT);
			  echo "<br>";
			  var_dump($row[date]);
			  if($row[date] ==  $DT)
			  {
				  echo "hihiihihihi";
			  
?>
						<tr bgcolor="#F8F8F8" class="tableTxt">
						<td align="center"><?php echo $ticket_id; ?></td>
						<td align="center"><?php echo $row[date]?></td>
						<td align="center"><?php echo $row['first_name'];?>&nbsp;<?php echo $row['last_name'];?></td>
					    <td align="center"><?php echo $row['attendance_status'];?></td> 
						 <td align="center"><?php echo $row['shift'];?> </td>
                        
						
					</tr>
                    </tbody>
                   <?php
				
         $i++;
	     }
		 else
		 {
			 echo "if value is not indata bse but in range in"."<br>";
			?>
            <tr bgcolor="#F8F8F8" class="tableTxt">
						<td align="center"><?php echo $ticket_id; ?></td>
						<td align="center"><?php echo $Dt=$year."-".$month."-".$i?></td>
						<td align="center"><?php echo $row['first_name'];?>&nbsp;<?php echo $row['last_name'];?></td>
					    <td align="center"><?php echo $row['attendance_status'];?></td> 
						 <td align="center"><?php echo $row['shift'];?> </td>
                        
						
					</tr>
                    </tbody>
                    <?php
			 
			 $i++;
		}
       }
	 }
	   else
	   {
		   echo "hihihih";
		   
		   ?>
		   <tr bgcolor="#F8F8F8" class="tableTxt">
						<td align="center"><?php echo $ticket_id;?></td>
						<td align="center"><?php echo $year."-".$month."-".$i?></td>
						<td align="center"><?php echo $name?>&nbsp;<?php echo $surname;?></td>
					    <td align="center"><?php echo $row['attendance_status'];?></td> 
						 <td align="center"><?php echo $row['shift'];?> </td>
                        
						
					</tr>
                    </tbody>
		   <?php 
		  }
}
?>
			           	    
			</table></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
    
    
    
    
<?php     
//ended here
}
else {
    ?>
    <div align="center">No record found</div>	
    <?
}
?>
