<?
include("inc/elec_header.php");
?>
<script type="text/javascript">
function overlay(id) {
    el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";	
}
function getDataInDiv(value,divId,page,byControl)
{
		var strURL1;
		if(value=="" && byControl=="DateFromTo")
		{
			var from=document.getElementById('RDFrom').value;
			var to=document.getElementById('RDTo').value;
			var value=from+','+to;
			strURL1=page+"?value="+value+"&byControl="+byControl;

		}
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
</script>

<?
$Page = "elec_list_HT.php";
$PageTitle = "List High Tension";
$PageFor = "High Tension";
$PageKey = "HT_id";
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
	$sql = "delete from elec_HT where $PageKey = '".$PageKeyValue."'";
	
	if(mysql_query ($sql))
	{
		$Message = "Record Sucessfully Deleted";
	}
	//$Message = "Order Sucessfully Deleted";
	redirect("$Page?Message=$Message");
}

?>
<?
$sql="select * from elec_HT order by reading_date asc";
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
          <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; List High Tension</td>
        </tr>
        <tr>
          <td valign="top">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td align="center" class="border" >
                	<div id="div_message" style="color:#399;font-size:16px;font-weight:bold;"><?=$Message?></div>
                  <table align="center" width="100%" border="1" class="table1 text_1">
                    <tr>
                      <td align="center" colspan="4"><b>Search Items</b></td>
                    </tr>
                    <tr>
                      <td><b>Reading Date(Format dd-mm-yyyy)</b></td>
                      <td colspan="3">
                      <input type="text" name="readingDate" id="readingDate" />
                      	<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.getElementById('readingDate'));return false;" HIDEFOCUS>
                        	<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                        </a> 
                        <input type="button" id="btnOk" name="btnOk" value="Ok" onclick="getDataInDiv(document.getElementById('readingDate').value,'getDataInDiv','elec_get_list_HT.php','ReadingDate')"/>
                       </td>
                    </tr>
                    <tr>
                    	<td><b>Date From</b></td>
                      <td>
                      <input type="text" name="RDFrom" id="RDFrom" />
                      	<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.getElementById('RDFrom'));return false;" HIDEFOCUS>
                        	<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                        </a> 
                       </td>
                       <td><b>Date To</b></td>
                      <td>
                      <input type="text" name="RDTo" id="RDTo" />
                      	<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.getElementById('RDTo'));return false;" HIDEFOCUS>
                        	<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                        </a> 
                        <input type="button" id="btnOk" name="btnOk" value="Ok" onclick="getDataInDiv('','getDataInDiv','elec_get_list_HT.php','DateFromTo')"/>
                       </td>
                    </tr>
                    <tr bgcolor="#dddddd">
                    	<td align="left"><b>Multiflying Factor</b></td>
                      <td>
												<?
													$factor=0;
													$sqlmf = "select * from elec_HT_MF";
													$resmf = mysql_query($sqlmf);
													$rowmf = mysql_fetch_array($resmf);
													echo $factor=(double)$rowmf['factor'];
												?>
                      </td>
                      <td align="left"><b>Maximum Demand</b></td>
                      <td>
                      	<?
													$demand=0;
													$sqlmd = "select * from elec_HT_max_demand";
													$resmd = mysql_query($sqlmd);
													$rowmd = mysql_fetch_array($resmd);
													$demand=(double)$rowmd['demand'];
													echo $demand;
												?>
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
                              <td class="gredBg">Reading Date</td>
                              <td class="gredBg">MWH Reading</td>
                              <td class="gredBg">MWH Unit</td>
                              <td class="gredBg">Comm. MWH Unit</td>
                              <td class="gredBg">MVAH Reading</td>
                              <td class="gredBg">MVAH Unit</td>
                              <td class="gredBg">KVA Reading</td>
                              <td class="gredBg">Comm. MVAH Unit</td>
                              <!--<td class="gredBg">Power Factor</td>-->
                              <td class="gredBg">Avg. P.F.</td>
                              <td width="4%" class="gredBg">Edit</td>
                              <td width="4%" class="gredBg">Delete</td>
                            </tr>
                            <?  
                            if(mysql_num_rows($result)>0)
                            {
                              $sno =1;
                              $mwh_unit=0;$mvah_unit=0;$mwh_unit_total=0;$mvah_unit_total=0;
															$total_avg_pf=0;$total_pf=0;$total_lf=0;$total_avg_pf;$days=1;
                              while($row=mysql_fetch_array($result))
                              {
                                $sql_idate="select * from elec_HT where insert_date='".date('Y-m-d')."' and HT_id='".$row['HT_id']."'";
                                $res_idate=mysql_query($sql_idate);
                                $row_idate=mysql_fetch_array($res_idate);
                                $insert_date=$row_idate['insert_date'];
                                
                                $da=explode('-',$row['reading_date']);//$da=explode('-','2011-03-01');
                                $early_date= date("Y-m-d", mktime(0, 0, 0,$da[1] ,$da[2]+1 , $da[0]));
                                $sql_u="select * from elec_HT where reading_date ='".$early_date."'";
                                $res_u=mysql_query($sql_u);		
                                $early_mwh_reading=0;$early_mvah_reading=0;
                                if(mysql_num_rows($res_u)>0)
                                {
                                  $row_u=mysql_fetch_array($res_u);
                                  $early_mwh_reading=(double)$row_u['mwh_reading'];
                                  $early_mvah_reading=(double)$row_u['mvah_reading'];
                                }
                              ?>
                              <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                                <td align="center"><?=$sno?></td>
                                <td align="right" style="padding-right:5px">
                                	<b><?= getDateFormate($row['reading_date'])?></b>
                                </td>
                                <td align="right" style="padding-right:5px">
																	<?= $row['mwh_reading']?>
                                </td>
                                <td align="right" style="padding-right:5px">
                                  <? 
                                    $mwh_unit=0;
                                    if(mysql_num_rows($res_u)>0)
                                    {
                                      $diff_mwh=$early_mwh_reading-(double)$row['mwh_reading'];
                                      $mwh_unit=$factor*$diff_mwh;
                                      
																			//$power_factor;;
                                    }
																		echo $mwh_unit=number_format($mwh_unit, 0, '.', '');	
                                  ?>
                                </td>
                                <td align="right" style="padding-right:5px">
																	<?= $mwh_unit_total+=$mwh_unit?>
                                </td> 
                                <td align="right" style="padding-right:5px">
																	<?= $row['mvah_reading']?>
                                </td>
                                <td align="right" style="padding-right:5px">
                                  <?
                                    $mvah_unit=0;
                                    if(mysql_num_rows($res_u)>0)
                                    {
                                      $diff_mvah=$early_mvah_reading-(double)$row['mvah_reading'];
                                      $mvah_unit=$factor*$diff_mvah;
                                      
																			//$power_factor;;
                                    }
																		echo $mvah_unit=number_format($mvah_unit, 0, '.', '');
                                  ?>
                                </td>
                                <td align="right" style="padding-right:5px"><?= $row['kva_reading']?></td>
                                <td align="right" style="padding-right:5px">
																	<?= $mvah_unit_total+=$mvah_unit?>
                                </td>
                                <!--<td align="right" style="padding-right:5px">
                                <?
                                  $power_factor=0;
																	if($mvah_unit=='' || $mvah_unit=='0')
																		$power_factor=0;
																	else
                                  	$power_factor=$mwh_unit/$mvah_unit;
                                  echo $power_factor=number_format($power_factor, 3, '.', '');
																	//$power_factor;
                                  $total_pf+=$power_factor;
                                ?>
                                </td>-->
                                <td align="right" style="padding-right:5px">
                                  <?
                                    $avg_pf=0;
																		if($mvah_unit_total=='' || $mvah_unit_total=='0')
																			$avg_pf=0;
																		else
                                  		$avg_pf=$mwh_unit_total/$mvah_unit_total;
                                    echo $avg_pf=number_format($avg_pf, 3, '.', '');
                                    $total_avg_pf+=$avg_pf;
                                  ?>
                                </td>
                                <?
								if(1)
								{
									//$SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date)
                                ?>
                                 <td align="center">
                                  <a href="elec_add_HT.php?HT_id=<?=$row["HT_id"]?>&mode=edit">
                                  <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0"/>
                                  </a>
                                </td>
                                <td align="center">
                                  <a href="javascript:;" onClick="overlay(<?=$row["HT_id"]?>);">
                                  <img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0">
                                  </a>
                                </td>
                                  <?
                              	}
                                else
                                {
                                ?>
                                  <td align="center" ></td>
                                  <td align="center" ></td>
                                <?
                                }
                                ?>
                              </tr>
                              <?
                                  if($avg_pf=='' || $avg_pf==0)
																		$load_factor=0;
																	else
                                  	$load_factor=($mwh_unit_total*100)/($row['kva_reading']*$avg_pf*24*(int)$days);
                                  $load_factor=number_format($load_factor, 3, '.', '');
                                  $total_lf+=$load_factor;
																	//echo $mwh_unit_total.','.$demand.','.$avg_pf.','.$days.', lf='.$load_factor.'<br />';
                                  $sno++;$days++;
                               }	
                            ?> 
                            <tr>
                              <td colspan="2" align="right"><b>Total</b>&nbsp;&nbsp;&nbsp;</td>
                              <td align="right" style="padding-right:5px" colspan="6">
                              <b>Load Factor</b>&nbsp;&nbsp;&nbsp;
                              <? $lf=$total_lf/($days-1);echo number_format($load_factor,2,'.','');?>
                              </td>
                              <td align="right" style="padding-right:5px"><?= $total_pf?></td>
                              <td align="right" style="padding-right:5px"><?= $total_avg_pf?></td>
                              <td colspan="2"></td>
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