<?
include("inc/store_header.php");
?>

<?
$Page = "store_add_supplier.php";
$PageTitle = "Add Supplier";
$PageFor = "Supplier";
$PageKey = "supplier_id";
$PageKeyValue = "";
$Message = "";
$mode = "";
$name = '';$address = '';$phone_number = '';
$fax='';$email = '';$tin = '';$pan = '';

if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
	$sql_idate="select * from ms_supplier where insert_date='".date('Y-m-d')."' and $PageKey='".$_GET[$PageKey]."'";
	$res_idate=mysql_query($sql_idate);
	if(mysql_num_rows($res_idate)==0 && !($SessionUserType=='Administrator'))
	{
		echo "<script>alert('You Cant Update Here');location.href='store_homepage.php';</script>";
	}
	//$row_idate=mysql_fetch_array($res_idate);
}
if(isset($_POST["btn_submit"]))
{
	$PageKeyValue = $_POST[$PageKey];
	$name = $_POST['name'];
	$phone_number = $_POST['phone_number'];
	$address = addslashes($_POST['address']);
	$fax = $_POST['fax'];
	$email = $_POST['email'];
	$tin=$_POST['tin'];
	if($PageKeyValue == "")
	{
		$tableName="ms_supplier";
		$tableData=array("''","'$name'","'$phone_number'","'$fax'","'$address'","'$email'","'$tin'","now()");
		if(addDataIntoTable($tableName,$tableData))
			$Message = "$PageFor Inserted";
		else
			$Message = "Error In Inserting";
		redirect("$Page?Message=$Message");
	}	
	else
	{
		if($mode == "edit")
		{					
			$tableName="ms_supplier";
			$tableColumns=array("supplier_id","name","phone_number","fax","address","email_id","tin");
			$tableData=array("'$PageKeyValue'","'$name'","'$phone_number'","'$fax'","'$address'","'$email'","'$tin'");
			if(updateDataIntoTable($tableName,$tableColumns,$tableData))
				$Message = "$PageFor Updated";
			else
				$Message = "Error In Updating";
			redirect("store_list_supplier.php");
		}
	}
}
?>
<?

$supplier_id = "";
if(isset($_GET["supplier_id"]))
{
	$supplier_id = $_GET["supplier_id"];
}
else
{
	$sql="select max(supplier_id) as supplier_id from ms_supplier";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$supplier_id=($row['supplier_id']+1);
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
		$name = $row['name'];$phone_number = $row['phone_number'];$fax = $row['fax'];
		$address = stripslashes($row['address']);$email = $row['email_id'];	
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
        	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add/Edit Supplier</td>
        </tr>
        <tr>
          <td valign="top" style="padding-top:10px;">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
            <td class="red"><?=$Message?></td>
            </tr>
              <tr>
                <td valign="top" style="padding-bottom:5px;" bgcolor="#EAE3E1">
                  <form name="frm_add" id="frm_add" action="" method="post">
                    <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1 border">
                      <tr>
                        <td align="left"><b>Supplier Code</b></td>
                        <td align="left" colspan="3">
                          <input type="text" id="supplier_id" name="supplier_id" value="<?=$supplier_id?>" readonly="readonly"/>
                        </td>
                      </tr>
                      <tr>
                        <td align="left"><b>Name</b></td>
                        <td align="left"><input type="text" id="name"  name="name" value="<?= $name ?>" /></td>
                        <td align="left"><b>Phone Number</b></td>
                        <td align="left">
                        <input type="text" id="phone_number" name="phone_number" value="<?= $phone_number ?>" />
                        </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"><b>Address</b></td>
                        <td align="left">
                          <textarea name="address" id="address" rows="3" cols="25"><?=$address?></textarea>
                        </td>
                        <td align="left"><b>Email Id</b></td>
                        <td align="left"><input type="text" id="email" name="email" value="<?= $email ?>" /></td>
                      </tr>
                      <tr>
                        <td align="left"><b>TIN</b></td>
                        <td align="left">
                          <input type="text" id="tin" name="tin" value="<?= $tin ?>" />
                        </td>
                        <td align="left"><b>Fax Number</b></td>
                        <td align="left">
                          <input type="text" id="fax" name="fax" value="<?= $fax ?>" />
                        </td>
                      </tr>
                      <tr>
                        <td align="center" colspan="4">
                        <input type="hidden" id="mode" name="mode" value="<?=$mode?>"/>
                        <input type="hidden" id="<?=$PageKey?>" name="<?=$PageKey?>" value="<?=$PageKeyValue?>" />
                        <input type="submit" id="btn_submit" name="btn_submit" value="Save" class="btn_bg" />
                        </td>
                      </tr>
                    </table>
                  </form>
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