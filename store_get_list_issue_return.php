<?
include("inc/dbconnection.php");
include("inc/store_function.php");
include("inc/check_session.php");

if(date('m') > 03){	$gFinYear = date('Y').'-'.(date('Y')+1);	}else{	$gFinYear = (date('Y')-1).'-'.date('Y');	}

if(isset($_REQUEST['value'])){
	$val=$_REQUEST['value'];
}
else
	$val='';
if(($_REQUEST['byControl'])=='IRNo'){
	$sql="select * from ms_IR_master mim,ms_IR_transaction mit where mim.IR_id=mit.IR_id and mim.IR_id=$val order by mim.IR_date asc";
}else if(($_REQUEST['byControl'])=='Department'){
	$sql="select ms_IR_master.IR_id,ms_IR_master.IR_date,ms_IR_transaction.item_id,ms_IR_transaction.return_qty,
				ms_item_master.department_id
				from ms_IR_master, ms_IR_transaction,ms_item_master
				where ms_IR_master.IR_id=ms_IR_transaction.IR_id 
				and ms_item_master.item_id=ms_IR_transaction.item_id
				and ms_item_master.department_id=$val 
				and miem.finYear = '".$gFinYear."'
				order by ms_IR_master.IR_date asc";
}
else if(($_REQUEST['byControl'])=='Item')
{
	$sql="select * from ms_IR_master mim,ms_IR_transaction mit where mim.IR_id=mit.IR_id and mit.item_id=$val and miem.finYear = '".$gFinYear."' order by mim.IR_date asc";
}
else if(($_REQUEST['byControl'])=='IRDate')
{
	$val=getDateFormate($val);
	$sql="select * from ms_IR_master mim,ms_IR_transaction mit where mim.IR_id=mit.IR_id and mim.IR_date='".$val."' and miem.finYear = '".$gFinYear."' order by mim.IR_date asc";
}
//echo $sql;
//$sql = $sql ." LIMIT " . $start . ", $row_limit";
$result=mysql_query($sql);

?> 
<table align="center" id="tableReturn" width="100%" border="1" class="table1 text_1">
  <tr>
    <td class="gredBg">S.No.</td>
    <td class="gredBg">IR. no.</td>
    <td class="gredBg">IR. Date</td>
    <td class="gredBg">Item Name</td>
    <td class="gredBg">Ret. Qty.</td>
    <td width="4%" class="gredBg">View</td> 
    <td width="4%" class="gredBg">Edit</td>
    <td width="4%" class="gredBg">Delete</td>
  </tr>
  <?  
  if(mysql_num_rows($result)>0)
  {
    $sno = 1;
    while($row=mysql_fetch_array($result))
    {	
    $sql_idate="select * from ms_IR_master where insert_date='".date('Y-m-d')."' and IR_id='".$row['IR_id']."'";
    $res_idate=mysql_query($sql_idate);	
    $row_idate=mysql_fetch_array($res_idate);
    $insert_date=$row_idate['insert_date'];
    ?>
    <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
      <td align="center"><?=$sno?></td>
      <td align="center"><?= $row['IR_id']?></td>
      <td align="center"><?= getDateFormate($row['IR_date'])?></td>
      <td align="left" style="padding-left:5px">
        <?
        $sql_I="select * from ms_item_master where item_id= '".$row['item_id']."' ";
        $res_item=mysql_query($sql_I) or die(mysql_error());
        $row_item=mysql_fetch_array($res_item);
       echo $row_item['name'].';Drg No. '.$row_item['drawing_number'].';Cat No. '.$row_item['catelog_number'];
        ?>
      </td>
      <td align="center"><?=$row['return_qty']?></td>
      <td align="center">
        <a href="store_view_issue_return.php?IR_id=<?=$row["IR_id"]?>">
          <img src="images/search-icon.gif" alt="View" title="View" border="0" />
        </a>
      </td>
      <?
        if($SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date))
        {
        ?>
        <td align="center">
          <a href="store_add_issue_return.php?IR_id=<?=$row["IR_id"]?>&mode=edit">
            <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
          </a>
        </td>
        <td align="center">
          <a href="javascript:;" onClick="overlay(<?=$row["IR_transaction_id"]?>);">
            <img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0">
          </a>
        </td>
        <?
        }
        else
        {
        ?>
         <td></td>
         <td></td>   
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
      <td colspan="8" align="center" style="font-weight:bold">No Records Found</td>
    </tr>
  <?    
  }
 ?>
</table>        
              	