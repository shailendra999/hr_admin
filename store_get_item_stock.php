<? include ("inc/dbconnection.php");?>
<?
$id="";
$id = $_REQUEST['item_id'];$sno=$_REQUEST['sno'];
$sql = "SELECT * FROM  ms_item_master where item_id = '$id' order by name ";
$result_item = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result_item)>0)
{
	$row_item = mysql_fetch_array($result_item);
	$stk=$row_item["closing_stock"];
	echo '<input name="stk_qty[]" id="stk_qty_'.$sno.'" value="'.$stk.'" type="hidden" readonly="readonly"/>';
	echo $stk;
}
?> 