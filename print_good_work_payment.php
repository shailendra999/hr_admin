<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Good Work Payment</title>
</head>
<body>
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
	  $sql_prj = "select mpc_official_detail.date_joining,mpc_employee_master.rec_id as id,mpc_employee_master.ticket_no,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_official_detail.emp_id ,mpc_official_detail.employee_typ,mpc_account_detail.emp_id,mpc_account_detail.date_releaving  $select_string from ".$mysql_table_prefix."employee_master,mpc_official_detail,mpc_account_detail $table_list where mpc_employee_master.rec_id!='' and mpc_employee_master.rec_id=mpc_official_detail.emp_id and mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00'  $where_string order by mpc_employee_master.ticket_no ASC";
	
	$result_prj = mysql_query($sql_prj) or die("Error in Query :".$sql_prj."<br>".mysql_error().":".mysql_errno());
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>      
        <td style="padding-left:5px; padding-top:5px;" valign="top">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center">MAHIMA PURESPUN(A UNIT OF MAHIMA FIBRES PVT.LTD.)</td>
                </tr>
                <tr>
                	<td align="left">Good Work Payment Date -<?=$month?></td>
                </tr>
                <tr>
                	<td align="left">Good Work Payment for <? if($_POST["print_plant_name"]!=""){echo '-Plant :'.$_POST["print_plant_name"]; } ?><? if($_POST["print_employee_type"]!=""){echo '-Employee Type :'.$_POST["print_employee_type"]; } ?> <? if($_POST["print_department"]!=""){echo '-Department :'.$_POST["print_department"];}?><? if($_POST["print_sub_department"]!="")
		{echo '-Sub Department :'.$_POST["print_sub_department"];}?><? if($_POST["print_ticket_id"]!="")
		{echo '-Employee ID.:'.$_POST["print_ticket_id"];}?></td>
                </tr>
                <tr>
                	<td valign="top">
					   <?  
                        if(mysql_num_rows($result_prj)>0)
                        {
                        $sno = $start+1;
                        ?>
                              <table align="center" width="100%" cellpadding="0" cellspacing="0" class="table1" border="1">
                                  <tr class="gredBg">
                                    <td width="5%" align="center"><b>S.No.</b></td>
                                    <td width="5%" align="center"><b>Emp Id</b></td>
                                    <td width="5%" align="center"><b>Employee Name</b></td> 
                                    <td width="15%" align="center"><b>Designation</b></td>
                                    <td align="center"><b>Basic</b></td>
                                    <td align="center"><b>Hrs</b></td>
                                    <td align="center"><b>Cal/Pay</b></td>
                                    <td align="center"><b>Side/Amount</b></td>
                                    <td align="center"><b>N/Payable</b></td>
                                  </tr>
                                    <?
                                    while($row=mysql_fetch_array($result_prj))
                                    {
                                    
                                    $emp_id=$row['id'];														
                                                                                                    
                                    $total_salary_earing=0;
                                    $total_salary_basic=getSalaryDetail("basic",$emp_id,getdbDate($month));
                                    if($row['employee_typ']=='daily_wages')
                                        {
                                            $salary_basic=$total_salary_basic/8;
                                        }
                                        else
                                        {
                                            $salary_basic=($total_salary_basic/31)/8;
                                        }
                                    $good_work=getGoodWorkBydate($emp_id,getdbDate($month));
                                    if($good_work!="")
                                    {
                                     ?>
                                   <tr <? if ($sno%2==1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
                                    <td width="5%" align="center"><?=$sno?></td>
                                    <td width="5%" align="center"><?=$row['ticket_no']?></td>
                                    <td width="5%" align="left">
                                    <?=$row['first_name']?> <?=$row['last_name']?><br/>
                                    </td>
                                    <td> 
                                        <?=getdesignationMaster('designation_name','rec_id',getdesignationDetail('designation_id',$emp_id,getdbDate($month)));?>  	
                                    </td>
                                        <td>
                                            <?=$total_salary_basic?></td>
                                        <td>
                                            <?=$good_work?>
                                        </td>
                                         <td>
                                            <?	
                                                $good_work=explode(':',$good_work);
                                                $good_work_hour=$good_work[0];
                                                $net_pay=$salary_basic*$good_work[0];
                                                if($good_work[1]=="30")
                                                {
                                                    $net_pay=$net_pay+($salary_basic/2);
                                                }
                                            ?>
                                            <?=round($net_pay,2)?>
                                         </td>
                                         <td>
                                            0.00
                                         </td>
                                         <td>
                                            <?=round($net_pay,2)?>
                                         </td>
                                  </tr>
                                   <? }
                                        $sno++;
                                    }	
                                    ?>														 
                                </table>                                                             </div>  
                            </td>
                       </tr> 
                        <?
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
  </body>
</html>