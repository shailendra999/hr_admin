<? include ("inc/dbconnection.php");?>
<?
$url = "list_employee.php";
$product_name = "";
$product_id = "";
if(isset($_GET["id"]))
{
	$shift = $_GET["id"];
	$emp_id = $_GET["str"];
}
?>
<div id="div_shift_change">
<table width="60%" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" valign="middle">
			 <select name="shift_duration" id="shift_duration" style="width:150px; height:20px;">
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
				<option value="G">G</option>
            </select>
			<input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
			<input type="hidden" name="emp_id" id="emp_id" value="<?=$shift?>" />
         <td>
			<input type="image" src="images/Modify.png" name="image_edit" id="image_edit" alt="Edit Shift" title="Edit Shift" onclick="get_frm('change_shift_edit.php',document.getElementById('shift_duration').value,'div_shift_change','<?=$emp_id?>')">&nbsp;
         </td>
         <td>
             <img src="images/Exit.png" alt="Cancel" title="Cancel" onClick="edit_div('div_shift_type_edit','<?=$shift ?>')">
    	</td>
	</tr>
</table>
</td>