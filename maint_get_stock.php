<? include ("inc/dbconnection.php");?>
<?
$id="";
$id = $_REQUEST['item_id'];
$sql = "SELECT * FROM  maint_item_stock where item_id = '$id'  ";
$result_item = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result_item)>0)
{
	$row_item = mysql_fetch_array($result_item);
	$stk=$row_item["maint_stock"];
	echo $stk;
}
else
{
	echo '0';
}
?> 