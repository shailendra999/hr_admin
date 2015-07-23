<?
include('inc/dbconnection.php');
$id="";
$id = $_GET["id"];
$off_day ="";
$rotation_type="";
$shift="";
$sql = "SELECT * FROM  mpc_shift_detail where emp_id = '$id' and to_date='0000-00-00'";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result)>0)
{
	while($row = mysql_fetch_array($result))
	{
		$shift=$row['shift'];
	} 
}
$sql = "SELECT * FROM  mpc_weekly_off_employee where emp_id = '$id' and to_date='0000-00-00'";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result)>0)
{
	while($row = mysql_fetch_array($result))
	{
		$off_day=$row['off_day']; 	
	} 
}
$sql = "SELECT * FROM  mpc_rotation_type_employee where emp_id = '$id' and to_date='0000-00-00'";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result)>0)
{
	while($row = mysql_fetch_array($result))
	{
		$rotation_type=$row['rotation_type']; 	

	} 
}
?>
<form action="" method="post" name="frm_shift" id="frm_shift">
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
	<tr>
    	<td colspan="2" class="blackHead">Shift Detail</td>
    </tr>
	<tr>
    	<td align="left">
        	<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
            	<tr>
                	<td class="text_1" width="40%">Rotation Type</td>
                    <td align="left" width="60%">
                    	<div id="div_rotation_type_edit"><?=$rotation_type?><div id="div_rotation_type"></div>
                        </div>
                     </td>
                     <td class="text_1">
                     	
                        
                        <a href="javascript:;" onclick="get_frm('change_rotation.php','<?=$rotation_type?>','div_rotation_type_edit','<?=$id?>')">Change</a>
                    </td>
                </tr>
            	<tr>
                	<td class="text_1">Shift</td>
                    <td align="left">
                    <div id="div_shift_type_edit"><?=$shift?><div id="div_shift_type"></div>
                        </div>
                    </td>
                     <td class="text_1">
                        <a href="javascript:;" onclick="get_frm('change_shift.php','<?=$shift?>','div_shift_type_edit','<?=$id?>')">Change</a>
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                <tr>
                    <td class="text_1" width="40%">Weekly OFF day</td>
                    <td align="left" width="60%">
                     <div id="div_weekly_off_edit"><?=$off_day?><div id="div_weekly_off"></div>
                        </div>
                    </td>
                    <td class="text_1">
                        <a href="javascript:;" onclick="get_frm('change_weekly.php','<?=$off_day?>','div_weekly_off_edit','<?=$id?>')">Change</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
<!--    <tr>
    	<td colspan="2" align="center">
        	<input type="image" src="images/btn_submit.png" name="submit_shift" id="submit_shift" value="Submit"/>
            <input type="hidden" name="emp_id" id="emp_id" value="<?=$id?>"/>
        </td>
    </tr>-->
</table>
</form>