<? include ("inc/dbconnection.php");?>
<?
$url = "document.php?id=".$_GET["id"];
$documentname = "";
$doc_id = "";
if(isset($_GET["id"]))
{
	$doc_id = $_GET["id"];
	
	$sql = "select * from ".$mysql_adm_table_prefix."document_master where rec_id = '$doc_id'";
	$result = mysql_query($sql) or die("Error in sql : ".mysql_errno()." : ".mysql_error()." : ".$sql);	
	$row = mysql_fetch_array($result);
	$documentname = $row["DocumentName"];
	
}
?>
<form name="frm" action="<?=$url?>" method="post">
<table width="60%" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" valign="middle">
			<input type="text" name="txt_docname" id="txt_docname" value="<?=$documentname?>" style="width:150px; height:20px;"/>
			<input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
			<input type="hidden" name="doc_id" id="doc_id" value="<?=$doc_id?>" />
			<input type="image" src="images/Modify.png" name="image_edit" id="image_edit" alt="Edit" title="Edit">&nbsp;
             <img src="images/Exit.png" alt="Cancel" title="Cancel" onClick="edit_div('dive<?=$doc_id?>','<?=$documentname?>')">
    	</td>
	</tr>
</table>
</form>