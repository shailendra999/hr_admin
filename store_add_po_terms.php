<? include ("inc/store_header.php"); ?>
<script type="text/javascript">
function overlay(RecordId) 
{
	e1 = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=RecordId;
	e1.style.visibility = (e1.style.visibility == "visible") ? "hidden" : "visible";
	
}
</script>
<?
$Page = "store_add_po_terms.php";
$PageTitle = "Add PO Terms";
$PageFor = "PO Terms";
$PageKey = "po_id";
$PageKeyValue = "";
$Message = "";
$mode = "";

$billing_address = '';
$delivery_address = '';
$payment_terms = '';
$delivery = '';
$excise_and_taxes = '';
if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
}

if(isset($_POST["btn_submit"]))
{
	$PageKeyValue = $_POST[$PageKey];
	$billing_address = addslashes($_POST['billing_address']);
	$delivery_address = addslashes($_POST['delivery_address']);
	$payment_terms = addslashes($_POST['payment_terms']);
	$delivery = addslashes($_POST['delivery']);
	$excise_and_taxes = addslashes($_POST['excise_and_taxes']);	
	if($PageKeyValue == "")
	{
		$tableName="ms_po_terms";
		$tableData=array("''","'$billing_address'","'$delivery_address'","'$payment_terms'","'$delivery'","'$excise_and_taxes'","now()");
		addDataIntoTable($tableName,$tableData);
		$Message = "$PageFor Inserted";
	}	
	else
	{
		if($mode == "edit")
		{
			$tableName="ms_po_terms";
			$tableColumns=array("po_id","billing_address","delivery_address","payment_terms","delivery","excise_and_taxes");
			$tableData=array("'$PageKeyValue'","'$billing_address'","'$delivery_address'","'$payment_terms'","'$delivery'","'$excise_and_taxes'");
			//print_r($tableData);
			updateDataIntoTable($tableName,$tableColumns,$tableData);			
			$Message = "$PageFor Updated";
		}
		
	}
	redirect("$Page?Message=$Message");
}
?>
<?
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}

if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_po_terms where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$billing_address = $row["billing_address"];
		$delivery_address = $row["delivery_address"];
		$payment_terms = $row["payment_terms"];
		$delivery = $row["delivery"];
		$excise_and_taxes = $row["excise_and_taxes"];
	}
}
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
    	<? include ("inc/store_setting_snb.php"); ?>
    </td>        
    <td style="padding-left:5px; padding-top:5px;">
      <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
        <tr>
          <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/>&nbsp; Welcome to Laxyo</td>
        </tr>
        <tr>
          <td valign="top" style="padding-top:5px; padding-left:40px;">
            <table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                  <td align="center" class="border">
                      <div align="center" style="padding-top:15px;">
                          <div id="div_message" style="color:#399;font-size:16px;font-weight:bold;padding:5 0 5 0"><?=$Message?></div>
                          <form id="frm_add" name="frm_add" action="" method="post">
                            <table align="center" cellpadding="1" cellspacing="1" border="0" width="60%" style="border:#CCCCCC solid 1px;">
                              <tr>
                                <td align="left">Billing Address</td>
                                <td align="left">
                                <textarea  id="billing_address" name="billing_address" value="<?= $billing_address ?>" rows="3" cols="35"><?=$billing_address?></textarea>
                                </td>
                              </tr>
                              <tr>
                                <td align="left">Delivery Address</td>
                                <td align="left">
                                <textarea  id="delivery_address" name="delivery_address" value="<?= $delivery_address ?>" rows="3" cols="35"><?=$delivery_address?></textarea>
                                </td>
                              </tr>
                              <tr>
                                <td align="left">Payment Terms</td>
                                <td align="left">
                                <textarea  id="payment_terms" name="payment_terms" value="<?= $payment_terms ?>" rows="3" cols="35"><?=$payment_terms?></textarea>
                                </td>
                              </tr>
                              <tr>
                                <td align="left">Delivery</td>
                                <td align="left">
                                <input type="text" id="delivery" name="delivery" value="<?=$delivery?>"/>
                                </td>
                              </tr>
                              <tr>
                                <td align="left">Ex. & Taxes</td>
                                <td align="left">
                                	<input type="text" id="excise_and_taxes" name="excise_and_taxes" value="<?= $excise_and_taxes ?>" />
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2" align="center" bgcolor="#E2EBF0" height="25">
                                 <input type="hidden" id="mode" name="mode" value="<?=$mode?>"/>
                                 <input type="hidden" id="<?=$PageKey?>" name="<?=$PageKey?>" value="<?=$PageKeyValue?>" />
                                 <input type="submit" id="btn_submit" name="btn_submit" value="Save"/>
                                </td>
                              </tr>
                       			</table>
                     			</form>
                          <div id="div_category_list"  style="overflow:auto;height:400px;margin-top:20px;">
                            <table align="center" width="100%" style="border:#CCCCCC solid 1px;" cellpadding="2" cellspacing="1">
                              <tr style="background:#F4F2F7" height="30px">
                                <td class="h_text">S.No.</td>
                                <td class="h_text">Billing Address</td>
                                <td class="h_text">Delivery Address</td>
                                <td class="h_text">Payment Terms</td>
                                <td class="h_text">Delivery</td>
                                <td class="h_text">Ex. & Taxes</td>
                                <td class="h_text">Edit</td>
                              </tr>
                              <?
															$sql = "select * from  ms_po_terms";
															$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
															if(mysql_num_rows($result)>0)
															{
																
																$num = mysql_num_rows($result) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
																$sno=1;
																while($row = mysql_fetch_array($result)) 
																{ 
																	?>
																	<tr bgcolor="#F2F7F9" style="font-size:12px">
																		<td><?= $sno++;?></td>
																		<td><?=$row["billing_address"]?></td>
																		<td><?=$row["delivery_address"]?></td>
																		<td><?=$row["payment_terms"]?></td>
																		<td><?=$row["delivery"]?></td>
																		<td><?=$row["excise_and_taxes"]?></td>
																		<td><a href="store_add_po_terms.php?po_id=<?=$row['po_id']?>&mode=edit">Edit</a></td>
																	</tr>
																	<?												
																}
															 }
															 else
															 {
															 ?>
																<tr bgcolor="#f9f8f9">
																		<td colspan="6" align="center"><b>No Records Entered Yet.</b></td>
																</tr>
															 <? 
															 }
															 ?>
														</table>
														
													</div>
												</div>
											</td>
											</tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<div id="overlay">
	<div>
        <p class="form_msg">Are you sure to delete this Record</p>
		<form name="frm_del" action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
            <input type="submit" class="submit" name="btn_delete" id="btn_delete" value="Yes" />
            <input type="button" class="submit" onClick="overlay();" name="btn_close" id="btn_close" value="No" />
		</form>
	</div>
</div>
<? include ("inc/hr_footer.php"); ?>	