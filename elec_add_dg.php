<? include("inc/elec_header.php"); ?>
<?
$Page = "elec_add_dg.php";
$PageTitle = "Add Diesel Generator";
$PageFor = "Diesel Generator";
$PageKey = "DG_id";
$PageKeyValue = "";
$Message = "";
$DG_id = "";
$DGName = "";
if(isset($_GET["mode"])){
	$mode = $_GET["mode"];
	$sql_idate="select * from elec_energy_consumption where insert_date='".date('Y-m-d')."' and $PageKey='".$_GET[$PageKey]."'";
	$res_idate=mysql_query($sql_idate);
	if(mysql_num_rows($res_idate)==0 && !($SessionUserType=='Administrator')){
		echo "<script>alert('You Cant Update Here');location.href='elec_homepage.php';</script>";
	}
}

/*if(isset($_GET[$PageKey])){
	$sql = "select * from elec_energy_consumption where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0){
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];$EC_id = $row['EC_id'];
		$department_id = $row["department_id"];
		$machine_name = $row["machine_name_number"];
		$time = $row["time"];
		$hr_mtr_reading = $row["hour_meter_reading"];
		$reading = $row["reading"];
		$reading_date = getDateFormate($row["reading_date"]);
	}
}*/
else if(!isset($_GET[$PageKey])){
	$sql="select max(DG_id) as DG_id from elec_DG_master";
	$res=mysql_query($sql);
	@$row=mysql_fetch_array($res);
	$DG_id=($row['DG_id']+1);
}

if(isset($_POST["btn_submit"])){
	$PageKeyValue = $_POST[$PageKey];
	$DGName = $_POST["DGName"];
	if($PageKeyValue == ""){
		$tableName="elec_DG_master";
		$tableData=array("''","'$DGName'","now()","''");
		//print_r($tableData);
	  addDataIntoTable($tableName,$tableData);
		$Message = "$PageFor Inserted";
		redirect("$Page?Message=$Message");
	}else{
		if($mode == "edit"){
			$tableName="elec_DG_master";
			$tableColumns=array("DG_id","DG_name");
			$tableData=array("'$PageKeyValue'","'$DG_name'");
			//print_r($tableData);
			updateDataIntoTable($tableName,$tableColumns,$tableData);
			$Message = "$PageFor Updated";
		}
	}
	redirect("elec_add_dg.php?Message=$Message");
}
if(isset($_GET["Message"])){
	$Message = $_GET["Message"];
}
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
	<tr>
		<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/elec_setting_snb.php"); ?>
		</td>
		<td style="padding-left:5px; padding-top:5px;" valign="top">
			<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
        <tr>
          <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add / Edit Diesel Generator</td>
        </tr>
        <tr>
          <td valign="top" style="padding-top:10px;">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td class="red"><?=$Message?></td>
              </tr>
              <tr>
                <td valign="top" class="border" bgcolor="#EAE3E1">
<form name="frm_add" id="frm_add" action="" method="post">
<table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
<tr>
	<td width="250px;">&nbsp;</td>
	<td align="left"><b>DG Id</b></td>
    <td align="left"><input type="text" readonly="readonly" id="DG_id" name="DG_id" value="<?=$DG_id?>"/></td>
</tr>
<tr>
	<td width="250px;">&nbsp;</td>
	<td align="left"><b>DG Name</b></td>
    <td align="left">
    	<input type="text" id="DGName" name="DGName" value="<?=$DGName?>"  />
	</td>
</tr>                           
<tr height="30px">
	<td align="center" colspan="4" style="padding-top:10px">
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
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>                                        
<? include("inc/hr_footer.php"); ?>