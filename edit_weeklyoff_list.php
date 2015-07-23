<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
$url = "list_weeklyoff_employee.php";
$basic ="";
$from_date ="";
$to_date ="";
if(isset($_GET["id"]))
{
	$weeklyoff_id = $_GET["id"];
		
	$sql = "select * from mpc_weekly_off_employee where rec_id = '$weeklyoff_id'";
	$result = mysql_query($sql) or die("Error in sql : ".mysql_errno()." : ".mysql_error()." : ".$sql);	
	$row = mysql_fetch_array($result);
	
	$emp_id = $row["emp_id"];
	$off_day  = $row["off_day"];
	$from_date = getDatetime($row["from_date"]);
	if($row["to_date"]=='0000-00-00')
		{
			$to_date = date('d/m/Y');
		}
		else
		{
			$to_date = getDatetime($row["to_date"]);
		}
	$weeklyoff_id = $row["rec_id"];
}
?>
<form name="frm" action="<?=$url?>" method="post">
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
		<td align="center" valign="middle">
			<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td align="left" class="text_1" style="padding-left:15px;"><b>Weekly Off day</b></td>
                    <td align="left">
						<select name="off_days" id="off_days" style="width:150px; height:20px;">
                            <option value="Sunday" <? if($off_day=='Sunday'){echo 'selected="selected"';}?> >Sunday</option>
                            <option value="Monday" <? if($off_day=='Monday'){echo 'selected="selected"';}?>>Monday</option>
                            <option value="Tuesday" <? if($off_day=='Tuesday'){echo 'selected="selected"';}?>>Tuesday</option>
                            <option value="Wednesday" <? if($off_day=='Wednesday'){echo 'selected="selected"';}?>>Wednesday</option>
                            <option value="Thursday" <? if($off_day=='Thursday'){echo 'selected="selected"';}?>>Thursday</option>
                            <option value="Friday" <? if($off_day=='Friday'){echo 'selected="selected"';}?>>Friday</option>
                            <option value="Saturday" <? if($off_day=='Saturday'){echo 'selected="selected"';}?>>Saturday</option>
                        </select>  
                    </td>
                    <td align="left" class="text_1"><b>From</b></td>
                    <td align="left"><input type="text" name="txt_from_date" id="txt_from_date" value="<?=$from_date?>" style="width:100px; height:20px;"/><a href="javascript:void(0)" onclick="gfPop.fPopCalendar(document.frm.txt_from_date);"><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="27" height="22" border="0" alt=""/></a>
            		</td>
                    <td align="left" class="text_1"><b>To</b></td>
                    <td align="left"><input type="text" name="txt_to_date" id="txt_to_date" value="<?=$to_date?>" style="width:100px; height:20px;"/><a href="javascript:void(0)" onclick="gfPop.fPopCalendar(document.frm.txt_to_date);"><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="27" height="22" border="0" alt=""/></a>
            		</td>
                    <td align="center" style="padding-top:5px;">
                                                                        
                            <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                            <input type="hidden" name="emp_id" id="emp_id" value="<?=$emp_id?>" />
                            <input type="hidden" name="weeklyoff_id" id="weeklyoff_id" value="<?=$weeklyoff_id?>" />
                            <span style="padding-top:0px;">
                                <input type="image" src="images/Modify.png" name="image_edit" id="image_edit" alt="Edit Department" title="Edit Department">&nbsp;
                                <img src="images/Exit.png" alt="Cancel" title="Cancel" onClick="document.getElementById('div_edit').innerHTML='';">
                            </span>
						</td>
	            	</tr>
            	</table>
    	</td>
	</tr>
</table>
</form>