<?
$url = "document.php?id=".$_GET["id"];
?>
<form name="frm" action="<?=$url?>" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="middle"><span class="red">Are You Sure, you want to delete?</span> <input type="hidden" name="docid" id="docid" value="<?=$_GET["id"]?>"></td>
    <td>
    <? $id=$_GET["id"]?>
    <input type="image" src="images/Delete1.png" name="image_edit" id="image_edit" alt="Delete Category" title="Delete Category">&nbsp;
    <img src="images/Exit.png" alt="Cancel" title="Cancel" onClick="delete_div('divd<?=$id?>')">
    </td>
  </tr>
</table>
</form>
