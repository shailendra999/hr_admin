<? include("inc/elec_header.php"); ?>
<script>
function overlay(id) {
    el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";	
}
</script>

<?
$Page = "elec_list_dg_reading.php";
$PageTitle = "List Diesel Generator Reading";
$PageFor = "Diesel Generator Reading";
$PageKey = "DG_reading_id";
$PageKeyValue = "";
$Message = "";
$whereCondition = "";
$to_date = "";
$form_date = "";

$DG_reading_id = "";$DG_id = "";$reading_date = "";


if(isset($_GET["Message"])){
	$Message = $_GET["Message"];
}
if(isset($_POST["btn_del"])){
	$PageKeyValue  = $_POST["hidden_overlay"];
	$sql = "delete from elec_DG_reading where $PageKey = '".$PageKeyValue."'";
	if(mysql_query ($sql)){
		$Message = "Record Sucessfully Deleted";
	}
	//$Message = "Order Sucessfully Deleted";
	redirect("$Page?Message=$Message");
}


if(isset($_POST['btn_submit'])){
	if($_POST['DG_reading_id'] != ''){
		$whereCondition .= "DG_reading_id = '".$_POST['DG_reading_id']."' and ";
	}
	if($_POST['reading_date'] != ''){
		$whereCondition .= "ReadingDate = '".getDateFormate($_POST['reading_date'])."' and ";
	}
	if($_POST['form_date'] != ''){
		if($_POST['to_date'] == ''){
			$toDate = date('d-m-Y');
		}else{
			$toDate = $_POST['to_date'];
		}
		$whereCondition .= "ReadingDate between '".getDateFormate($_POST['form_date'])."' and '".getDateFormate($toDate)."' and ";
	}
	if($_POST['DG_id'] != ''){
		$whereCondition .= "DG_id = '".$_POST['DG_id']."' and";
	}
}
$sql="select * from elec_DG_reading where $whereCondition DG_reading_id <> '' order by ReadingDate asc";
$result=mysql_query($sql);

?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
    <? include ("inc/elec_snb.php"); ?>
    </td>
    <td style="padding-left:5px; padding-top:5px;" valign="top">
      <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td align="center" class="gray_bg">
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; List Energy Consumption
          </td>
        </tr>
        <tr>
          <td valign="top">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td align="center" class="border" >
                	<div id="div_message" style="color:#399;font-size:16px;font-weight:bold;"><?=$Message?></div>
<form action="" name="search" method="post">
<table align="center" width="100%" cellpadding="2" cellspacing="2" border="1" class="text_1">
<tr>
	<td align="left"><b>DG Entry Id</b></td>
    <td align="left"><input type="text" id="DG_reading_id" name="DG_reading_id" value="<?=$DG_reading_id?>" autocomplete="off" /></td>
	<td align="left"><b>Reading Date</b></td>
    <td align="left">
    	<input type="text" id="reading_date" name="reading_date" value="<?=$reading_date?>"  />
		<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.search.reading_date);return false;" HIDEFOCUS>
    		<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
		</a> 
	</td>
	<td align="left"><b>DGNo.</b></td>
    <td align="left">
		<? $sql_D= "select * from elec_DG_master order by DG_name";
        $res_D = mysql_query ($sql_D) or die (mysql_error()); ?>
        <select name="DG_id" id="DG_id" style="width:160px;">
        <option value=""></option>
        <? if(mysql_num_rows($res_D)>0){
            while($row_D = mysql_fetch_array($res_D)){ ?>
        <option value="<?= $row_D['DG_id']; ?>" <? if($row_D['DG_id']==$DG_id){ ?> selected="selected"<? }?> ><?= $row_D['DG_name']; ?></option>
        <? }
        } ?>
        </select>
	</td>
</tr>                           
<tr height="30px">

    <td align="left"><b>Form Date</b></td>
    <td align="left">
    	<input type="text" id="form_date" name="form_date" value="<?=$form_date?>"  />
		<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.search.form_date);return false;" HIDEFOCUS>
    		<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
		</a> 
	</td>
    <td align="left"><b>To Date</b></td>
    <td align="left">
    	<input type="text" id="to_date" name="to_date" value="<?=$to_date?>"  />
		<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.search.to_date);return false;" HIDEFOCUS>
    		<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
		</a> 
	</td>
	<td align="center" colspan="2" style="padding-top:10px"><input type="submit" id="btn_submit" name="btn_submit" value="Search" class="btn_bg" /></td>
</tr>
</table>
</form>                  
					<div id="getDataInDiv" style="margin:0 auto;width:100%;overflow:auto;height:600px">
                    <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="tableborder">
                      <tr>
                        <td valign="top">	
                            <table align="center" id="tableEntry" width="100%" border="1" class="table1 text_1">
                              <tr>
                                <td class="gredBg" width="4%">S.No.</td>
                                <td class="gredBg" width="15%">DG Reading No.</td>
                                <td class="gredBg" width="20%">DG Name</td>
                                <td class="gredBg" width="10%">Reading Date</td>
                                <td class="gredBg" width="8%">Running Hours</td>
                                <td class="gredBg" width="8%">Running Hours Diffrence</td>
                                <td class="gredBg" width="10%">Oil Temp (&deg;C)</td>
                                <td class="gredBg" width="10%">Diesel Level (Ltr)</td>
                                <td class="gredBg" width="10%">KWH</td>
                                <td class="gredBg" width="10%">Unit</td>
                                <td width="5%" class="gredBg">Edit</td>
                                <td width="5%" class="gredBg">Delete</td>
                              </tr>
<? if(mysql_num_rows($result)>0){
	$sno =1;$n=1;
	while($row=mysql_fetch_array($result)){
		$n=1;
		$sql_previousReading="select * from elec_DG_reading where ReadingDate < '".$row['ReadingDate']."' and DG_id='".$row['DG_id']."' limit 1";
		$res_previousReading=mysql_query($sql_previousReading);
		$row_previousReading=mysql_fetch_array($res_previousReading);
		$previousRading = $row_previousReading['KWH'].'<br />';

	?>
                                <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                                  <td align="center"><?=$sno?></td>
                                  <td align="center"><?=$row['DG_reading_id']?></td>
                                  <td align="left" style="padding-left:2px">
	  <? $sql_dep = "select * from elec_DG_master where DG_id = '".$row['DG_id']."' ";
	  $res_dep = mysql_query($sql_dep) or die ("Invalid query : ".$sql_dep."<br>".mysql_errno().":".mysql_error());
	  $row_dep = mysql_fetch_array($res_dep);
	  echo $row_dep['DG_name']; ?>	
                                  </td>
                                  <td align="left" style="padding-left:2px"><?=getDateFormate($row['ReadingDate'])?></td>
                                  <td align="center"><?=$row['RunningHours']?></td>
<? $da=explode('-',$row['ReadingDate']);//$da=explode('-','2011-03-01');
	$early_date= date("Y-m-d", mktime(0, 0, 0,$da[1] ,$da[2]-1 , $da[0]));
	$sql_u="select RunningHours from elec_DG_reading where ReadingDate ='".$early_date."'";
	$res_u = mysql_query($sql_u);
	if(mysql_num_rows($res_u) > 0){
		$row_u = mysql_fetch_array($res_u);
		$diff = $row['RunningHours'] - $row_u['RunningHours'];
    }else{
		$diff = 0;
	}?>
                                  <td align="center"><?=$diff?></td>
                                  <td align="center"><?=$row['OilTemp']?></td>
                                  <td align="center"><?=$row['DieselLevel']?></td>
                                  <td align="right" style="padding-right:2px"><?=$row['KWH']?></td>
                                  <td align="center"><?=($row['KWH'] - $previousRading)?></td>
              <? if(1){ //$SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date) ?>
                <td align="center">
                  <a href="elec_add_dg_reading.php?DG_reading_id=<?=$row["DG_reading_id"]?>&mode=edit">
                    <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
                  </a>
                </td>
                <td align="center">
                  <a href="javascript:;" onClick="overlay(<?=$row["DG_reading_id"]?>);">
                    <img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0">
                  </a>
                </td>
              <? }else{ ?>
                <td align="center"></td>
                <td align="center"></td>
              <? } ?>
            </tr>
              <? $sno++;
              }	
          }else{ ?>
            <tr><td align="center" colspan="12"><b>No Records Found</b></td></tr>
          <?  } ?>  
                            </table>
                      	</td>
                   		</tr>
                 		</table>
                	</div>
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
<div id="overlay">
   <div class="form_msg">
      <p>Are you sure to delete this Item</p>
      <form name="frm_del" action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
        <input type="submit" name="btn_del" value="Yes" />
        <input type="button" onClick="overlay();" name="btn_close" value="No" />
      </form>
   </div>
</div>
<? include("inc/hr_footer.php"); ?>