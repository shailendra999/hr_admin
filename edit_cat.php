<? include ("inc/dbconnection.php");?>
<?
$url = "add_category.php";
$category_name = "";
$category_id = "";
if(isset($_GET["id"]))
{
	$category_id = $_GET["id"];
	
	$sql = "select * from ".$mysql_adm_table_prefix."category_master where rec_id = '$category_id'";
	$result = mysql_query($sql) or die("Error in sql : ".mysql_errno()." : ".mysql_error()." : ".$sql);	
	$row = mysql_fetch_array($result);
	$category_name = $row["CategoryName"];
	
}
?>
<form name="frm" action="<?=$url?>" method="post">
<table width="60%" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" valign="middle">
			<input type="text" name="txt_catname" id="txt_catname" value="<?=$category_name?>" style="width:150px; height:20px;"/>
			<input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
			<input type="hidden" name="category_id" id="category_id" value="<?=$category_id?>" />
			<input type="image" src="images/Modify.png" name="image_edit" id="image_edit" alt="Edit Category" title="Edit Category">&nbsp;
             <img src="images/Exit.png" alt="Cancel" title="Cancel" onClick="edit_div('dive<?=$category_id?>','<?=$category_name?>')">
    	</td>
	</tr>
</table>
</form>