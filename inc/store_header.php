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

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laxyo Pvt. Ltd.</title>
<link href="style/store_style.css" type="text/css" rel="stylesheet">
<script language="JavaScript1.2" src="ajax/common_function.js"></script>
<script language="JavaScript1.2" src="inc/mm_menu.js"></script>
<? include("inc/store_menu_3.php"); ?>

</head>
<body>
<script language="JavaScript1.2">mmLoadMenus();</script>
<table width="98%" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
    	<td align="center"><? include ("inc/store_top_tnb.php"); ?></td>
    </tr>
    <tr>
    	<td class="header_bg"><img src="images/web_logo.png" width="259" height="78"></td>
    </tr>
    <tr>
    	<td align="center"><? include ("inc/store_tnb.php"); ?></td>
    </tr>
</table>