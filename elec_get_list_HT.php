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
<div class="AddMore" style="padding-top:10px">
	<form action="elec_print_list_HT.php" name="test" id="test" method="post" target="_blank"> 
    <input type="hidden" name="value" id="value" value="<?=$_REQUEST['value'] ?>" />
    <input type="hidden" name="byControl" id="byControl" value="<?=$_REQUEST['byControl'] ?>" />
    <a href="#" onclick="test.submit();">Print&nbsp;&nbsp;&nbsp;</a>
 	</form>
</div>
<table align="center" width="100%" border="1" class="table1 text_1">
  <tr>
    <td class="gredBg">S.No.</td>
    <td class="gredBg">Reading Date</td>
    <td class="gredBg">MWH Reading</td>
    <td class="gredBg">MWH Unit</td>
    <td class="gredBg">Comm. MWH Unit</td>
    <td class="gredBg">MVAH Reading</td>
    <td class="gredBg">MVAH Unit</td>
    <td class="gredBg">KVA Reading</td>
    <td class="gredBg">Comm. MVAH Unit</td>
    <!--<td class="gredBg">Power Factor</td>-->
    <td class="gredBg">Avg. P.F.</td>
    <td width="4%" class="gredBg">Edit</td>
    <td width="4%" class="gredBg">Delete</td>
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
    <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
      <td align="center"><?=$sno?></td>
      <td align="right" style="padding-right:5px"><b><?= getDateFormate($row['reading_date'])?></b></td>
      <td align="right" style="padding-right:5px"><?= $row['mwh_reading']?></td>
      <td align="right" style="padding-right:5px">
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
      <td align="right" style="padding-right:5px"><?= $mwh_unit_total+=$mwh_unit?></td> 
      <td align="right" style="padding-right:5px"><?= $row['mvah_reading']?></td>
      <td align="right" style="padding-right:5px">
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
      <td align="right" style="padding-right:5px"><?= $row['kva_reading']?></td>
      <td align="right" style="padding-right:5px"><?= $mvah_unit_total+=$mvah_unit?></td>
      
      <!--<td align="right" style="padding-right:5px">
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
      </td>-->
      <td align="right" style="padding-right:5px">
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
      <?
			if(1)
			{
				//$SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date)
			?>
			 <td align="center">
				<a href="elec_add_HT.php?HT_id=<?=$row["HT_id"]?>&mode=edit">
					<img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
				</a>
			</td>
			<td align="center">
				<a href="javascript:;" onClick="overlay(<?=$row["HT_id"]?>);">
					<img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0">
				</a>
			</td>
				<?
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
        //echo $mwh_unit_total.','.$demand.','.$avg_pf.','.$days.',';
        if($avg_pf=='' || $avg_pf==0)
					$load_factor=0;
				else
					$load_factor=($mwh_unit_total*100)/($demand*$avg_pf*24*(int)$days);
					#$load_factor=($mwh_unit_total*100)/($demand*0.9*24*(int)$days);
				$load_factor=number_format($load_factor, 3, '.', '');
				$total_lf+=$load_factor;
        $sno++;$days++;
     }	
  ?> 
  <tr>
    <td colspan="2" align="right"><b>Total</b>&nbsp;&nbsp;&nbsp;</td>
    <td align="right" style="padding-right:5px" colspan="6">
    <b>Load Factor</b>&nbsp;&nbsp;&nbsp;
    <? 	# $lf=$total_lf/($days-1);echo number_format($lf,2,'.','');?>
      <? 	 $lf=$total_lf/($days-1);echo number_format($load_factor,2,'.','');?>
    </td>
    <td colspan="4"></td>
  </tr>
  <?
	}    
	else
  {
  	?>
    <tr>
      <td colspan="12" align="center" style="font-weight:bold">No Records Found</td>
    </tr>
    <?
	}
	?>
</table>