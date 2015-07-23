<?
include("inc/check_session.php");
include('inc/dbconnection.php');
include('inc/adm_function.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"> 
<title>EXPORT PURCHASE INVOICE</title> 
<style type="text/css">
.headingSmallPrint
{
 	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:14px;
	color:#000000;
	text-align:center;
	line-height:15px;
	vertical-align:top;
	padding-right:10px;
	padding-top:thin;
	font-weight:bold;
}
.print_text {
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
	color:#000000;
	text-align:left;
	padding-left:5px;
	line-height:15px;
}
.print_border {
	border:thin solid #000000;
}
.left_padding {
 padding-left:5px;
 }
</style>
</head> 
<body> 
<?
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=exportpi.xls");
$IDC=array();

if(isset($_GET['pi_id']))
{
	$sql = "select * from ".$mysql_adm_table_prefix."pi_master where rec_id = '".$_GET['pi_id']."'";
	$result = mysql_query($sql) or die("Error in Query : ".$sql."<br/>".mysql_error()."<br/>".mysql_errno());
	$row = mysql_fetch_array($result);
	$rec_id = $row['rec_id'];
	$pi_number = $row['PiNumber'];
	$pi_date = getDateFormate($row['PiDate'],1);
	$buyername = getBuyer('BuyerName','rec_id',$row['BuyerId']);
	$buyercountry = getCountry(getBuyer('CountryId','rec_id',$row['BuyerId']));
	$buyeraddress = getBuyer('Address','rec_id',$row['BuyerId']);
	$tinno = getBuyer('TinNumber','rec_id',$row['BuyerId']);
	$cstno = getBuyer('CstNumber','rec_id',$row['BuyerId']);
	$pino = $row['PiNumber'];
	$pidate = getDateFormate($row['PiDate'],1);
	$TermsAndCondition = $row['TermsAndCondition'];
?>
<table align="center" cellpadding="1" cellspacing="1" width="700" class="print_border">
	<tr>
    	<td align="center" colspan="2" style="border-bottom:#000000 solid thin;"><span  class="headingSmallPrint">PROFORMA INVOICE</span></td>
    </tr>
    <tr>
    	<td style="border-right:#000000 solid thin;">
        	<table align="center" width="100%" cellpadding="0" cellspacing="0">
            	<tr>
                	<td class="print_text" valign="top" colspan="2"><b>Manufacturer & Export :</b><br/>
                    	<?=$company_Fulladdress?>
                    </td>
                </tr>
                <tr>
                	<td class="print_text" style="border-top:#000000 solid thin;" valign="top" colspan="2"><b>Buyer(If Other Than Consignee)</b><br/>
                    	<b><?=$buyername?></b><br/>
                        <b><?=$buyercountry?></b>
                    </td>
                </tr>    
             </table>       
        </td>
        <td valign="top">
        	<table align="center" width="100%" cellpadding="0" cellspacing="0">
            	<tr>
                	<td colspan="2" class="print_text" valign="top" style="border-right:#000000 solid thin;">
                    	<b>Proforma Invoice No. :<br/><?=$pi_number?></b><br/><b><?=$pi_date?></b>
                    </td>
                    <td colspan="2" class="print_text" valign="top">Exporter's Ref. No.</td>
                </tr>
                <tr>
                	<td class="print_text" colspan="4" style="border-top:#000000 solid thin;border-bottom:#000000 solid thin;">Buyer's Order No.<br/>Email of Acme International, India</td>
                </tr>
                <tr>
                	<td class="print_text" colspan="4" valign="top" style="border-bottom:#000000 solid thin;">Consignee :<br/>Same as Buyer</td>
                </tr>
                <tr>
                	<td colspan="2" class="print_text" valign="top" style="border-right:#000000 solid thin;">Country of Origin<br/><b>INDIA</b></td>
                    <td colspan="2" class="print_text" valign="top">
                    	Country of Final Destination<br/>
                    	<b><?=$buyercountry?></b>
                    </td>        
            </table>        
        </td>
    </tr>
    <tr>
    	<td valign="top" style="border-top:#000000 solid thin;border-right:#000000 solid thin;">
        	<table align="center" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                	<td align="center" valign="top" style="border-right:#000000 solid thin;">
                    	<span class="print_text">Pre Carriage By</span><br/>
                        <span class="print_text" style="text-align:center">-</span>	
                    </td>
                    <td align="center" valign="top" style="border-top:#000000 solid thin;">
                    	<span class="print_text">Place of Receipt</span><br/>
                        <span class="print_text" style="text-align:center">-</span>
                    </td>
                </tr>
                <tr>
                	<td align="center" valign="top" style="border-right:#000000 solid thin;border-top:#000000 solid thin;">
                    	<span class="print_text">Vessel / Flight No.</span><br/>
                        <span class="print_text" style="text-align:center">-</span>	
                    </td>
                    <td align="center" valign="top" style="border-top:#000000 solid thin;">
                    	<span class="print_text">Port of Loading</span><br/>
                        <span class="print_text" style="text-align:center">ANY PORT IN INDIA</span>
                    </td>
                </tr>
                <tr>
                	<td align="center" valign="top" style="border-right:#000000 solid thin;border-top:#000000 solid thin;">
                    	<span class="print_text">Port of Discharge</span><br/>
                        <span class="print_text" style="text-align:center">&nbsp;</span>	
                    </td>
                    <td align="center" valign="top" style="border-top:#000000 solid thin;">
                    	<span class="print_text">Final Destination</span><br/>
                        <span class="print_text" style="text-align:center"><b><?=$buyercountry?></b></span>
                    </td>
                </tr>        
             </table>        
        </td>
        <td valign="top" style="border-top:#000000 solid thin;">
        	<table align="center" width="100%" cellpadding="0" cellspacing="0">
            	<tr>
                	<td class="print_text" valign="top" colspan="4"><b>Terms of Delivery & Payment</b><br/>
                    	<br/>
                        <?=nl2br($TermsAndCondition)?>
                    </td>
                </tr>
            </table>        
        </td>
    </tr>
    <tr>
    	<td colspan="2" style="border-top:#000000 solid thin;">
        	<table align="center" width="100%" cellpadding="0" cellspacing="0">
            	<tr>
                	<td align="center" colspan="2" style="border-right:#000000 solid thin;border-bottom:#000000 solid thin;" valign="top">
                    	<span class="print_text"><b>Description of Goods</b></span>
                    </td>
                    <td align="center" style="border-right:#000000 solid thin;border-bottom:#000000 solid thin;">
                    	<span class="print_text"><b>No. of<br/>Containers</b></span>
                    </td>
                    <td align="center" style="border-right:#000000 solid thin;border-bottom:#000000 solid thin;">
                    	<span class="print_text"><b>Total Qty.<br/>(In Kgs)</b></span>
                    </td>
                    <td align="center" style="border-right:#000000 solid thin;border-bottom:#000000 solid thin;">
                    	<span class="print_text"><b>Rate<br/>USD/Kg</b></span>
                    </td>
                    <td align="center" style="border-bottom:#000000 solid thin;"><span class="print_text"><b>Amount<br/>USD</b></span></td>
                </tr>
		<?
		$sql_detail = "select * from ".$mysql_adm_table_prefix."pi_detail where PiId = '$rec_id'"; 
		$result_detail = mysql_query($sql_detail) or die("Error in Query : ".$sql_detail."<br/>".mysql_error()."<br/>".mysql_errno());
		$i = 1;
		$total_amount = 0;
		while($row_detail = mysql_fetch_array($result_detail))
		{
        
        ?>
        		<tr>
                	
                    
                    <td colspan="2" align="right" style="border-right:#000000 solid thin;padding-right:5px; line-height:35px; height:35px; vertical-align:top;"><span class="print_text"><?=getCount('Count','rec_id',$row_detail['CountId'])?>&nbsp;<?=getProduct('ProductName','rec_id',$row_detail['ProductId'])?></span></td>
                    
                    <td align="center" style="border-right:#000000 solid thin;"><span class="print_text">&nbsp;</span></td>
                    <td align="right" style="border-right:#000000 solid thin;padding-right:5px; vertical-align:top"><span class="print_text"><?=$row_detail['Quantity']?></span></td>
                    <td align="center" style="border-right:#000000 solid thin;padding-right:5px; vertical-align:top"><span class="print_text"><?=$row_detail['Price']?></span></td>
                    <td align="right" style="padding-right:5px;vertical-align:top"><span class="print_text"><?=($row_detail['Quantity']*$row_detail['Price'])?></span></td>
                </tr>
       <?
            $i++;
			$total_amount = $total_amount+($row_detail['Quantity']*$row_detail['Price']);
         }
        ?> 
        		<tr>
                	<td colspan="2" align="left" style="border-right:#000000 solid thin;padding-top:10px;" class="print_text">
                    <b>Packing Details</b><br/>
                    <b>&nbsp;</b>
                    </td>
                    <td style="border-right:#000000 solid thin;">&nbsp;</td>
                    <td style="border-right:#000000 solid thin;">&nbsp;</td>
                    <td style="border-right:#000000 solid thin;">&nbsp;</td>
                    <td style="border-right:#000000 solid thin;">&nbsp;</td>
                </tr>
                <tr>
                	<td colspan="2" align="left" style="border-right:#000000 solid thin;padding-top:10px;" class="print_text">
                    <b>SHIPMENT :</b><br/>
                    <b>&nbsp;</b>
                    </td>
                    <td style="border-right:#000000 solid thin;">&nbsp;</td>
                    <td style="border-right:#000000 solid thin;">&nbsp;</td>
                    <td style="border-right:#000000 solid thin;">&nbsp;</td>
                    <td style="border-right:#000000 solid thin;">&nbsp;</td>
                </tr>
                <tr>
                	<td colspan="2" align="left" style="border-right:#000000 solid thin;padding-top:10px;" class="print_text">
                    <b><u>Our Bank Details :</u></b><br/>
                    <b><?=$company_bankdetail?></b>
                    </td>
                    <td style="border-right:#000000 solid thin;">&nbsp;</td>
                    <td style="border-right:#000000 solid thin;">&nbsp;</td>
                    <td style="border-right:#000000 solid thin;">&nbsp;</td>
                    <td style="border-right:#000000 solid thin;">&nbsp;</td>
                </tr>
                <tr>
                	<td class="print_text" colspan="4" style="border-top:#000000 solid thin;border-right:#000000 solid thin;" valign="top"><b>Amount Chargeble(in words):&nbsp;<?=num_to_wordsDoller($total_amount,'Doller', 2, 'Cent')?></b></td>
                    <td class="print_text" style="border-top:#000000 solid thin;border-right:#000000 solid thin;"><b>Total: USD<br/>CNF</b></td>
                    <td align="right" style="border-top:#000000 solid thin;padding-right:5px;" valign="top"><span class="print_text"><b><?=$total_amount?></b></span></td>
                </tr>                                     
             </table>
         </td>
    </tr>
   
    <tr>
    	<td style="border-top:#000000 solid thin;padding-top:20px;">&nbsp;
			        	
        </td>
        <td style="border-top:#000000 solid thin;padding-top:20px;">&nbsp;
			        	
        </td>
        
    </tr>
    <tr>
    	<td>&nbsp;
        	
        </td>
    	<td style="border-left:thin solid #000000; border-top:thin solid #000000;">
        	<div style="height:20px;"class="print_text print_border">
            <?=$company_fullname?><br/><br/>
            	<div style="padding-top:55px;"><b>AUTHORISED SIGNATORY</b></div>
            </div>
        </td>
    </tr>
</table>        
<?
}
?>
</body>
</html>