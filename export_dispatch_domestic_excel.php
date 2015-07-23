<?php
include("inc/check_session.php");
include('inc/dbconnection.php');
include('inc/adm_function.php');
if(isset($_GET['id']))
{
	$sql = "select * from ".$mysql_adm_table_prefix."dispatch_number where rec_id = '".$_GET['id']."'";
	$result = mysql_query($sql) or die("Error in Query : ".$sql."<br/>".mysql_error()."<br/>".mysql_errno());
	$row = mysql_fetch_array($result);
	$rec_id = $row['rec_id'];
	$buyername = getBuyer('BuyerName','rec_id',$row['BuyerId']);
	$buyercountry = getCountry(getBuyer('CountryId','rec_id',$row['BuyerId']));
	$buyeraddress = getBuyer('Address','rec_id',$row['BuyerId']);
	$buyertinno = getBuyer('TinNumber','rec_id',$row['BuyerId']);
	$invoiceno = $row['DispatchNumber'];
	$invoicedate = getDateFormate($row['DespatchDate'],1);
	$transport = $row['TransportNo'];
	$vechileno = $row['VechileNo'];
	$lr_no = $row['LrNo'];
	$lr_date = $row['LrDate'];
	$Other_ref = $row['OtherRef'];
	$FreightCharges = $row['FreightCharges'];
	$pi_id = getDispatchDetail('PiId','DispatchNumberId',$rec_id);
	$report_type = getPINumber('ReportType','rec_id',$pi_id);
	$FinalNetAmount = $row['FinalNetAmount'];
}	
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=domestic_dispatch_excel.xls");
?>
<style type="text/css">
.headingSmallPrint
{
 	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:15px;
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
.print_smalltext {
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:9px;
	color:#000000;
	text-align:left;
	padding-left:5px;
	line-height:15px;
}
.print_border {
	border:#000000 solid thin;
}
.left_padding {
 padding-left:5px;
 }
</style>
<body>
<table align="center" cellpadding="1" cellspacing="1" width="700" style="border:#000000 solid thin;">
  <tr>
    <td colspan="7" style="border-bottom:#000000 solid thin">
    	<div align="center">
        	<span class="headingSmallPrint" style="font-size:18px;"><b>MAHIMA PURESPUN</b></span><br/>
        	<span class="print_smalltext"><b>(A UNIT OF MAHIMA FIBERS PVT. LTD.)</b></span><br/>
        	<span class="print_smalltext"><b>PLOT NO. 73-74, SECTOR-II, PITHAMPUR, DIST-DHAR</b></span><br/>
      		<span class="print_smalltext"><b>PHONE NO : 07292-416323 FAX : 07290-252985 EMAIL: Mahima_mill@rediffmail.com</b></span><br/>
            <span class="print_smalltext"><b>VAT TIN Number: 23390904470M</b></span>
        </div>
    </td>
  </tr>
  <tr>
    <td colspan="7" style="border-bottom:#000000 solid thin">
    	<div align="center">
                <span class="print_text"><b>Regd. Off : 202, Kuber House, 162, Kanchan Bag, Indore-01</b></span><br/>
                <span class="print_text"><b>Phone No.: 0731-2521021, 4066642-43 Fax No.: 0731-2529556, email id :- mahimaaccounts@gmail.com</b></span>
        </div>
	</td>
  </tr>
  <tr>
    <td colspan="3" style="border-bottom:#000000 solid thin;border-right:#000000 solid thin;" valign="top">
    	
        
        <table align="center" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td width="12%" valign="top" class="print_text">Buyer</td>
                <td width="3%" valign="top" class="print_text">:</td>
                <td width="85%" valign="top" class="print_text"><b><?=$buyername?></b><br/><?=$buyeraddress?><br/><b><?=$buyercountry?></b></td>
            </tr>
            <tr>
                <td class="print_text">TIN No</td>
                <td class="print_text">:</td>
                <td class="print_text"><b><?=$buyertinno?></b></td>
            </tr>
        </table>      
    </td>
    <td colspan="4" style="border-bottom:#000000 solid thin" valign="top">
    	<table width="100%" style="vertical-align:top;">
        	<tr>
            	<td>&nbsp;</td>
                <td>&nbsp;</td>
            	<td align="left" valign="top" style="font-size:14px;"><div class="headingSmallPrint"><b>YARN INVOICE</b></div></td>
           </tr>
            <tr>
            	<td width="18%" class="print_text" style="border-top:#000000 solid thin" valign="top"><b>INVOICE NO.</b></td>
          		<td width="3%" valign="top"><div align="center">:</div></td>
              	<td width="79%" class="print_text" style="border-top:#000000 solid thin;" valign="top"><b><?=$invoiceno?></b></td>
          	</tr>
            <tr>
            	<td class="print_text" style="border-bottom:#000000 solid thin;" valign="top"><b>DATED</b></td>
                <td valign="top"><div align="center">:</div></td>
              	<td width="79%" valign="top" align="left" style="border-bottom:#000000 solid thin;"><span class="print_text"><b><?=$invoicedate?></b></span></td>
            </tr>
            <tr>
            	<td align="center"><span class="print_text">Transport</span></td>
                <td><div align="center">:</div></td>
              	<td class="print_text"><b><?=$transport?></b></td>
            </tr>
            <tr>
            	<td align="center"><span class="print_text">Vechile NO</span></td>
                <td><div align="center">:</div></td>
              	<td class="print_text"><b><?=$vechileno?></b></td>
            </tr>
            <tr>
            	<td align="center"><span class="print_text">LR NO</span></td>
                <td><div align="center">:</div></td>
              	<td class="print_text"><b><?=$lr_no?></b></td>
            </tr>
            <tr>
            	<td align="center"><span class="print_text">LR Date</span></td>
                <td><div align="center">:</div></td>
                <td class="print_text"><b><?=$lr_date?></b></td>
            </tr>
            <tr>
            	<td align="center"><span class="print_text">Order No</span></td>
                <td><div align="center">:</div></td>
              	<td class="print_text"><b></b></td>
            </tr>
            <tr>
            	<td align="center"><span class="print_text">Other Ref</span></td>
                <td><div align="center">:</div></td>
              	<td class="print_text"><b><?=$Other_ref?></b></td>
            </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td width="54" align="center" style="border-bottom:#000000 solid thin;border-right:#000000 solid thin;"><span class="print_text"><b>S.No.</b></span></td>
    <td width="310" align="center" style="border-bottom:#000000 solid thin;border-right:#000000 solid thin;" colspan="2"><span class="print_text"><b>Description &amp; Marking of Goods</b></span></td>
    <td width="69" align="center" style="border-bottom:#000000 solid thin;border-right:#000000 solid thin;"><span class="print_text"><b>No. of PACKS</b></span></td>
    <td width="88" align="center" style="border-bottom:#000000 solid thin;border-right:#000000 solid thin;"><span class="print_text"><b>TOTAL QTY/KGS</b></span></td>
    <td width="76" align="center" style="border-bottom:#000000 solid thin;border-right:#000000 solid thin;"><span class="print_text"><b>RATE/KG</b></span></td>
    <td width="80" align="center" style="border-bottom:#000000 solid thin;"><span class="print_text"><b>AMOUNT (Rs.)</b></span></td>
  </tr>
<?php
$sql_detail = "select * from ".$mysql_adm_table_prefix."dispatch_master where DispatchNumberId = '$rec_id'"; 
$result_detail = mysql_query($sql_detail) or die("Error in Query : ".$sql_detail."<br/>".mysql_error()."<br/>".mysql_errno());
$i = 1;
$total_amount = 0;
while($row_detail = mysql_fetch_array($result_detail))
{
?>  
  <tr>
    <td align="center" valign="top" height="120" style="border-bottom:#000000 solid thin;border-right:#000000 solid thin;"><span class="print_text"><?=$i?></span></td>
    <td class="print_text" valign="top" style="border-bottom:#000000 solid thin;border-right:#000000 solid thin;"><b><?=getCount('Count','rec_id',$row_detail['CountId'])?></b>&nbsp;<?=getProduct('ProductName','rec_id',$row_detail['ProductId'])?></td>
    <td style="border-bottom:#000000 solid thin;border-right:#000000 solid thin;">&nbsp;</td>
    <td valign="top" style="border-right:#000000 solid thin;border-bottom:#000000 solid thin;" class="print_text">&nbsp;</td>
    <td valign="top" style="border-right:#000000 solid thin;border-bottom:#000000 solid thin;" align="center"><span class="print_text"><?=$row_detail['NowOfferedQty']?> KGS</span></td>
    <td align="right" style="padding-right:5px;vertical-align:top;border-bottom:#000000 solid thin;;border-right:#000000 solid thin;"><span class="print_text"><?
	if($report_type=='exmill')
	{ 
		echo $row_detail['Price'];
	}
	else if($report_type=='net')
	{
		$y2 = $FinalNetAmount-$FreightCharges;
		$x2 = $y2/1.02;
		$sub_total1 = round($x2,2);
		$amt1 = $sub_total1/$i;
		$amount = round($amt1,2);
		$rate = $amount/$row_detail['NowOfferedQty'];
		echo round($rate,2);
	}	
	?></span></td>
    <td align="right" style="padding-right:5px;vertical-align:top;border-bottom:#000000 solid thin;"><span class="print_text"><?php 
	if($report_type=='exmill')
	{
		echo $row_detail['NowOfferedQty']*$row_detail['Price'];
	}	
	else if($report_type=='net')
	{
		$y1 = $FinalNetAmount-$FreightCharges;
		$x1 = $y1/1.02;
		$sub_total = round($x1,2);
		$amt = $sub_total/$i;
		echo round($amt,2);
	}
	?></span></td>
  </tr>
<?php
$i++;
	$total_amount = $total_amount+($row_detail['NowOfferedQty']*$row_detail['Price']);
}
?>  
  <tr>
    <td style="border-bottom:#000000 solid thin;border-right:#000000 solid thin;">&nbsp;</td>
    <td align="right" style="border-bottom:#000000 solid thin;border-right:#000000 solid thin;"><span class="print_text"><b></b>&nbsp;</span></td>
    <td align="right" style="border-bottom:#000000 solid thin;border-right:#000000 solid thin;"><span class="print_text"><b>Total :</b>&nbsp;</span></td>
    <td align="center" style="border-bottom:#000000 solid thin;border-right:#000000 solid thin;"><span class="print_text"><b></b></span>&nbsp;</td>
    <td style="border-bottom:#000000 solid thin;border-right:#000000 solid thin;">&nbsp;</td>
    <td align="right" style="border-bottom:#000000 solid thin;;border-right:#000000 solid thin;"><span class="print_text"><b></b></span>&nbsp;</td>
    <td align="right" style="border-bottom:#000000 solid thin;;border-right:#000000 solid thin;"><span class="print_text"><b>
    <?php 
	if($report_type=='exmill')
	{
		echo $total_amount;
	}
	else if($report_type=='net')
	{
		$y = $FinalNetAmount-$FreightCharges;
		$x = $y/1.02;
		echo round($x,2);
	}
	?>&nbsp;</b></span>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" style="border-bottom:#000000 solid thin;border-right:#000000 solid thin;">
    	<p class="print_text"><b>Bank Details: State Bank Of Mysore, Account No.-64001674621</b></p>
    	<p class="print_text"><b>TERMS &amp; CONDITIONS:</b></p>
        <ol>
              <li class="print_smalltext">Subject to Indore Jurisdiction.</li>
              <li class="print_smalltext">We are not responsible for any loss or damage in transit.</li>
              <li class="print_smalltext">Overdue Amount will attract 15% interest from due date.</li>	
              <li class="printprint_smalltext_text">If any running fault is noticed,Please inform with first roll at once.We will accept only one roll as defective.</li>
              <li class="print_smalltext">Payment against Delivery.</li>
        </ol>
    </td>
    <td colspan="2" valign="top" class="print_text" style="border-bottom:#000000 solid thin;border-right:#000000 solid thin;"> 
    	C.S.T.<br/>
    	Freight On Sales
	</td>
    <td valign="top" align="center" style="border-bottom:#000000 solid thin;border-right:#000000 solid thin;"><span class="print_text">2%</span></td>
    <td valign="top" align="right" style="border-bottom:#000000 solid thin;"><span class="print_text">
    <?php
	if($report_type=='exmill')	
	{ 
		echo ($total_amount*2)/100;
	}
	else if($report_type=='net')
	{
		$z = $y-$x;
		echo round($z,2);
	}	
	?></span><br/>
    <span class="print_text"><?=$FreightCharges?></span></td>
  </tr>
  <tr>
    <td colspan="6" align="right" style="padding-right:40px;border-bottom:#000000 solid thin;"><span class="print_text">Total Amount :</span></td>
    <td align="right" style="border-bottom:#000000 solid thin;"><span class="print_text"><b>
    <?php 
	if($report_type=='exmill')	
	{
	 	$final_total = $total_amount+($total_amount*2)/100+$FreightCharges;
	 	echo $final_total;
	}
	else if($report_type=='net')
	{
		$final_total = $FinalNetAmount;
		echo $final_total;
	}		
	 ?></b></span></td>
  </tr>
  <tr>
    <td colspan="7" class="print_text" style="border-bottom:#000000 solid thin;"><b>Rs. <?=num_to_wordsRS($final_total,'Rupee', 2, 'Paise')?> Only</b></td>
  </tr>
  <tr>
    <td colspan="6" class="print_text"><b>Delivery at :</b>
    <span></span><br/><br/>
    <span><b>Prepared By</b></span>
    <span style="padding-left:150px;"><b>Checked By</b></span>
    <span style="text-align:right;padding-left:50px;"><b>For MAHIMA PURESPUN</b><br/><b>(A Unit of Mahima Fibers Pvt. Ltd.)</b></span>
  	</td>
  </tr>
  
</table>

</body>
</html>
