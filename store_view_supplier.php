<?
include("inc/store_header.php");
?>
<?
$Page = "store_add_supplier.php";
$PageTitle = "View Supplier";
$PageFor = "Supplier";
$PageKey = "supplier_id";
$PageKeyValue = "";$Message = "";$mode = "";$name = '';$address = '';$phone_number = '';
$email = '';$tin = '';$fax = '';
?>
<?
$supplier_id = "";
if(isset($_GET["supplier_id"]))
{
	$supplier_id = $_GET["supplier_id"];
}
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}

if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_supplier where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$name = $row['name'];$phone_number = $row['phone_number'];
		$address = $row['address'];$email = $row['email_id'];	
		$fax = $row['fax'];
		$tin = $row['tin'];
	}
}
?>

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
    	<? include ("inc/store_snb.php"); ?>
    </td>
    <td style="padding-left:5px; padding-top:5px;" valign="top">
      <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
        <tr>
        	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; View Supplier</td>
        </tr>
        <tr>
          <td valign="top" style="padding-top:10px;">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
            	<tr>
      					<td class="red"><?=$Message?></td>
              </tr>
              <tr>
              	<td valign="top" style="padding-bottom:5px;">
              		<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                    <tr>
                      <td align="center" valign="top" class="border">
                        <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                          <tr style="line-height:22px;background:#EAE3E1;">
                            <td align="left"><b>Supplier Id</b></td>
                            <td align="left"><?=$supplier_id?></td>
                            <td align="left"><b>Name</b></td>
                            <td align="left"><?= $name ?></td>
                          </tr>
                          <tr style="line-height:22px;background:#FFF;">
                            <td align="left"><b>Phone Number</b></td>
                            <td align="left"><?= $phone_number ?></td>
                            <td align="left" valign="top"><b>Address</b></td>
                            <td align="left"><?=$address?></td>
                          </tr>
                          <tr style="line-height:22px;background:#FFF;">
                            <td align="left"><b>Tin</b></td>
                            <td align="left"><?=$tin?></td>
                            <td align="left"><b>Fax</b></td>
                            <td align="left"><?=$fax?></td>
                          </tr>
                          <tr style="line-height:22px;background:#EAE3E1;">
                            <td align="left"><b>Email Id</b></td>
                            <td align="left" colspan="3"><?= $email ?></td>
                          </tr>  
                        </table>
                      </td>
										</tr>
									</table>
      					</td>
      				</tr>
      			</table>
					</td>
				</tr>
      </table>
    </td>
  </tr>
</table>
<? 
include("inc/hr_footer.php");
?>