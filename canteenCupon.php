<? include ("inc/hr_header.php");
$msg ='';
$plant="";
$dep="";
$dept_id="";
if(isset($_GET['start'])){
	if($_GET['start']=='All'){
		$start = 0;
	}else{
		$start = $_GET['start'];
	}
}else{
	$start = 0;
}		
$date_upto="";
if(isset($_POST['txt_date'])){	
	 $date_upto =$_POST['txt_date'];
}	
$employee_type="";
$department="";
$sub_department="";
$plant_name="";
$ticket_id="";
$select_string= "";
$table_list= "";
$where_string="";
if(isset($_POST["employee_type"]) and isset($_POST["ticket_id"]) and isset($_POST["department"]) and isset($_POST["sub_department"])
and isset($_POST["plant_name"])){
	if(($_POST["employee_type"]!="")){	
		$select_string=",mpc_designation_employee.*,mpc_designation_master.*";
		$employee_type=$_POST["employee_type"];
		$table_list= ",mpc_designation_employee,mpc_designation_master";
		$where_string.="and mpc_designation_employee.emp_id =mpc_employee_master.rec_id and mpc_designation_employee.designation_id=mpc_designation_master.rec_id and mpc_designation_master.emp_category='$employee_type' and mpc_designation_employee.to_date='0000-00-00'";
	}
	if($_POST["ticket_id"]!=""){
		$select_string= "";
		$ticket_id=$_POST["ticket_id"];
		$table_list.= "";
		$where_string.="and mpc_employee_master.ticket_no ='$ticket_id'";
	}
	if($_POST["department"]!="" and $_POST["sub_department"]==""){
		$select_string= ",mpc_department_employee.*,mpc_department_master.*";
		$department=$_POST["department"];
		$table_list.= ",mpc_department_employee,mpc_department_master";
		
		$where_string.="and mpc_department_employee.emp_id =mpc_employee_master.rec_id and mpc_department_master.reference_id ='$department' and mpc_department_employee.to_date='0000-00-00' and mpc_department_master.rec_id=mpc_department_employee.dept_id";
	}
	if($_POST["sub_department"]!=""){
		$select_string= ",mpc_department_employee.*";	
		$department=$_POST["department"];
		$sub_department=$_POST["sub_department"];
		$table_list.= ",mpc_department_employee";
		
		$where_string.="and mpc_department_employee.emp_id =mpc_employee_master.rec_id and mpc_department_employee.dept_id ='$sub_department' and mpc_department_employee.to_date='0000-00-00'";
	}
	if($_POST["plant_name"]!=""){
		$select_string= ",mpc_plant_employee.*";
		$plant_name=$_POST["plant_name"];
		$table_list.= ",mpc_plant_employee";
		
		$where_string.="and mpc_plant_employee.emp_id =mpc_employee_master.rec_id and mpc_plant_employee.plant_id ='$plant_name' and mpc_plant_employee.to_date='0000-00-00'";
	}
}
if(isset($_POST["btn_submit_x"]) or isset($_GET['year'])){			
$sql_prj = "select mpc_official_detail.date_joining,mpc_employee_master.rec_id as id,
mpc_employee_master.ticket_no,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_official_detail.emp_id ,
mpc_official_detail.employee_typ,mpc_account_detail.emp_id,
mpc_account_detail.date_releaving  $select_string from ".$mysql_table_prefix."employee_master,
mpc_official_detail,mpc_account_detail $table_list where mpc_employee_master.rec_id!='' and 
mpc_employee_master.rec_id=mpc_official_detail.emp_id and mpc_employee_master.rec_id=mpc_account_detail.emp_id and
 mpc_account_detail.date_releaving ='0000-00-00'  $where_string order by mpc_employee_master.ticket_no ASC";
	
	$result_prj = mysql_query($sql_prj) or die("Error in Query :".$sql_prj."<br>".mysql_error().":".mysql_errno());
}?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/snb.php"); ?>
        </td>       
        <td style="padding-left:5px; padding-top:5px;" valign="top">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp;Daily Good Work Payment</td>
                </tr>
                <tr>
                	<td valign="top">
                        <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                                        <tr>
                                            <td class="red"><?=$msg?></td>
                                         </tr>
                                        <tr>
                                            <td align="center" valign="top">
                                                <table align="center" width="40%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #C6B4AE;" bgcolor="#EAE3E1">
                                                     <tr>
                                                        <td style="padding-top:10px;" align="center">
                                                        <form name="frm_month" id="frm_month" action="" method="post">
                                                            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                <tr>
                                                                	<td colspan="8" class="text_1" style="text-align:center;">
                                                                 
                                                                      Dated: <input type="text" name="txt_date" id="txt_date" style="width:100px; height:20px;" readonly="readonly" value="<?=$date_upto?>"/>
                                              <a href="javascript:void(0)" onclick="gfPop.fPopCalendar(document.frm_month.txt_date);"><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="27" height="22" border="0" alt=""/></a>                             
                                                                   	</td>
                                                                </tr>
                                                                 <tr> 
                                                                 	<td class="text_1">
                                                                    	Filter By:
                                                                    </td>
                                                                	<td class="text_1">
                                                                    	 Emp Type<select name="employee_type" id="employee_type">
                                                                        							<option value="">Select</option>
                                                                                                    <option value="Staff" <? if($employee_type=='Staff'){echo 'selected="selected"';}?> >Staff</option>
                                                                                                    <option value="Worker" <? if($employee_type=='Worker'){echo 'selected="selected"';}?>>Worker</option>
                                                                        						</select>
                                                                        		   
                                                                    </td>
                                                                    <td class="text_1">
                                                                    	Emp ID <input type="text" name="ticket_id" id="ticket_id" value="<?=$ticket_id?>" size="4"/>
                                                                    </td>
                                                                    <td class="text_1">
                                                                    	Department<?
																				 $sql = "SELECT * FROM mpc_department_master where reference_id='0' order by department_name";
																				 $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
																				 ?>
																			<select name="department" id="department" style="width:150px; height:20px;" onChange="get_frm('get_department.php',this.value,'div_sub_dept','sub_department');">
																				<option value="">Select</option>
																				 <?
																			  while ($row=mysql_fetch_array($result))
																				{	?>
																					   <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$department){?> selected="selected" <? } ?>><?=$row["department_name"]?></option>
																				<?  }	?>
																			</select>
                                                                    </td>
                                                                    <td class="text_1">
                                                                    	Sub Department
                                                                         <div id="div_sub_dept">
																			
                                                                        <select name="sub_department" id="sub_department" style="width:150px; height:20px;" onchange="">
                                                                            <option value="">Select</option>
                                                                            
                                                                        </select>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text_1">
                                                                    	Plant<?
																			 $sql = "SELECT * FROM mpc_plant_master order by plant_name";
																			 $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
																			 ?>
																		<select name="plant_name" id="plant_name" style="width:150px; height:20px;">
																			<option value="">Select</option>
																			 <?
																		  while ($row=mysql_fetch_array($result))
																			{	?>
																				   <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$plant_name){?> selected="selected" <? } ?>><?=$row["plant_name"]?></option>
																			<?  }	?>
																		</select>
                                                                    </td>
                                                                </tr> 
                                                                <tr>
                                                                    <td colspan="6" align="center" style="padding-top:5px;">
                                                                        <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                                        <input type="image" src="images/btn_view.jpg" name="btn_submit" id="btn_submit" value="View"/>
                                                                        	
                                                   <a href="javascript:;" onclick="document.location='daily_good_work_payment.php';">
                                                    <img src="images/submit_button_Mahima.jpg" name="over" border="0"></a>
                                                                    </td>
                                                                </tr>     
                                                            </table>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top" style="padding-top:5px;">
                                                <table align="center" width="100%" cellpadding="1" cellspacing="1" border="0" style="border:1px solid #E4E4E4;">
                                                       <?  
                                                    if(isset($_POST["btn_submit_x"]) or isset($_GET['month']))
                                                        {
                                                        if(mysql_num_rows($result_prj)>0)
                                                        {
                                                        
                                                        ?>
                                                   <tr>
                                                  		 <td align="right">
                                                         	<table cellpadding="0" cellspacing="0" border="0">
                                                            	<tr>
                                                                	<td>
                                                                        <form action="print_good_work_payment.php" method="post" name="frm_print" id="frm_print" target="_blank">
                                                                            <input type="hidden" name="print_month" id="print_month" value="<?=$date_upto?>"/>
                                                                            <input type="hidden" name="print_employee_type" id="print_employee_type" value="<?=$employee_type?>"/>
                                                                            <input type="hidden" name="print_ticket_id" id="print_ticket_id" value="<?=$ticket_id?>"/>
                                                                            <input type="hidden" name="print_department" id="print_department" value="<?=$department?>"/>
                                                                            <input type="hidden" name="print_sub_department" id="print_sub_department" value="<?=$sub_department?>"/>
                                                                            <input type="hidden" name="print_plant_name" id="print_plant_name" value="<?=$plant_name?>"/>
                                                                             <input type="image" src="images/btn_print.jpg" name="btn_submit" id="btn_submit" value="View"/>
                                                                        </form>
                                                         			</td>
                                                                    <td valign="top">
                                                                           <form action="print_good_work_payment_excel.php" method="post" name="frm_print_xls" id="frm_print_xls" target="_blank" style="display:inline;">
                                                                            <input type="hidden" name="print_month" id="print_month" value="<?=$date_upto?>"/>
                                                                            <input type="hidden" name="print_employee_type" id="print_employee_type" value="<?=$employee_type?>"/>
                                                                            <input type="hidden" name="print_ticket_id" id="print_ticket_id" value="<?=$ticket_id?>"/>
                                                                            <input type="hidden" name="print_department" id="print_department" value="<?=$department?>"/>
                                                                            <input type="hidden" name="print_sub_department" id="print_sub_department" value="<?=$sub_department?>"/>
                                                                            <input type="hidden" name="print_plant_name" id="print_plant_name" value="<?=$plant_name?>"/>
            
                                                                        </form>

                                                            <a href="javascript:;" onclick="frm_print_xls.submit()" class="AddMore" >Export To XLS</a>  
                                                         			</td>
                                                        		 </tr>
                                                        	 </table>
                                                         </td>
                                                   </tr> 
                                                   <tr>
                                                        <td align="center">
<div id="div_attandance_list" style="overflow:scroll;height:500px;width:1000px">
<form action="foodCoupon.php" id="foodCupon" name="foodCupon" method="post">
	<table align="center" width="100%" cellpadding="0" cellspacing="0" class="table1" border="1">
		<tr class="gredBg">
			<td width="10%" align="center"><b>S.No.</b></td>
			<td width="10%" align="center"><b>Emp Id</b></td>
			<td width="30%" align="center"><b>Employee Name</b></td> 
			<td width="10%" align="center"><b>Designation</b></td>
			<td width="10%" align="center"><b>Basic</b></td>
			<td width="10%" align="center"><b>Hrs</b></td>
			<td width="10%" align="center"><b>Shift</b></td>
			<td align="center"><b>Check Here</b></td>
		</tr>
<? $sno_d =1;
while($row=mysql_fetch_array($result_prj)){
	$emp_id=$row['id'];
	
	$total_salary_earing=0;
	$total_salary_basic=getSalaryDetail("basic",$emp_id,getdbDate($date_upto));
	if($row['employee_typ']=='daily_wages'){
		$salary_basic=$total_salary_basic/8;
	}else{
		$salary_basic=($total_salary_basic/31)/8;
	}
	$good_work=getGoodWorkBydate($emp_id,getdbDate($date_upto));
	if($good_work!=""){?>
		<tr <? if ($sno_d%2==1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
			<td width="5%" align="center"><?=$sno_d?></td>
			<td width="5%" align="center"><?=$row['ticket_no']?><input type="hidden" name="cardNo" id="cardNo" value="<?=$sno_d?>"  /></td>
			<td width="5%" align="left"><? $empName = $row['first_name'].' '.$row['last_name']?><input type="hidden" name="empName" id="empName" value="<?=$empName?>"  /><br/></td>
			<td><?= getdesignationMaster('designation_name','rec_id',getdesignationDetail('designation_id',$emp_id,getdbDate($date_upto)));
			echo $desig;?><input type="hidden" name="designation" id="designation" value="<?=$desig?>"  /></td>
			<td><?=$total_salary_basic?></td>
			<td><?=$good_work?><input type="hidden" name="goodWork" id="goodWork" value="<?=$good_work?>"  /></td>
			<td>			</td>
			<td><input type="checkbox" name="canteenCupon" id="canteenCupon" value="1" /></td>
		</tr>
		<? $sno_d++;
	}
}?>														 
	</table>
	<input type="submit" name="cuponSubmit" id="submit" value="Generate Cupon"  />
</form>
</div>  
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
                                                    } 
                                                      ?>          	
                                               </table>
                                          </td>
                                       </tr>
                                   </table>
                               </td>
                           </tr>
                        </table> 
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>   
<? include ("inc/hr_footer.php"); ?>
