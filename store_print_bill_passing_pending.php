<?
include("inc/dbconnection.php");
include("inc/store_function.php");

?>
<?
	//$byControl=$_POST['byControl'];
	//echo $_POST['byControl'].' : '.$_POST['byControlValue']; 
	$PendingDateFrom='';
	$PendingDateTo='';
	if($_POST['byControl']=='PendingDateRange')
	{	
		$PendingDateFrom=($_POST['PendingDateFrom']);
		$PendingDateTo=($_POST['PendingDateTo']);
		$sql="select ms_GRN_master.*,ms_GRN_transaction.* from ms_GRN_master,ms_GRN_transaction where ms_GRN_master.GRN_id=ms_GRN_transaction.GRN_id and ms_GRN_master.GRN_date BETWEEN '".$PendingDateFrom."' AND '".$PendingDateTo."' and ms_GRN_master.GRN_id NOT IN (select GRN_id from ms_bill_pass_master_new) order by ms_GRN_master.GRN_id";
	}
	$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Pending Bill Passing By Date</title>
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
.padding_right
{
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
            <?
							if($_POST['byControl']=='PendingDateRange')
								echo 'Pending Bill List Between <b>'.getDateFormate($PendingDateFrom).'</b> and <b>'.getDateFormate($PendingDateTo).'</b>';
							
            ?>
          </td>
        </tr>
      </thead>
      <tr>
      	<td align="center">
          <table align="center" width="100%" border="1" class="tblborder">
            <tr class="note">
              <td align="center" width="6%">S.No.</td>
              <td align="center" width="6%">GRN No.</td>
              <td align="center" width="10%">GRN Date</td>
              <td align="center" width="6%">Inv. No.</td>
              <td align="center" width="10%">Inv. Date</td>
              <td align="center" width="20%">Supplier</td>
              <td align="center" width="20%">ItemName</td>
              <td align="center" width="7%">ItemQty</td>
              <td align="center" width="7%">NetRate</td>
              <td align="center" width="8%">Total Amt.</td>
            </tr>
            <?  
            if(mysql_num_rows($result)>0)
            {
              $sno = 1;$totalQty=0;$totalNetRate=0;$totalValue=0;
              while($row=mysql_fetch_array($result))
              {	
               
              ?>
              <tr class="particulars">
                <td align="center"><?=$sno?></td>
                <td align="center"><?=$row['GRN_id']?></td>
                <td align="center"><?= getDateFormate($row['GRN_date'])?></td>
                <td align="center"><?=$row['inv_number']?></td>
                <td align="center"><?=getDateFormate($row['inv_date']);?></td>
                <td align="left" style="padding-left:2px">
                  <?
                  $sql_S="select name from ms_supplier where supplier_id='".$row['supplier_id']."'";
                  $result_S = mysql_query($sql_S) or die (mysql_error());;
                  $row_S = mysql_fetch_array($result_S);
                  echo $row_S['name'];
                  ?>
                </td>
                <td align="left" style="padding-left:2px">
                  <?
                  $sql_I="select name from ms_item_master,ms_GRN_transaction where ms_GRN_transaction.item_id=ms_item_master.item_id and ms_item_master.item_id='".$row['item_id']."'";
                  $result_I = mysql_query($sql_I) or die (mysql_error());;
                  $row_I = mysql_fetch_array($result_I);
                  echo $row_I['name'];
                  ?>
                </td>
                <td align="right" style="padding-right:2px">
                  <?
                  echo number_format($row['rec_qty'],2,'.','');
                  $totalQty+=number_format($row['rec_qty'],2,'.','');
                  $totalNetRate+=number_format($row['net_rate'],2,'.','');
                  ?>
                </td>
                <td align="right" style="padding-right:2px"><?=number_format($row['net_rate'],2,'.','');?></td>
                <td align="right" style="padding-right:2px">
                  <?
                  echo number_format($row['total_amount'],2,'.','');
                  $totalValue+=number_format($row['total_amount'],2,'.','');
                  ?>
                </td>
              </tr>
              <?
              $sno++;
              }	
              ?>
                <tr class="note">
                  <td align="right" colspan="7" style="padding-right:10px"><b>Total : </b></td>
                  <td align="right" style="padding-right:2px"><?=number_format($totalQty,2,'.','')?></td>
                  <td align="right" style="padding-right:2px"><?=number_format($totalNetRate,2,'.','')?></td>
                  <td align="right" style="padding-right:2px"><?=number_format($totalValue,2,'.','')?></td>
                </tr>
              <?
            }
            else
            {
              ?>
              <tr><td align="center" colspan="10"><b>No Record Found.</b></td></tr>
              <?
            }
            ?>  
          </table>
       	</td>
      </td>
    </table>
  </div>
</body>
</html>