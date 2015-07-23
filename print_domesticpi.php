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
	$buyeraddress = getBuyer('Address','rec_id',$row['BuyerId']);
	$tinno = getBuyer('TinNumber','rec_id',$row['BuyerId']);
	$cstno = getBuyer('CstNumber','rec_id',$row['BuyerId']);
	$pino = $row['PiNumber'];
	$pidate = getDateFormate($row['PiDate'],1);
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DOMESTIC PURCHASE INVOICE</title>
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
<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" class="print_border">
	<tr>
    	<td align="center" colspan="2" style="border-bottom:#000000 solid 1px;">
            <span class="headingSmallPrint">MAHIMA PURESPUN</span><br/>
            <span class="print_text">(A UNIT OF MAHIMA FIBRES PVT. LTD.)</span><br/>
            <span class="print_text">PLOT NO. 73-74, SECTOR-II, PITHAMPUR, DIST-DHAR</span><br/>
            <span class="print_text">PHONE NO : 07292-416323 FAX : 07292-252985 EMAIL ID : mahima_mill@rediffmail.com</span>
        </td>
    </tr>
    <tr>    
        <td align="center" colspan="2" style="border-bottom:#000000 solid 1px;">
        	<span class="print_text">Regd. Off : 406, Corporate House, 169 R.N.T. Marg, Indore</span><br/>
            <span class="print_text">PHONE NO : 0731-4271451-66 FAX : 0731-2529556 EMAIL ID : mahimaaccounts@gmail.com</span>
            <span class="print_text"><b>TIN No.: 23390904470</b></span>	
        </td>
    </tr>
    <tr>
    	<td width="50%" valign="top" style="padding:2px;">
        	<table align="center" width="100%" cellpadding="0" cellspacing="0" class="print_border">
            	<tr>
                	<td class="print_text">
						M/s.&nbsp;<span><b><?=$buyername?></b></span><br/>
                       	<span><?=$buyeraddress?></span><br/>
                       	<span><?=$buyercountry?></span>
                    </td>
                </tr>
                <tr>
                	<td class="print_text">TIN NO : <?=$tinno?></td>
                </tr>
                <tr>
                	<td class="print_text">C.S.T. : <?=$cstno?></td>    
            </table>         
        </td>
        <td width="50%" valign="top" style="padding:2px;">
        	<table align="center" width="100%" cellpadding="0" cellspacing="0" class="print_border" height="92">
            	<tr>
                	<td align="center" style="border-bottom:#000000 solid 1px;"><span class="print_text"><b>PROFORMA INVOICE</b></span></td>
                </tr>
                <tr>
                	<td>
                    <span class="print_text">INV. NO : <b><?=$pino?></b></span>
                    </td>
                </tr>
                <tr>
                	<td>
                    <span class="print_text">DATE : <b><?=$pidate?></b></span>
                    </td>
                </tr>    
            </table>         
        </td>
    </tr>
    <tr>
    	<td colspan="2" style="border-top:#000000 solid 1px;padding-top:2px;">
        	<table align="center" width="100%" cellpadding="0" cellspacing="0" style="border-bottom:#000000 solid 1px;border-top:#000000 solid 1px;  height:350px; vertical-align:top;">
            	<tr style="height:30px;">
                	<td align="center" style="border-right:#000000 solid 1px;border-bottom:#000000 solid 1px;"><span class="print_text">Sl.NO.</span></td>
                    <td align="center" style="border-right:#000000 solid 1px;border-bottom:#000000 solid 1px;"><span class="print_text">DESCRIPTION & MARKING OF GOODS</span></td>
                    <td align="center" style="border-right:#000000 solid 1px;border-bottom:#000000 solid 1px;"><span class="print_text">No. of PACKS</span></td>
                    <td align="center" style="border-right:#000000 solid 1px;border-bottom:#000000 solid 1px;"><span class="print_text">TOTAL QTY KGS</span></td>
                    <td align="center" style="border-right:#000000 solid 1px;border-bottom:#000000 solid 1px;"><span class="print_text">RATE / KG</span></td>
                    <td align="center" style="border-bottom:#000000 solid 1px;"><span class="print_text">AMOUNT (Rs.)</span></td>
                </tr>
		<?
            $sql_detail = "select * from ".$mysql_adm_table_prefix."pi_detail where PiId = '$rec_id'"; 
            $result_detail = mysql_query($sql_detail) or die("Error in Query : ".$sql_detail."<br/>".mysql_error()."<br/>".mysql_errno());
            $i = 1;
			$total_qty = 0;
			$total_amount = 0;
			$no_pck = 0;
            while($row_detail = mysql_fetch_array($result_detail))
            {
        
        ?>                
                <tr style="vertical-align:top">
                	<td align="center" style="border-right:#000000 solid 1px;"><span class="print_text"><?=$i?></span></td>
                    <td class="print_text" style="border-right:#000000 solid 1px;"><?=getCount('Count','rec_id',$row_detail['CountId'])?>&nbsp;<?=getProduct('ProductName','rec_id',$row_detail['ProductId'])?></td>
                    <td align="center" style="border-right:#000000 solid 1px;"><span class="print_text"><?=$no_pck?>&nbsp;</span></td>
                    <td align="center" style="border-right:#000000 solid 1px;"><span class="print_text"><?=$row_detail['Quantity']?></span></td>
                    <td align="right" style="border-right:#000000 solid 1px;padding-right:5px;"><span class="print_text"><?=$row_detail['Price']?></span></td>
                    <td align="right" style="padding-right:5px;"><span class="print_text"><? $amount = round($row_detail['Quantity']*$row_detail['Price']);echo $amount;?></span></td>
                </tr>
		<?
            $i++;
			$total_qty = $total_qty+$row_detail['Quantity'];
			$total_amount = $total_amount+$amount;
            }
        ?>                
                <tr style="height:30px;">
                	<td class="print_text" style="border-right:#000000 solid 1px;padding-top:10px;">&nbsp;</td>
                    <td align="right" style="border-right:#000000 solid 1px;padding-right:5px;padding-top:10px;"><span class="print_text"><b>Total</b></span></td>
                    <td align="center" style="border-right:#000000 solid 1px;padding-top:10px;"><span class="print_text"><?=$no_pck?></span>&nbsp;</td>
                    <td align="center" style="border-right:#000000 solid 1px;padding-top:10px;"><span class="print_text"><b><?=$total_qty?></b></span></td>
                    <td class="print_text" style="border-right:#000000 solid 1px;padding-top:10px;">&nbsp;</td>
                    <td class="print_text" style="padding-top:10px;">&nbsp;</td>
                </tr>
             </table>       
        </td>
    </tr>
    <tr>
    	<td width="55%" valign="top">
        	<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td>&nbsp;</td>
                    <td width="2">&nbsp;</td>
                </tr>
                <tr>
                	<td class="print_text" colspan="2"><b>TERMS & CONDITIONS :</b></td>
                </tr>
              <tr>
               	  <td style="border-top:#000000 solid 1px;border-right:#000000 solid 1px;border-bottom:#000000 solid 1px;" width="100%" height="99" colspan="2"><span class="print_text"><ol>
                              <li>Subject to Indore Jurisdiction.</li>
                              <li>We are not responsible for any loss or damage in transit.</li>
                              <li>Overdue Amount will attract 15% interest from due date.</li>	
                              <li>If any running fault is noticed,Please inform with first roll at once.We will accept only one roll as defective.</li>
                              <li>Payment against Delivery.</li>
                              </ol></span>
                  </td>   
              </tr>   
            </table> 
        </td>
        <td width="45%" valign="top">
        	<table align="center" width="100%" cellpadding="0" cellspacing="0">
            	<tr>
                	<td width="55%" height="40" valign="top" style="padding-top:2px;"><span class="print_text"><b>GROSS AMOUNT</b></span></td>
                    <td width="2%" height="40" valign="top" style="padding-top:2px;"><b>:</b></td>
                  	<td width="43%" height="40" align="right" valign="top" style="padding-top:2px;"><span class="print_text"><?=$total_amount?>&nbsp;</span></td>
                </tr>
                <tr>
                	<td class="print_text"><B>SUB TOTAL</B></td>
                    <td><b>:</b></td>
                    <td align="right"><span class="print_text"><?=$total_amount?>&nbsp;</span></td>
                </tr>
                 <tr>
                	<td class="print_text">ADD CST @ 2.00 %<br/>(SALES AGAINST FROM C )</td>
                    <td><b>:</b></td>
                    <td align="right"><span class="print_text"><?=round($total_amount*0.02)?>&nbsp;</span></td>
                </tr>
                <tr>
                	<td class="print_text" style="padding-bottom:5px;">PACKING & FORWARDING</td>
                    <td style="padding-bottom:5px;"><b>:</b></td>
                    <td align="right" style="padding-bottom:5px;"><span class="print_text">&nbsp;</span></td>
                </tr>
                <tr>
                	<td class="print_text" style="border-top:#000000 solid 1px;border-bottom:#000000 solid 1px;" height="21"><b>NET AMOUNT</b></td>
                    <td style="border-top:#000000 solid 1px;border-bottom:#000000 solid 1px;" height="21"><b>:</b></td>
                    <td align="right" style="border-top:#000000 solid 1px;border-bottom:#000000 solid 1px;" height="21"><span class="print_text"><b><? $net_amt = ($total_amount+round($total_amount*0.02));echo $net_amt;?>&nbsp;</b></span></td>
                </tr>      
            </table>        
        </td>
    </tr>
    <tr>
    	<td colspan="2" class="print_text" style="border-bottom:#000000 solid 1px;"><?=no_to_words($net_amt)?>&nbsp;Only</td>            
    </tr>
    <tr>
    	<td class="print_text" valign="top">Delivery At :<br/>
        	<span><?=$buyeraddress?></span><br/>
            <span><?=$buyercountry?></span>
        </td>
        <td style="padding-top:40px;" align="center"><span class="print_text"><b>For MAHIMA PURESPUN</b></span><br/>
        											 <span class="print_text">(A Unit of Mahima Fibres Pvt. Ltd.)</span><br/>
                                                     						
        </td>
    </tr>
    <tr>
    	<td class="print_text" style="padding-top:35px;">
        	<span>Prepared By</span>
            <span style="padding-left:150px;">Checked By</span>
        </td>
        <td align="center" style="padding-top:35px;"><span class="print_text">Authorised Signatory</span></td>
    </tr> 
</table>
<div align="center">
<span class="noprintcontrols">
    <input type="button" onClick="window.print();" id="btn_print" name="btn_print" value="Print">
</span>
</div>
</body>
</html>    