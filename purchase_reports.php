<? include ("inc/purchase_header.php"); ?>
<script language="javascript">
function sellstockChecked() 
{
	var fromstock=document.getElementById('fromstock');
	if(fromstock.checked==false)
	{
		document.getElementById('divsellRequired').style.display='block';
		document.getElementById('tocheck').style.display='block';
	}
	else
	{ 
		document.getElementById('divsellRequired').style.display='none';
		document.getElementById('tocheck').style.display='none';
	}
}
function buystockChecked() 
{
	var tostock=document.getElementById('tostock');
	if(tostock.checked==false)
	{
		document.getElementById('divbuyRequired').style.display='block';
		document.getElementById('fromcheck').style.display='block';
	}
	else
	{ 
		document.getElementById('divbuyRequired').style.display='none';
		document.getElementById('fromcheck').style.display='none';
	}
}
</script>
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
$stock_search_string="";
$fromstock = "";
$tostock = "";
$tostockSeachString="";
$fromstockSeachString="";
if(isset($_POST["fromstock"]))
{
	if($_POST["fromstock"]!="")	
	{
		$fromstock = $_POST["fromstock"];
		$fromstockSeachString = "and ms_sell_master.toWhat='0'";

	}
}
if(isset($_POST["tostock"]))
{
	if($_POST["tostock"]!="")
	{
		$tostock = $_POST["tostock"];
		$tostockSeachString ="and ms_buyer_master.fromWhat='0'";

	}
}

if(isset($_POST["company_id"]) and isset($_POST["purchaser_id"]) and isset($_POST["seller_id"]) and isset($_POST["form_id"]))
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
	if($_POST["form_id"]!="")
	{
		$form_id = $_POST["form_id"];
		$form_search_string = " and ms_purchase_form_master.form_id = '".$_POST["form_id"]."' ";
	}

	if($_POST["txt_from_date"]!="" and $_POST["txt_to_date"]!="")
	{
		$txt_from_date = $_POST["txt_from_date"];
		$txt_to_date = $_POST["txt_to_date"];
		$buy_search_string .= " and ms_buyer_master.buyer_date between '".getDateFormate($txt_from_date)."' and '".getDateFormate($txt_to_date)."' ";
		
		$sell_search_string .= " and ms_sell_master.sell_date between '".getDateFormate($txt_from_date)."' and '".getDateFormate($txt_to_date)."' ";	
	}
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
			<? include ("inc/purchase_snb.php"); ?>
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
                                   	<td class="text_1" width="15%">
                                    <div id="fromcheck" style="display:block;">
                                    To Stock
                                      <input type="checkbox" name="fromstock" id="fromstock" value="1" onClick="sellstockChecked();" />
                                      </div>
                                        </td>
                                      <td class="text_1" width="55%">
                                         <?
																				$sql_sell = "select * from ms_seller_master";
																				$sql_res = mysql_query($sql_sell) or die(mysql_error());
																			?>
                                      <div style="display:block" id="divsellRequired">
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
                                      </div>
                                      </td>
                                      <td class="text_1" width="15%">
                                      <div style="display:block;" id="tocheck">
                                      From Stock
                                        <input type="checkbox" name="tostock" id="tostock" onClick="buystockChecked();" />
                                        </div>
                                      </td>
                                       <td class="text_1" width="55%">
                                      <?
																				$sql_pur = "select * from ms_purchaser_master";
																				$sql_res = mysql_query($sql_pur) or die(mysql_error());
																			?>
                                      <div style="display:block" id="divbuyRequired">
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
                                      </div>
                                      </td>
                                      <td class="text_1">
                                        <b>Form</b><?
																				$sql_frm = "select * from ms_purchase_form_master";
																				$sql_res = mysql_query($sql_frm) or die(mysql_error());
																			?>
																			<select name="form_id" id="form_id" style="width:140px; margin-right:25px;">
																			<option value="">Select Form</option>
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
                                                                        <td colspan="8" align="center" style="padding-top:5px;">
                                                                            <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                                            <input type="image" src="images/btn_view.jpg" name="btn_submit" id="btn_submit" value="View"/>
                                                                            <a href="javascript:;" onClick="document.location='purchase_reports.php';">
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
													?>
                                                  <tr><td colspan="2" align="right">
                                                  		
                                                      <form action="print_purchase_reports.php" method="post" name="frm_print" id="frm_print" target="_blank" style="display:inline;">
                                                      
                                                       <input type="hidden" name="txt_from_date" id="txt_from_date" value="<?=$txt_from_date?>"/>
                                                       <input type="hidden" name="txt_to_date" id="txt_to_date" value="<?=$txt_to_date?>"/>
                                                       <input type="hidden" name="company_id" id="company_id" value="<?=$company_id?>"/>
                                                       <input type="hidden" name="purchaser_id" id="purchaser_id" value="<?=$purchaser_id?>"/>
                                                       <input type="hidden" name="seller_id" id="seller_id" value="<?=$seller_id?>"/>
                                                       <input type="hidden" name="form_id" id="form_id" value="<?=$form_id?>"/>
                                                       <input type="hidden" name="fromstock" id="fromstock" value="<?=$fromstock?>"/>
                                                       <input type="hidden" name="tostock" id="tostock" value="<?=$tostock?>"/>
                                                       <input type="image" src="images/btn_print.jpg" name="btn_submit" id="btn_submit" value="View"/>
                                                       
                                                    	</form>
                                                      <form action="excel_purchase_reports.php" method="post" name="frm_excel" id="frm_excel" style="display:inline;">
                                                      
                                                       <input type="hidden" name="txt_from_date" id="txt_from_date" value="<?=$txt_from_date?>"/>
                                                       <input type="hidden" name="txt_to_date" id="txt_to_date" value="<?=$txt_to_date?>"/>
                                                       <input type="hidden" name="company_id" id="company_id" value="<?=$company_id?>"/>
                                                       <input type="hidden" name="purchaser_id" id="purchaser_id" value="<?=$purchaser_id?>"/>
                                                       <input type="hidden" name="seller_id" id="seller_id" value="<?=$seller_id?>"/>
                                                       <input type="hidden" name="form_id" id="form_id" value="<?=$form_id?>"/>
                                                       <input type="hidden" name="fromstock" id="fromstock" value="<?=$fromstock?>"/>
                                                       <input type="hidden" name="tostock" id="tostock" value="<?=$tostock?>"/>
                                                       <input type="image" src="images/Excel-icon.png" name="btn_submit" id="btn_submit" width="20" height="20"/>
                                                    </form>
                                                     <!--<a href="javascript:;" onClick="frm_excel.submit();">Excel Report</a>-->
                                                    </td></tr>
													<?
													while($row_company=mysql_fetch_array($result_company))
													{
														$total_seller=0;
														$total_buyer=0;
														$net_quanitiy=0;
														$sql_sell = "select sell_id,company_id,ms_sell_master.form_id,ms_sell_master.product_id,ms_sell_master.seller_id,quantity,sell_date,toWhat,buyer_id,name,form_name,(select column_name from information_schema.columns where table_name='ms_sell_master' and EXTRA = 'auto_increment' and COLUMN_KEY = 'PRI') as ColName
													  					 from 
																				ms_sell_master,
																				ms_purchase_product_master,
																				ms_seller_master,
																				ms_purchase_form_master
																		 where 
																				 company_id = '".$row_company["company_id"]."' 
																				 and ms_purchase_form_master.form_id = ms_sell_master.form_id
																				 and ms_seller_master.seller_id = ms_sell_master.seller_id
																				 $form_search_string
																				 $sell_search_string $fromstockSeachString
																	UNION all 
																	select buyer_id,company_id,ms_buyer_master.form_id,ms_buyer_master.product_id,ms_buyer_master.purchaser_id,quantity,buyer_date,fromWhat,seller_id,name,form_name,(select column_name from information_schema.columns where table_name='ms_buyer_master' and EXTRA = 'auto_increment' and COLUMN_KEY = 'PRI') as ColName
																			from 
																					ms_buyer_master,
																					ms_purchase_form_master,
																					ms_purchaser_master
																			  where 
																			  		company_id = '".$row_company["company_id"]."' and
																					ms_purchaser_master.purchaser_id = ms_buyer_master.purchaser_id and 
																					ms_purchase_form_master.form_id = ms_buyer_master.form_id and fromWhat='0'
																					$form_search_string
																					$buy_search_string order by sell_date";
														
														$result_sell = mysql_query($sql_sell) or die("Error in : ".$sql_sell."<br>".mysql_errno()." : ".mysql_error());
														
													?>
                                                	<tr>
                                                        <td>
                                                        	<?="<strong>".$row_company["name"]."</strong>"?>, <?="<strong>".$row_company["city"]."</strong>"?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td>
                                                        	<table width="100%" border="1" > 
                                                            	<tr style="background-color:#EAE3E1;">
                                                                	<td width="50%" align="center" colspan="4">
                                                                    	<strong>Purchase</strong>
                                                                    </td>
                                                                    <td width="50%" align="center" colspan="4">                                                                        
                                                                    <strong>Sell</strong>
                                                                    </td>
                                                                </tr> 
                                                                <tr valign="top" class="gredBg">
                                                                    <td width="100px">
                                                                        Date
                                                                    </td>
                                                                    <td>
                                                                        Party
                                                                    </td>
                                                                    <td width="8%">
                                                                        Form
                                                                    </td>
                                                                    
                                                                    <td width="5%">
                                                                        Qty
                                                                    </td>
                                                                    <td width="50px">
                                                                        Date
                                                                    </td>
                                                                    <td>
                                                                        Party
                                                                    </td>
                                                                    <td width="8%">
                                                                        Form
                                                                    </td>
                                                                    <td width="5%">
                                                                        Qty
                                                                    </td>
                                                                </tr>
                                                                            <?
																			if(mysql_num_rows($result_sell)>0)
																			{
																				$order="";
																				$total_seller=0;
																				$total_buyer=0;
																				$net_quanitiy=0;
																				while($row_sell = mysql_fetch_array($result_sell))
																				{
																				?>
                                                                            <tr valign="top" class="tableTxt">
                                                                            	<?
																					if($row_sell["ColName"]=='buyer_id')
																					{
																						?>
                                                                                        	<td></td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                        <?
																					}
																					else
																					{
																				?>
                                                                            	<td align="center">
                                                                                	<?=getDateFormate($row_sell["sell_date"])?>
                                                                                </td>
                                                                                <td align="center">
                                                                                	<?
																						if($row_sell["toWhat"]==0 and $row_sell["ColName"]=='sell_id')
																						{
																							echo "To Stock(".$row_sell["name"].")";
																						}
																						else
																						{
																							echo $row_sell["name"];
																						}
																					?>
                                                                                </td>
                                                                                <td align="center">
                                                                                	<?=$row_sell["form_name"]?>
                                                                                </td>
                                                                               
                                                                                <td align="center">
                                                                                	<?=$row_sell["quantity"]?>
                                                                                </td>  
                                                                                <?
																				$total_buyer=$total_buyer +$row_sell["quantity"];
																				}
																				
																				if($row_sell["ColName"]=='sell_id' and $row_sell["toWhat"]!=1)
																				{
																						?>
                                                                                        	<td></td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                        <?
																				}
																				else
																				{
																					if($row_sell["toWhat"]==0)
																					{
																						?>
                                                                                        <td align="center">
                                                                                          <?=getDateFormate($row_sell["sell_date"])?>
                                                                                        </td>
                                                                                        <td align="center">
                                                                                            <?
                                                                                                if($row_sell["toWhat"]==0)
                                                                                                {
                                                                                                    echo "From Stock(".$row_sell["name"].")";
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    echo $row_sell["name"];
                                                                                                }
                                                                                            ?>
                                                                                        </td>
                                                                                        <td align="center">
                                                                                         <?=$row_sell["form_name"]?>
                                                                                        </td>
                                                                                        <td align="center">
                                                                                          <?=$row_sell["quantity"]?>
                                                                                        </td>
                                                                                        
                                                                                        <? 
                                                                                       		$total_seller=$total_seller +$row_sell["quantity"];
																					}
																					else
																					{
																						$sql_buy = "select * from 
                                                                                                        ms_buyer_master,
                                                                                                        ms_purchase_form_master,
																										ms_purchaser_master
                                                                                                     where 
                                                                                                     ms_purchaser_master.purchaser_id = ms_buyer_master.purchaser_id and 
																									 ms_purchase_form_master.form_id = ms_buyer_master.form_id
                                                                                                     and buyer_id = '".$row_sell["buyer_id"]."'";
                                                                                
                                                                                $result_buy = mysql_query($sql_buy) or die("Error in : ".$sql_buy."<br>".mysql_errno()." : ".mysql_error());	
																				if(mysql_num_rows($result_buy)>0)
                                                                                {
                                                                                    
                                                                                    while($row_buy = mysql_fetch_array($result_buy))
                                                                                    {
                                                                                    ?>
                                                                                      	<td align="center">
                                                                                          <?=getDateFormate($row_buy["buyer_date"])?>
                                                                                        </td>
                                                                                        <td align="center">
                                                                                            <?
                                                                                                if($row_sell["toWhat"]==0)
                                                                                                {
                                                                                                    echo "From Stock(".$row_buy["name"].")";
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    echo $row_buy["name"];
                                                                                                }
                                                                                            ?>
                                                                                        </td>
                                                                                        <td align="center">
                                                                                         <?=$row_buy["form_name"]?>
                                                                                        </td>
                                                                                        <td align="center">
                                                                                          <?=$row_sell["quantity"]?>
                                                                                        </td>
                                                                                        
                                                                                        <? 
                                                                                       		$total_seller=$total_seller +$row_sell["quantity"];
                                                                                    	}
                                                                              		 }
																					 }
																					}
																				}
																			?>
                                                                            </tr>
                                                                            <tr class="tableTxt">
                                                                                <td colspan="3" align="center">Total
                                                                                </td>
                                                                                <td align="center">
                                                                                    <?=$total_buyer?>
                                                                                </td>
                                                                                <td colspan="3" align="center">Total
                                                                                </td>
                                                                                <td align="center">
                                                                                    <?=$total_seller?>
                                                                                </td>
                                                                            </tr>
                                                                             <?
																			}
																			?>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                	<td colspan="2">
                                                                    	<table  width="100%" border="0">
                                                                        	<tr>
                                                                            	<td>Opening Stock</td>
                                                                                <td><?=$OpeningQuantity=getStockOpeningQuantity(getDateFormate($txt_from_date),3,$row_company['company_id'])?></td>
                                                                            	<td>Net Stock</td>
                                                                                <td><?=$net_quanitiy=$total_buyer-$total_seller?></td>
                                                                            	<td>Closing Stock</td>
                                                                                <td><?=$OpeningQuantity+$net_quanitiy;?></td>
                                                                			</tr>
                                                                        </table>
                                                               		</td>
                                                                 </tr>
                                                    <?
																$total_seller=0;
																$total_buyer=0;
																$net_quanitiy=0;
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