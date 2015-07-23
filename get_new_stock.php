<? include ("inc/dbconnection.php");?>
<?
$count = $_GET["count"];
$id = $_GET["id"];
$Date = $_GET["Date"];

	$sql_stock = "SELECT SUM(StockInKgs) as TotalNewStock FROM  ".$mysql_adm_table_prefix."stock_master where CountId = '$id' and Date = '$Date' order by Date ";
$result_stock = mysql_query($sql_stock) or die("Error in Query:".$sql_stock."<br>".mysql_errno().":".mysql_error());
if(mysql_num_rows($result_stock)>0)	
{
	$row_stock=mysql_fetch_array($result_stock);
	echo $row_stock["TotalNewStock"];
	
}
?>