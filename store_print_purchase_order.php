<?
include("inc/dbconnection.php");
include("inc/store_function.php");
$PageFor = "Purchase Order";
$PageKey = "order_id";


$po_type_select='';$po_date='';$supplier='';$ref_quot_no='';$purchase_order_date='';$purchase_order_type='';

$tc_billing_address='';$tc_delivery_address='';$tc_payment_terms='';$tc_delivery='';
$tc_delivery_date='';$tc_errection='';$tc_freight='';
$tc_excise_and_taxes='';$tc_p_and_f='';$tc_remarks='';

$cal_gross_amount='';$cal_discount_amount='';$cal_duty_amount='';$cal_st_amount='';
$cal_sc_amount='';$cal_excess_amount='';$cal_add_amount='';$cal_less_amount='';
$cal_pack_and_fowd_select='';$cal_pack_fowd_amt='';
$cal_payment_1='';$cal_payment_2='';$cal_payment_3='';$cal_payment_4='';$cal_payment_5='';$cal_payment_6='';

$cal_round_off='';$cal_total_amount='';$cal_net_amount='';
$PageKeyValue = "";

if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_order_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$order_id = $row[$PageKey];
		$po_type_select=$row['po_type_id'];
		$order_date=getDateFormate($row['order_date']);
		$supplier_id=$row['supplier_id'];
		$indent_id=$row['indent_id'];
	
	  $tc_billing_address=stripslashes($row['tc_billing_address']);
		$tc_delivery_address=stripslashes($row['tc_delivery_address']);
		$tc_payment_terms=stripslashes($row['tc_payment_terms']);
		$tc_delivery=stripslashes($row['tc_delivery']);
		$tc_delivery_date=getDateFormate($row['tc_delivery_date']);
		$tc_errection=stripslashes($row['tc_errection']);
		$tc_freight=stripslashes($row['tc_freight']);
		$tc_excise_and_taxes=stripslashes($row['tc_excise_and_taxes']);
		$tc_p_and_f=stripslashes($row['tc_p_and_f']);
		$tc_remarks=stripslashes($row['tc_remarks']);
	
		$cal_gross_amt=$row['gross_amt_total'];$cal_disc_amt=$row['disc_amt_total'];	
		$cal_duty_amount=$row['duty_amt_total'];$cal_vat_amt=$row['vat_amt_total'];$cal_ecess_amt=$row['ecess_amt_total'];
		$cal_pack_fowd_amt=$row['pf_after_before_amount'];
		$cal_round_off=$row['round_off_amount'];
		$cal_total_amt=$row['total_amount'];$cal_net_amt=$row['net_amount'];	
	}
}
$sql_count = "select count(*) as count from ms_order_master,ms_order_transaction 
where ms_order_master.order_id=ms_order_transaction.order_id and ms_order_master.order_id='".$order_id."'";
$result_count = mysql_query($sql_count) or die ("Invalid query : ".$sql_count."<br>".mysql_errno()." : ".mysql_error());
$row_count = mysql_fetch_array($result_count);
$numrows = $row_count['count'];
$no_of_rec_show=4;
$count = ceil($numrows/$no_of_rec_show);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Purchase Order</title>
<style>
.note
{
font: Arial, Helvetica, sans-serif;
font-size:13px;
}
.particulars
{
font: Arial, Helvetica, sans-serif;
font-size:10px;
height:28px;
}
.tblborder
{
 border-collapse:collapse;border-color:1px solid #000;
}
.borderTop
{
	border-top:1px solid #000;
}
.borderBottom
{
	border-bottom:1px solid #000;
}
.borderRight
{
	border-right:1px solid #000;
}
.borderLeft
{
	border-left:1px solid #000;
}
.padding_left
{
	padding-left:2px;
}
.break { page-break-before: always; }
</style>
</head>

<body onload="print();">
<? 
	for($i=0,$countTrans=1;$i<$count;$i++)
	{
	?>
    <div style="width:740px;margin:0 auto;font:Arial, Helvetica, sans-serif;border:1px solid #000">
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      	<thead> 
          <tr>
            <td>
              <table align="center" width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td align="center">
                  <b style="font-size:20px;">MAHIMA PURESPUN&nbsp;&nbsp;&nbsp;TIN No.: 23390904470</b>
                </td>
              </tr>
              <tr>
                <td align="center">
                  (A UNIT OF MAHIMA FIBRES PVT. LTD.)<br />
                  406 Corporate House, 169 R.N.T. Marg, Indore-452001<br />
                  Phone : 0731 - 4271451 - 66 Fax :0731 2529556<br />
                  <b style="font-size:13px">E-Mail : mahimaspares@gmail.com</b>
                </td>
              </tr>
            </table>    
            </td>
          </tr>
          <tr>
            <td class="borderTop">
              <table align="center" width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                  <td align="center" colspan="2"><b style="font-size:20px">PURCHASE ORDER</b></td>
                </tr>
                <tr>
                  <td align="center">
                    <table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr>
                        <td width="70%">
                          <table width="100%" border="0" cellspacing="0" cellpadding="2">
                            <tr>
                              <td align="left" valign="top"><b>To:</b></td>
                              <td align="left" style="font-size:13px">
                                <?
                                $sql_sup="select * from ms_supplier where supplier_id=$supplier_id";
                                $res_sup=mysql_query($sql_sup);
                                $row_sup=mysql_fetch_array($res_sup);
                                echo $row_sup['name'];echo '<br />';
                                echo $row_sup['address'];
                                ?>
                              </td>
                            </tr>
                            <tr>
                              <td align="left" valign="top"><b>Phone No.:</b></td>
                              <td align="left" style="font-size:13px"><?=$row_sup['phone_number']?></td>
                            </tr>
                            <tr>
                              <td align="left"><b>FAX:</b></td>
                              <td align="left" style="font-size:13px"><?=$row_sup['fax']?></td>
                            </tr>
                            <tr>
                              <td align="left"><b>Tin No.:</b></td>
                              <td align="left" style="font-size:13px"><?=$row_sup['tin']?></td>
                            </tr>
                            <tr>
                              <td align="left"><b>Indent No.:</b></td>
                              <td align="left"><?= $indent_id ?></td>
                            </tr>
                            <tr>
                              <td align="left"><b>Purchase Order No.:</b></td>
                              <td align="left" style="font-size:12px">
                              <?
                                $forYear=getDateFormate($order_date);
                                $year=explode('-',$forYear);
                                //if($year[2])
                                $year1='';$year2='';
                                if(($year[1]>=4 && $year[1]<=12) || $year[1]>=1 && $year[1]<=3)
                                {
                                  
                                  if(($year[1]>=4 && $year[1]<=12))
                                  {
                                    $year1=$year[0];
                                    $year2=$year[0]+1;
                                  }
                                  if(($year[1]>=1 && $year[1]<=3))
                                  {
                                    $year2=$year[0];
                                    $year1=$year[0]-1;
                                  }
                                  
                                }
                                echo '<b>MP/'.$year1.'-'.$year2.'/'.$order_id.'</b>';
                              ?>
                              </td>
                            </tr>
                          </table>
                        </td>
                        <td width="30%" valign="bottom">
                          <table width="100%" border="0" cellspacing="0" cellpadding="2">
                              <tr>
                                <td align="right"><b>Date :</b></td>
                                <td align="left"><?= $order_date ?></td>
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
          <tr height="30px">
            <td style="font-size:12px">&nbsp;&nbsp;We accept the rate and submit our order as follows.</td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <table align="center" width="100%" border="0" cellspacing="0" cellpadding="2" class="tblborder">
                <tr style="font-weight:bold" class="borderBottom borderTop">
                  <td align="center" class="borderRight">S.No.</td>
                  <td align="center" class="borderRight">Particulars</td>
                  <td align="center" class="borderRight">UOM</td>
                  <td align="center" class="borderRight">Qty.</td>
                  <td align="center" class="borderRight">Rate</td>
                  <td align="center">Remark</td>
                </tr>
                <?
                $sql_order_trans="SELECT * FROM ms_order_master mom, ms_order_transaction mot WHERE mom.order_id = mot.order_id AND mom.order_id ='".$PageKeyValue."'";
                $res_order_trans=mysql_query($sql_order_trans);
                $rc_trans=mysql_num_rows($res_order_trans);
                if($rc_trans>0)
                {
									$j=$i*$no_of_rec_show;
									mysql_data_seek($res_order_trans,$j);
									$k=0;
                  while($row_t=mysql_fetch_array($res_order_trans))

                  {
                  ?>
                  <tr class="particulars">
                    <td align="center" class="borderRight" valign="top">
											<?= $countTrans++?>
                    </td>
                    <td align="left" class="borderRight" style="padding-left:2px" valign="top">
                      <div style="height:24px;overflow:hidden">
                      <?
                      $sql_item="select * from ms_item_master where item_id=$row_t[item_id]";
                      $res_item=mysql_query($sql_item);
                      $row_item=mysql_fetch_array($res_item);
                      echo $row_item['name'];
                      ?>
                      </div>
                    </td>
                    <td align="center" class="borderRight" valign="top">
                    <? 
                      $id = $row_t['item_id'];
                      $sql = "SELECT * FROM  ms_item_master where item_id = '$id' order by name ";
                      $result_item = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
                      $uname='';
                      if(mysql_num_rows($result_item)>0)
                      {
                        $row_item = mysql_fetch_array($result_item);
                        $sql_uom = "SELECT name as uname FROM  ms_uom where uom_id = '".$row_item['uom_id']."' order by name ";
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
                    <td align="center" class="borderRight" valign="top"><?=$row_t['po_qty']?></td>
                    <td align="center" class="borderRight" valign="top"><?=$row_t['rate']?></td>
                    <td align="left" style="padding-left:2px" valign="top">
                    	<div style="height:24px;overflow:hidden">
                      	<?=$tc_remarks ?>
                      </div>
                    </td>
                  </tr>
                  <?
                  if($k==($no_of_rec_show-1))
                  {
                    break;
                  }
                  $k++;
                }
              }
              for($l=$k;$l<=$no_of_rec_show;$l++)
              {
              ?>
              <tr style="height:28px">
                <td class="borderRight borderLeft" align="center">&nbsp;</td>
                <td class="borderRight" align="center">&nbsp;</td>
                <td class="borderRight" align="center">&nbsp;</td>
                <td class="borderRight" align="center">&nbsp;</td>
                <td class="borderRight" align="center">&nbsp;</td>
                <td align="center">&nbsp;</td>
              </tr>
							<?
               }
              ?>
              </table>
            </td>
          </tr>
       	</tbody>
        <tfoot>
          <tr>
            <td align="left" class="borderTop">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr height="25px">
                  <td><b style="font-size:12px">&nbsp;<u>Terms And Conditions :</u></b></td>
                </tr>
                <tr>
                  <td class="note">
                    <table width="100%" border="0" cellspacing="2" cellpadding="0">
                      <tr>
                        <td align="left" width="20%">&nbsp;1. Billing Address</td>
                        <td align="left" width="2%">&nbsp;<b>:</b>&nbsp;</td>
                        <td align="left" width="78%"><b><?= $tc_billing_address ?></b></td>
                      </tr>
                      <tr>
                        <td align="left" width="20%">&nbsp;2. Payment Terms</td>
                        <td align="left" width="2%">&nbsp;<b>:</b>&nbsp;</td>
                        <td align="left" width="78%"><b><?= $tc_payment_terms ?></b></td>
                      </tr>
                      <tr>
                        <td align="left" width="20%">&nbsp;3. Delivery </td>
                        <td align="left" width="2%">&nbsp;<b>:</b>&nbsp;</td>
                        <td align="left" width="78%"><b><?= $tc_delivery ?></b></td>
                      </tr>
                      <tr>
                        <td align="left" width="20%">&nbsp;4. Delivery Address</td>
                        <td align="left" width="2%">&nbsp;<b>:</b>&nbsp;</td>
                        <td align="left" width="78%"><b><?= $tc_delivery_address ?></b></td>
                      </tr>
                      <tr>
                        <td align="left" width="20%">&nbsp;5. Freight</td>
                        <td align="left" width="2%">&nbsp;<b>:</b>&nbsp;</td>
                        <td align="left" width="78%"><b><?= $tc_freight ?></b></td>
                      </tr>
                      <tr>
                        <td align="left" width="20%">&nbsp;6. Errection</td>
                        <td align="left" width="2%">&nbsp;<b>:</b>&nbsp;</td>
                        <td align="left" width="78%"><b><?= $tc_errection ?></b></td>
                      </tr>
                      <tr>
                        <td align="left" width="20%">&nbsp;7. P & F</td>
                        <td align="left" width="2%">&nbsp;<b>:</b>&nbsp;</td>
                        <td align="left" width="78%"><b><?= $tc_p_and_f ?></b></td>
                      </tr>
                      <tr>
                        <td align="left" width="20%">&nbsp;8. Ex. & Taxes</td>
                        <td align="left" width="2%">&nbsp;<b>:</b>&nbsp;</td>
                        <td align="left" width="78%"><b><?= $tc_excise_and_taxes ?></b></td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td class="borderBottom">
              <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                  <td align="left"><b style="font-size:14px">&nbsp;<u>Note:</u></b></td> 
                </tr>
                <tr>
                  <td class="note">
                    &nbsp;1. The above goods must be delivered as per terms and conditions otherwise we will reject/cancel the order.<br />
                    &nbsp;2. Payment is subject to approval / verification of goods maintained by overselves.<br />
                    &nbsp;3. All goods / materials should be strictly in confirmity with the order or else shall be rejected.<br />
                    &nbsp;4. We have no liabilities for rejected goods.<br />
                    &nbsp;5. Packing of goods must be damage proof, if any damage or leakage of goods may be returnable.<br />
                    &nbsp;6. Delivery schedule be strictly followed to avoid any rejection / deduction in price.<br />
                  </td> 
                </tr>
                <tr height="35px">
                  <td align="left">&nbsp;Thanking You,</td> 
                </tr>
                <tr>
                  <td align="left">&nbsp;Yours faithfully,</td> 
                </tr>
                <tr>
                  <td align="left">
                    <b>&nbsp;For Mahima Purespun</b><br />
                  &nbsp;<span style="font-size:13px">(A unit of Mahima Fibres P.Ltd.)</span> </td> 
                </tr>
                <tr height="50px"> 
                  <td align="left" style="padding-bottom:5px" valign="bottom">&nbsp;(Authorised Signatory)</td>
                </tr>
              </table>
            </td>
          </tr>
          <tr height="30px">
            <td align="center" style="font-size:12px;font-weight:bold">
              Factory : Plot No. 73-74, Sector-II, Pithampur, Distt. Dhar.
            </td>
          </tr>
        </tfoot>
			</table>
		</div>
		<p class="break"></p>
   <?
   	}
 ?>                
</body>
</html>
