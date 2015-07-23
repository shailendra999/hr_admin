<? include("inc/store_header.php");
set_time_limit(0); ?>
<script>
function checkData(){
	var status=true;
	var dept_id=document.getElementById('department_id').value;
	var fromDate=document.getElementById('dateFrom').value;
	var toDate=document.getElementById('dateTo').value;
	if(dept_id=='' && fromDate=='' && toDate==''){	
		status=false;
		alert('Check All Entries');
	}
	return status;
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
$department_id ='';
$SearchByDepartmentId='';
$department_id='';
$fromDate='';
$toDate='';
$SearchInGRNDate='and ms_GRN_master.GRN_date < CAST(now() as DATE)';
if(isset($_POST['btn_submit'])){
#	echo '<pre>';	print_r($_POST);	echo '<pre>';
	$department_id=$_POST['department_id'];
	$fromDate=getDateFormate($_POST['dateFrom']);
	$toDate=getDateFormate($_POST['dateTo']);
	/*if($toDate == ''){
		$toDate = date('Y-m-d');
	}*/
	if($department_id != ''){
		$SearchByDepartmentId=" and ms_department.department_id= ".$department_id;
	}
	if($fromDate != '' && $toDate !=''){
		$SearchInGRNDate="and ms_GRN_master.GRN_date  between '".$fromDate."' and '".$toDate."'";
	}
}
$sql="SELECT
	ms_department.department_id as DeptId,
	ms_department.name as Department,
	ms_item_master.item_id as ItemId,
	ms_item_master.opening_quantity as opening_quantity,
	CONCAT(ms_item_master.name,' Drg No . ',ms_item_master.drawing_number) as Description
FROM
	ms_item_master,
	ms_department
WHERE
	ms_department.department_id = ms_item_master.department_id
	$SearchByDepartmentId
ORDER BY
	ms_department.name asc,
	ms_item_master.name";//and ms_department.department_id=3
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error()); ?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
	<tr><td align="left" valign="top" width="230px" style="padding-top:5px;"><? include ("inc/store_snb.php"); ?></td>
    <td style="padding-left:5px; padding-top:5px;" valign="top">
    	<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
        	<tr><td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Stock Unused Report</td></tr>
            <tr><td valign="top">
            	<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                	<tr><td align="center" class="border" >
                    	<form name="frm_show" id="frm_show" method="post" onsubmit="return checkData()">
                        	<table align="center" width="100%" border="1" class="table1 text_1">
                            	<tr><td align="center" colspan="4"><b>Search Items</b></td></tr>
                                <tr>
                                	<td align="left"><b>From Date</b></td>
                                    <td align="left"><input type="text" name="dateFrom" id="dateFrom"/>
                                    	<a href="javascript:void(0)" HIDEFOCUS onClick="gfPop.fPopCalendar(document.getElementById('dateFrom'));return false;">
                                        	<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                                        </a>
                                    </td>
                                    <td align="left"><b>To Date</b></td>
                                    <td align="left"><input type="text" name="dateTo" id="dateTo"/>
                                    	<a href="javascript:void(0)" HIDEFOCUS onClick="gfPop.fPopCalendar(document.getElementById('dateTo'));return false;">
                                        <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
										</a> 
									</td></tr>
					<tr>
                      	<td align="left"><b>Department</b></td>
                        <td align="left">
                        <select name="department_id" id="department_id" style="width:150px;height:20px">
                          <option value="">-Select-</option>
                          <? $sql_dept= 'select * from ms_department order by name asc';
                            $res_dept = mysql_query ($sql_dept) or die (mysql_error());
                            if(mysql_num_rows($res_dept)>0){
                              while($row_dept = mysql_fetch_array($res_dept)){ ?>
                                <option value='<?= $row_dept['department_id'];?>'><?= $row_dept['name'];?></option>
                                <?  }
                            } ?>
                          </select>
                      	</td>
                        <td align="center"><input type="submit" id="btn_submit" name="btn_submit" value="Search"/></td>
                        <td align="center"><input type="button" value="Reset" onclick="location.reload(1);" /></td>
                     </tr>
                  	</table>
                  </form>
                  <div id="getItemsInDiv" style="margin:0 auto;width:100%;overflow:auto;height:800px;border:1px solid black;">
                  <? if(isset($_POST['btn_submit'])){ ?>
                  	<div class="AddMore" style="padding-top:10px;" id="divPrint">
                    <form action="store_print_report_unused_stock.php" name="test" id="test" method="post" target="_blank" style="float:right"> 
                      <input type="hidden" name="department_name" id="department_name" value="<?=$department_id ?>" />
                      <input type="hidden" name="FromDate" id="FromDate" value="<?=$_POST['dateFrom'] ?>"/>
                      <input type="hidden" name="ToDate" id="ToDate" value="<?=$_POST['dateTo'] ?>"/>
                        <a href="#" onclick="test.submit();"><img src="images/print_25.png"  /></a>
                     </form>
                    <form action="xls/store_report_unused_stock.php" name="excel" id="excel" method="post" target="_blank" style="margin-right:50px;"> 
                      <input type="hidden" name="department_name" id="department_name" value="<?=$department_id ?>" />
                      <input type="hidden" name="FromDate" id="FromDate" value="<?=$_POST['dateFrom'] ?>"/>
                      <input type="hidden" name="ToDate" id="ToDate" value="<?=$_POST['dateTo'] ?>"/>
                        <a href="#" onclick="excel.submit();"><img src="images/Excel-icon.png"  /></a>
                     </form>
                  </div>
                  <? } ?>
                    <table align="center" width="100%" border="1" cellpadding="" class="table1 text_1">
                      <tr>
                        <td class="gredBg">S.No.</td>
                        <td class="gredBg">Description</td>
                        <td class="gredBg">GRN Date</td>
                        <td class="gredBg">Purchase Qty.</td>
                      </tr>
                    <? if(mysql_num_rows($result)>0){
                        $sno = 1; $oldid=""; $flag=0; $flag1=0; $deptId=''; $totalValue=0; $count=0;
                        while($row=mysql_fetch_array($result)){	
													//$totalValue=0;
$sql_G="select
	ms_GRN_master.GRN_date as Date,
	ms_GRN_transaction.rec_qty as PurchaseQty
from
	ms_GRN_master,
	ms_GRN_transaction,
	ms_item_master
where
	ms_GRN_transaction.item_id NOT IN
		(select
			ms_IE_transaction.item_id
		from
			ms_IE_master,
			ms_IE_transaction,
			ms_item_master
		where
			ms_IE_master.IE_id = ms_IE_transaction.IE_id
			and ms_IE_transaction.item_id = ms_item_master.item_id)
	and ms_GRN_transaction.item_id = ms_item_master.item_id
	and ms_GRN_master.GRN_id = ms_GRN_transaction.GRN_id
	$SearchInGRNDate
	and ms_item_master.item_id = '".$row['ItemId']."'";			//(DATEDIFF(CAST(now() as DATE),(ms_GRN_master.GRN_date))>=45)
													$res_G=mysql_query($sql_G) or die("Error in : ".$sql_G."<br>".mysql_errno()." : ".mysql_error());
													if(mysql_num_rows($res_G)>0){
														$PurchaseQty = $row["opening_quantity"];
														while($row_G=mysql_fetch_array($res_G)){
															$PurchaseQty += $row_G['PurchaseQty'];
														}
														if($row['DeptId']!=$oldid){
$checkSql="select
	ms_GRN_master.GRN_date as Date,
	ms_GRN_transaction.rec_qty as PurchaseQty
from
	ms_GRN_master,
	ms_GRN_transaction,
	ms_item_master,
	ms_department
where
	ms_GRN_transaction.item_id NOT IN
		(select
			ms_IE_transaction.item_id
		from
			ms_IE_master,
			ms_IE_transaction,
			ms_item_master
		where
			ms_IE_master.IE_id = ms_IE_transaction.IE_id
			and ms_IE_transaction.item_id = ms_item_master.item_id)
	and ms_GRN_transaction.item_id = ms_item_master.item_id
	and ms_GRN_master.GRN_id = ms_GRN_transaction.GRN_id
	and ms_item_master.department_id = '".$row['DeptId']."'
	and ms_department.department_id = ms_item_master.department_id
	$SearchInGRNDate";
															
															//echo $checkSql."<br>";
$res_Check=mysql_query($checkSql) or die("Error in : ".$checkSql."<br>".mysql_errno()." : ".mysql_error());
$remain=mysql_num_rows($res_Check);
#	echo '<pre>'; print_r(mysql_fetch_array($res_Check)); echo '</pre>';
$oldid = $row['DeptId'];
$flag=1;$sno=1;$totalValue=0;
														}else{
															$flag=0;
														}
														if($flag==1){ ?>
														 <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
															<td colspan="4" align="left" style="color:#03F;font-size:14px;padding-left:15px">
																<b><?= $row['Department']?></b>
															</td>
														 </tr>
														 <? } ?>
														<tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
															<td align="center"><?=$sno?></td>
															<td align="left" style="padding-left:5px"><?= $row['Description']?></td>
                              <td align="center"><b><?=getDateFormate($remain['Date']);?></b></td>
															<td align="right" style="padding-right:5px" >
															<? echo number_format($PurchaseQty,2,'.','');
																$totalValue+=$PurchaseQty; ?>
															</td>
														</tr>
														<? $sno++;$count++;$remain--;
                            if($remain==0){ ?>
															 <tr bgcolor="#D0C9C1">
																<td colspan="3"><b>&nbsp;Total</b></td>
																<td align="right" style="padding-right:2px">
																	<?= number_format($totalValue,2,'.','')?>
																</td>
															 </tr>
														<? }//End Of If For Total 
													}//End of Inner Count
												}//End Of While
                      }else{// End Of Outer If  ?>
                        <tr>
                          <td colspan="4" align="center"><b>No Records Found</b></td>
                        </tr>
                      <? } ?> 
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
<? include("inc/hr_footer.php"); ?>