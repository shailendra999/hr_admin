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
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Daily Stock Report</td>
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
                                                <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                    <tr>
                                                        <td valign="middle">
                                                        	<?
                                                            if(isset($_POST["button_check_x"]))
															{
																$Date = $_POST["Date"];
															}
															else
															{
																$Date = date('d-m-Y');
															}
                                                            ?>
                                                            <form name="frm_stock_check" id="frm_stock_check" action="" method="post">
                                                            <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="border:1px solid #C6B4AE;" bgcolor="#EAE3E1" height="40">
                                                            	<tr>
                                                                	<td align="center">
                                                                    	<input type="text" name="Date" id="Date" value="<?=$Date?>" style="width:150px; height:22px;"/>
                                                                    	<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_stock_check.Date);return false;" HIDEFOCUS>
                                                                        	<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                                                                        </a>
                                                                    </td>
                                                                    <td>   
                                                                        <input type="image" src="images/btn_submit.png" name="button_check" id="button_check" value="submit" />
                                                                    </td>
                                                                    	
                                                                </tr>
															</table>
                                                            </form>
                                                            <?
                                                            if(isset($_POST["button_check_x"]))
															{
																$Date = getDateFormate($_POST["Date"],1);
                                                            ?>
                                                            <table align="center" width="100%" border="0" class="border">
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
																	".$mysql_adm_table_prefix."stock_master sm, 
																	".$mysql_adm_table_prefix."lot_master lm, 
																	".$mysql_adm_table_prefix."pi_detail pd
																		where 
																	lm.PiDetailId = pd.rec_id and 
																	pd.CountId = sm.CountId and 
																	sm.rec_id = lm.StockId and

																	sm.Date='$Date'";
															
                                                            $result = mysql_query($sql) or die("Error in sql : ".$sql."<br>".mysql_errno()." : ".mysql_error());
                                                            if(mysql_num_rows($result)>0)
                                                            {
																 
                                                            ?>
                                                                <tr class="gredBg">
                                                                    <td align="center" style="width:20%"><strong>Count Name</strong></td>
                                                                    <td align="center"><strong> Lot No</strong></td>
                                                                    <td align="center"><strong>Bag Sr. No.</strong></td>
                                                                    <td align="center"><strong>No. of Bags</strong></td>
                                                                    <td align="center">
                                                                        <strong>Total Wt</strong>
                                                                    </td>
                                                                    <td align="center"><strong>Desp. Bag No</strong></td>
                                                                    <td align="center"><strong>No. of Bags</strong></td>
                                                                    <td align="center"><strong>Dispatch Wt</strong></td>
                                                                    <td align="center"><strong>Closing Bal</strong></td>
                                                                    
                                                                    <td align="center"><strong>Closing Bags</strong></td>
                                                                    
                                                                </tr>
                                                            <?
																$sno = 1;
                                                                while($row = mysql_fetch_array($result))
                                                                {
                                                                    $CountId = $row["CountId"];
                                                            ?>
                                                                <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?> class="text_1">
                                                                    <td align="center"><?=getCount('Count','rec_id',$CountId)?></td>
                                                                    <td align="center"><?=$row["LotNumber"];?></td>
                                                                    <td align="center">1 to <?=$row["NumberOfBags"];?></td>
                                                                    <td align="center"><?=$row["NumberOfBags"];?></td>
                                                                    <td align="center"><?=$row["StockInKgs"];?></td>
                                                                    <td align="center">1 to <?=$row["NoOfPck"];?></td>
                                                                    <td align="center"><?=$row["NoOfPck"];?></td>
                                                                    <td align="center"><?=$row["TotalKgs"];?></td>
                                                                    <td align="center"><?=$row["StockInKgs"] - $row["TotalKgs"];?></td>
                                                                    <td align="center"><?=$row["NumberOfBags"] - $row["NoOfPck"];?></td>
                                                                </tr>
                                                            <?
                                                                	$sno++;   
                                                                }
																?>
                                                                <tr>
                                                                	<td colspan="11" style="border-top:1px solid #EAE3E1;">
                                                                    	<div class="AddMore">
                                                                            <a href="daily_stock_report_xls.php?Date=<?=$Date?>">Export To XLS</a>  
                                                                        </div>
                                                                    </td>
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