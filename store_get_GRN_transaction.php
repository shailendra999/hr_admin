<?
include("inc/dbconnection.php");
$GRN_id=$_REQUEST['GRN_id'];
$sql_trans="SELECT * FROM ms_GRN_master sm,ms_GRN_transaction st WHERE sm.GRN_id=st.GRN_id AND sm.GRN_id ='".$GRN_id."' and st.NRGP_qty<>0";
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
			$sql_indent="SELECT * FROM ms_indent_transaction mgt where mgt.indent_transaction_id='".$row_t['indent_transaction_id']."'";
			$res_indent=mysql_query($sql_indent);
			$row_indent=mysql_fetch_array($res_indent);
			?>
				<div id="myDBDiv_<?=$countTrans?>">
        <input name="GRN_trans_id[]" id="GRN_trans_id[]" type="hidden" value="<?=$row_t['GRN_transaction_id']?>" />
				<input name="item_id[]" id="item_id[]" type="hidden" value="<?=$row_t['item_id']?>"/>
          <table align="center" width="100%" cellpadding="1" cellspacing="1" class="border" border="0">
            <tr class="text_tr" bgcolor="<?=$tableColor?>">
              <td align="center" width="10%"><b>S. No. </b></td> 
              <td align="center" width="40%"><b>Item Name</b></td>
              <td align="center" width="10%"><b>Remark</b></td>
              <td align="center" width="10%"><b>GRN Qty</b></td>
              <td align="center" width="10%"><b>NRGP Qty</b></td>
              <td align="center" width="10%"><b>Remaining</b></td>
              <td align="center" width="10%"><b>Rate</b></td>                                  
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
                <input name="remarks[]" id="remarks[]" type="text" style="height:18px;width:200px"/>
              </td>
              <td align="center"><?= $row_t['NRGP_qty']?></td>
              <td align="center">
                <input name="NRGP_qty[]" id="NRGP_qty_<?=$countTrans?>" type="text" class="get_H_18_W_60" onchange="return checkQuantity(event,'NRGP_qty_<?=$countTrans?>','remain_qty_<?=$countTrans?>',<?=$row_t['NRGP_qty']?>,'0')" onkeyUp="return checkQuantity(event,'NRGP_qty_<?=$countTrans?>','remain_qty_<?=$countTrans?>',<?=$row_t['NRGP_qty']?>,'0')"/>
              </td>
              <td align="center">
                <input name="remain_qty[]" id="remain_qty_<?=$countTrans?>" readonly="readonly" type="text" class="get_H_18_W_60"/>
              </td>
              <td align="center">
                <input name="rate[]" value="<?= $row_t['rate']?>" id="rate[]" type="text" class="get_H_18_W_60"/>
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