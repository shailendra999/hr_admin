<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
$id="";
$id = $_GET["id"];
$check = $_GET["str"];
if($check=="name")
	{
$sql = "SELECT mpc_employee_master.*,mpc_official_detail.emp_category,mpc_official_detail.emp_id,mpc_account_detail.emp_id,mpc_account_detail.date_releaving FROM  ".$mysql_table_prefix."employee_master,mpc_account_detail,mpc_official_detail where mpc_employee_master.rec_id=mpc_account_detail.emp_id  and mpc_employee_master.rec_id=mpc_official_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' and first_name like '$id%' order by first_name";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	}
	else
	{
	$sql = "SELECT mpc_employee_master.*,mpc_official_detail.emp_category,mpc_official_detail.emp_id,mpc_account_detail.emp_id,mpc_account_detail.date_releaving FROM mpc_employee_master,mpc_account_detail,mpc_official_detail where mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_employee_master.rec_id=mpc_official_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' and  ticket_no like '$id' order by first_name";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	}
if(mysql_num_rows($result)>0)
{
?>
	<table width="100%" align="center" cellpadding="2" cellspacing="2" border="0" class="border">
    	<tr class="blackHead">
        	<td width="7%" align="center">Name</td>
            <td width="21%" align="center">Previlage Leave</td>
            <td width="21%" align="center">Casual Leave</td>
            <td width="12%" align="center">Absent</td>
            <td width="12%" align="center">Present</td>
            <td width="12%" align="center">Total working Days</td>
		</tr>
<?	
	while ($row=mysql_fetch_array($result))
	{
	?>
		<tr <? if ($row%2==1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
        	<td align="center">
            	<?=$row["first_name"]?>
            </td>
            <td align="center">
            	<? $left_pl=getLeaveAllowed("pl",$row["emp_category"])-getLeave($row["emp_id"],"Pl")?>
                <?
					if($left_pl==0)
						{
					    	echo $left_pl; 
						}
					else
						{
						?>
                        	<a href="leave_application.php?emp_id=<?=$row["emp_id"]?>&leave_type=PL"><?=$left_pl?></a>
						<?	
						}
						
				?>
            </td>
             <td align="center">
            	<? $left_cl=getLeaveAllowed("cl",$row["emp_category"])-getLeave($row["emp_id"],"Cl")?>
                 <?
					if($left_cl==0)
						{
					    	echo $left_cl; 
						}
					else
						{
						?>
                        	<a href="leave_application.php?emp_id=<?=$row["emp_id"]?>&leave_type=CL"><?=$left_cl?></a>
						<?	
						}
						
				?>
            </td>
             <td align="center">
            	<?=getLeavestatus($row["emp_id"],"A")?>
            </td>
             <td align="center">
            	<?=getLeavestatus($row["emp_id"],"P")?>
            </td>
		</tr>
	<?
	} 
}
?>
</table>