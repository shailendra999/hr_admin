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
$DateRange='';
if($val!='')
{
	$val=explode(',',$val);
	$department_id=$val[0];
	$machine_id=$val[1];
	$dfrom=getDateFormate($val[2]);
	$dto=getDateFormate($val[3]);
	$DateRange="(machine_maint_date BETWEEN '".$dfrom."' and '".$dto."')";
	$Department="and department_id='".$department_id."'";
	$Machine="and machine_id='".$machine_id."'";
}
	
$sql="select * from elec_machine_maint where 
$DateRange
$Department
$Machine
order by machine_maint_date asc 
";
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());$sum=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Machine Maintenance Report</title>
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
          <b>Machine Maintenance REPORT</b>
    				BETWEEN <b><?=getDateFormate($dfrom) ?></b> And <b><?=getDateFormate($dto)?></b>
        </td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
        	<table align="center" width="100%" border="1" class="tblborder">
            <tr class="note"> 
              <td align="center" width="6%">S.No.</td>
              <td align="center" width="10%">Date</td>
              <td align="center" width="15%">Department</td>
              <td align="center" width="14%">Machine</td>
              <td align="center" width="55%">Details</td>
            </tr>
            <?
              if(mysql_num_rows($result)>0)
              {
                $sno=1;
                $count=1;
                while($row=mysql_fetch_array($result))
                {
                  $sql_idate="select * from elec_machine_maint where insert_date='".date('Y-m-d')."' and machine_maint_id='".$row['machine_maint_id']."'";
                  $res_idate=mysql_query($sql_idate);
                  $row_idate=mysql_fetch_array($res_idate);
                  $insert_date=$row_idate['insert_date'];
                  ?>
                  <tr class="particulars">
                    <td align="center"><?=$sno++?></td>
                    <td align="center"><?=getDateFormate($row['machine_maint_date'])?></td>
          					<td align="left" style="padding-left:5px">
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
                      <td align="left" style="padding-left:5px">
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
                      <td align="left" style="padding-left:5px">
												<?=stripcslashes($row['details'])?>
                      </td>
                  </tr> 
                  <?
                }
              }
              else
              {
              ?>
              <tr>
                <td colspan="5" align="center" style="font-weight:bold">No Records Found</td>
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
