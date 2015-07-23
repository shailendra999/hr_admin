<? include ("inc/dbconnection.php");?>
<?
$url = "add_product.php";
$product_name = "";
$product_id = "";
if(isset($_GET["id"]))
{
	$product_id = $_GET["id"];
	
	$sql = "select * from ".$mysql_adm_table_prefix."product_master where rec_id = '$product_id'";
	$result = mysql_query($sql) or die("Error in sql : ".mysql_errno()." : ".mysql_error()." : ".$sql);	
	$row = mysql_fetch_array($result);
	
	$product_name = $row["ProductName"];
	$txt_stockkg = $row["StockInKgs"];
	$txt_stockbale = $row["StockInBale"];
	$IsCount = $row["IsCount"];
	
}
?>
<form name="frm" action="<?=$url?>" method="post">
<table width="60%" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
		<td align="center" valign="middle">
			<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="29%" align="left" class="text_1" style="padding-left:15px;"><b>Product Name</b></td>
                    <td width="47%" align="left"><input type="text" name="txt_prdname" id="txt_prdname" value="<?=$product_name?>" style="width:150px; height:20px;"/></td>
                    <tr>
                        <td align="left" class="text_1"><b>Is Count</b></td>
                        <td align="left">
            <input type="checkbox" name="chk_iscount_edit_<?=$_GET["id"]?>" id="chk_iscount_edit_<?=$_GET["id"]?>" value="" <? if ($IsCount) { ?> checked="checked" <? }?> onclick="hide_stock('div_stock_edit_<?=$_GET["id"]?>','chk_iscount_edit_<?=$_GET["id"]?>');" />
            			</td>
                    <tr>
                        <td colspan="2">
                            <div id="div_stock_edit_<?=$_GET["id"]?>" style="display:<? if ($IsCount) { ?>none<? }else{?>block<? }?>;">
                                <table width="100%">
                                  <tr>
                                      <td width="38%" align="left" class="text_1" style="padding-left:15px;"><b>Stock</b></td>
                                      <td width="62%" align="left"><input type="text" name="txt_stockkg" id="txt_stockkg" value="<?=$txt_stockkg?>" /><span class="text_1">kg</span></td>
                                  </tr>
                                  <tr>
                                      <td width="38%" align="left" class="text_1" style="padding-left:15px;"><b>Stock</b></td>
                                      <td width="62%" align="left"><input type="text" name="txt_stockbale" id="txt_stockbale" value="<?=$txt_stockbale?>" /><span class="text_1">bale</span></td>
                                  </tr>
                                </table>
                            </div>
						</td>
                	</tr>
                    <tr>
                    	<td width="24%" colspan="2" align="center" style="padding-top:5px;">
                                                                        
                            <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                            <input type="hidden" name="product_id" id="product_id" value="<?=$product_id?>" />
                            <span style="padding-top:0px;">
                                <input type="image" src="images/Modify.png" name="image_edit" id="image_edit" alt="Edit Product" title="Edit Product">&nbsp;
                                <img src="images/Exit.png" alt="Cancel" title="Cancel" onClick="edit_div('dive<?=$product_id?>','<?=$product_name?>')">
                            </span>
						</td>
	            	</tr>
            	</table>
    	</td>
	</tr>
</table>
</form>