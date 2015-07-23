<?php
	include("inc/check_session.php");
	include("inc/dbconnection.php");
	include("inc/store_function.php");
?>
<? 
$Total = 0;
$g_total = 0;
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
////////// Code For Updating Selected Item Quntity////////////////
//echo $_POST['product_id'];
/*if(isset($_POST['product_id']))
{
	$product_id = $_POST['product_id'];
	$qty_id = $_POST['qty'];

	$i=0;
	foreach($product_id as $prod_id)
	{
		$product_qty_id = getProductDetail("Quantity","ProductId",$prod_id);	
		if($product_qty_id >= $qty_id[$i])
		{
		$_SESSION["session_qty_$prod_id"] = $qty_id[$i];
		}
		$i++;
	}
}*/
?>
<?

///////////////Code For Deleteing the Selected Item/////////////
/*if(isset($_GET['mode']))
{
	$product_id = $_GET['product_id'];
	unset ($_SESSION['cart'][$product_id]);
	session_unregister("session_$product_id");
	session_unregister("session_qty_$product_id");
	//	echo "delete cart ";
}*/
?>
<?
////////// Code For Updating Selected Item Quntity////////////////
//echo $_POST['product_id'];
/*if(isset($_POST['update_cart']))
{
	$product_id = $_POST['update_cart'];

	$i=0;
	foreach($product_id as $prod_id)
	{	
		$delete_id[$i] = isset($_POST["delete_$prod_id"]) ? $_POST["delete_$prod_id"]:"";
		if($delete_id[$i] =='on')
			{
				unset ($_SESSION['cart'][$prod_id]);
				session_unregister("session_$prod_id");
				session_unregister("session_qty_$prod_id");
			}
		$i++;
	}
}*/
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mahima Purespun ERP</title>
<link href="style/store_style.css" type="text/css" rel="stylesheet">
<script language="JavaScript1.2" src="ajax/common_function.js"></script>
<script language="JavaScript1.2" src="inc/mm_menu.js"></script>
<? include("inc/purchase_menu_3.php"); ?>

</head>
<body>
<script language="JavaScript1.2">mmLoadMenus();</script>
<table width="98%" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
    	<td align="center"><? include ("inc/purchase_top_tnb.php"); ?></td>
    </tr>
    <tr>
    	<td class="header_bg"><img src="images/header.jpg" width="259" height="78"></td>
    </tr>
    <tr>
    	<td align="center"><? include ("inc/purchase_tnb.php"); ?></td>
    </tr>
</table>