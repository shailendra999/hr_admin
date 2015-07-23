<?php
include("inc/check_session.php");
include("inc/dbconnection.php");
include("inc/function.php");

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>LSSPL-ERP</title>
        <link href="style/hr_style.css" type="text/css" rel="stylesheet">
        <script language="JavaScript1.2" src="ajax/common_function.js"></script>
        <script language="JavaScript1.2" src="inc/mm_menu.js"></script>
        
         <!-- date picker -->
        <link rel="stylesheet" href="css/BeatPicker.min.css"/>
        <script src="js/jquery-1.11.0.min.js"></script>
        <script src="js/BeatPicker.min.js"></script> 
        
               <!-- end -->
        <? include("inc/menu_3.php"); ?>

    </head>
    <body>
        <script language="JavaScript1.2">mmLoadMenus();</script>
        <table width="98%" cellpadding="0" cellspacing="0" border="0" align="center">
            <tr>
                <td align="center"><? include ("inc/top_tnb_user.php"); ?></td>
            </tr>
            <tr>
                <td class="header_bg"><img src="images/web_logo.png"></td>
            </tr>
            <tr>
                <td align="center"><? include ("inc/tnb.php"); ?></td>
            </tr>
        </table>
