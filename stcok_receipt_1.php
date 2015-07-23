<table width="99%" border="0" align="center">

	<tr class="simple_text" >
		<td align="justify" colspan="2">
			<strong>Recipt</strong><br><br>
			<hr noshade width='550px'>
			Thank you for your <? if($payment_type) {?>Purchasing <? } else { ?>order<? } ?>!<br><div style="font-weight:bold;">
			<!--<?
				if($shop_user==1)
				{
			?>
			<?=ucwords($shipfname . " " . $shiplname)?>
			<?
				}
			?>-->
			</div><br>
			<div style="background-color:#E8E8E8; line-height:20px;">
			<center><strong>Your <? if($payment_type) {?>Invoice <? } else { ?>order<? } ?> Number Is <span style="text-decoration:underline"><?=$order_no?></span>.</strong></center>
			</div>
			<br /> Please print this page or retain this number for your records.<br>
			<br>
			<!--<?
				if($shop_user!=1)
				{
			?>
			This Order Confirmation and Receipt is also sending to your email address. <b><?=$txtusername?></b> and <b><?=$shipemail?></b>
			<br />
			<?
				}
			?>-->
			Here is a recap of your <? if($payment_type) {?>Purchasing <? } else { ?>order<? } ?>:<br><br>
			<? if($payment_type) {?>Purchasing <? } else { ?>order<? } ?> Date: <?=substr($insert_date,8,2)."-".substr($insert_date,5,2)."-".substr($insert_date,0,4)?><br><br />
		</td>
	</tr>
	<!--<?
		if($shop_user!=1)
		{
	?>
  	<tr>
		<td align="left" class="simple_text" >
		  <p><font size="2"><strong>Bill to:</strong><br>
			<?=ucwords($Name) ?><br>
			<?=ucwords($Address)?><br>
			<?=ucwords($CityId . ", ". $PinCode)?> </font></p>
		</td>
		<td align="left" class="simple_text">
		  <p><font size="2"><strong>Ship to:</strong><br>
			<?=ucwords($shipname)?><br>
			<?=ucwords($shipaddress)?><br>
			<?=ucwords($shipcity . ", " . $shippostcode)?> </font></p>
		</td>
  	</tr>
	<?
		}
	?>-->
</table>
<hr noshade width='500px' align='center'>
<div style="margin:2px;">
<table width="99%" cellpadding="5" align="center" border="0">
	<tr class="m_separ">
		<td align="left" class="span_title">
			<span>Qty</span>		</td>
		<td align="left" class="span_title">
			<span>Product Name</span>		</td>
		<td align="right" class="span_title">
			<span>
				<table>
					<tr>
						<td>
							Price						</td>
<!--						<td>
							<div style="font-size:9px;">( in USD)</div>
						</td>
-->					</tr>
				</table>
			</span>		</td>
		
		<td align="right" class="span_title">
			<span>
				<table>
					<tr>
						<td>
							Total						</td>
						<!--<td>
							<div style="font-size:9px;">( in USD)</div>
						</td>-->
					</tr>
				</table>
			</span>		</td>
	</tr>
<?
$OrderId = GetOrderMaster('OrderId','OrderNumber',$order_no);
$query = "SELECT * from ".$mysql_table_prefix."order_detail WHERE OrderId = '$OrderId'";
$results = mysql_query($query) or die("Error81:".mysql_error());
while ($row = mysql_fetch_array($results)) 
{
	   extract ($row);
	   $prod = "SELECT * FROM ".$mysql_table_prefix."product_master WHERE ProductId = '$ProductId'";
	   $prod2 = mysql_query($prod);
	   $prod3 = mysql_fetch_array($prod2);
	   extract ($prod3);
	   ?>
	<tr class="m_separ">
	  	<td><font size='2'>
	   	<?=$row["Quantity"]?>
	   	</font>		</td>
		<td><font size='2'>
	   	<?=$Title?>
	   	</font></td>
	   	<td align='right'><font size='2'>
        <?
			if($payment_type!='PayPal')
				{
					 $selling_price=$SellingPrice_RS;
				}
				else
				{
					 $selling_price=$SellingPrice_USD;
				}
				
		?>
	   	<?=$ProductPrice ?>
	   	</font></td>
	   	<td align='right'><font size='2'>
	   	
	   	</font></td>
	   	<td align='right'><font size='2'>
	   	<?
	   	$extprice = ($ProductPrice  * $row["Quantity"]);
	   	echo number_format($extprice,2);
	   	?>
	   	</font></td>
	</tr>
<?
	$extprice_t = $extprice_t + $extprice;
}

?>
	<tr class="m_separ">
		<td colspan='4' align='right'><font size='2'>
			Your total before shipping is:</font>		</td>
		<td align='right'><font size='2'>
		<?//=//$extprice_t?>
		     <? echo number_format($extprice_t, 2) ?></font>		</td>
	</tr>
	
	<tr class="m_separ">
		<td colspan='4' align='right'><font size='2'>Shipping Costs:</font></td>
		<td align='right'><font size='2'><? echo number_format($shipping, 2) ?></font></td>
	</tr>
    
    	<tr class="m_separ">
		<td colspan='4' align='right'><font size='2'>Tax:</font></td>
		<td align='right'><font size='2'><? echo number_format($tax, 2) ?></font></td>
	</tr>
	
	<?
		$total = $shipping + $extprice_t +$tax ;
		
		if($discount>0)
		{
	?>
	<tr class="m_separ">
		<td colspan='4' align='right'><font size='2'>Discount Costs:</font></td>
		<td align='right'><font size='2'><? echo number_format($discount, 2) ?></font></td>
	</tr>
	<?
		$total_d = $total - $discount;
		}
		else
		{
			$total_d = $total;
		}
		?>
	<tr class="m_separ">
		<td colspan='4' align='right'><font size='2'>Your final total is:</font></td>
		<td align='right'><font size='2'><? $g_total = number_format($total_d, 2);$g_total = str_replace(',', '', $g_total); $new_g = round($g_total);
		 echo "$new_g."."00";
		 ?></font></td>
	</tr>
	<tr>
		<td colspan="5" align="center">
			<a href="javascript:;" onclick="window.open('print_receipt.php?order_no=<?=$order_no?>','BIlL');">
			<? if($payment_type) {?>
	      <img src="images/btn_bill.jpg" border="0" alt="Print Bill" /></a><br />
			<? } else {?>
			<img src="images/btn_printreceipt.jpg" border="0" alt="Print Receipt" />
			<? } ?>		</td>
	</tr>
    <tr>
    	<td colspan="5" align="center"><div id="payment_result">  
        	<?
        	if($_SESSION['session_customer_UserType']=='Shop')
				{
					if($payment_type=='Cash' or $payment_type=='Cheque' or $payment_type=='Draft')
						{
					?>
					<a href="javascript:;" onclick="get_frm('payment_status.php',<?=$OrderId?>,'payment_result','');"><img  src="images/btn_payment_accept.png"/></a>
					<?
						}
                }
			?>
          </div></td>
    </tr>
	<tr>
		<td colspan="5" align="center">
			
<form name="frm_paypal" method="post" action="<?=$paypal_action?>" enctype="multipart/form-date">
<input type='hidden' name="cmd" value="_xclick">
<input type='hidden' name="first_name" value="<?=$Name?>">
<input type='hidden' name="address_override" value="1">
<input type='hidden' name="cbt" value="Continue">
<input type='hidden' name="email" value="<?=$shipemail?>">
<?
	if($country_id=='99')
		{
		  $curr_dollar=getDollarsRate();
		  $new_g=$new_g/$curr_dollar;
?>
<input type='hidden' name="amount" value="<? echo number_format(($new_g), 2) ?>">
<?
		}
		else
		{
?>
<input type='hidden' name="amount" value="<? echo number_format(($new_g), 2) ?>">	
<?		
		}
?>
<input type="hidden" name="item_name" value="<?=$order_no?>">
<input type='hidden' name="item_number" value="<?=$order_no?>">
<input type='hidden' name="business" value="<?=$business?>">
<input type='hidden' name="currency_code" value="USD">
<input type='hidden' name="cancel_return" value="<?=$path?>cancel.php?order_no=<?=$order_no?>">
<input type='hidden' name="return" value="<?=$path?>return.php?order_no=<?=$order_no?>">
<input type='hidden' name="no_note" value="0">
<input type='hidden' name="notify_url" value="<?=$path?>notify.php">
<?
if(!$payment_type or $payment_type=="PayPal" )
{
?>
<input type="image"  src="images/btn_paynow.jpg" border="0" alt="Pay Now" />
<?
}
?>
</form>		</td>
	</tr>
	<tr>
	  <td colspan="5" align="left" class="Text9Pt"><font color="#990000">***Price inclusive of all taxes</font></td>
    </tr>
</table>
</div>