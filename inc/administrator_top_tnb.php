<table width="100%" cellpadding="0" cellspacing="0" border="0" class="top_tnb">
	<tr>
    <td width="66%" align="right">
      <?
        if($SessionUserType=='Administrator')
        {
          ?>
          <a href="administrator_homepage.php">Home</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <a href="store_homepage.php">Store</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <a href="elec_homepage.php">Electric</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <a href="maint_homepage.php">Maintenance</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <a href="hr_homepage.php">HR</a>
          <?
        }
      ?>
    </td>
    <td width="1%"><img src="images/tnb_div.jpg" width="2" height="25"/></td>
    <td width="15%">Welcome to : <b><?=ucfirst($SessionUserName)?></b></td>
    <td width="1%"><img src="images/tnb_div.jpg" width="2" height="25"/></td>
    <td width="10%"><a href="#">Setting</a></td>
    <td width="1%"><img src="images/tnb_div.jpg" width="2" height="25"/></td>
    <td width="6%"><a href="logoff.php">Log off</a></td>
  </tr>
</table>