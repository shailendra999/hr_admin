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
if(($_REQUEST['byControl'])=='POid')
{
	$sql="select mrgm.order_id,mrgm.order_date,mrgm.supplier_id,mrgt.item_id,mrt.indent_transaction_id,mrgm.indent_id,mrgt.po_qty,mrgt.pend_qty from ms_order_master mrgm,ms_order_transaction mrgt,ms_indent_transaction mrt where mrgm.order_id=mrgt.order_id and mrgm.order_id=$val and mrt.indent_transaction_id=mrgt.indent_transaction_id order by mrgm.order_id asc";
}
if(($_REQUEST['byControl'])=='PODate')
{
	$val=getDateFormate($val);
	$sql="select mrgm.order_id,mrgm.order_date,mrgm.supplier_id,mrgt.item_id,mrt.indent_transaction_id,mrgm.indent_id,mrgt.po_qty,mrgt.pend_qty from ms_order_master mrgm,ms_order_transaction mrgt,ms_indent_transaction mrt where mrgm.order_id=mrgt.order_id and mrgm.order_date='".$val."' and mrt.indent_transaction_id=mrgt.indent_transaction_id order by mrgm.order_id asc";
}
else if(($_REQUEST['byControl'])=='Supplier')
{
	$sql="select mrgm.order_id,mrgm.order_date,mrgm.supplier_id,mrgt.item_id,mrt.indent_transaction_id,mrgm.indent_id,mrgt.po_qty,mrgt.pend_qty from ms_order_master mrgm,ms_order_transaction mrgt,ms_indent_transaction mrt where mrgm.order_id=mrgt.order_id and mrgm.supplier_id=$val and mrt.indent_transaction_id=mrgt.indent_transaction_id order by mrgm.order_id asc";
}
else if(($_REQUEST['byControl'])=='ItemName')
{
	$sql="select mrgm.order_id,mrgm.order_date,mrgm.supplier_id,mrgt.item_id,mrt.indent_transaction_id,mrgm.indent_id,mrgt.po_qty,mrgt.pend_qty from ms_order_master mrgm,ms_order_transaction mrgt,ms_indent_transaction mrt where mrgm.order_id=mrgt.order_id and mrgt.item_id = '".$val."' and mrt.indent_transaction_id=mrgt.indent_transaction_id order by mrgm.order_id asc";
}
//echo $sql;
//$sql = $sql ." LIMIT " . $start . ", $row_limit";
$result=mysql_query($sql);

?> 
<table align="center" width="100%" cellpadding="0" cellspacing="0" border="1" class="table1 text_1">
  <tr>
    <td class="gredBg" width="5%">S.No.</td>
    <td class="gredBg" width="5%">PO No.</td>
    <td class="gredBg" width="8%">PO date</td>
    <td class="gredBg" width="7%">IndentNo.</td>
    <td class="gredBg" width="20%">Supplier</td>
    <td class="gredBg" width="30%">Item Name</td>
    <td class="gredBg" width="6%">PO.Qty.</td>
    <td class="gredBg" width="7%">Pend.Qty.</td>
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
      $sql_idate="select * from ms_order_master where insert_date='".date('Y-m-d')."' and order_id='".$row['order_id']."'";
      $res_idate=mysql_query($sql_idate);	
      $row_idate=mysql_fetch_array($res_idate);
      $insert_date=$row_idate['insert_date'];	
    ?>
    <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
      <td align="center"><?=$sno?></td>
      <td align="center"><?=$row['order_id']?></td>
      <td align="center"><?=getDateFormate($row['order_date'])?></td>
      <td align="center"><?=$row['indent_id']?></td>
      <td align="left" style="padding-left:5px">
      <?
        $sql_sup= "select * from ms_supplier where supplier_id='".$row['supplier_id']."' ";
        $res_sup = mysql_query ($sql_sup) or die (mysql_error());
        $row_sup = mysql_fetch_array($res_sup);
        echo $row_sup['name'];
        ?>
      </td>
      <td align="left" style="padding-left:5px">
      <?
        $sql_I= "select * from ms_item_master where item_id='".$row['item_id']."' ";
        $res_I = mysql_query ($sql_I) or die (mysql_error());
        $row_I = mysql_fetch_array($res_I);
         echo $row_I['name'].';Drg No. '.$row_I['drawing_number'].';Cat No. '.$row_I['catelog_number'];
        ?>
      </td>
      <td align="center"><?=$row['po_qty']?></td>
      <td align="center"><?=$row['pend_qty']?></td>
      <td align="center">
        <a href="store_view_purchase_order.php?order_id=<?=$row["order_id"]?>">
        <img src="images/search-icon.gif" alt="View" title="View" border="0" /></a>
      </td>
			<?
      if(1)
      {//$SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date)
      ?>
        <td align="center">
          <a href="store_add_purchase_order.php?order_id=<?=$row["order_id"]?>&mode=edit">
            <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
          </a>
        </td>
        <td align="center">
          <a href="javascript:;" onClick="overlay(<?=$row_t['order_transaction_id']?>);">
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
      <tr><td align="center" colspan="11"><b>No Record Found.</b></td></tr>
    <?
  }	
 ?>         
</table>