<?
include("inc/dbconnection.php");
include("inc/store_function.php");
include("inc/check_session.php");

$WhereCondition = "";
$WhereCondition .= ($_POST["RGP_id"] != "") ? " and mrgm.RGP_GRN_id = '".$_POST["RGP_id"]."'" : "";

$WhereCondition .= ($_POST["supplier_id"] != "") ? " and mrgm.supplier_id = '".$_POST["supplier_id"]."'" : "";

$WhereCondition .= ($_POST["item_id"] != "") ? " and mrt.item_name like '%".$_POST["item_id"]."%'" : "";

$WhereCondition .= ($_POST["RGPGRNDate"] != "") ? " and mrgm.RGP_GRN_date BETWEEN '".getDateFormate($_POST["RGPGRNDate"])."'" : "";

$WhereCondition .= ($_POST["RGPGRN_end_Date"] != "") ? " and '".getDateFormate($_POST["RGPGRN_end_Date"])."'" : "";
/*$WhereCondition .= ($_POST["RGP_id"] != "") ? " and mrgm.RGP_GRN_id = '".$_POST["RGP_id"]."'" : "";
$WhereCondition .= ($_POST["supplier_id"] != "") ? " and mrgm.supplier_id = '".$_POST["supplier_id"]."'" : "";
$WhereCondition .= ($_POST["RGPGRNDate"] != "") ? " and mrgm.RGP_GRN_date = '".getDateFormate($_POST["RGPGRNDate"])."'" : "";
$WhereCondition .= ($_POST["item_id"] != "") ? " and mrt.item_name like '%".$_POST["item_id"]."%'" : "";*/
$sql="select 
			mrgm.RGP_GRN_id,
			mrgm.RGP_GRN_date,
			mrgm.supplier_id,
			mrt.item_name,
			mrt.RGP_transaction_id,
			mrgm.RGP_id,
			mrgt.rec_qty,
			mrgt.net_rate,
			mrgm.others_amount,
			mrgm.net_amount 
		from 
			ms_RGP_GRN_master mrgm,
			ms_RGP_GRN_transaction mrgt,
			ms_RGP_transaction mrt 
		where 
			mrgm.RGP_GRN_id=mrgt.RGP_GRN_id 
			and mrt.RGP_transaction_id=mrgt.RGP_transaction_id 
			".$WhereCondition." 
		order by 
			mrgm.RGP_GRN_id 
			asc";


//echo $sql;
//$sql = $sql ." LIMIT " . $start . ", $row_limit";
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print RGP GRNList </title>
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
				
                if($_POST["supplier_id"] != "")
                {
					$sql_S="select name from ms_supplier where supplier_id='".$_POST["supplier_id"]."'";
					$res_S=mysql_query($sql_S) or die("Error in : ".$sql_S."<br>".mysql_errno()." : ".mysql_error());
					if(mysql_num_rows($res_S)>0)
					{
						$row_S=mysql_fetch_array($res_S);
						$TypeName='Of Supplier - <u>'.$row_S['name'].'</u>';
					}
                }
                else if($_POST["item_id"] != "")
                {
                    $TypeName='Of Item Name Like - <u>'.$_POST["item_id"].'</u>';
                }
				else if($_POST["RGPGRNDate"] != "")
                {
                    $TypeName='On Date - <u>'.getDateFormate($_POST["RGPGRNDate"]).'</u>';
                }
				else if($_POST["RGP_id"] != "")
                {
                    $TypeName='Of RGP GRN No. - <u>'.$_POST["RGP_id"].'</u>';
                }
              ?>
              RGP GRN Report <b><?=$TypeName?></b>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <table align="center" width="100%" border="1" class="tblborder">
                <tr class="note">
                  <td>S.No.</td>
                  <td>No.</td>
                  <td>Date</td>
                  <td>RGP No.</td>
                  <td>Supplier</td>
                  <td>Item Name</td>
                  <td>Rec. Qty</td>
                  <td>NetRate</td>
                  <td>Value</td>
                  <td>Others</td> <td>Net.Amt.</td>
               </tr>	
              <?  
                if(mysql_num_rows($result)>0)
                {
                  $sno = 1;$TotalReceivedQty=0;$TotalNetRate=0;
									$TotalValue=0;$oldGRN_id="";
									$TotalOthersAmt=0;$TotalAmount=0;$total_amount=0;
                  while($row=mysql_fetch_array($result))
                  {	
                 		if($oldGRN_id!=$row['RGP_GRN_id'])
										{
											$total_amount=number_format($row['net_amount'],2,'.','');
											$others_amount=number_format($row['others_amount'],2,'.','');
											$oldGRN_id=$row['RGP_GRN_id'];
										}
										else
										{
											$total_amount="";$others_amount="";
										}
                  ?>
                  <tr class="particulars">
                    <td align="center"><?=$sno?></td>
                    <td align="center"><?= $row['RGP_GRN_id']?></td>
                    <td align="center"><?= getDateFormate($row['RGP_GRN_date'])?></td>
                    <td align="center"><?= $row['RGP_id']?></td>
                    <td align="left" style="padding-left:5px">
                    <?
                      $sql_S= "select * from ms_supplier where supplier_id='".$row['supplier_id']."'";
                      $res_S = mysql_query ($sql_S) or die (mysql_error());
                      $row_S = mysql_fetch_array($res_S);
                      echo $row_S['name'];
                    ?>
                    </td>
                    <td align="left" style="padding-left:5px">
                    <?
                    $sql_IN= "select mrt.* from ms_RGP_transaction mrt,ms_RGP_GRN_transaction mrgt  where mrt.RGP_transaction_id='".$row['RGP_transaction_id']."' and mrt.RGP_transaction_id=mrgt.RGP_transaction_id";
                    $res_IN = mysql_query ($sql_IN) or die (mysql_error());
                    $row_IN = mysql_fetch_array($res_IN);
                    echo $row_IN['item_name'];
                    ?>
                    </td>
                    <td align="right" style="padding-right:2px;"><?=number_format($row['rec_qty'],2,'.','')?></td>
                    <td align="right" style="padding-right:2px;"><?=number_format($row['net_rate'],2,'.','')?></td>
                    <td align="right" style="padding-right:2px;"><?=number_format(($row['rec_qty']*$row['net_rate']),2,'.','')?></td>
                    <td align="right" style="padding-right:2px;"><?=$others_amount?></td>
                    <td align="right" style="padding-right:2px;"><?=$total_amount?></td>
                     
                  </tr>
                  <?
                   $sno++;
                  }
                }
                else
                {
                  ?>
                    <tr><td align="center" colspan="9"><b>No Record Found.</b></td></tr>
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
