<?
include("inc/store_header.php");
?>
<?
$Page = "store_add_bill_passing.php";
$PageTitle = "Add Bill Passing";
$PageFor = "Bill Passing";
$PageKey = "bill_pass_id";

$Message = "";
$mode='';
if(isset($_GET['mode']))
{
	$mode=$_GET['mode'];
}

/////////////////////////////////////////////////////////////////////////////////////////////
$bill_pass_id='';$bill_pass_date='';$supplier_id='';$grn_date='';$GRN_id='';$cash='';$item_id='';
$GRN_no='';$PO_no='';$rec_qty='';$acc_qty='';$rate='';$disc_perc='';$duty_perc='';$ecess_perc='';$st_perc='';$sc_perc='';
$resale_perc='';$purchase_account ='';$cash_account ='';$tax_account ='';$gross_amount ='';$disc_amount='';$duty_amount='';
$ecess_amount='';$round_off='';$total_amount='';$net_amount='';
/////////////////////////////////////////////////////////////////////////////////////////////

$PageKeyValue = "";

if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_bill_pass_master_new bp,ms_GRN_master gm where $PageKey = '".$_GET[$PageKey]."' and bp.GRN_id=gm.GRN_id";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];$bill_pass_id = $_GET["bill_pass_id"];
		$bill_pass_date=getDateFormate($row['bill_pass_date']);
		$GRN_id=$row['GRN_id'];
	}
}
?>
<?
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}
if(isset($_GET["bill_pass_id"]))
{
	$bill_pass_id = $_GET["bill_pass_id"];
}
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
    	<? include ("inc/store_snb.php"); ?>
    </td>
    <td style="padding-left:5px; padding-top:5px;"  valign="top">
      <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
      	<tr>
         	<td align="center" class="gray_bg">
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; View Bill Passing Entry
          </td>
        </tr>
        <?
				if(mysql_num_rows($result)>0)
				{
				?>
        <tr>
          <td class="AddMore">
             <a target="_blank" href="store_print_bill_passing.php?bill_pass_id=<?= $PageKeyValue?>" title="Print">Print&nbsp;&nbsp;&nbsp;</a>
          </td>
        </tr>
        <tr>
        	<td valign="top" style="padding-top:10px;">
           	<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
            
            
              <tr>
                <td align="center" valign="top" class="border" width="100%" bgcolor="#EAE3E1">
                  <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_12">
                    <tr style="line-height:22px;background:#EAE3E1;">
                      <td align="left"><b>Bill NO.</b></td>
                      <td align="left"><?=$bill_pass_id ?></td>
                      <td align="left" valign="top"><b>Bill Date</b></td>
                      <td align="left"><?= $bill_pass_date ?></td>
                    </tr>
                    <tr style="line-height:22px;background:#FFFFFF;">
                      <td align="left"><b>GRN NO.</b></td>
                      <td align="left"><?=$GRN_id ?></td>
                      <td align="left" valign="top"><b>GRN Date</b></td>
                      <td align="left"><?= getDateFormate($row['GRN_date']) ?></td>
                    </tr>
                    <tr style="line-height:22px;background:#EAE3E1;">
                      <td align="left"><b>Supplier Name</b></td>
                      <td align="left" colspan="3">
                          <?
                          $sql_sup= "select * from ms_supplier where supplier_id='".$row['supplier_id']."'";
                          $res_sup = mysql_query ($sql_sup) or die (mysql_error());                          $row_sup = mysql_fetch_array($res_sup);
                          echo $row_sup['name']; 
                          ?>
                      </td>
                    </tr>
                    <tr style="line-height:22px;background:#FFFFFF;">
                      <td align="left"><b>DC No.</b></td>
                      <td align="left"><?= $row['dc_number'] ?></td>
                      <td align="left"><b>DC Date</b></td>
                      <td align="left"><?= getDateFormate($row['dc_date']) ?></td>
                    </tr>
                    <tr style="line-height:22px;background:#EAE3E1;">
                      <td align="left"><b>Inv. No</b></td>
                      <td align="left"><?= $row['inv_number'] ?></td>
                      <td align="left"><b>Inv. Date</b></td>
                      <td align="left"><?= getDateFormate($row['inv_date']) ?></td>
                    </tr>
                    <tr style="line-height:22px;background:#FFFFFF;">
                        <td align="left"><b>PO No.</b></td>
                        <td align="left" colspan="3"><?='<b>'.$row['order_id'].'</b>'?></td>
                     </tr>
                  </table>
                </td>
              </tr>
              <tr>   
                <td align="center">
                  <div id="myDataBaseDiv">
                  <?
                    $sql_trans="SELECT * FROM ms_GRN_master sm,ms_GRN_transaction st WHERE sm.GRN_id=st.GRN_id AND sm.GRN_id ='".$row['GRN_id']."'";
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
                  <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_12">
                    <tr>
                      <td width="30%" valign="top">
                        <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_12">
                          <tr style="line-height:22px;background:#EAE3E1;">
                            <td align="left" valign="top"><b>Remarks</b></td>
                            <td align="left"><?= $row['remarks']?></td>   
                          </tr>
                        </table>
                      </td>
                      <td width="70%" valign="top">
                        <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_12">
                           <tr style="line-height:22px;background:#EAE3E1;">
                            <td align="left" valign="top"><b>Discount Amount</b></td>
                            <td align="left"><?=$row['disc_amount']?></td>
                            <td align="left"><b>Gross Amount</b></td>
                            <td align="left"><?= $row['gross_amount']?></td>
                          </tr>
                          <tr style="line-height:22px;background:#FFFFFF;">
                            <td align="left" valign="top"><b>Duty Amount</b></td>
                            <td align="left"><?= $row['duty_amount'] ?></td>
                            <td align="left"><b>Others Amount</b></td>
                            <td align="left"><?= $row['others_amount']?></td>
                          </tr>
                          <tr style="line-height:22px;background:#EAE3E1;">
                            <td align="left" valign="top"><b>Vat Amount</b></td>
                            <td align="left"><?= $row['vat_amount'] ?></td>
                            <td align="left"><b>Net Amount</b></td>
                            <td align="left"><?=$row['net_amount']?></td>
                          </tr>
                          <tr style="line-height:22px;background:#FFFFFF;">
                            <td align="left" valign="top"><b>Ecess Amount</b></td>
                            <td align="left"><?= $row['ecess_amount'] ?></td>
                            <td align="left"><b>Total Amount</b></td>
                            <td align="left"><?=$row['total_amount']?></td>
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
       	<?
				}
				else
				{
					?>
          	<tr>
            	<td align="center" class="border" bgcolor="#EAE3E1"><b>No Record Found</b></td>
            </tr>
          <?
				}
				?>
			</table> 
		</td>
	</tr>
</table>
                                   
<? 
include("inc/footer.php");
?>                           