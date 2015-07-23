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
	//var	dateFrom= document.getElementById('dateFrom').value;
	//var	dateTo= document.getElementById('dateTo').value;
	//if(dateFrom=='' || dateTo=='')
	{
		//alert("Select Date First.");
		//location.reload(1);
	}
	//else
	{
		str=value;//str=dateFrom+','+dateTo+','+value;
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
<script type="text/javascript">
function callPrintPage()
{
	///window.location.href=document.;
	document.frm_print.submit();
}
</script>
<?
$sql="SELECT 
ms_item_master.item_id as ItemId,CONCAT(ms_item_master.name,';Drg No. ',ms_item_master.drawing_number,';Cat No. ',ms_item_master.catelog_number) as Description,ms_item_master.location as Location,ms_uom.name as UOM,
ms_item_master.closing_stock as CStockQty,ms_item_master.opening_quantity as OStockQty,
ifnull((select avg(ms_GRN_transaction.net_rate) from ms_GRN_transaction where ms_GRN_transaction.item_id = ms_item_master.item_id) , ms_item_master.opening_rate) as UnitRate,
ifnull((select avg(ms_GRN_transaction.net_rate)*(ms_item_master.closing_stock) from ms_GRN_transaction where ms_GRN_transaction.item_id=ms_item_master.item_id),ms_item_master.opening_rate*(ms_item_master.closing_stock)) as Value,ms_department.name as Department,ms_department.department_id FROM
ms_item_master,ms_department,ms_machinary,ms_uom 
WHERE
ms_department.department_id = ms_item_master.department_id
and ms_machinary.machinary_id = ms_item_master.machinary_id
and ms_uom.uom_id = ms_item_master.uom_id
and (ms_item_master.opening_quantity!=0 OR ms_item_master.closing_stock!=0 OR ms_item_master.opening_rate!=0)
ORDER BY ms_department.name, ms_item_master.name";
/*$sql="SELECT 
ms_item_master.item_id as ItemId,CONCAT(ms_item_master.name,';Drg No. ',ms_item_master.drawing_number,';Cat No. ',ms_item_master.catelog_number) as Description,ms_item_master.location as Location,ms_uom.name as UOM,
ms_item_master.closing_stock as StockQty,ifnull((select avg(ms_GRN_transaction.net_rate) from ms_GRN_transaction where ms_GRN_transaction.item_id = ms_item_master.item_id) , ms_item_master.opening_rate) as UnitRate,
ifnull((select avg(ms_GRN_transaction.net_rate)*(ms_item_master.closing_stock) from ms_GRN_transaction where ms_GRN_transaction.item_id=ms_item_master.item_id),ms_item_master.opening_rate*(ms_item_master.closing_stock)) as Value,ms_department.name as Department,ms_department.department_id FROM
ms_item_master,ms_department,ms_machinary,ms_uom 
WHERE
ms_department.department_id = ms_item_master.department_id
and ms_machinary.machinary_id = ms_item_master.machinary_id
and ms_uom.uom_id = ms_item_master.uom_id
and ms_item_master.closing_stock!=0
ORDER BY ms_department.name";*/
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
            <img src="images/bullet.gif" width="15" height="22"/> &nbsp; Stock Report
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
                   <!-- <tr>
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
                     </tr>-->
                     <tr>
                      <td align="left"><b>Department</b></td>
                      <td align="left">
                        <select name="department_id" id="department_id" style="width:150px;height:20px" onChange="getDataInDiv(this.value,'getItemsInDiv','store_get_report_stock.php','Department')" >
                          <option value="">-Select-</option>
                          <? $sql_dept= 'select * from ms_department order by name asc';
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
                      	<input type="button" value="Reset" onclick="location.reload(1);" />
                      </td>
                 		 </tr>
            			</table>
                  <div id="getItemsInDiv" style="margin:0 auto;width:100%;overflow:auto;height:800px">
                    <table align="center" width="100%" border="1" cellpadding="" class="table1 text_1">
                      <tr>
                        <td class="gredBg" width="5%">S.No.</td>
                        <td class="gredBg" width="5%">Item Id</td>
                        <td class="gredBg" width="45%">Description</td>
                        <td class="gredBg" width="7%">UOM</td>
                        <td class="gredBg" width="10%">Location</td>
                        <td class="gredBg" width="7%">Op.StockQty.</td>
                        <td class="gredBg" width="7%">C.StockQty.</td>
                        <td class="gredBg" width="7%">Unit Rate</td> 
                        <td class="gredBg" width="7%">Value</td>
                      </tr>
                    <?  
                      if(mysql_num_rows($result)>0)
                      {
                        $sno = 1;$oldid="";$flag=0;$flag1=0;$deptId='';$count=0;
												$totalQty=0;$totalUnitRate=0;$totalValue=0;$totalOQty=0;$NewValue=0;
                        while($row=mysql_fetch_array($result))
                        {	
													
													if($row['department_id']!=$oldid)
													{
														$oldid = $row['department_id'];
														$flag=1;$sno=1;
													}
													else
													{
														$flag=0;
													}
													if($count!=0 && $flag==1)
													{
													?>
													 <tr bgcolor="#D0C9C1" style="font-size:13px;font-weight:bold;">
														<td colspan="5"><b>Total</b></td>
														<td align="right" style="padding-right:2px">
															<?= number_format($totalOQty,2,'.','')?>
														</td>
														<td align="right" style="padding-right:2px">
															<?= number_format($totalQty,2,'.','')?>
														</td>
														<td align="right" style="padding-right:2px">
															<?= number_format($totalUnitRate,2,'.','')?>
														</td>
														<td align="right" style="padding-right:2px">
															<?= number_format($totalValue,2,'.','')?>
														</td>
													 </tr>
													 <?
													 $totalQty=0;$totalOQty=0;
														$totalUnitRate=0;
														$totalValue=0;$count++;
													}
													else
														$count++;
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
													?>
													<tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
														<td align="center"><?=$sno?></td>
														<td align="center"><?= $row['ItemId']?></td>
														<td align="left" style="padding-left:5px">
															<?=$row['Description']?>
														</td>
														<td align="center"><?=$row['UOM']?></td>
														<td align="center"><?=$row['Location']?></td>
														<td align="right" style="padding-right:2px">
															<?=number_format($row['OStockQty'],2,'.','');?>
														</td>
														<td align="right" style="padding-right:2px">
															<?=number_format($row['CStockQty'],2,'.','');?>
														</td>
														<td align="right" style="padding-right:2px">
															<?=number_format($row['UnitRate'],2,'.','');?>
														</td>
														<td align="right" style="padding-right:2px">
														<?
														if($row['Value']==0 and $row['CStockQty']!=0)
														{
															$value=$row['UnitRate']*$row['CStockQty'];
															$totalValue+=$value;
															echo number_format($value, 2, '.','');
														}
														else
														{
															echo number_format($row['Value'], 2, '.','');
															$totalValue+=$row['Value'];
														}
														?>
														</td>
													</tr>
													<?
													$totalOQty+=$row['OStockQty'];
													$totalQty+=$row['CStockQty'];
													$totalUnitRate+=$row['UnitRate'];
													
													$sno++; 
												}
												if($count==mysql_num_rows($result))
												{
													?>
													 <tr bgcolor="#D0C9C1" style="font-size:13px;font-weight:bold;">
														<td colspan="5"><b>Total</b></td>
														<td align="right" style="padding-right:2px">
															<?= number_format($totalOQty,2,'.','')?>
														</td>
														<td align="right" style="padding-right:2px">
															<?= number_format($totalQty,2,'.','')?>
														</td>
														<td align="right" style="padding-right:2px">
															<?= number_format($totalUnitRate,2,'.','')?>
														</td>
														<td align="right" style="padding-right:2px">
															<?= number_format($totalValue,2,'.','')?>
														</td>
													 </tr>
													<?
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