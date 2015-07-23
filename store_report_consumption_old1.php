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
<style type="text/css" media="print">
#btn_print, form, .tnb_print, img, .top_tnb, .header_bg, .welcome_txt, iframe, #overlay
{
	display:none;
}
#getItemsInDiv
{
	display:block;
	height:auto;
}
</style>
<?
function OpeningValue($ItemId, $LeftQuantity)
{
	global $PurchaseValue;
	global $$ItemId;
	global $GRNLeftQuantity;
	
	//echo $LeftQuantity."<br>";
	
	
	
	$sql_purchase = "select * from ms_GRN_transaction where item_id = '".$ItemId."' order by GRN_transaction_id ASC limit ".$$ItemId.",1";
	
	//echo $sql_purchase."<br>";
	//echo $$ItemId."<br>";
	$res_purchase=mysql_query($sql_purchase) or die("Error in : ".$sql_purchase."<br>".mysql_errno()." :".mysql_error());
	if(mysql_num_rows($res_purchase)>0)
	{
		while($row_purchase=mysql_fetch_array($res_purchase))
		{
			
			if($LeftQuantity > $row_purchase["rec_qty"])
			{
				
				//echo "A ".$ItemId." : ".$LeftQuantity." : ".$row_purchase["rec_qty"]." : ".$row_purchase["net_rate"];
				//echo "<br>";
				
				$PurchaseValue += $row_purchase["rec_qty"] * $row_purchase["net_rate"];
				
				
				$LeftQuantity = $LeftQuantity - $row_purchase["rec_qty"];
				//echo "<br>";
				$$ItemId++;
				
				OpeningValue($ItemId,$LeftQuantity);
			}
			else if($GRNLeftQuantity>0 && $LeftQuantity>$GRNLeftQuantity)
			{
				//echo "B ".$ItemId." : ".$LeftQuantity." : ".$row_purchase["rec_qty"]." : ".$row_purchase["net_rate"];
				//echo "<br>";
				
				$PurchaseValue += $GRNLeftQuantity * $row_purchase["net_rate"];
				
				$LeftQuantity = $LeftQuantity - $GRNLeftQuantity;
				$$ItemId++;
				$GRNLeftQuantity = 0;
				if($LeftQuantity>0)
				{
					OpeningValue($ItemId,$LeftQuantity);
				}
				
			}
			else if($GRNLeftQuantity>0 && $LeftQuantity<=$GRNLeftQuantity)
			{
				//echo "C ".$ItemId." : ".$LeftQuantity." : ".$row_purchase["rec_qty"]." : ".$row_purchase["net_rate"];
				//echo "<br>";
				
				$PurchaseValue += $LeftQuantity * $row_purchase["net_rate"];
				
				$GRNLeftQuantity = $GRNLeftQuantity - $LeftQuantity;
			}
			else
			{
				
				//echo "D ".$ItemId." : ".$LeftQuantity." : ".$row_purchase["rec_qty"]." : ".$row_purchase["net_rate"];
				//echo "<br>";
				
				$PurchaseValue += $LeftQuantity * $row_purchase["net_rate"];
				
				$GRNLeftQuantity = $row_purchase["rec_qty"] - $LeftQuantity;
				
				if($GRNLeftQuantity==0)
				{
					$$ItemId++;
				}
			}
		}
	}
	return $PurchaseValue;
}


$FromDate = date('Y-m-d');
$ToDate = date('Y-m-d');
$WhereDepartment = "";
$WhereMachinary = "";
$WhereItem = "";
if(isset($_POST["btn_submit"]))
{
	$FromDate = ( $_POST["FromDate"]!= "") ? getDateFormate($_POST["FromDate"]) : $FromDate;
	$ToDate = ( $_POST["ToDate"]!= "") ? getDateFormate($_POST["ToDate"]) : $FromDate;
	
	$department_id = $_POST["department_id"];
	$machinary_id = $_POST["machinary_id"];
	$item_id = $_POST["item_id"];
	
	
	$WhereDepartment = ($department_id!= "") ? " and ms_department.department_id = '".$department_id."'" : $WhereDepartment;
	
	$WhereMachinary = ($machinary_id!= "") ? " and im.machinary_id = '".$machinary_id."'" : $WhereMachinary;
	
	$WhereItem = ($item_id!= "") ?" and im.item_id = '".$item_id."'" : $WhereItem;
	
}
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
	<tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;" class="tnb_print"><? include ("inc/store_snb.php"); ?></td>
	    <td style="padding-left:5px; padding-top:5px;" valign="top">
      		<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
        		<tr>
          			<td align="center" class="gray_bg">
			            <img src="images/bullet.gif" width="15" height="22"/> &nbsp; Stock Consumption Report
          			</td>
		        </tr>
        		<tr>
		          	<td valign="top" id="test">
                        <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td align="center" colspan="4"><b>Search</b> From <?=getDateFormate($FromDate)?> To <?=getDateFormate($ToDate)?></td>
                            </tr>
                            <tr>
                                <td align="center" class="border" >
                                    <form name="frm" action="" method="post">
                                        <table align="center" width="100%" border="1" class="table1 text_1">
                                          	<tr>
                                            	<td align="left"><b>From</b></td>
                                            		<td align="left">
                                              			<input type="text" name="FromDate" id="FromDate"/>
                                              			<a href="javascript:void(0)" HIDEFOCUS
                                                  			onClick="gfPop.fPopCalendar(document.getElementById('FromDate'));return false;">
                                                  			<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                                              			</a>
                                            	</td>
                                            	<td align="left"><b>To</b></td>
                                            	<td align="left">
                                              		<input type="text" name="ToDate" id="ToDate"/>
                                                	<a href="javascript:void(0)" HIDEFOCUS
                                                  		onClick="gfPop.fPopCalendar(document.getElementById('ToDate'));return false;">
                                                  		<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                                                	</a> 
                                            	</td>
                                           	</tr>
                                           	<tr>
                                          		<td align="left"><b>Department</b></td>
                                          		<td align="left">
                                            		<select name="department_id" id="department_id" style="width:150px;height:20px" onChange="getDataInDiv(this.value,'getItemsInDiv','store_get_report_stock.php','Department')" >
                                              			<option value="">-Select-</option>
                                              		<?
													$sql_dept= 'select * from ms_department order by name asc';
                                                	$res_dept = mysql_query ($sql_dept) or die (mysql_error());
                                                	if(mysql_num_rows($res_dept)>0)
                                                	{
                                                  		while($row_dept = mysql_fetch_array($res_dept))
                                                  		{
                                                    ?>
                                                    	<option value='<?= $row_dept['department_id'];?>'><?= $row_dept['name'];?></option>
                                                    <? 
                                                  		}
                                                	}
                                                	?>
                                              		</select>
                                          		</td>
                                          		<td align="left"><b>Machinary</b></td>
                                          		<td align="left">
                                            		<select name="machinary_id" id="machinary_id" style="width:150px;height:20px" onChange="getDataInDiv(this.value,'getItemsInDiv','store_get_report_stock.php','Machinary')" >
                                              			<option value="">-Select-</option>
                                                        <? 
                                              			$sql_I= 'select * from ms_machinary order by name asc';
                                                		$res_I = mysql_query ($sql_I) or die (mysql_error());
                                                		if(mysql_num_rows($res_I)>0)
                                                		{
                                                  			while($row_I = mysql_fetch_array($res_I))
                                                  			{
                                                    	?>
                                                    	<option value='<?= $row_I['machinary_id']?>'><?= $row_I['name']?></option>
                                                    	<? 
                                                  			}
                                                		}
                                                		?>
                                            		</select>
                                            	</td>
											</tr>
                                           	<tr>
                                           		<td align="left"><b>Item Name</b></td>
                                                <td align="left">
                                                    <select name="item_id" id="item_id" style="width:250px;height:20px" onChange="getDataInDiv(this.value,'getItemsInDiv','store_get_report_stock.php','ItemId')" >
                                                        <option value="">-Select-</option>
                                                    <? 
                                                    $sql_I= 'select * from ms_item_master order by name asc';
                                                    $res_I = mysql_query ($sql_I) or die (mysql_error());
                                                    if(mysql_num_rows($res_I)>0)
                                                    {
                                                        while($row_I = mysql_fetch_array($res_I))
                                                        {
                                                        ?>
                                                        <option value='<?= $row_I['item_id']?>'><?= $row_I['name']?></option>
                                                        <? 
                                                        }
                                                    }
                                                    ?>
                                                    </select>
                                                </td>
                                                <td colspan="2" align="center">
                                                    <input type="submit" value="Ok" name="btn_submit" id="btn_submit"/>
                                                </td>
											</tr>
                                        </table>
                                    </form>
                      				<table align="center" width="100%" border="1" cellpadding="" class="table1 text_1">
                      				<?
									if(isset($_POST["btn_submit"]))
									{
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
                                    <tr bgcolor="#F5F2F1">
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
                                    
                                    <tr <? if ($sno_item%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
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
									}
									?>
                                   
                                    </table>
                                   	<input type="button" id="btn_print" name="btn_print" value="Print" onClick="window.print();" />
                        
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