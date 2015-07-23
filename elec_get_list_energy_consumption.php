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
		$val3='';
		$val4='';
		if($val[2]!='' and $val[3]!='')
		{
			$val3=getDateFormate($val[2]);
			$val4=getDateFormate($val[3]);
		}
		$deptId='';
		$Machine='';
		$Rdate='';
			$deptId=" department_id='".$val1."' ";
			$Machine=" machine_name_number ='".$val2."' ";
			$Rdate=" reading_date BETWEEN '".$val3."' AND '".$val4."' ";
			if($val1!='' and $val2!='' and ($val3!='' and $val4!=''))
			{
				$All=" $deptId and $Machine and $Rdate ";
			}
			else
			{
				if($val1!='' and $val2!='')
				{
					$All=" $deptId and $Machine ";
				}
				else if($val1!='' and $val3!='')
				{
					$All=" $deptId and $Rdate ";
				}
				else if($val2!='' and $val3!='')
				{
					$All=" $Machine and $Rdate ";
				}
				else if($val1!='')
					$All=" $deptId";
				else if($val2!='')
					$All=" $Machine";
				else if($val3!='')
					$All=" $Rdate";
			}			
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
<div class="AddMore" style="padding-top:10px">
	<form action="elec_print_list_energy_consumption.php" name="test" id="test" method="post" target="_blank"> 
    <input type="hidden" name="str" id="str" value="<?=$_REQUEST['str'] ?>" />
    <input type="hidden" name="byControl" id="byControl" value="<?=$_REQUEST['byControl'] ?>" />
    <a href="#" onclick="test.submit();">Print&nbsp;&nbsp;&nbsp;</a>
 	</form>
</div>
<table align="center" id="tableEntry" width="100%" border="1" class="table1 text_1">
  <tr>
    <td class="gredBg" width="4%">S.No.</td>
    <td class="gredBg" width="22%">Department</td>
    <td class="gredBg" width="22%">Machine</td>
    <td class="gredBg" width="7%">Time</td>
    <td class="gredBg" width="8%">Hrs Reading</td>
    <td class="gredBg" width="7%">Reading</td>
    <td class="gredBg" width="10%">Unit Cons/Hrs.</td>
    <td class="gredBg" width="10%">Reading Date</td>
    <td width="5%" class="gredBg">Edit</td>
    <td width="5%" class="gredBg">Delete</td>
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
		<tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
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
			<?
			if($SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date))
			{
			?>
				<td align="center">
					<a href="elec_add_energy_consumption.php?EC_id=<?=$row["EC_id"]?>&mode=edit">
						<img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
					</a>
				</td>
				<td align="center">
					<a href="javascript:;" onClick="overlay(<?=$row["EC_id"]?>);">
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
    <tr><td align="center" colspan="10"><b>No Records Found</b></td></tr>
  <?
  }
?>  
</table>