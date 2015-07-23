<? include('inc/adm0_header.php');?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/adm0_snb.php"); ?>
        </td>
        <td style="padding-left:5px; padding-top:5px;">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; List Of Remainig Despatch of PI</td>
                </tr>
                <tr>
                	<td class="heading" height="400px" valign="middle">
                    	<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                                        <tr>
                                            <td height="500px" align="center" valign="top" class="">
                                                <?
											 $sql = "select dm.PiId,dm.DispatchNumberId,dm.ProductId,dm.CountId,dm.NowOfferedQty,pd.PiId ,pd.ProductId,pd.CountId,pd.Quantity from mo_adm_pi_detail as pd , mo_adm_dispatch_master as dm where dm.ProductId = pd.ProductId and dm.CountId = pd.CountId and dm.PiId = pd.PiId group by dm.CountId";
												$result = mysql_query($sql) or die("Error in Query: ".$sql."<br/>".mysql_error()."<br/>".mysql_errno());
												if(mysql_num_rows($result)>0)
												{
													$sno = 1;
												?>
												<table width="100%" class="table1 text_1" border="1">
													<tr>
                                                    	<td width="17%" class="gredBg">PI Num</td>
                                                      <td width="22%" class="gredBg">Product</td>
                                                      <td width="22%" class="gredBg">Count</td>
                                                      <td width="21%" class="gredBg">Ordered Quantity</td>
                                                      <td width="18%" class="gredBg">Remaining Quantity</td>
                                                  </tr>
												<?
													$total_qty = 0;
													while($row = mysql_fetch_array($result))
													{
														$sql_1 = "select sum(NowOfferedQty) as total_qty from mo_adm_dispatch_master where PiId = '".$row["PiId"]."' and ProductId = '".$row["ProductId"]."' and CountId = '".$row["CountId"]."'";
														$result_1 = mysql_query($sql_1) or die("Error in Query: ".$sql_1."<br/>".mysql_error()."<br/>".mysql_errno());
														if(mysql_num_rows($result_1)>0)
														{
															$row_1 = mysql_fetch_array($result_1);
															{
																$total_qty = $row_1["total_qty"];
																if($total_qty!=$row["Quantity"])
																{
																?>
                                                                <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                                                                    <td align="center"><?=getPINumber('PiNumber','rec_id',$row["PiId"])?></td>
                                                                    <td align="center"><?=getProduct('ProductName','rec_id',$row["ProductId"])?></td>
                                                                    <td align="center"><?=getCount('Count','rec_id',$row["CountId"])?></td>
                                                                    <td align="center"><?=$row["Quantity"]?></td>
                                                                    <td align="center"><?=$row["Quantity"]-$total_qty?></td>
                                                               </tr>
																<?
																}
															}
														}
														$sno++;
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
<? include("inc/footer.php");?>                                                 