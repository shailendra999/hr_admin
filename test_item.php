<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Machinary List</title>
</head>

<body onload="print()">
<? 
	include("inc/store_function.php");
	include("inc/dbconnection.php");
?>
<table width="740px" cellpadding="0" cellspacing="0" align="center" border="0">
	<tr height="35px"><td align="center"><b><h3>UOM List</h3></b></td></tr>
	<tr> 
  	<td>          
          <table align="center" width="100%" cellpadding="2" cellspacing="1" border="1" style="border-collapse:collapse">
            <tr>
              <td align="center"><b>UOM Id</b></td>
              <td align="center"><b>UOM Name</b></td>
            </tr>
            <?
            $sql = "select * from ms_uom order by uom_id";
            $result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
            if(mysql_num_rows($result)>0)
            {
              $num = mysql_num_rows($result) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
              $sno=1;
              while($row = mysql_fetch_array($result)) 
              { 
                
                ?>
                <tr>
                  <td align="center"><?=$row["uom_id"]?></td>
                  <td align="left" style="padding-left:3px"><?=$row["name"]?></td>
                </tr>
                <?												
               }
             }
             else
             {
             ?>
              <tr bgcolor="#f9f8f9">
                <td colspan="5" align="center">No Records Entered Yet.</td>
              </tr>
             <? 
             }
             ?>
          </table>
    </td>
  </tr>
  
</table>

</body>
</html>