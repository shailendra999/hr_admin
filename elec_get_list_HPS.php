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
<div class="AddMore" style="padding-top:10px">
	<form action="elec_print_list_HPS.php" name="test" id="test" method="post" target="_blank"> 
    <input type="hidden" name="value" id="value" value="<?=$_REQUEST['value'] ?>" />
    <input type="hidden" name="byControl" id="byControl" value="<?=$_REQUEST['byControl'] ?>" />
    <a href="#" onclick="test.submit();">Print&nbsp;&nbsp;&nbsp;</a>
 	</form>
</div>
<table align="center" width="100%" border="1" class="table1 text_1">
	<tr>
    <td class="gredBg">S.No.</td>
    <td class="gredBg">Reading Date</td>
    <td class="gredBg">Power Failure</td>
    <td class="gredBg">Plant</td>
    <td class="gredBg">Pump</td>
    <td class="gredBg">Reading</td>
    <td class="gredBg">Difference</td>
    <td width="4%" class="gredBg">Edit</td>
    <!--<td width="4%" class="gredBg">Delete</td>-->
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
        <tr>
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
          <?
					if(1)
					{
						//$SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date)
					?>
           <td align="center">
          	<a href="elec_add_HPS.php?HPS_id=<?=$row["HPS_id"]?>&mode=edit">
              <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
            </a>
          </td>
          <!--<td align="center">
            <a href="javascript:;" onClick="overlay(<? //$row["HPS_id"]?>);">
              <img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0">
            </a>
          </td>-->
					<?
          }
          else
          {
          ?>
            <td align="center"></td>
            <!--<td align="center"></td>-->
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
			<td colspan="8" align="center" style="font-weight:bold">No Records Found</td>
		</tr>
		<?
		}
	?>        
</table>