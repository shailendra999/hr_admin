<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
$id="";
$start=0;
$id = $_GET["id"];
$check = $_GET["str"];
$deduction_date="";
if($check=="name")
	{
	 $sql = "SELECT mpc_employee_master.*,mpc_weekly_off_employee.* FROM  ".$mysql_table_prefix."employee_master ,mpc_weekly_off_employee where mpc_employee_master.rec_id=mpc_weekly_off_employee.emp_id and first_name like '$id%' order by first_name";

$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	}
	else
	{
	  $sql = "SELECT mpc_employee_master.*,mpc_weekly_off_employee.*,mpc_weekly_off_employee.rec_id as weekly_id FROM  ".$mysql_table_prefix."employee_master,mpc_weekly_off_employee where mpc_employee_master.rec_id=mpc_weekly_off_employee.emp_id and ticket_no like '$id' order by first_name ";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	}
if(mysql_num_rows($result)>0)
{
	$sno=1;
	?>
	<form id="frm_emp_list" name="frm_emp_list" method="post" action="">
		<table width="100%" align="center" cellpadding="2" cellspacing="2" border="0" class="border">
			<tr class="blackHead">
				<td align="center">Employee Id</td>
				<td align="center">Employee Name</td>
				<td align="center">Weekly Off Day</td>
				<td align="center">From</td>
				<td align="center">To</td>
                <td align="center">Edit</td>
                <td align="center">Delete</td>
			</tr>
            <?
				while($row = mysql_fetch_array($result))
					{
			?>
			<tr <? if ($sno%2==1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
				<td align="center">
					<?=$row["ticket_no"]?>
				</td>
				<td align="center">
					<?=$row["first_name"]?> <?=$row["last_name"]?> 
				</td>
				<td align="center">
					<?=$row["off_day"]?>
				</td>
                 <td align="center">
					<?=$row["from_date"]?>
				</td>
                 <td align="center">
					<? if($row["to_date"]=='0000-00-00'){echo 'TODAY';}else{echo $row["to_date"]; }?>
				</td>
                <td align="center"><a href="javascript:;" onClick="get_frm('edit_weeklyoff_list.php','<?=$row["weekly_id"]?>','div_edit','')"><img src="images/Modify.png" alt="Edit" title="Edit" border="0"></a>
                </td>
                <td align="center"><a href="javascript:;" onClick="overlay(<?=$row["weekly_id"]?>);">
<img src="images/Delete.png" alt="Delete" title="Delete" border="0"></a>
                </td> 
			</tr>
			<?
			}
			$emp_id=$row["emp_id"];
			$sno++;    
			?>   
	</table>
	</form>
<?
 	}
	else
	{
		?>
        <table width="100%" align="center" cellpadding="2" cellspacing="2" border="0" class="border">
			<tr class="blackHead">
				<td align="center">No Designation</td>
			</tr>
        </table>
        <?
	}

?>