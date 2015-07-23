<?
include("inc/store_header.php");
?>
<style>
.get_H_18_W_60
{
	height:18px;
	width:60px;
}
</style>
<script type="text/javascript">
function overlay(MasterId,RecordId) 
{
	e1 = document.getElementById("overlay");
	document.getElementById("hidden_overlay_master").value=MasterId;
	document.getElementById("hidden_overlay").value=RecordId;
	e1.style.visibility = (e1.style.visibility == "visible") ? "hidden" : "visible";	
}
</script>
<?

$Page = "store_add_purchase_order.php";
$PageTitle = "View Purchase Order";
$PageFor = "Purchase Order";
$PageKey = "order_id";

$Message = "";

$po_type_select='';$order_date='';$supplier_id='';$indent_id='';$purchase_order_date='';$purchase_order_type='';

$tc_billing_address='';$tc_delivery_address='';$tc_payment_terms='';$tc_delivery='';
$tc_delivery_date='';$tc_errection='';$tc_freight='';
$tc_excise_and_taxes='';$tc_p_and_f='';$tc_remarks='';

$cal_gross_amt='';$cal_disc_amt='';$cal_duty_amount='';$cal_vat_amt='';$cal_ecess_amt='';
$cal_pack_fowd_amt='';
$cal_round_off='';$cal_total_amt='';$cal_net_amt='';
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
		$supplier_id=$row['supplier_id'];$indent_id=$row['indent_id'];
	
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
?>

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
    <? include ("inc/store_snb.php"); ?>
    </td>
    <td style="padding-left:5px;padding-top:5px;" valign="top">
      <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
      	<tr>
         	<td align="center" class="gray_bg">
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; View Purchase Order
          </td>
        </tr>
        <tr>
        	<td valign="top" style="padding-top:10px;">
           	<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
             	<tr>
               	<td class="red"><?=$Message?></td>
              </tr>
              <tr>
                <td class="AddMore">
                   <a target="_blank" href="store_print_purchase_order.php?order_id=<?= $PageKeyValue?>" title="Print">Print&nbsp;&nbsp;&nbsp;</a>
                </td>
              </tr>
              <tr>
                <td valign="top" style="padding-bottom:5px;">
                  <table width="100%" cellpadding="1" cellspacing="1" align="center" border="0" class="border">
                    <tr>
                      <td bgcolor="#EAE3E1">
                        <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_12">
                          <tr style="line-height:22px;background:#EAE3E1;">
                            <td align="left"><b>PO No.</b></td>
                             <td align="left"><?= $order_id ?></td>
                             <td align="left"><b>PO Date</b></td>
                             <td align="left"><?= $order_date?></td>
                          </tr>
                          <tr style="line-height:22px;background:#FFFFFF;">
                            <td align="left"><b>PO Type</b></td>
                            <td align="left">
                                <?
                                $sql_po="select * from ms_po_type where po_type_id='".$po_type_select."'";
                                $res_po=mysql_query($sql_po);
                                $row_po=mysql_fetch_array($res_po);
                                echo $row_po['name'];
                                ?>
                            </td>
                            <td align="left"><b>Supplier</b></td>
                            <td align="left">
                                <?
                                  $sql_sup="select * from ms_supplier where supplier_id='".$supplier_id."'";
                                  $res_sup=mysql_query($sql_sup);
                                  $row_sup=mysql_fetch_array($res_sup);
                                  echo $row_sup['name'];
                                ?>
                            </td>
                          </tr>
                          <tr style="line-height:22px;background:#EAE3E1;">
                            <td align="left"><b>Indent No.</b></td>
                            <td align="left" colspan="3"><?=$indent_id?></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div id="myDataBaseDiv">
                          <?
                          $sql_trans="SELECT * FROM ms_order_master sm,ms_order_transaction st WHERE sm.order_id=st.order_id AND sm.order_id ='".$PageKeyValue."'";
                          $res_trans=mysql_query($sql_trans);
                          $countTrans=1;
                          $rc_trans=mysql_num_rows($res_trans);
                          if($rc_trans>0)
                          {
                            ?>
                            <div id="divTransaction">
                            <?
                              while($row_t=mysql_fetch_array($res_trans))
                              {
                                if($countTrans%2==0)
                                  $tableColor="#eedfdc";
                                else
                                  $tableColor="#f8f1ef";
                                  
                                $sql_indent="SELECT * FROM ms_indent_transaction mgt where mgt.indent_transaction_id='".$row_t['indent_transaction_id']."'";
                                $res_indent=mysql_query($sql_indent);
                                $row_indent=mysql_fetch_array($res_indent);
                                ?>
                                  <div id="myDBDiv_<?=$countTrans?>">
                                  <table align="center" width="100%" cellpadding="1" cellspacing="1" class="border" border="0">
                                    <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                      <td align="center" width="12%"><b>S. No. </b></td> 
                                      <td align="center" width="40%"><b>Item Name</b></td>
                                      <td align="center" width="12%"><b>UOM</b></td>
                                      <td align="center" width="12%"><b>Indent Qty</b></td>
                                      <td align="center" width="12%"><b>PO Qty</b></td>
                                      <td align="center" width="12%"><b>Pend Qty</b></td>
                                    </tr>
                                    <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                      <td align="center"><?=$countTrans?></td>
                                      <td align="left" style="padding-left:5px">
                                      <?
                                        $sql_IT="select * from ms_item_master where item_id='".$row_t['item_id']."'";
                                        $res_IT=mysql_query($sql_IT);
                                        $row_IT=mysql_fetch_array($res_IT);
                                        echo $row_IT['name']."; Drg No.: ".$row_IT['drawing_number'].'; Cat No. '.$row_IT['catelog_number'];
                                        $uom_id=$row_IT['uom_id'];
                                        ?>
                                      </td>
                                      <td align="center">
                                      <? 
                                      $sql_uom = "SELECT name as uname FROM  ms_uom where uom_id = '".$uom_id."' order by name ";
                                      $result_uom = mysql_query ($sql_uom) or die (mysql_error());
                                      $row_uom = mysql_fetch_array($result_uom);
                                      echo $row_uom['uname'];
                                      ?>
                                      </td>
                                      <td align="center"><?= $row_indent['required_quantity']?></td>
                                      <td align="center"><?=$row_t['po_qty']?></td>
                                      <td align="center"><?=$row_indent['pend_qty']?></td>
                                    </tr>
                                    <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                      <td align="center"><b>Rate</b></td>
                                      <td align="center"><b>Disc%</b></td>
                                      <td align="center"><b>Duty%</b></td>
                                      <td align="center"><b>E.Cess%</b></td>
                                      <td align="center"><b>ST%</b></td>
                                      <td align="center"><b>Net Rate</b></td>
                                    </tr>
                                    <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                      <td align="center"><?= $row_t['rate']?></td>
                                      <td align="center"><?= $row_t['disc_perc']?></td>
                                      <td align="center"><?= $row_t['duty_perc']?></td>
                                      <td align="center"><?= $row_t['ecess_perc']?></td>
                                      <td align="center"><?= $row_t['vat_perc']?></td>
                                      <td align="center"><?= $row_t['net_rate']?></td>
                                    </tr> 
                                  </table>
                                  </div>
                                <?			
                                $countTrans++; 													 
                              } // end of while
                               ?>
                            </div> 
                          <?
                          }// end if	
                          ?>
                        </div>
                      </td>
                    </tr>
                    <tr>
                     <td>
                      <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0" class="border">
                        <tr>
                          <td align="center" valign="top" class="border" width="45%" bgcolor="#EAE3E1">
                          <table align="left" width="100%" cellpadding="1" cellspacing="1" border="0" class="text_12">
                            <tr style="line-height:22px;background:#EAE3E1;">
                              <td align="left" valign="top"><b>Billing Address</b></td>
                              <td align="left"><?= $tc_billing_address ?></td>
                            </tr>	
                            <tr style="line-height:22px;background:#FFFFFF;">
                              <td align="left" valign="top"><b>Delivery Address</b></td>
                              <td align="left"><?= $tc_delivery_address ?></td>
                            </tr>
                            <tr style="line-height:22px;background:#EAE3E1;">
                              <td align="left"><b>Payment Terms</b></td>
                              <td align="left"><?= $tc_payment_terms ?></td>
                            </tr>
                            <tr style="line-height:22px;background:#FFFFFF;">
                              <td align="left" valign="top"><b>Delivery</b></td>
                              <td align="left"><?= $tc_delivery ?></td>
                            </tr>
                            <tr style="line-height:22px;background:#EAE3E1;">
                              <td align="left" valign="top"><b>Date Of Delivery</b></td>
                              <td align="left"><?= $tc_delivery_date ?></td>
                            </tr>
                            <tr style="line-height:22px;background:#FFFFFF;">
                              <td align="left"><b>Errection</b></td>
                              <td align="left"><?= $tc_errection?></td>
                            </tr>
                            <tr style="line-height:22px;background:#EAE3E1;">
                              <td align="left"><b>Freight</b></td>
                              <td align="left"><?= $tc_freight?></td>
                            </tr>
                            <tr style="line-height:22px;background:#FFFFFF;">
                            <td align="left"><b>P & F.</b></td>
                            <td align="left"><?= $tc_p_and_f?></td>
                          </tr>
                          <tr style="line-height:22px;background:#EAE3E1;">
                            <td align="left"><b>Ex. & Taxes.</b></td>
                            <td align="left"><?= $tc_excise_and_taxes?></td>
                          </tr>
                            <tr style="line-height:22px;background:#FFFFFF;">
                              <td align="left" valign="top"><b>Remarks</b></td>
                              <td align="left"><?= $tc_remarks?></td>
                            </tr> 
                          </table>
                        </td>                                
                        <td align="left" valign="top" class="border" width="55%" bgcolor="#EAE3E1">
                           <table align="left" width="100%" cellpadding="1" cellspacing="1" border="0" class="text_12">
                              <tr style="line-height:22px;background:#EAE3E1;">
                                <td align="left" valign="top"><b>Gross Amount</b></td>
                                <td align="left"><?= $cal_gross_amt ?></td>
                                <td align="left" valign="top"><b>Pack & Forwd Amount</b></td>
                                <td align="left"><?=$cal_pack_fowd_amt?></td>
                              </tr>
                              <tr style="line-height:22px;background:#FFFFFF;">
                                <td align="left" valign="top"><b>Discount Amount</b></td>
                                <td align="left"><?=$cal_disc_amt?></td>
                                <td align="left"><b>Round Off</b></td>
                                <td align="left"><?= $cal_round_off ?></td>
                              </tr>
                              <tr style="line-height:22px;background:#EAE3E1;">
                                <td align="left" valign="top"><b>Duty</b></td>
                                <td align="left"><?= $cal_duty_amount ?></td>
                                <td align="left" valign="top"><b>Total Amount</b></td>
                                <td align="left"><?= $cal_total_amt ?></td>
                              </tr>
                              <tr style="line-height:22px;background:#FFFFFF;">
                                <td align="left" valign="top"><b>VAT</b></td>
                                <td align="left"><?= $cal_vat_amt ?></td>
                                <td align="left" valign="top"><b>Net Amount</b></td>
                                <td align="left"><?= $cal_net_amt ?></td>
                              </tr>
                              <tr style="line-height:22px;background:#EAE3E1;">
                                <td align="left" valign="top"><b>Ecess Amount</b></td>
                                <td align="left"><?= $cal_ecess_amt ?></td>
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
		</td>
	</tr>
</table>


<? 
include("inc/footer.php");
?>                           