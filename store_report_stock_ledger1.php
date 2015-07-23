<?
include("inc/store_header.php");
?>
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
function IssueRate($issueQuantity,$itemId)
{
	global $totalOpeningQuantity;
	global $totalOpeningRate;
	global $issueRate;
	global $grnQtyleftCheck;
	global $grntRateleft;
	
	global $$itemId;
	
	$leftQuanity=$issueQuantity;
	
	//echo  $totalOpeningQuantity. ' : '.$totalOpeningRate. ' : '.$issueRate. ' : '.$grnQtyleftCheck. ' : '.$grntRateleft.' : '.$leftQuanity;
	//echo '<br>';
	
	
	if($totalOpeningQuantity>0)
	{
		if($totalOpeningQuantity>$issueQuantity)
		{
			$issueRate=$totalOpeningRate*$issueQuantity;
			$totalOpeningQuantity=$totalOpeningQuantity-$issueQuantity;
			$leftQuanity=$leftQuanity-$issueQuantity;
		}
		else
		{
			$leftQuanity=$leftQuanity-$totalOpeningQuantity;
			$issueRate=$totalOpeningRate*$totalOpeningQuantity;
			$totalOpeningQuantity=0;
		}
	}
	else if($grnQtyleftCheck>0)
	{
		if($grnQtyleftCheck < $leftQuanity)
		{
			$leftQuanity=$leftQuanity-$grnQtyleftCheck;
			$issueRate=$grntRateleft*$grnQtyleftCheck;
			$grnQtyleftCheck=0;
		}
		else
		{
			$issueRate=$grntRateleft*$leftQuanity;
			$grnQtyleftCheck=$grnQtyleftCheck-$leftQuanity;
			$leftQuanity=0;				
		}
	}
	else
	{
		$sql_func="select ms_GRN_master.GRN_id,ms_GRN_master.GRN_date,ms_GRN_transaction.rec_qty,ms_GRN_transaction.net_rate from ms_GRN_master,ms_GRN_transaction,ms_item_master where ms_GRN_master.GRN_id=ms_GRN_transaction.GRN_id and ms_GRN_transaction.item_id=ms_item_master.item_id and ms_GRN_transaction.item_id='".$itemId."' order by ms_GRN_transaction.GRN_transaction_id ASC limit ".$$itemId.",1";
	 	
	 
		$result_func=mysql_query($sql_func) or die("Error in : ".$sql_func."<br>".mysql_errno()." : ".mysql_error());	
		if(mysql_num_rows($result_func)>0)
		{
			$row_func=mysql_fetch_array($result_func);
			
			$grnQtyleft=$row_func['rec_qty'];
			$grntRateleft=$row_func['net_rate'];
			$grnQtyleftCheck=$row_func['rec_qty'];								
			if(round($leftQuanity,2)<=round($grnQtyleft,2))
			{
				$issueRate=$issueRate+($grntRateleft*$leftQuanity);
				$grnQtyleftCheck=$grnQtyleftCheck-$leftQuanity;
				$leftQuanity=0;
			}
			else
			{
				$issueRate=$issueRate+($grntRateleft*$grnQtyleft);
				$grnQtyleftCheck=0;
				$leftQuanity=$leftQuanity-$grnQtyleft;
			}	
			$$itemId++;
		}
		else
		{
			return 0;
		}
	}	
		
	if($leftQuanity>0)
	{			
		IssueRate($leftQuanity,$itemId);
	}
	//echo $issueRate.' : '.$leftQuanity;
	return $issueRate;
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

$SearchGRNDate="  and ms_GRN_master.GRN_date between '".$from."' and '".$to."'";
$SearchIEDate="  and ms_IE_master.IE_date between '".$from."' and '".$to."'";
$DateRange=$from.','.$to;
	
$sql="SELECT department_id,name from ms_department ORDER BY name";

$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());

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
                  <?
									if(isset($_POST['btn_submit']))
									{
									?>
                  	<div class="AddMore" style="padding-top:10px">
                    	<form action="store_print_report_stock_ledger.php" name="test" id="test" method="post" target="_blank"> 
                        <input type="hidden" name="DateRange" id="DateRange" value="<?=$DateRange ?>" />
                          <a href="#" onClick="test.submit();">Print&nbsp;&nbsp;&nbsp;</a>
                     </form>
                    </div>
                  <?
									}
									?>
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
					
                      if(mysql_num_rows($result)>0)
                      {
                        $snoDep = 1;$oldid="";$flag=0;$flag1=0;$deptId='';$count=0;
												$totalQty=0;$totalUnitRate=0;$totalValue=0;
												$GrossOpening=0;$GrossPurchase=0;$GrossIssue=0;$GrossClosing=0;
                        while($row=mysql_fetch_array($result))
                        {
							$OpningIssueValue=0;
							$OpningPurchaseValue=0;				
							
							$sql_opning_purchase="select 
														sum(ms_GRN_transaction.rec_qty*ms_GRN_transaction.net_rate) as OpningPurchaseValue
													from 
														ms_GRN_master,
														ms_GRN_transaction,
														ms_item_master
													where 
														ms_GRN_master.GRN_id=ms_GRN_transaction.GRN_id 
														and ms_GRN_transaction.item_id=ms_item_master.item_id 
														and ms_GRN_master.GRN_date < '".$from."'
														and ms_item_master.department_id='".$row['department_id']."'
														";
														
							$res_opning_purchase=mysql_query($sql_opning_purchase) or die("Error in : ".$sql_opning_purchase."<br>".mysql_errno()." : ".mysql_error());
							if(mysql_num_rows($res_opning_purchase)>0)
							{
								while($row_opning_purchase=mysql_fetch_array($res_opning_purchase))
								{
									$OpningPurchaseValue+=$row_opning_purchase['OpningPurchaseValue'];
									
								}
							}
																		
							
							
							$sql_opening_issue="select 
													sum(ms_IE_transaction.iss_qty) as opening_issue_qty,
													
													ms_item_master.item_id as ITEMID,
													ms_item_master.name,
													ms_item_master.opening_quantity as OpeningQty,ms_item_master.opening_rate as OpeningRate
												from 
													ms_IE_master,
													ms_IE_transaction,
													ms_item_master 
												where 
													ms_IE_master.IE_id=ms_IE_transaction.IE_id 
													and ms_IE_transaction.item_id=ms_item_master.item_id 
													and ms_IE_master.IE_date < '".$from."'
													and ms_item_master.department_id='".$row['department_id']."'
													group by ms_item_master.item_id
												";
													
							$res_opening_issue=mysql_query($sql_opening_issue) or die("Error in : ".$sql_opening_issue."<br>".mysql_errno()." :".mysql_error());
							if(mysql_num_rows($res_opening_issue)>0)
							{
								while($row_opening_issue=mysql_fetch_array($res_opening_issue))
								{
									
									$totalOpeningQuantity=$row_opening_issue['OpeningQty'];
									$totalOpeningRate=$row_opening_issue['OpeningRate'];
									$ORate=$row_opening_issue['OpeningQty']*$row_opening_issue['OpeningRate'];
									
									$leftQty=$row_opening_issue['OpeningQty'];
									$leftRate=$row_opening_issue['OpeningRate'];
									$grnQtyleftCheck=0;
									$grntRateleft=0;
									$issueRate=0;
									
									if(isset($$row_opening_issue['ITEMID']))
									{
									}
									else
									{
										$$row_opening_issue['ITEMID']=0;
									}
									
									
									$issueRate=IssueRate(number_format($row_opening_issue['opening_issue_qty'],2,'.',''),$row_opening_issue['ITEMID']);				
									
									
									//echo '<br>';
									//echo $row_opening_issue['ITEMID']. ' : '.$row_opening_issue['name']. ' : '.$row_opening_issue['opening_issue_qty'];
									
									//echo '<br>';
									
									$OpningIssueValue+=number_format($issueRate,2,'.','');

								}
								
							}
				
							//echo $OpningPurchaseValue. ' : '.$OpningIssueValue;
							//echo '<br>';
				
						 	$sql_sub="SELECT 
											ms_item_master.item_id as ITEMID,ms_item_master.name as ItemName,
											ms_item_master.opening_quantity as OpeningQty,ms_item_master.opening_rate as OpeningRate
											FROM
											ms_item_master,ms_department
											WHERE
											 ms_department.department_id = ms_item_master.department_id
											 and ms_item_master.department_id='".$row['department_id']."'
											ORDER BY ms_department.name";	
							$result_sub=mysql_query($sql_sub) or die("Error in : ".$sql_sub."<br>".mysql_errno()." : ".mysql_error());
							if(mysql_num_rows($result_sub)>0)
							{
								$sno = 1;$count=0;
								$totalOpening=0;$totalPurchase=0;$totalIssue=0;$totalRate=0;
								while($row_sub=mysql_fetch_array($result_sub))
								{	
									$totalOpeningQuantity=$row_sub['OpeningQty'];
									$totalOpeningRate=$row_sub['OpeningRate'];
									$ORate=$row_sub['OpeningQty']*$row_sub['OpeningRate'];
									//echo '<br>';
									//echo number_format($ORate,2,'.','');
									
									$sql_G="select sum(ms_GRN_transaction.rec_qty*ms_GRN_transaction.net_rate) as GRate from ms_GRN_master,ms_GRN_transaction,ms_item_master where ms_GRN_master.GRN_id=ms_GRN_transaction.GRN_id and ms_GRN_transaction.item_id=ms_item_master.item_id and ms_item_master.item_id='".$row_sub['ITEMID']."' $SearchGRNDate";
									$res_G=mysql_query($sql_G) or die("Error in : ".$sql_G."<br>".mysql_errno()." : ".mysql_error());
									if(mysql_num_rows($res_G)>0)
									{
										while($row_G=mysql_fetch_array($res_G))
										{
											$GRate=$row_G['GRate'];
											$totalPurchase+=number_format($GRate,2,'.','');
										}
									}
									
									
									 $sql_I="select sum(ms_IE_transaction.iss_qty) as iss_qty from ms_IE_master,ms_IE_transaction,ms_item_master where ms_IE_master.IE_id=ms_IE_transaction.IE_id and ms_IE_transaction.item_id=ms_item_master.item_id and ms_item_master.item_id='".$row_sub['ITEMID']."' $SearchIEDate  group by ms_item_master.item_id order by ms_item_master.item_id";
							
									$res_I=mysql_query($sql_I) or die("Error in : ".$sql_I."<br>".mysql_errno()." :".mysql_error());
									if(mysql_num_rows($res_I)>0)
									{
										$sql_issue = "select 
													sum(ms_IE_transaction.iss_qty) as opening_issue_qty from ms_IE_master,ms_IE_transaction where ms_IE_master.IE_id=ms_IE_transaction.IE_id  and ms_IE_transaction.item_id ='".$row_sub['ITEMID']."' and ms_IE_master.IE_date < '".$from."'";
													
													
										$res_issue=mysql_query($sql_issue) or die("Error in : ".$sql_issue."<br>".mysql_errno()." :".mysql_error());
										if(mysql_num_rows($res_issue)>0)
										{
											$row_issue=mysql_fetch_array($res_issue);
											$leftQty=$row_sub['OpeningQty'] - $row_issue["opening_issue_qty"];
										}
										else
										{
											$leftQty=$row_sub['OpeningQty'];
										}
										$totalOpeningQuantity = $leftQty;
										
										$leftRate=$row_sub['OpeningRate'];
										
										if(isset($$row_sub['ITEMID']))
										{
										}
										else
										{
											$$row_sub['ITEMID']=0;
										}
										
										$grnQtyleftCheck=0;
										$grntRateleft=0;
										while($row_I=mysql_fetch_array($res_I))
										{
											//echo $row_I['iss_qty']."-".$row_sub['ITEMID']."<br/>";
											$issueRate=0;
											$issueRate=IssueRate(number_format($row_I['iss_qty'],2,'.',''),$row_sub['ITEMID']);		
											
											
											$totalIssue+=number_format($issueRate,2,'.','');
											
											
											//echo $row_sub['ITEMID']. ' : '.$row_sub['ItemName']. ' : '.$issueRate . ' : '.$row_I['iss_qty'].' : '.$leftRate;
									
											//echo '<br>';
											
										}
									}
									
									$totalRate+=number_format($ORate,2,'.','');
									
								}
								//echo $totalPurchase." : ".$totalIssue."<br />";
								
								//echo $totalRate. ' : '.$OpningPurchaseValue. ' : '.$OpningIssueValue;
								$totalRate1 = $totalRate + $OpningPurchaseValue - $OpningIssueValue;
								
								
															?>
                                <tr <? if ($snoDep%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                                  <td align="center"><?=$snoDep++?></td>
                                  <td align="left" style="padding-left:3px"><?= $row['name']?></td>
                                  <td align="right" style="padding-right:3px"><?=number_format($totalRate1,2)?></td>
                                  <td align="right" style="padding-right:3px"><?=number_format($totalPurchase,2)?></td>
                                  <td align="right" style="padding-right:3px"><?=number_format($totalIssue,2)?></td>
                                  <td align="right" style="padding-right:3px"><?=number_format($totalRate1+$totalPurchase-$totalIssue,2)?></td>
                                </tr>
                                <?
											$GrossOpening+=$totalRate1;
											$GrossPurchase+=$totalPurchase;
											$GrossIssue+=$totalIssue;
											$GrossClosing+=($totalRate1+$totalPurchase-$totalIssue);
										}
											
									} 
								?>
													 <tr style="font-weight:bold">
															<td align="right" style="padding-right:3px" colspan="2">Total:</td>
															<td align="right" style="padding-right:3px"><?=number_format($GrossOpening,2)?></td>
															<td align="right" style="padding-right:3px"><?=number_format($GrossPurchase,2)?></td>
															<td align="right" style="padding-right:3px"><?=number_format($GrossIssue,2)?></td>
															<td align="right" style="padding-right:3px"><?=number_format(($GrossClosing),2)?></td>
													 </tr>

                     <? 
										 }
                      else
                      {
                      ?>
                        <tr>
                          <td colspan="6" align="center"><b>No Records Found</b></td>
                        </tr>
                      <?    
                      }
                      ?> 
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