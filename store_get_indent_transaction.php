<?
include("inc/dbconnection.php");
$sql_tax="select * from ms_taxes_master where tax_for_page = '1' ";
$res_tax=mysql_query($sql_tax);
$row_tax=mysql_fetch_array($res_tax);
//$cenvat = $row_tax['cenVat'];
$disc_perc = $row_tax['discount'];
$duty_perc = $row_tax['duty'];
$ecess_perc = $row_tax['ecess'];
$vat_perc = $row_tax['st'];
?>
<?
$indent_id=$_REQUEST['indent_id'];
$sql_trans="SELECT * FROM ms_indent_master sm,ms_indent_transaction st WHERE sm.indent_id=st.indent_id AND sm.indent_id ='".$indent_id."' and st.pend_qty<>0";
$res_trans=mysql_query($sql_trans);
$countTrans=1;
$rc_trans=mysql_num_rows($res_trans);
if($rc_trans>0)
{
	?>
  <div id="divTransaction">
  <?
		while($row_t=mysql_fetch_array($res_trans))
		{
			if($countTrans%2==0)
				$tableColor="#eedfdc";
			else
				$tableColor="#f8f1ef";
			?>
				<div id="myDBDiv_<?=$countTrans?>">
				<input name="indent_trans_id[]" id="indent_trans_id[]" type="hidden" value="<?=$row_t['indent_transaction_id']?>" />
				<input name="item_id[]" id="item_id[]" type="hidden" value="<?=$row_t['item_id']?>"/> 
				<table align="center" width="100%" cellpadding="1" cellspacing="1" class="border" border="0">
					<tr class="text_tr" bgcolor="<?=$tableColor?>">
						<td align="center" width="11%"><b>S. No. </b></td> 
						<td align="center" width="40%"><b>Item Name</b></td>
						<td align="center" width="11%"><b>UOM</b></td>
						<td align="center" width="11%"><b>Indent Qty</b></td>
						<td align="center" width="11%"><b>PO Qty</b></td>
						<td align="center" width="11%"><b>Pend Qty</b></td>
            <td align="center" width="5%"></td>                                  
					</tr>
					<tr class="text_tr" bgcolor="<?=$tableColor?>">
						<td align="center"><?=$countTrans?></td>
						<td align="left" style="padding-left:5px">
						<?
							$sql_IT="select * from ms_item_master where item_id='".$row_t['item_id']."'";
							$res_IT=mysql_query($sql_IT);
							$row_IT=mysql_fetch_array($res_IT);
							echo $row_IT['name']."; Drg No.: ".$row_IT['drawing_number'].'; Cat No. '.$row_IT['catelog_number'];
							$uom_id=$row_IT['uom_id'];
							?>
						</td>
						<td align="center">
						<? 
						$sql_uom = "SELECT name as uname FROM  ms_uom where uom_id = '".$uom_id."' order by name ";
						$result_uom = mysql_query ($sql_uom) or die (mysql_error());
						$row_uom = mysql_fetch_array($result_uom);
						echo $row_uom['uname'];
						?>
						</td>
						<td align="center"><?= $row_t['pend_qty']?></td>
						<td align="center">
            	<input name="po_qty[]" id="po_qty_<?=$countTrans?>" type="text" class="get_H_18_W_60"  autocomplete="off" onkeyup="return checkQuantity(event,'po_qty_<?=$countTrans?>','pend_qty_<?=$countTrans?>',<?=$row_t['pend_qty']?>)" onblur="return checkQuantity(event,'po_qty_<?=$countTrans?>','pend_qty_<?=$countTrans?>',<?=$row_t['pend_qty']?>)"/>
						</td>
						<td align="center">
							<input name="pend_qty[]" id="pend_qty_<?=$countTrans?>" value="<?=$row_t['pend_qty']?>" readonly="readonly" type="text" class="get_H_18_W_60"/>
						</td>
            <td align="center"></td> 
					</tr>
					<tr class="text_tr" bgcolor="<?=$tableColor?>">
						<td align="center"><b>Rate</b></td>
						<td align="center"><b>Disc%</b></td>
						<td align="center"><b>Duty%</b></td>
						<td align="center"><b>E.Cess%</b></td>
						<td align="center"><b>ST%</b></td>
            <td align="center"><b>Net Rate</b></td>
						<td align="center"></td>
					</tr>
					<tr class="text_tr" bgcolor="<?=$tableColor?>">
						<td align="center">
							<input name="rate[]" id="rate[]" type="text" class="get_H_18_W_60"/>
						</td>
						<td align="center">
              <input name="disc_perc[]" id="disc_perc[]" type="text" value="<?=$disc_perc?>" class="get_H_18_W_60"/>
						</td>
						<td align="center">
							<input name="duty_perc[]" id="duty_perc[]" type="text" value="<?=$duty_perc?>" class="get_H_18_W_60"/>
						</td>
						<td align="center">
							<input name="ecess_perc[]" id="ecess_perc[]" type="text" value="<?=$ecess_perc?>" class="get_H_18_W_60"/>
						</td>
						<td align="center">
							<input name="vat_perc[]" id="vat_perc[]" type="text" value="<?=$vat_perc?>" class="get_H_18_W_60"/>
						</td>
            <td align="center">
							<input name="net_rate[]" id="net_rate[]" type="text" class="get_H_18_W_60" readonly="readonly"/>
						</td>
						<td class="AddMore" align="center">
							<input type="hidden" name="h_hidden" id="h_hidden" value="<?= $countTrans ?>"/> 
							 <a href="javascript:;" onclick="removeElement('myDBDiv_<?=$countTrans?>','divTransaction')">
							 	<img src="images/delete_icon.jpg" alt="Delete" border="0" align="absmiddle" title="Delete"/>
               </a>
						</td>
					</tr> 
				</table>
				</div>
			<?			
			$countTrans++; 													 
    } // end of while
     ?>
  </div> 
<?
}// end if	
?>