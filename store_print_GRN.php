<?
include("inc/dbconnection.php");
include("inc/store_function.php");
$PageFor = "GRN";
$PageKey = "GRN_id";
$PageKeyValue = "";
$Message = "";

$supplier_id='';
$GRN_id='';
$dc_no='';
$dc_date='';
$grn_date='';
$inv_no='';
$inv_date='';
$othersamount='';$grossamount='';$netamount='';$remarks='';

$po_no='';$ind_no='';$po_qty='';$pend_qty='';$rec_qty='';$ecess_qty='';$short_qty='';$acc_qty='';
$godown='';$rate='';$disc_perc='';$p_and_f='';$duty_perc='';$ecess_perc='';
$vat_perc='';$sc_perc='';$add_amt='';$less_amt='';$net_rate='';


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
		$gross_amount=$row['gross_amount'];$othersamount=$row['others_amount'];
		$netamount=$row['net_amount'];$totalamount=$row['total_amount'];
	}
}
?>
<?
if(isset($_GET["GRN_id"]))
{
	$GRN_id = $_GET["GRN_id"];
}
$sql_count = "select count(*) as count from ms_GRN_master,ms_GRN_transaction 
where ms_GRN_master.GRN_id=ms_GRN_transaction.GRN_id and ms_GRN_master.GRN_id='".$GRN_id."'";
$result_count = mysql_query($sql_count) or die ("Invalid query : ".$sql_count."<br>".mysql_errno()." : ".mysql_error());
$row_count = mysql_fetch_array($result_count);
$numrows = $row_count['count'];
$no_of_rec_show=15;
$count = ceil($numrows/$no_of_rec_show);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Goods Received Entry</title>
<style>
.note
{
font: Arial, Helvetica, sans-serif;
font-size:13px;
}
.particulars
{
font: Arial, Helvetica, sans-serif;
font-size:11px;
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
                <td align="center" colspan="2"><b style="font-size:24px;">MAHIMA PURESPUN</b></td>
              </tr>
              <tr>
                <td colspan="2" align="center">
                  (A UNIT OF MAHIMA FIBRES PVT. LTD.)<br />
                  Factory : PLOT No. 73 - 74 SECTOR-II, PITHAMPUR, DISTT. DHAR<br />
                  Phones : 07292 416300-328 Fax :07292 252985<br />
                  Tin No. : 23390904470&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C.S.T. No. :&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
              </tr>
            </table>    
            </td>
          </tr>
          <tr>
            <td>
              <table align="center" width="100%" border="0" cellspacing="0" cellpadding="2" class="tblborder">
                <tr>
                  <td align="center" class="borderTop borderBottom">
                    <b style="font-size:20px">GOODS RECEIVED NOTE</b>
                  </td>
                </tr>
                <tr>
                  <td align="center" class="borderBottom">
                    <table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr>
                        <td align="left" width="25%"><b>No.:</b></td>
                        <td align="left" width="25%" class="borderRight"><?= $GRN_id ?></td>
                        <td align="left" width="25%"><b>Date :</b></td>
                        <td align="left" width="25%"><?= $grn_date ?></td>
                      </tr>
                    </table>
                  </td>
                </tr>
            </table>
            </td>
          </tr>
          <tr>
            <td align="left">
              <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                  <td align="left"><b>Received From:</b></td>
                </tr>
                <tr>
                   <td class="note" style="padding-left:45px">
                      <?
                      $sql_sup="select * from ms_supplier where supplier_id=$supplier_id";
                      $res_sup=mysql_query($sql_sup);
                      $row_sup=mysql_fetch_array($res_sup);
                      echo '<b>'.$row_sup['name'].'</b><br />';
                      echo $row_sup['address'];
                      ?>
                    </td>
                </tr>
              </table>
            </td>
          </tr>
        </thead>
         <tfoot>
            <tr>
              <td align="left" class="borderTop" style="padding-top:5px;padding-bottom:5px">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="35%" class="note" valign="top" align="left">
                      <table width="100%" border="0" cellspacing="2" cellpadding="0">
                        <tr>
                          <td align="left"><b>DC No. </b></td>
                          <td><b>:</b></td>
                          <td align="left"><?= $dc_no ?></td>
                        </tr>
                        <tr>
                          <td align="left"><b>DC Date </b></td>
                          <td><b>:</b></td>
                          <td align="left"><?= $dc_date ?></td>
                        </tr>
                        <tr>
                          <td align="left"><b>Inv No. </b></td>
                          <td><b>:</b></td>
                          <td align="left"><?=$inv_no?></td>
                        </tr>
                        <tr>
                          <td align="left"><b>Inv. Date </b></td>
                          <td><b>:</b></td>
                          <td align="left"><?= $inv_date ?></td>
                        </tr>
                        <tr>
                          <td align="left"><b>Purpose </b></td>
                          <td><b>:</b></td>
                          <td align="left"><?= $remarks ?></td>
                        </tr>
                      </table>
                    </td>
                    <td width="20%" align="center">&nbsp;</td>
                    <td width="45%" class="note" valign="top" align="right">
                      <table width="100%" border="0" cellspacing="2" cellpadding="0">
                        <tr>
                          <td align="left"><b>Gross Amount </b></td><td><b>:</b></td>
                          <td align="right" style="padding-right:15px">
														<?= number_format($gross_amount,2,'.','')?>
                          </td>
                        </tr>
                        <tr>
                          <td align="left"><b>Disc Amount </b></td><td><b>:</b></td>
                          <td align="right" style="padding-right:15px">
														<?= number_format($disc_amount,2,'.','')?>
                          </td>
                        </tr>
                        <tr>
                          <td align="left"><b>Others Amount </b></td><td><b>:</b></td>
                          <td align="right" style="padding-right:15px"><?= number_format($othersamount,2,'.','')?></td>
                        </tr>
                        <tr>
                          <td align="left"><b>Duty Amount </b></td><td><b>:</b></td>
                          <td align="right" style="padding-right:15px"><?= number_format($duty_amount,2,'.','')?></td>
                        </tr>
                        <tr>
                          <td align="left"><b>E.Cess Amount </b></td><td><b>:</b></td>
                          <td align="right" style="padding-right:15px"><?= number_format($ecess_amount,2,'.','')?></td>
                        </tr>
                        <tr>
                          <td align="left"><b>VAT Amount </b></td><td><b>:</b></td>
                          <td align="right" style="padding-right:15px"><?= number_format($vat_amount,2,'.','')?></td>
                        </tr>
                        <tr>
                          <td align="left" class="borderTop" style="padding-top:5px">
                            <b>Net Amount </b>
                          </td>
                          <td><b>:</b></td>
                          <td align="right" class="borderTop" style="padding-right:15px;padding-top:5px">
                            <?= number_format($totalamount,2,'.','')?>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td class="borderTop">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr height="80px">
                   <td align="right" valign="bottom"><b>For MAHIMA PURESPUN&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                  </tr>
                  <tr height="10px"><td></td></tr>
                  <tr>
                    <td align="right">(A Unit Of Mahima Fibres Pvt. Ltd.)&nbsp;&nbsp;</td>
                  </tr>
                  <tr height="50px">
                    <td valign="bottom">
                      <table width="100%" border="0" cellspacing="0" cellpadding="2">
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
          </tfoot>
        <tbody>
          <tr>
            <td>
              <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" class="tblborder">
                 <tr style="font-size:13px;font-weight:bold" class="borderBottom borderTop">
                  <td align="center" class="borderRight" width="6%">S.No.</td>
                  <td align="center" class="borderRight" width="43%">Particulars</td>
                  <td align="center" class="borderRight" width="12%">UOM</td>
                  <td align="center" class="borderRight" width="8%">Po. No.</td>
                  <td class="borderRight" align="center" width="9%">Qty.</td>
                  <td align="center" class="borderRight" width="10%">Rate</td>
                  <td align="center" width="12%">Amount</td>
                </tr>
                <?
                 $sql_GRN_trans="SELECT * FROM ms_GRN_master mgm,ms_GRN_transaction mgt WHERE mgm.GRN_id=mgt.GRN_id AND mgm.GRN_id ='".$PageKeyValue."'";
              $res_GRN_trans=mysql_query($sql_GRN_trans);
              //$countTrans=1;
              $rc_trans=mysql_num_rows($res_GRN_trans);
              if($rc_trans>0)
              {
              //$countTrans=1;
              $j=$i*$no_of_rec_show;
              mysql_data_seek($res_GRN_trans,$j);
              $k=0;
              while($row_t=mysql_fetch_array($res_GRN_trans))
              {
              ?>
                <tr class="particulars">
                  <td align="center" class="borderRight"><?= $countTrans++?></td>
                  <td align="left" style="padding-left:2px;" class="borderRight">
                    <div style="height:15px;overflow:hidden"><?
                    $sql_item="select * from ms_item_master where item_id=$row_t[item_id]";
                    $res_item=mysql_query($sql_item);
                    $row_item=mysql_fetch_array($res_item);
                    echo $row_item['name'].' Drg No. '.$row_item['drawing_number'].'Cat No. '.$row_item['catelog_number'];
                    ?></div>
                  </td>
                  <td align="center" class="borderRight">
                  <? 
                    $id = $row_t['item_id'];
                    $sql = "SELECT * FROM  ms_item_master where item_id = '$id' order by name ";
                    $result_item = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
                    $uname='';
                    if(mysql_num_rows($result_item)>0)
                    {
                      $row_item = mysql_fetch_array($result_item);
                      $sql_uom = "SELECT name as uname FROM  ms_uom where uom_id = '".$row_item['uom_id']."' order by name ";
                      $result_uom =mysql_query ($sql_uom) or die ("Error in : ".$sql_uom."<br>".mysql_errno()." : ".mysql_error());
                      if(mysql_num_rows($result_uom)>0)
                      {
                        $row_uom = mysql_fetch_array($result_uom);
                        $uname= $row_uom['uname'];
                      }
                    }
                    echo $uname;
                    ?>
                  </td>
                  <td align="center" class="borderRight"><?=$row_t['order_id']?></td>
                  <td align="center" class="borderRight"><?=$row_t['rec_qty']?></td>
                  <td align="center" class="borderRight"><?=$row_t['rate']?></td>
                  <td align="center"><? echo $amt=$row_t['rate']*$row_t['rec_qty']?></td>
                </tr>
                <?
                  if($k==($no_of_rec_show-1))
                  {
                    break;
                  }
                  $k++;
                }
              }
              for($l=$k;$l<$no_of_rec_show;$l++)
              {
              ?>
              <tr class="particulars">
                <td class="borderRight" align="center">&nbsp;</td>
                <td class="borderRight" align="center">&nbsp;</td>
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
      </table>
    </div>
		<p class="break"></p>
   <?
   	}
   ?>
</body>
</html>