<? include ("inc/dbconnection.php");?>
<?
$id="";
$id = $_REQUEST['item_id'];
$sql = "SELECT mim.order_id FROM ms_item_master mitem, ms_order_master mim,ms_order_transaction mit where mit.item_id = '$id' and mim.order_id=mit.order_id and mit.item_id=mitem.item_code ";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
	echo  "<input name='po_no[]' id='po_no[]' type='text' value='".$row['order_id']."'  style='height:18px;width:100%'/>";	
}
?> 