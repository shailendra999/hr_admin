<?
	session_start();
?>
<? include ("inc/dbconnection.php");?>
<? include ("inc/store_function.php");?>
<?
$quantity =  $_GET["str"];


$product_qty_id ="";
//$product_qty_id = getProductQty($_POST['product_id']);
/////////Avoiding Refresh////////////////
$prodID =  $_GET["id"];
$product_id = $_GET["id"];
$product_qty_id = getstock_item_Detail("quantiy","rec_id",$product_id);
if(session_is_registered("session_$product_id"))
{
	////////////Updating Quantity If product already exists in the cart/////////////
	if($product_qty_id >= ($_SESSION["session_qty_$product_id"] + $quantity))
	{
		$_SESSION["session_qty_$product_id"] = $_SESSION["session_qty_$product_id"] + $quantity;
		 $qty = $_SESSION["session_qty_$product_id"];
	}
	else
	{
		//$msg =  "Don't Update ";   // Only Available
	}	
}
else if($product_qty_id >= $quantity)
{
	////////Adding New Item////////////////

		$_SESSION["session_$product_id"] = $product_id;
		$_SESSION["session_qty_$product_id"] = $quantity;
		
		$_SESSION['cart'][$product_id] = array("productId" => $prodID);
}
else
 {
	echo $msg="Not enought quantity Avaiable";
 }
	//echo "add cart";
?>
<? 

$Total="";
$g_total = "";

$product_count =0;
if(session_is_registered('cart'))
{
	for($i=0;$i<=count($_SESSION['cart']);$i++)
	{
		$product_count = $i;
	}
}
?>



<? 
if($product_count==0)
{
?>
<p>You have no items in your shopping cart.</p>
<? 
}
else
{
	?>
     There <? if($product_count>1)
{ echo "are "; } else{ echo "is ";}?><?=$product_count?> items in your cart.
<form action="" method="post" name="frm_update" id="frm_update">
<table cellpadding="0" cellspacing="0" border="0" width="100%">   
<tr>
	<td>
    	Stock Name
    </td>
    <td>
    	Quantity
    </td>
    <td>
    	Remove
    </td>
</tr> 
	<?	
	foreach($_SESSION['cart'] as $cartItems)
	{
		foreach($cartItems as $prodcut_id)
		{
			$sql = "select * from ms_stock_master where rec_id = '$prodcut_id'";
			$result = mysql_query($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());;
			if(mysql_num_rows($result)>0)
			{
				$row = mysql_fetch_array($result);
				?>
                <tr>
                    <td>
                        <?=$row['item_name']?>
                    </td>
                    <td>	
                        <?=$_SESSION["session_qty_$prodcut_id"]?>  <?=getunittDetail('unit_name','rec_id', $row['quantity_unit'])?>
                    </td>
                    <td>
                    	<input name="delete_<?=$prodcut_id?>" vaule="1" type="checkbox">
                        <input type="hidden" name="update_cart[]" id="update_cart[]" value="<?=$prodcut_id?>"/>
                    </td>
                </tr>
  				<?
			}
		}
	}
	?>
    <tr>
        <td>
            <input type="submit" name="btn_remove" id="btn_remove" value="Remove"/>
        </td>
        <td>
        </td>
        <td>
            <input type="button" name="btn_receipt" id="btn_receipt" value="Receipt" onclick="window.location='stock_receipt.php'"/>
        </td>
    </tr>
</table> 
</form> 
    <?
	
}
?> 		
																	