<?
include("inc/adm0_header.php");
$msg="";
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/adm0_snb.php"); ?>
        </td>
        
        <td style="padding-left:5px; padding-top:5px;" valign="top">
        	<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Stock Report</td>
                </tr>
                
                <tr>
               	  <td valign="top">
                        <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td style="padding-top:5px;" valign="top">
                                    <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                                        <tr colspan="2">
                                        	<td class="red"><?=$msg?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" align="center" valign="top">
                                                <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #C6B4AE;" bgcolor="#EAE3E1">
                                                    <tr>
                                                        <td valign="middle" style="padding-top:10px;">
                                                        	
                                                            <?
                                                            $prdid = "";
                                                            if(isset($_POST["button_check"]))
                                                            {
                                                                $Date = $_POST["Date"];
                                                                $prdid = $_POST["txt_product"];
                                                            }
                                                            else
                                                            {
                                                                $Date = date('d-m-Y');
                                                            }
                                                            ?>
                                                            <form name="frm_stock_check" id="frm_stock_check" action="" method="post">
                                                            
                                                            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="border">
                                                            	<tr>
                                                               	  <td width="12%" class="text_1">
                                                                  <B>Product</B>                                                                    </td>
                                                                    <td width="24%" align="left">
                                                                        <?    
                                                                        $sql_prd = "select * from ".$mysql_adm_table_prefix."product_master order by ProductName";
                                                                        $result_prd = mysql_query ($sql_prd) or die ("Error in : ".$sql_prd."<br>".mysql_errno()." : ".mysql_error());
                                                                        ?>    
                                                                        <select name="txt_product" id="txt_product" style="width:150px;">
                                                                                <option value="">--select--</option>
                                                                            <? 
                                                                            while ($row_prd = mysql_fetch_array($result_prd))
                                                                            {
                                                                            ?>
                                                                                <option value="<?=$row_prd['rec_id']?>"<? if($row_prd['rec_id']==$prdid){?> selected="selected"<? }?>>
                                                                                <?=$row_prd["ProductName"]?>
                                                                                </option>
                                                                            <?
                                                                            }
                                                                            ?>
                                                                      </select>
                                                                    </td>
                                                                	<td>
                                                                    	<input type="text" name="Date" id="Date" value="<?=$Date?>" style="width:150px; height:22px;"/>
                                                                    	<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_stock_check.Date);return false;" HIDEFOCUS><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a>
                                                                    	<input type="submit" id="button_check" name="button_check" value="Check">    
                                                                    </td>
                                                                    
                                                                    	
                                                                </tr>
															</table>
                                                            </form>
                                                            <?
                                                            if(isset($_POST["button_check"]))
															{
																$Date = getDateFormate($_POST["Date"],1);
																$prdid = $_POST["txt_product"];
                                                            ?>
                                                            
                                                            
                                                            <table align="center" width="100%" border="0" class="border">
                                                                <tr>
                                                                	<td colspan="10" class="gredBg">
                                                                    	REPORT SUMMARY AS ON <?=$Date?>                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                	<td width="22%" rowspan="3"  class="gredBg">
																		<?=getProduct("ProductName", "rec_id", $prdid)?>																	</td>
                                                                  <td width="8%" rowspan="3" class="gredBg">
																		Lot Number																  </td>
                                                                  <td colspan="2" class="gredBg">
                                                               	  Op. Stock                                                                    </td>
                                                                    <td colspan="2" class="gredBg">
                                                               	  Received                                                                    </td>
                                                                    <td colspan="2" class="gredBg">
                                                               	  Issued/Mixing                                                                    </td>
                                                                    <td colspan="2" class="gredBg">
                                                                    	Closing Stock                                                                    </td>
                                                              </tr>
                                                                <tr>
                                                                	<td width="9%" class="gredBg">
                                                                    	Kgs                                                                    </td>
                                                              <td width="9%" class="gredBg">
                                                                    	Packs                                                                    </td>
                                                              <td width="8%" class="gredBg">
                                                                    	Kgs                                                                    </td>
                                                              <td width="9%" class="gredBg">
                                                                    	Packs                                                                    </td>
                                                              <td width="9%" class="gredBg">
                                                                    	Kgs                                                                    </td>
                                                              <td width="9%" class="gredBg">
                                                                    	Packs                                                                    </td>
                                                              <td width="8%" class="gredBg">
                                                                    	Kgs                                                                    </td>
                                                              <td width="9%" class="gredBg">
                                                                    	Packs                                                                    </td>
                                                              </tr>
                                                                <tr>
                                                                	<td colspan="2" class="gredBg">
                                                                    	Op. Stock                                                                    </td>
                                                                    <td colspan="2" class="gredBg">
                                                                    	Received                                                                    </td>
                                                                    <td colspan="2" class="gredBg">
                                                                    	Issued/Mixing                                                                    </td>
                                                                    <td colspan="2" class="gredBg">
                                                                    	Closing Stock                                                                    </td>
                                                                </tr>
                                                            <?
                                                            //$Date="2010-05-03"; 
                                                            //$sql = "select * from ".$mysql_adm_table_prefix."stock_master where Date = '$Date'";
															
															
															/*SELECT * FROM 
															
															mo_adm_stock_master sm, 
															mo_adm_lot_master lm, 
															mo_adm_pi_detail pd, 
															mo_adm_dispatch_master dm, 
															mo_adm_dispatch_number dn
															
															WHERE lm.PiDetailId = pd.rec_id
															AND pd.CountId = sm.CountId
															AND sm.Date = '2010-05-03'
															AND dm.PiId = pd.PiId
															AND dm.DispatchNumberId = dn.rec_id
															And dm.CountId = sm.CountId*/
															
															$sql = "select * from 
																				".$mysql_adm_table_prefix."stock_master sm , mo_adm_count_master cm 
																					where 
																						sm.CountId = cm.rec_id and
																						cm.ProductId = '$prdid' and
																					sm.Date<='$Date' ";
															
                                                            $result = mysql_query($sql) or die("Error in sql : ".$sql."<br>".mysql_errno()." : ".mysql_error());
                                                            if(mysql_num_rows($result)>0)
                                                            {
																 
                                                            ?>
                                                                <!--<tr >
                                                                    <td class="gredBg" style="width:20%">
                                                                        <strong>Count Name</strong>
                                                                    </td>
                                                                    <td class="gredBg">
                                                                       <strong> Lot No</strong>
                                                                    </td>
                                                                    <td class="gredBg">
                                                                        <strong>Bag Sr. No</strong>
                                                                    </td>
                                                                    <td class="gredBg">
                                                                        <strong>No. of Bags</strong>
                                                                    </td>
                                                                    <td class="gredBg">
                                                                        <strong>Total Wt</strong>
                                                                    </td>
                                                                    <td class="gredBg">
                                                                        <strong>Desp. Bag No</strong>
                                                                    </td>
                                                                    <td class="gredBg">
                                                                        <strong>No. of Bags</strong>
                                                                    </td>
                                                                    <td class="gredBg">
                                                                        <strong>Dispatch Wt</strong>
                                                                    </td>
                                                                    <td class="gredBg">
                                                                        <strong>Closing Bal</strong>
                                                                    </td>
                                                                    
                                                                    <td class="gredBg">
                                                                        <strong>Closing Bags</strong>
                                                                    </td>
                                                                    
                                                                </tr>-->
                                                            <?
																$sno = 1;
                                                                while($row = mysql_fetch_array($result))
                                                                {
                                                                    $CountId = $row["CountId"];
                                                            ?>
                                                                <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                                                                    <td class="text_1">
                                                                        <?=getCount('Count','rec_id',$CountId)?>                                                                    </td>
                                                                    <td class="text_1">
                                                                        <?=$row["LotNumber"];?>                                                                    </td>
                                                                    
                                                                    
                                                                    <td class="text_1">
                                                                        <?=$row["StockInKgs"];?>                                                                    </td>
                                                                    <td class="text_1">
                                                                        <?=$row["NumberOfBags"];?>                                                                    </td>
                                                                    
                                                                    <td class="text_1">
                                                                    	<?
																		$TodayStockInKgs = "0";
                                                                    	$sql_today_stock_kgs = "SELECT sum(StockInKgs) as TodayStockInKgs FROM mo_adm_stock_master where CountId = '$CountId' and Date = '$Date'";
                                                                        $result_today_stock_kgs = mysql_query ($sql_today_stock_kgs) or die ("Error in : ".$sql_today_stock_kgs."<br>".mysql_errno()." : ".mysql_error());
                                                                        if(mysql_num_rows($result_today_stock_kgs)>0)
                                                                        {
                                                                            $row_today_stock_kgs=mysql_fetch_array($result_today_stock_kgs);
                                                                            $TodayStockInKgs = $row_today_stock_kgs["TodayStockInKgs"];
                                                                        }
																		?>
                                                                        <?=$TodayStockInKgs?>                                                                    </td>
                                                                    <td class="text_1">
                                                                        <?
																		$TodayNumberOfBags = "0";
                                                                    	$sql_today_stock_bags = "SELECT sum(NumberOfBags) as TodayNumberOfBags FROM mo_adm_stock_master where CountId = '$CountId' and Date = '$Date'";
                                                                        $result_today_stock_bags = mysql_query ($sql_today_stock_bags) or die ("Error in : ".$sql_today_stock_bags."<br>".mysql_errno()." : ".mysql_error());
                                                                        if(mysql_num_rows($result_today_stock_bags)>0)
                                                                        {
                                                                            $row_today_stock_bags=mysql_fetch_array($result_today_stock_bags);
                                                                            $TodayNumberOfBags = $row_today_stock_bags["TodayNumberOfBags"];
                                                                        }
																		?>
                                                                        <?=$TodayNumberOfBags?>                                                                    </td>
                                                                    
                                                                    
                                                                    <td class="text_1">
                                                                        <?
																		$TodayDispatchNumberOfKgs = "0";
                                                                    	$sql_today_lot_kgs = "SELECT sum(lm.TotalKgs) as TodayDispatchNumberOfKgs FROM mo_adm_lot_master lm, mo_adm_pi_detail pd where lm.PiDetailId = pd.rec_id and pd.CountId = '$CountId'";
                                                                        $result_today_lot_kgs = mysql_query ($sql_today_lot_kgs) or die ("Error in : ".$sql_today_lot_kgs."<br>".mysql_errno()." : ".mysql_error());
                                                                        if(mysql_num_rows($result_today_lot_kgs)>0)
                                                                        {
                                                                            $row_today_lot_kgs=mysql_fetch_array($result_today_lot_kgs);
                                                                            $TodayDispatchNumberOfKgs = $row_today_lot_kgs["TodayDispatchNumberOfKgs"];
                                                                        }
																		if($TodayDispatchNumberOfKgs == "")
																		{
																			$TodayDispatchNumberOfKgs = 0;
																		}
																		?>
                                                                        <?=$TodayDispatchNumberOfKgs?>&nbsp;                                                                    </td>
                                                                    <td class="text_1">
                                                                        <?
																		$TodayDispatchNumberOfBags = "0";
                                                                    	$sql_today_lot_bags = "SELECT sum(NoOfPck) as TodayDispatchNumberOfBags FROM mo_adm_lot_master lm, mo_adm_pi_detail pd where lm.PiDetailId = pd.rec_id and pd.CountId = '$CountId'";
                                                                        $result_today_lot_bags = mysql_query ($sql_today_lot_bags) or die ("Error in : ".$sql_today_lot_bags."<br>".mysql_errno()." : ".mysql_error());
                                                                        if(mysql_num_rows($result_today_lot_bags)>0)
                                                                        {
                                                                            $row_today_lot_bags=mysql_fetch_array($result_today_lot_bags);
                                                                            $TodayDispatchNumberOfBags = $row_today_lot_bags["TodayDispatchNumberOfBags"];
                                                                        }
																		if($TodayDispatchNumberOfBags == "")
																		{
																			$TodayDispatchNumberOfBags = 0;
																		}
																		?>
                                                                        <?=$TodayDispatchNumberOfBags?>                                                                    </td>
                                                                    
                                                                    <td class="text_1">
                                                                        <?=$row["StockInKgs"] + $TodayStockInKgs - $TodayDispatchNumberOfKgs;?>                                                                    </td>
                                                                    <td class="text_1">
                                                                        <?=$row["NumberOfBags"] + $TodayNumberOfBags - $TodayDispatchNumberOfBags;?>                                                                    </td>
                                                                </tr>			
                                                            <?
                                                                	$sno++;   
                                                                }
																?>
                                                                <tr>
                                                                	<td colspan="11">
                                                                    	<div class="AddMore">
                                                                            <a href="daily_summary_stock_report_xls.php?Date=<?=$Date?>&prdid=<?=$prdid?>">Export To XLS</a>                                                                        </div>                                                                    </td>
                                                                </tr>
                                                                <?
                                                            }
                                                            ?>
                                                            </table>
                                                            
                                                        <?
                                                        }
                                                        ?>
                                                        	
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
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
<? 
include("inc/footer.php");
?>                                                          