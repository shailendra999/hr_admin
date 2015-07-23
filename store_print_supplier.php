<?
include("inc/dbconnection.php");
include("inc/store_function.php");

$supplier_id = $_POST["supplier_id"];
$where = "";
if($supplier_id!="" and $supplier_id!="0")
{
	$where = " where supplier_id = '$supplier_id'";
}
echo $sql="select * from ms_supplier $where order by name asc";
//echo $sql;
//$sql = $sql ." LIMIT " . $start . ", $row_limit";
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());

$numrows = mysql_num_rows($result);
$no_of_rec_show=25;
$count = ceil($numrows/$no_of_rec_show);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Supplier List</title>
<style>
.note
{
font: Arial, Helvetica, sans-serif;
font-size:13px;
font-weight:bold;
height:30px;
}
.particulars
{
font: Arial, Helvetica, sans-serif;
font-size:11px;
height:25px;
}
.tblborder
{
 border-collapse:collapse;border-color:1px solid #000;
}
.break { page-break-before: always; }
</style>

</head>

<body onload="print();">
<? 
	for($i=0,$countTrans=1;$i<$count;$i++)
	{
	?>
    <div style="margin:0 auto;width:740px;padding:2px">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr height="70px">
            <td align="center">
              <b><u>MAHIMA PURESPUN</u></b><br />
              <b>Supplier List</b>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <table align="center" width="100%" border="1" class="tblborder">
                <tr class="note">
                  <td align="center" width="6%">S.No.</td>
                  <td align="center" width="35%">Supplier Name</td>
                  <td align="center" width="15%">Phone No.</td>
                  <td align="center" width="30%">Address</td>
                  <td align="center" width="14%">TIN</td>
                </tr>
                <?  
                if(mysql_num_rows($result)>0)
                {
									$sno = 1;
									$sno=1;
									$j=$i*$no_of_rec_show;
									mysql_data_seek($result,$j);
									$k=0;
                  while($row=mysql_fetch_array($result))
                  {
                    
                    ?>
                    <tr class="particulars">
                      <td align="center"><?=$countTrans++?></td>
                      <td align="left" style="padding-left:2px;"><?=$row['name']?></td>
                      <td align="left" style="padding-left:2px;"><?=$row['phone_number']?></td>
                      <td align="left" style="padding-left:2px;"><?=stripslashes($row['address'])?></td>
                      <td align="center"><?=$row['tin']?></td>
                   </tr>
                  <?
									if($k==($no_of_rec_show-1))
									{
										break;
									}
									$k++;
                  $sno++;
                }	
              ?> 
              <?
              } // End Of If
              else
              {
              ?>
              <tr>
                <td align="center" colspan="5"><b>No Records Found</b></td>
              </tr>
              <?
              }
              ?>
             </table>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  	<p class="break"></p>
  <?
  }
 ?>
</body>
</html>
