<?
include("inc/dbconnection.php");
include("inc/store_function.php");
$PageFor = "Purchase Order";
$PageKey = "issue_entry_id";
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
if(isset($_GET["issue_entry_id"]))
{
	$issue_id = $_GET["issue_entry_id"];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Issue Entry</title>

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

<body onload="print();">
<?
	$sql = "select * from ms_issue_entry_master ";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		while($row = mysql_fetch_array($result))
		{
			$PageKeyValue = $row[$PageKey];
			$purpose=stripslashes($row['purpose']);
			$issue_date=getDateFormate($row['issue_entry_date']);		
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
                <td align="center" colspan="2"><b style="font-size:24px;">MAHIMA PURESPUN.</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>TIN No.</b></td>
              </tr>
              <tr>
                <td colspan="2" align="center">
                  (A UNIT OF MAHIMA FIBRES PVT. LTD.)<br />
                  Factory : PLOT No. 73 - 74 SECTOR-11, PITHAMPUR, DIST DHAR<br />
                  Phones : 07292 252995,252963 Fax :07292 252985<br />
                  <b>CST. No. :</b>
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
          <td align="center" colspan="2"><b style="font-size:20px">Issue Entry</b></td>
        </tr>
        <tr>
          <td><b>No. :</b><span style="margin-left:10px;"><?=$PageKeyValue?></span></td><td><b>Date :</b><span style="margin-left:10px;"><?=$issue_date?></span></td>
        </tr>
        <tr>
          <td align="center" colspan="2">
              <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                  <td align="left"><b>Recieved By :</b></td>
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
          <td align="center"> Stk. Qty.</td><td align="center">Iss. Qty.</td><td align="center">Department</td>
        </tr>
        <?
        $sql_order_trans="SELECT * FROM ms_issue_entry_master mom, ms_issue_entry_transaction mot WHERE mom.issue_entry_id = mot.issue_entry_id AND mom.issue_entry_id ='".$row['issue_entry_id']."'";
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
            <td align="center"><?=$row_t['stk_qty']?></td>
            <td align="center"><?=$row_t['iss_qty']?></td>
            <td align="center">
             <?php
			 $sql_dept= "select * from ms_department where department_code='".$row_t['department_id']."' ";
			 $res_dept = mysql_query ($sql_dept) or die ("Invalid query : ".$sql_dept."<br>".mysql_errno()." : ".mysql_error());
			 if(mysql_num_rows($res_dept)>0)
			 {
			   $row_dept = mysql_fetch_array($res_dept);
			   {
					echo $row_dept['name'];
			   }
			 }	
			?>
            </td>
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
              <tr>
                <td align="left">&nbsp;<b>Purpose</b></td>
              <td align="right"><b>For MAHIMA PURESPUN</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
              </tr>
               <tr>
                <td align="left" style="padding-left:25px;"><?=$purpose?></td>
                 <td align="right">(A Unit Of Mahima Fibres Pvt. Ltd.)&nbsp;&nbsp;</td>
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
