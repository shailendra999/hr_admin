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
$sql="SELECT 
ms_department.department_id as department_id,
ms_department.name as Department,
ms_item_master.name as ItemName,CONCAT(ms_item_master.name,';Drg No. ',ms_item_master.drawing_number,';Cat No. ',ms_item_master.catelog_number) as Description,ms_uom.name as UOM,
ms_item_master.opening_quantity as OpeningQty,
ms_item_master.closing_stock as ClosingQty,
ifnull((select sum(ms_IE_transaction.iss_qty) from ms_IE_transaction where ms_IE_transaction.item_id = ms_item_master.item_id) , 0) as  IssueQty,
ifnull((select sum(ms_GRN_transaction.rec_qty) from ms_GRN_transaction where ms_GRN_transaction.item_id = ms_item_master.item_id) , 0) as PurchaseQty
FROM
ms_item_master,ms_department,ms_uom
WHERE
 ms_item_master.closing_stock!=0
  and 
 ms_department.department_id = ms_item_master.department_id
 and ms_uom.uom_id=ms_item_master.uom_id
ORDER BY ms_department.name,ms_item_master.name asc";
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
              <!--<tr>
                <td class="AddMore">
                  <a target="_blank" href="#" title="Print">Print All&nbsp;&nbsp;&nbsp;</a>
                </td>
              </tr>-->
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
                        <select name="department_id" id="department_id" style="width:150px;height:20px" onChange="getDataInDiv(this.value,'getItemsInDiv','store_get_report_stock_ledger_qty.php','Department')" >
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
                      <td colspan="2" align="center">
                      	<input type="button" value="Reset" onclick="location.reload(1);" />
                      </td>
                 		 </tr>
            			</table>
                  <div id="getItemsInDiv" style="margin:0 auto;width:100%;overflow:auto;height:800px">
                    <table align="center" width="100%" border="1" cellpadding="" class="table1 text_1">
                      <tr>
                        <td class="gredBg" width="5%">S.No.</td>
                        <td class="gredBg" width="45%">Description</td>
                        <td class="gredBg" width="10%">UOM</td>
                        <td class="gredBg" width="10%">Opening Qty.</td>
                        <td class="gredBg" width="10%">Purchase Qty.</td>
                        <td class="gredBg" width="10%">Issue Qty.</td>
                        <td class="gredBg" width="10%">Closing Qty.</td> 
                      </tr>
                    	<?  
                      if(mysql_num_rows($result)>0)
                      {
                        $sno = 1;$oldid="";$flag=0;$flag1=0;$deptId='';$count=0;
												$totalOpening=0;$totalPurchase=0;$totalIssue=0;$totalClosing=0;
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
                           <tr bgcolor="#D0C9C1">
                            <td colspan="3"><b>Total</b></td>
                            <td align="right" style="padding-right:2px">
															<?= number_format($totalOpening,2,'.','')?>
                            </td>
                            <td align="right" style="padding-right:2px">
															<?= number_format($totalPurchase,2,'.','')?>
                            </td>
                            <td align="right" style="padding-right:2px">
															<?= number_format($totalIssue,2,'.','')?>
                            </td>
                            <td align="right" style="padding-right:2px">
															<?= number_format($totalClosing,2,'.','')?>
                            </td>
                           </tr>
                           <?
                           $totalOpening=0;
                           $totalPurchase=0;
                           $totalIssue=0;
													 $totalClosing=0;
													 $count++;
                          }
												  else
														$count++;
													if($flag==1)
													{
													 
													 ?>
                           <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                            <td colspan="8" align="left" style="color:#03F;font-size:14px;padding-left:15px">
                              <b><?= $row['Department']?></b>
                            </td>
                           </tr>
                           <?
													}
													?>
												
                          <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                            <td align="center"><?=$sno?></td>
                            <td align="left" style="padding-left:5px"><?=$row['Description']?></td>
                            <td align="center"><?= $row['UOM'];?></td>
                            <td align="right" style="padding-right:2px"><?= $row['OpeningQty'];?></td>
                            <td align="right" style="padding-right:2px"><?= $row['PurchaseQty'];?></td>
                            <td align="right" style="padding-right:2px"><?= $row['IssueQty'];?></td>
                            <td align="right" style="padding-right:2px"><?=$row['ClosingQty']?></td>
                          </tr>
                        	<?
													$totalOpening+=$row['OpeningQty'];
													$totalPurchase+=$row['PurchaseQty'];
													$totalIssue+=$row['IssueQty'];
													$totalClosing+=$row['ClosingQty'];
                          $sno++; 
												}
												if($count==mysql_num_rows($result))
												{
												?>
                           <tr bgcolor="#D0C9C1">
                            <td colspan="3"><b>Total</b></td>
                            <td align="right" style="padding-right:2px">
                              <?= number_format($totalOpening,2,'.','')?>
                            </td>
                            <td align="right" style="padding-right:2px">
                              <?= number_format($totalPurchase,2,'.','')?>
                            </td>
                            <td align="right" style="padding-right:2px">
                              <?= number_format($totalIssue,2,'.','')?>
                            </td>
                            <td align="right" style="padding-right:2px">
                              <?= number_format($totalClosing,2,'.','')?>
                            </td>
                           </tr>
												<?
												}
                      }
                      else
                      {
                      ?>
                        <tr>
                          <td colspan="8" align="center"><b>No Records Found</b></td>
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