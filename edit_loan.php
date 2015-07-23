<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
$url = "list_loan.php";
$loan_amount = "";
$installments_decided = "";
$loan_date = "";
$loan_id = "";
if(isset($_GET["id"]))
{
	$loan_id = $_GET["id"];
	
	$sql = "select * from mpc_loan_employee where rec_id = '$loan_id'";
	$result = mysql_query($sql) or die("Error in sql : ".mysql_errno()." : ".mysql_error()." : ".$sql);	
	$row = mysql_fetch_array($result);
	
	$loan_amount = $row["loan_amount"];
	$installments_decided = $row["installments_decided"];
	$loan_date = getDatetime($row["loan_date"]);	
}
?>
<form name="frm" action="<?=$url?>" method="post">
<table width="60%" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
		<td align="center" valign="middle">
			<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td align="left" class="text_1" style="padding-left:15px;"><b>Loan Amount</b></td>
                    <td align="left"><input type="text" name="txt_loan" id="txt_loan" value="<?=$loan_amount?>" style="width:150px; height:20px;"/></td>
                    <td align="left" class="text_1" style="padding-left:15px;"><b>Loan Installment</b></td>
                    <td align="left"><input type="text" name="installments_decided" id="installments_decided" value="<?=$installments_decided?>" style="width:150px; height:20px;"/></td>
                    <td align="left" class="text_1"><b>Loan Date</b></td>
                    <td align="left"><input type="text" name="txt_date" id="txt_date" value="<?=$loan_date?>" style="width:150px; height:20px;"/><a href="javascript:void(0)" onclick="gfPop.fPopCalendar(document.frm.txt_date);"><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="27" height="22" border="0" alt=""/></a>
            		</td>
                    <td align="center" style="padding-top:5px;">
                                                                        
                            <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                            <input type="hidden" name="loan_id" id="loan_id" value="<?=$loan_id?>" />
                            <span style="padding-top:0px;">
                                <input type="image" src="images/Modify.png" name="image_edit" id="image_edit" alt="Edit Loan" title="Edit Loan">&nbsp;
                                <img src="images/Exit.png" alt="Cancel" title="Cancel" onClick="document.getElementById('div_edit').innerHTML='';">
                            </span>
						</td>
	            	</tr>
            	</table>
    	</td>
	</tr>
</table>
</form>