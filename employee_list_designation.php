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
$sql = "SELECT mpc_employee_master.*,mpc_designation_employee.* FROM  ".$mysql_table_prefix."employee_master ,mpc_designation_employee where mpc_employee_master.rec_id=mpc_designation_employee.emp_id and first_name like '$id%' ";

$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	}
	if ($check == 'id')
	{
/*
echo $sql = "SELECT mpc_employee_master.*,mpc_designation_employee.*,mpc_designation_employee.rec_id FROM  ".$mysql_table_prefix."employee_master,mpc_designation_employee where mpc_employee_master.rec_id=mpc_designation_employee.emp_id and mpc_employee_master.ticket_no like '$id' ";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
*/

$sql = "Select * From mpc_employee_master,mpc_designation_employee,mpc_designation_master Where mpc_employee_master.emp_id = mpc_designation_employee.emp_id AND mpc_designation_master.rec_id = mpc_designation_employee.designation_id AND mpc_employee_master.ticket_no LIKE '%$id%'";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
/*
$sql = "Select * From mpc_employee_master,mpc_designation_employee,mpc_designation_master
            Where mpc_employee_master.rec_id = mpc_designation_employee.emp_id AND mpc_designation_master.rec_id = mpc_designation_employee.designation_id
            AND mpc_employee_master.ticket_no LIKE '%$id%' ";
*/

	}
if ($check == 'employee')
{
$sql="SELECT  * FROM  ".$mysql_table_prefix."employee_master ,mpc_designation_employee,mpc_designation_master Where mpc_employee_master.rec_id = mpc_designation_employee.emp_id AND mpc_designation_master.rec_id = mpc_designation_employee.designation_id
                 AND mpc_designation_master.designation_name LIKE '%$id%' ";
	
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
				<td align="center">Designation</td>
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
                    <!--<input type="hidden" name="emp_id"  id="emp_id" value="<?//=$row["ticket_no"]?>">  -->
				<!--<input type="text" name="em" id="em" readonly="readonly" value="<?//=$row["ticket_no"]?>" />  -->
                </td>
				<td align="center">
					<?=$row["first_name"]?> <?=$row["last_name"]?> 
				</td>
				<td align="center">
					<?=getdesignationMaster('designation_name','rec_id',$row["designation_id"])?>
                    <input type="hidden" name="designation" id="designation_id" value="<?=$row["designation_id"]?>" />
				</td>
                 <td align="center">
					<?=$row["from_date"]?>
				</td>
                 <td align="center">
					<? if($row["to_date"]=='0000-00-00'){echo 'TODAY';}else{echo $row["to_date"]; }?>
				</td>
                <td align="center"><a href="javascript:;" onClick="get_frm('edit_designation_list.php','<?=$row["ticket_no"]?>','div_edit','')"><img src="images/Modify.png" alt="Edit" title="Edit" border="0"></a>
                </td>
                <td align="center"><a href="javascript:;" onClick="overlay(<?=$row["des_id"]?>);">
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