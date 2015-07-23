<? include ("inc/dbconnection.php");?>
<?
$id="";
$id = $_REQUEST['item_id'];
$sql = "SELECT * FROM  ms_item_master where item_id = '$id'" ;
$result_item = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result_item)>0)
{
	$row_item = mysql_fetch_array($result_item);
  echo "Drg No.: ".$row_item['drawing_number'].';Cat No. '.$row_item['catelog_number'];
	//echo  "<input name='item_desc[]' id='item_desc[]' type='text' value='".$val."' readonly='readonly'  style='height:18px;width:100%'/>";
}
?> 