<?
include("inc/check_session.php");
include("inc/dbconnection.php");
include("inc/common_function_mt_elect.php");
?>

<?
$id='';
if(isset($_REQUEST["value"]))
	$id = $_REQUEST["value"];
else
	$id = '';
$ItemReceivedId="";$ItemReceivedDate="";$ItemId="";
if($id!='')
{
	if(($_REQUEST['byControl'])=='IR_id')
	{
		$ItemReceivedId=" maint_item_received_master.IR_id ='".$id."'";
	}
	else if(($_REQUEST['byControl'])=='IRDate')
	{
		$date=getDateFormate($id);
		$ItemReceivedDate=" maint_item_received_master.IR_date ='".$date."' ";
	}
	else if(($_REQUEST['byControl'])=='Item')
	{
		$ItemId=" maint_item_received_transaction.item_id ='".$id."'";
	}
}
$sql="select * from maint_item_received_master, maint_item_received_transaction
 where 
	$ItemReceivedId
	$ItemReceivedDate
	$ItemId 
 and maint_item_received_transaction.IR_id =maint_item_received_master.IR_id 
 order by maint_item_received_master.IR_date asc";
$result=mysql_query($sql) or die(mysql_error());

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Job Report</title>
<style>
.note
{
font: Arial, Helvetica, sans-serif;
font-size:13px;
font-weight:bold;
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

</style>

</head>

<body onload="print();">
<div style="margin:0 auto;width:740px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <thead>
      <tr height="70px">
        <td align="center">
          <b><u>MAHIMA PURESPUN</u></b><br />
          <b>RECEIVED ITEM REPORT</b>
        </td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
        	<table align="center" width="100%" border="1" class="tblborder">
           <tr class="note">
              <td align="center" width="6%">S.No.</td>
              <td align="center" width="8%">IR No.</td>
              <td align="center" width="10%">IR Date.</td>
              <td align="center" width="46%">Item Desc</td>
              <td align="center" width="10%">Req. Qty.</td>
              <td align="center" width="10%">Rec. Qty.</td>
              <td align="center" width="10%">Pend. Qty.</td>
            </tr>	
          <?  
            if(mysql_num_rows($result)>0)
            {
							$sno =1;
							while($row=mysql_fetch_array($result))
							{	
								?>
								<tr class="particulars">
                  <td align="center"><?=$sno?></td>
                  <td align="center"><?= $row['IR_id']?></td>
                  <td align="center"><?= getDateFormate($row['IR_date'])?></td>
                  <td align="left" style="padding-left:3px">
                  <?
                  $sql_S="select * from ms_item_master where ms_item_master.item_id = '".$row['item_id']."'";
                  $res_S=mysql_query($sql_S) or die(mysql_error());
                  if(mysql_num_rows($res_S)>0)
                  {
                    while($row_S=mysql_fetch_array($res_S))
                    {
                     echo $row_S['name']." ;Drg No. ".$row_S['drawing_number']." ;Cat No. ".$row_S['catelog_number'];
                    }
                  }
                  ?>
                  </td>
                  <td align="center"><?= $row['req_qty']?></td>
                  <td align="center"><?= $row['rec_qty']?></td>
                  <td align="center"><?= $row['pend_qty']?></td>
								</tr>
								<?
								 $sno++;
								}	
							}
							else
							{
								?>
								<tr>
									<td colspan="7" align="center"><b>No Records Found</b></td>
								</tr> 
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
