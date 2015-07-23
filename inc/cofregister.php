<?php
	include("inc/hr_header.php");
?>

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/snb.php"); ?>
        </td> 
<td style="padding-left:5px; padding-top:5px;" valign="top">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/>COF Ragister</td>
                </tr>
                <?php
				include("inc/dbconnection.php");
				$que = mysql_query("select * from mpc_attendence_master");
				while($row = mysql_fetch_array($que))
				
				{
					print_r($row);
					
					}
				
				?>
        </table>

<?php

include("inc/hr_footer.php");
?>