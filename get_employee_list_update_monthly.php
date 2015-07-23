<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
/*$id="";
$add_div = "";
$hidden_value = "";
$id = $_GET["id"];

$type = $_GET["type"];
$date = $_GET["str"];
$date1 =$_GET["sdate"];

$shift = $_GET["shift"];*/

	$id="";
   $date1 =$_GET["startdate"];
   $date2=$_GET["enddate"];
   $id =$_GET["id"];
   $status =$_POST["str4"];
   $badli_as  =$_POST["str5"];
   $type=$_GET["type"];
   $shift=$_GET["shift"];
?>

<?
if(isset($_GET['start']))
{
	if($_GET['start']=='All')
	{
		$start = 0;
	}
	else
	{
		$start = $_GET['start'];
	}
}
else
{
	$start = 0;
}	
$sql = "SELECT emp_id,badli_as,date,attendance_status FROM mpc_attendence_master where date='$date1' and emp_id='$id'";
$result_doc = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result_doc)>0)
{
	$row_update = mysql_fetch_array($result_doc);
	$badli_as=$row_update['badli_as'];
	$attendance_status=$row_update['attendance_status'];
}

$sql = "SELECT mpc_employee_master.last_name,mpc_employee_master.first_name,mpc_employee_master.emp_id,mpc_employee_master.  	ticket_no FROM mpc_employee_master where mpc_employee_master.emp_id  and mpc_employee_master.rec_id = '$id'";
 
$query_count = "select count(*) as count from ".$mysql_adm_table_prefix."document_master where DocumentFor = '$id'";
$result_doc = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
$query_count = $query_count;
$result_q= mysql_query($query_count);
$row_count = mysql_fetch_array($result_q);
$numrows = $row_count['count'];
$count = ceil($numrows/$row_limit);
if(mysql_num_rows($result_doc)>0)
{
	$sno = 1;
?>
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr class="navigation_row">
        <td class="headingSmall">
            <div style="margin:1px;text-align:left;" >
               Update Employee Attendance
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
            <? if($type!="Staff")
				{ 
			?>
			<td width="11%" align="center">Badli as</td>
            <?
				}
			?>
            <td width="19%" align="center">Attendance</td>
      </tr>
<?
	while($row_doc = mysql_fetch_array($result_doc))
	{
?>
		<tr <? if ($sno%2==1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
            <td align="center"><?=$sno?></td>
            <td align="center"><?=$row_doc['ticket_no']?></td>
            <td align="center"><?=$row_doc['first_name']?>-<?=$row_doc['last_name']?></td>
             <? if($type!="Staff")
				{ 
			?>
            <td>
            	<?
			
			$sql = "SELECT * FROM  mpc_designation_master where emp_category  = '$type' order by designation_name";
			$result_city = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
			if(mysql_num_rows($result_city)>0)
			{
			?>
				<select name="designation" id="designation" onkeydown="if(event.keyCode && event.keyCode == 13){document.getElementById('attendace').focus();}">
						<option value="">--Select--</option>
			<?
				while($row_city = mysql_fetch_array($result_city))
				{
			?> 
						<option value="<?=$row_city['rec_id']?>" <? if($row_city['rec_id']==$badli_as) {echo 'selected="selected"';}?> ><?=$row_city['designation_name']?></option>
			<?
				}
			?>
				</select>
			<?    	
			}
			?>
            </td>
            <?
			}
			else
			{
				?>
				 <input type="hidden" name="designation" id="designation" value=""/>
				<?
            }
			?>
            <td align="center">              
<!--             <input type="hidden" id="emp_id[]" name="emp_id[]" value="<?=$row_doc['emp_id']?>"/> 
            	<?
					if(getleavecheck("$date",$row_doc['emp_id'])=="CL")
						{
						?>
						  <input type="radio" name="attendace<?=$row_doc['emp_id']?>" id="attendace<?=$row_doc['emp_id']?>" value="CL" checked="checked" readonly="readonly"/>Casual Leave
                        <?
						}
						else if(getleavecheck("$date",$row_doc['emp_id'])=="PL")
							{
							?>
							 <input type="radio" name="attendace<?=$row_doc['emp_id']?>" id="attendace<?=$row_doc['emp_id']?>" value="PL" checked="checked" readonly="readonly"/>Prelilage Leave
                            <?
							}
						else
						{
				?>
               <input type="radio" name="attendace<?=$row_doc['emp_id']?>" id="attendace<?=$row_doc['emp_id']?>" value="P" checked="checked"/>Present
               <input type="radio" name="attendace<?=$row_doc['emp_id']?>" id="attendace<?=$row_doc['emp_id']?>" value="A"/>Absent
               <?
			            }
			   ?>-->
               <select name="attendace" id="attendace" onkeydown="if(event.keyCode == 13){  get_frm_attendence('get_employee_attendance_list_update.php','<?=$date?>','div_employee_last','<?=$id?>&str7=<?=$shift?>',document.getElementById('attendace').value,document.getElementById('designation').value,'<?=$type?>') }">
               
               	<option value="P" <? if($attendance_status=='P'){echo 'selected="selected"';}?> >Present</option>
                <option value="CL" <? if($attendance_status=='Cl'){echo 'selected="selected"';}?>>Casual Leave</option>
                <option value="PL" <? if($attendance_status=='Pl'){echo 'selected="selected"';}?>>Prelilage Leave</option>
                <option value="A" <? if($attendance_status=='A'){echo 'selected="selected"';}?>>Absent</option>
                <option value="CO/COF">CO/COF</option>
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
<?
	 $sno++;
	}
?>       
 <input type="hidden" id="count_row" name="count_row" value="<?=mysql_num_rows($result_doc)?>"/> 
 <tr bgcolor="#F8F8F8">
    <td colspan="8" align="center">
        <input type="button" src="images/btn_submit.png" name="btn_attend" id="btn_attend" value="Submit" onclick="get_frm_attendence('get_employee_attendance_list_update_monthly.php','<?=$date1?>','div_employee_last','<?=$id?>&str7=<?=$shift?>&sdate=<?=$date2?>',document.getElementById('attendace').value,document.getElementById('designation').value,'<?=$type?>')"/>


    </td>
</tr>    	    
</table>
</div>
<?    	
}
else
{
?>
	<div align="center">no record found</div>	
<?
}	
?>	
          			