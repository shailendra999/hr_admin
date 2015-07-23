<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
$msg ='';
$plant="";
$month="0";
$year="0";
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
if(isset($_POST['print_month']))
{	
	 $month =$_POST['print_month'];
}	
if(isset($_POST['print_year']))
{	
	 $year =$_POST['print_year'];
}	
$employee_type="";
$department="";
$sub_department="";
$plant_name="";
$ticket_id="";
$select_string= "";
$table_list= "";
$where_string="";
if(isset($_POST["print_employee_type"]) and isset($_POST["print_ticket_id"]) and isset($_POST["print_department"]) and isset($_POST["print_sub_department"])
and isset($_POST["print_plant_name"]))
	{
	if(($_POST["print_employee_type"]!=""))
		{	
		$select_string=",mpc_designation_employee.*,mpc_designation_master.*";
		$employee_type=$_POST["print_employee_type"];
		$table_list= ",mpc_designation_employee,mpc_designation_master";
		$where_string.="and mpc_designation_employee.emp_id =mpc_employee_master.rec_id and mpc_designation_employee.designation_id=mpc_designation_master.rec_id and mpc_designation_master.emp_category='$employee_type' and mpc_designation_employee.to_date='0000-00-00'";
	    }
	if($_POST["print_ticket_id"]!="")
		{
		$select_string= "";
		$ticket_id=$_POST["print_ticket_id"];
		$table_list.= "";
		$where_string.="and mpc_employee_master.ticket_no ='$ticket_id'";
		}
	if($_POST["print_department"]!="" and $_POST["print_sub_department"]=="")
		{	
		$select_string= ",mpc_department_employee.*,mpc_department_master.*";
		$department=$_POST["print_department"];
		$table_list.= ",mpc_department_employee,mpc_department_master";
		
		$where_string.="and mpc_department_employee.emp_id =mpc_employee_master.rec_id and mpc_department_master.reference_id ='$department' and mpc_department_employee.to_date='0000-00-00' and mpc_department_master.rec_id=mpc_department_employee.dept_id";
		}
		if($_POST["print_sub_department"]!="")
		{
		$select_string= ",mpc_department_employee.*";	
		$department=$_POST["print_department"];
		$sub_department=$_POST["print_sub_department"];
		$table_list.= ",mpc_department_employee";
		
		$where_string.="and mpc_department_employee.emp_id =mpc_employee_master.rec_id and mpc_department_employee.dept_id ='$sub_department' and mpc_department_employee.to_date='0000-00-00'";
		}
		if($_POST["print_plant_name"]!="")
		{	
		$select_string= ",mpc_plant_employee.*";
		$plant_name=$_POST["print_plant_name"];
		$table_list.= ",mpc_plant_employee";
		
		$where_string.="and mpc_plant_employee.emp_id =mpc_employee_master.rec_id and mpc_plant_employee.plant_id ='$plant_name' and mpc_plant_employee.to_date='0000-00-00'";
		}
	}
		
	$sql_prj = "select DAY(mpc_official_detail.date_joining) as 'Day',MONTH(mpc_official_detail.date_joining) as 'Month' ,YEAR(mpc_official_detail.date_joining) as 'Year',mpc_official_detail.date_joining,mpc_employee_master.rec_id as id,mpc_employee_master.ticket_no,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_official_detail.emp_id ,mpc_account_detail.emp_id,mpc_account_detail.date_releaving,mpc_advance_employee.advance,mpc_advance_employee.ad_date,mpc_advance_employee.rec_id as adv_id $select_string from ".$mysql_table_prefix."employee_master,mpc_official_detail,mpc_account_detail,mpc_advance_employee $table_list where mpc_employee_master.rec_id!='' and mpc_employee_master.rec_id=mpc_official_detail.emp_id and EXTRACT(YEAR_MONTH FROM mpc_official_detail.date_joining)<='$year$month' and mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' and mpc_advance_employee.emp_id =  mpc_employee_master.rec_id $where_string and mpc_advance_employee.deduction_date='0000-00-00' and mpc_advance_employee.advance!='' and  MONTH(mpc_advance_employee.ad_date)='".$month."' and YEAR(mpc_advance_employee.ad_date) ='".$year."' order by mpc_employee_master.ticket_no ASC";
	
	$result_prj = mysql_query($sql_prj) or die("Error in Query :".$sql_prj."<br>".mysql_error().":".mysql_errno());
	
$date_month=$year."-".$month."-01";
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>      
        <td style="padding-left:5px; padding-top:5px;" valign="top">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<thead>
                    <tr>
                        <td align="center">Laxyo Solution Soft Pvt. Ltd.</td>
                    </tr>
                    <tr>
                        <td align="left">Salary Employee Report MONTH -<?=date("F",mktime(0, 0, 0,$month, 1, 0))?>,<?=$year?></td>
                    </tr>
                    <tr>
                        <td align="left">Salary Employee for <? if($_POST["print_plant_name"]!=""){echo '-Plant :'.$_POST["print_plant_name"]; } ?><? if($_POST["print_employee_type"]!=""){echo '-Employee Type :'.$_POST["print_employee_type"]; } ?> <? if($_POST["print_department"]!=""){echo '-Department:'.getdeptDetail('department_name','rec_id',$_POST["print_department"]);}?><? if($_POST["print_sub_department"]!="")
            {echo '-Sub Department:'.getdeptDetail('department_name','rec_id',$_POST["print_sub_department"]);}?><? if($_POST["print_ticket_id"]!="")
            {echo '-Employee ID.:'.$_POST["print_ticket_id"];}?></td>
                    </tr>
                   </thead>
                <tr>
                	<td valign="top">
                    	<?
                        if(mysql_num_rows($result_prj)>0)
                        {
                        $sno = $start+1;
                        ?>
                            <table align="center" width="100%" cellpadding="0" cellspacing="0" class="table1" border="1">
                               <thead>
                                  <tr>
                                    <td width="5%" align="center"><b>Sno.</b></td>
                                    <td width="5%" align="center"><b>Emp Id</b></td>
                                    <td width="15%" align="center"><b>Name</b></td>
                                    <td width="15%" align="center"><b>Advance</b></td>
                                    <td width="15%" align="center"><b>Advance Date</b></td>
                                  </tr>
                               </thead>
                                   
						<?
								$sno=1;
								while($row=mysql_fetch_array($result_prj))
								{
								?>	
							  <tr>
								<td align="center"><?=$sno?></td>
								<td align="center"><?=$row['ticket_no']?></td>
								<td align="left"><?=$row['first_name']?> <?=$row['last_name']?></td>
								<td align="center"><?=$row['advance']?></td>
								<td align="center"><?=getDatetime($row["ad_date"]);?></td>
							 </tr>
						<?
								$sno++;
								}
                         }	 
                         else
                         {
                         ?>
                         <tr class="table_rows">
                            <td align="center" colspan="8">No records found</td>
                          </tr>
                         <?
                          } 
                          ?>          	
                   </table>                                    
        </td>
    </tr>
</table>
<script>
   window.print ();
 </script>