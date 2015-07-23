<?
$url = "add_product.php";
?>
<form name="frm" action="<?=$url?>" method="post">
<table width="50%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="center" valign="middle"><span class="red" style="text-align:center;">Are You Sure, you want to delete?</span> <input type="hidden" name="prdid" id="prdid" value="<?=$_GET["id"]?>"></td>
    <td align="center">
    <? $id=$_GET["id"]?>
    <input type="image" src="images/Delete1.png" name="image_edit" id="image_edit" alt="Delete Product" title="Delete Product">&nbsp;
    <img src="images/Exit.png" alt="Cancel" title="Cancel" onClick="delete_div('divd<?=$id?>')">
    </td>
  </tr>
</table>
</form>
