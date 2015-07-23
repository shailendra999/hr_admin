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
	if(($_REQUEST['byControl'])=='IC_id')
	{
		$ItemReceivedId=" maint_item_consumption_master.IC_id ='".$id."'";
	}
	else if(($_REQUEST['byControl'])=='ICDate')
	{
		$date=getDateFormate($id);
		$ItemReceivedDate=" maint_item_consumption_master.IC_date ='".$date."' ";
	}
	else if(($_REQUEST['byControl'])=='Item')
	{
		$ItemId=" maint_item_consumption_transaction.item_id ='".$id."'";
	}
}
$sql="select * from maint_item_consumption_master, maint_item_consumption_transaction
 where 
	$ItemReceivedId
	$ItemReceivedDate
	$ItemId 
 and maint_item_consumption_transaction.IC_id =maint_item_consumption_master.IC_id 
 order by maint_item_consumption_master.IC_date asc";
$result=mysql_query($sql) or die(mysql_error());

?>


<div class="AddMore" style="padding-top:10px">
	<form action="maint_print_item_consumption.php" name="test" id="test" method="post" target="_blank"> 
    <input type="hidden" name="value" id="value" value="<?=$_REQUEST['value'] ?>" />
    <input type="hidden" name="byControl" id="byControl" value="<?=$_REQUEST['byControl'] ?>" />
    <a href="javascript:;" onclick="test.submit();">Print&nbsp;&nbsp;&nbsp;</a>
 	</form>
</div> 

<table align="center" width="100%" border="1" class="table1 text_1">
 <tr>
    <td class="gredBg" width="7%">S.No.</td>
    <td class="gredBg" width="8%">IC No.</td>
    <td class="gredBg" width="10%">IC Date.</td>
    <td class="gredBg" width="52%">Item Desc</td>
    <td class="gredBg" width="8%">Cons. Qty.</td>
    <td width="5%" class="gredBg">View</td>
    <td width="5%" class="gredBg">Edit</td>
    <td width="5%" class="gredBg">Delete</td>
  </tr>	
  <?  
  if(mysql_num_rows($result)>0)
  {
    $sno =1;
    while($row=mysql_fetch_array($result))
    {	
      $sql_idate="select * from maint_item_consumption_master where insert_date='".date('Y-m-d')."' and IC_id='".$row['IC_id']."'";
      $res_idate=mysql_query($sql_idate);
      $row_idate=mysql_fetch_array($res_idate);
      $insert_date=$row_idate['insert_date'];
      ?>
      <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
      <td align="center"><?=$sno?></td>
      <td align="center"><?= $row['IC_id']?></td>
      <td align="center"><?= getDateFormate($row['IC_date'])?></td>
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
      <td align="center"><?= $row['cons_qty']?></td>
      <td align="center">
        <a href="maint_view_item_consumption.php?IC_id=<?=$row["IC_id"]?>">
        <img src="images/search-icon.gif" alt="View" title="View" border="0" /></a>
      </td>
      <?
        if($SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date))
        {
        $colspan=8;
        ?>
        <td align="center">
        <a href="maint_add_item_consumption.php?IC_id=<?=$row["IC_id"]?>&mode=edit">
          <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
        </a>
        </td>
        <td align="center">
        <a href="javascript:;" onClick="overlay(<?=$row["IC_transaction_id"]?>,<?=$row["item_id"]?>,<?=$row["cons_qty"]?>);">
          <img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0">
        </a>
        </td>
        <?
         }
         else
         {
        ?>
        <td align="center"></td>
        <td align="center"></td>
       <?
        }
       ?>
      </tr>
      <?
       $sno++;
      }	
  }
  else
  {
      ?>
    <tr>
    <td colspan="8" align="center"><b>No Records Found</b></td>
    </tr> 
    <?
  }
?>        
</table>
