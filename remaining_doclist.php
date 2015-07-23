<? include('inc/adm0_header.php');?>
<script type="text/javascript" src="highslide/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
<script type="text/javascript">
hs.graphicsDir = 'highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>
<style type="text/css">
	.highslide-html-content {
	display: none;
	width: 600px;
	padding: 0 5px 5px 5px;
}
</style>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/adm0_snb.php"); ?>
        </td>
        <td style="padding-left:5px; padding-top:5px;">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; List Of Remainig Documents of Despatch</td>
                </tr>
                <tr>
                	<td class="heading" height="400px" valign="middle">
                    	<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td valign="top">
                                    <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                                        <tr>
                                            <td height="500px" align="center" valign="top" class="">
                                                <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                    <tr>
                                                    	<td style="padding-top:5px;" valign="top">
                                                        	<div style="overflow:auto;height:500px; vertical-align:top;">
                                                        	<table align="center" width="100%" border="0" class="border" cellpadding="1" cellspacing="1">
                                                            	<tr>
                                                                	<td align="center" class="gredBg"><b>PI Number</b></td>
                                                                    <td align="center" class="gredBg"><b>Invoice Number</b></td>
                                                                    <td align="center" class="gredBg"><b>Buyer</b></td>

                                                                </tr>
																<?
                                                                $sql_dn = "select * from mo_adm_dispatch_number";
                                                                $result_dn = mysql_query($sql_dn)or die("Error in Query: ".$sql_dn."<br/>".mysql_error()."<br/>".mysql_errno());
                                                                if(mysql_num_rows($result_dn)>0)
                                                                {
																	$sno = 1;
																	while($row_dn = mysql_fetch_array($result_dn))
																	{
                                                                        $sql_1 = "select dm.rec_id , dm.PiId , dm.DispatchNumberId from mo_adm_dispatch_master as dm where dm.DispatchNumberId = '".$row_dn["rec_id"]."'";
                                                                        $result_1 = mysql_query($sql_1)or die("Error in Query: ".$sql_1."<br/>".mysql_error()."<br/>".mysql_errno());
                                                                        if(mysql_num_rows($result_1)>0)
                                                                        {
                                                                            $row_1 = mysql_fetch_array($result_1);
                                                                            
																?>
                                                                <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?> class="AddMore">
                                                                    <td align="center"><a href="javascript:;" onClick="return hs.htmlExpand(this,{headingText: 'PI Detail'})"><?=getPINumber('PiNumber','rec_id',$row_1['PiId'])?></a>
                                                                        <div class="highslide-maincontent">
                                                                            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                                <tr>
                                                                                    <td align="center">
                                                                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                                            <tr>
                                                                                                <td class="tableText">
                                                                                                    <b><?=getPINumber('PiNumber','rec_id',$row_1['PiId'])?></b>
                                                                                                </td>
                                                                                                <td class="tableText">
                                                                                                    <b><?=getDateFormate(getPINumber('PiDate','rec_id',$row_1['PiId']),1)?></b>
                                                                                                </td>
                                                                                                <td class="tableText">
                                                                                                    <b><?=getBuyer('BuyerName','rec_id',getPINumber('BuyerId','rec_id',$row_1['PiId']))?></b>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                        <table align="center" width="100%" cellpadding="0" cellspacing="0" class="table1" border="1">
                                                                                            <tr class="gredBg">
                                                                                                <td width="16%" align="center"><b>Product</b></td>
                                                                                                <td width="15%" align="center"><b>Count</b></td>
                                                                                                <td width="12%" align="center"><b>Quantity</b></td>
                                                                                                <td width="11%" align="center"><b>Price</b></td>
                                                                                                <td width="12%" align="center"><b>Total</b></td>
                                                                                            </tr>
																							<?
                                                                                            $sql_detail = "select * from ".$mysql_adm_table_prefix."pi_detail where PiId = '".$row_1['PiId']."'";
                                                                                            $result_detail = mysql_query($sql_detail) or die("Error in sql : ".$sql_detail." : ".mysql_errno()." : ".mysql_error());
                                                                                            $total = 0;
                                                                                            $snob = 1;
                                                                                            while ($row_detail=mysql_fetch_array($result_detail))
                                                                                            {    
                                                                                            ?>
                                                                                            <tr <? if ($snob%2==1) { ?> bgcolor="#F5F2F1" <? } ?> class="text_1">
                                                                                                <td align="center"><?=getProduct('ProductName','rec_id',$row_detail["ProductId"])?></td>
                                                                                                <td align="center"><?=getCount('Count','rec_id',$row_detail["CountId"])?></td>
                                                                                                <td align="center"><?=$row_detail["Quantity"]?></td>
                                                                                                <td style="text-align:right; padding-right:10px;"><?=$row_detail["Price"]?></td>
                                                                                                <td style="text-align:right; padding-right:10px;"><?=number_format($row_detail["Quantity"] * $row_detail["Price"],2)?></td>
                                                                                            </tr>
																							<?
                                                                                                $snob++;
                                                                                                $total = $total + $row_detail["Quantity"] * $row_detail["Price"];
                                                                                            }
                                                                                            ?>
                                                                                            <tr class="text_1">
                                                                                                <td align="right" colspan="4" style="padding-right:10px;"><strong>Total</strong> </td>
                                                                                                <td class="Text01" style="text-align:right; padding-right:10px;">
                                                                                                	<strong><?=number_format($total,2)?></strong>
																								</td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </td>
                                                                    <td align="center"><a href="javascript:;" onClick="return hs.htmlExpand(this,{headingText: 'Dispatch Detail'})"><?=$row_dn['DispatchNumber']?></a>
                                                                        <div class="highslide-maincontent">
                                                                            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                                <tr>
                                                                                    <td>
                                                                                        <table align="center" width="100%" cellpadding="1" cellspacing="1" class="border">
                                                                                            <tr>
                                                                                                <td class="gredBg">Product</td>
                                                                                                <td class="gredBg">Count</td>
                                                                                                <td class="gredBg">Ordered Quantity</td>
                                                                                                <td class="gredBg">Now Sent Quantity</td>
                                                                                                <td class="gredBg">Quantity Left</td>
                                                                                                <td class="gredBg">Price</td>
                                                                                            </tr>   
                                                                                            <?
                                                                                            $sql_detail = "select * from ".$mysql_adm_table_prefix."dispatch_master where DispatchNumberId = '".$row_dn['rec_id']."'";
                                                                                            $result_detail = mysql_query($sql_detail) or die("Error in Query :".$sql_detail."<br>".mysql_error().":".mysql_errno());
                                                                                            $s = 1;
                                                                                            while($row_detail = mysql_fetch_array($result_detail))
                                                                                            {	
                                                                                            ?> 		
                                                                                            <tr <? if ($s%2==1) { ?> bgcolor="#F5F2F1" <? } ?> class="text_1">
                                                                                                <td align="center"><?=getProduct('ProductName','rec_id',$row_detail['ProductId'])?></td>
                                                                                                <td align="center"><?=getCount('Count','rec_id',$row_detail['CountId'])?></td>
                                                                                                <td align="center"><?=$row_detail['Quantity']?></td>
                                                                                                <td align="center"><?=$row_detail['NowOfferedQty']?></td>
                                                                                                <td align="center">
                                                                                                <?
                                                                                                    $a = $row_detail['NowOfferedQty']+$row_detail['PrevioslyAcceptedQty'];
                                                                                                    $b = $row_detail['Quantity'] - $a;
                                                                                                    echo $b;
                                                                                                ?>	
                                                                                                </td>
                                                                                                <td align="center"><?=$row_detail['Price']?></td>
                                                                                            </tr>
                                                                                            <?
                                                                                                $s++;
                                                                                            }
                                                                                            ?>		                                         	         
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </td>
                                                                    <td align="center"><span class="text_1"><?=getBuyer('BuyerName','rec_id',getDispatchNumber('BuyerId','rec_id',$row_1['DispatchNumberId']))?></span></td>
                                                                </tr>
																<?
                                                                		}
                                                                ?>
                                                                <tr>
                                                                    <td align="center" colspan="4">
                                                                        <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
                                                                            <tr>
                                                                            <?
                                                                            $sql = "select ddl.rec_id , ddl.DispatchMasterId , ddl.DocId , ddl.DocStatus , ddl.DocDate , dm.rec_id , dm.PiId , dm.DispatchNumberId from mo_adm_despatch_doclist as ddl , mo_adm_dispatch_master as dm where ddl.DocStatus = '0' and ddl.DispatchMasterId = dm.rec_id and dm.DispatchNumberId = '".$row_dn["rec_id"]."'";
                                                                            $result = mysql_query($sql)or die("Error in Query: ".$sql."<br/>".mysql_error()."<br/>".mysql_errno());
                                                                            if(mysql_num_rows($result)>0)
                                                                            {
                                                                                while($row = mysql_fetch_array($result))
                                                                                //$row = mysql_fetch_array($result);
                                                                                {
                                                                            ?>
                                                                                <td class="tableText"><?=getDocumentDetail('DocumentName','rec_id',$row['DocId'])?></td>
                                                                            <?                                            		
                                                                                }	
                                                                            }
                                                                            ?>
                                                                            </tr>
                                                                        </table>
                                                                        
                                                                    </td>
                                                                </tr>            
                                                                <tr>
                                                                    <td align="center" colspan="4">
                                                                        <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
                                                                            <tr>
																			<?
                                                                            $sql_1 = "select bm.rec_id , bm.BuyerName , docm.rec_id , docm.DocumentName , docm.DocumentFor , dn.rec_id , dn.DispatchNumber from mo_adm_buyer_master as bm , mo_adm_dispatch_number as dn , mo_adm_document_master as docm where bm.BuyerType = docm.DocumentFor and dn.BuyerId = bm.rec_id and dn.rec_id = '".$row_dn["rec_id"]."' order by dn.rec_id ";
                                                                            $result_1 = mysql_query($sql_1)or die("Error in Query: ".$sql_1."<br/>".mysql_error()."<br/>".mysql_errno());
                                                                            if(mysql_num_rows($result_1)>0)
                                                                            {
                                                                                while($row_1 = mysql_fetch_array($result_1))
                                                                                //$row_1 = mysql_fetch_array($result_1);
                                                                                {
                                                                                    $DocStatus = 0;
                                                                                    $DispatchMasterId = getDispatchDetail('rec_id','DispatchNumberId',$row_1["rec_id"]);
                                                                                    
                                                                                    $sql_2 = "select * from mo_adm_despatch_doclist  where DispatchMasterId = '$DispatchMasterId'";
                                                                                    
                                                                                    $result_2 = mysql_query($sql_2)or die("Error in Query: ".$sql_2."<br/>".mysql_error()."<br/>".mysql_errno());
                                                                                    
                                                                                    if(mysql_num_rows($result_2) == 0)
                                                                                    {
                                                                                    ?>
                                                                                <td class="tableText"><?=$row_1['DocumentName']?></td>
																					<?
                                                                                    }
                                                                                }
                                                                            }
                                                                            ?>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>     
																<?
																	}
                                                            	}
                                                            	?>             
                                                           </table>
                                                           <div class="AddMore">
    	                                                        <a href="remaining_doclist_xls.php">Export To XLS</a>  
                                                            </div>
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
                    </td>
               </tr>
           </table>
       </td>
   </tr>
</table>
<? include("inc/footer.php");?>                                                    	