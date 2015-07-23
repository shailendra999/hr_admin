<? include ("inc/dbconnection.php");?>
<?
$i = $_GET["i"];
$CountId = $_GET["CountId"];
$id = $_GET["id"];
$Date = $_GET["Date"];
$sql_stock = "SELECT * FROM  ".$mysql_adm_table_prefix."stock_master where rec_id = '$id' and Date = '$Date' order by Date ";
$result_stock = mysql_query($sql_stock) or die("Error in Query:".$sql_stock."<br>".mysql_errno().":".mysql_error());
if(mysql_num_rows($result_stock)>0)	
{
	$row_stock=mysql_fetch_array($result_stock);
	
?>
<table align="center" width="100%" class="border">
    <tr>
        <td class="text_1">
            Lot Number
        </td>
        <td class="text_1">
            <input type="text" id="LotNumber_<?=$i?>" name="LotNumber_<?=$i?>" value="<?=$row_stock["LotNumber"]?>">
        </td>
    </tr>
    <tr>
        <td class="text_1">
            Number Of Bags
        </td>
        <td class="text_1">
            <input type="text" id="NumberOfBags_<?=$i?>" name="NumberOfBags_<?=$i?>" value="<?=$row_stock["NumberOfBags"]?>">
            
        </td>
    </tr>
    <!--<tr>
        <td class="text_1">
            Stock In Kgs
        </td>
        <td class="text_1">
            <input type="text" id="StockInKgs_<?=$i?>" name="StockInKgs_<?=$i?>" value="<?=$row_stock["StockInKgs"]?>">
            
        </td>
    </tr>-->    
    <tr>
        <td colspan="2" align="center">
            <input type="hidden" id="h_count_id_<?=$i?>" name="h_count_id_<?=$i?>" value="<?=$CountId?>" />
            <input type="hidden" id="h_rec_id_<?=$i?>" name="h_rec_id_<?=$i?>" value="<?=$id?>" />
            <input type="hidden" id="Date_<?=$i?>" name="Date_<?=$i?>" value="<?=$Date?>" />
            <input type="submit" id="btn_upload_<?=$i?>" name="btn_upload_<?=$i?>" value="Update" onClick="doit(<?=$i?>,'Update'); return false;" />
            <input type="submit" id="btn_upload_new_<?=$i?>" name="btn_upload_new_<?=$i?>" value="New" onClick="doit(<?=$i?>,'New'); return false;" />
        </td>
    </tr>
</table>
<?
}
?>