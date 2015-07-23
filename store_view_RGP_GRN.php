<?
include("inc/store_header.php");
?>
<?
$Page = "store_add_RGP_GRN.php";
$PageTitle = "View RGP GRN";
$PageFor = "RGP GRN";
$PageKey = "RGP_GRN_id";
$PageKeyValue = "";
$Message = "";

$RGP_GRN_id='';$RGP_GRN_date='';$department_id='';$supplier_id='';
$dc_no='';$dc_date='';$inv_no='';$inv_date='';$gp_no='';$gp_date='';
$othersamount='';$grossamount='';$netamount='';$purpose='';

$item_id='';$RGP_no='';$purpose_trans='';$RGP_qty='';$pend_qty='';$rec_qty='';
$rate='';$vat_perc='';$add_amt='';$net_rate='';

if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_RGP_GRN_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row=mysql_fetch_array($result);
		$PageKeyValue=$row['RGP_GRN_id'];$RGP_GRN_id=$row['RGP_GRN_id'];
		$supplier_id=$row['supplier_id'];
		$RGP_GRN_date=getDateFormate($row['RGP_GRN_date']);
		$RGP_id=$row['RGP_id'];
		$dc_no=$row['dc_number'];$dc_date=getDateFormate($row['dc_date']);
		$inv_no=$row['inv_number'];$inv_date=getDateFormate($row['inv_date']);
		$gp_no=$row['gp_number'];$gp_date=getDateFormate($row['gp_date']);
		$purpose=$row['purpose'];$grossamount=$row['gross_amount'];$vatamount=$row['vat_amount'];
		$othersamount=$row['others_amount'];$netamount=$row['net_amount'];
	}
}
?>

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
	<tr>
		<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/store_snb.php"); ?>
		</td>
		<td style="padding-left:5px; padding-top:5px;" valign="top">
			<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
				<tr>
					<td align="center" class="gray_bg">
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; View RGP GRN
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
                	<a target="_blank" href="store_print_RGP_GRN.php?RGP_GRN_id=<?= $PageKeyValue?>" title="Print">Print&nbsp;&nbsp;&nbsp;</a>
                </td>
              </tr>
							<tr>
								<td valign="top" style="padding-bottom:5px;">
                    <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                      <tr>
                      	<td align="center" valign="top" class="border" width="100%" bgcolor="#EAE3E1">
                      		<table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                      			<tr style="line-height:22px;background:#EAE3E1;">
                    					<td align="left"><b>RGP GRN NO.</b></td>
                    					<td align="left"><?= $RGP_GRN_id ?></td>
                              <td align="left"><b>RGP GRN Date</b></td>
                              <td align="left"><?=$RGP_GRN_date?></td>
                    				</tr>
                            <tr style="line-height:22px;background:#FFFFFF;">
                              <td align="left"><b>Supplier Name</b></td>
                              <td align="left" colspan="3">
																<?
                                $sql_sup= "select * from ms_supplier WHERE supplier_id=$supplier_id";
                                $res_sup = mysql_query ($sql_sup) or die (mysql_error());
                                if(mysql_num_rows($res_sup)>0)
                                {
                                  $row_sup = mysql_fetch_array($res_sup);
                                  echo $row_sup['name'];
                                }
                                ?>
                               </td>
                            </tr>
                    				<tr style="line-height:22px;background:#EAE3E1;">
                              <td align="left"><b>DC No.</b></td>
                              <td align="left"><?= $dc_no ?></td>
                              <td align="left"><b>DC Date</b></td>
                              <td align="left"><?=$dc_date ?></td>
                            </tr>
                            <tr style="line-height:22px;background:#FFFFFF;">
                              <td align="left"><b>Inv. No</b></td>
                              <td align="left"><?= $inv_no ?></td>
                              <td align="left"><b>Inv. Date</b></td>
                              <td align="left"><?=$inv_date ?></td>
                          	</tr>
                            <tr style="line-height:22px;background:#EAE3E1;">
                              <td align="left"><b>GP. No.</b></td>
                              <td align="left"><?= $gp_no ?></td>
                              <td align="left"><b>GP Date</b></td>
                              <td align="left"><?=$gp_date ?></td>
                          	</tr>
                            <tr style="line-height:22px;background:#FFFFFF;">
                              <td align="left"><b>RGP No.</b></td>
                              <td align="left" colspan="3"><?=$RGP_id?></td>
                          	</tr>
                        	</table>
                    		</td>
										</tr>
                      <tr>   
                        <td>
                          <div id="myDataBaseDiv">
                          <?
                          $sql_GRN_trans="SELECT * FROM ms_RGP_GRN_master mrgm,ms_RGP_GRN_transaction mrgt WHERE mrgm.RGP_GRN_id=mrgt.RGP_GRN_id AND mrgm.RGP_GRN_id ='".$PageKeyValue."'";
                          $res_GRN_trans=mysql_query($sql_GRN_trans);
                          $countTrans=1;
                          $rc_trans=mysql_num_rows($res_GRN_trans);
                          if($rc_trans>0)
                          {													
                            while($row_t=mysql_fetch_array($res_GRN_trans))
                            {
                              if($countTrans%2==0)
                                $tableColor="#eedfdc";
                              else
                                $tableColor="#f8f1ef";
                              $sql_tr="SELECT * FROM ms_RGP_transaction mgt where mgt.RGP_transaction_id='".$row_t['RGP_transaction_id']."'";
                              $res_tr=mysql_query($sql_tr);
                              $row_tr=mysql_fetch_array($res_tr);
                              ?>
                            <div id="myDBDiv_<?=$countTrans?>">
                              <table align="center" width="100%" cellpadding="1" cellspacing="1" class="border" border="0">
                                <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                  <td align="center" width="5%"><b>S. No. </b></td>                               
                                  <td align="center" width="15%"><b>Department</b></td>
                                  <td align="center" width="30%"><b>Item Name</b></td>
                                  <td align="center" width="10%"><b>UOM</b></td>
                                  <td align="center" width="30%"><b>Purpose</b></td>
                                  <td align="center" width="10%"><b>RGP. Qty</b></td>
                                </tr>
                                <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                  <td align="center"><?=$countTrans ?></td>
                                  <td align="center">
                                   <?
                                    $sql_D="select * from ms_department where department_id=$row_tr[department_id]";
                                    $res_D=mysql_query($sql_D);
                                    $row_D=mysql_fetch_array($res_D);
                                    echo $row_D['name'];
                                    ?>
                                  </td>
                                  <td align="left" style="padding-left:5px"><?=$row_tr['item_name']?></td>                                	<td align="center">
                                    <? 
                                      $sql_uom = "SELECT name as uname FROM  ms_uom where uom_id =$row_tr[uom_id]";
                                      $result_uom = mysql_query ($sql_uom) or die (mysql_error());
                                      if(mysql_num_rows($result_uom)>0)
                                      {
                                        $row_uom = mysql_fetch_array($result_uom);
                                        echo $row_uom['uname'];
                                      }
                                    ?>
                                  </td>
                                  <td align="left" style="padding-left:5px"><?= $row_tr['remarks']?></td>
                                  <td align="center"><?= $row_tr['quantity']?></td>
                                </tr>
                                <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                  <td align="center"><b>Rec. Qty</b></td>
                                  <td align="center"><b>Pend. Qty</b></td>
                                  <td align="center"><b>Rate</b></td>
                                  <td align="center"><b>VAT%</b></td>
                                  <td align="center"><b>Net Rate</b></td>
                                  <td align="center">&nbsp;</td>
                                </tr>
                                <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                  <td align="center"><?=$row_t['rec_qty']?></td>
                                  <td align="center"><?=$row_tr['pend_qty']?></td>
                                  <td align="center"><?= $row_t['rate']?></td>
                                  <td align="center"><?= $row_t['vat_perc']?></td>
                                  <td align="center"><?= $row_t['net_rate']?></td>
                                  <td align="center">&nbsp;</td>
																</tr> 
                              </table>
                            </div>
                            <?
                            $countTrans++;
                            }
                          }?>
                          </div>
                          </td>
                        </tr>
                      <tr>
                        <td align="center" colspan="2" class="border" bgcolor="#EAE3E1">
                          <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                            <tr>
                              <td width="50%" valign="top">
                                <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                                  <tr style="line-height:22px;background:#EAE3E1;">
                                    <td align="left" valign="top"><b>Purpose</b></td>
                                    <td align="left"><?= $purpose?></td>   
                                  </tr>
                                </table>
                              </td>
                              <td width="50%" valign="top">
                                <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                                   <tr style="line-height:22px;background:#EAE3E1;">
                                    <td align="left"><b>Gross Amount</b></td>
                                    <td align="left"><?= $grossamount?></td>
                                   </tr>
                                   <tr style="line-height:22px;background:#FFFFFF;">
                                    <td align="left"><b>Vat Amount</b></td>
                                    <td align="left"><?= $vatamount?></td>
                                   </tr>
                                   <tr style="line-height:22px;background:#EAE3E1;">
                                    <td align="left"><b>Others Amount</b></td>
                                    <td align="left"><?= $othersamount?></td>
                                   </tr>
                                   <tr style="line-height:22px;background:#FFFFFF;">
                                    <td align="left"><b>Net Amount</b></td>
                                    <td align="left"><?= $netamount?></td>
                                   </tr> 
                                </table>
                              </td>
                          </tr>
                          </table>
                        </td>
                      </tr>
                  		
                 		</table>
								</td><!-- End Of Main Content -->
							</tr>
						</table> 
					</td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<? 
include("inc/hr_footer.php");
?>