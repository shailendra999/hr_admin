<?
include("inc/dbconnection.php");
include("inc/store_function.php");
include("inc/check_session.php");
//print_r($_REQUEST);
//print_r($_POST);
if(isset($_REQUEST['value']))
{
	$val=$_REQUEST['value'];
}
else
	$val='';
if(($_REQUEST['byControl'])=='NRGP_id')
{
	$sql="select mm.NRGP_id,mm.NRGP_date,mm.supplier_id,mt.item_name,quantity,rate from ms_NRGP_master mm,ms_NRGP_Item_transaction mt where mm.NRGP_id=mt.NRGP_id and mm.NRGP_id=$val order by mm.NRGP_id asc";
}
else if(($_REQUEST['byControl'])=='NRGPDate')
{
	$val=getDateFormate($val);
	$sql="select mm.NRGP_id,mm.NRGP_date,mm.supplier_id,mt.item_name,quantity,rate from ms_NRGP_master mm,ms_NRGP_Item_transaction mt where mm.NRGP_id=mt.NRGP_id and mm.NRGP_date='".$val."' order by mm.NRGP_id asc";
}
else if(($_REQUEST['byControl'])=='Supplier')
{
	$sql="select mm.NRGP_id,mm.NRGP_date,mm.supplier_id,mt.item_name,quantity,rate from ms_NRGP_master mm,ms_NRGP_Item_transaction mt where mm.NRGP_id=mt.NRGP_id and mm.supplier_id=$val order by mm.NRGP_id asc";
}
else if(($_REQUEST['byControl'])=='ItemName')
{
	$sql="select mm.NRGP_id,mm.NRGP_date,mm.supplier_id,mt.item_name,quantity,rate from ms_NRGP_master mm,ms_NRGP_Item_transaction mt where mm.NRGP_id=mt.NRGP_id and mt.item_name like '".$val."%' order by mm.NRGP_id asc";
}
else if(($_REQUEST['byControl'])=='Department')
{
	$sql="select mm.NRGP_id,mm.NRGP_date,mm.supplier_id,mt.item_name,quantity,rate from ms_NRGP_master mm,ms_NRGP_Item_transaction mt where mm.NRGP_id=mt.NRGP_id and mt.department_id=$val order by mm.NRGP_id asc";
}
//echo $sql;
//$sql = $sql ." LIMIT " . $start . ", $row_limit";
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());

?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print NRGP List Item</title>
<style>
.note
{
font: Arial, Helvetica, sans-serif;
font-size:13px;
font-weight:bold;
height:30px;
text-align:center;
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
                if($_REQUEST['byControl']=="Department")
                {
                  $sql_D="select name from ms_department where department_id=$val";
                  $res_D=mysql_query($sql_D) or die("Error in : ".$sql_D."<br>".mysql_errno()." : ".mysql_error());
                  if(mysql_num_rows($res_D)>0)
                  {
                    $row_D=mysql_fetch_array($res_D);
                    $TypeName=' Of Department - '.$row_D['name'];
                  }
                }
                else if($_REQUEST['byControl']=="Supplier")
                {
                  $sql_M="select name from ms_supplier where supplier_id=$val";
                  $res_M=mysql_query($sql_M) or die("Error in : ".$sql_M."<br>".mysql_errno()." : ".mysql_error());
                  if(mysql_num_rows($res_M)>0)
                  {
                    $row_M=mysql_fetch_array($res_M);
                    $TypeName=' Of Supplier - '.$row_M['name'];
                  }
                }
								else if($_REQUEST['byControl']=="ItemName")
                {
                   $TypeName=' Of Item Like - <u>'.$val.'</u>';
                }
								else if($_REQUEST['byControl']=="NRGPDate")
                {
                   $TypeName=' On Date - '.getDateFormate($val);
                }
								else if(($_REQUEST['byControl'])=='NRGP_id')
                {
                   $TypeName=' Of NRGP No. - '.$val;
                }
              ?>
              NRGP Report <b><?=$TypeName?></b>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <table align="center" width="100%" border="1" class="tblborder">
                <tr class="note">
                  <td>S.No.</td>
                  <td>NRGP No.</td>
                  <td>NRGP Date</td>
                  <td>Supplier</td>
                  <td>Item Name</td>
                  <td>Qty</td>
                  <td>Rate</td>
                </tr>	
                <?  
                if(mysql_num_rows($result)>0)
                {
                  $sno = 1;$oldid = "";$count =1;
                  while($row=mysql_fetch_array($result))
                  {	
                    $sql_idate="select * from ms_NRGP_master where insert_date='".date('Y-m-d')."' and NRGP_id='".$row['NRGP_id']."'";
                    $res_idate=mysql_query($sql_idate);	
                    $row_idate=mysql_fetch_array($res_idate);
                    $insert_date=$row_idate['insert_date'];
                    ?>
                    <tr class="particulars">
                      <td align="center"><?=$sno?></td>
                      <td align="center"><?= $row['NRGP_id']?></td>
                      <td align="center"><?=getDateFormate($row['NRGP_date']);?></td>
                      <td align="left" style="padding-left:3px">
                      <?
                        $sql_sup= "select * from ms_supplier where supplier_id='".$row['supplier_id']."'";
                        $res_sup = mysql_query ($sql_sup) or die (mysql_error());
                        $row_sup = mysql_fetch_array($res_sup);
                        echo $row_sup['name'];
                       ?>
                      </td>
                      <td align="left" style="padding-left:3px"><?= $row['item_name']?></td>
                      <td align="left" style="padding-left:3px"><?= $row['quantity']?></td>
                      <td align="left" style="padding-left:3px"><?= $row['rate']?></td>
                    </tr>
                  <?
                   $sno++;
                  }	
                }
                else
                {
                  ?>
                    <tr><td align="center" colspan="5"><b>No Record Found.</b></td></tr>
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
