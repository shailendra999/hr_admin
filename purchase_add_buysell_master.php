<? include ("inc/addpurchase_header.php"); ?>
<script type="text/javascript" src="ajax/common_function.js"></script>
<script language="javascript">
function sellstockChecked() 
{
	var sellstock=document.getElementById('fromstock');
	if(sellstock.checked==false)
	{
		document.getElementById('divsellRequired').style.display='block';
		document.getElementById('buy').style.display='block';
		document.getElementById('divfromstockRequired').style.display='none';
	}
	else
	{ 
		document.getElementById('divsellRequired').style.display='none';
		document.getElementById('buy').style.display='none';
		document.getElementById('divfromstockRequired').style.display='block';
	}
}
function buystockChecked() 
{
	var buystock=document.getElementById('tostock');
	if(buystock.checked==false)
	{
		document.getElementById('divbuyRequired').style.display='block';
		document.getElementById('sell').style.display='block';
		document.getElementById('divtostockRequired').style.display='none';
	}
	else
	{ 
		document.getElementById('divbuyRequired').style.display='none';
		document.getElementById('sell').style.display='none';
		document.getElementById('divtostockRequired').style.display='block';
	}
}

</script>
<?
$Page = "purchase_add_buysell.php";
$PageTitle = "Add Buyer/Seller";
$PageFor = "Buyer/Seller";
$PageKey = "stock_id";
$PageKeyValue = "";
$Message = "";
$mode = "";

$company_id = '';
$purchaser_id = '';
$seller_id = '';
$product_id = '';
$quantity = '';
$buysell_date = '';
$form_id = '';
$previous_stock = '';
$next_stock = '';
$table_rec_id = '';
$seller_buyer = '';
$dtTransaction = '';
$name = '';

if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
}

if(isset($_POST["btn_submit"]))
{
	//$PageKeyValue = $_POST[$PageKey];
	$company_id = $_POST['company_id'];	
	$seller_id = $_POST['seller_id'];
	$purchaser_id = $_POST['purchaser_id'];
	$form_id = $_POST['form_id'];
	$product_id = $_POST['product_id'];
	$quantity = $_POST['quantity'];
	$buysell_date = getDateFormate($_POST['buysell_date']);
	$ip_add = $_SERVER['REMOTE_ADDR'];
	
			
	
			if(isset($_POST['fromstock']))
			{
			$sql_buy = mysql_query("INSERT INTO ms_buyer_master 
																		(buyer_id, company_id ,purchaser_id, product_id, form_id, quantity, buyer_date, insert_date, login_id, IP, fromWhat ) 
																		VALUES 
																		(NULL, '$company_id', '$purchaser_id', '$product_id', '$form_id', '$quantity', '$buysell_date', now(), '$SessionLoginMasterId', '$ip_add','0')")
																		or die(mysql_error());
			$insert_id = mysql_insert_id();
			
			$sql_stock =	mysql_query("INSERT INTO ms_purchase_stock_master 
																		(stock_id, table_rec_id, company_id, product_id, stock_quantity, seller_buyer, dtTransaction, insert_date, login_id, ip) 
																		VALUES (NULL, '$insert_id', '$company_id', '$product_id', '$quantity', '0', '$buysell_date', now(), '$SessionLoginMasterId', '$ip_add')") 
																		or die(mysql_error());

			$sql_prod = "select * from ms_purchase_product_master where product_id='".$product_id."'";
			$sql_res = mysql_query($sql_prod) or die(mysql_error());
			$row=mysql_fetch_array($sql_res);
			$previous_stock =$row['existing_stock'];
		  $next_stock =  $previous_stock + $quantity ;	
			
			$tablename="ms_purchase_product_master";
			$tableColumns=array("product_id","existing_stock");
			$tableData=array("'$product_id'","'$next_stock'");
			updateDataIntoTable($tablename,$tableColumns,$tableData);	
			
			}
			else
			if(isset($_POST['tostock']))
			{
			$sql_sell = mysql_query("INSERT INTO ms_sell_master 
																		(sell_id, company_id ,seller_id, form_id, product_id,  quantity, sell_date, insert_date, login_id, IP, toWhat ) 
																		VALUES 
																		(NULL, '$company_id', '$seller_id', '$form_id', '$product_id', '$quantity', '$buysell_date', now(), '$SessionLoginMasterId', '$ip_add','0')")
																		or die(mysql_error());
			$insert_id = mysql_insert_id();
			
			$sql_stock =	mysql_query("INSERT INTO ms_purchase_stock_master 
																		(stock_id, table_rec_id, company_id, product_id, stock_quantity, seller_buyer, dtTransaction, insert_date, login_id, ip) 
																		VALUES (NULL, '$insert_id', '$company_id', '$product_id', '$quantity', '0', '$buysell_date', now(), '$SessionLoginMasterId', '$ip_add')") 
																		or die(mysql_error());

			$sql_prod = "select * from ms_purchase_product_master where product_id='".$product_id."'";
			$sql_res = mysql_query($sql_prod) or die(mysql_error());
			$row=mysql_fetch_array($sql_res);
			$previous_stock =$row['existing_stock'];
		  $next_stock =  $previous_stock - $quantity ;	
			
			$tablename="ms_purchase_product_master";
			$tableColumns=array("product_id","existing_stock");
			$tableData=array("'$product_id'","'$next_stock'");
			updateDataIntoTable($tablename,$tableColumns,$tableData);	
			
			}
			else
			if(!isset($_POST['fromstock']) && !isset($_POST['tostock']))
			{
			$sql_sell = mysql_query("INSERT INTO ms_sell_master 
																		(sell_id, company_id ,seller_id, form_id, product_id,  quantity, sell_date, insert_date, login_id, IP, toWhat ) 
																		VALUES 
																		(NULL, '$company_id', '$seller_id', '$form_id', '$product_id', '$quantity', '$buysell_date', now(), '$SessionLoginMasterId', '$ip_add','1')")
																		or die(mysql_error());
			$sql_buy = mysql_query("INSERT INTO ms_buyer_master 
																		(buyer_id, company_id ,purchaser_id, product_id, form_id, quantity, buyer_date, insert_date, login_id, IP, fromWhat ) 
																		VALUES 
																		(NULL, '$company_id', '$purchaser_id', '$product_id', '$form_id', '$quantity', '$buysell_date', now(), '$SessionLoginMasterId', '$ip_add','1')")
																		or die(mysql_error());
			}

		$Message = "$PageFor Inserted";
		//redirect("$Page?Message=$Message");
	
		
		
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
        <td style="padding-left:5px;" valign="top">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/>&nbsp; Add Buyer/Seller</td>
                </tr>
                <tr>
                	<td valign="top" style="padding-top:5px; padding-left:40px;">
                    	<table width="1000" align="center" cellpadding="0" cellspacing="0" border="0" style="border:#CCCCCC solid 1px;">
                            <tr>
                                <td align="center" class="border">
                                    <div align="center" >
                                        <div id="div_message" style="color:#399;font-size:16px;font-weight:bold;padding:0 0 5 0"><?=$Message?></div>
                                        <form id="purchase_frm_buysell" name="purchase_frm_buysell" action="" method="post">
                                         <table align="center" cellpadding="1" cellspacing="1" border="0" width="100%" style="border:#CCCCCC solid 1px;">
                                                <tr class="paas_text" bgcolor="#E2EBF0" >
                                                	<td align="center"><b>Company Name</b></td>
                                                  <td align="center"><b>Product</b></td>
                                                  <td align="center"><b>Quantity</b></td>
                                                  <td align="center"><b>Date</b></td>
                                                </tr>
                                                <tr bgcolor="#F2F7F9">
                                                	<td align="center">
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
                                                    <option value="<?= $row_comp['company_id'] ?>"><?= $row_comp['name'].",".$row_comp['city'] ?></option>
                                                    <?
																													}
																											}
																										?>
                                                    </select>
                                                  </td>
                                                  <td align="center">
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
                                                  <td align="center">
                                                  	<input type="text" id="quantity" name="quantity"  />
                                                  </td>
                                                  <td align="center">
                                                  	<input type="text" id="buysell_date" name="buysell_date"  />
                                                      <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.purchase_frm_buysell.buysell_date);return false;" HIDEFOCUS>
                                                      <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                                                      </a> 
                                                  </td>
                                                </tr>
                                                <tr> 
                                              <td align="left" colspan="2"><div style="display:block" id="sell">
                                              <b>From Stock</b> 
                                              <input type="checkbox" id="fromstock" name="fromstock" onClick="sellstockChecked();"/>
																							</div>
                                              </td>
                                              <td align="right" colspan="2">
                                              <div style="display:block" id="buy">
                                              <b>To Stock</b> 
                                              <input type="checkbox" id="tostock" name="tostock" onClick="buystockChecked();"/>
                                              </div>
                                              </td>
                                            </tr>
																								<tr>
                                                	<td width="50%" colspan="2">
                                            		<div style="display:block" id="divsellRequired"> 
                                            		<table align="center" cellpadding="1" cellspacing="1" border="0" width="90%" style="border:#CCCCCC solid 1px;">
                                                <tr>
                                                		<td colspan="2" class="paas_text" bgcolor="#E2EBF0" ><b>Seller</b></td>
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
                                                  
                                                
                                              </table>
                                           </div>
                                           <div style="display:none" id="divfromstockRequired"> 
                                            		<table align="center" cellpadding="1" cellspacing="1" border="0" width="90%" style="border:#CCCCCC solid 1px;">
                                                <tr>
                                                		<td colspan="2" class="paas_text" bgcolor="#E2EBF0" ><b>Stock</b></td>
                                                </tr>
                                               
                                                 <tr>
                                                    <td class="paas_text" bgcolor="#E2EBF0" width="40%">Existing Stock Quantity</td>
                                                    <td align="left" bgcolor="#F2F7F9" width="60%" style="padding-left:10px;">
                                                   <?
																												$sql_prod = "select * from ms_purchase_product_master ";
																												$sql_res = mysql_query($sql_prod) or die(mysql_error());
																												$row=mysql_fetch_array($sql_res);
																												echo $row['existing_stock'];
																										?>
                                                    </td>
                                                </tr>
                                              </table>
                                           </div>
                                            </td>
                                            <td width="50%" colspan="2">
                                            	 <div style="display:block" id="divbuyRequired"> 
                                            		<table align="center" cellpadding="1" cellspacing="1" border="0" width="90%" style="border:#CCCCCC solid 1px;">
                                                 <tr>
                                               		 <td colspan="2" class="paas_text" bgcolor="#E2EBF0"><b>Buyer</b></td>
                                                </tr>
                                                 <tr>
                                                    <td class="paas_text" bgcolor="#E2EBF0" width="40%">Buyer</td>
                                                    <td align="left" bgcolor="#F2F7F9" width="60%" style="padding-left:10px;">
                                                    <?
																											$sql_pur = "select * from ms_purchaser_master";
																											$sql_res = mysql_query($sql_pur) or die(mysql_error());
																										?>
                                                    <select name="purchaser_id" id="purchaser_id" style="width:145px;">
                                                    <option value="0"></option>
                                                    <?
																											if(mysql_num_rows($sql_res)>0)
																											{
																													while($row_pur = mysql_fetch_array($sql_res))
																													{
																										?>
                                                    <option value="<?=  $row_pur['purchaser_id'] ?>"><?= $row_pur['name'] ?></option>
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
                                                    <select name="form_id" id="form_id" style="width:145px">
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
                                              </table>
                                              </div>
                                               <div style="display:none" id="divtostockRequired"> 
                                            		<table align="center" cellpadding="1" cellspacing="1" border="0" width="90%" style="border:#CCCCCC solid 1px;">
                                                <tr>
                                                		<td colspan="2" class="paas_text" bgcolor="#E2EBF0" ><b>To Stock</b></td>
                                                </tr>
                                               
                                                 <tr>
                                                    <td class="paas_text" bgcolor="#E2EBF0" width="40%">Existing Stock Quantity</td>
                                                    <td align="left" bgcolor="#F2F7F9" width="60%" style="padding-left:10px;">
                                                    <?
																											$sql_prod = "select * from ms_purchase_product_master ";
																												$sql_res = mysql_query($sql_prod) or die(mysql_error());
																												$row=mysql_fetch_array($sql_res);
																												echo $row['existing_stock'];
																										?>
                                                    </td>
                                                </tr>
                                              </table>
                                           </div>
                                            	</td>
                                                </tr>
                                                <tr height="20px"><td colspan="4"></td></tr>
                                                <tr>
                                                    <td colspan="4" align="center" bgcolor="#E2EBF0" height="25">
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