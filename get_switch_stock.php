<? include ("inc/check_session.php");?>
<? include ("inc/dbconnection.php");?>
<? include ("inc/adm_function.php");?>
<?
$id = $_GET["id"];

$sql_stock = "select * from ".$mysql_adm_table_prefix."stock_master where rec_id = '$id'";
//echo "<br><br>";
$result_stock = mysql_query($sql_stock) or die("Error in Query:".$sql_stock."<br>".mysql_errno().":".mysql_error());

if(mysql_num_rows($result_stock)>0)	
{
	$row_stock = mysql_fetch_array($result_stock);
	
	$StockId = $row_stock["rec_id"];
	$CountId =  $row_stock["CountId"];
	$LotNumber =  $row_stock["LotNumber"];
	$NumberOfBags =  $row_stock["NumberOfBags"];
	$StockInKgs =  $row_stock["StockInKgs"];
	$StockInBale =  $row_stock["StockInBale"];
	$Date =  $row_stock["Date"];
	$IpAddress = $_SERVER['REMOTE_ADDR'];
	
	$sql_stock_box = "select * from ".$mysql_adm_table_prefix."stock_box where StockId = '$StockId' order by rec_id";
	//echo "<br><br>";
	$result_stock_box = mysql_query($sql_stock_box) or die("Error in query:".$sql_stock_box."<br>".mysql_error().":".mysql_errno());
	
	if(mysql_num_rows($result_stock_box)>0)
	{
		$CountName =  getCount("Count", "rec_id", $CountId);
			
		$sql_count = "select * from ".$mysql_adm_table_prefix."count_master where Count = '$CountName' and rec_id != '$CountId'";
		//echo "<br><br>";
		$result_count = mysql_query($sql_count) or die("Error in query:".$sql_count."<br>".mysql_error().":".mysql_errno());

		$SwitchCountId = "";

		if(mysql_num_rows($result_count)>0)
		{
			$row_count = mysql_fetch_array($result_count);
			$SwitchCountId = $row_count["rec_id"];
		}
		
		$SwitchedId = getStockDetail("rec_id", "SwitchedFrom", $StockId);
		
		if($SwitchedId=="")
		{
			$sql_insert_stock = "insert into ".$mysql_adm_table_prefix."stock_master set 
																				CountId = '$SwitchCountId',
																				LotNumber = '".$LotNumber."',
																				NumberOfBags = '".$NumberOfBags."',
																				StockInKgs = '".$StockInKgs."',
																				StockInBale = '".$StockInBale."',
																				Date = '".$Date."',
																				SwitchedFrom = '".$StockId."',
																				InsertBy = '$SessionUserType',
																				InsertDate = now(),
																				IpAddress = '$IpAddress'";
			
			mysql_query($sql_insert_stock) or die("Error in query:".$sql_insert_stock."<br>".mysql_error().":".mysql_errno());
			//echo "<br><br>";
			$SwitchedId = mysql_insert_id();
		}
		else
		{
			$sql_del_stock_box = "delete from ".$mysql_adm_table_prefix."stock_box where StockId = '$SwitchedId'";
			mysql_query($sql_del_stock_box) or die("Error in query:".$sql_del_stock_box."<br>".mysql_error().":".mysql_errno());
			//echo "<br><br>";
			
			$sql_insert_stock = "update ".$mysql_adm_table_prefix."stock_master set 
																				CountId = '$SwitchCountId',
																				LotNumber = '".$LotNumber."',
																				NumberOfBags = '".$NumberOfBags."',
																				StockInKgs = '".$StockInKgs."',
																				StockInBale = '".$StockInBale."',
																				Date = '".$Date."',
																				SwitchedFrom = '".$StockId."'
																				where rec_id = '".$SwitchedId."'";
			
			mysql_query($sql_insert_stock) or die("Error in query:".$sql_insert_stock."<br>".mysql_error().":".mysql_errno());
			//echo "<br><br>";
		}

		$i=1;
		while($row_stock_box = mysql_fetch_array($result_stock_box))
		{
			$BoxNumber =  $row_stock_box["BoxNumber"];
			$BoxWeight =  $row_stock_box["BoxWeight"];
																			
			$sql_insert_stock_box = "insert into ".$mysql_adm_table_prefix."stock_box set 
																				StockId = '$SwitchedId',
																				BoxNumber = '".$row_stock_box["BoxNumber"]."',
																				BoxWeight = '".$row_stock_box["BoxWeight"]."',
																				InsertBy = '$SessionUserType',
																				InsertDate = now(),
																				IpAddress = '$IpAddress'";

			mysql_query($sql_insert_stock_box) or die("Error in query:".$sql_insert_stock_box."<br>".mysql_error().":".mysql_errno());	
			//echo "<br><br>";
		}
		echo "Switched";
	}
}
?>