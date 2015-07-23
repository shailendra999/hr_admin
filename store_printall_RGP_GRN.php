<?
include("inc/dbconnection.php");
include("inc/store_function.php");

$PageFor = "RGP GRN";
$PageKey = "RGP_GRN_id";
$PageKeyValue = "";

$RGP_GRN_id='';$RGP_GRN_date='';$department_id='';$supplier_id='';
$dc_no='';$dc_date='';$inv_no='';$inv_date='';$gp_no='';$gp_date='';
$othersamount='';$grossamount='';$netamount='';$purpose='';

$item_id='';$RGP_no='';$purpose_trans='';$RGP_qty='';$pend_qty='';$rec_qty='';$acc_qty='';$godown='';
$rate='';$disc_perc='';$duty_perc='';$ecess_perc='';$st_perc='';$sc_perc='';$add_amt='';$less_amt='';$net_rate='';$qc_loc='';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print All GOODS RECEIVED NOTE (RGP)</title>
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
	$sql = "select * from ms_RGP_GRN_master ";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		while($row=mysql_fetch_array($result))
		{
			$PageKeyValue=$row['RGP_GRN_id'];$supplier_id=$row['supplier_id'];$RGP_GRN_date=getDateFormate($row['RGP_GRN_date']);
			$department_id=$row['department_id'];$dc_no=$row['dc_number'];$dc_date=getDateFormate($row['dc_date']);
			$inv_no=$row['inv_number'];$inv_date=getDateFormate($row['inv_date']);$gp_no=$row['gp_number'];$gp_date=getDateFormate($row['gp_date']);
			$purpose=$row['purpose'];$grossamount=$row['gross_amount'];$othersamount=$row['others_amount'];$netamount=$row['net_amount'];

?>
<div style="width:700px;margin:0 auto">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
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
                  Phones : 07292 252995,252963 Fax :07292 252985<br />
                  <b>Tin No. :</b>
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
          <td align="center" colspan="2"><b style="font-size:20px">GOODS RECEIVED NOTE (RGP)</b></td>
        </tr>
        <tr>
          <td align="center">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="60%" style="border-right:1px solid #000">
                  <table width="100%" border="0" cellspacing="0" cellpadding="2">
                    <tr>
                      <td align="left"><b>Recieved From :</b></td>
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
                        <td align="left"><b> No. :</b></td>
                        <td align="left"><?= $PageKeyValue ?></td>
                      </tr>
                      <tr>
                        <td align="left"><b> Date :</b></td>
                        <td align="left"><?= $RGP_GRN_date?></td>
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
          <td align="center">S.No.</td><td align="center">Particulars</td><td align="center">Purpose</td>
          <td align="center">RGP Qty.</td><td align="center">Rec. Qty.</td><td align="center">Acc. Qty.</td>
        </tr>
        <?
        $sql_order_trans="SELECT * FROM ms_RGP_GRN_master mom, ms_RGP_GRN_transaction mot WHERE mom.RGP_GRN_id = mot.RGP_GRN_id AND mom.RGP_GRN_id ='".$PageKeyValue."'";
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
              echo $row_item['name'];
              ?>
            </td>
            <td align="center"><?=$row_t['purpose_trans']?></td>
            <td align="center"><?=$row_t['RGP_qty']?></td>
            <td align="center"><?=$row_t['rec_qty']?></td>
            <td align="center"><?=$row_t['acc_qty']?></td>
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
        <tr height="180px">
          <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
             <tr height="40px">
                <td align="right" colspan="3"><b>For MAHIMA PURESPUN&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
              </tr>
              <tr>
                <td align="right" colspan="3">(A Unit Of Mahima Fibres Pvt. Ltd.)&nbsp;&nbsp;</td>
              </tr>
              <tr height="40px"><td></td></tr>
              <tr>
                <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Prepared By</td>
                <td align="center">&nbsp;</td>
                <td align="right">Authorised Signatory&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
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
<?
	}
}

?>                      
</body>
</html>
