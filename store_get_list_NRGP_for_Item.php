<?
include("inc/dbconnection.php");
include("inc/store_function.php");
include("inc/check_session.php");
if(isset($_REQUEST['value']))
{
	$val=$_REQUEST['value'];
}
else
	$val='';
if(($_REQUEST['byControl'])=='NRGP_id')
{
	$sql="select mm.NRGP_id,mm.NRGP_date,mm.supplier_id,mt.item_name from ms_NRGP_master mm,ms_NRGP_Item_transaction mt where mm.NRGP_id=mt.NRGP_id and mm.NRGP_id=$val order by mm.NRGP_id asc";
}
else if(($_REQUEST['byControl'])=='NRGPDate')
{
	$val=getDateFormate($val);
	$sql="select mm.NRGP_id,mm.NRGP_date,mm.supplier_id,mt.item_name from ms_NRGP_master mm,ms_NRGP_Item_transaction mt where mm.NRGP_id=mt.NRGP_id and mm.NRGP_date='".$val."' order by mm.NRGP_id asc";
}
else if(($_REQUEST['byControl'])=='Supplier')
{
	$sql="select mm.NRGP_id,mm.NRGP_date,mm.supplier_id,mt.item_name from ms_NRGP_master mm,ms_NRGP_Item_transaction mt where mm.NRGP_id=mt.NRGP_id and mm.supplier_id=$val order by mm.NRGP_id asc";
}
else if(($_REQUEST['byControl'])=='ItemName')
{
	$sql="select mm.NRGP_id,mm.NRGP_date,mm.supplier_id,mt.item_name from ms_NRGP_master mm,ms_NRGP_Item_transaction mt where mm.NRGP_id=mt.NRGP_id and mt.item_name like '".$val."%' order by mm.NRGP_id asc";
}
else if(($_REQUEST['byControl'])=='Department')
{
	$sql="select mm.NRGP_id,mm.NRGP_date,mm.supplier_id,mt.item_name from ms_NRGP_master mm,ms_NRGP_Item_transaction mt where mm.NRGP_id=mt.NRGP_id and mt.department_id=$val order by mm.NRGP_id asc";
}
//echo $sql;
//$sql = $sql ." LIMIT " . $start . ", $row_limit";
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());

?> 
<div class="AddMore" style="padding-top:10px">
	<form action="store_print_NRGP_list_Of_Item.php" name="test" id="test" method="post" target="_blank"> 
    <input type="hidden" name="value" id="value" value="<?=$_REQUEST['value'] ?>" />
    <input type="hidden" name="byControl" id="byControl" value="<?=$_REQUEST['byControl'] ?>" />
    <a href="#" onclick="test.submit();">Print&nbsp;&nbsp;&nbsp;</a>
 	</form>
</div>
<table align="center" width="100%" border="1" class="table1 text_1">
  <tr>
    <td class="gredBg">S.No.</td>
    <td class="gredBg">NRGP No.</td>
    <td class="gredBg">NRGP Date</td>
    <td class="gredBg">Supplier</td>
    <td class="gredBg">Item Name</td>
    <td width="4%" class="gredBg">View</td>  
    <td width="4%" class="gredBg">Edit</td>
    <td width="4%" class="gredBg">Delete</td>
 </tr>	
  <?  
  if(mysql_num_rows($result)>0)
  {
    $sno = 1;$oldid = "";$count =1;
    while($row=mysql_fetch_array($result))
    {	
      $sql_idate="select * from ms_NRGP_master where insert_date='".date('Y-m-d')."' and NRGP_id='".$row['NRGP_id']."'";
      $res_idate=mysql_query($sql_idate);	
      $row_idate=mysql_fetch_array($res_idate);
      $insert_date=$row_idate['insert_date'];
      ?>
      <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
        <td align="center"><?=$sno?></td>
        <td align="center"><?= $row['NRGP_id']?></td>
        <td align="center"><?=getDateFormate($row['NRGP_date']);?></td>
        <td align="left" style="padding-left:5px">
        <?
          $sql_sup= "select * from ms_supplier where supplier_id='".$row['supplier_id']."'";
          $res_sup = mysql_query ($sql_sup) or die (mysql_error());
          $row_sup = mysql_fetch_array($res_sup);
          echo $row_sup['name'];
         ?>
        </td>
        <td align="left" style="padding-left:5px"><?= $row['item_name']?></td>
       
        <?
        if($row['NRGP_id']!=$oldid)
        {
          $oldid = $row['NRGP_id'];
          $count=1;
        }
        $sql_tr="select * from ms_NRGP_Item_transaction where NRGP_id='".$oldid."'";
        $res_tr=mysql_query($sql_tr);
        $row_count=mysql_num_rows($res_tr);
				?>
				 <td align="center">
					 <a href="store_view_NRGP_for_Item.php?NRGP_id=<?=$row["NRGP_id"]?>">
						<img src="images/search-icon.gif" alt="View" title="View" border="0" />
					 </a>
					</td> 
				<?
				if($SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date))
				{
				?>
				<td align="center">
					<a href="store_add_NRGP_for_Item.php?NRGP_id=<?=$row["NRGP_id"]?>&mode=edit">
						<img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
					</a>
				</td>
				<td align="center">
					<a href="javascript:;" onClick="overlay(<?=$row["NRGP_id"]?>);">
					<img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0">
					</a>
				</td>
					<?
				}
        $count++;
      ?>                                     
     </tr>
    <?
     $sno++;
    }	
  }
  else
  {
    ?>
      <tr><td align="center" colspan="8"><b>No Record Found.</b></td></tr>
    <?
  }
  ?>
</table>