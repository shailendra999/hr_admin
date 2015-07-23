<?
include("inc/dbconnection.php");
include("inc/store_function.php");

$PageFor = "Indent";
$PageKey = "indent_id";

$date = '';
$indent_department = '';$approved_by = '';$authorised_status = '';$authorised_by = '';$authorised_date = '';$indent_transaction_id = '';$item_id = '';
$stock = '';$required_quantity = '';$approval_status = '';$rate = '';$approved_quantity = '';$due_date = '';$remark = '';$purpose = '';$cancel_quantity = '';
$PageKeyValue = "";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print All Purchase Indent</title>
<style>
.note
{
padding-left:35px;
font: Arial, Helvetica, sans-serif;
font-size:13px;
}
.particulars
{
font: Arial, Helvetica, sans-serif;
font-size:14px;
height:22px;
}
.tblborder
{
 border-collapse:collapse;border-color:1px solid #000;
}
</style>
</head>

<body onload="print();">
<?
$sql="select * from ms_indent_master";
$res=mysql_query($sql) or die(mysql_error());
while($row = mysql_fetch_array($res))
{
	$PageKeyValue = $row[$PageKey];
	$date = getDateFormate($row["date"]);
	$indent_department = $row["indent_department"];
	$approved_by = $row["approved_by"];
	$authorised_status = $row["authorised_status"];
	$authorised_by = $row["authorised_by"];
	$authorised_date = getDateFormate($row["authorised_date"]);	
?>
<div style="width:700px;margin:0 auto">
<table width="100%" class="tblborder" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<td>
      <table width="100%" border="1"  class="tblborder">
        <tr>
          <td>
          	<table align="center" width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td align="center" colspan="2"><b style="font-size:24px;">MAHIMA PURESPUN.</b></td>
              </tr>
              <tr>
                <td colspan="2" align="center">
                  (A UNIT OF MAHIMA FIBRES PVT. LTD.)<br />
                  Factory : PLOT No. 73 - 74 SECTOR-11, PITHAMPUR, DIST DHAR<br />
                  Phones : 07292 252995,252963 Fax :07292 252985
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>
      <table align="center" width="100%" border="1" cellspacing="0" cellpadding="2" class="tblborder">
        <tr>
          <td align="center" colspan="2"><b style="font-size:20px">PURCHASE INDENT</b></td>
        </tr>
        <tr>
          <td align="center">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="60%" style="border-right:1px solid #000">
                  <table width="100%" border="0" cellspacing="0" cellpadding="2">
                    <tr>
                      <td align="left"><strong>Department :</strong></td>
                      <td colspan="3" align="left"><?=$indent_department?>
                      </td>
                    </tr>
                    <tr>
                      <td align="left"><strong>Purchase Order No. :</strong></td>
                      <td colspan="3" align="left">&nbsp;___________</td>
                    </tr>
                  </table>
                </td>
                <td width="40%">
                  <table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr>
                        <td align="left"><strong>Indent No. :</strong></td>
                        <td align="left"><?= $PageKeyValue ?></td>
                      </tr>
                      <tr>
                        <td align="left"><strong>Indent Date</strong></td>
                        <td align="left"><?= $date?></td>
                      </tr>
                    </table>
                </td>
              </tr>
          	</table>
        	</td>
      	</tr>
    </table>
    </td>
  </tr>
  
  <tr>
    <td>
    	<table align="center" width="100%" border="1" cellspacing="0" cellpadding="2" class="tblborder">
        <tr style="font-weight:bold">
          <td align="center">S.No.</td><td align="center">Item Code</td><td align="center">Particulars</td><td align="center">UOM</td>
          <td align="center">Ind. Qty.</td><td align="center">Stk. Qty.</td><td align="center">Purpose</td><td align="center">Remark</td>
        </tr>
        <?
        $sql_order_trans="SELECT * FROM ms_indent_master mom, ms_indent_transaction mot WHERE mom.indent_id = mot.indent_id  AND mom.indent_id ='".$row['indent_id']."'";
        $res_order_trans=mysql_query($sql_order_trans);
        $countTrans=1;
        $rc_trans=mysql_num_rows($res_order_trans);
        if($rc_trans>0)
        {
          while($row_t=mysql_fetch_array($res_order_trans))
          {
          ?>
          <tr class="particulars">
            <td align="center"><?= $countTrans++?></td>
            <td align="center"><?=$row_t['item_id']?></td>
            <td align="left" style="padding-left:10px">
              <?
              $sql_item="select * from ms_item_master where item_code='".$row_t['item_id']."' ";
              $res_item=mysql_query($sql_item);
              $row_item=mysql_fetch_array($res_item);
              echo $row_item['name']."<br>";
			  echo "<strong>Drow. No. :</strong> " .$row_item['drawing_number']."<br>";
			  echo "<strong>Cat. No. :</strong> " .$row_item['catelog_number'];
              ?>
            </td>
            <td align="center">
            <? 
              $id = $row_t['item_id'];
              $sql = "SELECT * FROM  ms_item_master where item_code = '$id' order by name ";
              $result_item = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
              $uname='';
              if(mysql_num_rows($result_item)>0)
              {
                $row_item = mysql_fetch_array($result_item);
                $sql_uom = "SELECT name as uname FROM  ms_uom where uom_code = '".$row_item['uom_id']."' order by name ";
                $result_uom = mysql_query ($sql_uom) or die ("Error in : ".$sql_uom."<br>".mysql_errno()." : ".mysql_error());
                if(mysql_num_rows($result_uom)>0)
                {
                  $row_uom = mysql_fetch_array($result_uom);
                  $uname= $row_uom['uname'];
                }
              }
              echo $uname;
              ?>
            </td>
            <td align="center"><?=$row_t['stock']?></td>
            <td align="center"><?=$row_t['approved_quantity']?></td>
            <td align="center"><?=$row_t['purpose']?></td>
            <td align="center"><?=$row_t['remark']?></td>
          </tr>
          <?
          }
        }
        ?>
       
      </table>
    </td>
  </tr>
  <tr>
  	<td>
    	<table width="100%" border="1" class="tblborder" cellspacing="0" cellpadding="0">
        <tr height="40px">
          <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
            <tr height="60px"><td colspan="4"></td></tr>
             <tr>
            	<td align="right" colspan="4"><b>For MAHIMA PURESPUN</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
           	 </tr>
             <tr>
               <td align="right" colspan="4">(A Unit Of Mahima Fibres Pvt. Ltd.)&nbsp;&nbsp;</td>
            	</tr>
              <tr height="40px"><td></td></tr>
              <tr>
                <td align="left">&nbsp;Prepared By</td>
                <td align="center">Dept. Head</td>
                <td align="center">Store Incharge</td>
                <td align="right">Passing Authority&nbsp;</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr height="60px">
  	<td><table width="100%" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</td>
  </tr>
</table>
  
</div>
<? } ?>                      
</body>
</html>
