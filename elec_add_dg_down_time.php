<? include("inc/elec_header.php"); ?>
<script src="javascript/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
<script src="javascript/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
$('#DownStartTime').timepicker({});
$('#DownEndTime').timepicker({});
</script>
<style>
	.ui-timepicker-div .ui-widget-header { margin-bottom: 8px; }
	.ui-timepicker-div dl { text-align: left; }
	.ui-timepicker-div dl dt { height: 25px; }
	.ui-timepicker-div dl dd { margin: -25px 10px 10px 65px; }
	.ui-timepicker-div td { font-size: 90%; }
	.ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; }
</style>
<?
$Page = "elec_add_dg_down_time.php";
$PageTitle = "Add Diesel Generator Down Time";
$PageFor = "Diesel Generator Down Time";
$PageKey = "DG_down_time_id";
$PageKeyValue = "";
$Message = "";
$DG_id = "";
$DownStartTime = "";
$DownEndTime = "";
$Reason = "";
$multiplyingfactor = "";
$EM = "";
$DieselRec = "";
$reading_date = "";
if(isset($_GET["mode"])){
	$mode = $_GET["mode"];
	$sql_idate="select * from elec_DG_down_time where insert_date='".date('Y-m-d')."' and $PageKey='".$_GET[$PageKey]."'";
	$res_idate=mysql_query($sql_idate);
	/*if(mysql_num_rows($res_idate)==0 && !($SessionUserType=='Administrator')){
		echo "<script>alert('You Cant Update Here');location.href='elec_homepage.php';</script>";
	}*/
}

if(isset($_GET[$PageKey])){
	$sql = "select * from elec_DG_down_time where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0){
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$DG_id = $row["DG_id"];
		$reading_date = getDateFormate($row["ReadingDate"]);
		$DownStartTime = $row["DownStartTime"];
		$DownEndTime = $row["DownEndTime"];
		$Reason = $row["Reason"];
		$multiplyingfactor = $row["multiplyingfactor"];
		$EM= $row["EM"];
		$DieselRec = $row["DieselRec"];
	}
}
if(isset($_POST["btn_submit"])){
	echo '<pre>';	print_r($_POST);	echo '</pre>';

	$PageKeyValue = $_POST[$PageKey];
	$DG_id = $_POST["DG_id"];
	$reading_date = getDateFormate($_POST["reading_date"]);

	$SHour = $_POST['SHour'];
	$SMin = $_POST['SMin'];
	$EHour = $_POST['EHour'];
	$EMin = $_POST['EMin'];

 	$DownStartTime = ($SHour * 60) + $SMin;
 	$DownEndTime = ($EHour * 60) + $EMin;

#die();	
	$Reason = $_POST["Reason"];
	$multiplyingfactor = $_POST["FillUpFuel"];
	$EM = $_POST["EM"];
	$DieselRec = $_POST["DieselRec"];

	if($PageKeyValue == ""){
		$tableName="elec_DG_down_time";
		$tableData=array("''","'$DG_id'","'$reading_date'","'$DownStartTime'","'$DownEndTime'","'$Reason'","'$multiplyingfactor'","'$EM'","'$DieselRec'","now()","''");
		//print_r($tableData);
	  addDataIntoTable($tableName,$tableData);
		$Message = "$PageFor Inserted";
		redirect("$Page?Message=$Message");
	}else{
		if($mode == "edit"){
			$tableName="elec_DG_down_time";
			$tableColumns=array("DG_down_time_id","DG_id","ReadingDate","DownStartTime","DownEndTime","Reason","multiplyingfactor","EM","DieselRec","update_at");
			$tableData=array("'$PageKeyValue'","'$DG_id'","'$reading_date'","'$DownStartTime'","'$DownEndTime'","'$Reason'","'$multiplyingfactor'","'$EM'","'$DieselRec'","now()");
			//print_r($tableData);
			updateDataIntoTable($tableName,$tableColumns,$tableData);
			$Message = "$PageFor Updated";
		}
	}
	redirect("elec_list_dg_down_time.php?Message=$Message");
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
          <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add / Edit Diesel Generator Down Time</td>
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
	<td align="left"><b>Start Down Time</b></td>
    <td align="left"><? $HH = floor($DownStartTime / 60);
		$MM = ($DownStartTime % 60); ?>
	HH&nbsp;<select name="SHour" id="SHour">
    <? for($x=0; $x<=23; $x++){?>
    	<option <? if($HH == str_pad($x, 2, '0', STR_PAD_LEFT)){ echo 'selected="selected"';}?> value="<? echo str_pad($x, 2, '0', STR_PAD_LEFT);?>"><? echo str_pad($x, 2, '0', STR_PAD_LEFT);?></option>
	<? } ?>
    </select>
    MM&nbsp;<select name="SMin" id="SMin">
    <? for($y=0; $y<=59; $y++){?>
    	<option <? if($MM == str_pad($y, 2, '0', STR_PAD_LEFT)){ echo 'selected="selected"';}?> value="<? echo str_pad($y, 2, '0', STR_PAD_LEFT);?>" ><? echo str_pad($y, 2, '0', STR_PAD_LEFT);?></option>
	<? } ?>
    </select>
    	
	</td>
	<td align="left"><b>End Down Time</b></td>
    <td align="left"><? $HH = floor($DownEndTime / 60);
		$MM = ($DownEndTime % 60); ?>
	HH&nbsp;<select name="EHour" id="EHour">
    <? for($x=0; $x<=23; $x++){?>
    	<option <? if($HH == str_pad($x, 2, '0', STR_PAD_LEFT)){ echo 'selected="selected"';}?> value="<? echo str_pad($x, 2, '0', STR_PAD_LEFT);?>"><? echo str_pad($x, 2, '0', STR_PAD_LEFT);?></option>
	<? } ?>
    </select>
    MM&nbsp;<select name="EMin" id="EMin">
    <? for($y=0; $y<=59; $y++){?>
    	<option <? if($MM == str_pad($y, 2, '0', STR_PAD_LEFT)){ echo 'selected="selected"';}?> value="<? echo str_pad($y, 2, '0', STR_PAD_LEFT);?>"><? echo str_pad($y, 2, '0', STR_PAD_LEFT);?></option>
	<? } ?>
    </select>
    	
	</td>
</tr>
<tr>
	<td align="left"><b>Reason</b></td>
    <td align="left">
    	<textarea id="Reason" name="Reason" ><?=$Reason?></textarea>
	</td>
	<td align="left"><b>Multiplying Factor</b></td>
    <td align="left">
    	<input type="text" id="multiplyingfactor" name="multiplyingfactor" value="<?=$multiplyingfactor?>"  />
	</td>
</tr>
<tr>
    <td align="left"><b>KWH</b></td>
    <td align="left">
    	<input type="text" id="EM" name="EM" value="<?=$EM?>"  />
	</td>
	<td align="left"><b>Fuel Received</b></td>
    <td align="left">
    	<input type="text" id="DieselRec" name="DieselRec" value="<?=$DieselRec?>"  />
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