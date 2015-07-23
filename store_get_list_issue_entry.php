<?
include("inc/dbconnection.php");
include("inc/store_function.php");
include("inc/check_session.php");

if(date('m') > 03){	$gFinYear = date('Y').'-'.(date('Y')+1);	}else{	$gFinYear = (date('Y')-1).'-'.date('Y');	}

if(isset($_REQUEST['value']))
{
	$val=$_REQUEST['value'];
}
else
	$val='';
if(($_REQUEST['byControl'])=='IENo')
{
	$sql="select * from ms_IE_master mim,ms_IE_transaction mit where mim.IE_id=mit.IE_id and mim.IE_id=$val and mim.finYear = '".$gFinYear."' order by mim.IE_date asc";
}
else if(($_REQUEST['byControl'])=='Department')
{
	$sql="select ms_IE_master.IE_id,ms_IE_master.IE_date,ms_IE_transaction.item_id,ms_IE_transaction.iss_qty,
				ms_item_master.department_id
				from ms_IE_master, ms_IE_transaction,ms_item_master
				where ms_IE_master.IE_id=ms_IE_transaction.IE_id 
				and ms_item_master.item_id=ms_IE_transaction.item_id
				and ms_item_master.department_id=$val 
				and ms_IE_master.finYear = '".$gFinYear."'
				order by ms_IE_master.IE_date asc";
}
else if(($_REQUEST['byControl'])=='Item')
{
	$sql="select * from ms_IE_master mim,ms_IE_transaction mit where mim.IE_id=mit.IE_id and mit.item_id=$val and mim.finYear = '".$gFinYear."' order by mim.IE_date asc";
}
else if(($_REQUEST['byControl'])=='IEDate')
{
	$val=getDateFormate($val);
	$sql="select * from ms_IE_master mim,ms_IE_transaction mit where mim.IE_id=mit.IE_id and mim.IE_date='".$val."' and mim.finYear = '".$gFinYear."' order by mim.IE_date asc";
}
//echo $sql;
//$sql = $sql ." LIMIT " . $start . ", $row_limit";
$result=mysql_query($sql);
if(($_REQUEST['byControl'])=='IEDate')
{
?>
<div style="float:right;padding-right:25px;">
 <a href="store_print_issue_entry_By_Date.php?IE_date=<?=$val?>" target="_blank" class="AddMore"><b>Print</b></a>
</div>
<?
}
?>
<table align="center" id="tableEntry" width="100%" border="1" class="table1 text_1">
  <tr>
    <td class="gredBg" width="8%">S.No.</td>
    <td class="gredBg" width="10%">Issue No.</td>
    <td class="gredBg" width="12%">Issue Date</td>
    <td class="gredBg" width="48%">Item Name</td>
    <td class="gredBg" width="10%">Issue Qty.</td>
    <td width="4%" class="gredBg">View</td>
    <td width="4%" class="gredBg">Edit</td>
    <td width="4%" class="gredBg">Delete</td>
  </tr>
  <?  
  if(mysql_num_rows($result)>0)
  {
    $sno = 1;$oldid = "";$count =1;$flag=0;                         
    while($row=mysql_fetch_array($result))
    {	
      $sql_idate="select * from ms_IE_master where insert_date='".date('Y-m-d')."' and IE_id='".$row['IE_id']."'";
      $res_idate=mysql_query($sql_idate);	
      $row_idate=mysql_fetch_array($res_idate);
      $insert_date=$row_idate['insert_date'];
    ?>
      <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
        <td align="center"><?=$sno?></td>
        <td align="center"><?= $row['IE_id']?></td>
        <td align="center"><?= getDateFormate($row['IE_date'])?></td>
        <td align="left" style="padding-left:5px">
        <?
        $sql_I="select * from ms_item_master where item_id= '".$row['item_id']."' ";
        $res_item=mysql_query($sql_I) or die(mysql_error());
        $row_item=mysql_fetch_array($res_item);
       echo $row_item['name'].';Drg No. '.$row_item['drawing_number'].';Cat No. '.$row_item['catelog_number'];
        ?>
        </td>
        <td align="center"><?= $row['iss_qty']?></td>
        <td align="center">
          <a href="store_view_issue_entry.php?IE_id=<?=$row["IE_id"]?>">
          <img src="images/search-icon.gif" alt="View" title="View" border="0" /></a>            
        </td>
				<?
        if($SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date))
        {
        ?>
        <td align="center">
          <a href="store_add_issue_entry.php?IE_id=<?=$row["IE_id"]?>&mode=edit">
            <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
          </a>
        </td>
        <td align="center">
          <a href="javascript:;" onClick="overlay(<?=$row["IE_transaction_id"]?>);">
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

	      
			