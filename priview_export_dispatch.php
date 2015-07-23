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
	$invoiceno = $row['DispatchNumber'];
	$invoicedate = getDateFormate($row['DespatchDate'],1);
	$freightcharges = $row['FreightCharges'];
	$port = $row['Port'];
	$container_no = $row['TransportNo'];
	$seal_no = $row['VechileNo'];
	//$lot_no = $row['LrNo'];
	//$no_pkg = count(explode(",",$row['SrNo']));
	$agent_seal_no = $row['AgentSealNo'];
	$hs_code = $row['HSCode'];
	$pi_no = getPINumber('PiNumber','rec_id',getDispatchDetail('PiId','DispatchNumberId',$rec_id));
	$PiDate = getDateFormate(getPINumber('PiDate','rec_id',getDispatchDetail('PiId','DispatchNumberId',$rec_id)),1);
	$pi_detailid = getPiDetail('rec_id','PiId',getDispatchDetail('PiId','DispatchNumberId',$rec_id));
	
	
}	
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Priview Of Export Dispatch</title>
<link href="style/adm0_style.css" rel="stylesheet" type="text/css">
</head>
<body>
<table align="center" cellpadding="1" cellspacing="1" width="100%" style="border:#000000 solid 1px;">
  <tr>
    <td colspan="6" align="center" style="border-bottom:#000000 solid 1px;"><span class="headingSmallPrint"><b>COMMERCIAL INVOICE</b></span></td>
  </tr>
  <tr>
    <td colspan="3" rowspan="2" valign="top" class="print_text" style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;">Exporter :<br/>
    <b>MAHIMA PURESPUN</b><br/>
    (A UNIT OF MAHIMA FIBRES PVT. LTD.)<br/>
    PLOT NO. 73-74, SEC-II, PITHAMPUR<br/>
    DISTRICT, DHAR, M.P., <b>INDIA</b><br/>
    I.E. CODE NO. 1101000376
    </td>
    <td colspan="2" valign="top" class="print_text" style="border-right:#000000 solid 1px;">Invoce No. and Date :<br/>
    <b><?=$invoiceno?></b><br/>
    <b>Dated <?=$invoicedate?></b>
    </td>
    <td width="142" valign="top" class="print_text">Exporter Ref:<br/>
    PI No. <b><?=$pi_no?></b><br/>
    Dated <b><?=$PiDate?></b>
    </td>
  </tr>
  <tr>
    <td colspan="3" class="print_text" valign="top" style="border-top:#000000 solid 1px;border-bottom:#000000 solid 1px;">Buyer's Order No. &amp; Date</td>
  </tr>
  <tr>
  	 <td colspan="3" rowspan="2" class="print_text" valign="top" style="border-right:#000000 solid 1px;border-bottom:#000000 solid 1px;">Consignee/Importer:<br/>
     <b><?=$buyername?></b><br/>
     <?=$buyeraddress?><br/>
     <b><?=$buyercountry?></b>
     </td>
    <td colspan="3" valign="top" class="print_text" style="border-bottom:#000000 solid 1px;">Buyer (if other than consignee)</td>
  </tr>
  <tr>
    <td colspan="2" valign="top" class="print_text" style="border-right:#000000 solid 1px;">Country of Origin of Goods<br/>
    <b>INDIA</b>
    </td>
    <td class="print_text" valign="top">Country of final Destination :<br/><b><?=$buyercountry?></b></td>
  </tr>
  <tr>
    <td colspan="2" class="print_text" style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;" valign="top">Pre. Carriage by :</td>
    <td width="148" valign="top" class="print_text" style="border-bottom:#000000 solid 1px;">Place of Receipt by</td>
    <td colspan="3" rowspan="3" class="print_text" valign="top" style="border-top:#000000 solid 1px;border-bottom:#000000 solid 1px;border-left:#000000 solid 1px;">Terms of Delivery of Payment<br/><?=nl2br(getPINumber('TermsAndCondition','rec_id',getDispatchDetail('PiId','DispatchNumberId',$rec_id)))?></td>
  </tr>
  <tr>
    <td colspan="2" class="print_text" style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;" valign="top">Vessel/Flight No.:</td>
    <td class="print_text" style="border-bottom:#000000 solid 1px;" valign="top">Port of Loading :</td>
  </tr>
  <tr>
    <td colspan="2" class="print_text" style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;" valign="top">Port of Discharge :</td>
    <td class="print_text" style="border-bottom:#000000 solid 1px;" valign="top">Final Destination :</td>
  </tr>
  <tr>
    <td width="96" valign="top" class="print_text" style="border-bottom:#000000 solid 1px;"><b>Marks &amp; Nos./</b></td>
    <td width="117" valign="top" class="print_text" style="border-bottom:#000000 solid 1px;"><b>No. &amp; Kind of Pkgs.</b></td>
    <td valign="top" class="print_text" style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;"><b>Description of Goods</b></td>
    <td width="94" align="center" valign="top" style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;"><span class="print_text"><b>Quantity</b><br/>
    <b>Kgs</b></span></td>
    <td width="80" align="center" valign="top" style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;"><span class="print_text"><b>Rate<br/></b>
    <b>(USD/Kg)</b></span></td>
    <td valign="top" align="center" style="border-bottom:#000000 solid 1px;"><span class="print_text"><b>Amount</b><br/><b>(USD)</b></span></td>
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
    <td class="print_text" height="150" valign="top">
    	<b>Container No :</b>&nbsp;<?=$container_no?>
        <br />
        <b>Seal No. :</b>&nbsp;<?=$seal_no?>
        <br /><br/>
		<?
       	$sql_lot = "select LotNumber,IdentificationMarks,PiDetailId,NoOfPck from mo_adm_lot_master where PiDetailId = '".$row_detail["PiDetailId"]."' and DispatchMasterId =  '".$row_detail["rec_id"]."'";
        $result_lot = mysql_query($sql_lot) or die("Error in Query : ".$sql_lot."<br/>".mysql_error()."<br/>".mysql_errno());
		$no_pkg = 0;
        while($row_lot = mysql_fetch_array($result_lot))
        {
            $IdentificationMarks = $row_lot['IdentificationMarks'];
            $lot_number = $row_lot['LotNumber'];
			$no_pkg = $no_pkg + $row_lot['NoOfPck'];
        ?>	
            <b>Lot No. : </b>&nbsp;<?=$lot_number?>
            <br /> 
            <b>Sr. No. : </b>&nbsp;	
            <? 
                $lotsr_no = explode(",",$IdentificationMarks);
                $sr_first = $lotsr_no[0]; 
                $sr_last= end($lotsr_no);
                $sr_no = $sr_first . " TO " .$sr_last;
                echo $sr_no;
            ?><br/><br/>
        <?	
        }
        ?> 
        <b>Agent Seal No.</b>&nbsp;<?=$agent_seal_no?>      
        <br/>
    </td>
    <td valign="top" class="print_text"><b><?=$no_pkg?></b> STANDARD EXPORT SEAWORTHY PALLENTS&nbsp;</td>
    <td valign="top" style="border-right:#000000 solid 1px;" class="print_text">
	<?=getCount('Count','rec_id',$row_detail['CountId'])?>&nbsp;<?=getProduct('ProductName','rec_id',$row_detail['ProductId'])?><br/><br/>
    <b>H.S. CODE :</b> <?=$hs_code?></td>
    <td valign="top" style="border-right:#000000 solid 1px;" class="print_text"><?=$row_detail['NowOfferedQty']?></td>
    <td valign="top" style="border-right:#000000 solid 1px;" align="center"><span class="print_text"><?=$row_detail['Price']?></span></td>
    <td align="right" style="padding-right:5px;vertical-align:top"><span class="print_text"><?=($row_detail['NowOfferedQty']*$row_detail['Price'])?></span></td>
  </tr>
<?
	$i++;
	$total_amount = $total_amount+($row_detail['NowOfferedQty']*$row_detail['Price']);
 }
?>  
  <tr>
    <td colspan="3" class="print_text" style="border-top:#000000 solid 1px;border-right:#000000 solid 1px;border-bottom:#000000 solid 1px;"><b>BILL OF LADING NO.:</b></td>
    <td valign="top" style="border-right:#000000 solid 1px;">&nbsp;</td>
    <td valign="top" style="border-right:#000000 solid 1px;">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" valign="top" class="print_text" style="border-right:#000000 solid 1px;border-bottom:#000000 solid 1px;"><B>EXPORT UNDER EPCG LCENCE NO.</B></td>
    <td valign="top" style="border-right:#000000 solid 1px;">&nbsp;</td>
    <td valign="top" style="border-right:#000000 solid 1px;">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" valign="top" class="print_text" style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;"><b>EXPORT UNDERDEPB SCHEME</b></td>
    <td valign="top" class="print_text" style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;">&nbsp;</td>
    <td valign="top" class="print_text" style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;">&nbsp;</td>
    <td valign="top" class="print_text" style="border-bottom:#000000 solid 1px;">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" valign="top" class="print_text" style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;">Ammount Chargeable (In words) :&nbsp;<b><?=num_to_wordsDoller($total_amount,'Doller', 2, 'Cent')?></b></td>
    <td class="print_text" valign="top" style="border-bottom:#000000 solid 1px;border-right:#000000 solid 1px;"><b>Total Value CFR (USD)</b></td>
    <td align="right" valign="top" style="border-bottom:#000000 solid 1px;"><span class="print_text"><b><?=$total_amount?></b></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="right" style="border-left:#000000 solid 1px;border-top:#000000 solid 1px;border-right:#000000 solid 1px;"><span class="print_text">CFR Value $</span></td>
    <td align="right" style="border-top:#000000 solid 1px;"><span class="print_text"><?=$total_amount?></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right" colspan="2" valign="top" style="border-left:#000000 solid 1px;border-top:#000000 solid 1px;border-right:#000000 solid 1px;"><span class="print_text">Ocean Freight Charges $</span></td>
    <td align="right" style="border-top:#000000 solid 1px;"><span class="print_text"><?=$freightcharges?>&nbsp;</span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" valign="top" style="border:#000000 solid 1px;" align="right"><span class="print_text">FOB Value $</span></td>
    <td align="right" style="border-top:#000000 solid 1px;border-bottom:#000000 solid 1px;"><span class="print_text"><? $fob = $total_amount-$freightcharges;  echo $fob;?>&nbsp;</span></td>
  </tr>
  <tr>
    <td colspan="3" valign="top">
    	<span class="print_text">-We hereby state that</span>
    	<span class="print_text">- GOODS ARE OF INDIAN ORIGIN</span><br/>
    	<div style="padding-left:135px;"><span class="print_text">- GOODS ARE OF FIRST QUALITY</span>	</div>									
    </td>    
    <td colspan="3" class="print_text">(2% OF FOB VALUE TO BE DEDUCTED & PAID TO EVIATAR SHERER ISRAEL)</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="padding-left:21px;" colspan="4"><span class="print_text">- GOODS ARE IN STRICT CONFORMITY WITH PROFORMA INVOICE NO. <?=$pi_no?> DATED <?=$PiDate?></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="print_text">WE ARE NOT REGISTERED WITH CENTRAL EXCISE & NOT AVAILING OF ANY CENVAT CREDIT FACILITY.<br/>
    	UNDER NOTIFICATION NO.
    </td>
  </tr>
  <tr>
    <td colspan="4" class="print_text">
    	- We here by cerify that the goods mentioned above is of INDIAN ORIGIN.
        <BR />
        - We declare that this invoice shows the actual price of the goods descibed and that all particulars are true & correct.
    </td>
    <td colspan="2" style="border-left:#000000 solid 1px;border-top:#000000 solid 1px;" class="print_text">
    	<table align="right" width="100%">
        	<tr>
            	<td class="print_text">
                   <b>For MAHIMA PURESPUN</b><br/>
                    (A Unit of Mahima Fibers Pvt Ltd)
                    <br />
                    <br />
                    <br />
                    Authorised Signatory
                </td>
            </tr>
        </table>
    </td>
  </tr>
</table>
<div align="center"><span class="AddMore"><a href="export_dispatch_excel.php?id=<?=$rec_id?>">Edit</a></span></div>
</body>
</html>