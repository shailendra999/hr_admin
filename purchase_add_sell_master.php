<? include ("inc/addpurchase_header.php"); ?>
<script type="text/javascript" src="ajax/common_function.js"></script>
<?
$Page = "purchase_add_sell.php";
$PageTitle = "Add Sell";
$PageFor = "Sell";
$PageKey = "sell_id";
$PageKeyValue = "";
$Message = "";
$mode = "";

$company_id = '';
$seller_id = '';
$product_id = '';
$quantity = '';
$form_id = '';

$previous_stock = '';
$name = '';
if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
}

if(isset($_POST["btn_submit"]))
{
	$PageKeyValue = $_POST[$PageKey];
	$company_id = $_POST['company_id'];	
	$seller_id = $_POST['seller_id'];
	$form_id = $_POST['form_id'];
	$product_id = $_POST['product_id'];
	$quantity = $_POST['quantity'];
	$sell_date = getDateFormate($_POST['sell_date']);
	
	if($PageKeyValue == "")
	{
		$tablename="ms_sell_master";
		$tableData=array("''","'$company_id'","'$seller_id'","'$form_id'","'$product_id'","'$quantity'","'$sell_date'","now()","$SessionLoginMasterId");
		addDataIntoTable($tablename,$tableData);		

		$Message = "$PageFor Inserted";
	}
		
			$sql_prod = "select * from ms_purchase_product_master where product_id='".$product_id."'";
			$sql_res = mysql_query($sql_prod) or die(mysql_error());
			$row=mysql_fetch_array($sql_res);
			$previous_stock =$row['existing_stock'];
		  $next_stock =  $previous_stock - $quantity ;	

			$tablename="ms_purchase_product_master";
			$tableColumns=array("product_id","existing_stock");
			$tableData=array("'$product_id'","'$next_stock'");
			updateDataIntoTable($tablename,$tableColumns,$tableData);	
		
		redirect("$Page?Message=$Message");
}
?>
<?
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}

?>

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/addpurchase_snb.php"); ?>
        </td>        
        <td style="padding-left:5px; padding-top:5px;">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/>&nbsp; Add Sell</td>
                </tr>
                <tr>
                	<td valign="top" style="padding-top:5px; padding-left:40px;">
                    	<table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td align="center" class="border">
                                    <div align="center" style="min-height:470px; padding-top:15px;">
                                        <div id="div_message" style="color:#399;font-size:16px;font-weight:bold;padding:5 0 5 0"><?=$Message?></div>
                                        <form id="purchase_frm_sell" name="purchase_frm_sell" action="" method="post">
                                            <table align="center" cellpadding="1" cellspacing="1" border="0" width="60%" style="border:#CCCCCC solid 1px;">
                                                <tr>
                                                    <td class="paas_text" bgcolor="#E2EBF0" width="40%">Company Name</td>
                                                    <td align="left" bgcolor="#F2F7F9" width="60%" style="padding-left:10px;">
                                                    <?
																											$sql_company = "select * from ms_purchase_company_master";
																											$sql_res = mysql_query($sql_company) or die(mysql_error());
																										?>
                                                    <select name="company_id" id="company_id" style="width:140px;">
                                                    <option value="0"></option>
                                                    <?
																											if(mysql_num_rows($sql_res)>0)
																											{
																													while($row_comp = mysql_fetch_array($sql_res))
																													{
																										?>
                                                    <option value="<?= $row_comp['company_id'] ?>"><?= $row_comp['name'] ?></option>
                                                    <?
																													}
																											}
																										?>
                                                    </select>
                                                    </td>
                                                </tr>
                                                 <tr>
                                                    <td class="paas_text" bgcolor="#E2EBF0" width="40%">Seller</td>
                                                    <td align="left" bgcolor="#F2F7F9" width="60%" style="padding-left:10px;">
                                                    <?
																											$sql_sell = "select * from ms_seller_master";
																											$sql_res = mysql_query($sql_sell) or die(mysql_error());
																										?>
                                                    <select name="seller_id" id="seller_id" style="width:140px;">
                                                    <option value="0"></option>
                                                    <?
																											if(mysql_num_rows($sql_res)>0)
																											{
																													while($row_sell = mysql_fetch_array($sql_res))
																													{
																										?>
                                                    <option value="<?=  $row_sell['seller_id'] ?>"><?= $row_sell['name'] ?></option>
                                                    <?
																													}
																											}
																										?>
                                                    </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="paas_text" bgcolor="#E2EBF0" width="40%" valign="top">Form</td>
                                                    <td align="left" bgcolor="#F2F7F9" width="60%" style="padding-left:10px;">
                                                    <?
																											$sql_frm = "select * from ms_purchase_form_master";
																											$sql_res = mysql_query($sql_frm) or die(mysql_error());
																										?>
                                                    <select name="form_id" id="form_id" style="width:140px">
                                                    <option value="0"></option>
                                                    <?
																											if(mysql_num_rows($sql_res)>0)
																											{
																													while($row_frm = mysql_fetch_array($sql_res))
																													{
																										?>
                                                    <option value="<?=  $row_frm['form_id'] ?>"><?= $row_frm['form_name'] ?></option>
                                                    <?
																													}
																											}
																										?>
                                                    </select>
                                                    </td>
                                                </tr>
                                                  <tr>
                                                    <td class="paas_text" bgcolor="#E2EBF0" width="40%">Product</td>
                                                    <td align="left" bgcolor="#F2F7F9" width="60%" style="padding-left:10px;">
                                                    <?
																											$sql_prod = "select * from ms_purchase_product_master";
																											$sql_res = mysql_query($sql_prod) or die(mysql_error());
																										?>
                                                    <select name="product_id" id="product_id" style="width:140px;">
                                                    <?
																											if(mysql_num_rows($sql_res)>0)
																											{
																													while($row_prod = mysql_fetch_array($sql_res))
																													{
																										?>
                                                    <option value="<?=$row_prod['product_id']?>"><?=$row_prod['product_name'] ?></option>
                                                    <?
																													}
																											}
																										?>
                                                    </select>
                                                    </td>
                                                </tr>
                                                 <tr>
                                                    <td class="paas_text" bgcolor="#E2EBF0" width="40%">Quantity </td>
                                                    <td align="left" bgcolor="#F2F7F9" width="60%" style="padding-left:10px;">
                                                    <input type="text" id="quantity" name="quantity"  /></td>
                                                </tr>
                                                 <tr>
                                                    <td class="paas_text" bgcolor="#E2EBF0" width="40%">Date</td>
                                                    <td align="left" bgcolor="#F2F7F9" width="60%" style="padding-left:10px;">
                                                    <input type="text" id="sell_date" name="sell_date"  />
                                                      <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.purchase_frm_sell.sell_date);return false;" HIDEFOCUS>
                                                      <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                                                      </a> 
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" align="center" bgcolor="#E2EBF0" height="25">
                                                        <input type="hidden" id="mode" name="mode" value="<?=$mode?>"/>
                                                        <input type="hidden" id="<?=$PageKey?>" name="<?=$PageKey?>" value="<?=$PageKeyValue?>" />
                                                        <input type="submit" id="btn_submit" name="btn_submit" value="Submit" class="btn_bg" />
                                                    </td>
                                                </tr>
                               			   </table>
                           				 </form>
                                        
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
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>                                        

<? include ("inc/hr_footer.php"); ?>	