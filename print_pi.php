<?
include('inc/dbconnection.php');
include('inc/adm_function.php');
?>
<?
if(isset($_GET['id']))
{
	$sql = "select * from ".$mysql_adm_table_prefix."pi_master where rec_id = '".$_GET['id']."'";
	$result = mysql_query($sql) or die("Error in Query : ".$sql."<br/>".mysql_error()."<br/>".mysql_errno());
	$row = mysql_fetch_array($result);
	$rec_id = $row['rec_id'];
	$pi_number = $row['PiNumber'];
	$pi_date = getDateFormate($row['PiDate'],1);
	$buyername = getBuyer('BuyerName','rec_id',$row['BuyerId']);
	$buyercountry = getCountry(getBuyer('CountryId','rec_id',$row['BuyerId']));
	$TermsAndCondition = $row['TermsAndCondition'];
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EXPORT PURCHASE INVOICE</title>
<link href="style/adm0_style.css" rel="stylesheet" type="text/css">
<style type="text/css" media="print">

#div_print_btn
{
 visibility:hidden;
}
</style>
<style media="print" type="text/css">
	.noprintcontrols {
	VISIBILITY: hidden
}

</style>
</head>

<body>
<table align="center" width="100%" cellspacing="0" cellpadding="0" class="print_border">
	<tr>
    	<td align="center" colspan="2" style="border-bottom:#000000 solid 1px;"><span  class="headingSmallPrint">PROFORMA INVOICE</span></td>
    </tr>
    <tr>
    	<td width="50%" style="border-right:#000000 solid 1px;">
        	<table align="center" width="100%" cellpadding="0" cellspacing="0">
            	<tr>
                	<td class="print_text" valign="top"><b>Manufacturer & Export :</b><br/>
                    	<?=$company_Fulladdress?>
                    </td>
                </tr>
                <tr>
                	<td class="print_text" style="border-top:#000000 solid 1px; height:100px" valign="top"><b>Buyer(If Other Than Consignee)</b><br/>
                    	<b><?=$buyername?></b><br/>
                        <b><?=$buyercountry?></b>
                    </td>
                </tr>    
             </table>       
        </td>
        <td width="50%" valign="top">
        	<table align="center" width="100%" cellpadding="0" cellspacing="0">
            	<tr>
                	<td class="print_text" valign="top" style="border-right:#000000 solid 1px;">
                    	<b>Proforma Invoice No. :<br/><?=$pi_number?></b><br/><b><?=$pi_date?></b>
                    </td>
                    <td class="print_text" valign="top">Exporter's Ref. No.</td>
                </tr>
                <tr>
                	<td colspan="2" class="print_text" style="border-top:#000000 solid 1px;border-bottom:#000000 solid 1px;">Buyer's Order No.<br/>Email of Acme International, India</td>
                </tr>
               
                <tr>
                	<td class="print_text" valign="top" style="border-right:#000000 solid 1px;border-bottom:#000000 solid 1px;">Country of Origin<br/><b>INDIA</b></td>
                    <td class="print_text" style="border-bottom:#000000 solid 1px;" valign="top">Country of Final Destination<br/>
                    					   <b><?=$buyercountry?></b>
                    </td>
                </tr>
                <tr>
                	<td class="print_text">
                    	Terms of Delivery & Payment<br/>
                    	<br/>
                        <?=nl2br($TermsAndCondition)?>
                        
                    </td>
                </tr>       
            </table>        
        </td>
    </tr>
    <tr>
    	<td width="50%" valign="top" style="border-top:#000000 solid 1px;border-right:#000000 solid 1px;">
        	<table align="center" width="100%" cellpadding="0" cellspacing="0">
            	
                <tr>
                	<td align="center" valign="top" style="border-right:#000000 solid 1px;">
                    	<span class="print_text">Pre Carriage By</span><br/>
                        <span class="print_text" style="text-align:center">-</span>	
                    </td>
                    <td align="center" valign="top">
                    	<span class="print_text">Place of Receipt</span><br/>
                        <span class="print_text" style="text-align:center">-</span>
                    </td>
                </tr>
                <tr>
                	<td align="center" valign="top" style="border-right:#000000 solid 1px;border-top:#000000 solid 1px;">
                    	<span class="print_text">Vessel / Flight No.</span><br/>
                        <span class="print_text" style="text-align:center">-</span>	
                    </td>
                    <td align="center" valign="top" style="border-top:#000000 solid 1px;">
                    	<span class="print_text">Port of Loading</span><br/>
                        <span class="print_text" style="text-align:center">ANY PORT IN INDIA</span>
                    </td>
                </tr>
                <tr>
                	<td align="center" valign="top" style="border-right:#000000 solid 1px;border-top:#000000 solid 1px;">
                    	<span class="print_text">Port of Discharge</span><br/>
                        <span class="print_text" style="text-align:center">&nbsp;</span>	
                    </td>
                    <td align="center" valign="top" style="border-top:#000000 solid 1px;">
                    	<span class="print_text">Final Destination</span><br/>
                        <span class="print_text" style="text-align:center"><b><?=$buyercountry?></b></span>
                    </td>
                </tr>        
             </table>        
        </td>
        <td width="50%" valign="top" style="border-top:#000000 solid 1px;">
        	        
        </td>
    </tr>
    <tr>
    	<td colspan="2" style="border-top:#000000 solid 1px;">
        	<table align="center" width="100%" cellpadding="0" cellspacing="0">
            	<tr>
                	<td align="center" width="50%" style="border-right:#000000 solid 1px;border-bottom:#000000 solid 1px;" valign="top">
                    	<span class="print_text"><b>Description of Goods</b></span>
                    </td>
                    <td align="center" style="border-right:#000000 solid 1px;border-bottom:#000000 solid 1px;">
                    	<span class="print_text"><b>No. of<br/>Containers</b></span>
                    </td>
                    <td align="center" style="border-right:#000000 solid 1px;border-bottom:#000000 solid 1px;">
                    	<span class="print_text"><b>Total Qty.<br/>(In Kgs)</b></span>
                    </td>
                    <td align="center" style="border-right:#000000 solid 1px;border-bottom:#000000 solid 1px;">
                    	<span class="print_text"><b>Rate<br/>USD/Kg</b></span>
                    </td>
                    <td align="center" style="border-bottom:#000000 solid 1px;"><span class="print_text"><b>Amount<br/>USD</b></span></td>
                </tr>
		<?
		$sql_detail = "select * from ".$mysql_adm_table_prefix."pi_detail where PiId = '$rec_id'"; 
		$result_detail = mysql_query($sql_detail) or die("Error in Query : ".$sql_detail."<br/>".mysql_error()."<br/>".mysql_errno());
		$i = 1;
		$total_amount = 0;
		while($row_detail = mysql_fetch_array($result_detail))
		{
        
        ?>
        		<tr style="height:100px; vertical-align:top; padding-top:10px; padding-right:2px;">
                	<td width="50%" align="right" style="border-right:#000000 solid 1px;"><span class="print_text"><?=getCount('Count','rec_id',$row_detail['CountId'])?>&nbsp;<?=getProduct('ProductName','rec_id',$row_detail['ProductId'])?></span></td>
                    <td align="center" style="border-right:#000000 solid 1px;"><span class="print_text">&nbsp;</span></td>
                    <td align="right" style="border-right:#000000 solid 1px;padding-right:5px;"><span class="print_text"><?=$row_detail['Quantity']?></span></td>
                    <td align="center" style="border-right:#000000 solid 1px;"><span class="print_text"><?=$row_detail['Price']?></span></td>
                    <td align="right" style="padding-right:5px;"><span class="print_text"><?=($row_detail['Quantity']*$row_detail['Price'])?></span></td>
                </tr>
       <?
            $i++;
			$total_amount = $total_amount+($row_detail['Quantity']*$row_detail['Price']);
         }
        ?> 
        		<tr>
                	<td width="50%" align="left" style="border-right:#000000 solid 1px;padding-top:10px;" class="print_text">
                    <b>(Tolerance in Quantity and Amount +/-5%)</b><br/><br/>
                    <b>DELIVERY = </b><br/><br/><br/><br/>
                    </td>
                    <td style="border-right:#000000 solid 1px;">&nbsp;</td>
                    <td style="border-right:#000000 solid 1px;">&nbsp;</td>
                    <td style="border-right:#000000 solid 1px;">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                	<td class="print_text" colspan="3" style="border-top:#000000 solid 1px;border-right:#000000 solid 1px;" valign="top"><b>Amount Chargeble(in words):&nbsp;<?=num_to_wordsDoller($total_amount,'Doller', 2, 'Cent')?></b></td>
                    <td class="print_text" style="border-top:#000000 solid 1px;border-right:#000000 solid 1px;"><b>Total: USD<br/>CNF</b></td>
                    <td align="right" style="border-top:#000000 solid 1px;padding-right:5px;" valign="top"><span class="print_text"><b><?=$total_amount?></b></span></td>
                </tr>                                     
             </table>
         </td>
    </tr>
    <tr>
    	<td align="right" height="100" style="border-top:#000000 solid 1px;padding-top:10px;" colspan="2">
        	<table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td width="50%" align="left" style="padding-top:10px;" class="print_text">
                    
                    <b><u>Our Bank Details :</u></b><br/>
                    <b><?=$company_bankdetail?></b>
                    </td>
                   	<td align="right">
                    	<div style="width:230px;" class="print_text">
						<?=$company_fullname?>
                            <div style="padding-top:55px;"><b>AUTHORISED SIGNATORY</b></div>
                        </div>
                    </td>
                </tr>
            </table>
        	
        </td>
    </tr>                             
</table>    
<div align="center">
<span class="noprintcontrols">
    <input type="button" onClick="window.print();" id="btn_print" name="btn_print" value="Print">
</span>
</div>        
</body>
</html>