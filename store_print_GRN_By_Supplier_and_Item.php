<?
include("inc/dbconnection.php");
include("inc/store_function.php");
if(isset($_REQUEST['value']))
{
	$val=$_REQUEST['value'];
}
else
	$val='';
$SearchType='';
if(($_REQUEST['byControl'])=='Supplier')
{
	$SearchType='Supplier';
	$sql="select mrgm.GRN_id,mrgm.type_GRN,mrgm.indent_id,mrgm.inv_number,mrgm.inv_date,mrgm.GRN_date,mrgm.supplier_id,mrgt.item_id,mrgt.GRN_transaction_id,mrgm.order_id,mrgm.others_amount,mrgm.total_amount,mrgt.net_rate,mrgt.rec_qty from ms_GRN_master mrgm,ms_GRN_transaction mrgt where mrgm.GRN_id=mrgt.GRN_id and mrgm.supplier_id=$val order by mrgm.GRN_id asc";
}
else if(($_REQUEST['byControl'])=='ItemName')
{
	$SearchType='ItemName';
	$sql="select mrgm.GRN_id,mrgm.type_GRN,mrgm.indent_id,mrgm.inv_number,mrgm.inv_date,mrgm.GRN_date,mrgm.supplier_id,mrgt.item_id,mrgt.GRN_transaction_id,mrgm.order_id,mrgm.others_amount,mrgm.total_amount,mrgt.net_rate,mrgt.rec_qty from ms_GRN_master mrgm,ms_GRN_transaction mrgt where mrgm.GRN_id=mrgt.GRN_id and mrgt.item_id = '".$val."' order by mrgm.GRN_id asc";
}
//echo $sql;
//$sql = $sql ." LIMIT " . $start . ", $row_limit";
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print GRN By <?=$SearchType?></title>
<style>
.note
{
font: Arial, Helvetica, sans-serif;
font-size:13px;
font-weight:bold;
height:30px;
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
.break { page-break-before: always; }
</style>

</head>

<body onload="print();">
    <div style="margin:0 auto;width:740px;padding:2px">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr height="70px">
            <td align="center">
              <b><u>MAHIMA PURESPUN</u></b><br />
              <?
                $TypeName='';
                if($SearchType=="Supplier")
                {
                  $sql_S="select name from ms_supplier where supplier_id=$val";
                  $res_S=mysql_query($sql_S) or die("Error in : ".$sql_S."<br>".mysql_errno()." : ".mysql_error());
                  if(mysql_num_rows($res_S)>0)
                  {
                    $row_S=mysql_fetch_array($res_S);
                    $TypeName='Supplier - '.$row_S['name'];
                  }
                }
                if($SearchType=="ItemName")
                {
                  $sql_I= "select * from ms_item_master where item_id='".$val."' ";
									$res_I = mysql_query($sql_I) or die("Error in : ".$sql_I."<br>".mysql_errno()." : ".mysql_error());
                  if(mysql_num_rows($res_I)>0)
                  {
                    $row_I=mysql_fetch_array($res_I);
                    $TypeName='Item - '.$row_I['name'];
                  }
                }
              ?>
              GRN Report Of <b><?=$TypeName?></b>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <table align="center" width="100%" border="1" class="tblborder">
                <tr class="note">
                	<td align="center" width="6%">S.No.</td>
                  <td align="center" width="7%">GRN No</td>
                  <td align="center" width="8%">GRN Date</td>
                  <td align="center" width="7%">PO No</td>
                  <td align="center" width="8%">Ind. No</td>
                  <td align="center" width="8%">Invoice no</td>
                  <td align="center" width="8%">Invoice Date</td>
                  
                  <?
                  if($SearchType=='ItemName')
                  {
                  ?>
                    <td align="center" width="25%">Supplier</td>
                  <?
                  }
                  if($SearchType=='Supplier')
                  {
                  ?>
                    <td align="center" width="25%">Item Name</td>
                  <?
                  }
                  ?>
                  <td align="center" width="7%">Rec. Qty.</td>
                  <td align="center" width="7%">Net Rate</td>
                  <td align="center" width="8%">Value</td>
                  <td align="center" width="8%">Other Amt.</td>
                  <td align="center" width="9%">Net Amt.</td>
                </tr>
                 <?  
                  if(mysql_num_rows($result)>0)
                  {
                    $sno=1;$oldGRN_id="";
										$TotalReceivedQty=0;$TotalNetRate=0;
										$TotalValue=0;
										$TotalOthersAmt=0;$TotalAmount=0;$total_amount=0;
                    while($row=mysql_fetch_array($result))
                    {	
											if($oldGRN_id!=$row['GRN_id'])
											{
												$total_amount=number_format($row['total_amount'],2,'.','');
												$oldGRN_id=$row['GRN_id'];
											}
											else
												$total_amount="";
                    ?>
                    <tr class="particulars">
                    	<td align="center"><?=$sno++?></td>
                      <td align="center"><?=$row['GRN_id']?></td>
                      <td align="center"><?=getDateFormate($row['GRN_date'])?></td>
                      <td align="center"><?=$row['order_id']?></td>
                      <td align="center"><?=$row['indent_id']?></td>
                      <td align="center" width="8%"><?=$row['inv_number']?></td>
	                  <td align="center" width="8%"><?=getDateFormate($row['inv_date'])?></td>
                      <?
                      if($SearchType=='ItemName')
                      {
                      ?>
                        <td align="left" style="padding-left:2px">
                          <?
														$sql_S= "select * from ms_supplier where supplier_id='".$row['supplier_id']."' ";
														$res_S = mysql_query($sql_S) or die(mysql_error());
														$row_S = mysql_fetch_array($res_S);
														echo $row_S['name'];
													?>
                        </td>
                      <?
                      }
                      if($SearchType=='Supplier')
                      {
                      ?>
                        <td align="left" style="padding-left:2px">
                          <?
													$sql_I= "select * from ms_item_master where item_id='".$row['item_id']."' ";
													$res_I = mysql_query($sql_I) or die(mysql_error());
													$row_I = mysql_fetch_array($res_I);
													echo $row_I['name'];
												 ?>
                        </td>
                      <?
                      }
                      ?>
                     	<td align="right" style="padding-right:2px;"><?=number_format($row['rec_qty'],2,'.','')?></td>
                      <td align="right" style="padding-right:2px;"><?=number_format($row['net_rate'],2,'.','')?></td>
                      <td align="right" style="padding-right:2px;"><?=number_format(($row['rec_qty']*$row['net_rate']),2,'.','')?></td>
                      <td align="right" style="padding-right:2px;"><?=number_format($row['others_amount'],2,'.','')?></td>
                      <td align="right" style="padding-right:2px;"><?=$total_amount?></td>
                    </tr>
                    <?
										  $TotalReceivedQty+=$row['rec_qty'];
											//$TotalNetRate+=$row['net_rate'];
											$TotalValue+=$row['rec_qty']*$row['net_rate'];
											$TotalOthersAmt+=$row['others_amount'];$TotalAmount+=$total_amount;
                      $sno++;
                    }	
										?>
                    	<tr class="particulars" style="font-weight:bold">
                        <td colspan="8" align="right" style="padding-right:5px">Total</td>
                        <td align="right" style="padding-right:2px"><?=number_format($TotalReceivedQty,2,'.','')?></td>
                        <td align="center">&nbsp;</td>
                        <td align="right" style="padding-right:2px"><?=number_format($TotalValue,2,'.','')?></td>
                        <td align="right" style="padding-right:2px"><?=number_format($TotalOthersAmt,2,'.','')?></td>
                        <td align="right" style="padding-right:2px"><?=number_format($TotalAmount,2,'.','')?></td>
                      </tr>
                    <?
										
                  }
                  else
                  {
                  ?>
                  <tr>
                    <td colspan="11" align="center" style="font-weight:bold">No Records Found</td>
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
</body>
</html>
