<?
include("inc/dbconnection.php");
include("inc/store_function.php");

$PageFor = "NRGP";
$PageKey = "NRGP_id";
$PageKeyValue = "";
$Message = "";

//////////////////////////////////////////////////////////
$NRGP_id='';$NRGP_date='';$supplier_id='';$NRGP_type='';$ref_quot_no='';$ref_quot_date='';
$despatch_through='';$special_instr=''
;
$item_id='';$remarks='';$quantity='';$value='';$duedate='';
//////////////////////////////////////////////////////////
if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_NRGP_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$NRGP_date=getDateFormate($row['NRGP_date']);
		$supplier_id=$row['supplier_id'];
		$NRGP_type=$row['NRGP_type'];
		$ref_quot_no=$row['ref_quot_no'];	
		$ref_quot_date=getDateFormate($row['ref_quot_date']);
		$despatch_through=$row['despatch_through'];
		$special_instr=stripslashes($row['special_instr']);
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print NON RETURNABLE GATE PASS</title>
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
height:30px;
}
.tblborder
{
 border-collapse:collapse;border-color:1px solid #000;
}
</style>
</head>

<body onload="print();">
<div style="width:700px;margin:0 auto">
<table width="100%" class="tblborder" border="1" cellspacing="0" cellpadding="0">
  
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
          Phones : 07292 416300-328 Fax :07292 252985
        </td>
      </tr>
    </table>    
    </td>
  </tr>
  <tr>
    <td>
      <table align="center" width="100%" border="1" cellspacing="0" cellpadding="2" class="tblborder">
        <tr>
          <td align="center" colspan="2"><b style="font-size:20px">NON RETURNABLE GATE PASS</b></td>
        </tr>
        <tr>
          <td align="center">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="60%" style="border-right:1px solid #000">
                  <table width="100%" border="0" cellspacing="0" cellpadding="2">
                    <tr>
                      <td align="left"><b>To :</b></td>
                    </tr>
                    <tr>
                     <td align="left"><span style="margin-left:30px;">  
					  					<?
                        $sql_sup="select * from ms_supplier where code='".$supplier_id."' ";
                        $res_sup=mysql_query($sql_sup);
                        $row_sup=mysql_fetch_array($res_sup);
                        echo "<strong>".$row_sup['name']."</strong><br>";
												echo "<span style='margin-left:30px;'>".$row_sup['address']."</span><br>";
                       ?></span>
                        </td>
                    </tr>
                  </table>
                </td>
                <td width="40%">
                  <table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr>
                        <td align="left"><b>No. :</b></td>
                        <td align="left"><?= $PageKeyValue ?></td>
                      </tr>
                      <tr>
                        <td align="left"><b>Date :</b></td>
                        <td align="left"><?= $NRGP_date?></td>
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
          <td align="center">S.No.</td><td align="center">Item Description</td><td align="center">UOM</td><td align="center">Purpose</td>
          <td align="center">Qty.</td><td align="center">Rate</td>
        </tr>
        <?
        $sql_order_trans="SELECT * FROM ms_NRGP_master mom, ms_NRGP_transaction mot WHERE mom.NRGP_id = mot.NRGP_id AND mom.NRGP_id ='".$PageKeyValue."'";
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
            <td align="left" style="padding-left:10px">
              <?
              $sql_item="select * from ms_item_master where item_code='".$row_t['item_id']."' ";
              $res_item=mysql_query($sql_item);
              $row_item=mysql_fetch_array($res_item);
              echo $row_item['name']."<br>";
							echo "<strong>Draw. No. :</strong> " .$row_item['drawing_number']."<br>";
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
            <td align="center"><?=$row_t['remarks']?></td>
            <td align="center"><?=$row_t['quantity']?></td>
						<td align="center"><?=$row_t['rate']?></td>
          </tr>
          <?
          }
        }
        ?>
      </table>
    </td>
  </tr>
   <tr>
    <td align="left">
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr height="20px"><td width="27%"></td>
      </tr>
        <tr>
        	<td><span style="font-size:14px; margin-left:10px;"><b>DESPATCH THROUGH :</b></span></td><td width="70%"><?=$despatch_through?></td>
        </tr>

        <tr>
        	<td><span style="font-size:14px; margin-left:10px;"><b>SPECIAL INSTRUCTION :</b></span></td><td><?=$special_instr?></td>
        </tr>
        <tr height="20px"><td></td></tr>
  		</table>
  	</td>
  </tr>
  <tr>
  	<td>
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      	<tr height="60px"><td></td></tr>
        <tr>
          <td align="right"><b>For MAHIMA PURESPUN&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
        </tr>
        <tr height="10px"><td></td></tr>
        <tr>
          <td align="right">(A Unit Of Mahima Fibres Pvt. Ltd.)&nbsp;&nbsp;</td>
        </tr>
        <tr height="30px"><td></td></tr>
        <tr>
          <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;Reciever</td>
                <td align="center">Store Keeper</td>
                <td align="right">Authorised Signatory&nbsp;&nbsp;&nbsp;&nbsp;</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr height="10px"><td></td></tr>
      </table>
    </td>
  </tr>
</table>
  
</div>
                      
</body>
</html>
