<?php
include("inc/check_session.php");
include('inc/dbconnection.php');
include('inc/adm_function.php');
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=domesticpi.xls");

?>
<title>DOMESTIC PURCHASE INVOICE</title> 
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
<?php
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
?>
<table align="center" cellpadding="1" cellspacing="1" width="600" class="print_border">
	<tr>
    	<td align="center" colspan="6" style="border-bottom:#000000 solid thin;">Laxyo Solution Soft Pvt. Ltd.
        </td>
    </tr>
    <tr>    
        <td align="center" colspan="6" style="border-bottom:#000000 solid thin;"><span class="print_text">Regd. Off : 202, Kuber House, 162, Kanchan Bag, Indore-1</span><br/>
        				   <span class="print_text">Phone No.: 0731-2521021, 4066642-43 Fax No.: 0731-2529556</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="print_text"><b>TIN No.: 23390904470</b></span>	
        </td>
    </tr>
    <tr>
    	<td width="50%" valign="top" style="padding:2px;" colspan="3">
        	<table align="center" width="100%" cellpadding="0" cellspacing="0" class="print_border">
            	<tr>
                	<td class="print_text" colspan="3">M/s.&nbsp;<span><b><?=$buyername?></b></span><br/>
                    					   <span><?=$buyeraddress?></span><br/>
                                           <span><?=$buyercountry?></span>
                    </td>
                </tr>
                <tr>
                	<td class="print_text" colspan="3">TIN NO : <?=$tinno?></td>
                </tr>
                <tr>
                	<td class="print_text" colspan="3">C.S.T. : <?=$cstno?></td>    
                </tr>
            </table>         
        </td>
        <td width="50%" valign="top" style="padding:2px;" colspan="3">
        	<table align="center" width="100%" cellpadding="0" cellspacing="0" height="92">
            	<tr>
                	<td align="center" style="border-bottom:#000000 solid thin;" colspan="3"><span class="print_text"><b>PROFORMA INVOICE</b></span></td>
                </tr>
                <tr>
                	<td colspan="3">
                    <span class="print_text">INV. NO : <b><?=$pino?></b></span>
                    </td>
                </tr>
                <tr>
                	<td colspan="3">
                    <span class="print_text">DATE : <b><?=$pidate?></b></span>
                    </td>
                </tr>    
            </table>         
        </td>
     </tr>
    <tr>
        <td align="center" style="border-right:#000000 solid thin;border-bottom:#000000 solid thin;"><span class="print_text">Sl.NO.</span></td>
        <td align="center" style="border-right:#000000 solid thin;border-bottom:#000000 solid thin;"><span class="print_text">DESCRIPTION & MARKING OF GOODS</span></td>
        <td align="center" style="border-right:#000000 solid thin;border-bottom:#000000 solid thin;"><span class="print_text">No. of PACKS</span></td>
        <td align="center" style="border-right:#000000 solid thin;border-bottom:#000000 solid thin;border-top:#000000 solid thin;"><span class="print_text">TOTAL QTY KGS</span></td>
        <td align="center" style="border-right:#000000 solid thin;border-bottom:#000000 solid thin;border-top:#000000 solid thin;"><span class="print_text">RATE / KG</span></td>
        <td align="center" style="border-bottom:#000000 solid thin;border-top:#000000 solid thin;"><span class="print_text">AMOUNT (Rs.)</span></td>
    </tr>
<?php
$sql_detail = "select * from ".$mysql_adm_table_prefix."pi_detail where PiId = '$rec_id'"; 
$result_detail = mysql_query($sql_detail) or die("Error in Query : ".$sql_detail."<br/>".mysql_error()."<br/>".mysql_errno());
$i = 1;
$total_qty = 0;
$total_amount = 0;
$no_pck = 0;
while($row_detail = mysql_fetch_array($result_detail))
{
?> 
	<tr>
        <td align="center" style="border-right:#000000 solid thin;"><span class="print_text"><?=$i?></span></td>
        <td class="print_text" style="border-right:#000000 solid thin;"><?=getCount('Count','rec_id',$row_detail['CountId'])?>&nbsp;<?=getProduct('ProductName','rec_id',$row_detail['ProductId'])?></td>
        <td align="center" style="border-right:#000000 solid thin;"><span class="print_text"><?=$no_pck?>&nbsp;</span></td>
        <td align="center" style="border-right:#000000 solid thin;"><span class="print_text"><?=$row_detail['Quantity']?></span></td>
        <td align="right" style="border-right:#000000 solid thin;padding-right:5px;"><span class="print_text"><?=$row_detail['Price']?></span></td>
        <td align="right" style="padding-right:5px;"><span class="print_text"><? $amount = round($row_detail['Quantity']*$row_detail['Price']);echo $amount;?></span></td>
     </tr>
<?php
	$i++;
	$total_qty = $total_qty+$row_detail['Quantity'];
	$total_amount = $total_amount+$amount;
}
?>
	<tr>
        <td class="print_text" style="border-right:#000000 solid thin;padding-top:10px;">&nbsp;</td>
        <td align="right" style="border-right:#000000 solid thin;padding-right:5px;padding-top:10px;"><span class="print_text"><b>Total</b></span></td>
        <td align="center" style="border-right:#000000 solid thin;padding-top:10px;"><span class="print_text"><?=$no_pck?></span>&nbsp;</td>
        <td align="center" style="border-right:#000000 solid thin;padding-top:10px;"><span class="print_text"><b><?=$total_qty?></b></span></td>
        <td class="print_text" style="border-right:#000000 solid thin;padding-top:10px;">&nbsp;</td>
        <td class="print_text" style="padding-top:10px;">&nbsp;</td>
   </tr>
   <tr>
        <td colspan="3" class="print_text" style="border-top:#000000 solid thin;">&nbsp;</td>
        <td style="border-top:#000000 solid thin;" class="print_text"><b>GROSS AMOUNT</b></td>
        <td style="border-top:#000000 solid thin;" align="right"><b>:</b></td>
        <td style="border-top:#000000 solid thin;" align="right"><span class="print_text"><?=$total_amount?>&nbsp;</span></td>
   </tr>
   <tr>
        <td colspan="3" class="print_text">&nbsp;</td>
        <td class="print_text">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
   </tr>
   <tr>
        <td colspan="3" class="print_text">&nbsp;</td>
        <td class="print_text">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
   </tr>
   <tr>
        <td colspan="3" class="print_text"><b>TERMS & CONDITION :</b></td>
        <td class="print_text"><b>SUB TOTAL</b></td>
        <td align="right"><b>:</b></td>
        <td align="right"><span class="print_text"><?=$total_amount?>&nbsp;</span></td>
   </tr>
   <tr>
        <td colspan="3" class="print_border" height="80" valign="top">
        <span class="print_text">
        <ol>
              <li>Subject to Indore Jurisdiction.</li>
              <li>We are not responsible for any loss or damage in transit.</li>
              <li>Overdue Amount will attract 15% interest from due date.</li>	
              <li>If any running fault is noticed,Please inform with first roll at once.We will accept only one roll as defective.</li>
              <li>Payment against Delivery.</li>
         </ol>
         </span>
        </td>
        <td class="print_text" valign="top">ADD CST @ 2.00 %<br/>(SALES AGAINST FROM C )<br/><br/><br/><hr /><b>NET AMOUNT</b></td>
        <td align="right" valign="top"><b>:</b><br/><br/><br/><br/><hr /><b>:</b></td>
        <td align="right" valign="top"><span class="print_text"><?=round($total_amount*0.02)?>&nbsp;</span><br/><br/><br/><br/><hr /><b><? $net_amt = ($total_amount+round($total_amount*0.02));echo $net_amt;?>&nbsp;</b></td>
   </tr>
   <tr>
   	   <td colspan="6" class="print_text" style="border-bottom:#000000 solid thin;border-top:#000000 solid thin;"><?=num_to_wordsRS($net_amt,'Rupee', 2, 'Paise')?>&nbsp;Only</td>
   </tr>
   <tr>
   		<td class="print_text" valign="top" colspan="3">Delivery At :<br/>
        	<span><?=$buyeraddress?></span><br/>
            <span><?=$buyercountry?></span>
        </td>
        <td colspan="3" align="center"><br/><br/>
        	<span class="print_text"><b>For MAHIMA PURESPUN</b></span><br/>
        	<span class="print_text">(A Unit of Mahima Fibers Pvt. Ltd.)</span><br/>
        </td>
   </tr>
   <tr>
        <td colspan="3" class="print_text">&nbsp;</td>
        <td class="print_text">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
   </tr>
   <tr>
        <td colspan="3" class="print_text">&nbsp;</td>
        <td class="print_text">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
   </tr>   
   <tr>
    	<td class="print_text" style="padding-top:25px;" colspan="2">
        	<span>Prepared By</span>
        </td>
        <td class="print_text" style="padding-top:25px;" colspan="1">    
            <span>Checked By</span>
        </td>
        <td align="center" style="padding-top:25px;" colspan="3"><span class="print_text">Authorised Signature</span></td>
    </tr>                     
</table>        
<?php
}
?>
</body>
</html>