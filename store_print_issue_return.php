<?
include("inc/dbconnection.php");
include("inc/store_function.php");
$PageFor = "Issue Return";
$PageKey = "IR_id";
$PageKeyValue = "";
$Message = "";
$mode="";
if(isset($_GET['mode']))
{
	$mode=$_GET['mode'];
}
//////////////////////////////////////////////////////////
$issue_id='';$purpose='';$issue_date='';
$item_id='';$stk_qty='';$req_qty='';$iss_qty='';$godown='';$department_id='';$machinary_id='';
//////////////////////////////////////////////////////////
if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_IR_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$remarks=stripslashes($row['remarks']);
		$issue_date=getDateFormate($row['IR_date']);		
	}
}

if(isset($_GET["IR_id"]))
{
	$issue_id = $_GET["IR_id"];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Issue Return</title>

<style>
.note
{
padding-left:25px;
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

<body>
<div style="width:700px;margin:0 auto">
<table width="100%" border="1" class="tblborder" cellspacing="0" cellpadding="0">
  <tr>
  	<td>
      <table align="center" width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
    		<td style="padding-left:30%" colspan="2"><b style="font-size:24px;">MAHIMA PURESPUN</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>TIN No.</b></td>
  		</tr>
      <tr>
        <td colspan="2" align="center">
          (A UNIT OF MAHIMA FIBRES PVT. LTD.)<br />
          Factory : PLOT No. 73 - 74 SECTOR-II, PITHAMPUR, DISTT DHAR<br />
          Phones : 07292 416300-328 Fax :07292 252985<br />
          <b>CST. No.</b>
        </td>
      </tr>
    </table>    
    </td>
  </tr>
  <tr>
    <td>
      <table align="center" width="100%" border="1" cellspacing="0" cellpadding="2" class="tblborder">
        <tr>
          <td align="center" colspan="2"><b style="font-size:20px">Issue Return</b></td>
        </tr>
        <tr>
          <td><b>No. :</b><span style="margin-left:10px;"><?=$PageKeyValue?></span></td>
          <td><b>Date :</b><span style="margin-left:10px;"><?=$issue_date?></span></td>
        </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td>
    	<table align="center" width="100%" border="1" cellspacing="0" cellpadding="2" class="tblborder">
        <tr style="font-weight:bold">
          <td align="center">S.No.</td><td align="center">Particulars</td>
          <td align="center">UOM</td>
          <td align="center">Return Qty.</td>
        </tr>
        <?
        $sql_order_trans="SELECT * FROM ms_IR_master mom, ms_IR_transaction mot WHERE mom.IR_id = mot.IR_id AND mom.IR_id ='".$PageKeyValue."'";
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
            <td align="left" style="padding-left:10px;">
              <?
              $sql_item="select * from ms_item_master where item_id=$row_t[item_id]";
              $res_item=mysql_query($sql_item);
              $row_item=mysql_fetch_array($res_item);
              echo $row_item['name'].'<br /><b>Drg. No. </b>'.$row_item['drawing_number'].'<br /><b>Cat. No. </b>'.$row_item['catelog_number'];
              ?>
            </td>
            <td align="center">
            <? 
              $id = $row_t['item_id'];
              $sql = "SELECT * FROM  ms_item_master where item_id = '$id' order by name ";
              $result_item = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
              $uname='';
              if(mysql_num_rows($result_item)>0)
              {
                $row_item = mysql_fetch_array($result_item);
                $sql_uom = "SELECT name as uname FROM  ms_uom where uom_id = '".$row_item['uom_id']."' order by name ";
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
            <td align="center"><?=$row_t['return_qty']?></td>
          </tr>
          <?
          }
        }
        ?>
      </table>
    </td>
  </tr>
  <tr>
  <tr height="150px" valign="top">
  	<td valign="bottom" style="padding-bottom:10px">
    	<table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td align="left">&nbsp;<b>Purpose</b></td>
  		  <td align="right"><b>For MAHIMA PURESPUN</b>&nbsp;&nbsp;</td>
        </tr>
        <tr>
          <td align="left" style="padding-left:25px;"><?=$remarks?></td>
          <td align="right">(A Unit Of Mahima Fibres Pvt. Ltd.)&nbsp;&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>

 
  
</div>
                    
</body>
</html>
