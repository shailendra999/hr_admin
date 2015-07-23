<? include("inc/dbconnection.php");
include("inc/store_function.php");
if ($_POST["grnNo"]!=""){
	$whreclosegrnNo = "and ms_bill_pass_master_new.GRN_id='".$_POST["grnNo"]."'";
	$whreclosegrnNo1 = " GRN_id='".$_POST["grnNo"]."'";
}
if($_POST['billDate']!=''){
	$billDate=getDateFormate($_POST['billDate']);
	$sql="select * from ms_bill_pass_master_new where bill_pass_date='".$billDate."' ".$whreclosegrnNo."  order by bill_pass_date asc";
}
if($_POST['grnNo']!=''){
	$byControlValue=$_POST['grnNo'];
	$grnNo=$_POST['grnNo'];
	$sql="select ms_bill_pass_master_new.* from ms_bill_pass_master_new,ms_GRN_master where ms_bill_pass_master_new.GRN_id=ms_GRN_master.GRN_id ".$whreclosegrnNo."   order by ms_bill_pass_master_new.bill_pass_date asc";
}
if($_POST['supplier_id']!=''){
	$byControlValue=$_POST['supplier_id'];
	$supplier_id=$_POST['supplier_id'];
	$sql="select ms_bill_pass_master_new.* from ms_bill_pass_master_new,ms_GRN_master where ms_GRN_master.supplier_id='".$supplier_id."' ".$whreclosegrnNo."  and ms_bill_pass_master_new.GRN_id=ms_GRN_master.GRN_id order by ms_bill_pass_master_new.bill_pass_date asc";
}
if($_POST['item_id']!=''){
	$byControlValue=$_POST['item_id'];
	$item_id=$_POST['item_id'];
	$sql="select ms_bill_pass_master_new.* from ms_bill_pass_master_new,ms_GRN_master,ms_GRN_transaction where ms_GRN_transaction.item_id='".$item_id."' ".$whreclosegrnNo."  and ms_bill_pass_master_new.GRN_id=ms_GRN_master.GRN_id and ms_GRN_master.GRN_id=ms_GRN_transaction.GRN_id order by ms_bill_pass_master_new.bill_pass_date asc";
}


	//$byControl=$_POST['byControl'];
	//echo $_POST['byControl'].' : '.$_POST['byControlValue']; 
	$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Bill Passing By Date</title>
<style>
.note{
	font: Arial, Helvetica, sans-serif;
	font-size:13px;
	font-weight:bold;
}
.particulars{
	font: Arial, Helvetica, sans-serif;
	font-size:11px;
	height:25px;
}
.tblborder{
	border-collapse:collapse;border-color:1px solid #000;
}
.padding_right{
	padding-right:2px;
}
</style>
</head>

<body onload="print();">
  <div style="width:99%;margin:0 auto;font:Arial, Helvetica, sans-serif;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <thead>
        <tr height="70px">
          <td align="center">
           	<b> MAHIMA PURESPUN</b><br />
<? if($_POST['billDate']!=''){
	echo 'Bill Passing As On <b>'.getDateFormate($billDate).'</b>';
}else if($_POST['item_id']!=''){
	$sql_I="select name from ms_item_master where item_id='".$item_id."'";
	$res_I=mysql_query($sql_I) or die("Error in : ".$sql_I."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($res_I)>0){
		$row_I=mysql_fetch_array($res_I);
		echo 'Bill Passing Of <b>Item - <u>'.$row_I['name'].'</u></b>';
	}
}else if($_POST['supplier_id']!=''){
	$sql_S="select name from ms_supplier where supplier_id='".$supplier_id."'";
	$res_S=mysql_query($sql_S) or die("Error in : ".$sql_S."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($res_S)>0){
		$row_S=mysql_fetch_array($res_S);
		echo 'Bill Passing Of <b>Supplier - <u>'.$row_S['name'].'</u></b>';
	}
} ?>
          </td>
        </tr>
      </thead>
      <tr>
      	<td align="center">
          <table align="center" width="100%" border="1" cellspacing="0" cellpadding="2" class="tblborder">
           <tr class="note">
              <td align="center">S.No.</td>
              <td align="center">Bill Pass No.</td>
              <td align="center">Bill Pass Date</td>
              <td align="center">GRN No.</td>
              <td align="center">GRN Date</td>
              <td align="center">Inv. No.</td>
              <td align="center">Inv. Date</td>
              <td align="center">Supplier</td>
              <td align="center">ItemName</td>
              <td align="center">ItemQty</td>
              <td align="center">NetRate</td>
              <td align="center">Total Amt.</td>
            </tr>
            <? if(mysql_num_rows($result)>0){
				$sno = 1;$totalQty=0;$totalNetRate=0;$totalValue=0;
				while($row=mysql_fetch_array($result)){	?>
              <tr class="particulars">
                <td align="center"><?=$sno?></td>
                <td align="center"><?=$row['bill_pass_id']?></td>
                <td align="center"><?=getDateFormate($row['bill_pass_date'])?></td>
                <td align="center"><?=$row['GRN_id']?></td>
                <td align="center">
                  <? $sql_gd="select GRN_date from ms_GRN_master where GRN_id = '".$row['GRN_id']."' ";
				  $result_gd = mysql_query($sql_gd) or die (mysql_error());;
				  $row_gd = mysql_fetch_array($result_gd);
                  echo getDateFormate($row_gd['GRN_date']); ?>
                </td>
                <td align="center">
                  <? $sql_Inv="select inv_number,inv_date from ms_GRN_master where ms_GRN_master.GRN_id='".$row['GRN_id']."'";
                  $result_Inv = mysql_query($sql_Inv) or die (mysql_error());;
                  $row_Inv = mysql_fetch_array($result_Inv);
                  echo $row_Inv['inv_number']; ?>
                </td>
                <td align="center"><?=getDateFormate($row_Inv['inv_date']);?>
                <td align="left" style="padding-left:2px">
                  <? $sql_S="select name from ms_supplier,ms_GRN_master where ms_GRN_master.GRN_id='".$row['GRN_id']."' and ms_supplier.supplier_id=ms_GRN_master.supplier_id";
                  $result_S = mysql_query($sql_S) or die (mysql_error());;
                  $row_S = mysql_fetch_array($result_S);
                  echo $row_S['name']; ?>
                </td>
                <td align="left" style="padding-left:2px">
                  <? $sql_I="select name from ms_item_master,ms_GRN_master,ms_GRN_transaction where ms_GRN_master.GRN_id='".$row['GRN_id']."' and ms_GRN_master.GRN_id=ms_GRN_transaction.GRN_id and ms_GRN_transaction.item_id=ms_item_master.item_id";
                  $result_I = mysql_query($sql_I) or die (mysql_error());;
                  $row_I = mysql_fetch_array($result_I);
                  echo $row_I['name']; ?>
                </td>
                <td align="right" style="padding-right:2px">
                  <? $sql_G="select rec_qty,net_rate from ms_GRN_master,ms_GRN_transaction where ms_GRN_master.GRN_id='".$row['GRN_id']."' and ms_GRN_master.GRN_id=ms_GRN_transaction.GRN_id";
                  $result_G = mysql_query($sql_G) or die (mysql_error());;
                  $row_G = mysql_fetch_array($result_G);
                  echo number_format($row_G['rec_qty'],2,'.','');
                  $totalQty+=number_format($row_G['rec_qty'],2,'.','');
                  $totalNetRate+=number_format($row_G['net_rate'],2,'.',''); ?>
                </td>
                <td align="right" style="padding-right:2px"><?=number_format($row_G['net_rate'],2,'.','');?></td>
                <td align="right" style="padding-right:2px">
                  <? $sql_na="select total_amount from ms_GRN_master where GRN_id='".$row['GRN_id']."'";
                  $result_na = mysql_query($sql_na) or die (mysql_error());;
                  $row_na = mysql_fetch_array($result_na);
                  echo $row_na['total_amount'];
                  $totalValue+=number_format($row_na['total_amount'],2,'.',''); ?>
                </td>
              </tr>
              <? $sno++;
              }	?>
              <tr>
                <td align="right" colspan="9" style="padding-right:10px"><b>Total : </b></td>
                <td align="right" style="padding-right:2px"><?=number_format($totalQty,2,'.','')?></td>
                <td align="right" style="padding-right:2px"><?=number_format($totalNetRate,2,'.','')?></td>
                <td align="right" style="padding-right:2px"><?=number_format($totalValue,2,'.','')?></td>
              </tr>
            <? }else{ ?>
              <tr><td align="center" colspan="12"><b>No Record Found.</b></td></tr>
              <? } ?>  
          </table>
       	</td>
      </td>
    </table>
  </div>
</body>
</html>