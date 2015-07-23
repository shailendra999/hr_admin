<? include ("inc/dbconnection.php");?>
<?
$id="";
$id = $_REQUEST['item_id'];
$sql = "SELECT mim.indent_id FROM ms_item_master mitem, ms_indent_master mim,ms_indent_transaction mit where mit.item_id = '$id' and mim.indent_id=mit.indent_id and mit.item_id=mitem.item_code ";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
	echo  "<input name='ind_no[]' id='ind_no[]' type='text' value='".$row['indent_id']."'  style='height:18px;width:100%'/>";	
}
?> 