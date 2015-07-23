<? 	ob_start();
	include("../inc/dbconnection.php");
	include("../inc/store_function.php");
	set_time_limit(0);
	function OpeningValue($ItemId, $LeftQuantity){
		global $PurchaseValue;
		global $$ItemId;
		global $GRNLeftQuantity;
		$sql_purchase = "select * from ms_GRN_transaction where item_id = '".$ItemId."' order by GRN_transaction_id ASC limit ".$$ItemId.",1";
		$res_purchase=mysql_query($sql_purchase) or die("Error in : ".$sql_purchase."<br>".mysql_errno()." :".mysql_error());
		if(mysql_num_rows($res_purchase)>0){
			while($row_purchase=mysql_fetch_array($res_purchase)){
				if($LeftQuantity > $row_purchase["rec_qty"] && $GRNLeftQuantity<=0){
					$PurchaseValue += $row_purchase["rec_qty"] * $row_purchase["net_rate"];
					$LeftQuantity = $LeftQuantity - $row_purchase["rec_qty"];
					$$ItemId++;
					OpeningValue($ItemId,$LeftQuantity);
				}else if($GRNLeftQuantity>0 && $LeftQuantity>$GRNLeftQuantity){
					$PurchaseValue += $GRNLeftQuantity * $row_purchase["net_rate"];
					$LeftQuantity = $LeftQuantity - $GRNLeftQuantity;
					$$ItemId++;
					$GRNLeftQuantity = 0;
					if($LeftQuantity>0){
						OpeningValue($ItemId,$LeftQuantity);
					}
				}else if($GRNLeftQuantity>0 && $LeftQuantity<=$GRNLeftQuantity){
					$PurchaseValue += $LeftQuantity * $row_purchase["net_rate"];
					$GRNLeftQuantity = $GRNLeftQuantity - $LeftQuantity;
				}else{
					$PurchaseValue += $LeftQuantity * $row_purchase["net_rate"];
					$GRNLeftQuantity = $row_purchase["rec_qty"] - $LeftQuantity;
					if($GRNLeftQuantity==0){
						$$ItemId++;
					}
				}
			}
		}
		return $PurchaseValue;
	}
	
	$html_string='<table border="1">';
	
	$FromDate = date('Y-m-d');
	$ToDate = date('Y-m-d');
	$department_id = '';
	$machinary_id = '';
	$item_id = '';
	
	$WhereDepartment = "";
	$WhereMachinary = "";
	$WhereItem = "";
	$FromDate = ( $_POST["FromDate"]!= "") ? $_POST["FromDate"] : $FromDate;
	$ToDate = ( $_POST["ToDate"]!= "") ? $_POST["ToDate"] : $FromDate;
	$department_id = $_POST["department_name"];
	$machinary_id = $_POST["Machine_name"];
	$item_id = $_POST["Item_name"];
	$WhereDepartment = ($department_id!= "") ? " and ms_department.department_id = '".$department_id."'" : $WhereDepartment;
	$WhereMachinary = ($machinary_id!= "") ? " and im.machinary_id = '".$machinary_id."'" : $WhereMachinary;
	$WhereItem = ($item_id!= "") ?" and im.item_id = '".$item_id."'" : $WhereItem;
	
	$xlsfile = "Store_Report_Consumption".date("m-d-Y-hiA").".xls";
	//stop the browser displaying the HTML table displaying
	//force the browser to download as xcel document
	//if you make comment below two lines as php comments ,you see a simple HTML table
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=$xlsfile");
?>
<table align="center" width="100%" border="1" cellpadding="" class="table1 text_1">
 <caption><?=$company_Fulladdress.'<br /><strong>Stock Consumption Report From '.getDateFormate($FromDate).' To '.getDateFormate($ToDate).'</strong>'?></caption>
                      				<? 
									$sql_department="select 
															ms_department.department_id as DepartmentId,
															ms_department.name  as DepartmentName
														from 
															ms_department
														where
															ms_department.department_id!=''
															$WhereDepartment 
														order by
															ms_department.name";

									$result_department=mysql_query($sql_department) or die("Error in : ".$sql_department."<br>".mysql_errno()." : ".mysql_error());
									if(mysql_num_rows($result_department)>0)
									{
										while($row_department = mysql_fetch_array($result_department))
										{
											
											
											//if($row_department["IssueQuantityBetweenDate"]!=0) 
										{
											
									?>
                                    
											<?
											$TotalOpeningQuantity = 0;
											$TotalClosingQuantity = 0;
											$Total = 0;
											$TotalUnitRate = 0;
											//$tItemId = 4608 ;
											//and im.item_id=$tItemId
                                           	$sql_opening_value="select 
                                                            
                                                                    im.item_id as ItemId,
                                                                    im.name as ItemName,
																	CONCAT(im.name,';Drg No. ',im.drawing_number,';Cat No. ',im.catelog_number) as ItemDescription,
																	ms_uom.name as UOM,
																	im.location as ItemLocation,
                                                                    im.opening_quantity as OpeningQuantity,
																	im.opening_rate as OpeningRate,
																	
																	(
																		select 
																			ROUND(sum(ms_GRN_transaction.rec_qty),2) as OpeningPurchaseQuantity
																		from 
																			ms_GRN_master,
																			ms_GRN_transaction
																			
																		where 
																			ms_GRN_master.GRN_id = ms_GRN_transaction.GRN_id
																			and ms_GRN_transaction.item_id = im.item_id
																			and ms_GRN_master.GRN_date < '".$FromDate."'
																	) as OpeningPurchaseQuantity,
																	
																	(
																		select 
																			ROUND(sum(ms_GRN_transaction.rec_qty),2) as PurchaseQuantityBetweenDate
																		from 
																			ms_GRN_master,
																			ms_GRN_transaction
																			where ms_GRN_master.GRN_id = ms_GRN_transaction.GRN_id
																			and ms_GRN_transaction.item_id = im.item_id
																			and ms_GRN_master.GRN_date between '".$FromDate."' and '".$ToDate."'
																	) as PurchaseQuantityBetweenDate,
																	
																	(
																		select 
																			ROUND(sum(ms_IE_transaction.iss_qty),2) as OpeningIssueQuantity
																			
																		from 
																			ms_IE_master,
																			ms_IE_transaction
																		where 
																			ms_IE_master.IE_id=ms_IE_transaction.IE_id 
																			and ms_IE_transaction.item_id=im.item_id 
																			and ms_IE_master.IE_date < '".$FromDate."'
																	) as OpeningIssueQuantity,
																	(
																		select 
																			ROUND(sum(ms_IE_transaction.iss_qty),2) as IssueQuantityBetweenDate
																			
																		from 
																			ms_IE_master,
																			ms_IE_transaction
																		where 
																			ms_IE_master.IE_id=ms_IE_transaction.IE_id 
																			and ms_IE_transaction.item_id=im.item_id 
																			and ms_IE_master.IE_date between '".$FromDate."' and '".$ToDate."'
																	) as IssueQuantityBetweenDate
																	
																from 
																	ms_item_master im,
																	ms_uom
																where 
																	im.department_id='".$row_department['DepartmentId']."'
																	and ms_uom.uom_id = im.uom_id
                                                                    $WhereMachinary
																	$WhereItem
                                                                ";
											//echo $sql_opening_value;
											$res_opening_value=mysql_query($sql_opening_value) or die("Error in : ".$sql_opening_value."<br>".mysql_errno()." :".mysql_error());
											
											
                                            if(mysql_num_rows($res_opening_value)>0)
                                            {
												$sno_item = 1;
                                                while($row_opening_value=mysql_fetch_array($res_opening_value))
                                                {
													
													
													$TotalIValue = 0;	
													$OpeningValue = 0;
													$IssueValue = 0;
													$OpneingIssueValue = 0;
													$OpeningQuantity = 0;
													$LeftQuantity = 0;
													$PurchaseValue = 0;
													
													//echo $row_opening_value["OpeningQuantity"]." : ".$row_opening_value["OpeningPurchaseQuantity"]." : ".$row_opening_value["OpeningIssueQuantity"];
													
													//echo $row_opening_value["OpeningIssueQuantity"];
													$sOpeningQuantity = $row_opening_value["OpeningQuantity"]+$row_opening_value["OpeningPurchaseQuantity"]-$row_opening_value["OpeningIssueQuantity"];
													$TodayQuantity = $row_opening_value["PurchaseQuantityBetweenDate"] - $row_opening_value["IssueQuantityBetweenDate"];
													
													
													
													if(isset($$row_opening_value['ItemId']))
													{
													}
													else
													{
														$$row_opening_value['ItemId']=0;
														$GRNLeftQuantity = 0;
													}
												
													
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
																	and ms_IE_master.IE_date < '".$FromDate."'
																	
																	and ms_item_master.department_id='".$row_department['DepartmentId']."'
																	and ms_item_master.item_id='".$row_opening_value['ItemId']."'
																	
																	group by ms_item_master.item_id
																	
																";
													//echo $row_opening_value['ItemId'];
													//echo $sql_opening_issue."<br>";
																	
													$result_opening_issue=mysql_query($sql_opening_issue) or die("Error in : ".$sql_opening_issue."<br>".mysql_errno()." :".mysql_error());
													
													$flag = 0;
													if(mysql_num_rows($result_opening_issue)>0)
													{
														while($row_opening_issue=mysql_fetch_array($result_opening_issue))
														{
															$PurchaseValue = 0;
															$OpeningQuantity = $row_opening_issue["OpeningQuantity"];
															//echo "<br>";
															
															//echo $row_opening_issue["ItemId"]." : ".$row_opening_issue["OpeningIssueQuantity"]." : ".$row_opening_issue["OpeningQuantity"];
															
															//echo "<br>";
															//echo $row_opening_issue["OpeningIssueQuantity"];
															
															if($row_opening_issue["OpeningIssueQuantity"] > $row_opening_issue["OpeningQuantity"])
															{
																$OpneingIssueValue = $row_opening_issue["OpeningQuantity"]*$row_opening_issue["OpeningRate"];
																
																
																//$OpneingIssueValue;
																//echo $row_opening_issue["OpeningQuantity"]. " : ".$row_opening_issue["OpeningRate"]."<br>";
																
																//echo $row_opening_issue["OpeningQuantity"]." : ".$row_opening_issue["OpeningRate"]."<br>";
																
																$LeftQuantity = $row_opening_issue["OpeningIssueQuantity"] - $row_opening_issue["OpeningQuantity"];
																//echo "<br>";
																
																//echo $OpneingIssueValue."<br>";
																//echo $LeftQuantity."<br>";
																//echo OpeningValue($row_opening_issue["ItemId"],$LeftQuantity)."<br>";
																
																$OpneingIssueValue += OpeningValue($row_opening_issue["ItemId"],round($LeftQuantity,2));
																//echo $OpneingIssueValue."<br>";;
																$OpeningQuantity = 0;
																$flag = 1;
															}
															else
															{
																$OpneingIssueValue += $row_opening_issue["OpeningIssueQuantity"]*$row_opening_issue["OpeningRate"]; 
																
																
																$OpeningQuantity = $row_opening_issue["OpeningQuantity"] - $row_opening_issue["OpeningIssueQuantity"];
																
																$flag = 1;
															}
															//echo $row_opening_issue["ItemId"]." : ".$LeftQuantity."<br>";
															
															//echo $OpneingIssueValue;
															//echo "<br>";
															//echo $OpeningQuantity;
														}
													}
													
													
													//echo $OpneingIssueValue;
													//echo "<br>";
													$sql_today_opening_issue="select 
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
																	and ms_IE_master.IE_date between '".$FromDate."' and '".$ToDate."'
																	
																	and ms_item_master.department_id='".$row_department['DepartmentId']."'
																	
																	and ms_item_master.item_id='".$row_opening_value['ItemId']."'
																	
																	group by ms_item_master.item_id
																";
															

													//echo $sql_today_opening_issue."<br>";
													$result_today_opening_issue=mysql_query($sql_today_opening_issue) or die("Error in : ".$sql_today_opening_issue."<br>".mysql_errno()." :".mysql_error());
													
													if(mysql_num_rows($result_today_opening_issue)>0)
													{
														
														while($row_today_opening_issue=mysql_fetch_array($result_today_opening_issue))
														{
															$PurchaseValue = 0;
															//echo $OpneingIssueValue;
															
															//echo $OpeningQuantity. " : ".$flag;
															if($OpeningQuantity==0 && $flag == 0)
															{
																$OpeningQuantity = $row_today_opening_issue["OpeningQuantity"];
															}
															
															//echo $row_today_opening_issue["OpeningIssueQuantity"] ." : ".$OpeningQuantity ;
															
															
															//echo $row_today_opening_issue["OpeningIssueQuantity"]." : ".$OpeningQuantity;
															if($row_today_opening_issue["OpeningIssueQuantity"] > $OpeningQuantity)
															{
																$IssueValue = $OpeningQuantity*$row_today_opening_issue["OpeningRate"];
																
																$LeftQuantity = $row_today_opening_issue["OpeningIssueQuantity"] - $OpeningQuantity;
																
																//echo OpeningValue($row_today_opening_issue["ItemId"],$LeftQuantity);
																//echo $row_today_opening_issue["ItemId"]." : ".$LeftQuantity."<br>";
																$IssueValue += OpeningValue($row_today_opening_issue["ItemId"],$LeftQuantity);
																//echo $IssueValue;
															}
															else
															{
																$IssueValue += $row_today_opening_issue["OpeningIssueQuantity"]*$row_today_opening_issue["OpeningRate"];
															}
															//echo $row_today_opening_issue["ItemId"]." : ".$LeftQuantity."<br>";
															//echo $IssueValue."<br>";
															//echo $row_today_opening_issue["ItemId"]." : ".$OpeningQuantity." : ".$row_today_opening_issue["OpeningIssueQuantity"]." : ".$IssueValue;
															
															//echo "<br>";
															
															
														}
													}
												
													//echo $TotalIValue = $TotalIValue + $OpneingIssueValue + $IssueValue;
													
													$sql_purchase = "select
											
																	(select 
																		sum(ms_GRN_transaction.rec_qty*ms_GRN_transaction.net_rate) as OpeningPurchase 
																	from 
																		ms_GRN_master,
																		ms_GRN_transaction,
																		ms_item_master
																		
																		where ms_GRN_master.GRN_id = ms_GRN_transaction.GRN_id
																		and ms_item_master.item_id = ms_GRN_transaction.item_id
																		and ms_item_master.department_id = '".$row_department["DepartmentId"]."'
																		and ms_GRN_master.GRN_date < '".$FromDate."'
																		and ms_item_master.item_id='".$row_opening_value['ItemId']."'
																	) as OpeningPurchase 
																	,
																	(select 
																		sum(ms_GRN_transaction.rec_qty*ms_GRN_transaction.net_rate) as PurchaseBetweenDates
																	from 
																		ms_GRN_master,
																		ms_GRN_transaction,
																		ms_item_master
																		
																		where ms_GRN_master.GRN_id = ms_GRN_transaction.GRN_id
																		and ms_item_master.item_id = ms_GRN_transaction.item_id
																		and ms_item_master.department_id = '".$row_department["DepartmentId"]."'
																		and ms_GRN_master.GRN_date between '".$FromDate."' and '".$ToDate."'
																		and ms_item_master.item_id='".$row_opening_value['ItemId']."'
																		) as PurchaseBetweenDates
																	
																	
																	
																	";
													
													$result_purchase=mysql_query($sql_purchase) or die("Error in : ".$sql_purchase."<br>".mysql_errno()." : ".mysql_error());
																	
													if(mysql_num_rows($result_purchase)>0)
													{
														while($row_purchase = mysql_fetch_array($result_purchase))
														{
															$OpeningPurchase = ($row_purchase["OpeningPurchase"]=="") ? 0 : $row_purchase["OpeningPurchase"];
															
															$TotalPurchase = ($row_purchase["PurchaseBetweenDates"]=="") ? 0 : $row_purchase["PurchaseBetweenDates"];
															
															//echo $OpeningValue. " : ".$OpeningPurchase." : ".$OpneingIssueValue;
															
															$OpeningValue1 = $OpeningValue + $OpeningPurchase - $OpneingIssueValue;
														}
													}
													
													
										if($row_opening_value["IssueQuantityBetweenDate"]!=0) 
										{
										if($sno_item==1)
										{
									?>
                                    <tr>
                                        <td colspan="9" align="left" style="color:#03F;font-size:14px;padding-left:15px">
                                            <b><?=$row_department['DepartmentName']?></b>
                                        </td>
                                    </tr>
                                    <thead>
                                    <tr>
                                    	<td class="gredBg" width="5%">S.No.</td>
                                        <td class="gredBg" width="5%">Item Id</td>
                                        <td class="gredBg" width="45%">Description</td>
                                        <td class="gredBg" width="7%">UOM</td>
                                        <td class="gredBg" width="10%">Location</td>
                                        <td class="gredBg" width="7%">Quantity</td>
                                        <td class="gredBg" width="7%">Unit Rate</td> 
                                        <td class="gredBg" width="7%">Value</td>
                                    </tr>
                                    </thead>
                                    <?
									}
									?>
                                    <tbody>
                                    
                                    <tr>
                                    	<td width="5%" align="center"><?=$sno_item?><br /><?// echo $row_opening_value["OpeningQuantity"]." : ".$row_opening_value["OpeningPurchaseQuantity"]." : ".$row_opening_value["PurchaseQuantityBetweenDate"]." : ".$row_opening_value["OpeningIssueQuantity"]." : ".$row_opening_value["IssueQuantityBetweenDate"];?></td>
                                        <td width="5%" align="center"><?=$row_opening_value["ItemId"]?></td>
                                        <td width="45%"><?=$row_opening_value["ItemDescription"]?></td>
                                        <td width="7%" align="center"><?=$row_opening_value["UOM"]?></td>
                                        <td width="10%" align="center"><?=$row_opening_value["ItemLocation"]?></td>
                                        <td width="7%" align="center"><?=$row_opening_value["IssueQuantityBetweenDate"]?></td>
                                        <td width="7%" align="center">
											<? 
											if($row_opening_value["IssueQuantityBetweenDate"]!=0) 
											{ 
												echo number_format($IssueValue/$row_opening_value["IssueQuantityBetweenDate"],2);
											}
											?>
										</td> 
                                        <td width="7%" align="center"><?=$IssueValue?></td>
                                    </tr>
                                    
                                    <?
													$sno_item++;
													
													$TotalClosingQuantity += $row_opening_value["IssueQuantityBetweenDate"];
													
													$Total += $IssueValue;
													if($row_opening_value["IssueQuantityBetweenDate"]!=0) 
													{ 
														$TotalUnitRate += $IssueValue/$row_opening_value["IssueQuantityBetweenDate"];
													}
												}
												}
												if($TotalClosingQuantity != 0 and $TotalUnitRate != 0 and $Total != 0)
												{
												?>
                                    
                                    
                                    <tr bgcolor="#D0C9C1" style="font-size:13px;font-weight:bold;">
                                        <td colspan="4"><b>Total</b></td>
                                        <td align="right" style="padding-right:2px">
                                            
                                        </td>
                                        <td align="right" style="padding-right:2px">
                                            <?= number_format($TotalClosingQuantity,2,'.','')?>
                                        </td>
                                        <td align="right" style="padding-right:2px">
                                            <?= number_format($TotalUnitRate,2,'.','')?>
                                        </td>
                                        <td align="right" style="padding-right:2px">
                                            <?= number_format($Total,2,'.','')?>
                                        </td>
                                     </tr>
                                     </tbody>
                                                <?
												}
												}
											}
										}
									}
								
									?>
                                   
                                    </table>
