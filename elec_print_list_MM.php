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
$Machine='';
$Motor='';
$DateRange='';
if($val!='')
{
	$val=explode(',',$val);
	$department_id=$val[0];
	$machine_id=$val[1];
	$motor_id=$val[2];
	$dfrom=getDateFormate($val[3]);
	$dto=getDateFormate($val[4]);
	
	$DateRange="(MM_date BETWEEN '".$dfrom."' and '".$dto."')";
	if($department_id!='')
		$Department="and department_id='".$department_id."'";
	if($machine_id!='' && $machine_id!='0')
		$Machine="and machine_id='".$machine_id."'";
	if($motor_id!='' && $motor_id!='0')
		$Motor="and motor_id='".$motor_id."'";
}
	

$sql="select * from elec_MM where 
$DateRange
$Department
$Machine
$Motor
order by MM_date asc
";
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());$sum=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Motor Maintenance Report</title>
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
<div style="margin:0 auto;width:740px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <thead>
      <tr height="70px">
        <td align="center">
          <b><u>MAHIMA PURESPUN</u></b><br />
          <b>MOTOR MAINTENANCE REPORT</b>
    				BETWEEN <b><?=getDateFormate($dfrom) ?></b> And <b><?=getDateFormate($dto)?></b>
        </td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
        	<table align="center" width="100%" border="1" class="tblborder">
            <tr class="note">
              <td align="center" width="5%"><b>SNo.</b></td>
              <td align="center" width="8%"><b>Date</b></td>
              <td align="center" width="14%"><b>Department</b></td>
              <td align="center" width="15%"><b>Machine</b></td>
              <td align="center" width="18%"><b>Motor</b></td>
              <td align="center" width="40%"><b>Details</b></td>
            </tr>
            <?
              if(mysql_num_rows($result)>0)
              {
                $sno=1;
                while($row=mysql_fetch_array($result))
                {
                  $sql_idate="select * from elec_MM where insert_date='".date('Y-m-d')."' and MM_id='".$row['MM_id']."'";
                  $res_idate=mysql_query($sql_idate);
                  $row_idate=mysql_fetch_array($res_idate);
                  $insert_date=$row_idate['insert_date'];
                  ?>
                  <tr class="particulars">
                      <td align="center"><?=$sno++?></td>
                      <td align="center"><?=getDateFormate($row['MM_date'])?></td>
                      <td align="left" style="padding-left:2px">
                      <?
                      $sqlD="select name from elec_department where department_id='".$row['department_id']."'";
                      $resD=mysql_query($sqlD);
                      $dname='';
                      if(mysql_num_rows($resD)>0)
                      {
                        $rowD=mysql_fetch_array($resD);
                        $dname=$rowD['name'];
                      }
                      echo $dname;
                      ?>
                      </td>
                      <td align="left" style="padding-left:2px">
                      <?
                      $sqlM="select name from elec_machine where machine_id='".$row['machine_id']."'";
                      $resM=mysql_query($sqlM);
                      $mname='';
                      if(mysql_num_rows($resM)>0)
                      {
                        $rowM=mysql_fetch_array($resM);
                        $mname=$rowM['name'];
                      }
                      echo $mname;
                      ?>
                      </td>
                      <td align="left" style="padding-left:2px">
                      <?
                      $sqlMO="select name from elec_motor where motor_id='".$row['motor_id']."'";
                      $resMO=mysql_query($sqlMO);
                      $mname='';
                      if(mysql_num_rows($resMO)>0)
                      {
                        $rowMO=mysql_fetch_array($resMO);
                        $mname=$rowMO['name'];
                      }
                      echo $mname;
                      ?>
                      </td>
                      <td align="left" style="padding-left:2px"><?=stripcslashes($row['details'])?></td>
                    </tr>
                  <?
                }
              }
              else
              {
                ?>
                <tr>
                  <td colspan="8" align="center"><b>No Record Found</b></td>
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
