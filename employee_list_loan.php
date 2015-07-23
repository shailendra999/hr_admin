<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>

<!--my code  -->
<!--<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script>
  $(function() {
    //$( "#dob" ).datepicker();
	$('.footer').hide();
  });
</script> -->
<!-- My code ende here-->

<?
$id="";
$start=0;
$id = $_GET["id"];
$check = $_GET["str"];
$deduction_date="";
if($check=="name")
	{
$sql = "SELECT mpc_employee_master.*,mpc_loan_employee.rec_id as loan_id,mpc_loan_employee.emp_id,mpc_loan_employee.loan_amount,mpc_loan_employee.loan_date,mpc_loan_employee.installments_decided FROM  ".$mysql_table_prefix."employee_master,mpc_loan_employee where mpc_employee_master.rec_id=mpc_loan_employee.emp_id and mpc_loan_employee.status='Open' and first_name like '$id%' order by first_name";
$sql = $sql ." LIMIT " . $start . ", $row_limit";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	}
	else
	{
	  $sql = "SELECT mpc_employee_master.*,mpc_loan_employee.rec_id as loan_id,mpc_loan_employee.emp_id,mpc_loan_employee.loan_amount,mpc_loan_employee.loan_date,mpc_loan_employee.installments_decided FROM  ".$mysql_table_prefix."employee_master,mpc_loan_employee where mpc_employee_master.rec_id=mpc_loan_employee.emp_id and mpc_loan_employee.status='Open' and ticket_no like '$id' order by first_name ";
	$sql = $sql ." LIMIT " . $start . ", $row_limit";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	}
if(mysql_num_rows($result)>0)
{
	?>
	<form id="frm_emp_list" name="frm_emp_list" method="post" action="">
		<table width="100%" align="center" cellpadding="2" cellspacing="2" border="0" class="border">
			<tr class="blackHead">
				<td align="center">Employee Id</td>
				<td align="center">Employee Name</td>
				<td align="center">Loan Amount</td>
                <td align="center">Loan Paid</td>
                <td align="center">Loan Left</td>
                <td align="center">Installment</td>
				<td align="center">Deduction Amount</td>
				<td align="center">Deduction Date</td>
				<td align="center">Deduction By</td>
			</tr>
	<?	$sno=1;
		$j=0;
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
					<?=$row["loan_amount"]?>
				</td>
                <td align="center">
					<?=$loanPaid=getloanPaid($row["loan_id"])?>
				</td>
                <td align="center">
					<?=$loan_left=($row["loan_amount"]-$loanPaid)?>
                    <input type="hidden" name="loan_left[]"  id="loan_left[]" value="<?=$loan_left?>"/>
				</td>
                <td align="center">
					<?=$row["installments_decided"]?>
				</td>
				<td align="center">
					<input type="text" name="deduction[]"  id="deduction[]" value="<?=$row["installments_decided"]?>"/>
				</td>
				<td align="center">
                  <input type="text" name="dob" id="dob" style="width:150px; height:20px;" value="<?=getDatetime($dob)?>" data-beatpicker="true" data-beatpicker-position="['right','*']" data-beatpicker-format="['DD','MM','YYYY']" />
					<?php /*?><input type="text" name="deduction_date_<?=$j?>" id="deduction_date_<?=$j?>" value="<?=$deduction_date?>" style="width:100px; height:20px;" readonly="readonly"/>
					   <a href="javascript:void(0)" onclick="gfPop.fPopCalendar(document.frm_emp_list.deduction_date_<?=$j?>);"><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="27" height="22" border="0" alt=""/></a> <?php */?>
				</td>
				 <td align="center">
					<select name="deduction_by[]" id="deduction_by[]">
						<option>-Select-</option>
						<option value="Cash">Cash</option>
						<option value="Cheque">Cheque</option>
						<option value="Salary">Salary</option>
					</select>
                    <input type="hidden" name="loan_id[]"  id="loan_id[]" value="<?=$row["loan_id"]?>"/>
				</td>
			</tr>
			<?
			$sno++;
			$j++;
			}     
	?>
			<tr bgcolor="#F8F8F8">
				<td colspan="8" align="center">
					
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
				<td align="center">No Loan Due</td>
			</tr>
         </table>
        <?
	}
	?>