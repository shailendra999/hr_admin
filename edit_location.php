<? include ("inc/dbconnection.php");?>
<?
$url = "list_employee.php";
$product_name = "";
$product_id = "";
if(isset($_GET["id"]))
{
	$rotation_type = $_GET["id"];
	$emp_id = $_GET["str"];
}
?>
<div id="div_rotation_type_change">
<form name="frm" action="<?=$url?>" method="post">
<table width="40%" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" valign="middle">
			<select name="rotation_type" id="rotation_type" style="width:150px; height:20px;">
                <option value="Weekly">Weekly</option>
                <option value="2 Week">2 Week</option>
                <option value="Monthly">Monthly</option>
            </select>
			<input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
			<input type="hidden" name="emp_id" id="emp_id" value="<?=$product_id?>" />
         <td><input type="image" src="images/Modify.png" name="image_edit" id="image_edit" alt="Edit Rotation" title="Edit Rotation" onclick="get_frm('change_rotation_edit.php',document.getElementById('rotation_type').value,'div_rotation_type_change','<?=$emp_id?>')" />&nbsp;</td>
 <td>
             <img src="images/Exit.png" alt="Cancel" title="Cancel" onClick="edit_div('div_rotation_type_edit','<?=$rotation_type ?>')"></td>
	</tr>
</table>
</form>
</div>