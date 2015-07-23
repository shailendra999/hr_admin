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
";
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());$sum=0;
?>
<div class="AddMore" style="padding-top:10px">
	<form action="elec_print_list_machine_maint.php" name="test" id="test" method="post" target="_blank"> 
    <input type="hidden" name="value" id="value" value="<?=$_REQUEST['value'] ?>" />
    <a href="#" onclick="test.submit();">Print&nbsp;&nbsp;&nbsp;</a>
 	</form>
</div> 
<table align="center" width="100%" border="1" class="table1 text_1">
  <tr>
    <td class="gredBg">S.No.</td>
    <td class="gredBg">Date</td>
    <td class="gredBg">Department</td>
    <td class="gredBg">Machine</td>
    <td class="gredBg">Details</td>
    <td width="4%" class="gredBg">Edit</td>
    <td width="4%" class="gredBg">Delete</td>
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
        <tr>
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
            <td align="left" style="padding-left:5px"><?=stripcslashes($row['details'])?></td>
            <?
            if(1)
            {
				//$SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date)
              ?>
               <td align="center">
                  <a href="elec_add_machine_maint.php?machine_maint_id=<?=$row["machine_maint_id"]?>&mode=edit">
                    <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
                  </a>
                </td>
                <td align="center">
                  <a href="javascript:;" onClick="overlay(<?=$row["machine_maint_id"]?>);">
                    <img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0">
                  </a>
                </td>
                <?
              $count++;
            }
            else
            {
            ?>
              <td align="center" ></td>
              <td align="center" ></td>
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
      <td colspan="7" align="center" style="font-weight:bold">No Records Found</td>
    </tr>
    <?
    }
  ?>        
</table>