<? include ("inc/check_session.php");?>
<? include ("inc/dbconnection.php");?>
<? include ("inc/adm_function.php");?>
<?
$StockId = $_GET["id"];
$i = $_GET["i"];
$CountId = $_GET["CountId"];
$Date = $_GET["Date"];

$CountName =  getCount("Count", "rec_id", $CountId);
			
$sql_count = "select * from ".$mysql_adm_table_prefix."count_master where Count = '$CountName' and rec_id != '$CountId'";
//echo "<br><br>";
$result_count = mysql_query($sql_count) or die("Error in query:".$sql_count."<br>".mysql_error().":".mysql_errno());

$SwitchCountId = "";

if(mysql_num_rows($result_count)>0)
{
	$row_count = mysql_fetch_array($result_count);
	$SwitchCountId = $row_count["rec_id"];
	
	$sql_update = "update ".$mysql_adm_table_prefix."stock_master set CountId = '$SwitchCountId' where rec_id = '$StockId'";
	mysql_query($sql_update) or die("Error in Query:".$sql_update."<br>".mysql_errno().":".mysql_error());
}

$sql_stock = "SELECT * FROM  ".$mysql_adm_table_prefix."stock_master where CountId = '$CountId' and Date = '$Date' order by Date ";
$result_stock = mysql_query($sql_stock) or die("Error in Query:".$sql_stock."<br>".mysql_errno().":".mysql_error());
if(mysql_num_rows($result_stock)>0)	
{
?>
	<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="border">
		<tr>
			<td colspan="7" class="blackHead">Stock Detail</td>
		</tr>
		<tr>
			<td align="center">
			<span class="text_1"><b>Lot Number</b></span>
			</td>
			<td align="center">
			<span class="text_1"><b>Number Of Bags</b></span>
			</td>
			<td align="center">
			<span class="text_1"><b>Stock In Kgs</b></span>
			</td>
			<td>
				<span class="text_1"><b>Edit</b></span>
			</td>
			<!--<td align="center">
				<span class="text_1"><b>Copy</b></span>
			</td>-->
			<td align="center">
				<span class="text_1"><b>Switch</b></span>
				
			</td>
		</tr>
		<?
		$j=0;
		while($row_stock=mysql_fetch_array($result_stock))
		{
		?>
		<tr>
			<td align="center">
				<span class="text_1"><?=$row_stock["LotNumber"]?></span>
			</td>
			<td align="center">
				<span class="text_1"><?=$row_stock["NumberOfBags"]?></span>
			</td>
			<td align="center">
				<span class="text_1"><?=$row_stock["StockInKgs"]?></span>
			</td>
			<td align="center">
				<a href="javascript:;" onclick="get_frm('get_lot_detail.php','<?=$row_stock["rec_id"]?>&i=<?=$i?>&CountId=<?=$CountId?>&Date=<?=$Date?>','div_<?=$i?>');"><img src="images/Modify.png" alt="Update" title="Update" border="0"></a>
			</td>
			
			<!--<td align="center">
				<?
				if($row_stock["SwitchedFrom"]=="")
				{
				?>
			
				<img src="images/Next.png" border="0" onclick="return hs.htmlExpand(this, {headingText: 'Switch Category', width: 500, height: 400 })" />
				
				<div class="highslide-maincontent">
					<table align="center" class="border" width="100%">
						<tr>
							<td class="text_1">Switch Category</td>
							<td class="text_1">
							<?    
							$sql_prd = "select * from ".$mysql_adm_table_prefix."product_master order by ProductName";
							$result_prd = mysql_query ($sql_prd) or die ("Error in : ".$sql_prd."<br>".mysql_errno()." : ".mysql_error());
							?>    
								<select name="txt_product" id="txt_product" style="width:150px;">
									<option value="">--select--</option>
								<? 
								while ($row_prd = mysql_fetch_array($result_prd))
								{
								?>
									<option value="<?=$row_prd['rec_id']?>"<? if($row_prd['rec_id']==$prdid){?> selected="selected"<? }?>>
									<?=$row_prd["ProductName"]?>
									</option>
								<?
								}
								?>
								</select>
							</td>
							<td>
								<input type="image" src="images/Next.png" id="btn_switch_category" name="btn_switch_category" value="Switch Category" onclick="get_frm('get_switch_stock.php','<?=$row_stock["rec_id"]?>', 'div_switch_<?=$j?>');" />
								
							</td>
							<td>
								<div id="div_switch_<?=$j?>"></div>
							</td>
						</tr>
					 </table>       
				</div>
				<?
				$j++;
				}
				?>
			</td>-->
			<td align="center" style="text-align:center">
				<a href="javascript:;" onclick="get_frm('get_switched_stock.php', '<?=$row_stock["rec_id"]?>&i=<?=$i?>&CountId=<?=$CountId?>&Date=<?=$Date?>', 'replaceme_<?=$i?>','');get_frm2('get_stock_list.php','<?=$row_stock["rec_id"]?>&i=<?=$i?>&CountId=<?=$CountId?>&Date=<?=$Date?>','replaceme_<?=$i?>');"><img src="images/icon_switch.jpg" border="0" /></a>
			</td>
		</tr>
		<?
			
		}
		?>
	</table>
<?
}
?>