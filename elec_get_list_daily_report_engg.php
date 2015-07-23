<?
include("inc/check_session.php");
include("inc/dbconnection.php");
include("inc/common_function_mt_elect.php");

if(isset($_REQUEST['value']))
{
	$val=$_REQUEST['value'];
}
else
	$val='';
$Department='';
$ReadingDate='';
$ReadingRange='';
if($val!='')
{
	
	$val=explode(',',$val);
	
		
	if(($_REQUEST['byControl'])=='DateFromTo')
	{
		$val1=getDateFormate($val[0]);$val2=getDateFormate($val[1]);
		$ReadingRange=" DailyReportDate BETWEEN '".$val1."' and '".$val2."'";
	}
}

$sql="select * from elec_daily_report_engg
where 
$ReadingRange
order by DailyReportDate asc";
//echo $sql;
//$sql = $sql ." LIMIT " . $start . ", $row_limit";
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
$sum=0;
?> 
<div class="AddMore" style="padding-top:10px">
	<form action="elec_print_list_daily_report_engg.php" name="test" id="test" method="post" target="_blank"> 
    <input type="hidden" name="value" id="value" value="<?=$_REQUEST['value'] ?>" />
    <input type="hidden" name="byControl" id="byControl" value="<?=$_REQUEST['byControl'] ?>" />
    <a href="#" onclick="test.submit();">Print&nbsp;&nbsp;&nbsp;</a>
 	</form>
</div>
<table align="center" id="tableEntry" width="100%" border="1" class="table1 text_1">
    <tr>
      <td class="gredBg">S.No.</td>
      <td class="gredBg">DailyReportId</td>
      <td class="gredBg">DailyReportDate</td>
      <td class="gredBg">UnitConsumption</td>
      <td class="gredBg">MaxDemand</td>
      <td class="gredBg">LoadFactor</td>
      <td class="gredBg">PowerFactor</td>
      <td class="gredBg">LightingUnit</td>
      <td class="gredBg">ColonyUnit</td>
      <td class="gredBg">T. F. O.</td>
      <td class="gredBg">CompressorUnit</td>
      <td width="4%" class="gredBg">Edit</td>
      <td width="4%" class="gredBg">Delete</td>
    </tr>
    <?
	if(mysql_num_rows($result)>0)
	{
		$sno=1;
		while($row=mysql_fetch_array($result))
		{	
		$sql_idate="select * from elec_daily_report_engg where InsertDate='".date('Y-m-d')."' and DailyReportId='".$row['DailyReportId']."'";
		$res_idate=mysql_query($sql_idate);
		$row_idate=mysql_fetch_array($res_idate);
		$insert_date=$row_idate['InsertDate'];
		?>
		<tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
		<td align="center"><?=$sno?></td>
		<td align="center"><?= $row['DailyReportId']?></td>
		<td align="center"><?= getDateFormate($row['DailyReportDate'])?></td>
		<td align="center"><?= $row['UnitConsumption']?></td>
		<td align="center"><?= $row['MaxDemand']?></td>
		<td align="center"><?= $row['LoadFactor']?></td>
		<td align="center"><?= $row['PowerFactor']?></td>
		<td align="center"><?= $row['LightingUnit']?></td>
		<td align="center"><?= $row['ColonyUnit']?></td>
        <td align="center"><?= $row['TFO']?></td>
		<td align="center"><?= $row['CompressorUnit']?></td>
		<?
		if(1)
		{
			//$SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date)
		?>
		  <td align="center">
			<a href="elec_add_daily_report_engg.php?DailyReportId=<?=$row["DailyReportId"]?>&mode=edit">
			  <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
			</a>
		  </td>
		  <td align="center">
			<a href="javascript:;" onClick="overlay(<?=$row["DailyReportId"]?>);">
			  <img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0">
			</a>
		  </td>
			<?
			}
			else
			{
			?>
				<td align="center"></td>
				<td align="center"></td>
			<?
			}
			?>
		</tr>
		<?
		   $sno++;
		  }	
	}
	else
	{
		?>
        <tr>
        	<td colspan="12" align="center"><b>No Records Found</b></td>
        </tr>
        <?
	}
    ?>         
</table>