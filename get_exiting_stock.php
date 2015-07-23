<? include ("inc/dbconnection.php");?>
<? include ("inc/store_function.php");?>
<?
$id="";
$company_id = $_GET["id"];
$product_id = $_GET["str"];
$date=date("Y-m-d");
/*$sql_count = "SELECT * FROM  ms_purchase_company_product_master where company_id ='$company_id' and product_id = '$product_id'";
$result_count = mysql_query ($sql_count) or die ("Error in : ".$sql_count."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result_count)>0)
{

	while($row_count = mysql_fetch_array($result_count))
	{
		echo $row_count['opening_stock']+ $row_count['existing_quantity'];
	}
 	
}*/
echo getStockOpeningQuantity($date,$product_id,$company_id);
?>         			