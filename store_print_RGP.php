<?
include("inc/dbconnection.php");
include("inc/store_function.php");

$PageFor = "RGP";
$PageKey = "RGP_id";
$PageKeyValue = "";

//////////////////////////////////////////////////////////
$RGP_id='';$RGP_date='';$supplier_id='';$ref_quot_no='';$ref_quot_date='';
$despatch_through='';$special_instr=''
;
$item_id='';$remarks='';$quantity='';$value='';$duedate='';
//////////////////////////////////////////////////////////
if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_RGP_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$RGP_date=getDateFormate($row['RGP_date']);
		$supplier_id=$row['supplier_id'];
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
<title>Print RETURNABLE/REPAIRABLE GATE PASS</title>
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
font-size:13px;
height:25px;
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
    		<td align="center" colspan="2"><b style="font-size:24px;">MAHIMA PURESPUN</b></td>
  		</tr>
      <tr>
        <td colspan="2" align="center">
          (A UNIT OF MAHIMA FIBRES PVT. LTD.)<br />
          Factory : PLOT No. 73 - 74 SECTOR-II, PITHAMPUR, DISTT DHAR<br />
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
          <td align="center" colspan="2"><b style="font-size:20px">RETURNABLE/REPAIRABLE GATE PASS</b></td>
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
                     <td align="left" style="padding-left:30px;font-size:12px">
					  					<?
                        $sql_sup="select * from ms_supplier where supplier_id='".$supplier_id."' ";
                        $res_sup=mysql_query($sql_sup);
                        $row_sup=mysql_fetch_array($res_sup);
                        echo "<b>".$row_sup['name']."</b><br />";
												echo $row_sup['address']."<br />";
                       ?>
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
                        <td align="left"><?= $RGP_date?></td>
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
          <td align="center">S.No.</td><td align="center">Item Description</td>
          <td align="center">UOM</td><td align="center">Purpose</td>
          <td align="center">Qty.</td><td align="center">Rate</td>
        </tr>
        <?
        $sql_order_trans="SELECT * FROM ms_RGP_master mom, ms_RGP_transaction mot WHERE mom.RGP_id = mot.RGP_id AND mom.RGP_id ='".$PageKeyValue."'";
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
            <td align="left" style="padding-left:10px"><?=$row_t['item_name']?></td>
            <td align="center">
            <? 
              $uname='';
						  $sql_uom = "SELECT name as uname FROM ms_uom where uom_id = '".$row_t['uom_id']."'";
							$result_uom = mysql_query ($sql_uom) or die ("Error in : ".$sql_uom."<br>".mysql_errno()." : ".mysql_error());
							if(mysql_num_rows($result_uom)>0)
							{
								$row_uom = mysql_fetch_array($result_uom);
								$uname= $row_uom['uname'];
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
        <tr>
        	<td><span style="font-size:12px; margin-left:10px;"><b>DESPATCH THROUGH :</b></span></td>
          <td width="70%"><?=$despatch_through?></td>
        </tr>
        <tr>
        	<td><span style="font-size:12px; margin-left:10px;"><b>SPECIAL INSTRUCTION :</b></span></td>
          <td><?=$special_instr?></td>
        </tr>
        <tr height="20px"><td></td></tr>
  		</table>
  	</td>
  </tr>
  <tr>
  	<td>
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      	<tr height="100px" valign="top">
        	<td align="center"><span style="font-size:12px;">(NOTE:- GATE PASS WITH ORIGINAL INVOICE COPY)</span></td>
        </tr>
        <tr>
          <td align="right"><b>For MAHIMA PURESPUN&nbsp;&nbsp;&nbsp;&nbsp;</b>
            <br />
            (A Unit Of Mahima Fibres Pvt. Ltd.)&nbsp;&nbsp;
          </td>
        </tr>
        <tr height="20px"><td></td></tr>
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
