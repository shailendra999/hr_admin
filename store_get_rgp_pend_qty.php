<? include ("inc/dbconnection.php");?>
<?
$id="";
$id = $_REQUEST['item_id'];
$res=mysql_query("select min(mrgt.pend_qty) as pend_qty from ms_RGP_GRN_transaction mrgt,ms_item_master mis where mis.item_code=mrgt.item_id and mis.item_code='$id'");
$row=mysql_fetch_array($res);
if(mysql_num_rows($res)>0 && $row["pend_qty"]!="")
{
	
	//$pq=$row[]-$row['pend_qty'];
	echo  "<input name='pend_qty[]' id='pend_qty[]' type='text' value='".$row['pend_qty']."'  style='height:18px;width:100%'/>";	
}
else
{
	$sql = "SELECT mit.quantity FROM ms_item_master mitem, ms_RGP_master mim,ms_RGP_transaction mit where mit.item_id = '$id' and mim.RGP_id=mit.RGP_id and mit.item_id=mitem.item_code";
	$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row=mysql_fetch_array($result);
		echo  "<input name='pend_qty[]' id='pend_qty[]' type='text' value='".$row['quantity']."'  style='height:18px;width:100%'/>";	
	}
}
?> 