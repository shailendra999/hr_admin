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
";
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());$sum=0;
?>
<div class="AddMore" style="padding-top:10px">
	<form action="elec_print_list_MM.php" name="test" id="test" method="post" target="_blank"> 
    <input type="hidden" name="value" id="value" value="<?=$_REQUEST['value'] ?>" />
    <a href="#" onclick="test.submit();">Print&nbsp;&nbsp;&nbsp;</a>
 	</form>
</div> 
<table align="center" width="100%" border="1" class="table1 text_1">
  <tr>
    <td class="gredBg" width="6%"><b>SNo.</b></td>
    <td class="gredBg" width="8%"><b>Date</b></td>
    <td class="gredBg" width="14%"><b>Department</b></td>
    <td class="gredBg" width="12%"><b>Machine</b></td>
    <td class="gredBg" width="18%"><b>Motor</b></td>
    <td class="gredBg" width="34%"><b>Details</b></td>
    <td class="gredBg" width="4%"><b>Edit</b></td>
    <td class="gredBg" width="4%"><b>Delete</b></td>
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
        <tr>
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
            <?
            if(1)
            {
				//$SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date)
            ?>
            <td align="center">
              <a href="elec_add_MM.php?MM_id=<?=$row["MM_id"]?>&mode=edit">
                <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
              </a>
            </td>
            <td align="center">
              <a href="javascript:;" onClick="overlay(<?=$row["MM_id"]?>);">
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