<? include ("inc/check_session.php");?>
<? include ("inc/dbconnection.php");?>
<? include ("inc/adm_function.php");?>
<?
//print_r($_POST);
$Date = "";
$msg = "";

if(isset($_POST["count"]))
{
	$count = $_POST["count"];
			
	$LotNumber = $_POST['LotNumber_'.$count];
	$StockId = $_POST['h_rec_id_'.$count];
	$CountId = $_POST['h_count_id_'.$count];

	$prdid = getCount("ProductId", "rec_id", $CountId);
	
	$Date = $_POST['Date_'.$count];
	$IpAddress = $_SERVER['REMOTE_ADDR'];
	
	$LotNumber = $_POST['LotNumber_'.$count];
	$NumberOfBags = $_POST['NumberOfBags_'.$count];
	
	//$StockInKgs = $_POST['StockInKgs_'.$count];
	
	if(isset($_POST['btn_upload_new_'.$count]) && !isset($_POST["btn_bag_submit"]))
	{
		if($StockId=="")
		{
			$sql_ins = "insert into ".$mysql_adm_table_prefix."stock_master set
																			CountId = '$CountId',
																			LotNumber = '$LotNumber',
																			NumberOfBags = '$NumberOfBags',
																			
																			Date = '$Date',
																			InsertBy = '$SessionUserType',
																			InsertDate = now(),
																			IpAddress = '$IpAddress'";
																						
			$result_ins = mysql_query($sql_ins) or die("Error in query:".$sql_ins."<br>".mysql_error().":".mysql_errno());
			$StockId = mysql_insert_id();
			$msg = "Stock Successfully Inserted";
		}
		else
		{
			$sql_ins = "update ".$mysql_adm_table_prefix."stock_master set
																		LotNumber = '$LotNumber',
																		NumberOfBags = '$NumberOfBags'
																		where rec_id = '$StockId'
																		";
																						
			$result_ins = mysql_query($sql_ins) or die("Error in query:".$sql_ins."<br>".mysql_error().":".mysql_errno());
			$msg = "Stock Successfully Updated";
		}
	}
}
?>
<?
if(isset($_POST['btn_bag_submit']))
{
	if(isset($_POST["StockId"]))
	{
		//print_r($_POST);
		$count = $_POST["count1"];
		//$StockId = $_POST['h_rec_id_'.$count];
		$CountId = $_POST['h_count_id_'.$count];
		$StockId = $_POST['StockId'];
		$BoxNumber = $_POST['BagNumber'];
		$BoxWeight = $_POST['txtNumberOfBags'];
		$IpAddress = $_SERVER['REMOTE_ADDR'];
		//$LotNumber = $_POST['LotNumber_'.$count];
		//$NumberOfBags = $_POST['NumberOfBags_'.$count];
		//$StockInKgs = $_POST['StockInKgs_'.$count];
		$TotalKgs = $_POST['TotalKgs'];
		$Date = $_POST['Date_'.$count];
		$IpAddress = $_SERVER['REMOTE_ADDR'];
		
		$sql_stock_box = "select * from ".$mysql_adm_table_prefix."stock_box where StockId = '$StockId'";
		$result_stock_box = mysql_query($sql_stock_box) or die("Error in query:".$sql_stock_box."<br>".mysql_error().":".mysql_errno());
	
		if(mysql_num_rows($result_stock_box)>0)
		{
			$sql_stock_box_delete = "delete from ".$mysql_adm_table_prefix."stock_box where StockId = '$StockId'";
			mysql_query($sql_stock_box_delete) or die("Error in query:".$sql_stock_box_delete."<br>".mysql_error().":".mysql_errno());
			
		}
		//echo $BoxNumber;
		for ($i = 0 ; $i<count($BoxNumber); $i++)
		{
			$sql_ins = "insert into ".$mysql_adm_table_prefix."stock_box set
																						StockId = '$StockId',
																						BoxNumber = '$BoxNumber[$i]',
																						BoxWeight = '$BoxWeight[$i]',
																						InsertBy = '$SessionUserType',
																						InsertDate = now(),
																						IpAddress = '$IpAddress'";
																						
			$result_ins = mysql_query($sql_ins) or die("Error in query:".$sql_ins."<br>".mysql_error().":".mysql_errno());
			
			
			$msg = "Stock Successfully Updated";
			
		}
		$sql_ins = "update ".$mysql_adm_table_prefix."stock_master set
																		StockInKgs = '$TotalKgs'
																		where rec_id = '$StockId'
																		";
																						
		$result_ins = mysql_query($sql_ins) or die("Error in query:".$sql_ins."<br>".mysql_error().":".mysql_errno());
		$msg = "Stock Successfully Inserted";
	}
}
?>
<div class="red" align="center" style="padding-top:5px;padding-bottom:5px;"><?=$msg;?></div>
<form id="frm_dispatch" name="frm_dispatch" action="add_stock_detail.php" method="post">
<table>
	<tr>
    	<td>
<?
$sql_stock = "SELECT * FROM  ".$mysql_adm_table_prefix."stock_master where rec_id = '$StockId' and Date = '$Date' order by Date ";
$result_stock = mysql_query($sql_stock) or die("Error in Query:".$sql_stock."<br>".mysql_errno().":".mysql_error());
if(mysql_num_rows($result_stock)>0)	
{
	$row_stock=mysql_fetch_array($result_stock);
	?>
		<table>
        	<tr>
            	<td class="text_1">
                    Check ALL - 
				</td>
                <td>
                	<input type="checkbox" id="cbAllNumberOfBags" name="cbAllNumberOfBags" value="" onClick="checkAll()">
                    <input type="hidden" id="NoOfPck" name="NoOfPck" value="<?=$row_stock['NumberOfBags']?>">
                    <input type="hidden" id="BoxKgs" name="BoxKgs" value="<?=$row_stock['StockInKgs']/$row_stock['NumberOfBags']?>">
                    <input type="hidden" id="StockInKgs" name="StockInKgs" value="<?=$row_stock['StockInKgs']?>">
                    <input type="hidden" id="TotalKgs" name="TotalKgs" value="">
                </td>
                <!--<td class="text_1">
                	AutoCalculation
                </td>
                <td>
                	<input type="checkbox" id="cbAutoCalculation" name="cbAutoCalculation" checked="checked">
                </td>-->
        	</tr>
        	<tr>
            	<td class="text_1">
                	From
                </td>
                <td>
                	<input type="text" id="txtFromNumber" name="txtFromNumber" value="">
                </td>
                <td class="text_1">
                	To
                </td>
                <td>
                	<input type="text" id="txtToNumber" name="txtToNumber" value=""> 
                </td>
                <td>
                	<input type="button" id="btn_update_box_kgs" name="btn_update_box_kgs" value="Update" onclick="UpdateBoxKgs();UpdateBoxKgs1();" />
                </td>
        	</tr>
            <tr>
				<td class="text_1">
                	Kgs/Pack
                </td>
       			<td>
                    <input type="hidden" id="StockInKgs" name="StockInKgs" value="<?=$row_stock['StockInKgs']?>">
                    <input type="text" id="txtBoxKgs" name="txtBoxKgs" value="">
        		</td>

            	<td class="text_1">
                	CalculateKgs
                </td>
            	<td>
                	<input type="text" id="txtCalculateKgs" name="txtCalculateKgs" value="">
                </td>
            </tr>
        </table>
        
	<?
	$sql_stock_box = "select * from ".$mysql_adm_table_prefix."stock_box where StockId = '$StockId' order by rec_id";
	$result_stock_box = mysql_query($sql_stock_box) or die("Error in query:".$sql_stock_box."<br>".mysql_error().":".mysql_errno());
	//echo mysql_num_rows($result_stock_box);
	//echo $row_stock['NumberOfBags'];
	
	//echo $row_stock['NumberOfBags'];
	
	if(mysql_num_rows($result_stock_box)!=$row_stock['NumberOfBags'])
	{
		
		for($i=1; $i<=$row_stock['NumberOfBags']; $i++)
		{
		?>
			<div style="float:left; width:80px;">
				<div style="float:left; width:50px; text-align:right">
					<input type="hidden" id="BagNumber" name="BagNumber" value="<?=$i?>">
					<?=$i?> <input type="checkbox" id="cbNumberOfBags" name="cbNumberOfBags" value="<?=round($row_stock['StockInKgs']/$row_stock['NumberOfBags'],2)?>">
				</div>
				<div style="float:left;">
					<input type="text" id="txtNumberOfBags" name="txtNumberOfBags[]" value="<?=round($row_stock['StockInKgs']/$row_stock['NumberOfBags'],2)?>" onblur="UpdateBoxKgs1()" style="width:50px;">
				</div>
			</div>
		<?
			if($i%8==0)
			{
				echo "<br>";
			}
		}
		
	}
	else if(mysql_num_rows($result_stock_box)>0)
	{
		$i=1;
		while($row_stock_box=mysql_fetch_array($result_stock_box))
		{
		?>
        	<div style="float:left; width:80px;">
				<div style="float:left; width:50px; text-align:right">
					<input type="hidden" id="BagNumber" name="BagNumber" value="<?=$i?>">
					<?=$i?> <input type="checkbox" id="cbNumberOfBags" name="cbNumberOfBags" value="<?=round($row_stock['StockInKgs']/$row_stock['NumberOfBags'],2)?>">
				</div>
				<div style="float:left;">
					<input type="text" id="txtNumberOfBags" name="txtNumberOfBags[]" value="<?=$row_stock_box["BoxWeight"]?>" onblur="UpdateBoxKgs1()" style="width:50px;">
				</div>
			</div>
        <?
			if($i%8==0)
			{
				echo "<br>";
			}
			$i++;
		}
	}
	/*else
	{
		for($i=1; $i<=$row_stock['NumberOfBags']; $i++)
		{
		?>
			<div style="float:left; width:80px;">
				<div style="float:left; width:50px; text-align:right">
					<input type="hidden" id="BagNumber" name="BagNumber" value="<?=$i?>">
					<?=$i?> <input type="checkbox" id="cbNumberOfBags" name="cbNumberOfBags" value="<?=round($row_stock['StockInKgs']/$row_stock['NumberOfBags'],2)?>">
				</div>
				<div style="float:left;">
					<input type="text" id="txtNumberOfBags" name="txtNumberOfBags[]" value="<?=round($row_stock['StockInKgs']/$row_stock['NumberOfBags'],2)?>" style="width:50px;">
				</div>
			</div>
		<?
			if($i%8==0)
			{
				echo "<br>";
			}
		}
	}*/
}
?>
		</td>
    </tr>
    <tr>
        <td>
        	<input type="hidden" id="StockId" name="StockId" value="<?=$StockId?>">
			<input type="submit" id="btn_bag_submit" name="btn_bag_submit" value="Submit" onClick="doit1(<?=$count?>,'New'); return false;"/>
        </td>
	</tr>
</table>            
</form>
<?
$sql_stock = "SELECT * FROM  ".$mysql_adm_table_prefix."stock_master where CountId = '$CountId' and Date = '$Date' order by Date ";
$result_stock = mysql_query($sql_stock) or die("Error in Query:".$sql_stock."<br>".mysql_errno().":".mysql_error());
if(mysql_num_rows($result_stock)>0)	
{
	
	?>
    
    <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="border">
    	<tr>
            <td colspan="6" class="blackHead">Stock Detail</td>
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
            <td align="center">
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
            	<a href="javascript:;" onclick="get_frm('get_lot_detail.php','<?=$row_stock["rec_id"]?>&i=<?=$count?>&CountId=<?=$CountId?>&Date=<?=$Date?>','div_<?=$count?>');get_frm2('get_stock_list.php','<?=$row_stock["rec_id"]?>&i=<?=$count?>&CountId=<?=$CountId?>&Date=<?=$Date?>','replaceme_<?=$count?>');"><img src="images/Modify.png" alt="Update" title="Update" border="0"></a>
            </td>
            <!--<td align="center">
            	<?
				if($row_stock["SwitchedFrom"]=="")
				{
				?>
                <a href="javascript:;" onClick="return hs.htmlExpand(this, {headingText: 'Stock History', width: 500, height: 400 })"><img src="images/Next.png" border="0" /></a>
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
								if(mysql_num_rows($result_prd)>0)
								{
                                	while ($row_prd = mysql_fetch_array($result_prd))
                                	{
                                ?>
                                    <option value="<?=$row_prd['rec_id']?>" <? if($row_prd['rec_id']==$prdid){?>selected="selected"<? }?>>
                                    <?=$row_prd["ProductName"]?>
                                    </option>
                                <?
									}
                                }
                                ?>
                                </select>
                            </td>
                            <td>
                                <input type="image" src="images/Next.png" id="btn_switch_category" name="btn_switch_category" value="Switch Category" onclick="get_frm('get_switch_stock.php','<?=$row_stock["rec_id"]?>', 'div_switch_<?=$count?>')" />
                                
                            </td>
                            <td>
                                <div id="div_switch_<?=$count?>"></div>
                            </td>
                        </tr>
                     </table>       
                </div>
                <?
				}
				?>
            </td>-->
            <td align="center" style="text-align:center">
            	
            	<a href="javascript:;" onclick="get_frm('get_switched_stock.php', '<?=$row_stock["rec_id"]?>&i=<?=$count?>&CountId=<?=$CountId?>&Date=<?=$Date?>', 'replaceme_<?=$count?>','');get_frm2('get_stock_list.php','<?=$row_stock["rec_id"]?>&i=<?=$count?>&CountId=<?=$CountId?>&Date=<?=$Date?>','replaceme_<?=$count?>');"><img src="images/icon_switch.jpg" border="0" /></a>
            </td>
       	</tr>
        <?
		}
		?>
	</table>
	<?

}
?>