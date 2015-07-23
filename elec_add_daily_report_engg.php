<?
include("inc/elec_header.php");
?>
<script type="text/javascript">
function getSubDeptData() {
	var deptId = document.getElementById("department_id").value;
	document.getElementById("div_sub_dept").style.border="none";
	//alert(deptId);
	document.getElementById("div_sub_dept").style.padding="0";	
	get_frm("elec_get_sub_department.php",deptId,"div_sub_dept",'');
}
</script>
<?
$Page = "elec_add_daily_report_engg.php";
$PageTitle = "Add Daily Report";
$PageFor = "Daily Report";
$PageKey = "DailyReportId";
$PageKeyValue = "";
$Message = "";
$mode = "";
$DailyReportDate = '';
$UnitConsumption = '';
$MaxDemand = '';
$LoadFactor = '';
$PowerFactor = '';
$LightingUnit = '';
$ColonyUnit = '';
$CompressorUnit = '';
$tfo='';
$BlowRoom = '';
$Preparatory = '';
$RingFrame = '';
$AutoCorner ='';
$ProgressReport = '';
if(isset($_GET["mode"])){
	$mode = $_GET["mode"];
	$sql_idate="select * from elec_daily_report_engg where insert_date='".date('Y-m-d')."' and $PageKey='".$_GET[$PageKey]."'";
	$res_idate=mysql_query($sql_idate);
	if(mysql_num_rows($res_idate)==0 && !($SessionUserType=='Administrator')){
		echo "<script>alert('You Cant Update Here');location.href='elec_homepage.php';</script>";
	}
}

if(isset($_GET[$PageKey])){
	$sql = "select * from elec_daily_report_engg where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0){
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$DailyReportId = $row['DailyReportId'];
		$DailyReportDate = getDateFormate($row["DailyReportDate"]);
		$UnitConsumption = $row['UnitConsumption'];
		$MaxDemand = $row["MaxDemand"];
		$LoadFactor = $row["LoadFactor"];
		$PowerFactor = $row["PowerFactor"];
		$LightingUnit = $row["LightingUnit"];
		$ColonyUnit = $row["ColonyUnit"];
		$CompressorUnit = $row["CompressorUnit"];
		$BlowRoom = $row["BlowRoom"];
		$Preparatory = $row["Preparatory"];
		$RingFrame = $row["RingFrame"];
		$AutoCorner = $row["AutoCorner"];
		$ProgressReport = $row["ProgressReport"];
	}
}else if(!isset($_GET[$PageKey])){
	$sql="select max(DailyReportId) as DailyReportId from elec_daily_report_engg";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$DailyReportId=($row['DailyReportId']+1);
}

if(isset($_POST["btn_submit"])){
	echo '<pre>';	print_r($_POST);	echo '</pre>';
	$PageKeyValue = $_POST[$PageKey];
	$DailyReportDate = getDateFormate($_POST["DailyReportDate"]);
	$UnitConsumption = addslashes($_POST['UnitConsumption']);
	$MaxDemand = addslashes($_POST["MaxDemand"]);
	$LoadFactor = addslashes($_POST["LoadFactor"]);
	$PowerFactor = addslashes($_POST["PowerFactor"]);
	$LightingUnit = addslashes($_POST["LightingUnit"]);
	$ColonyUnit = addslashes($_POST["ColonyUnit"]);
	$CompressorUnit = addslashes($_POST["CompressorUnit"]);
$tfo = addslashes($_POST["tfo"]);
	$BlowRoom = addslashes($_POST["BlowRoom"]);
	$Preparatory = addslashes($_POST["Preparatory"]);
	$RingFrame = addslashes($_POST["RingFrame"]);
	$AutoCorner = addslashes($_POST["AutoCorner"]);
 	$ProgressReport = addslashes($_POST["ProgressReport"]);
	
	if($PageKeyValue == ""){
		$tableName="elec_daily_report_engg";
		$tableData=array("''","'$DailyReportDate'","'$UnitConsumption'","'$MaxDemand'","'$LoadFactor'","'$PowerFactor'","'$LightingUnit'","'$ColonyUnit'","'$CompressorUnit'","'$tfo'","'$BlowRoom'","'$Preparatory'","'$RingFrame'","'$AutoCorner'","'$ProgressReport'","now()");
		//print_r($tableData);
	  addDataIntoTable($tableName,$tableData);
		$Message = "$PageFor Inserted";
		redirect("$Page?Message=$Message");
	}else{
		if($mode == "edit"){
			$tableName="elec_daily_report_engg";
			$tableColumns=array("DailyReportId","DailyReportDate","UnitConsumption","MaxDemand","LoadFactor","PowerFactor","LightingUnit","ColonyUnit","CompressorUnit","TFO","BlowRoom","Preparatory","RingFrame","AutoCorner","ProgressReport");
			$tableData=array("'$PageKeyValue'","'$DailyReportDate'","'$UnitConsumption'","'$MaxDemand'","'$LoadFactor'","'$PowerFactor'","'$LightingUnit'","'$ColonyUnit'","'$CompressorUnit'","'$tfo'","'$BlowRoom'","'$Preparatory'","'$RingFrame'","'$AutoCorner'","'$ProgressReport'");
			//print_r($tableData);
		  updateDataIntoTable($tableName,$tableColumns,$tableData);
			$Message = "$PageFor Updated";
		}
	}
	redirect("elec_list_daily_report_engg.php?Message=$Message");
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
          <td align="center" class="gray_bg">
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add/Edit Daily Report
          </td>
        </tr>
        <tr>
          <td valign="top" style="padding-top:10px;">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td class="red"><?=$Message?></td>
              </tr>
              <tr>
                <td valign="top" style="padding-bottom:5px;">
                  <form name="frm_add" id="frm_add" action="" method="post">
                  <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                    <tr>
                      <td align="center" valign="top" class="border" width="50%" bgcolor="#EAE3E1">
                       <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                          <tr>
                            <td align="left"><b>Daily Report Id</b></td>
                            <td align="left">
                              <input type="text" readonly="readonly" id="DailyReportId" name="DailyReportId" value="<?= $DailyReportId?>"/>
                            </td>
                            <td align="left"><b>Daily Report Date</b></td>
                            <td align="left">
                              <input type="text" readonly="readonly" id="DailyReportDate" name="DailyReportDate" value="<?= $DailyReportDate?>"/>
                              <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.getElementById('DailyReportDate'));return false;" HIDEFOCUS>
                                <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                            </a> 
                            </td>
                          </tr>
                          <tr>
                            <td align="left"><b>Unit Consumption</b></td>
                            <td align="left">
                              <input type="text" id="UnitConsumption" name="UnitConsumption" value="<?= $UnitConsumption?>"/>
                            </td>
                            <td align="left"><b>Max Demand</b></td>
                            <td align="left">
                              <input type="text" id="MaxDemand" name="MaxDemand" value="<?= $MaxDemand?>"/>
                            </td>
                          </tr>
                          <tr>
                            <td align="left"><b>Load Factor</b></td>
                            <td align="left">
                              <input type="text" id="LoadFactor" name="LoadFactor" value="<?= $LoadFactor?>"/>
                            </td>
                            <td align="left"><b>Power Factor</b></td>
                            <td align="left">
                              <input type="text" id="PowerFactor" name="PowerFactor" value="<?= $PowerFactor?>"/>
                            </td>
                          </tr>
                          <tr>
                            <td align="left"><b>Lighting Unit</b></td>
                            <td align="left">
                              <input type="text" id="LightingUnit" name="LightingUnit" value="<?= $LightingUnit?>"/>
                            </td>
                            <td align="left"><b>Colony Unit</b></td>
                            <td align="left">
                              <input type="text" id="ColonyUnit" name="ColonyUnit" value="<?= $ColonyUnit?>"/>
                            </td>
                          </tr>
                          <tr>
                            <td align="left"><b>Compressor Unit</b></td>
                            <td align="left">
                              <input type="text" id="CompressorUnit" name="CompressorUnit" value="<?= $CompressorUnit?>"/>
                            </td>
                            <td align="left"><b>T. F. O.</b></td>
                            <td align="left" colspan="3">
                              <input type="text" id="tfo" name="tfo" value="<?=$tfo?>"/>
                            </td>
                          </tr>
                          <tr>
                            <td align="left"><b>Blow Room</b></td>
                            <td align="left">
                              <textarea name="BlowRoom" id="BlowRoom" rows="3" cols="30"><?= $BlowRoom?></textarea>
                            </td>
                            <td align="left"><b>Preparatory</b></td>
                            <td align="left">
                              <textarea id="Preparatory" name="Preparatory" rows="3" cols="30"><?= $Preparatory?></textarea>
                            </td>
                          </tr>    
                          <tr>
                            <td align="left"><b>Ring Frame</b></td>
                            <td align="left">
                              <textarea name="RingFrame" id="RingFrame" rows="3" cols="30"><?= $RingFrame?></textarea>
                            </td>
                            <td align="left"><b>Autocorner</b></td>
                            <td align="left">
                              <textarea id="AutoCorner" name="AutoCorner" rows="3" cols="30"><?= $AutoCorner?></textarea>
                            </td>
                          </tr>   
                          <tr>
                            <td align="left"><b>Progress Report</b></td>
                            <td align="left">
                              <textarea name="ProgressReport" id="ProgressReport" rows="3" cols="30"><?= $ProgressReport?></textarea>
                            </td>               
                           </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td align="center" colspan="3">
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
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>                                        
<? include("inc/hr_footer.php"); ?>