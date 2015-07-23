<?
include("inc/store_function.php");
include("inc/dbconnection.php");
?>
<?
$Page = "store_view_GRN.php";
$PageTitle = "View GRN";
$PageFor = "GRN";
$PageKey = "GRN_id";
$PageKeyValue = "";
$Message = "";

$type_of_form='';
$cash='';
$supplier_id='';
$GRN_id='';
$dc_no='';
$dc_date='';
$grn_date='';
$inv_no='';
$inv_date='';//$gp_no='';$gp_date='';
$disc_amount='';$duty_amount='';$vat_amount='';$ecess_amount='';
$othersamount='';$grossamount='';$netamount='';$remarks='';
$po_no='';$ind_no='';$po_qty='';$pend_qty='';$rec_qty='';$ecess_qty='';$short_qty='';$acc_qty='';
$rate='';$disc_perc='';$p_and_f='';$duty_perc='';$ecess_perc='';$vat_perc='';$sc_perc='';$add_amt='';$net_rate='';
if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_GRN_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row=mysql_fetch_array($result);
		$PageKeyValue=$row['GRN_id'];$GRN_id=$row['GRN_id'];
		$supplier_id=$row['supplier_id'];$order_id=$row['order_id'];
		$grn_date=getDateFormate($row['GRN_date']);
		$dc_no=$row['dc_number'];$dc_date=getDateFormate($row['dc_date']);
		$inv_no=$row['inv_number'];$inv_date=getDateFormate($row['inv_date']);
		$remarks=$row['remarks'];$disc_amount=$row['disc_amount'];$duty_amount=$row['duty_amount'];
		$vat_amount=$row['vat_amount'];$ecess_amount=$row['ecess_amount'];
		$grossamount=$row['gross_amount'];$othersamount=$row['others_amount'];
		$netamount=$row['net_amount'];$totalamount=$row['total_amount'];
	}
}
?>
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
  <tr>
    <td align="center" valign="top" class="border" width="100%" bgcolor="#EAE3E1">
      <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
        <tr style="line-height:22px;background:#EAE3E1;">
          <td align="left"><b>GRN NO.</b></td>
          <td align="left"><?=$GRN_id ?></td>
          <td align="left" valign="top"><b>GRN Date</b></td>
          <td align="left"><?= $grn_date ?></td>
        </tr>
        <tr style="line-height:22px;background:#FFFFFF;">
          <td align="left"><b>Supplier Name</b></td>
          <td align="left" colspan="3">
              <?
              $sql_sup= "select * from ms_supplier where supplier_id='".$supplier_id."'";
              $res_sup = mysql_query ($sql_sup) or die (mysql_error());                                	$row_sup = mysql_fetch_array($res_sup);
              echo $row_sup['name']; 
              ?>
          </td>
        </tr>
        <tr style="line-height:22px;background:#EAE3E1;">
          <td align="left"><b>DC No.</b></td>
          <td align="left"><?= $dc_no ?></td>
          <td align="left"><b>DC Date</b></td>
          <td align="left"><?= $dc_date ?></td>
        </tr>
        <tr style="line-height:22px;background:#FFFFFF;">
          <td align="left"><b>Inv. No</b></td>
          <td align="left"><?= $inv_no ?></td>
          <td align="left"><b>Inv. Date</b></td>
          <td align="left"><?= $inv_date ?></td>
        </tr>
        <tr style="line-height:22px;background:#EAE3E1;">
            <td align="left"><b>PO No.</b></td>
            <td align="left" colspan="3"><?='<b>'.$order_id.'</b>'?></td>
         </tr>
      </table>
    </td>
  </tr>
  <tr>   
    <td align="center">
      <div id="myDataBaseDiv">
      <?
        $sql_trans="SELECT * FROM ms_GRN_master sm,ms_GRN_transaction st WHERE sm.GRN_id=st.GRN_id AND sm.GRN_id ='".$PageKeyValue."'";
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
              $sql_order="SELECT * FROM ms_order_transaction mgt where mgt.order_transaction_id='".$row_t['order_transaction_id']."'";
              $res_order=mysql_query($sql_order);
              $row_order=mysql_fetch_array($res_order);	
              $sql_indent="SELECT * FROM ms_indent_transaction mgt where mgt.indent_transaction_id='".$row_t['indent_transaction_id']."'";
              $res_indent=mysql_query($sql_indent);
              $row_indent=mysql_fetch_array($res_indent);
              ?>
                <div id="myDBDiv_<?=$countTrans?>">
                <table align="center" width="100%" cellpadding="1" cellspacing="1" class="border" border="0">
                  <tr class="text_tr" bgcolor="<?=$tableColor?>">
                    <td align="center" width="10%"><b>S. No. </b></td> 
                    <td align="center" width="40%"><b>Item Name</b></td>
                    <td align="center" width="10%"><b>UOM</b></td>
                    <td align="center" width="10%"><b>Indent Qty</b></td>
                    <td align="center" width="10%"><b>PO Qty</b></td>
                    <td align="center" width="10%"><b>Rec. Qty</b></td>
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
                    <td align="center"><?=$row_order['po_qty']?></td>
                    <td align="center"><?=$row_t['rec_qty']?></td>
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
    <td align="center" colspan="2" class="border" bgcolor="#EAE3E1">
      <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
        <tr>
          <td width="35%" valign="top">
            <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
              <tr style="line-height:22px;background:#EAE3E1;">
                <td align="left" valign="top"><b>Remarks</b></td>
                <td align="left"><?= $remarks?></td>   
              </tr>
            </table>
          </td>
          <td width="65%" valign="top">
            <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
               <tr style="line-height:22px;background:#EAE3E1;">
                <td align="left" valign="top"><b>Discount Amount</b></td>
                <td align="left"><?=$disc_amount?></td>
                <td align="left"><b>Gross Amount</b></td>
                <td align="left"><?= $grossamount?></td>
              </tr>
              <tr style="line-height:22px;background:#FFFFFF;">
                <td align="left" valign="top"><b>Duty Amount</b></td>
                <td align="left"><?= $duty_amount ?></td>
                <td align="left"><b>Others Amount</b></td>
                <td align="left"><?= $othersamount?></td>
              </tr>
              <tr style="line-height:22px;background:#EAE3E1;">
                <td align="left" valign="top"><b>Vat Amount</b></td>
                <td align="left"><?= $vat_amount ?></td>
                <td align="left"><b>Net Amount</b></td>
                <td align="left"><?=$netamount?></td>
              </tr>
              <tr style="line-height:22px;background:#FFFFFF;">
                <td align="left" valign="top"><b>Ecess Amount</b></td>
                <td align="left"><?= $ecess_amount ?></td>
                <td align="left"><b>Total Amount</b></td>
                <td align="left"><?=$totalamount?></td>
              </tr>
            </table>
          </td>
      	</tr>
      </table>
    </td>
  </tr>
</table>
    