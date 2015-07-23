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
$PlantId='';
$PlantTransactionId='';
if($val!='')
{
	if($_REQUEST['byControl']=='ReadingDate')
	{
		$val=explode(',',$val);
		$plant_id=$val[0];
		$plant_transaction_id=$val[1];
		$rd=getDateFormate($val[2]);
		
		$ReadingDate="em.reading_date ='".$rd."' ";
		$PlantId="and et.plant_id='".$plant_id."'";
		$PlantTransactionId="and et.plant_transaction_id='".$plant_transaction_id."' ";
		
	}
	if(($_REQUEST['byControl'])=='DateFromTo')
	{
		$val=explode(',',$val);
		$plant_id=$val[0];
		$plant_transaction_id=$val[1];
		$rdfrom=getDateFormate($val[2]);
		$rdto=getDateFormate($val[3]);
		
		$ReadingRange="(em.reading_date BETWEEN '".$rdfrom."' and '".$rdto."')";
		$PlantId="and et.plant_id='".$plant_id."'";
		$PlantTransactionId="and et.plant_transaction_id='".$plant_transaction_id."' ";
		
	}	
}
$sql="select em.HPS_id,et.HPS_transaction_id,et.reading,et.plant_id,et.plant_transaction_id,em.reading_date,em.power_failure,pm.name as plantname,pt.name as pumpname from elec_HPS_master em,elec_HPS_transaction et,elec_plant_master pm,elec_plant_transaction pt where 
$ReadingDate 
$ReadingRange
$PlantId
$PlantTransactionId
and pm.plant_id=et.plant_id and pt.plant_transaction_id=et.plant_transaction_id and et.HPS_id=em.HPS_id";
//echo $sql;
//$sql = $sql ." LIMIT " . $start . ", $row_limit";
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print HPS Report</title>
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
          <b>HPS REPORT</b>
					<? 
					if(($_POST['byControl'])=='ReadingDate')
					{
						?>
            ON <b><?=getDateFormate($rd) ?></b>
          <?
					}
					else
					{
					?>
    				BETWEEN <b><?=getDateFormate($rdfrom) ?></b> And <b><?=getDateFormate($rdto)?></b>
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
              <td align="center">Power Failure</td>
              <td align="center">Plant</td>
              <td align="center">Pump</td>
              <td align="center">Reading</td>
              <td align="center">Difference</td>
            </tr>
            <?
              if(mysql_num_rows($result)>0)
              {
                $sno=1;
                while($row=mysql_fetch_array($result))
                {
                  $sql_idate="select * from elec_HPS_master where insert_date='".date('Y-m-d')."' and HPS_id='".$row['HPS_id']."'";
                  $res_idate=mysql_query($sql_idate);
                  $row_idate=mysql_fetch_array($res_idate);
                  $insert_date=$row_idate['insert_date'];
                  ?>
                  <tr class="particulars">
                    <td align="center"><?=$sno++?></td>
                    <td align="center"><?=getDateFormate($row['reading_date'])?></td>
                    <td align="center"><?=$row['power_failure']?></td>
                    <td align="center"><?=$row['plantname']?></td>
                    <td align="center"><?=$row['pumpname']?></td>
                    <td align="center"><?=$row['reading']?></td>
                    <td align="center">
                    <?
                      $da=explode('-',$row['reading_date']);//$da=explode('-','2011-03-01');
                      $early_date= date("Y-m-d", mktime(0, 0, 0,$da[1] ,$da[2]-1 , $da[0]));
                      $sql_u="select em.HPS_id,et.HPS_transaction_id,et.reading,em.reading_date,em.power_failure,pm.name as plantname,pt.name as pumpname from elec_HPS_master em,elec_HPS_transaction et,elec_plant_master pm,elec_plant_transaction pt where em.reading_date ='".$early_date."' and et.plant_id='".$row['plant_id']."' and et.plant_transaction_id='".$row['plant_transaction_id']."' and pm.plant_id=et.plant_id and pt.plant_transaction_id=et.plant_transaction_id and et.HPS_id=em.HPS_id";
                      $res_u=mysql_query($sql_u);		
                      $early_reading=0;$diff=0;
                      if(mysql_num_rows($res_u)>0)
                      {
                        $row_u=mysql_fetch_array($res_u);
                        $early_reading=(double)$row_u['reading'];
                        $diff=(double)$row['reading']-$early_reading;
                      }
                      echo $diff;
                      ?>
                    </td>
                  </tr> 
                  <?
                }
              }
              else
              {
              ?>
              <tr>
                <td colspan="7" align="center" style="font-weight:bold">No Records Found</td>
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
