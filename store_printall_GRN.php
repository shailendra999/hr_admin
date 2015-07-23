<?
include("inc/dbconnection.php");
include("inc/store_function.php");

$PageFor = "GRN";
$PageKey = "GRN_id";
$PageKeyValue = "";
$Message = "";

$type_of_form='';
$cash='';
$supplier_id='';
$GRN_id='';
$dc_no='';
$dc_date='';
$grn_date='';
$inv_no='';
$inv_date='';$gp_no='';$gp_date='';
$othersamount='';$grossamount='';$netamount='';$remarks='';

$po_no='';$ind_no='';$po_qty='';$pend_qty='';$rec_qty='';$ecess_qty='';$short_qty='';$acc_qty='';
$godown='';$rate='';$disc_perc='';$p_and_f='';$duty_perc='';$ecess_perc='';$st_perc='';$sc_perc='';$add_amt='';$less_amt='';$net_rate='';$qc_loc='';
$mode = "";

?>
<?
if(isset($_GET["GRN_id"]))
{
	$GRN_id = $_GET["GRN_id"];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print All Goods Received Entry</title>
<style>
.note
{
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
	$sql = "select * from ms_GRN_master";
	
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		while($row=mysql_fetch_array($result))
		{
			$PageKeyValue=$row['GRN_id'];$supplier_id=$row['supplier_id'];$grn_date=getDateFormate($row['GRN_date']);
			$cash=$row['cash'];$type_of_form=$row['type_of_form'];$dc_no=$row['dc_number'];$dc_date=getDateFormate($row['dc_date']);
			$inv_no=$row['inv_number'];$inv_date=getDateFormate($row['inv_date']);$gp_no=$row['gp_number'];$gp_date=getDateFormate($row['gp_date']);
			$remarks=$row['remarks'];$grossamount=$row['gross_amount'];$othersamount=$row['others_amount'];$netamount=$row['net_amount'];
			$disc_amount=$row['disc_amount'];$duty_amount=$row['duty_amount'];$ecess_amount=$row['ecess_amount'];$st_amount=$row['st_amount'];
			$p_f_amt=0;$add_amt=0;
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
                  Tin No. :23390904470&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C.S.T. No. :&nbsp;&nbsp;&nbsp;&nbsp;
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
          <td align="center" colspan="2"><b style="font-size:20px">GOODS RECEIVED NOTE</b></td>
        </tr>
        <tr>
          <td align="center">
            <table width="100%" border="0"  cellspacing="0" cellpadding="2">
              <tr>
                <td align="left"><strong>No.:</strong></td>
                <td align="left"><?= $PageKeyValue ?></td>
                <td align="left"><strong>Date :</strong></td>
                <td align="left"><?= $grn_date ?></td>
              </tr>
            </table>
        	</td>
      	</tr>
      </table>
    </td>
  </tr>
  <tr>
  	<td>
    	<table width="100%" border="1" cellpadding="2" cellspacing="0" class="tblborder">
        <tr>
          <td align="left">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td align="left"><b>Received From:</b></td>
              </tr>
              <tr>
                <td class="note" style="padding-left:45px">
                  <?
                  $sql_sup="select * from ms_supplier where code=$supplier_id";
                  $res_sup=mysql_query($sql_sup);
                  $row_sup=mysql_fetch_array($res_sup);
                  echo '<b>'.$row_sup['name'].'</b>';
                  ?>
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
          <td align="center">S.No.</td><td align="center">Particulars</td><td align="center">UOM</td>
          <td align="center">Po. No.</td><td align="center">Qty.</td><td align="center">Rate</td><td align="center">Amount</td>
        </tr>
       	<?
				$sql_GRN_trans="SELECT * FROM ms_GRN_master mgm,ms_GRN_transaction mgt WHERE mgm.GRN_id=mgt.GRN_id AND mgm.GRN_id ='".$row['GRN_id']."'";
				$res_GRN_trans=mysql_query($sql_GRN_trans);
				$countTrans=1;
				$rc_trans=mysql_num_rows($res_GRN_trans);
				if($rc_trans>0)
				{
					while($row_t=mysql_fetch_array($res_GRN_trans))
					{
						$p_f_amt+=$row_t['p_and_f'];
						$add_amt+=$row_t['add_amt'];
					?>
          <tr class="particulars">
            <td align="center"><?= $countTrans++?></td>
            <td align="left" style="padding-left:10px">
              <?
              $sql_item="select * from ms_item_master where item_code=$row_t[item_id]";
              $res_item=mysql_query($sql_item);
              $row_item=mysql_fetch_array($res_item);
              echo $row_item['name'];
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
            <td align="center"><?=$row_t['po_number']?></td>
            <td align="center"><?=$row_t['recieved_quantity']?></td>
            <td align="center"><?=$row_t['rate']?></td>
            <td align="center"><? echo $amt=$row_t['rate']*$row_t['recieved_quantity']?></td>
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
    	<table width="100%" border="1" class="tblborder" cellspacing="0" cellpadding="0">
      	<tr>
        	<td width="50%" class="note" valign="top">
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
              <tr>
                <td align="left">DC No. :</td>
                <td align="left"><?= $dc_no ?></td>
              </tr>
              <tr>
                <td align="left">DC Date :</td>
                <td align="left"><?= $dc_date ?></td>
              </tr>
              <tr>
                <td align="left">Inv No. :</td>
                <td align="left"><?=$inv_no?></td>
              </tr>
              <tr>
                <td align="left">Inv. Date :</td>
                <td align="left"><?= $inv_date ?></td>
              </tr>
              <tr>
                <td align="left">Purpose :</td>
                <td align="left"><?= $remarks ?></td>
              </tr>
            </table>
          </td>
          <td width="50%" class="note" valign="top">
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
							<tr>
                <td align="left">Disc Amount :</td>
                <td align="left"><?= $disc_amount?></td>
              </tr>
              <tr>
                <td align="left">Pack. And Forwd Amount :</td>
                <td align="left"><?= $p_f_amt?></td>
              </tr>
              <tr>
                <td align="left">Duty Amount :</td>
                <td align="left"><?= $duty_amount?></td>
              </tr>
							<tr>
                <td align="left">E.Cess Amount :</td>
                <td align="left"><?= $ecess_amount?></td>
              </tr>
              <tr>
                <td align="left">ST Amount :</td>
                <td align="left"><?= $st_amount?></td>
              </tr>
              <tr>
                <td align="left">Add Amount :</td>
                <td align="left"><?= $add_amt?></td>
              </tr>
              <tr>
                <td align="left">Net Amount :</td>
                <td align="left"><?= $netamount?></td>
              </tr>
            </table>
          </td>
        </tr>
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
                <td align="left">&nbsp;Prepared By</td>
                <td align="center">Checked By</td>
                <td align="right">Authorised Signatory&nbsp;</td>
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
