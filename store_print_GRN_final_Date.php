<? include("inc/dbconnection.php");
include("inc/store_function.php");
$GRN_id = $_POST['GRN_id'];
$supplier_id = $_POST['supplier_id'];
$GRNDate = $_POST['GRNDate'];
$GRNDateTo = $_POST['GRNDateTo'];
$item_id = $_POST['item_id'];
$mac_id = $_POST['mac_id'];
$dep_id = $_POST['dep_id'];
$Header='Purchase Register As On ';
$where_condition = "where mrgm.GRN_id = mrgt.GRN_id";
if($GRN_id != ''){
	$where_condition .= " and mrgm.GRN_id = '".$GRN_id."'";
}
if($GRNDate != '' || $GRNDateTo != ''){
	$from_date = getDateFormate($GRNDate);
	$to_date = getDateFormate($GRNDateTo);
	if($to_date == ''){
		$to_date = date('Y-m-d');
	}
	$where_condition .= " and mrgm.GRN_date between '".$from_date."' and '".$to_date."'";
	$Header .= $GRNDate;
}
if($supplier_id != ''){
	$where_condition .= " and mrgm.supplier_id = '".$supplier_id."'";
	#$Header .= " Supplier Name : ".$supplier_id."<br />";
}
if($item_id != ''){
	$where_condition .= " and mrgt.item_id = '".$item_id."'";
}
if($mac_id != ''){
	$sql_mac = "SELECT `item_id` FROM `ms_item_master` WHERE `machinary_id` = '".$mac_id."'";
	$res_mac = mysql_query ($sql_mac) or die (mysql_error());
	if(mysql_num_rows($res_mac)>0){
		while($row_mac = mysql_fetch_array($res_mac)){
			$machinery[] = $row_mac['item_id'];
		}
		$machineries = implode(',', $machinery) ;
		$where_condition .= " and mrgt.item_id in($machineries)";
		#$Header .= " Machine Name : ".$mac_id."<br />";
	}
}
if($dep_id != ''){
	$sql_dep = "SELECT `item_id` FROM `ms_item_master` WHERE `department_id` = '".$dep_id."'";
	$res_dep = mysql_query ($sql_dep) or die (mysql_error());
	if(mysql_num_rows($res_dep)>0){
		while($row_dep = mysql_fetch_array($res_dep)){
			$department[] = $row_dep['item_id'];
		}
		$departments = implode(',', $department);
		$where_condition .= " and mrgt.item_id in($departments)";
		#$Header .= " Department Name : ".$dep_id."<br />";
	}
}
$sql = "select
	mrgm.GRN_id,
	mrgm.type_GRN,
	mrgm.indent_id,
	mrgm.inv_number,
	mrgm.GRN_date,
	mrgm.supplier_id,
	mrgt.item_id,
	mrgt.GRN_transaction_id,
	mrgm.order_id,
	mrgt.rec_qty,
	mrgt.rate,
	mrgm.total_amount from ms_GRN_master mrgm, ms_GRN_transaction mrgt ".$where_condition." order by mrgm.GRN_id asc";
$result = mysql_query($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print All Goods Received Entry</title>
<style>
.note{
	font: Arial, Helvetica, sans-serif;
	font-size:13px;
}
.particulars{
	font: Arial, Helvetica, sans-serif;
	font-size:14px;
	height:22px;
}
.tblborder{
	border-collapse:collapse;border-color:1px solid #000;
}
</style>
</head>
<body onload="print();">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<thead>
  <tr height="70px">
    <td align="center">
      <b><u>MAHIMA PURESPUN</u></b><br />
      <b><?=$Header?></b>
    </td>
  </tr>
</thead>
<tbody>
  <tr>
    <td>
      <table align="center" width="100%" border="1" class="tblborder">
        <tr class="note">
          <td align="center" width="7%">GRN No</td>
          <td align="center" width="8%">Invoice No.</td>
          <td align="center" width="7%">Supplier</td>
          <td align="center" width="8%">Item No.</td>
          <td align="center" width="8%">Item Name</td>
          <td align="center" width="8%">UOM</td>
          <td align="center" width="7%">Rec. Qty.</td>
          <td align="center" width="7%">Rate / Unit</td>
          <td align="center" width="7%">Value</td>
          <td align="center" width="8%">Net Rate</td>
        </tr>
         <? if(mysql_num_rows($result)>0){
             $sno=1;$oldGRN_id="";
             $TotalReceivedQty=0;$TotalNetRate=0;
             $TotalValue=0;
             $TotalOthersAmt=0;$TotalAmount=0;$total_amount=0;
             while($row=mysql_fetch_array($result)){
				 if($oldGRN_id!=$row['GRN_id']){
					 $total_amount=number_format($row['total_amount'],2,'.','');
					 $oldGRN_id=$row['GRN_id'];
				}else
					$total_amount=""; ?>
            <tr class="particulars">
              <td align="center"><?=$row['GRN_id']?></td>
              <td align="center" width="8%"><?=$row['inv_number']?></td>
              <td align="left" style="padding-left:2px">
			  <? $sql_S= "select * from ms_supplier where supplier_id='".$row['supplier_id']."' ";
			  	$res_S = mysql_query($sql_S) or die(mysql_error());
				$row_S = mysql_fetch_array($res_S);
					echo $row_S['name']; ?>
              </td>
              <td align="center"><?=$row['item_id']?></td>
              <td align="left" style="padding-left:2px">
              <? $sql_I= "select * from ms_item_master where item_id='".$row['item_id']."' ";
			  	$res_I = mysql_query($sql_I) or die(mysql_error());
				$row_I = mysql_fetch_array($res_I);
				echo $row_I['name']; ?>
              </td>
              <td align="left" style="padding-left:2px">
              <? $sql_U= "select name from ms_uom where uom_id = '".$row_I['uom_id']."' ";
			  	$res_U = mysql_query($sql_U) or die(mysql_error());
				$row_U = mysql_fetch_array($res_U);
				echo $row_U['name'];?>
              </td>
              <td align="right" style="padding-right:2px;"><?=number_format($row['rec_qty'],2,'.','')?></td>
              <td align="right" style="padding-right:2px;"><?=number_format($row['rate'],2,'.','')?></td>
              <td align="right" style="padding-right:2px;"><?=number_format(($row['rec_qty']*$row['rate']),2,'.','')?></td>
              <td align="right" style="padding-right:2px;"><?=$total_amount?></td>
            </tr>
            <? $TotalReceivedQty+=$row['rec_qty'];
            $TotalValue+=$row['rec_qty']*$row['rate'];
            $TotalAmount+=$total_amount;
            $sno++;
        } ?>
                <tr class="particulars" style="font-weight:bold">
                <td colspan="6" align="right" style="padding-right:5px">Total</td>
                <td align="right" style="padding-right:2px"><?=number_format($TotalReceivedQty,2,'.','')?></td>
                <td align="center">&nbsp;</td>
                <td align="right" style="padding-right:2px"><?=number_format($TotalValue,2,'.','')?></td>
                <td align="right" style="padding-right:2px"><?=number_format($TotalAmount,2,'.','')?></td>
              </tr>
            <? }else{ ?>
          <tr>
            <td colspan="10" align="center" style="font-weight:bold">No Records Found</td>
          </tr>
          <? } ?>        
      </table>
    </td>
  </tr>
</tbody>
</table>
</body>
</html>