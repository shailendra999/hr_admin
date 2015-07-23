<? include ("inc/dbconnection.php");?>
<?
$id="";
$id = $_REQUEST['item_id'];
$sql = "SELECT mit.quantity FROM ms_item_master mitem, ms_RGP_master mim,ms_RGP_transaction mit where mit.item_id = '$id' and mim.RGP_id=mit.RGP_id and mit.item_id=mitem.item_code";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
	echo  "<input name='RGP_qty[]' id='RGP_qty[]' type='text' value='".$row['quantity']."'  style='height:18px;width:100%'/>";	
}
?> 