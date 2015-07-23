<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
   $txt_date1 =$_GET["id"];
   $txt_date2=$_GET["sdate"];
   $id =$_GET["str"];
   $status =$_POST["str4"];
   $stat =$_POST["str4"];
   $badli_as  =$_POST["str5"];
   $type=$_POST["str6"];
   $shift=$_GET["str7"];
?>
<?


////////////////////// Markin attendence //////////////
	$ip = $_SERVER['REMOTE_ADDR'];
    $good_work="";
	echo $txt_date1 = str_replace("/","-",$txt_date1);
	echo '...........'.$txt_date2 = str_replace("/","-",$txt_date2);
	$datePeriod = createDateRangeArray($txt_date1,$txt_date2);
	echo '<pre>';
	print_r($datePeriod);
	die();
	foreach($datePeriod as $datePeriod){
	$date123 = date("w", strtotime($datePeriod));
	
	

	// Set timezone
	date_default_timezone_set('UTC');
 
	// Start date
	$date = $txt_date1;
	// End date
	$end_date = $txt_date2;
 
	while (strtotime($date) <= strtotime($end_date)) {
		echo "$date\n";
		echo $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
	}
 

 if($date123 == 0){
	 $status='W';
	 
	 }
	 else{
		 $status = $stat;
		 }

	$sql_check_attendance = "SELECT * FROM mpc_attendence_master where  date='$date123' and emp_id ='$id'";
		 $result_check_attendance = mysql_query ($sql_check_attendance) or die ("Error in : ".$sql_check_attendance."<br>".mysql_errno()." : ".mysql_error());
	$asdf = mysql_num_rows($result_check_attendance);
	 if(mysql_num_rows($result_check_attendance)==0)
		{
	$sql_check = "insert into ".$mysql_table_prefix."attendence_master set emp_id ='$id',
																				attendance_status='$status',
																				date ='$datePeriod',
																				badli_as ='$badli_as',
																				shift ='$shift',
																				good_work ='$good_work',
																				InsertBy ='$id',
																				InsertDate =now(),
																				IpAddress ='$ip'";
																		
			  $result_check=mysql_query($sql_check) or die ("Query Failed ".mysql_error());
			 
		}
		
		else
		{
			 $sql_check_update = "update ".$mysql_table_prefix."attendence_master set	
																					attendance_status='$status',
																					badli_as ='$badli_as',
																					shift ='$shift'
																					where emp_id ='$id' and date ='$txt_date'";
																		
			$result_check_update=mysql_query($sql_check_update) or die ("Query Failed ".mysql_error());
		}
		}
?>

<?
if(isset($_GET['start']))
{
	if($_GET['start']=='All')
	{
		$start = 0;
	}
	else
	{
		$start = $_GET['start'];
	}
}
else
{
	$start = 0;
}	
//	if($type=="Staff")
//	{
//     $sql = "SELECT mpc_official_detail.emp_category,mpc_official_detail.emp_id,mpc_employee_master.emp_id,mpc_attendence_master.emp_id,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_attendence_master.attendance_status,mpc_attendence_master.badli_as,mpc_attendence_master.good_work FROM mpc_attendence_master,mpc_employee_master,mpc_official_detail where  date='$txt_date' and mpc_employee_master.emp_id =mpc_attendence_master.emp_id and mpc_official_detail.emp_id = mpc_employee_master.emp_id  and mpc_official_detail.emp_category='$type' order by mpc_attendence_master.InsertDate DESC";
//   }
//   else
//   {
//      $shift=getShiftDetail('shift',$id);
//   	   $sql = "SELECT mpc_shift_detail.to_date,mpc_shift_detail.shift,mpc_shift_detail.emp_id,mpc_official_detail.emp_category,mpc_official_detail.emp_id,mpc_employee_master.emp_id,mpc_attendence_master.emp_id,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_attendence_master.attendance_status,mpc_attendence_master.badli_as,mpc_attendence_master.good_work FROM mpc_attendence_master,mpc_employee_master,mpc_official_detail,mpc_shift_detail where  date='$txt_date' and mpc_employee_master.emp_id =mpc_attendence_master.emp_id and mpc_official_detail.emp_id = mpc_employee_master.emp_id  and mpc_official_detail.emp_category='$type' and mpc_shift_detail.emp_id = mpc_official_detail.emp_id and mpc_shift_detail.shift='$shift' and to_date='0000-00-00' order by mpc_attendence_master.InsertDate DESC";
//   }
   
  /*?>    $sql="SELECT mpc_employee_master.emp_id,
     mpc_employee_master.ticket_no,mpc_attendence_master.emp_id,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_attendence_master.attendance_status,mpc_attendence_master.shift,mpc_attendence_master.badli_as,mpc_designation_master.rec_id,mpc_designation_master.emp_category ,mpc_designation_employee.designation_id,mpc_designation_employee.to_date,mpc_designation_employee.emp_id FROM mpc_attendence_master,mpc_employee_master,mpc_designation_employee,mpc_designation_master where date='$txt_date1' and mpc_employee_master.rec_id =mpc_attendence_master.emp_id and mpc_designation_employee.emp_id =mpc_employee_master.rec_id and mpc_designation_employee.designation_id=mpc_designation_master.rec_id and mpc_designation_master.emp_category='$type' and mpc_designation_employee.to_date='0000-00-00' and mpc_attendence_master.shift='$shift' order by InsertDate Desc";
 
  $query_count = "select count(*) as count from ".$mysql_adm_table_prefix."document_master where DocumentFor = '$id'";

$result_doc = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
$query_count = $query_count;
$result_q= mysql_query($query_count);
$row_count = mysql_fetch_array($result_q);
$numrows = $row_count['count'];
$count = ceil($numrows/$row_limit);
if(mysql_num_rows($result_doc)>0)
{
	$sno = 1;
?>
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr class="navigation_row">
        <td class="headingSmall">
            <div style="margin:1px;text-align:left;" >
       
                <?
                if(!$count==0)
                {
                ?>
                    <?=$numrows?> results found
                <?
                }
                ?>
            </div>
        </td>   
    </tr>
</table> 
<div> 
    <table align="center" width="100%" border="0" class="border">
        <tr class="blackHead">
          <td width="6%" align="center">S.No.</td>
          <td width="7%" align="center">Emp no.</td>
          <td width="21%" align="center">Employee Name</td>         
           <? if($type!="Staff")
			{
		   ?>
          <td width="11%" align="center">Badli as</td>
          <?
		    }
		  ?>
          <td width="19%" align="center">Attendance</td>
      </tr>
<?
	while($row_doc = mysql_fetch_array($result_doc))
	{
?>
		<tr <? if ($sno%2==1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
            <td align="center"><?=$sno?></td>
            <td align="center"><?=$row_doc['ticket_no']?></td>
            <td align="center"><?=$row_doc['first_name']?>-<?=$row_doc['last_name']?></td>
           <? if($type!="Staff")
			{
		   ?>
            <td>
            	<? if($row_doc['badli_as']==""){echo 'None';}else{ echo getdesignationMaster('designation_name','rec_id',$row_doc['badli_as']); }?>
            </td>
			<?
				}
			?>
            <td align="center"><?=$row_doc['attendance_status']?>            
          	</td>
        </tr>
<?
	 $sno++;
	}
?>           	    
</table>
</div>
<?    	
}
else
{
?>
	<div align="center">no record found</div>	
<?
}<?php */?>
<?php
function createDateRangeArray($strDateFrom,$strDateTo)
{
    // takes two dates formatted as YYYY-MM-DD and creates an
    // inclusive array of the dates between the from and to dates.

    // could test validity of dates here but I'm already doing
    // that in the main script

    $aryRange=array();

    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

    if ($iDateTo>=$iDateFrom)
    {
        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
        while ($iDateFrom<$iDateTo)
        {
            $iDateFrom+=86400; // add 24 hours
            array_push($aryRange,date('Y-m-d',$iDateFrom));
        }
    }
    return $aryRange;
}	

?>	

          			
