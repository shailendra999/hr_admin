<?
include("inc/check_session.php");
include("inc/dbconnection.php");
include("inc/common_function_mt_elect.php");
$whereCondition='';
if(isset($_POST)){
	if($_POST['dep']=='selectAll'){
		$whereCondition= "";
	}elseif($_POST['dep']!=''){
		$whereCondition.= " eLT.department_id ='".$_POST['dep']."' and";
	}
	if($_POST['subDEp']!='0'){
		$whereCondition= " eLT.sub_department_id ='".$_POST['subDEp']."' and";
	}
	if($_POST['fDate'] != '' || $_POST['tDate'] != ''){
		$from_date = getDateFormate($_POST['fDate']);
		$to_date = getDateFormate($_POST['tDate']);
		if($to_date == ''){
			$to_date = date('Y-m-d');
		}
		$whereCondition.= " eLT.reading_date BETWEEN '".$from_date."' and '".$to_date."' and";
	}
	if($_POST['rDate']!=''){
		$whereCondition = " eLT.reading_date ='".$_POST['rDate']."' and";
	}
	
}
$sql="select DISTINCT * from elec_LT as eLT, elec_sub_department as eD, elec_department as edept
where $whereCondition eLT.sub_department_id = eD.sub_department_id and edept.department_id = eD.department_id  
order by eD.name asc,eLT.reading_date asc ";
//echo $sql;
//$sql = $sql ." LIMIT " . $start . ", $row_limit";
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
$sum=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Low Tension Report</title>
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
          <b>LT REPORT</b><br />
          <? if($_POST['fDate']!='' || $_POST['rDate'] != ''){
			  if($_POST['rDate']!=''){ ?>
            ON <b><?=getDateFormate($_POST['rDate'])?></b>
          <? }else{ ?>
    				BETWEEN <b><?=getDateFormate($_POST['fDate']) ?></b> And <b><?=getDateFormate($_POST['fDate'])?></b>
          <? } }?>
        </td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
        	<table align="center" width="100%" border="1" class="tblborder">
            <tr class="note">
              <td align="center">S.No.</td>
              <td align="center">Department</td>
              <td align="center">Sub Department</td>
              <td align="center">Reading</td>
              <td align="center">Reading  Date</td>
              <td align="center">Units(KWH)</td>
            </tr>
             <?  
              if(mysql_num_rows($result)>0)
              {
                $sno = 1;$totalUnit=0;
                while($row=mysql_fetch_array($result))
                {	
                $sql_idate="select * from elec_LT where insert_date='".date('Y-m-d')."' and LT_id='".$row['LT_id']."'";
                $res_idate=mysql_query($sql_idate);
                $row_idate=mysql_fetch_array($res_idate);
                $insert_date=$row_idate['insert_date'];
                ?>
                <tr class="particulars">
                  <td align="center"><?=$sno?></td>
                  <td align="left" style="padding-left:5px">
                  <?
                    $sql_dep = "select * from elec_department where department_id = '".$row['department_id']."'";
                    $res_dep = mysql_query($sql_dep) or die (mysql_error());
                    $row_dep = mysql_fetch_array($res_dep);
                    echo $row_dep['name'];
                  ?>	
                  </td>
                  <td align="left" style="padding-left:5px">
                  <?
                    $sql_SD = "select * from elec_sub_department where sub_department_id = '".$row['sub_department_id']."'";
                    $res_SD = mysql_query($sql_SD) or die (mysql_error());
                    $row_SD = mysql_fetch_array($res_SD);
                    echo $row_SD['name'];
                  ?>	
                  </td>
                  <td align="center"><?= $row['reading']?></td>
                  <td align="center"><?= getDateFormate($row['reading_date'])?></td>
                    <td align="right" style="padding-right:3px">
                    <?
                      $da=explode('-',$row['reading_date']);//$da=explode('-','2011-03-01');
                      $early_date= date("Y-m-d", mktime(0, 0, 0,$da[1] ,$da[2]-1 , $da[0]));
                      $sql_u="select reading from elec_LT where reading_date ='".$early_date."' and sub_department_id='".$row['sub_department_id']."'";
                      $res_u=mysql_query($sql_u);
                      $factor=1;
                      if(mysql_num_rows($res_u)>0)
                      {
                        $sql_lt = "select * from elec_LT_MF where sub_department_id = '".$row['sub_department_id']."' ";
                        $res_lt = mysql_query($sql_lt);
                        $row_lt = mysql_fetch_array($res_lt);
                        $factor=$row_lt['factor'];
                        $row_u=mysql_fetch_array($res_u);
                        $diff=(double)$row['reading']-(double)$row_u['reading'];
                        $total=$diff*$factor;
                        echo $total;
                        $sum+=$total;
                      }
                      else
                      {
                        echo '0';
                      }
                    ?>
                    </td>
                </tr>
                <?
                $sno++;
                }	
                //if($_POST['byControl']=='Department')
                {
                ?>
                <tr>
                  <td align="right" colspan="5">Total Unit are :&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  <td align="right" style="padding-right:3px"><b><?= $sum?></b></td>
                </tr>	
                  <?
                }
              }
              else
              {
              ?>
              <tr>
                <td colspan="6" align="center" style="font-weight:bold">No Records Found</td>
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
