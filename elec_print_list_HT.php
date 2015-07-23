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
$ReadingDate='';
$ReadingRange='';
if($val!='')
{
	if(($_REQUEST['byControl'])=='ReadingDate')
	{
		$val=getDateFormate($val);
		$ReadingDate="reading_date ='".$val."'";
	}
	else if(($_REQUEST['byControl'])=='DateFromTo')
	{
		$val=explode(',',$val);
		$val1=getDateFormate($val[0]);$val2=getDateFormate($val[1]);
		$ReadingRange="reading_date >='".$val1."' and reading_date <='".$val2."'";
	}
}

$sql="select * from elec_HT where 
$ReadingDate
$ReadingRange
order by reading_date asc";
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
?> 
<?
	$factor=0;
	$sqlmf = "select * from elec_HT_MF";
	$resmf = mysql_query($sqlmf);
	$rowmf = mysql_fetch_array($resmf);
	$factor=(double)$rowmf['factor'];
?>
<?
	$demand=0;
	$sqlmd = "select * from elec_HT_max_demand";
	$resmd = mysql_query($sqlmd);
	$rowmd = mysql_fetch_array($resmd);
	$demand=(double)$rowmd['demand'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print High Tension Report</title>
<style>
.note
{
font: Arial, Helvetica, sans-serif;
font-size:13px;
font-weight:bold;
}
.particulars
{
font: Arial, Helvetica, sans-serif;
font-size:11px;
height:25px;
}
.tblborder
{
 border-collapse:collapse;border-color:1px solid #000;
}

</style>

</head>

<body onload="print();">
<div style="margin:0 auto;width:740px;padding:2px">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <thead>
      <tr height="70px">
        <td align="center">
          <b><u>MAHIMA PURESPUN</u></b><br />
          <b>HT REPORT</b>
					<? 
					if(($_POST['byControl'])=='ReadingDate')
					{
						?>
            ON <b><?=getDateFormate($val) ?></b>
          <?
					}
					else
					{
					?>
    				BETWEEN <b><?=getDateFormate($val1) ?></b> And <b><?=getDateFormate($val2)?></b>
          <?
					}
          ?>
        </td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
        	<table align="center" width="100%" border="1" class="tblborder">
            <tr class="note">
              <td align="center">S.No.</td>
              <td align="center">Reading Date</td>
              <td align="center">MWH Reading</td>
              <td align="center">MWH Unit</td>
              <td align="center">Comm. MWH Unit</td>
              <td align="center">MVAH Reading</td>
              <td align="center">MVAH Unit</td>
              <td align="center">Comm. MVAH Unit</td>
              <td align="center">Power Factor</td>
              <td align="center">Avg. P.F.</td>
            </tr>
            <?  
							if(mysql_num_rows($result)>0)
							{
								$sno =1;
								$mwh_unit=0;$mvah_unit=0;$total_pf=0;$total_lf=0;$total_avg_pf=0;$days=1;
								$mvah_unit_total=0;$mwh_unit_total=0;
								while($row=mysql_fetch_array($result))
								{
									$sql_idate="select * from elec_HT where insert_date='".date('Y-m-d')."' and HT_id='".$row['HT_id']."'";
									$res_idate=mysql_query($sql_idate);
									$row_idate=mysql_fetch_array($res_idate);
									$insert_date=$row_idate['insert_date'];
									$da=explode('-',$row['reading_date']);//$da=explode('-','2011-03-01');
									$early_date= date("Y-m-d", mktime(0, 0, 0,$da[1] ,$da[2]+1 , $da[0]));
									$sql_u="select * from elec_HT where reading_date ='".$early_date."'";
									$res_u=mysql_query($sql_u);		
									$early_mwh_reading=0;$early_mvah_reading=0;
									if(mysql_num_rows($res_u)>0)
									{
										$row_u=mysql_fetch_array($res_u);
										$early_mwh_reading=(double)$row_u['mwh_reading'];
										$early_mvah_reading=(double)$row_u['mvah_reading'];
									}
								?>
								<tr class="particulars">
									<td align="center"><?=$sno?></td>
									<td align="center"><?= getDateFormate($row['reading_date'])?></td>
									<td align="right" style="padding-right:2px"><?= $row['mwh_reading']?></td>
									<td align="right" style="padding-right:2px">
										<? 
											$mwh_unit=0;
											if(mysql_num_rows($res_u)>0)
											{
												$diff_mwh=$early_mwh_reading-(double)$row['mwh_reading'];
												$mwh_unit=$factor*$diff_mwh;
												echo $mwh_unit=number_format($mwh_unit, 0, '.', '');//$power_factor;;
											}
										?>
									</td>
									<td align="right" style="padding-right:2px"><?= $mwh_unit_total+=$mwh_unit?></td> 
									<td align="right" style="padding-right:2px"><?= $row['mvah_reading']?></td>
									<td align="right" style="padding-right:2px">
										<?
											$mvah_unit=0;
											if(mysql_num_rows($res_u)>0)
											{
												$diff_mvah=$early_mvah_reading-(double)$row['mvah_reading'];
												$mvah_unit=$factor*$diff_mvah;
												echo $mvah_unit=number_format($mvah_unit, 0, '.', '');//$power_factor;;
											}
										?>
									</td>
									<td align="right" style="padding-right:2px"><?= $mvah_unit_total+=$mvah_unit?></td>
									<td align="right" style="padding-right:2px">
									<?
										$power_factor=0;
										if($mvah_unit=='' || $mvah_unit=='0')
											$power_factor=0;
										else
											$power_factor=$mwh_unit/$mvah_unit;
										echo $power_factor=number_format($power_factor, 3, '.', '');
										//$power_factor;
										$total_pf+=$power_factor;
									?>
									</td>
									<td align="right" style="padding-right:2px">
										<?
											$avg_pf=0;
											if($mvah_unit_total=='' || $mvah_unit_total=='0')
												$avg_pf=0;
											else
												$avg_pf=$mwh_unit_total/$mvah_unit_total;
											echo $avg_pf=number_format($avg_pf, 3, '.', '');
											$total_avg_pf+=$avg_pf;
										?>
									</td>
								</tr>
								<?
										//echo $mwh_unit_total.','.$demand.','.$avg_pf.','.$days.',';
										if($avg_pf=='' || $avg_pf==0)
											$load_factor=0;
										else
											$load_factor=($mwh_unit_total*100)/($demand*0.9*24*(int)$days);
										$load_factor=number_format($load_factor, 3, '.', '');
										$total_lf+=$load_factor;
										$sno++;$days++;
								 }	
							?> 
							<tr>
								<td colspan="2" align="right"><b>Total</b>&nbsp;&nbsp;&nbsp;</td>
								<td align="right" style="padding-right:2px" colspan="6">
								<b>Load Factor</b>&nbsp;&nbsp;&nbsp;
								<? $lf=$total_lf/($days-1);echo number_format($lf,2,'.','');?>
								</td>
								<td align="right" colspan="2"></td>
							</tr>
							<?
							}    
							else
							{
								?>
								<tr>
									<td colspan="10" align="center" style="font-weight:bold">No Records Found</td>
								</tr>
								<?
							}
							?>
          </table>      
        </td>
      </tr>
    </tbody>
  </table>
</div>
</body>
</html>
