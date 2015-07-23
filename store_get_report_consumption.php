<?
include("inc/check_session.php");
include("inc/dbconnection.php");
include("inc/store_function.php");
$value=(isset($_REQUEST['str']))?$_REQUEST['str'] : "";
?>

<?
function IssueRate($issueQuantity,$itemId)
{
	global $totalOpeningQuantity;
	global $totalOpeningRate;
	global $issueRate;
	global $grnQtyleftCheck;
	global $grntRateleft;
	
	global $$itemId;
	
	//echo $itemId. " : ".$$itemId;
	//echo "<br>";
	
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

if($value!='')
{
	$val=explode(",",$value);
	
	$SearchIEDate="";
	$SearchDepartment="";
	$SearchMachinary="";
	$SearchItem="";


	$from=getDateFormate($val[0]);
	$to=getDateFormate($val[1]);
	$SearchIEDate = "and ms_IE_master.IE_date between'".$from."' and '".$to."'";
	if($_REQUEST['byControl']=='Department' and $val[2]!="")
	{
		$SearchDepartment=" where ms_department.department_id='".$val[2]."' ";
		
	}
	else if($_REQUEST['byControl']=='Machinary' and $val[2]!="")
	{
		$SearchMachinary=" and ms_machinary.machinary_id='".$val[2]."' ";
		
	}
	else if($_REQUEST['byControl']=='ItemId' and $val[2]!="")
	{
		$SearchItem=" and ms_item_master.item_id='".$val[2]."' ";
		
	}
}



$SearchGRNDate="  and ms_GRN_master.GRN_date between '".$from."' and '".$to."'";
$SearchIEDate="  and ms_IE_master.IE_date between '".$from."' and '".$to."'";
$DateRange=$from.','.$to;
	
$sql="SELECT department_id,name from ms_department $SearchDepartment ORDER BY name";

$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());

?>

                	
                  	<div class="AddMore" style="padding-top:10px">
                    	<form action="store_print_report_stock_ledger.php" name="test" id="test" method="post" target="_blank"> 
                        <input type="hidden" name="DateRange" id="DateRange" value="<?=$DateRange ?>" />
                          <a href="#" onClick="test.submit();">Print&nbsp;&nbsp;&nbsp;</a>
                     </form>
                    </div>
                 
                    
                      
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
											ms_item_master.opening_quantity as OpeningQty,ms_item_master.opening_rate as OpeningRate,
											CONCAT(ms_item_master.name,';Drg No. ',ms_item_master.drawing_number,';Cat No. ',ms_item_master.catelog_number) as ItemDescription,
			ms_uom.name as UOM
											FROM
											ms_item_master,ms_department,ms_uom 
											WHERE
											 ms_department.department_id = ms_item_master.department_id
											 and ms_uom.uom_id = ms_item_master.uom_id
											 and ms_item_master.department_id='".$row['department_id']."'
											ORDER BY ms_department.name";	
							$result_sub=mysql_query($sql_sub) or die("Error in : ".$sql_sub."<br>".mysql_errno()." : ".mysql_error());
							
							
							if(mysql_num_rows($result_sub)>0)
							{
							?>
                            <table align="center" width="100%" border="1" cellpadding="" class="table1 text_1">
                                            <tr>
                                                <td class="gredBg">S.No.</td>
                                                <td class="gredBg">Item Id</td>
                                                <td class="gredBg">Description</td>
                                                <td class="gredBg">UOM</td>
                                                <td class="gredBg">Qty.</td>
                                                <td class="gredBg">Unit Rate</td> 
                                                <td class="gredBg">Value</td>
                                            </tr>
                            <?
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
											?>
                                            <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                                                    <td align="center"><?=$sno?></td>
                                                    <td align="center"><?=$row_sub['ITEMID']?></td>
                                                    <td align="left" style="padding-left:5px"><?=$row_sub['ItemDescription']?></td>
                                                    <td align="center"><?= $row_sub['UOM']?></td>
                                                    <td align="right" style="padding-right:2px"><?=number_format($row_I['iss_qty'], 2, '.', '');?></td><? //number_format($row['Qty'], 2, '.', '');?>
                                                    <td align="right" style="padding-right:2px"><?=number_format($issueRate/$row_I['iss_qty'], 2, '.', '');?></td>
                                                    <td align="right" style="padding-right:2px"><?=number_format($issueRate, 2, '.', '');?></td>
                                                </tr>
                                            <?
                                                    $sno++;
                                            
											
										}
									}
									
									$totalRate+=number_format($ORate,2,'.','');
									
								}
								
								$totalRate1 = $totalRate + $OpningPurchaseValue - $OpningIssueValue;
								
								?>
                                			<tr>
                                            	<td colspan="6" align="right" style="padding-right:2px">
                                                	Total
                                                </td>
                                                <td align="right" style="padding-right:2px">
                                                	<?=$totalIssue?>
                                                </td>
                                            </tr>
                                        </table>
                                        <?
															
										}
											
									} 
								?>
													 

                     <? 
										 }
                      
                      ?> 
                  	
                  