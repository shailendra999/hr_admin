<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
  $id="";
  $txt_date =$_GET["id"];
  $id =$_GET["str"];
  $good_work =$_POST["str4"];
  $type =$_POST["str5"];
  $shift =$_POST["str6"];
  
?>
<?
////////////////////// Markin attendence //////////////
	$ip = $_SERVER['REMOTE_ADDR'];

	 
	 $sql_check = "update ".$mysql_table_prefix."good_work_master set	
																	good_work ='$good_work',
																	InsertBy ='$id',
																	InsertDate =now(),
																	IpAddress ='$ip'
																	where emp_id ='$id' and date ='$txt_date' and shift ='$shift'";
																	
	$result_check=mysql_query($sql_check) or die ("Query Failed ".mysql_error());
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
	

    $sql="SELECT mpc_employee_master.emp_id,mpc_employee_master.  	ticket_no,mpc_good_work_master.emp_id,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_good_work_master.good_work,mpc_designation_master.rec_id,mpc_designation_master.emp_category ,mpc_designation_employee.designation_id , mpc_designation_employee.to_date,mpc_designation_employee.emp_id FROM mpc_good_work_master,mpc_employee_master,mpc_designation_employee,mpc_designation_master where date='$txt_date' and mpc_employee_master.rec_id =mpc_good_work_master.emp_id and mpc_designation_employee.emp_id =mpc_employee_master.rec_id and mpc_designation_employee.designation_id=mpc_designation_master.rec_id and mpc_designation_master.emp_category='$type' and mpc_designation_employee.to_date='0000-00-00' and mpc_good_work_master.shift='$shift'";
   
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
            Recent Good Work of date:<?=$txt_date?>
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
          <td width="19%" align="center">Good Work</td>
      </tr>
<?
	while($row_doc = mysql_fetch_array($result_doc))
	{
?>
		<tr <? if ($sno%2==1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
            <td align="center"><?=$sno?></td>
            <td align="center"><?=$row_doc['ticket_no']?></td>
            <td align="center"><?=$row_doc['first_name']?>-<?=$row_doc['last_name']?></td>
            <td align="center"><?=$row_doc['good_work']?>            
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
}
	
?>	
          			