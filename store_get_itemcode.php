<? include ("inc/dbconnection.php");?>
<?
$id="";
$id = $_REQUEST['item_id'];
$sql = "SELECT * FROM  ms_item_master where item_id = '$id' order by name ";
$result_item = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result_item)>0)
{
	while($row_item = mysql_fetch_array($result_item))
		{
			echo $row_item['item_id'];

		}
}
?> 