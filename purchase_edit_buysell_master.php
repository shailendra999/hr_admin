<? include ("inc/addpurchase_header.php"); ?>
<?
$msg ='';
?>
<?
if(isset($_GET['start']))
{
	if($_GET['start']=='All')
	{
		$start = 0;
	}
	else
	{
		$start = $_GET['start'];
	}
}
else
{
	$start = 0;
}		
if(isset($_POST['txt_from_date']))
{	
	 $txt_from_date =$_POST['txt_from_date'];
}	
if(isset($_POST['txt_to_date']))
{	
	$txt_to_date =$_POST['txt_to_date'];
}

$company_id="";
$purchaser_id="";
$seller_id="";
$buyer_id="";
$sell_id="";
$form_id="";

$where_string="";
$buy_search_string="";
$sell_search_string="";
$form_search_string="";
if(isset($_POST["company_id"]) and isset($_POST["purchaser_id"]) and isset($_POST["seller_id"]))
{
	if(($_POST["company_id"]!=""))
	{	
		$company_id = $_POST["company_id"];
		$where_string = " where company_id = '".$_POST["company_id"]."'";
	}
	if(($_POST["purchaser_id"]!=""))
	{	
		$purchaser_id = $_POST["purchaser_id"];
		$buy_search_string = " and ms_buyer_master.purchaser_id='".$_POST["purchaser_id"]."'";
	}
	if($_POST["seller_id"]!="")
	{	
		$seller_id = $_POST["seller_id"];
		$sell_search_string = " and ms_sell_master.seller_id='".$_POST["seller_id"]."'";
	}
	if($_POST["txt_from_date"]!="" and $_POST["txt_to_date"]!="")
	{
		$txt_from_date = $_POST["txt_from_date"];
		$txt_to_date = $_POST["txt_to_date"];

		$buy_search_string .= " and ms_buyer_master.buyer_date between '".getDateFormate($txt_from_date)."' and '".getDateFormate($txt_to_date)."' ";
		
		$sell_search_string .= " and ms_sell_master.sell_date between '".getDateFormate($txt_from_date)."' and '".getDateFormate($txt_to_date)."' ";
	}
}

if(isset($_POST["IsEntryChecked"]))
{
	$IsEntryChecked = $_POST["IsEntryChecked"];
	
	$buy_search_string .= " and IsEntryChecked = '$IsEntryChecked'";
	
	$sell_search_string .= " and IsEntryChecked = '$IsEntryChecked'";
	
}
if(isset($_POST["btn_submit_x"]))
{			
	 $sql_company = "select * from 
						ms_purchase_company_master
						$where_string
						";
	$result_company = mysql_query($sql_company) or die("Error in Query :".$sql_company."<br>".mysql_error().":".mysql_errno());
}
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/addpurchase_snb.php"); ?>
        </td>       
        <td style="padding-left:5px; padding-top:5px;" valign="top">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Reports</td>
                </tr>
                <tr>
                	<td valign="top">
                        <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                                        <tr>
                                            <td class="red"><?=$msg?></td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top">
                                                <table align="center" width="60%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #C6B4AE;" bgcolor="#EAE3E1">
                                                     <tr>
                                                        <td style="padding-top:10px;" align="center">
                                                        	<form name="frm_report" id="frm_report" action="" method="post">
                                                                <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                    <tr>
                                                                        <td colspan="8">
                                                                            <table align="center">
                                                                                <tr>                                                                  
                                                                                    <td align="center" class="text_1"><b>From Date</b></td>
                                                                                    <td align="center">
                                                                                        <input type="text" name="txt_from_date" id="txt_from_date" value="" style="width:100px; height:20px;" readonly="readonly"/>
                                              <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_report.txt_from_date);"><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="27" height="22" border="0" alt=""/></a>                            
                                                                                    </td>
                                                                                    <td align="left" class="text_1"><b>To Date</b></td>
                                                                                    <td align="left">
                                                                                        <input type="text"
             name="txt_to_date" id="txt_to_date" value="" style="width:100px; height:20px;" readonly="readonly"/>
                                              <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_report.txt_to_date);"><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="27" height="22" border="0" alt=""/></a>                      
                                                                                    </td>
                                                                                    </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                     <tr> 
                                                                        <td class="text_1">
                                                                            <b>Filter By:</b>
                                                                        </td>
                                                                        <td class="text_1">
                                                                            <b>Company</b>
																		<?
																			$sql_company = "select * from ms_purchase_company_master";
																			$sql_res = mysql_query($sql_company) or die(mysql_error());
																		?>
																		<select name="company_id" id="company_id" style="width:140px;">
																		<option value="">Select Company</option>
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
                                   	
                                      <td class="text_1">
                                         <?
																				$sql_sell = "select * from ms_seller_master";
																				$sql_res = mysql_query($sql_sell) or die(mysql_error());
																			?>
                                     
                                      <b>Seller</b>
																			<select name="seller_id" id="seller_id" style="width:140px;">
																			<option value="">Select Seller</option>
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
                                     
                                       <td class="text_1">
                                      <?
																				$sql_pur = "select * from ms_purchaser_master";
																				$sql_res = mysql_query($sql_pur) or die(mysql_error());
																			?>
                                     
                                      <b>Purchaser</b>
																			<select name="purchaser_id" id="purchaser_id" style="width:140px;">
																			<option value="">Select Purchaser</option>
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
                                      <td>
                                      	Is Entry Confirmed <input type="checkbox" id="IsEntryChecked" name="IsEntryChecked" value="1" />
                                      </td>
                                     
                                                                    </tr> 
                                                                    <tr>
                                                                        <td colspan="6" align="center" style="padding-top:5px;">
                                                                            <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                                            <input type="image" src="images/btn_view.jpg" name="btn_submit" id="btn_submit" value="View"/>
                                                                            <a href="javascript:;" onClick="document.location='purchase_edit_buysell_master.php';">
                                                                                <img src="images/submit_button_Mahima.jpg" name="over" border="0">
                                                                            </a>
                                                                        </td>
                                                                    </tr>     
                                                                </table>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top" style="padding-top:5px;">
												<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #E4E4E4;">
                       
                        
												   	<?  
                                                    if(isset($_POST["btn_submit_x"]))
                                                    {
                                                        if(mysql_num_rows($result_company)>0)
                                                        {
                                                    	    $sno = $start+1;
																													while($row_company=mysql_fetch_array($result_company))
																													{
																																										?>
                                                   
                                                	<tr>
                                                        <td colspan="2">
                                                        	<?="<strong>".$row_company["name"]."</strong>"?>, <?="<strong>".$row_company["city"]."</strong>"?>
                                                        </td>
                                                        
                                                    </tr>
                                                    <tr>
                                                    	<td>
                                                        	<table width="100%" border="1" > 
                                                            	<tr style="background-color:#EAE3E1;">
                                                                	<td width="50%" align="center">
                                                                    	<strong>Buy</strong>
                                                                    </td>
                                                                    <td width="50%" align="center">
                                                                    	<strong>Sell</strong>
                                                                    </td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                	<td valign="top">
                                                                    	<table width="100%"  border="0" class="table1">
                                                                        	<tr valign="top" class="gredBg">
                                                                            	<td>
                                                                                	Date
                                                                                </td>
                                                                                <td>
                                                                                	Party
                                                                                </td>
                                                                                <td>
                                                                                	Form
                                                                                </td>
                                                                                <td>
                                                                                	Product
                                                                                </td>
                                                                                <td>
                                                                                	Qty
                                                                                </td>
                                                                                <td>
                                                                                	Is EC
                                                                                </td>
                                                                                <td>
                                                                                </td>
                                                                            </tr>
                                                                            <?
																			$sql_buy = "select * from 
																									ms_buyer_master,
																									ms_purchase_product_master,
																									ms_purchaser_master,
																									ms_purchase_form_master
																									
																								 where 
																								 company_id = '".$row_company["company_id"]."'
																								 and ms_purchase_product_master.product_id = ms_buyer_master.product_id
																								 and ms_purchaser_master.purchaser_id = ms_buyer_master.purchaser_id
																								 and ms_purchase_form_master.form_id = ms_buyer_master.form_id
																								 $buy_search_string order by ms_buyer_master.buyer_date
																								 ";
																			
																			$result_buy = mysql_query($sql_buy) or die("Error in : ".$sql_buy."<br>".mysql_errno()." : ".mysql_error());
																			if(mysql_num_rows($result_buy)>0)
																			{
																				while($row_buy = mysql_fetch_array($result_buy))
																				{
																				?>
                                            <tr valign="top" class="tableTxt">
                                              <td align="center" >
                                                  <?=getDateFormate($row_buy["buyer_date"])?>
                                                </td>
                                                <td align="center">
                                                  <?=$row_buy["name"]?>
                                                </td>
                                                <td align="center">
                                                  <?=$row_buy["form_name"]?>
                                                </td>
                                                <td align="center">
                                                  <?=$row_buy["product_name"]?>
                                                </td>
                                                <td align="center">
                                                  <?=$row_buy["quantity"]?>
                                                </td>
                                                <td align="center">
                                                	<?=$IsEntryChecked = ($row_buy["IsEntryChecked"]) ? "Yes" : "No";?>
                                                </td>
                                                <td align="center">
													<?
                                                    if($IsEntryChecked == "No")
                                                    {
                                                    ?>
                                                	<a href="purchase_add_buysell.php?buyer_id=<?=$row_buy["buyer_id"]?>">Edit</a>
                                                    <?
													}
													?>
                                                </td>
                                            </tr>    
                                                <?
																					
																				}
																				
																			}
																			?>
                                                                        </table>
                                                                    </td>
                                                                    <td valign="top">
                                                                    	<table width="100%" border="0" class="table1">
                                                                      
                                                                        	<tr valign="top" class="gredBg">
                                                                            	<td>
                                                                                	Date
                                                                                </td>
                                                                                <td>
                                                                                	Party
                                                                                </td>
                                                                                <td>
                                                                                	Form
                                                                                </td>
                                                                                <td>
                                                                                	Product
                                                                                </td>
                                                                                <td>
                                                                                	Qty
                                                                                </td>
                                                                                <td align="center">
                                                                                	Is EC
                                                                                </td>
                                                                                <td>
                                                                                </td>
                                                                            </tr>
                                                                            <?
																			$sql_sell = "select * from 
																									ms_sell_master,
																									ms_purchase_product_master,
																									ms_seller_master,
																									ms_purchase_form_master
																								 where 
																								 company_id = '".$row_company["company_id"]."'
																								 and ms_purchase_product_master.product_id = ms_sell_master.product_id
																								 and ms_seller_master.seller_id = ms_sell_master.seller_id
																								  and ms_purchase_form_master.form_id = ms_sell_master.form_id
																								 $sell_search_string order by ms_sell_master.sell_date
																								 ";
																			
																			$result_sell = mysql_query($sql_sell) or die("Error in : ".$sql_sell."<br>".mysql_errno()." : ".mysql_error());
																			if(mysql_num_rows($result_sell)>0)
																			{
																				while($row_sell = mysql_fetch_array($result_sell))
																				{
																				?>
                                                                            <tr valign="top" class="tableTxt">
                                                                            	<td align="center" >
                                                                                	<?=getDateFormate($row_sell["sell_date"])?>
                                                                                </td>
                                                                                <td align="center">
                                                                                	<?=$row_sell["name"]?>
                                                                                </td>
                                                                                <td align="center">
                                                                                	<?=$row_sell["form_name"]?>
                                                                                </td>
                                                                                <td align="center">
                                                                                	<?=$row_sell["product_name"]?>
                                                                                </td>
                                                                                <td align="center">
                                                                                	<?=$row_sell["quantity"]?>
                                                                                </td>
                                                                                <td align="center">
																					<?=$IsEntryChecked = ($row_sell["IsEntryChecked"]) ? "Yes" : "No";?>
                                                                                </td>
                                                                                <td align="center">
                                                                                	<?
																					if($IsEntryChecked == "No")
																					{
																					?>
                                                                                    <a href="purchase_add_buysell_master.php?sell_id=<?=$row_sell["sell_id"]?>">Edit</a>
                                                                                    <?
																					}
																					?>
                                                                                </td>
                                                                            </tr>    
                                                                                <?
																					
																				}
																				
																			}
																			?>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <?
															}
														}
													}
													?>
                                                   
                                                           	
                                               </table>
                                          </td>
                                       </tr>
                                   </table>
                               </td>
                           </tr>
                        </table> 
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>   
<? include ("inc/hr_footer.php"); ?>	