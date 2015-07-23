<? include ("inc/dbconnection.php");?>
<?
$id="";
$id = $_REQUEST['item_id'];
$sql = "SELECT * FROM  ms_item_master where item_id = '$id' order by name ";
$result_item = mysql_query ($sql) or die (mysql_error());
if(mysql_num_rows($result_item)>0)
{
	while($row_item = mysql_fetch_array($result_item))
		{
			$sql_uom = "SELECT * FROM  ms_uom where uom_id = '".$row_item['uom_id']."' order by name ";
			$result_uom = mysql_query ($sql_uom) or die (mysql_error());
			if(mysql_num_rows($result_uom)>0)
			{
				while($row_uom = mysql_fetch_array($result_uom))
				{
					echo $row_uom['name'];
				}
			}
			
		}
}
?> 