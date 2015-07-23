<?
include("inc/dbconnection.php");
include("inc/store_function.php");
$PageFor = "GRN";
$PageKey = "GRN_id";
$PageKeyValue = "";
$Message = "";
if(isset($_REQUEST['GRN_date']))
{
	$GRN_date=getDateFormate($_REQUEST['GRN_date']);
}
else
	$GRN_date='';

$supplier_id='';
$GRN_id='';
$dc_no='';
$dc_date='';
$grn_date='';
$inv_no='';
$inv_date='';
$othersamount='';$grossamount='';$netamount='';$remarks='';

$po_no='';$ind_no='';$po_qty='';$pend_qty='';$rec_qty='';$ecess_qty='';$short_qty='';$acc_qty='';
$godown='';$rate='';$disc_perc='';$p_and_f='';$duty_perc='';$ecess_perc='';$vat_perc='';$sc_perc='';$add_amt='';$less_amt='';$net_rate='';


if(isset($_GET['GRN_date']))
{
	$sql = "select * from ms_GRN_master where GRN_date = '".$_GET['GRN_date']."'";
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
<?
if(isset($_GET["GRN_id"]))
{
	$GRN_id = $_GET["GRN_id"];
}
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
height:25px;
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
.padding_right
{
padding-right:2px;
}
</style>
</head>

<body onload="print();">
  <div style="width:99%;margin:0 auto;font:Arial, Helvetica, sans-serif;border:1px solid #000">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <thead>
        <tr height="70px">
          <td align="center">
            MAHIMA PURESPUN<br />
            Purchase Register As on <b><?= $GRN_date?></b>
          </td>
        </tr>
      </thead>
      <tbody>
      	<table align="center" width="100%" border="0" cellspacing="0" cellpadding="2" class="tblborder">
          <tr style="font-size:13px" class="borderBottom borderTop">
          	<th align="center" class="borderRight"><b>GRN No.</b></th>
            <th align="center" class="borderRight"><b>INV.No.</b></th>
            <th align="center" class="borderRight"><b>Supplier</b></th>
            <th align="center" class="borderRight"><b>Item No.</b></th>
            <th align="center" class="borderRight"><b>Item Name</b></th>
            <th align="center" class="borderRight"><b>UOM</b></th>
            <th align="center" class="borderRight"><b>Rec. Qty.</b></th>
            <th align="center" class="borderRight"><b>Rate/Unit</b></th>
            <th align="center" class="borderRight"><b>Value</b></th>
            <th align="center"><b>Net Rate</b></th>
          </tr>
          <?
					$sql_t="select ms_GRN_master.GRN_id,ms_GRN_master.GRN_date,
					ms_GRN_master.inv_number,ms_GRN_master.others_amount,ms_supplier.name as SupplierName,
					ms_uom.name as UOM,ms_item_master.name as ItemName,ms_GRN_transaction.rec_qty,
					ms_GRN_transaction.rate,ms_GRN_transaction.item_id,ms_GRN_transaction.net_rate
					FROM ms_item_master,ms_GRN_master,ms_uom,ms_GRN_transaction,ms_supplier
					where 
						ms_GRN_master.GRN_id=ms_GRN_transaction.GRN_id and ms_GRN_master.GRN_date='".getDateFormate($GRN_date)."'
						and ms_item_master.item_id=ms_GRN_transaction.item_id and ms_item_master.uom_id=ms_uom.uom_id
						and ms_GRN_master.supplier_id=ms_supplier.supplier_id
					";
					$result_t = mysql_query($sql_t) or die ("Invalid query : ".$sql_t."<br>".mysql_errno()." : ".mysql_error());
					if(mysql_num_rows($result_t)>0)
					{
					$totalNetRate=0;
						while($row_t=mysql_fetch_array($result_t))
						{
						?>
            <tr class="particulars">
              <td align="center" class="borderRight"><?= $row_t['GRN_id']?></td>
              <td align="center" class="borderRight"><?= $row_t['inv_number']?></td>
              <td align="left" style="padding-left:2px" class="borderRight"><?= $row_t['SupplierName']?></td>
              <td align="center" class="borderRight"><?= $row_t['item_id']?></td>
              <td align="left" style="padding-left:2px" class="borderRight"><?= $row_t['ItemName']?></td>
              <td align="center" class="borderRight"><?= $row_t['UOM']?></td>
              <td align="right" class="borderRight padding_right">
                <?= number_format($row_t['rec_qty'],2,'.','')?>
              </td>
              <td align="right" class="borderRight padding_right">
                <?= number_format($row_t['rate'],2,'.','')?>
              </td>
              <td align="right" class="borderRight padding_right">
                <?= number_format(($row_t['rec_qty']*$row_t['rate']),2,'.','')?>
              </td>
              <td align="right" class="padding_right">
                <?= number_format(($row_t['rec_qty']*$row_t['net_rate']),2,'.','')?>
              </td>
             </tr>
            <?
						$totalNetRate+=($row_t['rec_qty']*$row_t['net_rate']);
						}
						?>
            <tfoot>
            	<tr class="borderTop borderBottom" style="font-size:12px">
                <td colspan="8">&nbsp;</td>
                <td align="center" class="borderRight">Total</td>
                <td align="right" class="padding_right">
									<?= 'approx. '.number_format($totalNetRate,2,'.','')?>
                </td>
             </tr>
           </tfoot>
            <?
					}
					else
					{
					?>
         	 <tr><td colspan="10" align="center"><b>No Records Found</b></td></tr>
          <?
					}
					?>
        </table>
      </tbody>
    </table>
  </div>
</body>
</html>