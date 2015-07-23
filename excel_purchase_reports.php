<? include("inc/dbconnection.php"); ?>
<? include("inc/store_function.php"); ?>

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
$fromstockSeachString = "";
$tostockSeachString = "";

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


 $sql_company = "select * from 
										ms_purchase_company_master
										$where_string
										";
$result_company = mysql_query($sql_company) or die("Error in Query :".$sql_company."<br>".mysql_error().":".mysql_errno());

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=purchase_report.xls")
?>
<head>
<title>Print Purchase Report</title>
</head>
<body>
<center>
<div style="width:900px; margin-top:20px;" align="center">
<table width="100%" cellpadding="0" cellspacing="0" align="center" border="1" class="tblborder" >
   <tr>      
        <td style="padding-left:5px; padding-top:10px;" valign="top">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	 <tr style="height:45px;">
                    <th align="center">MAHIMA PURESPUN(A UNIT OF MAHIMA FIBRES PVT.LTD.)</th>
                </tr>
                <tr>
                  <td align="center" valign="top" style="padding-top:5px; padding-bottom:50px;">
												<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
												   	<?  
													if(mysql_num_rows($result_company)>0)
													{
																	?>
                                <tr>
                                	<td width="85%" height="32" align="right"><span class="date">From Date </span></td>
                                    <td width="3%" align="center"><b> : </b></td>
                                    <td width="12%"> <span class="show_date"><?=$txt_from_date ?></span></td>
                                </tr>
                                <tr>
                                      <td height="27" align="right"><span class="date">To Date </span></td>
                                      <td align="center"><b> : </b></td>
                                      <td><span class="show_date"><?=$txt_to_date ?></span></td>
								</tr>
                                <tr>
                                	<td>
                                    	<strong>Purchase</strong>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                    	<strong>Sell</strong>
                                    </td>
                                </tr>
								<?
								$sno = $start+1;
								while($row_company=mysql_fetch_array($result_company))
								{
								?>
								<tr>
                                    <td class="text" colspan="3">
                                        <?="<strong>".$row_company["name"]."</strong>"?>, <?="<strong>".$row_company["city"]."</strong>"?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" > 
                                                    
                                            <tr>
                                                <td valign="top" width="50%" style="padding:2px;">
                                                                                            
                                                	<table width="100%" border="1" class="tblborder">
                                                      <tr valign="top" class="gredBg">
                                                          <td align="center" class="text_head" width="15%">
                                                              Date
                                                            </td>
                                                            <td align="center" class="text_head" >
                                                              Party
                                                            </td>
                                                            <td align="center" class="text_head" width="10%">
                                                              Form
                                                            </td>
                                                            
                                                            <td align="center" class="text_head" width="10%">
                                                              Qty
                                                            </td>
                                                        </tr>
                                                        <?
                                                          $sql_sell = "select * from 
                                                                       ms_sell_master,
                                                                       ms_purchase_form_master,
                                                                       ms_seller_master
                                                                       where 
                                                                       company_id = '".$row_company["company_id"]."'
                                                                       and ms_purchase_form_master.form_id = ms_sell_master.form_id
                                                                       and ms_seller_master.seller_id = ms_sell_master.seller_id
                                                                       $sell_search_string  $form_search_string $fromstockSeachString  order by sell_date";
                                                          
                                                          $result_sell = mysql_query($sql_sell) or die("Error in : ".$sql_sell."<br>".mysql_errno()." : ".mysql_error());
                                                          if(mysql_num_rows($result_sell)>0)
                                                          {
														  	$total_seller=0;
                                                            while($row_sell = mysql_fetch_array($result_sell))
                                                            {
                                                            ?>
                                                        <tr valign="top" class="tableTxt">
                                                          <td align="center" class="col">
                                                              <?=getDateFormate($row_sell["sell_date"])?>
                                                            </td>
                                                            <td align="center" class="col">
															<?
                                                                if($row_sell["toWhat"]==0)
                                                                {
                                                                    echo "From Stock";
                                                                }
                                                                else
                                                                {
                                                                    echo $row_sell["name"];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td align="center" class="col">
                                                          <?=$row_sell["form_name"]?>
                                                            </td>
                                                           
                                                            <td align="center" class="col">
                                                              <?=$row_sell["quantity"]?>
                                                            </td>
                                                        </tr>    
                                                            <?
															$total_seller=$total_seller +$row_sell["quantity"];
                                                            }
															?>
                                                            <tr class="tableTxt">
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
                                                <td style="border:1px solid #000066">
                                                </td>
                                                <td valign="top" width="50%" style="padding:2px;">
                                                  	
                                                    <table width="100%"  border="1" class="tblborder">
                                                    <tr valign="top" class="gredBg">
                                                        <td align="center" class="text_head"  width="15%">
                                                                Date
                                                            </td>
                                                            <td align="center" class="text_head">
                                                                Party
                                                            </td>
                                                            <td align="center" class="text_head" width="10%">
                                                                Form
                                                            </td>
                                                            
                                                            <td align="center" class="text_head" width="10%">
                                                                Qty
                                                            </td>
                                                    </tr>
                                                    <?
                                                    
                                                        $sql_buy = "select * from 
																					ms_buyer_master,
																					ms_purchaser_master,
																					ms_purchase_form_master
																			 where 
																			 company_id = '".$row_company["company_id"]."'
																			 and ms_purchaser_master.purchaser_id = ms_buyer_master.purchaser_id
																				and ms_purchase_form_master.form_id = ms_buyer_master.form_id
																					$form_search_string
																			
																			 $buy_search_string $tostockSeachString order by ms_buyer_master.buyer_date
																			 ";
                                                    
                                                          $result_buy = mysql_query($sql_buy) or die("Error in : ".$sql_buy."<br>".mysql_errno()." : ".mysql_error());
                                                          if(mysql_num_rows($result_buy)>0)
                                                          {
														  	$total_buyer=0;
                                                            while($row_buy = mysql_fetch_array($result_buy))
                                                            {
                                                            ?>
                                                                <tr valign="top" class="tableTxt">
                                                                    <td align="center" class="col" width="25%" >
                                                                            <?=getDateFormate($row_buy["buyer_date"])?>
                                                                        </td>
                                                                        <td align="center" class="col">
                                                                            <?
                                                                            if($row_buy["fromWhat"]==0)
                                                                            {
                                                                                    echo "To Stock";
                                                                            }
                                                                            else
                                                                            {
                                                                                    echo $row_buy["name"];
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td align="center" class="col" width="10%">
                                                                            <?=$row_buy["form_name"]?>
                                                                        </td>
                                                                        
                                                                        <td align="center" class="col" width="10%">
                                                                            <?=$row_buy["quantity"]?>
                                                                        </td>
                                                                </tr>    
                                                            <? 
																	$total_buyer=$total_buyer +$row_buy["quantity"];
																}
																?>
																<tr class="tableTxt">
																	<td colspan="3" align="center">Total
																	</td>
																	<td align="center">
																		<?=$total_buyer?>
																	</td>
																</tr>
																<?
                                                            }
                                                            ?>
                                                              </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                	<tr>
                                        <td colspan="2">
                                            <table  width="100%" border="0">
                                                <tr>
                                                    <td>Opening Stock</td>
                                                    <td><?=$OpeningQuantity=getStockOpeningQuantity(getDateFormate($txt_from_date),2)?></td>
                                                    <td>Net Stock</td>
                                                    <td><?=$net_quanitiy=$total_seller-$total_buyer?></td>
                                                    <td>Closing Stock</td>
                                                    <td><?=$OpeningQuantity+$net_quanitiy;?></td>
                                                </tr>
                                            </table>
                                        </td>
                                     </tr>
									<?
											}
										}
									?>
								   </table>
                                          </td>
                                       </tr>
                                        <tr>
                                            	<td colspan="3">
                                              	<table width="100%" border="0" style="margin-bottom:20px;">
                                                  <tr>
                                                    <td class="app_text">Approved By</td>
                                                    <td class="app_text">Approved By</td>
                                                    <td class="app_text">Approved By</td>
                                                  </tr>
                                                </table>
                                              </td>
                                            <tr>
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
</div>
</center>
</body>
</html>