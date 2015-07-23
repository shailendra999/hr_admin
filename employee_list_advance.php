<link rel="stylesheet" href="css/BeatPicker.min.css"/>
<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/BeatPicker.min.js"></script>
<script>
  $(function() {
    //$( "#dob" ).datepicker();
	$('.footer').hide();
  });
</script>
<? include ("inc/dbconnection.php");?>

<?
$id="";
$start=0;
$id = $_GET["id"];
$check = $_GET["str"];
$deduction_date="";
if($check=="name")
	{
	 $sql = "SELECT mpc_employee_master.*,(sum(mpc_advance_employee.advance)-sum(mpc_advance_employee.deduction)) as net_advance FROM  ".$mysql_table_prefix."employee_master ,mpc_advance_employee where mpc_employee_master.rec_id=mpc_advance_employee.emp_id and first_name like '$id%' order by first_name";

$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	}
	else
	{
	  $sql = "SELECT mpc_employee_master.*,(sum(mpc_advance_employee.advance)-sum(mpc_advance_employee.deduction)) as net_advance FROM  ".$mysql_table_prefix."employee_master ,mpc_advance_employee where mpc_employee_master.rec_id=mpc_advance_employee.emp_id and ticket_no like '$id' order by first_name ";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	}
if(mysql_num_rows($result)>0)
{

	$row = mysql_fetch_array($result);
	if($row['net_advance']!=0)
	{
	$sno=1;
	?>
	<form id="frm_emp_list" name="frm_emp_list" method="post" action="">
		<table width="100%" align="center" cellpadding="2" cellspacing="2" border="0" class="border">
			<tr class="blackHead">
				<td align="center">Employee Id</td>
				<td align="center">Employee Name</td>
				<td align="center">Advance Amount</td>
				<td align="center">Deduction Amount</td>
                <td align="center">Deduction Date</td>
				<td align="center">Deduction By</td>
			</tr>
			<tr <? if ($sno%2==1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
				<td align="center">
					<?=$row["ticket_no"]?>
				</td>
				<td align="center">
					<?=$row["first_name"]?> <?=$row["last_name"]?> 
				</td>
				<td align="center">
					<?=$row['net_advance']?>
				</td>
                <td align="center">
					<input type="text" name="deduction"  id="deduction" value=""/>
				</td>
				<td align="center">
					<input type="text" name="deduction_date" id="deduction_date" value="" style="width:100px; height:20px;" data-beatpicker="true" />
				</td>
				 <td align="center">
					<select name="deduction_by" id="deduction_by">
						<option>-Select-</option>
						<option value="Cash">Cash</option>
						<option value="Cheque">Cheque</option>
						<option value="Salary">Salary</option>
					</select>
				</td>
			</tr>
			<?
			$emp_id=$row["rec_id"];
			$sno++;    
	?>
			<tr bgcolor="#F8F8F8">
				<td colspan="13" align="center">
					<input type="hidden" name="emp_id"  id="emp_id" value="<?=$emp_id?>"/>
					<input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
					<input type="submit" src="images/btn_submit.png" name="btn_submit" id="btn_submit" value="Submit"/>
				</td>
			</tr>    
	</table>
	</form>
<?
	}
	else
	{
		?>
        <table width="100%" align="center" cellpadding="2" cellspacing="2" border="0" class="border">
			<tr class="blackHead">
				<td align="center">No Advance Due</td>
			</tr>
        </table>
        <?
	}
 }
?>