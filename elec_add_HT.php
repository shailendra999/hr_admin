<?
include("inc/elec_header.php");
?>
<?
$Page = "elec_add_HT.php";
$PageTitle = "Add High Tension";
$PageFor = "High Tension";
$PageKey = "HT_id";
$PageKeyValue = "";
$Message = "";
$mode = "";
$HT_id = "";$department_code = "";$reading = "";$reading_date = "";$mwh_reading ="";$mvah_reading ="";
if(isset($_GET["mode"])){
	$mode = $_GET["mode"];
	$sql_idate="select * from elec_HT where insert_date='".date('Y-m-d')."' and $PageKey='".$_GET[$PageKey]."'";
	$res_idate=mysql_query($sql_idate);
	/*if(mysql_num_rows($res_idate)==0 && !($SessionUserType=='Administrator'))
	{
		echo "<script>alert('You Cant Update Here');location.href='elec_homepage.php';</script>";
	}*/
}

if(isset($_GET[$PageKey])){
	$sql = "select * from elec_HT where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0){
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];$HT_id = $row['HT_id'];
		$mwh_reading = $row["mwh_reading"];
		$mvah_reading = $row["mvah_reading"];
		$kva_reading = $row["kva_reading"];
		$reading_date = getDateFormate($row["reading_date"]);
	}
}else if(!isset($_GET[$PageKey])){
	$sql="select max(HT_id) as HT_id from elec_HT";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$HT_id=($row['HT_id']+1);
	
}

if(isset($_POST["btn_submit"])){
	echo $PageKeyValue = $_POST[$PageKey];
	$mwh_reading = $_POST["mwh_reading"];
	$mvah_reading = $_POST["mvah_reading"];
	$kva_reading = $_POST["kva_reading"];
	$reading_date = getDateFormate($_POST["reading_date"]);	
	
	if($PageKeyValue == ""){
		$tableName="elec_HT";
		$tableData=array("''","'$mwh_reading'","'$mvah_reading'","'$kva_reading'","'$reading_date'","now()");
		print_r($tableData);
	  addDataIntoTable($tableName,$tableData);
		$Message = "$PageFor Inserted";
		redirect("$Page?Message=$Message");
	}else{
		if($mode == "edit"){
			$tableName="elec_HT";
			$tableColumns=array("HT_id","mwh_reading","mvah_reading","kva_reading","reading_date");
			$tableData=array("'$PageKeyValue'","'$mwh_reading'","'$mvah_reading'","'$kva_reading'","'$reading_date'");
			//print_r($tableData);
		  updateDataIntoTable($tableName,$tableColumns,$tableData);
			$Message = "$PageFor Updated";
		}
	}
	redirect("elec_list_HT.php?Message=$Message");
}
?>
<?
if(isset($_GET["Message"]))
{
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
          <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add/Edit High Tension</td>
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
                        <table align="center" width="50%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                          <tr>
                            <td align="left"><b>Sno. No</b></td>
                            <td align="left">
                              <input type="text" readonly="readonly" id="Sno" name="Sno" value="<?= $HT_id ?>"  />
                            </td>
                          </tr>
                          <tr>
                            <td align="left"><b>MWH Reading</b></td>
                            <td align="left">
                              <input type="text" id="mwh_reading" name="mwh_reading" value="<?= $mwh_reading ?>"  />
                            </td>
                          </tr>
                          <tr>
                            <td align="left"><b>MVAH Reading</b></td>
                            <td align="left">
                              <input type="text" id="mvah_reading" name="mvah_reading" value="<?= $mvah_reading ?>"  />
                            </td>
                          </tr>
                          <tr>
                            <td align="left"><b>KVA Reading</b></td>
                            <td align="left">
                              <input type="text" id="kva_reading" name="kva_reading" value="<?= $kva_reading ?>"  />
                            </td>
                          </tr>
                          <tr>
                            <td align="left"><b>Reading Date</b></td>
                            <td align="left">
                              <input type="text" id="reading_date" name="reading_date" value="<?= $reading_date ?>"  />
                               <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.reading_date);return false;" HIDEFOCUS>
                               	<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                               </a> 
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
   
<? 
include("inc/hr_footer.php");
?>