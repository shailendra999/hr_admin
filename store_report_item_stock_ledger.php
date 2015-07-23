<?
include("inc/store_header.php");
?>
<script>
function overlay(id) {
  el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";	
}
function getDataInDiv(value,divId,page,byControl){
	var	dateFrom= document.getElementById('dateFrom').value;
	var	dateTo= document.getElementById('dateTo').value;
	if(dateFrom=='' || dateTo==''){
		alert("Select Date First.");
		location.reload(1);
	}else{
		str=dateFrom+','+dateTo+','+value;
		var strURL1=page+"?str="+str+"&byControl="+byControl+"&sid="+Math.random();
		alert(strURL1);
		var req = getXMLHTTP();
		if (req){																					
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
			global $start;
			
			$leftQuanity=number_format($issueQuantity,2,'.','');
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
				  $sql_func="select ms_GRN_master.GRN_id,ms_GRN_master.GRN_date,ifnull(ms_GRN_transaction.rec_qty,(select sum(return_qty) from ms_IR_transaction where ms_IR_transaction.item_id=ms_item_master.item_id and ms_item_master.item_id='".$itemId."')) as rec_qty,ifnull(ms_GRN_transaction.net_rate,0) as net_rate from ms_GRN_master,ms_GRN_transaction,ms_item_master where ms_GRN_master.GRN_id=ms_GRN_transaction.GRN_id and ms_GRN_transaction.item_id=ms_item_master.item_id and ms_GRN_transaction.item_id='".$itemId."' order by ms_GRN_transaction.GRN_transaction_id ASC limit $start,1 ";
			 
			$result_func=mysql_query($sql_func) or die("Error in : ".$sql_func."<br>".mysql_errno()." : ".mysql_error());	
			//if(mysql_num_rows($result_func)>0)
			{
					$row_func=mysql_fetch_array($result_func);

					$grnQtyleft=$row_func['rec_qty'];
					$grntRateleft=$row_func['net_rate'];
					$grnQtyleftCheck=$row_func['rec_qty'];									
			}
			
			
								
					if($leftQuanity<$grnQtyleft)
					{
						$issueRate=$issueRate+$grntRateleft*$leftQuanity;
						$grnQtyleftCheck=$grnQtyleftCheck-$leftQuanity;
					}
					else
					{
						$issueRate=$issueRate+$grntRateleft*$grnQtyleft;
						$grnQtyleftCheck=0;
					}
					
					$leftQuanity=$leftQuanity-$grnQtyleft;
					
					$start++;
												
			}			
			if($leftQuanity>0 and $leftQuanity>$issueQuantity)
			{				
				IssueRate($leftQuanity,$itemId);
			}
			//echo $issueRate.' : '.$leftQuanity;
			return $issueRate;
		}	

$sql="SELECT 
ms_department.department_id as department_id,
ms_item_master.item_id as ITEMID,
ms_item_master.opening_quantity as OpeningQty,
ms_item_master.closing_stock as ClosingQty,
ms_item_master.opening_rate as OpeningRate,
ms_department.name as Department,
ms_item_master.name as ItemName
FROM
ms_item_master,ms_department
WHERE
 ms_department.department_id = ms_item_master.department_id
ORDER BY ms_department.name";
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());

?>
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/store_snb.php"); ?>
    </td>
    <td style="padding-left:5px; padding-top:5px;" valign="top">
      <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td align="center" class="gray_bg">
            <img src="images/bullet.gif" width="15" height="22"/> &nbsp; Item Stock Ledger Report
          </td>
        </tr>
        <tr>
          <td valign="top">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td align="center" class="border" >
                  <table align="center" width="100%" border="1" class="table1 text_1">
                    <tr>
                      <td align="center" colspan="4"><b>Search Items</b></td>
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
                      <td align="left"><b>Department</b></td>
                      <td align="left">
                        <select name="department_id" id="department_id" style="width:250px;height:20px" onChange="getDataInDiv(this.value,'getItemsInDiv','store_get_report_item_stock_ledger.php','Department')" >
                          <option value="">-Select-</option>
                          <? $sql_dept= 'select * from ms_department order by name asc';
                            $res_dept = mysql_query ($sql_dept) or die("Error in : ".$sql_dept."<br>".mysql_errno()." : ".mysql_error());
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
                      <td align="left"><b>Item</b></td>
                      <td align="left">
                        <select name="item_id" id="item_id" style="width:50px; font-size:10px;" onChange="getDataInDiv(this.value,'getItemsInDiv','store_get_report_item_stock_ledger.php','Item')" >
                          <option value="">-Select-</option>
                          <? $sql_I= 'select * from ms_item_master order by name asc';
                            $res_I = mysql_query ($sql_I) or die("Error in : ".$sql_I."<br>".mysql_errno()." : ".mysql_error());
                            if(mysql_num_rows($res_I)>0)
                            {
                              while($row_I = mysql_fetch_array($res_I))
                              {
                                ?>
        	<option value="<?= $row_I['item_id']?>"><?= $row_I['name'].' | Drg No. '.$row_I['drawing_number'].'  | Cat. No.'.$row_I['catelog_number']?></option>
                                <? 
                              }
                            }
                            ?>
                          </select>
                      </td>
                     </tr>
                     <tr>
                      <td colspan="4" align="center">
                      	<input type="button" value="Reset" onclick="location.reload(1);" />
                      </td>
                 		 </tr>
            			</table>
                  <div id="getItemsInDiv" style="margin:0 auto;width:100%;overflow:auto;height:800px">
                    <table align="center" width="100%" border="1" cellpadding="" class="table1 text_1">
                      <tr>
                        <td class="gredBg" width="12%">Date</td>
                        <td class="gredBg" width="10%">Type</td>
                        <td class="gredBg" width="10%">Type No.</td>
                        <td class="gredBg" width="12%">Rec Qty.</td>
                        <td class="gredBg" width="12%">Rec Rate.</td>
                        <td class="gredBg" width="10%">Issue Qty.</td>
                        <td class="gredBg" width="10%">Issue Rate.</td>
                        <td class="gredBg" width="12%">Total. Qty.</td>
                        <td class="gredBg" width="12%">Total. Rate.</td> 
                      </tr>
                    	<?  
                      if(mysql_num_rows($result)>0)
                      {
                        $sno = 1;$oldid="";$flag=0;$deptId='';$count=0;$errorCount=0;
    										$totalOpening=0;$totalPurchase=0;$totalIssue=0;$totalRate=0;$errorIds='';
                        while($row=mysql_fetch_array($result))
                        {	
													$totalOpening=0;
                          $totalPurchase=0;
                          $totalIssue=0;
													$totalRate=0;
													if($row['department_id']!=$oldid)
													{
														$oldid = $row['department_id'];
														$flag=1;$sno=1;
													}
													else
													{
														$flag=0;
													}
													if($flag==1)
													{
													 ?>
                           <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                            <td colspan="9" align="left" style="color:#03F;font-size:14px;padding-left:15px">
                              <b><?= $row['Department']?></b>
                            </td>
                           </tr>
                           <?
													}
													$totalOpeningQuantity=$row['OpeningQty'];
													$totalOpeningRate=$row['OpeningRate'];
													?>
													<tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                          	<td colspan="9" align="left" style="color:#0CF;font-size:12px;padding-left:55px">
                              <b><?= $row['ItemName'].' : '.$row['ITEMID']?></b>
                            </td>
                          </tr>
                          <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                          	<td align="center"></td>
                            <td>&nbsp;<b>Opening</b></td><td>&nbsp;</td>
                            <td align="center"><?= $row['OpeningQty']?></td>
                            <td align="center"><?= $row['OpeningRate']?></td>
                            <td colspan="3" align="center"></td>
                            <td align="center">
                            <?
														$ORate=$row['OpeningQty']*$row['OpeningRate'];
														echo number_format($ORate,2,'.','');
														$totalRate+=$ORate;
                            ?>
                            </td>
                          </tr>
                          <?
													$sql_G="select ms_GRN_master.GRN_id,ms_GRN_master.GRN_date,ms_GRN_transaction.rec_qty,ms_GRN_transaction.net_rate from ms_GRN_master,ms_GRN_transaction,ms_item_master where ms_GRN_master.GRN_id=ms_GRN_transaction.GRN_id and ms_GRN_transaction.item_id=ms_item_master.item_id and ms_item_master.item_id='".$row['ITEMID']."'";
													$res_G=mysql_query($sql_G) or die("Error in : ".$sql_G."<br>".mysql_errno()." : ".mysql_error());
													if(mysql_num_rows($res_G)>0)
													{
														while($row_G=mysql_fetch_array($res_G))
														{
															?>
                              <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                                <td align="center"><?= getDateFormate($row_G['GRN_date'])?></td>
                                <td>&nbsp;<b>GRN</b></td><td align="center"><?= $row_G['GRN_id']?></td>
                                <td align="center"><?= $row_G['rec_qty']?></td>
                                <td align="center"><?= $row_G['net_rate']?></td>
                                <td colspan="2" align="center"></td>
                                <td align="center"><?= $row_G['rec_qty']?></td>
                                <td align="center">
																	<?
																	$GRate=$row_G['rec_qty']*$row_G['net_rate'];
																	echo number_format($GRate,2,'.','');
																	?>
                                </td>
                              </tr>
                              <?
															$totalPurchase+=$row_G['rec_qty'];
															$totalRate+=$GRate;
														}
													}
													?>
                          <?
													$sql_I="select ms_IE_master.IE_id,ms_IE_master.IE_date,ms_IE_transaction.iss_qty,ifnull((select avg(ms_GRN_transaction.net_rate) from ms_GRN_transaction,ms_item_master where ms_GRN_transaction.item_id = ms_item_master.item_id and ms_item_master.item_id='".$row['ITEMID']."') , ms_item_master.opening_rate) as avg_rate from ms_IE_master,ms_IE_transaction,ms_item_master where ms_IE_master.IE_id=ms_IE_transaction.IE_id and ms_IE_transaction.item_id=ms_item_master.item_id and ms_item_master.item_id='".$row['ITEMID']."'";
													$res_I=mysql_query($sql_I) or die("Error in : ".$sql_I."<br>".mysql_errno()." : ".mysql_error());
													if(mysql_num_rows($res_I)>0)
													{
														$leftQty=$row['OpeningQty'];
														$leftRate=$row['OpeningRate'];
														$start=0;
														$grnQtyleftCheck=0;
														while($row_I=mysql_fetch_array($res_I))
														{
															$issueRate=0;
															$issueRate=IssueRate(number_format($row_I['iss_qty'],2,'.',''),$row['ITEMID']);	
															?>
                              <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                                <td align="center"><?= getDateFormate($row_I['IE_date'])?></td>
                                <td>&nbsp;<b>Issue</b></td>
                                <td align="center"><?= $row_I['IE_id']?></td>
                                <td align="center">&nbsp;</td>
                                <td align="center">&nbsp;</td>
                                <td align="center"><?= $row_I['iss_qty']?></td>
                                <td align="center"><? $IssueRatePerQty=$issueRate/$row_I['iss_qty'];?><?= number_format($IssueRatePerQty,2,'.','')?></td>
                                <td align="center"><?= $row_I['iss_qty']?></td>
                                <td align="center">
																<?
																	$IRate=$issueRate;
																	echo number_format($issueRate,2,'.','');
																?>
																</td>
                              </tr>
                              <?
															$totalIssue+=$row_I['iss_qty'];
															$totalRate-=$IRate;
														}
													}
													
													$totalOpening+=$row['OpeningQty'];
													?>
                          <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                            <td align="center" colspan="7">
															<?
                                if($row['ClosingQty']!=($totalOpening+$totalPurchase-$totalIssue))
																{
																	$errorIds.=$row['ITEMID'].', ';
																	echo '<b style="background-color:#FF0000;color:#FFFFFF">'.$errorCount++.' : '.$row['ClosingQty'].'</b>';
																}
                              ?>
                            </td>
                            <td align="center"><?=($totalOpening+$totalPurchase-$totalIssue)?></td>
                            <td align="center"><?=number_format($totalRate,2,'.','')?></td>
                          </tr>
                          <?
													
                          $sno++; 
												}
                      }
                      else
                      {
                      ?>
                        <tr>
                          <td colspan="9" align="center"><b>No Records Found</b></td>
                        </tr>
                      <?    
                      }
                      ?>
                       <tr>
                          <td colspan="9" align="center" style="color:#FF0000"><?=$errorCount.' : '.$errorIds?></td>
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