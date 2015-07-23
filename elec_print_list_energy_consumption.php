<?
include("inc/check_session.php");
include("inc/dbconnection.php");
include("inc/common_function_mt_elect.php");

if(isset($_REQUEST['str']))
{
	$val=$_REQUEST['str'];
}
else
	$val='';
$MachineName='';
$All='';
if($val!='')
{
	if(($_REQUEST['byControl'])=='MachineName')
	{
		$MachineName=" machine_name_number like '".$val."%' ";
	}
	else if(($_REQUEST['byControl'])=='DateFromTo')
	{
		$val=explode(',',$val);
		$val1=$val[0];$val2=$val[1];
		$val3=getDateFormate($val[2]);$val4=getDateFormate($val[3]);
		$All="department_id=$val1 and machine_name_number ='".$val2."' and reading_date  BETWEEN '".$val3."' AND '".$val4."'";
	}
}
$sql="select * from elec_energy_consumption where 
$MachineName
$All
order by reading_date asc";
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
?> 
<?
	$factor=0;
	$sqlmf = "select * from elec_EnergyCons_MF";
	$resmf = mysql_query($sqlmf);
	$rowmf = mysql_fetch_array($resmf);
	$factor=(double)$rowmf['factor'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Energy Consumption Report</title>
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
          <b>ENERGY CONSUMPTION REPORT</b>
        </td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
        	<?
						$factor=0;
						$sqlmf = "select * from elec_EnergyCons_MF";
						$resmf = mysql_query($sqlmf);
						$rowmf = mysql_fetch_array($resmf);
						$factor=(double)$rowmf['factor'];
					?>
					<table align="center" width="100%" border="1" class="tblborder">
            <tr class="note">
              <td align="center" width="6%">S.No.</td>
              <td align="center" width="25%">Department</td>
              <td align="center" width="25%">Machine</td>
              <td align="center" width="8%">Time</td>
              <td align="center" width="8%">Hrs Reading</td>
              <td align="center" width="8%">Reading</td>
              <td align="center" width="10%">Unit Cons/Hrs.</td>
              <td align="center" width="10%">Reading Date</td>
            </tr>
            <?  
            if(mysql_num_rows($result)>0)
            {
              $sno =1;$n=1;
              while($row=mysql_fetch_array($result))
              {	
                $n=1;
                $sql_idate="select * from elec_energy_consumption where insert_date='".date('Y-m-d')."' and EC_id='".$row['EC_id']."'";
                $res_idate=mysql_query($sql_idate);
                $row_idate=mysql_fetch_array($res_idate);
                $insert_date=$row_idate['insert_date'];
                
                $da=explode('-',$row['reading_date']);//$da=explode('-','2011-03-01');
                $early_date= date("Y-m-d", mktime(0, 0, 0,$da[1] ,$da[2]+1 , $da[0]));
                $sql_u="select * from elec_energy_consumption where reading_date ='".$early_date."'";
                $res_u=mysql_query($sql_u);		
                $early_reading=0;$early_hr_reading=0;
                if(mysql_num_rows($res_u)>0)
                {
                  $row_u=mysql_fetch_array($res_u);
                  $early_reading=(double)$row_u['reading'];
                  $early_hr_reading=(double)$row_u['hour_meter_reading'];$n=1;
                }
                else
                {
                  $sql_u="select * from elec_energy_consumption where reading_date ='".$row['reading_date']."' limit 1,$n";
                  $res_u=mysql_query($sql_u);		
                  if(mysql_num_rows($res_u)>0)
                  {
                    $row_u=mysql_fetch_array($res_u);
                    $early_reading=(double)$row_u['reading'];
                    $early_hr_reading=(double)$row_u['hour_meter_reading'];
                    $n++;
                  }
                }
              ?>
              <tr class="particulars">
                <td align="center"><?=$sno?></td>
                <td align="left" style="padding-left:2px">
                <?
                  $sql_dep = "select * from elec_department where department_id = '".$row['department_id']."' ";
                  $res_dep = mysql_query($sql_dep) or die ("Invalid query : ".$sql_dep."<br>".mysql_errno().":".mysql_error());
                  $row_dep = mysql_fetch_array($res_dep);
                  echo $row_dep['name'];
                ?>	
                </td>
                <td align="left" style="padding-left:2px">
                  <?=$row['machine_name_number']?>
                </td>
                <td align="center"><?= $row['time']?></td>
                <td align="center"><?= $row['hour_meter_reading']?></td>
                <td align="center"><?= $row['reading']?></td>
                <td align="right" style="padding-right:2px">
                <?
                  if($early_reading>=$row['reading'])
                  {
                    $diff=$early_hr_reading-$row['hour_meter_reading'];
                    if($diff!=0)
                    {
                      $unit=(($early_reading-$row['reading'])*$factor)/$diff;
                      echo number_format($unit,2,'.','');
                    }
                    else
                      echo 0.00;
                  }
                  else
                    echo '0.00';
                ?>
                </td>
                <td align="center"><?= getDateFormate($row['reading_date'])?></td>
              </tr>
                <?
                 $sno++;
                }	
            }
            else
            {
            ?>
              <tr><td align="center" colspan="8"><b>No Records Found</b></td></tr>
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
