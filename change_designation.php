<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
$designation_id = "";
if(isset($_GET["id"]))
{
	$emp_type = $_GET["id"];
	$emp_id1 = $_GET["str"];
	$emp_type_old = $_GET["old_cat"];
	$old_des_id = $_GET["old_des_id"];		
}
?>
<div id="designation_div">
<table width="40%" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" valign="middle">
			<?
			
			$sql = "SELECT * FROM  mpc_designation_master where emp_category ='$emp_type'order by designation_name";
			$result_city = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
			if(mysql_num_rows($result_city)>0)
			{
			?>
				<select name="designation" id="designation">
						<option value="">--Select--</option>
			<?
				while($row_city = mysql_fetch_array($result_city))
				{
			?> 
						<option value="<?=$row_city['rec_id']?>" <? if($row_city['rec_id']==$old_des_id){ echo 'selected="selected"';} ?>><?=$row_city['designation_name']?></option>
			<?
				}
			?>
				</select>
			<?    	
			}
			?>
         <td>
	</tr>
</table>
</div>