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

if(isset($_POST["btn_submit"]))
{			
	 $sql_company = "select * from 
											ms_purchase_company_master
											$where_string
											";
	$result_company = mysql_query($sql_company) or die("Error in Query :".$sql_company."<br>".mysql_error().":".mysql_errno());
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Purchase Report</title>
<style>

.tblborder
{
 border-collapse:collapse;border-color:1px solid #000;
}
.text
{
	font-family:Arial, Helvetica, sans-serif; font-size:13px;
}
.text_head
{
	font-family:Arial, Helvetica, sans-serif; font-size:11px; font-weight:bold;padding-top:2px; padding-bottom:2px;
}
.col
{
	font-family:Arial, Helvetica, sans-serif; font-size:13px; padding-top:2px; padding-bottom:2px;
}
.date
{
	font-family:Arial, Helvetica, sans-serif; font-size:14px; margin-left:20px; font-weight:bold;
}
.show_date
{
	margin-right:20px; font-family:Arial, Helvetica, sans-serif; font-size:14px;
}
.app_text
{
	text-align:center; font-size:12px; font-weight:bold; font-family:Arial, Helvetica, sans-serif;
}
</style>
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
                        if(isset($_POST["btn_submit"]))
                        	{
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
						<?
                        $sno = $start+1;
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
                            <td width="100%" colspan="3">
                                <table width="100%" border="1" class="tblborder" > 
                                    <tr>
                                        <td width="50%" align="center" colspan="4">
                                            <strong>Purchase</strong>
                                        </td>
                                        <td width="50%" align="center" colspan="4">                                                                        
                                        <strong>Sell</strong>
                                        </td>
                                    </tr> 
                                    <tr valign="top" class="gredBg">
                                        <td width="120px">
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
                                        <td colspan="3">
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
                                 }
                            }
                        }
                        ?>
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
                                    </tr>
         </table>
       </td>
    </tr>
</table>
</td>
</tr>
</table>
<script>
   window.print ();
 </script>
</div>
</center>
</body>
</html>