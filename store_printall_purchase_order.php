<?
include("inc/dbconnection.php");
include("inc/store_function.php");
$PageFor = "Purchase Order";
$PageKey = "order_id";


$po_type_select='';$po_date='';$supplier='';$ref_quot_no='';$purchase_order_date='';$purchase_order_type='';$amendment_date='';
$authorised_status='';$authorised_by='';$authorised_date='';

$tc_excise_duty='';$tc_sales_tax='';$tc_payment='';$tc_delivery_at='';$tc_delivery_date='';$tc_despatch='';$tc_freight='';$tc_special_instructions='';$cal_gross_amount='';$cal_discount_amount='';$cal_duty_amount='';$cal_st_amount='';
$cal_sc_amount='';$cal_excess_amount='';$cal_add_amount='';$cal_less_amount='';
$cal_pack_and_fowd_select='';$cal_pack_fowd_amt='';
$cal_payment_1='';$cal_payment_2='';$cal_payment_3='';$cal_payment_4='';$cal_payment_5='';$cal_payment_6='';
$cal_round_off='';$cal_total_amount='';$cal_net_amount='';
$PageKeyValue = "";

	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print All Purchase Order Bill</title>
<style>
.note
{
padding-left:35px;
font: Arial, Helvetica, sans-serif;
font-size:13px;
}
.particulars
{
font: Arial, Helvetica, sans-serif;
font-size:14px;
height:22px;
}
.tblborder
{
 border-collapse:collapse;border-color:1px solid #000;
}
</style>
</head>

<body onload="print();">
<?
$sql = "select * from ms_order_master ";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		while($row = mysql_fetch_array($result))
		{
			$PageKeyValue = $row[$PageKey];
			$po_type_select=$row['po_type_id'];
			$po_date=getDateFormate($row['po_date']);$supplier=$row['supplier_id'];$ref_quot_no=$row['ref_quot_number'];
			$purchase_order_date=getDateFormate($row['date']);$purchase_order_type=$row['type_p_amendment'];
			$amendment_date=getDateFormate($row['type_amendment_date']);
			$authorised_status=$row['authorised_status'];$authorised_by=$row['authorised_by'];$authorised_date=getDateFormate($row['authorised_date']);
			$tc_excise_duty=$row['tc_excise_duty'];$tc_sales_tax=$row['tc_sales_tax'];
			$tc_payment=$row['tc_payment'];$tc_delivery_at=$row['tc_delivery_at'];$tc_delivery_date=getDateFormate($row['tc_delivery_date']);
			$tc_despatch=$row['tc_despatch'];$tc_freight=$row['tc_freight'];$tc_special_instructions=$row['tc_sp_instruct'];
			$cal_gross_amount=$row['gross_amt_total'];$cal_discount_amount=$row['disc_amt_total'];	
			$cal_duty_amount=$row['duty_amt_total'];$cal_st_amount=$row['st_amt_total'];	
			$cal_excess_amount=$row['ecess_amt_total'];$cal_add_amount=$row['add_amt_total'];
			$cal_less_amount=$row['less_amt_total'];
			$cal_pack_fowd_amt=$row['pf_after_before_amount'];
			$cal_total_amount=$row['total_amount'];$cal_net_amount=$row['net_amount'];	
		
?>
<div style="width:700px;margin:0 auto">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  	<td>
      <table width="100%" border="1"  class="tblborder">
        <tr>
          <td>
          	<table align="center" width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td align="center" colspan="2"><b style="font-size:24px;">MAHIMA PURESPUN.</b></td>
              </tr>
              <tr>
                <td colspan="2" align="center">
                  (A UNIT OF MAHIMA FIBRES PVT. LTD.)<br />
                  Factory : PLOT No. 73 - 74 SECTOR-11, PITHAMPUR, DIST DHAR<br />
                  Phones : 07292 252995,252963 Fax :07292 252985
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>  
  <tr>
    <td>
      <table align="center" width="100%" border="1" cellspacing="0" cellpadding="2" class="tblborder">
        <tr>
          <td align="center" colspan="2"><b style="font-size:20px">PURCHASE ORDER</b></td>
        </tr>
        <tr>
          <td align="center">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="60%" style="border-right:1px solid #000">
                  <table width="100%" border="0" cellspacing="0" cellpadding="2">
                    <tr>
                      <td align="left"><strong>To:</strong></td>
                      <td colspan="3" align="left">
                         <?
                        $sql_sup="select * from ms_supplier where code=$supplier";
                        $res_sup=mysql_query($sql_sup);
                        $row_sup=mysql_fetch_array($res_sup);
                        echo $row_sup['name'];
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <td align="left"><strong>Phone No.:</strong></td>
                      <td colspan="3" align="left">&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="left"><strong>Tin No.:</strong></td>
                      <td align="left">&nbsp;</td>
                      <td align="left"><strong>C.S.T. No.:</strong></td>
                      <td align="left">&nbsp;</td>
                    </tr>
                  </table>
                </td>
                <td width="40%">
                  <table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr>
                        <td align="left"><strong>Ref. Ind. No.:</strong></td>
                        <td align="left"><?= $ref_quot_no ?></td>
                      </tr>
                      <tr>
                        <td align="left"><strong>Order No. :</strong></td>
                        <td align="left"><?= $PageKeyValue?></td>
                      </tr>
                      <tr>
                        <td align="left"><strong>Date :</strong></td>
                        <td align="left"><?= $po_date ?></td>
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
  <tr>
    <td>We are pleased to place an order for the following materials/items</td>
  </tr>
  <tr>
    <td>
    	<table align="center" width="100%" border="1" cellspacing="0" cellpadding="2" class="tblborder">
        <tr style="font-weight:bold">
          <td align="center">S.No.</td><td align="center">Particulars</td><td align="center">UOM</td>
          <td align="center">Qty.</td><td align="center">Rate</td><td align="center">Remark</td>
        </tr>
        <?
        $sql_order_trans="SELECT * FROM ms_order_master mom, ms_order_transaction mot WHERE mom.order_id = mot.order_id AND mom.order_id ='".$PageKeyValue."'";
        $res_order_trans=mysql_query($sql_order_trans);
        $countTrans=1;
        $rc_trans=mysql_num_rows($res_order_trans);
        if($rc_trans>0)
        {
          while($row_t=mysql_fetch_array($res_order_trans))
          {
          ?>
          <tr class="particulars">
            <td align="center"><?= $countTrans++?></td>
            <td align="left" style="padding-left:10px">
              <?
              $sql_item="select * from ms_item_master where item_code=$row_t[item_id]";
              $res_item=mysql_query($sql_item);
              $row_item=mysql_fetch_array($res_item);
              echo $row_item['name'];
              ?>
            </td>
            <td align="center">
            <? 
              $id = $row_t['item_id'];
              $sql = "SELECT * FROM  ms_item_master where item_code = '$id' order by name ";
              $result_item = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
              $uname='';
              if(mysql_num_rows($result_item)>0)
              {
                $row_item = mysql_fetch_array($result_item);
                $sql_uom = "SELECT name as uname FROM  ms_uom where uom_code = '".$row_item['uom_id']."' order by name ";
                $result_uom = mysql_query ($sql_uom) or die ("Error in : ".$sql_uom."<br>".mysql_errno()." : ".mysql_error());
                if(mysql_num_rows($result_uom)>0)
                {
                  $row_uom = mysql_fetch_array($result_uom);
                  $uname= $row_uom['uname'];
                }
              }
              echo $uname;
              ?>
            </td>
            <td align="center"><?=$row_t['po_qty']?></td>
            <td align="center"><?=$row_t['rate']?></td>
            <td align="center">
              <? 
              $id = $row_t['item_id'];
              $sql = "SELECT * FROM  ms_item_master where item_code= '$id'" ;
              $result_item = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
              $item_desc_trans='';
              if(mysql_num_rows($result_item)>0)
              {
                $row_item = mysql_fetch_array($result_item);
                $item_desc_trans= "Drg No.: ".$row_item['drawing_number'].';Cat No. '.$row_item['catelog_number'];
              }
              echo $item_desc_trans;
              ?>
            </td>
          </tr>
          <?
          }
        }
        ?>
      </table>
    </td>
  </tr>
  <tr>
    <td align="left">
    	<table width="100%" border="1"  class="tblborder" cellspacing="0" cellpadding="0">
        <tr>
        	<td><b style="font-size:14px">Terms And Conditions :</b></td>
        </tr>
        <tr>
        	<td class="note">
          	<table width="100%" border="0" cellspacing="2" cellpadding="0">
            	<tr>
                <td align="left" width="20%">Payment Terms </td>
                <td align="left" width="2%">&nbsp;<b>:</b>&nbsp;</td>
                <td align="left" width="78%">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" width="20%">Delivery At </td>
                <td align="left" width="2%">&nbsp;<b>:</b>&nbsp;</td>
                <td align="left" width="78%"><?= $tc_delivery_at ?></td>
              </tr>
              <tr>
                <td align="left" width="20%">Freight </td>
                <td align="left" width="2%">&nbsp;<b>:</b>&nbsp;</td>
                <td align="left" width="75%">
									<?
                  $freight='';
                  if($tc_freight=="to_pay")
                    $freight= "To Pay";
                  if($tc_freight=="paid")
                    $freight= "Paid";
                  if($tc_freight=="to_be_filled")
                  	$freight= "To Be Filled";
                  echo $freight;
								 ?>
                </td>
              </tr>
              <tr>
                <td align="left" width="20%">Despatch Through </td>
                <td align="left" width="2%">&nbsp;<b>:</b>&nbsp;</td>
                <td align="left" width="78%"><?= $tc_despatch ?></td>
              </tr>
              <tr>
                <td align="left" width="20%">Ex. Duty </td>
                <td align="left" width="2%">&nbsp;<b>:</b>&nbsp;</td>
                <td align="left" width="78%"><?= $tc_excise_duty ?></td>
              </tr>
              <tr>
                <td align="left" width="20%">Taxes </td>
                <td align="left" width="2%">&nbsp;<b>:</b>&nbsp;</td>
                <td align="left" width="78%"><?= $tc_sales_tax ?></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
		</td>
  </tr>
  <tr>
    <td>
    	<table width="100%" border="1"  class="tblborder" cellspacing="0" cellpadding="2">
        <tr>
          <td colspan="2" align="left"><b style="font-size:14px">Note:</b></td> 
        </tr>
        <tr>
          <td class="note">
            1. The above goods must be delivered as per terms and conditions otherwise we will reject/cancel the order.<br />
            2. Payment is subject to approval / verification of goods maintained by overselves.<br />
            3. All goods / materials should be strictly in confirmity with the order or else shall be rejected.<br />
            4. We have no liabilities for rejected goods.<br />
            5. Packing of goods must be damage proof, if any damage or leakage of goods may be returnable.<br />
            6. Delivery schedule be strictly followed to avoid any rejection / deduction in price.<br />
            7. Party should be mention the Purchase Order No. & Date otherwise the goods are not accepted.
        	</td> 
      	</tr>
    	</table>
		</td>
  </tr>
  <tr>
  </tr>
    <tr>
  	<td>
    	<table width="100%" border="1" class="tblborder" cellspacing="0" cellpadding="0">
        <tr height="40px">
          <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
             <tr height="40px">
                <td align="right" colspan="3"><b>For MAHIMA PURESPUN&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
              </tr>
              <tr>
                <td align="right" colspan="3">(A Unit Of Mahima Fibres Pvt. Ltd.)&nbsp;&nbsp;</td>
              </tr>
              <tr height="40px"><td></td></tr>
              <tr>
                <td align="left">&nbsp;Prepared By</td>
                <td align="center">Checked By</td>
                <td align="right">Authorised Signatory&nbsp;</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr height="60px">
  	<td><table width="100%" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</td>
</tr>
</table>
</div> 
<?
		}
	}
?>                
</body>
</html>
