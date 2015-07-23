<?
include("inc/check_session.php");
include('inc/dbconnection.php');
include('inc/adm_function.php');
?>
<?
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
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Priview Of Domestic Dispatch</title>
<link href="style/adm0_style.css" rel="stylesheet" type="text/css">
<style type="text/css">
.print_smalltext {
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:10px;
	color:#000000;
	text-align:left;
	padding-left:5px;
	line-height:15px;
}
</style>
</head>
<body>
<table align="center" cellpadding="1" cellspacing="1" width="100%" style="border:#000000 solid 1px;">
  <tr>
    <td colspan="7" style="border-bottom:#000000 solid 1px">
    	<div align="center">
        	<span class="headingSmallPrint" style="font-size:18px;"><b>MAHIMA PURESPUN</b></span><br/>
        	<span class="print_text"><b>(A UNIT OF MAHIMA FIBERS PVT. LTD.)</b></span><br/>
        	<span class="print_text"><b>PLOT NO. 73-74, SECTOR-II, PITHAMPUR, DIST-DHAR</b></span><br/>
      		<span class="print_text"><b>PHONE NO : 07292-416323 FAX : 07290-252985 EMAIL: Mahima_mill@rediffmail.com</b></span><br/>
            <span class="print_text"><b>VAT TIN Number: 23390904470M</b></span>
        </div>
    </td>
  </tr>
  <tr>
    <td colspan="7" style="border-bottom:#000000 solid 1px">
    	<div align="center">
                <span class="print_text"><b>Regd. Off : 202, Kuber House, 162, Kanchan Bag, Indore-01</b></span><br/>
                <span class="print_text"><b>Phone No.: 0731-2521021, 4066642-43 Fax No.: 0731-2529556, email id :- mahimaaccounts@gmail.com</b></span>
        </div>
	</td>
  </tr>
  <tr>
    <td colspan="3" style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;" valign="top">
    	
        
        <table width="100%" height="201" align="center" cellpadding="0" cellspacing="0">
<tr>
                <td width="12%" valign="top" class="print_text" height="150">Buyer</td>
                <td width="3%" valign="top" class="print_text">:</td>
                <td width="85%" valign="top" class="print_text"><b><?=$buyername?></b><br/><?=$buyeraddress?><br/><b><?=$buyercountry?></b></td>
            </tr>
            <tr>
                <td height="50" class="print_text">TIN No</td>
              <td class="print_text">:</td>
                <td class="print_text"><b><?=$buyertinno?></b></td>
            </tr>
        </table>      
    </td>
    <td colspan="4" style="border-bottom:#000000 solid 1px" valign="top">
    	<table width="100%" style="vertical-align:top;">
        	<tr>
            	<td>&nbsp;</td>
                <td>&nbsp;</td>
            	<td align="left" valign="top" style="font-size:14px;"><div class="headingSmallPrint"><b>YARN INVOICE</b></div></td>
           </tr>
            <tr>
            	<td width="31%" class="print_text" style="border-top:#000000 solid 1px" valign="top"><b>INVOICE NO.</b></td>
       		  <td width="2%" valign="top"><div align="center">:</div></td>
           	  <td width="67%" class="print_text" style="border-top:#000000 solid 1px;" valign="top"><b><?=$invoiceno?></b></td>
       	  </tr>
            <tr>
            	<td class="print_text" style="border-bottom:#000000 solid 1px;" valign="top"><b>DATED</b></td>
                <td valign="top"><div align="center">:</div></td>
              	<td width="67%" valign="top" align="left" style="border-bottom:#000000 solid 1px;"><span class="print_text"><b><?=$invoicedate?></b></span></td>
          </tr>
            <tr>
            	<td align="left"><span class="print_text">Transport</span></td>
                <td><div align="center">:</div></td>
              	<td class="print_text"><b><?=$transport?></b></td>
            </tr>
            <tr>
            	<td align="left"><span class="print_text">Vechile NO</span></td>
                <td><div align="center">:</div></td>
              	<td class="print_text"><b><?=$vechileno?></b></td>
            </tr>
            <tr>
            	<td align="left"><span class="print_text">LR NO</span></td>
                <td><div align="center">:</div></td>
              	<td class="print_text"><b><?=$lr_no?></b></td>
            </tr>
            <tr>
            	<td align="left"><span class="print_text">LR Date</span></td>
                <td><div align="center">:</div></td>
                <td class="print_text"><b><?=$lr_date?></b></td>
            </tr>
            <tr>
            	<td align="left"><span class="print_text">Order No</span></td>
                <td><div align="center">:</div></td>
              	<td class="print_text"><b></b></td>
            </tr>
            <tr>
            	<td align="left"><span class="print_text">Other Ref</span></td>
                <td><div align="center">:</div></td>
              	<td class="print_text"><b><?=$Other_ref?></b></td>
            </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td width="54" align="center" style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;"><span class="print_text"><b>S.No.</b></span></td>
    <td width="310" align="center" style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;" colspan="2"><span class="print_text"><b>Description &amp; Marking of Goods</b></span></td>
    <td width="69" align="center" style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;"><span class="print_text"><b>No. of PACKS</b></span></td>
    <td width="88" align="center" style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;"><span class="print_text"><b>TOTAL QTY/KGS</b></span></td>
    <td width="76" align="center" style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;"><span class="print_text"><b>RATE/KG</b></span></td>
    <td width="80" align="center" style="border-bottom:#000000 solid 1px;"><span class="print_text"><b>AMOUNT (Rs.)</b></span></td>
  </tr>
<?
$sql_detail = "select * from ".$mysql_adm_table_prefix."dispatch_master where DispatchNumberId = '$rec_id'"; 
$result_detail = mysql_query($sql_detail) or die("Error in Query : ".$sql_detail."<br/>".mysql_error()."<br/>".mysql_errno());
$i = 1;
$total_amount = 0;
while($row_detail = mysql_fetch_array($result_detail))
{
?>  
  <tr>
    <td align="center" height="120" valign="top" style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;"><span class="print_text"><?=$i?></span></td>
    <td class="print_text" valign="top" style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;"><b><?=getCount('Count','rec_id',$row_detail['CountId'])?></b>&nbsp;<?=getProduct('ProductName','rec_id',$row_detail['ProductId'])?></td>
    <td style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;">&nbsp;</td>
    <td valign="top" style="border-right:#000000 solid 1px;border-bottom:#000000 solid 1px;" class="print_text">&nbsp;</td>
    <td valign="top" style="border-right:#000000 solid 1px;border-bottom:#000000 solid 1px;" align="center"><span class="print_text"><?=$row_detail['NowOfferedQty']?> KGS</span></td>
    <td align="right" style="padding-right:5px;vertical-align:top;border-bottom:#000000 solid 1px;;border-right:#000000 solid 1px;"><span class="print_text">    <?
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
    <td align="right" style="padding-right:5px;vertical-align:top;border-bottom:#000000 solid 1px;"><span class="print_text">
	<? 
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
<?
$i++;
	$total_amount = $total_amount+($row_detail['NowOfferedQty']*$row_detail['Price']);
}
?>  
  <tr>
    <td style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;">&nbsp;</td>
    <td align="right" style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;"><span class="print_text"><b></b>&nbsp;</span></td>
    <td align="right" style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;"><span class="print_text"><b>Total :</b>&nbsp;</span></td>
    <td align="center" style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;"><span class="print_text"><b></b></span>&nbsp;</td>
    <td style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;">&nbsp;</td>
    <td align="right" style="border-bottom:#000000 solid 1px;;border-right:#000000 solid 1px;"><span class="print_text"><b></b></span>&nbsp;</td>
    <td align="right" style="border-bottom:#000000 solid 1px;;border-right:#000000 solid 1px;"><span class="print_text"><b>
	<? 
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
    <td colspan="3" style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;">
    	<p class="print_text"><b>Bank Details: State Bank Of Mysore, Account No.-64001674621</b></p>
    	<p class="print_text"><b>TERMS &amp; CONDITIONS:</b></p>
        <ol>
              <li class="print_smalltext">Subject to Indore Jurisdiction.</li>
              <li class="print_smalltext">We are not responsible for any loss or damage in transit.</li>
              <li class="print_smalltext">Overdue Amount will attract 15% interest from due date.</li>	
              <li class="print_smalltext">If any running fault is noticed,Please inform with first roll at once.We will accept only one roll as defective.</li>
              <li class="print_smalltext">Payment against Delivery.</li>
        </ol>
    </td>
    <td colspan="2" valign="top" class="print_text" style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;"> 
    	C.S.T.<br/>
    	Freight On Sales
	</td>
    <td valign="top" align="center" style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;"><span class="print_text">2%</span></td>
    <td valign="top" align="right" style="border-bottom:#000000 solid 1px;"><span class="print_text">
	<?
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
    <td colspan="6" align="right" style="padding-right:40px;border-bottom:#000000 solid 1px;"><span class="print_text">Total Amount :</span></td>
    <td align="right" style="border-bottom:#000000 solid 1px;"><span class="print_text"><b>
    <? 
	$final_total = 0;
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
    <td colspan="7" class="print_text" style="border-bottom:#000000 solid 1px;"><b>Rs. <?=num_to_wordsRS($final_total,'Rupee', 2, 'Paise')?> Only</b></td>
  </tr>
  <tr>
    <td colspan="7">
    <span style="text-align:left"><span class="print_text"><b>Delivery at :</b></span></span>
    <span style="padding-left:550px;"><span class="print_text"><b>For MAHIMA PURESPUN</b></span></span>
    <div align="right"><span class="print_text"><b>(A Unit of Mahima Fibers Pvt. Ltd.)</b></span></div><br/><br/><br/>
    	<table align="center" width="100%" border="0">
        	<tr>
            	<td width="32%" align="left" valign="top"><span class="print_text"><b>Prepared By</b></span></td>
              <td width="24%" align="center" valign="top"><span class="print_text"><b>Checked By</b></span></td>
   			  <td width="44%" align="right" valign="top" style="padding-right:40px;"><span class="print_text"><b>Authorised Signatory</b></span></td>
          </tr>
         </table>       
  	</td>
  </tr>
</table>
<div align="center"><span class="AddMore"><a href="export_dispatch_domestic_excel.php?id=<?=$rec_id?>">Edit</a></span></div>
</body>
</html>
