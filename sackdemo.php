<? include ("inc/dbconnection.php");?>
<? include ("inc/adm_function.php");?>
<?

$Date = "";
if(isset($_REQUEST["id"]))
{
	$sql_stock = "SELECT * FROM  ".$mysql_adm_table_prefix."stock_master where CountId = '".$_REQUEST["id"]."' order by Date ";
	$result_stock = mysql_query($sql_stock) or die("Error in Query:".$sql_stock."<br>".mysql_errno().":".mysql_error());
	if(mysql_num_rows($result_stock)>0)	
	{
	?>
    <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="border">
    	<tr>
            <td colspan="4" class="blackHead">Stock Detail</td>
        </tr>
		<tr>
            <td class="text_1">
                StockInKgs
            </td>
            <td class="text_1">
                StockInBale
            </td>
            <td class="text_1">
                Date
            </td>
            <td class="text_1">
                InsertBy
            </td>
       	</tr>
  		<?
		while($row_stock=mysql_fetch_array($result_stock))
		{
		?>
        <tr>
            <td class="text_1">
                <?=$row_stock["StockInKgs"]?>
            </td>
            <td class="text_1">
                <?=$row_stock["StockInBale"]?>
            </td>
            <td class="text_1">
                <?=getDateFormate($row_stock["Date"],1)?>
            </td>
            <td class="text_1">
                <?=$row_stock["InsertBy"]?>
            </td>
       	</tr>
        <?
		$Date = $row_stock["Date"];
		}
		
		?>
	</table>
	<?
	}
	else
	{
		$InsertDate = explode(" ",getCount("InsertDate", "rec_id", $_GET["id"]));
		$Date = $InsertDate[0];
		
	}


$days = dateDiffDB("-",date('Y-m-d'), $Date);
?>

<form name="form" id="form" action="sackdemo.php" method="post">

<table align="center" width="100%" cellpadding="0" cellspacing="0" border="1" class="border">
	<tr>
    	<td align="left" class="text_1" style="padding-left:15px;"><b>Stock</b><span class="text_1">kg</span></td>
        <td align="left" class="text_1" style="padding-left:15px;"><b>Stock</b><span class="text_1">bale</span></td>
        <td align="left" class="text_1" style="padding-left:15px;"><b>Date</b></td>
    </tr>
<?
for($i=0; $i< $days; $i++)
{
?>   
    <tr>	
        
        <td align="left"><input type="text" name="StockInKgs_<?=$i?>" id="StockInKgs_<?=$i?>"  value="" style="width:150px; height:20px;"/></td>
    
        
        <td align="left"><input type="text" name="StockInBale_<?=$i?>" id="StockInBale_<?=$i?>"  value="" style="width:150px; height:20px;"/></td>
    
        
        <td align="left"><? $date_1 = explode("-",$Date);?><input type="text" name="Date_<?=$i?>" id="Date_<?=$i?>" value="<?=getDateFormate(date("Y-m-d", mktime(0, 0, 0, $date_1[1], $date_1[2] + $i+1 , $date_1[0])),1);?>" style="width:150px; height:22px;"/></td>
    </tr>
<?
}
?>    
    <tr>
        <td colspan="2" align="center" style="padding-top:5px;">
        	<input name="id" type="hidden" id="id" value="<?=$_GET["id"];?>" />
            <input name="field_counter" type="hidden" id="field_counter" value="<?=$i;?>" />
            <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
            <input type="submit" name="btn_submit" id="btn_submit" value="submit"  onClick="doit(); return false;"/>
        </td>
    </tr> 
</table>
</form>
<?
}
?>