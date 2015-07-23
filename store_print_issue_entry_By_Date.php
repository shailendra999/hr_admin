<?
include("inc/dbconnection.php");
include("inc/store_function.php");
$PageFor = "Issue Entry";
$PageKey = "IE_id";
$PageKeyValue = "";
$Message = "";
if(isset($_REQUEST['IE_date']))
{
	$IE_date=getDateFormate($_REQUEST['IE_date']);
}
else
	$IE_date='';

$supplier_id='';
$IE_id='';

if(isset($_GET['IE_date']))
{
	$sql = "select * from ms_IE_master where IE_date = '".$_GET['IE_date']."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row=mysql_fetch_array($result);
		$PageKeyValue=$row['IE_id'];$IE_id=$row['IE_id'];
		
	}
}
?>
<?
if(isset($_GET["IE_id"]))
{
	$IE_id = $_GET["IE_id"];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Issue Entry</title>
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
            Issue Entry As on <b><?= $IE_date?></b>
          </td>
        </tr>
      </thead>
      <tbody>
      	<table align="center" width="100%" border="0" cellspacing="0" cellpadding="2" class="tblborder">
          <tr style="font-size:13px" class="borderBottom borderTop">
          	<th align="center" class="borderRight"><b>Issue No.</b></th>
            <th align="center" class="borderRight"><b>Machine</b></th>
            <th align="center" class="borderRight"><b>Item No.</b></th>
            <th align="center" class="borderRight"><b>Item Name</b></th>
            <th align="center" class="borderRight"><b>UOM</b></th>
            <th align="center" class="borderRight"><b>Iss. Qty.</b></th>
            <th align="center" class="borderRight"><b>Avg Rate</b></th>
            <th align="center" class="borderRight"><b>Value</b></th>
          </tr>
          <?
					$sql_t="select ms_IE_master.IE_id,ms_IE_master.IE_date,
				  ms_uom.name as UOM,ms_item_master.name as ItemName,ms_IE_transaction.iss_qty,
					ifnull((select avg(ms_GRN_transaction.net_rate) from ms_GRN_transaction where ms_GRN_transaction.item_id = ms_item_master.item_id) , ms_item_master.opening_rate) as AvgRate,
					
					ms_IE_transaction.item_id,ms_machinary.name as Machine
					FROM ms_item_master,ms_IE_master,ms_uom,ms_IE_transaction,ms_machinary
					where 
						ms_IE_master.IE_id=ms_IE_transaction.IE_id 
						and ms_IE_master.IE_date='".getDateFormate($IE_date)."'
						and ms_item_master.item_id=ms_IE_transaction.item_id 
						and ms_item_master.uom_id=ms_uom.uom_id
						and ms_item_master.machinary_id=ms_machinary.machinary_id
					";
					$result_t = mysql_query($sql_t) or die ("Invalid query : ".$sql_t."<br>".mysql_errno()." : ".mysql_error());
					if(mysql_num_rows($result_t)>0)
					{
					$totalNetRate=0;
						while($row_t=mysql_fetch_array($result_t))
						{
						?>
            <tr class="particulars">
              <td align="center" class="borderRight"><?= $row_t['IE_id']?></td>
              <td align="left" style="padding-left:2px" class="borderRight"><?= $row_t['Machine']?></td>
              <td align="center" class="borderRight"><?= $row_t['item_id']?></td>
              <td align="left" style="padding-left:2px" class="borderRight"><?= $row_t['ItemName']?></td>
              <td align="center" class="borderRight"><?= $row_t['UOM']?></td>
              <td align="right" class="borderRight padding_right">
                <?= number_format($row_t['iss_qty'],2,'.','')?>
              </td>
              <td align="right" class="borderRight padding_right">
                <?= number_format($row_t['AvgRate'],2,'.','')?>
              </td>
              <td align="right" class="borderRight padding_right">
                <?= number_format(($row_t['iss_qty']*$row_t['AvgRate']),2,'.','')?>
              </td>
             </tr>
            <?
						$totalNetRate+=($row_t['iss_qty']*$row_t['AvgRate']);
						}
						?>
            <tfoot>
            	<tr class="borderTop borderBottom" style="font-size:12px">
                <td colspan="6">&nbsp;</td>
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
         	 <tr><td colspan="8" align="center"><b>No Records Found</b></td></tr>
          <?
					}
					?>
        </table>
      </tbody>
    </table>
  </div>
</body>
</html>