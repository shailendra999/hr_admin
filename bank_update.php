<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
$date_releaving = "";
$reason_realeaving = "";
$emp_id = "";
$id=$_POST["str1"];
if(isset($_POST["str3"]))
{
	$payment_type = $_POST["str3"];
	$bank_name = $_POST["str4"];
	$account_no = $_POST["str5"];
	$emp_id = $_POST["str6"];
}

//echo $weekly_off;
if($id==1)
{
 $sql_check1 = "update ".$mysql_table_prefix."account_detail set	
																payment_mode  ='$payment_type',
																bank_name='$bank_name',
																account_no='$account_no'
																where emp_id='$emp_id'";
																
$result_check1=mysql_query($sql_check1) or die ("Query Failed ".mysql_error());

?>
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
                   	<?=$payment_type?>
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
        	<a onclick="post_frm('bank_update.php','0','div_update_releave','<?=$payment_type?>','<?=$bank_name?>','<?=$account_no?>','<?=$emp_id?>')">Edit</a>
        </td>
    </tr>
</table>

<?
} else if($id==0)
{
?>
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
                    	<option value="Cash" <? if($payment_type=='Cash'){ echo 'selected="selected"';}?>>Cash</option>
                        <option value="Cheque" <? if($payment_type=='Cheque'){ echo 'selected="selected"';}?>>Cheque</option>
                        <option value="Online" <? if($payment_type=='Online'){ echo 'selected="selected"';}?>>Online</option>
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
                        	<input type="text" name="bank_name" id="bank_name" style="width:150px; height:20px;" value="<?=$bank_name?>"/>
                    </td>
                </tr>
                <tr>
                    <td class="text_1" width="40%">Account Number</td>
                    <td align="left" width="60%">
                        	<input type="text" name="account_no" id="account_no" style="width:150px; height:20px;" value="<?=$account_no ?>"/>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
    	<td colspan="2" align="center">
        	<input type="image" src="images/btn_submit.png" name="submit_pf" id="submit_pf" value="Submit" onclick="post_frm('bank_update.php','1','div_update_releave',document.getElementById('payment_mode').value,document.getElementById('bank_name').value,document.getElementById('account_no').value,'<?=$emp_id?>')"/>
        </td>
    </tr>
</table>
<?
}
?>