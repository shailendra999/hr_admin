<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
$id="";
$add_div = "";
$hidden_value = "";
$ticket_id = $_GET["id"];
$type = $_GET["type"];
$date = $_GET["str"];

$date = str_replace("/","-",$date);
$id=getemployeeDetailByTicket('rec_id',$ticket_id);
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
$day = substr($_GET["str"],0,2); 
$month = substr($_GET["str"],3,2);
$year = substr($_GET["str"],6,4);
$weekly_day=date("l", mktime(0,0,0,$month,$day,$year));
$holiday=getHoliday('holiday_name',$date);
$sql = "Select * from mpc_employee_master where emp_id = '$id'";

  $result_doc = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result_doc)>0)
	{
		
		$row = mysql_fetch_array($result_doc);
	
		$first_name = $row['first_name'];
		$last_name = $row['last_name'];
		
		$sql = "select * from mpc_attendence_master where emp_id = '$id' and date = '$date'";
		 $result_doc = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result_doc)>0)
	{
		
					$sno = 1;
				?>
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
						<td width="19%" align="center">Shift</td>
						<td width="19%" align="center">Attendance</td>
					   <td width="11%" align="center">Update</td>
				  </tr>
			<?
				while($row_doc = mysql_fetch_array($result_doc))
				{
			?>
					<tr <? if ($sno%2==1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
						<td align="center"><?=$sno?></td>
						<td align="center"><?=$ticket_id?></td>
						<td align="center"><?=$first_name?><?=$last_name?></td>
						 <? if($type!="Staff")
							{ 
						?>    
						<td>
							<? if($row_doc['badli_as']==""){echo 'None';}else{ echo getdesignationMaster('designation_name','rec_id',$row_doc['badli_as']); }?>
						</td>
						<?
						}
						?>
						 <td align="center"><?=$row_doc['shift']?></td> 
						 <td align="center"><?=$row_doc['attendance_status']?>  </td> 
						 <td>
							<a href="javascript:;" onclick="get_frm_focus('get_employee_list_udate.php','<?=$id?>&type=<?=$type?>&shift=<?=$shift?>','div_employee_list','<?=$date?>');" id="update_emp">update</a>
						</td>
					</tr>
			<?
				 $sno++;
				}
			?>           	    
			</table>
				<?
	
		
	}
	else 
	{
		
		
		if($holiday!="")
		{
		?>
		<table align="center" width="100%" border="0" class="border">
			<tr class="blackHead" >
				<td align="center">
					Holiday OFF:<?=$holiday?>
				</td>    
			</tr>
		</table>
		<?
		}
		else if($weekly_day==getweeklyoffDetail('off_day',$id,$date))
		{
				?>
			<table align="center" width="100%" border="0" class="border">
				<tr class="blackHead" >
					<td align="center">
						Weekly OFF:<?=$weekly_day?>
					</td>    
				</tr>
			</table>
				<?
		}
		else
		{
	
	
	$query_count = "select count(*) as count from ".$mysql_adm_table_prefix."document_master where DocumentFor = '$id'";
	
	$result_doc = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$query_count = $query_count;
	$result_q= mysql_query($query_count);
	$row_count = mysql_fetch_array($result_q);
	$numrows = $row_count['count'];
	$count = ceil($numrows/$row_limit);

		$sno = 1;
	?>
	<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
		<tr class="navigation_row">
			<td class="headingSmall">
				<div style="margin:1px;text-align:left;" >
					<?
					if(!$count==0)
					{
					?>
						<?=$numrows?> results found
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
				<? if($type!="Staff")
					{ 
				?>
				<td width="11%" align="center">Badli as</td>
				<?
					}
				?>
				<td width="19%" align="center">Attendance</td>
		  </tr>
	
			<tr <? if ($sno%2==1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
				<td align="center"><?=$sno?></td>
				<td align="center"><?=$ticket_id?></td>
				<td align="center"><?=$first_name?>&nbsp;<?=$last_name?></td>
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
							<option value="<?=$row_city['rec_id']?>"><?=$row_city['designation_name']?></option>
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
                	<?
						$leave_taken=getleavecheck("$date",$row_doc['emp_id']);
					?>
				   <select name="attendace" id="attendace" onkeydown="if (event.keyCode == 13) get_frm_attendence('get_employee_attendance_list.php','<?=$date?>','div_employee_last','<?=$id?>&str7=<?=$shift?>',document.getElementById('attendace').value,document.getElementById('designation').value,'<?=$type?>')">
					<option value="P">Present</option>
					<option value="CL" <? if($leave_taken=='CL'){echo 'selected="selected"';}?>>Casual Leave</option>
          <option value="CL" <? if($leave_taken=='CL'){echo 'selected="selected"';}?>>Half Casual Leave</option>
					<option value="PL" <? if($leave_taken=='PL'){echo 'selected="selected"';}?>>Prelilage Leave</option>
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
	       
	 <input type="hidden" id="count_row" name="count_row" value="<?=mysql_num_rows($result_doc)?>"/> 
	 <tr bgcolor="#F8F8F8">
		<td colspan="8" align="center">
			<input type="button" src="images/btn_submit.png" name="btn_attend" id="btn_attend" value="Submit" onclick=" get_frm_attendence('get_employee_attendance_list.php','<?=$date?>','div_employee_last','<?=$id?>&str7=<?=$shift?>',document.getElementById('attendace').value,document.getElementById('designation').value,'<?=$type?>')"/>
		</td>
	</tr>    	    
	</table>
	</div>
<?	
  }		
	
		
	}
		
	}
	else
	{
		?>
		<div align="center">No record found</div>	
	<?
}	
?>