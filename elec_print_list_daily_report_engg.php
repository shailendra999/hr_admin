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


$sql_count = "select count(*) as count from elec_daily_report_engg
where 
$ReadingRange
order by DailyReportDate asc";
$result_count = mysql_query($sql_count) or die ("Invalid query : ".$sql_count."<br>".mysql_errno()." : ".mysql_error());
$row_count = mysql_fetch_array($result_count);
$numrows = $row_count['count'];
$no_of_rec_show=1;
$count = ceil($numrows/$no_of_rec_show);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Daily Report</title>
<style>
.note
{
font: Arial, Helvetica, sans-serif;
font-size:22px;
font-weight:bold;
}
.particulars
{
font: Arial, Helvetica, sans-serif;
font-size:20px;
color:#222222;
height:35px;
}
.tblborder
{
 border-collapse:collapse;border-color:1px solid #000;
}
.borderTop
{
	border-top:1px solid #000;
}
.borderBottom
{
	border-bottom:1px solid #000;
}
.borderRight
{
	border-right:1px solid #000;
}
.padding_left
{
	padding-left:15px;
}
.break { page-break-before: always; }
</style>
</head>

<body onload="print();">
<? 
	for($i=0,$countTrans=1;$i<$count;$i++)
	{
	?>
    <div style="width:740px;margin:0 auto;font:Arial, Helvetica, sans-serif;border:1px solid #000">
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      	<thead> 
          <tr height="70px">
          	<td align="center">
              <b><u>MAHIMA PURESPUN</u></b><br />
              <b>DAILY REPORT ENGINEERING </b>
              <?
							if($val1==$val2)
								echo 'On <b>'.getDateFormate($val1).'</b>';
							else
								echo 'Between <b>'.getDateFormate($val1).'</b> And <b>'.getDateFormate($val2).'</b>';
              ?>
          	</td>
      		</tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <table align="center" width="100%" border="0" cellspacing="0" cellpadding="2" class="tblborder">
                 <tr class="borderBottom borderTop note">
                  <td align="center" class="borderRight" width="10%">S.No.</td>
                  <td align="center" class="borderRight" colspan="2" width="40%">Particulars</td>
                  <td align="center" width="50%">Value</td>
                </tr>
                <?
                //$sql_order_trans="SELECT * FROM ms_indent_master mom, ms_indent_transaction mot WHERE mom.indent_id = mot.indent_id AND mom.indent_id ='".$PageKeyValue."'";
                //$res_order_trans=mysql_query($sql_order_trans);
                //$rc_trans=mysql_num_rows($res_order_trans);
                if(mysql_num_rows($result)>0)
                {
									$sno=1;$snoDetantion=1;
									$j=$i*$no_of_rec_show;
									mysql_data_seek($result,$j);
									$k=0;
                  while($row=mysql_fetch_array($result))
                  {
                  ?>
                  <tr class="particulars borderBottom">
                  	<td align="center" colspan="4"><b>Date : <u><?= getDateFormate($row['DailyReportDate'])?></u></b></td>
                  </tr>
                  <tr class="particulars" valign="top">
                    <td align="center"><?=$sno++?></td>
                    <td align="left"><b>Unit Consumption</b></td>
                    <td><b>:</b></td>
                    <td align="left" class="padding_left"><?= $row['UnitConsumption']?></td>
                  </tr>
                  <tr class="particulars" valign="top">
                  	<td align="center"><?=$sno++?></td>
                    <td align="left"><b>Max Demand</b></td><td><b>:</b></td>
                    <td align="left" class="padding_left"><?= $row['MaxDemand']?></td>
                  </tr>
                  <tr class="particulars" valign="top">
                  	<td align="center"><?=$sno++?></td>
                    <td align="left"><b>Load Factor</b></td><td><b>:</b></td>
                    <td align="left" class="padding_left"><?= $row['LoadFactor']?></td>
                  </tr>
                  <tr class="particulars" valign="top">
                  	<td align="center"><?=$sno++?></td>
                    <td align="left"><b>Power Factor</b></td><td><b>:</b></td>
                    <td align="left" class="padding_left"><?= $row['PowerFactor']?></td>
                  </tr>
                  <tr class="particulars" valign="top">
                  	<td align="center"><?=$sno++?></td>
                    <td align="left"><b>Lighting Unit</b></td><td><b>:</b></td>
                    <td align="left" class="padding_left"><?= $row['LightingUnit']?></td>
                  </tr>
                  <tr class="particulars" valign="top">
                  	<td align="center"><?=$sno++?></td>
                    <td align="left"><b>Colony Unit</b></td><td><b>:</b></td>
                    <td align="left" class="padding_left"><?= $row['ColonyUnit']?></td>
                  </tr>
                  <tr class="particulars" valign="top">
                  	<td align="center"><?=$sno++?></td>
                    <td align="left"><b>T. F. O.</b></td><td><b>:</b></td>
                    <td align="left" class="padding_left"><?= $row['TFO']?></td>
                  </tr>
                  <tr class="particulars" valign="top">
                  	<td align="center"><?=$sno++?></td>
                    <td align="left"><b>Compressor Unit</b></td><td><b>:</b></td>
                    <td align="left" class="padding_left"><?= $row['CompressorUnit']?></td>
                  </tr>
                  <tr>
                  	<td colspan="4" align="center" style="font-size:24px"><b><u>Machine Detantion</u></b></td>
                  </tr>
                  <tr class="particulars" valign="top">
                  	<td align="center"><?=$snoDetantion++?></td>
                    <td align="left"><b>Blow Room</b></td><td><b>:</b></td>
                    <td align="left" class="padding_left">
										<?
										 $BlowRoom=explode("\r\n",$row['BlowRoom']);
										 foreach($BlowRoom as $br)
										 {
										 	if($br!='')
										 		echo $br.'<br />';
										 }
										?>
                    </td>
                  </tr>
                  <tr class="particulars" valign="top">
                  	<td align="center"><?=$snoDetantion++?></td>
                    <td align="left"><b>Preparatory</b></td><td><b>:</b></td>
                    <td align="left" class="padding_left">
										<?
										 $Preparatory=explode("\r\n",$row['Preparatory']);
										 foreach($Preparatory as $pp)
										 {
										 	if($pp!='')
											 	echo $pp.'<br />';
										 }
										?>
                    </td>
                  </tr>
                  <tr class="particulars" valign="top">
                  	<td align="center"><?=$snoDetantion++?></td>
                    <td align="left"><b>Ring Frame</b></td><td><b>:</b></td>
                    <td align="left" class="padding_left"><?
										 $RingFrame=explode("\r\n",$row['RingFrame']);
										 foreach($RingFrame as $rf)
										 {
										 	if($rf!='')
										 		echo $rf.'<br />';
										 }
										?>
                    </td>
                  </tr>
                  <tr class="particulars" valign="top">
                  	<td align="center"><?=$snoDetantion++?></td>
                    <td align="left"><b>AutoCorner</b></td><td><b>:</b></td>
                    <td align="left" class="padding_left"><?
										 $AutoCorner=explode("\r\n",$row['AutoCorner']);
										 foreach($AutoCorner as $ac)
										 {
											 if($ac!='')
												echo $ac.'<br />';
										 }
										?>
                    </td>
                  </tr>
                  <tr class="particulars" valign="top">
                  	<td align="center"><?=$snoDetantion++?></td>
                    <td align="left"><b>Progress Report</b></td><td><b>:</b></td>
                    <td align="left" class="padding_left">
										<?
										 $ProgressReport=explode("\r\n",$row['ProgressReport']);
										 foreach($ProgressReport as $pr)
										 {
										 	if($pr!='')
										 		echo $pr.'<br />';
										 }
										?>
                    </td>
                  </tr>
                    <? //= getDateFormate($row['DailyReportDate'])?>
                    
                    
                  <?
                  if($k==($no_of_rec_show-1))
                  {
                    break;
                  }
                  $k++;
                }
              }
							?>
              </table>
            </td>
          </tr>
        </tbody>
        <tfoot>
        	<tr height="80px" valign="middle">
          	<td style="padding-left:25px" align="left">
            	<b>SR.ENGINEER<br/>(ENGINEERING)</b>
            </td>
          </tr>
        </tfoot>
			</table>
  	 </div>
		<p class="break"></p>
   <?
   	}
   ?>
</body>
</html>
