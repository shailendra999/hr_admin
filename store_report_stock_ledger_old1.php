<? include("inc/store_header.php"); ?>
<script>
function overlay(id) {
  el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";	
}
function getDataInDiv(value,divId,page,byControl)
{
	var	dateFrom= document.getElementById('dateFrom').value;
	var	dateTo= document.getElementById('dateTo').value;
	if(dateFrom=='' || dateTo=='')
	{
		alert("Select Date First.");
		location.reload(1);
	}
	else
	{
		str=dateFrom+','+dateTo+','+value;
		var strURL1=page+"?str="+str+"&byControl="+byControl+"&sid="+Math.random();
		
		var req = getXMLHTTP();
		if (req)
		{																					
				req.onreadystatechange = function() {
						if (req.readyState == 4) {
								if (req.status == 200)                         
										document.getElementById(divId).innerHTML=req.responseText;
								 else 
										alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}
					}            
				req.open("GET", strURL1, true);
				req.send(null);
		}
	}
}

</script>
<?
function OpeningValue($ItemId, $LeftQuantity)
{
	$PurchaseValue = 0 ;
	
	$sql_purchase = "select * from ms_GRN_transaction where item_id = '".$ItemId."' order by GRN_transaction_id";
	
	$res_purchase=mysql_query($sql_purchase) or die("Error in : ".$sql_purchase."<br>".mysql_errno()." :".mysql_error());
	if(mysql_num_rows($res_purchase)>0)
	{
		while($row_purchase=mysql_fetch_array($res_purchase))
		{
			if($LeftQuantity > $row_purchase["rec_qty"])
			{
				$PurchaseValue += $row_purchase["rec_qty"] * $row_purchase["net_rate"];
				//echo $LeftQuantity." : ".$row_purchase["rec_qty"]." : ".$row_purchase["net_rate"]. " : ".$PurchaseValue;
				//echo "<br>";
				$LeftQuantity = $LeftQuantity - $row_purchase["rec_qty"];
			}
			else if($LeftQuantity>0)
			{
				$PurchaseValue += $LeftQuantity * $row_purchase["net_rate"];
				//echo $LeftQuantity." : ".$row_purchase["rec_qty"]." : ".$row_purchase["net_rate"]. " : ".$PurchaseValue;
				//echo "<br>";
				$LeftQuantity = 0;
			}
		}
	}
	return $PurchaseValue;
}

$SearchGRNDate='';
$SearchIEDate='';
$DateRange='';

$from = $to = date('Y-m-d');

if(isset($_POST['btn_submit']))
{
	$from=getDateFormate($_POST['dateFrom']);
	$to=getDateFormate($_POST['dateTo']);
}

$DateRange=$from.','.$to;
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/store_snb.php"); ?>
    </td>
    <td style="padding-left:5px; padding-top:5px;" valign="top">
      <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td align="center" class="gray_bg">
            <img src="images/bullet.gif" width="15" height="22"/> &nbsp; Stock Ledger Report
          </td>
        </tr>
        <tr>
          <td valign="top">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td align="center" class="border" >
                	<form name="frm" action="" method="post">
                    <table align="center" width="100%" border="1" class="table1 text_1">
                      <tr>
                        <td align="center" colspan="4"><b>Search</b>Fron <?=$from?> To <?=$to?></td>
                      </tr>
                      <tr>
                        <td align="left"><b>From</b></td>
                        <td align="left">
                          <input type="text" name="dateFrom" id="dateFrom"/>
                          <a href="javascript:void(0)" HIDEFOCUS
                              onClick="gfPop.fPopCalendar(document.getElementById('dateFrom'));return false;">
                              <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                          </a> 
                        </td>
                        <td align="left"><b>To</b></td>
                        <td align="left">
                          <input type="text" name="dateTo" id="dateTo"/>
                            <a href="javascript:void(0)" HIDEFOCUS
                              onClick="gfPop.fPopCalendar(document.getElementById('dateTo'));return false;">
                              <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                            </a> 
                        </td>
                       </tr>
                       <tr>
                        <td colspan="2" align="center">
                          <input type="submit" value="Ok" name="btn_submit" id="btn_submit"/>
                        </td>
                        <td colspan="2" align="center">
                          <input type="button" value="Reset" onClick="location.href='store_report_stock_ledger.php';" />
                        </td>
                       </tr>
                    </table>
                  </form>
                  
                  	<div id="getItemsInDiv" style="margin:0 auto;width:100%;overflow:auto;height:800px">
                       	<table align="center" width="100%" border="1" cellpadding="" class="table1 text_1">
                            <tr>
                                <td class="gredBg">S.No.</td>
                                <td class="gredBg">Department</td>
                                <td class="gredBg">Opening Value</td>
                                <td class="gredBg">Purchase Value</td>
                                <td class="gredBg">Issue Value</td>
                                <td class="gredBg">Closing Value</td> 
                            </tr>
                        	<?
							
							
                            $sql_department="SELECT department_id,name from ms_department where department_id in (select department_id from ms_item_master) ORDER BY name";

							$result_department=mysql_query($sql_department) or die("Error in : ".$sql_department."<br>".mysql_errno()." : ".mysql_error());
							
							
							if(mysql_num_rows($result_department)>0)
							{
								$sno = 1;
								$TotalOpeningValue = 0;
									
								$TotalPurchaseValue = 0;
								
								$TotalIssueValue = 0;
								
								$TotalClosingValue = 0;
								while($row_department = mysql_fetch_array($result_department))
								{
									$sql_opening_value="select 
													
													ms_item_master.item_id as ItemId,
													ms_item_master.name as ItemName,
													ms_item_master.opening_quantity as OpeningQuantity,
													ms_item_master.opening_rate as OpeningRate
												from 
													ms_item_master 
												where 
													
													ms_item_master.department_id='".$row_department['department_id']."'
												";
										
									$OpeningValue = 0;
									$IssueValue = 0;
									$OpneingIssueValue = 0;
									$LeftQuantity = 0;
									$OpeningQuantity = 0;
									$res_opening_value=mysql_query($sql_opening_value) or die("Error in : ".$sql_opening_value."<br>".mysql_errno()." :".mysql_error());
									if(mysql_num_rows($res_opening_value)>0)
									{
										while($row_opening_value=mysql_fetch_array($res_opening_value))
										{
											$OpeningValue+=$row_opening_value['OpeningQuantity']*$row_opening_value['OpeningRate'];
										
								
											$sql_opening_issue="select 
															sum(ms_IE_transaction.iss_qty) as OpeningIssueQuantity,
															ms_item_master.item_id as ItemId,
															ms_item_master.name as ItemName,
															ms_item_master.opening_quantity as OpeningQuantity,
															ms_item_master.opening_rate as OpeningRate
														from 
															ms_IE_master,
															ms_IE_transaction,
															ms_item_master 
														where 
															ms_IE_master.IE_id=ms_IE_transaction.IE_id 
															and ms_IE_transaction.item_id=ms_item_master.item_id 
															and ms_IE_master.IE_date < '".$from."'
															
															and ms_item_master.department_id='".$row_department['department_id']."'
															and ms_item_master.item_id='".$row_opening_value['ItemId']."'
															group by ms_item_master.item_id
															
														";
											//echo $row_opening_value['ItemId'];
											//echo $sql_opening_issue."<br>";
															
											$res_opening_issue=mysql_query($sql_opening_issue) or die("Error in : ".$sql_opening_issue."<br>".mysql_errno()." :".mysql_error());
											
											
											if(mysql_num_rows($res_opening_issue)>0)
											{
												while($row_opening_issue=mysql_fetch_array($res_opening_issue))
												{
													if($row_opening_issue["OpeningIssueQuantity"] > $row_opening_issue["OpeningQuantity"])
													{
														$OpneingIssueValue += $row_opening_issue["OpeningQuantity"]*$row_opening_issue["OpeningRate"];
														
														$LeftQuantity = $row_opening_issue["OpeningIssueQuantity"] - $row_opening_issue["OpeningQuantity"];
														//echo "<br>";
		
														$OpneingIssueValue += OpeningValue($row_opening_issue["ItemId"],$LeftQuantity);
													}
													else
													{
														$OpneingIssueValue += $row_opening_issue["OpeningIssueQuantity"]*$row_opening_issue["OpeningRate"]; 
													}
												}
											}
											
											$sql_opening_issue="select 
															sum(ms_IE_transaction.iss_qty) as OpeningIssueQuantity,
															ms_item_master.item_id as ItemId,
															ms_item_master.name as ItemName,
															ms_item_master.opening_quantity as OpeningQuantity,
															ms_item_master.opening_rate as OpeningRate
														from 
															ms_IE_master,
															ms_IE_transaction,
															ms_item_master 
														where 
															ms_IE_master.IE_id=ms_IE_transaction.IE_id 
															and ms_IE_transaction.item_id=ms_item_master.item_id 
															and ms_IE_master.IE_date between '".$from."' and '".$to."'
															
															and ms_item_master.department_id='".$row_department['department_id']."'
															
															and ms_item_master.item_id='".$row_opening_value['ItemId']."'
															
															group by ms_item_master.item_id
														";
													
											$res_opening_issue=mysql_query($sql_opening_issue) or die("Error in : ".$sql_opening_issue."<br>".mysql_errno()." :".mysql_error());
											
											if(mysql_num_rows($res_opening_issue)>0)
											{
												
												while($row_opening_issue=mysql_fetch_array($res_opening_issue))
												{
													//echo $OpneingIssueValue;
													if($row_opening_issue["OpeningIssueQuantity"] > $row_opening_issue["OpeningQuantity"] && $OpneingIssueValue!=0)
													{
														$IssueValue += $row_opening_issue["OpeningQuantity"]*$row_opening_issue["OpeningRate"];
														
														$LeftQuantity = $row_opening_issue["OpeningIssueQuantity"] - $row_opening_issue["OpeningQuantity"];
														
														$IssueValue += OpeningValue($row_opening_issue["ItemId"],$LeftQuantity);
														
													}
													else
													{
														$IssueValue += $row_opening_issue["OpeningIssueQuantity"]*$row_opening_issue["OpeningRate"];
													}
												}
											}
										}
									}
									
									$sql_purchase = "select
							
													(select 
														sum(ms_GRN_transaction.rec_qty*ms_GRN_transaction.net_rate) as OpeningPurchase 
													from 
														ms_GRN_master,
														ms_GRN_transaction,
														ms_item_master
														
														where ms_GRN_master.GRN_id = ms_GRN_transaction.GRN_id
														and ms_item_master.item_id = ms_GRN_transaction.item_id
														and ms_item_master.department_id = '".$row_department["department_id"]."'
														and ms_GRN_master.GRN_date < '".$from."') as OpeningPurchase 
													,
													(select 
														sum(ms_GRN_transaction.rec_qty*ms_GRN_transaction.net_rate) as PurchaseBetweenDates
													from 
														ms_GRN_master,
														ms_GRN_transaction,
														ms_item_master
														
														where ms_GRN_master.GRN_id = ms_GRN_transaction.GRN_id
														and ms_item_master.item_id = ms_GRN_transaction.item_id
														and ms_item_master.department_id = '".$row_department["department_id"]."'
														and ms_GRN_master.GRN_date between '".$from."' and '".$to."') as PurchaseBetweenDates
													
													
													
													";
									
									$result_purchase=mysql_query($sql_purchase) or die("Error in : ".$sql_purchase."<br>".mysql_errno()." : ".mysql_error());
													
									if(mysql_num_rows($result_purchase)>0)
									{
										while($row_purchase = mysql_fetch_array($result_purchase))
										{
											$OpeningPurchase = ($row_purchase["OpeningPurchase"]=="") ? 0 : $row_purchase["OpeningPurchase"];
											
											$TotalPurchase = ($row_purchase["PurchaseBetweenDates"]=="") ? 0 : $row_purchase["PurchaseBetweenDates"];
											
											$OpeningValue1 = $OpeningValue + $OpeningPurchase - $OpneingIssueValue;
											?>
											<tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                                                <td align="center"><?=$sno++?></td>
                                                <td align="left" style="padding-left:3px"><?=$row_department['name']?></td>
                                                <td align="right" style="padding-right:3px"><?=number_format($OpeningValue1,2)?></td>
                                                <td align="right" style="padding-right:3px"><?=number_format($TotalPurchase,2)?></td>
                                                <td align="right" style="padding-right:3px"><?=number_format($IssueValue,2)?></td>
                                                <td align="right" style="padding-right:3px"><?=number_format($OpeningValue1+$TotalPurchase-$IssueValue,2)?></td>
											</tr>
											<?
											$TotalOpeningValue += $OpeningValue1;
											
											$TotalPurchaseValue += $TotalPurchase;
											
											$TotalIssueValue += $IssueValue;
											
											$TotalClosingValue += $OpeningValue1+$TotalPurchase-$IssueValue;	
										}
									}
								}
							}
							?>
							
                           	 <tr style="font-weight:bold">
                               	<td></td>
                                <td align="left" style="padding-left:3px">Total</td>
                                <td align="right" style="padding-right:3px"><?=number_format($TotalOpeningValue,2)?></td>
                                <td align="right" style="padding-right:3px"><?=number_format($TotalPurchaseValue,2)?></td>
                                <td align="right" style="padding-right:3px"><?=number_format($TotalIssueValue,2)?></td>
                                <td align="right" style="padding-right:3px"><?=number_format($TotalClosingValue,2)?></td>
                            </tr>
                        	
                        </table>
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
<div id="overlay">
  <div class="form_msg">
    <p>Are you sure to delete this Record</p>
    <form name="frm_del" action="<?=$_SERVER['PHP_SELF']?>" method="post">
      <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
      <input type="submit" name="btn_del" value="Yes" />
      <input type="button" onClick="overlay();" name="btn_close" value="No" />
    </form>
  </div>
</div>

<? 
include("inc/hr_footer.php");
?>