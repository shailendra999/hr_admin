<? include("inc/elec_header.php"); ?>
<script>
function overlay(id) {
    el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";	
}
</script>
<?
$Page = "elec_list_dg_down_time.php";
$PageTitle = "List Diesel Generator  Down Time";
$PageFor = "Diesel Generator Down Time";
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
	$sql = "delete from elec_DG_down_time where $PageKey = '".$PageKeyValue."'";
	if(mysql_query ($sql)){
		$Message = "Record Sucessfully Deleted";
	}
	//$Message = "Order Sucessfully Deleted";
	redirect("$Page?Message=$Message");
}
if(isset($_POST['btn_submit'])){
	$DG_id = $_POST['DG_id'];
	$reading_date = $_POST['reading_date'];
	$form_date = $_POST['form_date'];
	$to_date = $_POST['to_date'];
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
$sql="select * from elec_DG_down_time where $whereCondition DG_down_time_id <> '' order by ReadingDate asc";
$result=mysql_query($sql); ?>
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
	<td align="left"><b>Reading Date</b></td>
    <td align="left">
    	<input type="text" id="reading_date" name="reading_date" value="<?=$reading_date?>"  />
		<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.search.reading_date);return false;" HIDEFOCUS>
    		<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
		</a> 
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
</tr>
<tr><td align="center" colspan="4" style="padding-top:10px"><input type="submit" id="btn_submit" name="btn_submit" value="Search" class="btn_bg" /></td></tr>
</table>
</form>                  
					<div id="getDataInDiv" style="margin:0 auto;width:100%;overflow:auto;height:600px">
<div class="AddMore">
<form action="elec_print_list_dg_down_time.php" name="test" id="test" method="post" target="_blank">
	<input type="hidden" name="DG_id" id="DG_id" value="<?=$DG_id;?>"  />
	<input type="hidden" name="reading_date" id="reading_date" value="<?=$reading_date;?>"  />
	<input type="hidden" name="form_date" id="form_date" value="<?=$form_date;?>"  />
	<input type="hidden" name="to_date" id="to_date" value="<?=$to_date;?>"  />
    <a href="#" onclick="test.submit();">Print&nbsp;&nbsp;&nbsp;</a>
</form>
</div> 
                    <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="tableborder">
                      <tr>
                        <td valign="top">	
                            <table align="center" id="tableEntry" width="100%" border="1" class="table1 text_1">
                              <tr>
                                <td class="gredBg" width="4%">S.No.</td>
                                <td class="gredBg" width="20%">DG Name</td>
                                <td class="gredBg" width="20%">Reading Date</td>
                                <td class="gredBg" width="10%">Start Down Time</td>
                                <td class="gredBg" width="8%">End Down Time</td>
                                <td class="gredBg" width="8%">Total Down Time</td>
                                <td class="gredBg" width="10%">Reason</td>
                                <td class="gredBg" width="10%">EM</td>
                                <td class="gredBg" width="10%">M / F</td>
                                <td class="gredBg" width="10%">DieselRec</td>
                                <td width="5%" class="gredBg">Edit</td>
                                <td width="5%" class="gredBg">Delete</td>
                              </tr>
<? if(mysql_num_rows($result)>0){
	$sno =1;$n=1;
	while($row=mysql_fetch_array($result)){
		$n=1;
#		$sql_previousReading="select * from elec_DG_down_time where ReadingDate < '".$row['ReadingDate']."' and DG_id='".$row['DG_id']."' limit 1";
#		$res_previousReading = mysql_query($sql_previousReading);
#		$row_previousReading = mysql_fetch_array($res_previousReading);
#		$previousRading = $row_previousReading['KWH'].'<br />';
?>
                                <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                                  <td align="center"><?=$sno?></td>
                                  <td align="left" style="padding-left:2px">
	  <? $sql_dep = "select * from elec_DG_master where DG_id = '".$row['DG_id']."' ";
	  $res_dep = mysql_query($sql_dep) or die ("Invalid query : ".$sql_dep."<br>".mysql_errno().":".mysql_error());
	  $row_dep = mysql_fetch_array($res_dep);
	  echo $row_dep['DG_name']; ?>	
                                  </td>
                                  <td align="left" style="padding-left:2px"><?=getDateFormate($row['ReadingDate'])?></td>
                                  <td align="center"><? $HH = floor($row['DownStartTime'] / 60);
								  $MM = ($row['DownStartTime'] % 60);
								  echo str_pad($HH, 2, '0', STR_PAD_LEFT).':'. str_pad($MM, 2, '0', STR_PAD_LEFT);
								  ?></td>
                                  <td align="center"><?  $HH = floor($row['DownEndTime'] / 60);
								  $MM = ($row['DownEndTime'] % 60);
								  echo str_pad($HH, 2, '0', STR_PAD_LEFT).':'. str_pad($MM, 2, '0', STR_PAD_LEFT);?></td>
                                  <td align="center"><?
								  $diff = $row['DownEndTime'] - $row['DownStartTime'];
								  if($diff < 60){
									  echo $diff.' Min';
								  }else{
									  $h = floor($diff / 60);
									  if($h > 24){
										  $d = floor($h / 24);
										  $h = floor($h % 24);
										  echo $d.' Days<br />'; 
										  echo $h.' Hours<br />'; 
									  }else{
										  echo $h.' Hour<br />';
									  }
									  echo ($diff % 60).' Min';
								  } ?></td>
                                  <td align="center"><?=$row['Reason']?></td>
                                  <td align="right" style="padding-right:2px"><?=$row['EM']?></td>
                                  <td align="right" style="padding-right:2px"><?=$row['multiplyingfactor']*$row['EM']?></td>
                                  <td align="center"><?=$row['DieselRec']?></td>
              <? if(1){ //$SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date) ?>
                <td align="center">
                  <a href="elec_add_dg_down_time.php?DG_down_time_id=<?=$row["DG_down_time_id"]?>&mode=edit">
                    <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
                  </a>
                </td>
                <td align="center">
                  <a href="javascript:;" onClick="overlay(<?=$row["DG_down_time_id"]?>);">
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