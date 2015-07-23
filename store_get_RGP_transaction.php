<?
include("inc/dbconnection.php");
?>
<?
$RGP_id=$_REQUEST['RGP_id'];
$sql_GRN_trans="SELECT * FROM ms_RGP_master mgm,ms_RGP_transaction mgt WHERE mgm.RGP_id=mgt.RGP_id AND mgm.RGP_id ='".$RGP_id."' and mgt.pend_qty<>0";
$res_GRN_trans=mysql_query($sql_GRN_trans);
$countTrans=1;
$rc_trans=mysql_num_rows($res_GRN_trans);
if($rc_trans>0)
{
	?>
  <div id="divTransaction">
		<?
    while($row_t=mysql_fetch_array($res_GRN_trans))
    {
			if($countTrans%2==0)
				$tableColor="#eedfdc";
			else
				$tableColor="#f8f1ef";
			?>
				<div id="myDBDiv_<?=$countTrans?>">
					<table align="center" width="100%" cellpadding="1" cellspacing="1" class="border" border="0">
					<input name="RGP_trans_id[]" id="RGP_trans_id[]" type="hidden" value="<?=$row_t['RGP_transaction_id']?>" />
						<tr class="text_tr" bgcolor="<?=$tableColor?>">
							<td align="center" width="5%"><b>S. No. </b></td>                               
							<td align="center" width="15%"><b>Department</b></td>
							<td align="center" width="30%"><b>Item Name</b></td>
							<td align="center" width="10%"><b>UOM</b></td>
							<td align="center" width="30%"><b>Purpose</b></td>
							<td align="center" width="10%"><b>RGP. Qty</b></td>                                  
						</tr>
						<tr class="text_tr" bgcolor="<?=$tableColor?>">
							<td align="center"><?=$countTrans ?></td>
							<td align="center">
							 <?
								$sql_D="select * from ms_department where department_id=$row_t[department_id]";
								$res_D=mysql_query($sql_D);
								$row_D=mysql_fetch_array($res_D);
								echo $row_D['name'];
								?>
							</td>
							<td align="left" style="padding-left:5px"><?=$row_t['item_name']?></td>                               
							<td align="center">
								<? 
									$sql_uom = "SELECT name as uname FROM  ms_uom where uom_id = '".$row_t['uom_id']."'";
									$result_uom = mysql_query ($sql_uom) or die (mysql_error());
									if(mysql_num_rows($result_uom)>0)
									{
										$row_uom = mysql_fetch_array($result_uom);
										echo $row_uom['uname'];
									}
								?>
							</td>
							<td align="left" style="padding-left:5px"><?= $row_t['remarks']?></td>
							<td align="center"><?= $row_t['pend_qty']?></td>
							<td align="center"></td>
						</tr>
						<tr class="text_tr" bgcolor="<?=$tableColor?>">
							<td align="center"><b>Rec. Qty</b></td>
							<td align="center"><b>Pend. Qty</b></td>
							<td align="center"><b>Rate</b></td>
							<td align="center"><b>VAT%</b></td>
							<td align="center"><b>Net Rate</b></td>
              <td align="center"></td>
						</tr>
						<tr class="text_tr" bgcolor="<?=$tableColor?>">
							<td align="center">
								<input name="rec_qty[]" id="rec_qty_<?=$countTrans?>" type="text" class="get_H_18_W_60" onkeyup="return checkQuantity(event,'rec_qty_<?=$countTrans?>','pend_qty_<?=$countTrans?>',<?=$row_t['pend_qty']?>)" onchange="return checkQuantity(event,'rec_qty_<?=$countTrans?>','pend_qty_<?=$countTrans?>',<?=$row_t['pend_qty']?>)"/>
							</td>
							<td align="center">
								<input name="pend_qty[]" id="pend_qty_<?=$countTrans?>" readonly="readonly" type="text" class="get_H_18_W_60"/>
							</td>
							<td align="center">
								<input name="rate[]" id="rate[]" value="<?= $row_t['rate']?>" type="text" class="get_H_18_W_60"/>
							</td>
							<td align="center">
								<input name="vat_perc[]" id="vat_perc[]" type="text" class="get_H_18_W_60"/>
							</td>
							<td align="center">
								<input name="net_rate[]" id="net_rate[]" type="text" class="get_H_18_W_60" readonly="readonly"/>
							</td>
							<td class="AddMore" align="center">
								<input type="hidden" name="h_hidden" id="h_hidden" value="<?= $countTrans ?>"/> 
								 <a href="javascript:;" onclick="removeElement('myDBDiv_<?=$countTrans?>','divTransaction')" title="Delete">
								 <img src="images/delete_icon.jpg" alt="Delete" border="0" align="absmiddle"/></a>
							</td>
						</tr> 
					</table>
				</div>
			<?
			$countTrans++;
		}
		?>
  </div>
  <?
}
else
{
?>
<table align="center" width="100%" cellpadding="1" cellspacing="1" class="border text_1" border="0">
	<tr>
  	<td align="center"><b>No Records Found</b></td>
  </tr>
</table>
<?
}
?>