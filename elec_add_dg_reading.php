<? include("inc/elec_header.php"); ?>
<?
$Page = "elec_add_dg_reading.php";
$PageTitle = "Add Diesel Generator Reading";
$PageFor = "Diesel Generator Reading";
$PageKey = "DG_reading_id";
$PageKeyValue = "";
$Message = "";
$DG_id = "";
$DG_reading_id = "";
$RunningHours = "";
$OilTemp = "";
$DieselLevel = "";
$KWH = "";
$Unit = "";
$reading_date = "";
if(isset($_GET["mode"])){
	$mode = $_GET["mode"];
	$sql_idate="select * from elec_DG_reading where insert_date='".date('Y-m-d')."' and $PageKey='".$_GET[$PageKey]."'";
	$res_idate=mysql_query($sql_idate);
	if(mysql_num_rows($res_idate)==0 && !($SessionUserType=='Administrator')){
		echo "<script>alert('You Cant Update Here');location.href='elec_homepage.php';</script>";
	}
}

if(isset($_GET[$PageKey])){
	$sql = "select * from elec_DG_reading where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0){
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];$EC_id = $row['DG_reading_id'];
		$DG_id = $row["DG_id"];
		$reading_date = getDateFormate($row["ReadingDate"]);
		$RunningHours = $row["RunningHours"];
		$OilTemp = $row["OilTemp"];
		$DieselLevel = $row["DieselLevel"];
		$KWH = $row["KWH"];
	}
}
else if(!isset($_GET[$PageKey])){
	$sql="select max(DG_reading_id) as DG_reading_id from elec_DG_reading";
	$res=mysql_query($sql);
	@$row=mysql_fetch_array($res);
	$DG_reading_id =($row['DG_reading_id']+1);
}

if(isset($_POST["btn_submit"])){
#	echo '<pre>';	print_r($_POST);	echo '</pre>';

	$PageKeyValue = $_POST[$PageKey];
	$DG_id = $_POST["DG_id"];
	$reading_date = getDateFormate($_POST["reading_date"]);
	$RunningHours = $_POST["RunningHours"];
	$OilTemp = $_POST["OilTemp"];
	$DieselLevel = $_POST["DieselLevel"];
	$KWH = $_POST["KWH"];
	
	if($PageKeyValue == ""){
		$tableName="elec_DG_reading";
		$tableData=array("''","'$DG_id'","'$reading_date'","'$RunningHours'","'$OilTemp'","'$DieselLevel'","'$KWH'","now()","''");
		//print_r($tableData);
	  addDataIntoTable($tableName,$tableData);
		$Message = "$PageFor Inserted";
		redirect("$Page?Message=$Message");
	}else{
		if($mode == "edit"){
			$tableName="elec_DG_reading";
			$tableColumns=array("DG_reading_id","DG_id","ReadingDate","RunningHours","OilTemp","DieselLevel","KWH");
			$tableData=array("'$PageKeyValue'","'$DG_id'","'$ReadingDate'","'$RunningHours'","'$OilTemp'","'$DieselLevel'","'$KWH'");
			//print_r($tableData);
			updateDataIntoTable($tableName,$tableColumns,$tableData);
			$Message = "$PageFor Updated";
		}
	}
	redirect("elec_list_dg_reading.php?Message=$Message");
}
if(isset($_GET["Message"])){
	$Message = $_GET["Message"];
}
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
	<tr>
		<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/elec_snb.php"); ?>
		</td>
		<td style="padding-left:5px; padding-top:5px;" valign="top">
			<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
        <tr>
          <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add / Edit Diesel Generator Reading</td>
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
	<td align="left"><b>Reading Date</b></td>
    <td align="left">
    	<input type="text" id="reading_date" name="reading_date" value="<?=$reading_date?>"  />
		<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.reading_date);return false;" HIDEFOCUS>
    		<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
		</a> 
	</td>
	<td align="left"><b>DGNo.</b></td>
    <td align="left">
		<? $sql_D= "select * from elec_DG_master order by DG_name";
        $res_D = mysql_query ($sql_D) or die (mysql_error()); ?>
        <select name="DG_id" id="DG_id" style="width:160px;">
        <option value="0"></option>
        <? if(mysql_num_rows($res_D)>0){
            while($row_D = mysql_fetch_array($res_D)){ ?>
        <option value="<?= $row_D['DG_id']; ?>" <? if($row_D['DG_id']==$DG_id){ ?> selected="selected"<? }?> ><?= $row_D['DG_name']; ?></option>
        <? }
        } ?>
        </select>
	</td>
</tr>
<tr>
	<td align="left"><b>Running Hours</b></td>
    <td align="left">
    	<input type="text" id="RunningHours" name="RunningHours" value="<?=$RunningHours?>"  />
	</td>
	<td align="left"><b>Oil Temp. (&deg;C)</b></td>
    <td align="left">
    	<input type="text" id="OilTemp" name="OilTemp" value="<?=$OilTemp?>"  />
	</td>
</tr>
<tr>
    <td align="left"><b>Diesel Level (Ltr.)</b></td>
    <td align="left">
    	<input type="text" id="DieselLevel" name="DieselLevel" value="<?=$DieselLevel?>"  />
	</td>
	<td align="left"><b>KWH</b></td>
    <td align="left">
    	<input type="text" id="KWH" name="KWH" value="<?=$KWH?>"  />
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