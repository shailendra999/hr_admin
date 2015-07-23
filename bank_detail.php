<?
include('inc/dbconnection.php');
include('inc/function.php');
$id="";
$payment_mode="";
$id = $_GET["id"];
$sql = "SELECT * FROM  mpc_account_detail where emp_id  = '$id'";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result)>0)
{
	while($row = mysql_fetch_array($result))
	{
		$payment_mode=$row['payment_mode'];
		$bank_name=$row['bank_name'];
		$account_no=$row['account_no'];
	} 	
}
if($payment_mode!="")
{
	?>
<div id="div_update_releave">
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
	<tr>
    	<td colspan="2" class="blackHead">Bank Detail</td>
    </tr>
	<tr>
    	<td align="left" valign="top">
        	<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
            	<tr>
                	<td class="text_1" width="60%">Mode of Payment</td>
                    <td align="left" width="40%">
                   	<?=$payment_mode?>
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                <tr>
                    <td class="text_1" width="40%">Bank Name</td>
                    <td align="left" width="60%">
                       <?=$bank_name?>
                    </td>
                </tr>
                <tr>
                    <td class="text_1" width="40%">Account Number</td>
                    <td align="left" width="60%">
                        <?=$account_no?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
    	<td colspan="2" align="center">
        	<a onclick="post_frm('bank_update.php','0','div_update_releave','<?=$payment_mode?>','<?=$bank_name?>','<?=$account_no?>','<?=$id?>')">Edit</a>
        </td>
    </tr>
</table></div>
	<?
}
else
{
?>
<div id="div_insert_bank">
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
	<tr>
    	<td colspan="2" class="blackHead">Bank Detail</td>
    </tr>
	<tr>
    	<td align="left" valign="top">
        	<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
            	<tr>
                	<td class="text_1" width="60%">Mode of Payment</td>
                    <td align="left" width="40%">
                    <select id="payment_mode" name="payment_mode">
                    	<option value="Cash">Cash</option>
                        <option value="Cheque">Cheque</option>
                        <option value="Online">Online</option>
                    </select>
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                <tr>
                    <td class="text_1" width="40%">Bank Name</td>
                    <td align="left" width="60%">
                        	<input type="text" name="bank_name" id="bank_name" style="width:150px; height:20px;"/>
                    </td>
                </tr>
                <tr>
                    <td class="text_1" width="40%">Account Number</td>
                    <td align="left" width="60%">
                        	<input type="text" name="account_no" id="account_no" style="width:150px; height:20px;"/>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
    	<td colspan="2" align="center">
        	<input type="image" src="images/btn_submit.png" name="submit_pf" id="submit_pf" value="Submit" onclick="post_frm('bank_update.php','1','div_insert_bank',document.getElementById('payment_mode').value,document.getElementById('bank_name').value,document.getElementById('account_no').value,'<?=$id?>')"/>
        </td>
    </tr>
</table>
</div>
<?
}
?>