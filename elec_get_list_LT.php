<?
include("inc/check_session.php");
include("inc/dbconnection.php");
include("inc/common_function_mt_elect.php");
$whereCondition='';
if(isset($_GET)){
	if($_GET['dep']=='selectAll'){
		$whereCondition= "";
	}elseif($_GET['dep']!=''){
		$whereCondition.= " eLT.department_id ='".$_GET['dep']."' and";
	}
	if($_GET['subDEp']!='0'){
		$whereCondition= " eLT.sub_department_id ='".$_GET['subDEp']."' and";
	}
	if($_GET['fDate'] != '' || $_GET['tDate'] != ''){
		$from_date = getDateFormate($_GET['fDate']);
		$to_date = getDateFormate($_GET['tDate']);
		if($to_date == ''){
			$to_date = date('Y-m-d');
		}
		$whereCondition.= " eLT.reading_date BETWEEN '".$from_date."' and '".$to_date."' and";
	}
	if($_GET['rDate']!=''){
		$whereCondition = " eLT.reading_date ='".$_POST['rDate']."' and";
	}
	
}
$sql="select DISTINCT * from elec_LT as eLT, elec_sub_department as eD, elec_department as edept
where $whereCondition eLT.sub_department_id = eD.sub_department_id and edept.department_id = eD.department_id  
order by eD.name asc,eLT.reading_date asc ";
#$sql="select DISTINCT * from elec_LT eLT,elec_sub_department eD,elec_department edept where $Department $SubDepartment $ReadingDate $ReadingRange and eLT.sub_department_id=eD.sub_department_id and edept.department_id=eD.department_id order by eD.name asc,eLT.reading_date asc ";

//echo $sql;
//$sql = $sql ." LIMIT " . $start . ", $row_limit";
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
$sum=0;
?>
<div class="AddMore" style="padding-top:10px">
	<form action="elec_print_list_LT.php" name="test" id="test" method="post" target="_blank"> 
    <input type="hidden" name="subDEp" id="subDEp" value="<?=$_GET['subDEp']?>" />
    <input type="hidden" name="dep" id="dep" value="<?=$_GET['dep']?>" />
	<input type="hidden" name="fDate" id="fDate" value="<?=$_GET['fDate']?>" />
    <input type="hidden" name="tDate" id="tDate" value="<?=$_GET['tDate']?>" />
    <input type="hidden" name="rDate" id="rDate" value="<?=$_GET['rDate']?>" />
	    <a href="#" onclick="test.submit();">Print&nbsp;&nbsp;&nbsp;</a>
 	</form>
</div>
<table id="tableItems" align="center" width="100%" border="1" class="table1 text_1">
	<tr>
    <td class="gredBg">S.No.</td>
    <td class="gredBg">Department</td>
    <td class="gredBg">Sub Department</td>
    <td class="gredBg">Reading</td>
    <td class="gredBg">Reading  Date</td>
	<td class="gredBg">Units(KWH)</td>
    <td width="4%" class="gredBg">Edit</td>
    <td width="4%" class="gredBg">Delete</td>
  </tr>
	 <? if(mysql_num_rows($result)>0){
			$sno = 1;$totalUnit=0;
			while($row=mysql_fetch_array($result)){	
				$sql_idate="select * from elec_LT where insert_date='".date('Y-m-d')."' and LT_id='".$row['LT_id']."'";
				$res_idate=mysql_query($sql_idate);
				$row_idate=mysql_fetch_array($res_idate);
				$insert_date=$row_idate['insert_date'];
			?>
		<tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
        <td align="center"><?=$sno?></td>
        <td align="left" style="padding-left:5px">
        <? $sql_dep = "select * from elec_department where department_id = '".$row['department_id']."'";
          $res_dep = mysql_query($sql_dep) or die (mysql_error());
          $row_dep = mysql_fetch_array($res_dep);
          echo $row_dep['name']; ?>	
        </td>
        <td align="left" style="padding-left:5px">
        <? $sql_SD = "select * from elec_sub_department where sub_department_id = '".$row['sub_department_id']."'";
          $res_SD = mysql_query($sql_SD) or die (mysql_error());
          $row_SD = mysql_fetch_array($res_SD);
          echo $row_SD['name']; ?>	
        </td>
        <td align="center"><?= $row['reading']?></td>
        <td align="center"><?= getDateFormate($row['reading_date'])?></td>
					<td align="right" style="padding-right:3px">
					<? $da=explode('-',$row['reading_date']);//$da=explode('-','2011-03-01');
            $early_date= date("Y-m-d", mktime(0, 0, 0,$da[1] ,$da[2]-1 , $da[0]));
            $sql_u="select reading from elec_LT where reading_date ='".$early_date."' and sub_department_id='".$row['sub_department_id']."'";
            $res_u=mysql_query($sql_u);
            $factor=1;
            if(mysql_num_rows($res_u)>0){
             // $sql_lt = "select * from elec_LT_MF where sub_department_id = '".$row['sub_department_id']."' ";
              //$res_lt = mysql_query($sql_lt);
              //$row_lt = mysql_fetch_array($res_lt);
				//			$factor=$row_lt['factor'];
				$factor=$row['multipulingfactor'];
              $row_u=mysql_fetch_array($res_u);
				$diff = (double)$row['reading'] - (double)$row_u['reading'];
#$total=$diff*$factor;
              $total = $diff * $factor;
			  	  
              echo $total;
							$sum+=$total;
            }else{
              echo '0';
            }
          ?>
          </td>
				<? if(1){//$SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date) ?>
					 <td align="center">
							<a href="elec_add_LT.php?LT_id=<?=$row["LT_id"]?>&mode=edit">
								<img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
							</a>
						</td>
						<td align="center">
							<a href="javascript:;" onClick="overlay(<?=$row["LT_id"]?>);">
								<img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0">
							</a>
						</td>
				<? }else{ ?>
					<td align="center"></td>
					<td align="center"></td>
				<? } ?>
			</tr>
			<? $sno++;
			}	
			//if($_REQUEST['byControl']=='Department')
			{ ?>
			<tr>
				<td align="right" colspan="5">Total Unit are :&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td align="right" style="padding-right:3px"><b><?= $sum?></b></td><td colspan="2"></td>
			</tr>	
				<? }
		}else{ ?>
		<tr>
			<td colspan="8" align="center" style="font-weight:bold">No Records Found</td>
		</tr>
		<? } ?>        
 </table>