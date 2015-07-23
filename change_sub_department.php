<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
$url = "list_employee.php";
$product_name = "";
$dept_id = "";
if(isset($_GET["id"]))
{
	$dept_id = $_GET["id"];
	$old_dept_id = $_GET["old_dept_id"];
	$old_main_id=getdeptDetail('reference_id','rec_id',$old_dept_id);
	$emp_id = $_GET["str"];
}
?>
<table width="40%" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" valign="middle">
			<?
			$sql = "SELECT * FROM  mpc_department_master where reference_id = '$dept_id' order by department_name";
			$result_city = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
			if(mysql_num_rows($result_city)>0)
			{
			?>
				<select name="sub_department" id="sub_department">
						<option value="">--Select--</option>
			<?
				while($row_city = mysql_fetch_array($result_city))
				{
			?> 
						<option value="<?=$row_city['rec_id']?>"  <? if($row_city['rec_id']==$old_dept_id){?> selected="selected" <? } ?>><?=$row_city['department_name']?></option>
			<?
				}
			?>
				</select>
			<?    	
			}
			?>	
         </td>
	</tr>
</table>