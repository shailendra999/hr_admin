<?
include("inc/elec_header.php");
?>
<script>
function overlay(id) {
    el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";	
}
function getDataInDiv(divId,page,byControl)
{
	if(byControl=="DateFromTo")
	{
		var from=document.getElementById('RDFrom').value;
		var to=document.getElementById('RDTo').value;
		if(from==''  || to=='')
			alert('Select Date');
		else
		{
			var value=from+','+to;
			strURL1=page+"?value="+value+"&byControl="+byControl;
			strURL1=page+"?value="+value+"&byControl="+byControl;
			//alert(strURL1);
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
}
</script>

<?
$Page = "elec_list_daily_report_engg.php";
$PageTitle = "List Daily Report";
$PageFor = "Daily Report";
$PageKey = "DailyReportId";
$PageKeyValue = "";
$Message = "";

?>
<?
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}
if(isset($_POST["btn_del"]))
{
	$PageKeyValue  = $_POST["hidden_overlay"];
	$sql = "delete from elec_daily_report_engg where $PageKey = '".$PageKeyValue."'";
	if(mysql_query ($sql))
	{
		$Message = "Record Sucessfully Deleted";
	}
	//$Message = "Order Sucessfully Deleted";
	redirect("$Page?Message=$Message");
}

?>
<?
$sql="select * from elec_daily_report_engg order by DailyReportDate asc";
$result=mysql_query($sql);

?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
    <? include ("inc/elec_snb.php"); ?>
    </td>
    <td style="padding-left:5px; padding-top:5px;" valign="top">
      <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td align="center" class="gray_bg">
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; List Daily Report
          </td>
        </tr>
        <tr>
          <td valign="top">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td align="center" class="border" >
                	<div id="div_message" style="color:#399;font-size:16px;font-weight:bold;"><?=$Message?></div>
                  <table id="" align="center" width="100%" border="1" class="table1 text_1">
                    <tr>
                      <td align="center" colspan="4"><b>Search Items</b></td>
                    </tr>
                    <tr>
                    	<td align="left"><b>Date From</b></td>
                      <td align="left">
                      <input type="text" name="RDFrom" id="RDFrom" />
                      	<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.getElementById('RDFrom'));return false;" HIDEFOCUS>
                        	<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                        </a> 
                       </td>
                       <td align="left"><b>Date To</b></td>
                      <td align="left">
                      <input type="text" name="RDTo" id="RDTo" />
                      	<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.getElementById('RDTo'));return false;" HIDEFOCUS>
                        	<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                        </a> 
                        <input type="button" id="btnOk" name="btnOk" value="Ok" onclick="getDataInDiv('getDataInDiv','elec_get_list_daily_report_engg.php','DateFromTo')"/>
                       </td>
                    </tr>
                  </table>
                  <div id="getDataInDiv" style="margin:0 auto;width:100%;overflow:auto;height:600px">
                    <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="tableborder">
                      <tr>
                        <td valign="top">	
                            <table align="center" id="tableEntry" width="100%" border="1" class="table1 text_1">
                              <tr>
                                <td class="gredBg">S.No.</td>
                                <td class="gredBg">DailyReportId</td>
                                <td class="gredBg">DailyReportDate</td>
                                <td class="gredBg">UnitConsumption</td>
                                <td class="gredBg">MaxDemand</td>
                                <td class="gredBg">LoadFactor</td>
                                <td class="gredBg">PowerFactor</td>
                                <td class="gredBg">LightingUnit</td>
                                <td class="gredBg">ColonyUnit</td>
                                <td class="gredBg">T. F. O.</td>
                                <td class="gredBg">CompressorUnit</td>
                                <td width="4%" class="gredBg">Edit</td>
                                <td width="4%" class="gredBg">Delete</td>
                              </tr>
                              <?  
															if(mysql_num_rows($result)>0)
															{
															  $sno =1;
																while($row=mysql_fetch_array($result))
																{	
																	$sql_idate="select * from elec_daily_report_engg where InsertDate='".date('Y-m-d')."' and DailyReportId='".$row['DailyReportId']."'";
																	$res_idate=mysql_query($sql_idate);
																	$row_idate=mysql_fetch_array($res_idate);
																	$insert_date=$row_idate['InsertDate'];
																?>
																<tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
																	<td align="center"><?=$sno?></td>
																	<td align="center"><?= $row['DailyReportId']?></td>
																	<td align="center"><?= getDateFormate($row['DailyReportDate'])?></td>
																	<td align="center"><?= $row['UnitConsumption']?></td>
																	<td align="center"><?= $row['MaxDemand']?></td>
																	<td align="center"><?= $row['LoadFactor']?></td>
																	<td align="center"><?= $row['PowerFactor']?></td>
																	<td align="center"><?= $row['LightingUnit']?></td>
																	<td align="center"><?= $row['ColonyUnit']?></td>
																	<td align="center"><?= $row['TFO']?></td>
																	<td align="center"><?= $row['CompressorUnit']?></td>
																	
																	<?
																	if(1)
																	{
																		//$SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date)
																	?>
																		<td align="center">
																			<a href="elec_add_daily_report_engg.php?DailyReportId=<?=$row["DailyReportId"]?>&mode=edit">
																				<img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
																			</a>
																		</td>
																		<td align="center">
																			<a href="javascript:;" onClick="overlay(<?=$row["DailyReportId"]?>);">
																				<img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0">
																			</a>
																		</td>
																	<?
																	}
																	else
																	{
																	?>
																		<td align="center"></td>
																		<td align="center"></td>
																	<?
																	}
																	?>
																</tr>
																<?
																	 $sno++;
																	}	
                          		}
															else
															{
															?>
                              	<tr>
                                	<td colspan="12" align="center"><b>No Records Found</b></td>
                                </tr>
                              <?
															}
                          		?>  
                           </table>      
                      	</td>
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
      <p>Are you sure to delete this Item</p>
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