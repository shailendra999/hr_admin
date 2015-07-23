<? $pgName = ""; ?>
<? include("inc/hr_header.php"); ?>
<?
include("inc/dbconnection.php");
?>
<style type="text/css" media="screen">
@import "tab/css/style.css";
@import "tab/css/simpletabs.css";
</style>
<?
if(isset($_GET['unset']))
{
	unset($_SESSION['emp_id']);
	unset($_SESSION['emp_family']);
	unset($_SESSION['emp_education']);
	unset($_SESSION['emp_offical']);
	unset($_SESSION['emp_salary']);

}
if(isset($_GET['emp_id']))
{

	unset($_SESSION['emp_id']);
	unset($_SESSION['emp_family']);
	unset($_SESSION['emp_education']);
	unset($_SESSION['emp_offical']);
	unset($_SESSION['emp_salary']);
	
	$emp_edit_id=$_GET['emp_id'];
	
	$_SESSION['emp_id']=$emp_edit_id;
	$_SESSION['emp_family']=$emp_edit_id;
	$_SESSION['emp_education']=$emp_edit_id;
	$_SESSION['emp_offical']=$emp_edit_id;
	$_SESSION['emp_salary']=$emp_edit_id;

}
//print_r($_SESSION);
$first_name ="";	
$last_name="";	
$address="";	
$country ="";	
$state ="";	
$other_state  ="";	
$city ="";	
$other_city ="";	
$dob ="";	
$gender ="";	
$phone_no  ="";	
$email_id ="";	
$employee_picture ="";	
$marital_status="";
$marriage_date="";	
$blood_group ="";		
$religion ="";			
$nationality  ="";		
$reference ="";	
$pincode="";	
$emp_edit_id="";				

	if(isset($_SESSION['emp_id']) or isset($_GET['emp_id']))
		{
			$emp_edit_id=isset($_SESSION['emp_id']) ? $_SESSION['emp_id']:$_GET['emp_id'];
			
		    $sql = "SELECT * FROM ".$mysql_table_prefix."employee_master where emp_id = '$emp_edit_id'";
			$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());	
			if(mysql_num_rows($result)>0)
				{	
					$row = mysql_fetch_array($result);
					$first_name =$row['first_name'];	
					$last_name  =$row['last_name'];
					$address =$row['address'];
					$country =$row['country'];
					$state =$row['state'];
					$other_state  =$row['other_state'];
					$city =$row['city'];
					$other_city  =$row['other_city'];
					$dob =$row['dob'];
					$gender =$row['gender'];
					$phone_no  =$row['phone_no'];
					$email_id =$row['email_id'];
					$employee_picture  =$row['employee_picture'];
					$marriage_date =$row['marriage_date'];
					$blood_group  =$row['blood_group'];	
					$religion  =$row['religion'];		
					$nationality  =$row['nationality'];	
					$reference  =$row['reference'];		
					$marital_status=$row['marital_status'];	
					$pincode=$row['pincode'];	
						
				}
		}
		
$father_name  ="";	
$father_dob   ="";
$Dependant_father ="";
$father_occupation  ="";
$mother_name  ="";
$mother_occupation  ="";
$mother_dob ="";
$Dependant_mother  ="";	
$wife_name ="";
$wife_dob  ="";
$Dependant_wife ="";
$wife_occupation  ="";		
$emp_family_edit="";	

		if(isset($_SESSION['emp_family']) or isset($_GET['emp_id']))
		{
			$emp_family_edit=isset($_SESSION['emp_family']) ? $_SESSION['emp_family']:$_GET['emp_id'];
			$sql = "SELECT * FROM ".$mysql_table_prefix."family_master where emp_id = '$emp_family_edit'";
			$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());	
			if(mysql_num_rows($result)>0)
				{	
					$row = mysql_fetch_array($result);
					$father_name  =$row['father_name'];	
					$father_dob   =$row['father_dob'];
					$Dependant_father  =$row['Dependant_father'];
					$father_occupation =$row['father_occupation'];
					$mother_name =$row['mother_name'];
					$mother_occupation  =$row['mother_occupation'];
					$mother_dob  =$row['mother_dob'];
					$Dependant_mother   =$row['Dependant_mother'];	
					$wife_name =$row['wife_name'];
					$wife_dob  =$row['wife_dob'];
					$Dependant_wife  =$row['Dependant_wife'];
					$wife_occupation   =$row['wife_occupation'];							
				}
		}
$qualification  ="";	
$university  ="";
$duration  ="";
$percentage ="";
$emp_education_edit="";	
				
		if(isset($_SESSION['emp_education']) or isset($_GET['emp_id']))
		{
			$emp_education_edit=isset($_SESSION['emp_education']) ? $_SESSION['emp_education']:$_GET['emp_id'];
			
			$sql = "SELECT * FROM ".$mysql_table_prefix."education_master where emp_id = '$emp_education_edit'";
			$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());	
			if(mysql_num_rows($result)>0)
				{	
					$row = mysql_fetch_array($result);
					$qualification  =$row['qualification'];	
					$university   =$row['university'];
					$duration  =$row['duration'];
					$percentage =$row['percentage'];					
				}
		}
		
$date_joining  ="";	
$plant  ="";	
$pan_no   ="";	
$grade  ="";	
$employee_typ  ="";	
$emp_category  ="";	
$skill_level  ="";		
$reporting_authority_name  ="";	
$emp_offical_edit="";	
$dept_id="";
$dep="";
$designation="";
				
		if(isset($_SESSION['emp_offical']) or isset($_GET['emp_id']))
		{
			$emp_offical_edit=isset($_SESSION['emp_offical']) ? $_SESSION['emp_education']:$_GET['emp_id'];
			
			$sql = "SELECT * FROM ".$mysql_table_prefix."official_detail where emp_id = '$emp_offical_edit'";
			$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());	
			if(mysql_num_rows($result)>0)
				{	
					$row = mysql_fetch_array($result);
					$date_joining  =$row['date_joining'];	
					$department =$row['department'];
					$designation =$row['designation'];
					$plant   =$row['plant'];
					$pan_no  =$row['pan_no'];
					$grade =$row['grade'];
					$employee_typ =$row['employee_typ'];	
					$emp_category =$row['emp_category'];	
					$skill_level =$row['skill_level'];	
					$reporting_authority_name =$row['reporting_authority_name'];						
				}
				
			$sql = "SELECT * FROM ".$mysql_table_prefix."department_employee where emp_id = '$emp_offical_edit' and to_date='00-00-0000'";
			$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());	
			if(mysql_num_rows($result)>0)
				{	
					$row = mysql_fetch_array($result);
					$dept_id =$row['dept_id'];		
					$dep=getdeptDetail('reference_id','rec_id',$dept_id);		
				}
		}
$side_allowance="";		
$leave_travel_allow  ="";	
$hra ="";	
$basic ="";	
$convence ="";	
$other_deductions ="";	
$tds ="";	
$medical ="";	
$professional_tax ="";		
$emp_salary_edit="";
$advance="";
$loan ="";			
				
		if(isset($_SESSION['emp_salary']) or isset($_GET['emp_id']))
		{
			$emp_offical_edit=isset($_SESSION['emp_salary']) ? $_SESSION['emp_salary']:$_GET['emp_id'];
			
			$sql = "SELECT * FROM ".$mysql_table_prefix."salary_master where emp_id = '$emp_offical_edit'";
			$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());	
			if(mysql_num_rows($result)>0)
				{	
					$row = mysql_fetch_array($result);
					$leave_travel_allow  =$row['leave_travel_allow'];	
					$side_allowance  =$row['side_allowance'];	
					$hra =$row['hra'];
					$basic =$row['basic'];
					$convence =$row['convence'];
					$other_deductions =$row['other_deductions'];
					$tds =$row['tds'];
					$medical =$row['medical'];	
					$professional_tax =$row['professional_tax'];						
				}
				
				
		    $sql = "SELECT * FROM ".$mysql_table_prefix."advance_employee where emp_id = '$emp_offical_edit' ";
			$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());	
			if(mysql_num_rows($result)>0)
				{	
					$row = mysql_fetch_array($result);
					$advance =$row['advance'];		
				}
			$sql = "SELECT * FROM ".$mysql_table_prefix."loan_employee where emp_id = '$emp_offical_edit' ";
			$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());	
			if(mysql_num_rows($result)>0)
				{	
					$row = mysql_fetch_array($result);
					$loan =$row['loan_amount'];		
				}
		}
?>
<?
$msg = '';
$mode='';
if(!session_is_registered("no_refresh"))
{
	$_SESSION['no_refresh'] = "";
}
$ip = $_SERVER['REMOTE_ADDR'];
if(isset($_POST['Submit_emp']))
{
	if($_POST['no_refresh'] == $_SESSION['no_refresh'])
	{	
		//echo "WARNING: Do not try to refresh the page.";
	}
	else
	{	
		////////////////////login deatil
		$emp_login = $_POST['emp_login'];
		
		/*$password = $_POST['password'];
		$sql_insert_login = "insert into ".$mysql_table_prefix."login_master  set 
			UserName = '$emp_login',
			Password = '$password',
			UserType = 'Empolyee',
			IsActive = '0',
			InsertDate= now()";																				
		$result_login = mysql_query($sql_insert_login) or die("Error in query:".$sql_insert_login."<br>".mysql_error()."<br>".mysql_errno());
		$emp_id = mysql_insert_id();*/
		
	    $_SESSION['emp_id'] = $emp_login;
				
		$first_name = $_POST['first_name'];
		$last_name=$_POST['last_name'];
		$address=$_POST['address'];
		$country = $_POST['country'];
		$state=isset($_POST['state']) ? $_POST['state'] : 0;
		$other_state = isset($_POST['txt_other_state']) ? $_POST['txt_other_state'] : "";
		$other_city =  isset($_POST['other_city']) ? $_POST['other_city'] : "";
		$city = isset($_POST['city_select']) ? $_POST['city_select'] : 0;
		$dob = getdbDate($_POST['dob']);
		$pin_code = $_POST['pin_code'];
		$gender = $_POST['gender'];
		
		$phone_no = $_POST['phone_no'];
		$email_id = $_POST['email_id'];
		$marital = $_POST['marital'];
		$marr_date = getdbDate(isset($_POST['marr_date']) ? $_POST['marr_date']:"");
		$blood_group = $_POST['blood_group'];
		$nationality = $_POST['nationality'];
		$reference = $_POST['reference'];
		$religion = $_POST['religion'];

		if($emp_edit_id=="")
		{
		$sql_insert_personal = "insert into ".$mysql_table_prefix."employee_master  set 
																						emp_id = '$emp_login',
																						first_name = '$first_name',
																						last_name = '$last_name',
																						address = '$address',
																						country = '$country',
																						state = '$state',
																						other_state = '$other_state',
																						city = '$city',
																						other_city = '$other_city',
																						pincode = '$pin_code',
																						dob = '$dob',
																						gender = '$gender',
																						phone_no = '$phone_no',
																						email_id = '$email_id',
																						religion='$religion',
																						marital_status = '$marital',
																						marriage_date = '$marr_date',
																						blood_group = '$blood_group',
																						nationality = '$nationality',		
																						reference = '$reference'";
			
	    $result_insert_personal = mysql_query($sql_insert_personal) or die("Error in query:".$sql_insert_personal."<br>".mysql_error()."<br>".mysql_errno());
		$emp_rec_id = mysql_insert_id();
		}
		else
		{
				$sql_insert_personal = "update ".$mysql_table_prefix."employee_master  set 
					first_name = '$first_name',
					last_name = '$last_name',
					address = '$address',
					country = '$country',
					state = '$state',
					other_state = '$other_state',
					city = '$city',
					other_city = '$other_city',
					pincode = '$pin_code',
					dob = '$dob',
					gender = '$gender',
					phone_no = '$phone_no',
					email_id = '$email_id',
					religion='$religion',
					marital_status = '$marital',
					marriage_date = '$marr_date',
					blood_group = '$blood_group',
					nationality = '$nationality',		
					reference = '$reference' where emp_id = '$emp_edit_id'";
					
				$result_insert_personal = mysql_query($sql_insert_personal) or die("Error in query:".$sql_insert_personal."<br>".mysql_error()."<br>".mysql_errno());
			
		}
		
		if($_FILES["emp_pic"]["name"] <> "")
		{
		
				$filename = $_FILES["emp_pic"]["name"];
				$file_arr = explode(".", $filename);
				$file_ext = strtolower($file_arr[sizeof($file_arr)-1]);
				if($file_ext=='jpg' || $file_ext=='gif' || $file_ext=='bmp' || $file_ext=='jpeg' )  
				{	 
					$filename=str_replace(" ","_",$filename);// Add _ inplace of blank space in file name, you can remove this line
					$time=time();
					$file=$time."_".$filename;
					$up_file = "employee_picture/".$file;   // upload directory path is set
					if(move_uploaded_file($_FILES['emp_pic']['tmp_name'], $up_file))     //  upload the file to the server
					{
						resize_image($up_file,'100','100','false',"employee_picture/thumb/".$file,'false','false');
						
						$flag = 1;
						$sql_insert = "update ".$mysql_table_prefix."employee_master set 
																						employee_picture = '$file'
																						where rec_id = '$emp_rec_id'";
						$result_insert = mysql_query($sql_insert) or die("Error in query:".$sql_insert."<br>".mysql_error()."<br>".mysql_errno());
					}
					else
					{
						$flag = 0;
						$msg ='error in upload image file';
					}
					
				}
				else
				{
					$flag = 0;
					$msg ='Please upload image file not '.$file_ext;
				}	
		 }
		
		 $mode='personal_detail';
	}
}	
		
if(isset($_POST['emp_family']))
{
	if($_POST['no_refresh'] == $_SESSION['no_refresh'])
	{	
		//echo "WARNING: Do not try to refresh the page.";
	}
	else
	{		
		$father_name = $_POST['father_name'];
		$Dependant_member1 = $_POST['Dependant_member1'];
		$mother_name = $_POST['mother_name'];
		$Dependant_member2 = $_POST['Dependant_member2'];
		$father_dob = getdbDate($_POST['father_dob']);
		$father_occupation = $_POST['father_occupation'];
		$mother_dob = getdbDate($_POST['mother_dob']);
		$mother_occupation = $_POST['mother_occupation'];
		$wife_name = $_POST['wife_name'];
		$Dependant_member3 = $_POST['Dependant_member3'];
		$wife_dob = getdbDate($_POST['wife_dob']);
		$wife_occupation = $_POST['wife_occupation'];

	   if($emp_family_edit=="")
		{
		
		 $sql_insert_family = "insert into ".$mysql_table_prefix."family_master  set 
																					emp_id = '".$_SESSION['emp_id']."',
																					father_name = '$father_name',
																					father_dob = '$father_dob',
																					Dependant_father = '$Dependant_member1',
																					father_occupation = '$father_occupation',
																					mother_name = '$mother_name',
																					mother_occupation = '$mother_occupation',
																					mother_dob = '$mother_dob',
																					Dependant_mother = '$Dependant_member2',
																					wife_name = '$wife_name',
																					Dependant_wife = '$Dependant_member3',
																					wife_dob = '$wife_dob',
																					wife_occupation = '$wife_occupation'";
																				
		$result_family = mysql_query($sql_insert_family) or die("Error in query:".$sql_insert_family."<br>".mysql_error()."<br>".mysql_errno());
		
		$emp_family = mysql_insert_id();
		
		}
		else
		{
		  $sql_insert_personal = "update ".$mysql_table_prefix."family_master  set 
																					father_name = '$father_name',
																					father_dob = '$father_dob',
																					Dependant_father = '$Dependant_member1',
																					father_occupation = '$father_occupation',
																					mother_name = '$mother_name',
																					mother_occupation = '$mother_occupation',
																					mother_dob = '$mother_dob',
																					Dependant_mother = '$Dependant_member2',
																					wife_name = '$wife_name',
																					Dependant_wife = '$Dependant_member3',
																					wife_dob = '$wife_dob',
																					wife_occupation = '$wife_occupation'
																					where emp_id = '$emp_family_edit'";
					
				$result_insert_personal = mysql_query($sql_insert_personal) or die("Error in query:".$sql_insert_personal."<br>".mysql_error()."<br>".mysql_errno());
			
		}
		
		$_SESSION['emp_family']=$_SESSION['emp_id'];
		 
		 $mode='family_detail';		
		 
	 }
}	 
if(isset($_POST['emp_education']))
{
	if($_POST['no_refresh'] == $_SESSION['no_refresh'])
	{	
		//echo "WARNING: Do not try to refresh the page.";
	}
	else
	{			
		$qualification = $_POST['qualification'];
		$university = $_POST['university'];
		$duration = $_POST['duration'];
		$percentage = $_POST['percentage'];

		if($emp_education_edit=="")
		{
		
		     $sql_insert_education = "insert into ".$mysql_table_prefix."education_master  set 
																								emp_id = '$emp_id',
																								qualification = '$qualification',
																								university = '$university',
																								duration = '$duration',
																								percentage = '$percentage'";
																				
			$result_family_education = mysql_query($sql_insert_education) or die("Error in query:".$sql_insert_education."<br>".mysql_error()."<br>".mysql_errno());
		
		}
		else
		{
			 $sql_insert_personal = "update ".$mysql_table_prefix."education_master  set 
																						qualification = '$qualification',
																						university = '$university',
																						duration = '$duration',
																						percentage = '$percentage' where emp_id = '$emp_education_edit'";
					
		    $result_insert_personal = mysql_query($sql_insert_personal) or die("Error in query:".$sql_insert_personal."<br>".mysql_error()."<br>".mysql_errno());
			
		}
		
		$_SESSION['emp_education']=$_SESSION['emp_id'];
		 $mode='education_detail';
	}
}

		/* $skill_name = $_POST['skill_name'];
		$experience = $_POST['experience'];

		
		$sql_insert_education = "insert into ".$mysql_table_prefix."skill_set  set 
			emp_id = '$emp_id',
			skills_name = '$skill_name',
			experience = '$experience'";
																				
		$result_family_education = mysql_query($sql_insert_education) or die("Error in query:".$sql_insert_education."<br>".mysql_error()."<br>".mysql_errno());
			*/

if(isset($_POST['emp_offical']))
{
	if($_POST['no_refresh'] == $_SESSION['no_refresh'])
	{	
		//echo "WARNING: Do not try to refresh the page.";
	}
	else
	{	
		$date_joining = getdbDate($_POST['date_joining']);
		$plant_name = $_POST['plant_name'];
		$department = $_POST['department'];
		$sub_department = $_POST['sub_department'];
		$grade = $_POST['grade'];
		$authority_name = $_POST['authority_name'];
		$pan_no = $_POST['pan_no'];
		$emp_type = $_POST['emp_type'];
		$emp_category = $_POST['emp_category'];
		$designation = $_POST['designation'];
					
		if($emp_offical_edit=="")
		{
		
		
		
		 $sql_insert_offical = "insert into ".$mysql_table_prefix."official_detail  set 
																						emp_id = '$emp_id',
																						date_joining = '$date_joining',
																						pan_no  = '$pan_no',
																						plant= '$plant_name',
																						department= '$sub_department',
																						grade = '$grade',
																						reporting_authority_name = '$authority_name',
																						designation = '$designation',
																						employee_typ = '$emp_type',
																						emp_category = '$emp_category',
																						InsertBy = '$grade',
																						InsertDate = now(),
																						IpAddress = '$ip'";
			
	    $result_insert_offical = mysql_query($sql_insert_offical) or die("Error in query:".$sql_insert_offical."<br>".mysql_error()."<br>".mysql_errno());


		$sql_insert_dept = "insert into ".$mysql_table_prefix."department_employee  set 
																						emp_id = '$emp_id',
																						dept_id = '$sub_department',
																						from_date = now()";
			
	   mysql_query($sql_insert_dept) or die("Error in query:".$sql_insert_dept."<br>".mysql_error()."<br>".mysql_errno());
	   
	   
	   $sql_insert_desi = "insert into ".$mysql_table_prefix."designation_employee  set 
																						emp_id = '$emp_id',
																						designation_id = '$designation',
																						from_date = now()";
			
	   mysql_query($sql_insert_desi) or die("Error in query:".$sql_insert_desi."<br>".mysql_error()."<br>".mysql_errno());
	   
	   }
	   else
	   {
	  	 	 $sql_insert_offical = "update ".$mysql_table_prefix."official_detail  set 
																							date_joining = '$date_joining',
																							plant= '$plant_name',
																							pan_no  = '$pan_no',
																							department= '$department',
																							grade = '$grade',
																							reporting_authority_name = '$authority_name',
																							designation = '$designation',
																							employee_typ = '$emp_type',
																							emp_category = '$emp_category',
																							InsertBy = '$grade',
																							InsertDate = now(),
																							IpAddress = '$ip' where emp_id = '$emp_education_edit'";

			
	    $result_insert_offical = mysql_query($sql_insert_offical) or die("Error in query:".$sql_insert_offical."<br>".mysql_error()."<br>".mysql_errno());


	     $sql_insert_dept = "update ".$mysql_table_prefix."department_employee  set 
																					dept_id = '$sub_department',
																					from_date = now() where emp_id = '$emp_education_edit'";

			
	   mysql_query($sql_insert_dept) or die("Error in query:".$sql_insert_dept."<br>".mysql_error()."<br>".mysql_errno());
	   
	   
	 	   $sql_insert_desi = "update ".$mysql_table_prefix."designation_employee  set 
																						designation_id = '$designation',
																						from_date = now() where emp_id = '$emp_education_edit'";

			
	   mysql_query($sql_insert_desi) or die("Error in query:".$sql_insert_desi."<br>".mysql_error()."<br>".mysql_errno());
		
		
	   }
	   
	   
	   
		
	   $_SESSION['emp_offical']=$_SESSION['emp_id'];
		
		$mode='offical_profile';
		
		

	}
}
if(isset($_POST['emp_salary']))
{
	if($_POST['no_refresh'] == $_SESSION['no_refresh'])
	{	
		//echo "WARNING: Do not try to refresh the page.";
	}
	else
	{			
		$basic = $_POST['basic'];
		$lta = $_POST['lta'];
		$convence = $_POST['convence'];
		$medical = $_POST['medical'];
		$hra = $_POST['hra'];
		$side_allowance = $_POST['side_allowance'];
		
		$p_tax = $_POST['p_tax'];
		$tds = $_POST['tds'];
		$advance = $_POST['advance'];
		$loan = $_POST['loan'];
		$other_gain = $_POST['other_gain'];	
		
				
		if($emp_salary_edit=="")
		{
			
		
		$sql_insert_education = "insert into ".$mysql_table_prefix."salary_master set 
			emp_id = '$emp_id',
			basic = '$basic',
			leave_travel_allow = '$lta',
			hra = '$hra',
			side_allowance = '$side_allowance',
			convence = '$convence',
			tds = '$other_gain',
			other_deductions = '$other_gain',
			medical = '$medical',
			professional_tax = '$p_tax',
			from_date = now(),
			InsertBy = '',
			InsertDate = now(),
			IpAddress = ''";
																				
		$result_family_education = mysql_query($sql_insert_education) or die("Error in query:".$sql_insert_education."<br>".mysql_error()."<br>".mysql_errno());
		
			$sql_loan= "insert into ".$mysql_table_prefix."loan_employee set 
																			emp_id = '$emp_id',
																			loan_amount = '$loan'";
																				
		mysql_query($sql_loan) or die("Error in query:".$sql_loan."<br>".mysql_error()."<br>".mysql_errno());
		
		$sql_advance= "insert into ".$mysql_table_prefix."advance_employee set 
			emp_id = '$emp_id',
			advance = '$advance',
			ad_date = now()";
																				
		mysql_query($sql_advance) or die("Error in query:".$sql_advance."<br>".mysql_error()."<br>".mysql_errno());	
		}
		else
		{
			$sql_insert_education = "update".$mysql_table_prefix."salary_master set 
																						basic = '$basic',
																						leave_travel_allow = '$lta',
																						hra = '$hra',
																						side_allowance = '$side_allowance',
																						convence = '$convence',
																						tds = '$other_gain',
																						other_deductions = '$other_gain',
																						medical = '$medical',
																						professional_tax = '$p_tax',
																						from_date = now(),
																						InsertBy = '',
																						InsertDate = now(),
																						IpAddress = '' where emp_id = '$emp_salary_edit'";
																				
		$result_family_education = mysql_query($sql_insert_education) or die("Error in query:".$sql_insert_education."<br>".mysql_error()."<br>".mysql_errno());
		
			$sql_loan= "update ".$mysql_table_prefix."loan_employee set 
																	    loan_amount = '$loan' where emp_id = '$emp_education_edit'";
																				
		mysql_query($sql_loan) or die("Error in query:".$sql_loan."<br>".mysql_error()."<br>".mysql_errno());
		
		$sql_advance= "update ".$mysql_table_prefix."advance_employee set 
																		advance = '$advance',
																		ad_date = now() where emp_id = '$emp_salary_edit'";
		}
		
		$_SESSION['emp_salary']=$_SESSION['emp_id'];	
		
		//unset($_SESSION['emp_id']);
		redirect('employee_detail.php?unset');
	}
}	
	
		/*if(($result_insert_1)&&($result_insert_2)&&($result_insert_3)&&($result_insert_4)&&($result_insert_5))		{
		redirect('index.php?err=3');
		}*/
	
?>
<?
if(isset($_GET['mode']))
	{
		 $mode=$_GET['mode'];
	}
?>
<script type="text/javascript">
function get_frm(str,str1,str2,str3)
{ 
	xmlHttp1=GetXmlHttpObject();
	if (xmlHttp1==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	} 
	
	document.getElementById(str2).innerHTML='<img src="images/loader.gif" border="0">';
	
	var url=str
	url=url+"?id="+str1+"&str="+str3;
	url=url+"&sid="+Math.random()
	xmlHttp1.onreadystatechange=function()
	{
		if (xmlHttp1.readyState==4 || xmlHttp1.readyState=="complete")
		{ 
			document.getElementById(str2).innerHTML=xmlHttp1.responseText;
		}
	};

	xmlHttp1.open("GET",url,true)
	xmlHttp1.send(null)
}

function get_frm1(str4,str5,str6,str7)
{ 
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	} 
	
	document.getElementById(str6).innerHTML='<img src="images/loader.gif" border="0">';
	
	var url=str4
	url=url+"?id="+str5+"&str="+str7;
	url=url+"&sid="+Math.random()
	xmlHttp.onreadystatechange=function()
	{
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{ 
			document.getElementById(str6).innerHTML=xmlHttp.responseText;
			document.getElementById('div_city').innerHTML='<input type="text" name="other_city" id="other_city" value="" class="inputfield">';
		}
	};

	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
}


function GetXmlHttpObject()
{ 
	var objXMLHttp=null
	if (window.XMLHttpRequest)
	{
		objXMLHttp=new XMLHttpRequest()
	}
	else if (window.ActiveXObject)
	{
		objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP")
	}
	return objXMLHttp
}

var xmlHttp=GetXmlHttpObject();
function check_email(str1,st){
		
	if(str1 != '')
   	{
		
		xmlHttp.open('get', 'check_email.php?id='+str1+'&st='+st);
		document.getElementById('div_email').innerHTML="<img src='images/loader.gif'>";
		xmlHttp.onreadystatechange = handleMail; 
		xmlHttp.send(null);
	}
}

function handleMail(){

	if(xmlHttp.readyState == 4){ 		
		var response = xmlHttp.responseText;
		

		if(response==0)
		{
		document.getElementById('div_email').innerHTML="This Email already exists.Please choose other email";
		document.getElementById('c_email').focus();
		document.getElementById('c_email').value='';
		}
		if(response==1)
		 {
			 document.getElementById('div_email').innerHTML="You can continue with this Email Id";
		 }
		
		
	}
}

function show_div(str)
{
	document.getElementById(str).style.display='block';
}

function close_div(str)
{
	document.getElementById(str).style.display='none';
}

function MM_openBrWindow(theURL,winName,features)
{ //v2.0

	window.open(theURL,winName,features);
}

function check_login_id(str1){
	if(str1 != '')
   	{   
		xmlHttp.open('get','check_login.php?id='+str1+'&act=username'+'&sid='+Math.random());
		document.getElementById('check_login').innerHTML="<img src='images/loader.gif'>";
		xmlHttp.onreadystatechange = handleusername; 
		xmlHttp.send(null);
	}

}
function handleusername(){
	if(xmlHttp.readyState == 4){ 		
	var response = xmlHttp.responseText;
		
 	 if(response==0)
	{
		document.getElementById('check_login').innerHTML="Login Id not available .Please choose other.";
		document.getElementById('login').focus();
		document.getElementById('login').value='';
	}
	else
	{
		 document.getElementById('check_login').innerHTML="Login Id available";
	}

	}

}
function numcheck(str)
{
	for(i=0;i<document.getElementById(str).value.length;i++)
	 {
		 var c = document.getElementById(str).value.substring(i,i+1);
		 if (isDigit(c) == false)
    	 {
			 document.getElementById(str).value=document.getElementById(str).value.substring(0,i);				
		  }

	 }
}
function isDigit(c)
{
	var test = "" + c;
	if (test == "0" || test == "1" || test == "2" || test == "3" || test == "4" || test == "5" || test == "6" || test == "7" || test == "8" || test == "9")
	{
		return true;
	}
	return false;

}
</script>

<script type="text/javascript" src="javascript/form.js"></script>
<script type="text/javascript" src="javascript/popup.js"></script>
<script language="JavaScript1.2">
function valid_customer(customer_reg)
{
	return(
				 checkString(customer_reg.elements["login"],"Login",false) &&
				 checkString(customer_reg.elements["password"],"Password",false) &&
				checkPassword(customer_reg.elements["password"],customer_reg.elements["re_password"],"Your password do not match",false) &&
				checkString(customer_reg.elements["comp_name"],"Company Name",false) &&
				checkString(customer_reg.elements["add"],"Postal Address",false) &&
				valid_customer1() &&
				//checkString(customer_reg.elements["state"],"State",false) &&
			 	//checkString(customer_reg.elements["city_select"],"City",false) &&
				//checkString(customer_reg.elements["pin"],"Pin",false) &&
				checkString(customer_reg.elements["c_name"],"Person Name",false) &&
				checkEmail(customer_reg.elements["c_email"],"Email Id",false) &&
				checkString(customer_reg.elements["t_country"],"Country Code",false) &&
				checkInteger(customer_reg.elements["t_area"],"Please Enter a valid Area Code.",false) &&
				checkInteger(customer_reg.elements["t_number"],"Please Enter a valid phone no.",false) &&
				checkString(customer_reg.elements["m_country"],"Mobile Country Code",false) &&
       			checkInteger(customer_reg.elements["m_number"],"Please Enter a valid Mobile no.",false) &&			
				checkVat(customer_reg.elements["vat"],"Not a valid Vat/Tin no",false) &&
				checkVat(customer_reg.elements["ecc"],"Not a valid ECC No",false) &&
				//checkString(customer_reg.elements["comm"],"Commissionerate",false) &&
				//checkString(customer_reg.elements["comm_div"],"Division",false) &&
				checkVat(customer_reg.elements["pan"],"Not a valid PAN No",false) &&
				checkString(customer_reg.elements["yearly"],"Yearly Comsumption",false)
				//checkcomsumption(customer_reg.elements["yearly"],"Not valid.Enter in a format(9.02) tones ",false)										
		   );
}


function valid_customer1()
{ 
	if(document.getElementById("password").value.length > 10)
	{
      Popup.showModal('modal',null,null,{'screenColor':'#99ff99','screenOpacity':.6},"Password Can Not Be More Than 10 Characters");      return false;
	}	
	if(document.getElementById("country").value != "99")
	{
		if(document.getElementById("txt_other_state").value=="")
		{
			Popup.showModal('modal',null,null,{'screenColor':'#99ff99','screenOpacity':.6},"Please Enter State");return false;
		}
		if(document.getElementById("city").value=="")
		{
			Popup.showModal('modal',null,null,{'screenColor':'#99ff99','screenOpacity':.6},"Please Enter City");return false;
		}
	}
	else
		{
			if(document.getElementById("state").value=="")
			{
				Popup.showModal('modal',null,null,{'screenColor':'#99ff99','screenOpacity':.6},"Please Enter State");return false;
			}
			if(document.getElementById("city_select").value=="")
			{
				Popup.showModal('modal',null,null,{'screenColor':'#99ff99','screenOpacity':.6},"Please Enter City");return false;
			}
		
		}
	return true;
}


</script>
<script>
function marriage_date(radio_value)
{
	text_box=document.getElementById("marr_date");
	if(radio_value.value=='no')
		{
			text_box.disabled=true;	
		}
	else
		{
			text_box.disabled=false;	
		}
}	
</script> 
<?
if(!isset($_SESSION['emp_id']))
	{
	$emp_id=0;
 	$sql = "SELECT emp_id  FROM  ".$mysql_table_prefix."employee_master";
	$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		while($row=mysql_fetch_array($result))
			{		
				$emp_id =$row['emp_id']+1;
			}
	}
	else
	{
		$emp_id =1000;
	}
	}
?>
<table width="98%" cellpadding="0" cellspacing="0" border="0" align="center">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/snb.php"); ?>
        </td>
        
        <td style="padding-left:5px; padding-top:5px;">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                    <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Employee Registration Form</td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td class="red"><?=$msg?></td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td style="vertical-align:top; padding-top:5px;">
                        <div class="simpleTabs">
                        <ul class="simpleTabsNavigation">
                        <li><a href="employee_detail.php?mode=" <? if($mode==''){ echo 'class="current"';}?>>Personal Detail</a></li>
                        <li><a <? if(isset($_SESSION['emp_id']) or isset($_GET['emp_id'])){ ?> href="employee_detail.php?mode=personal_detail"<? } if($mode=='personal_detail'){ echo 'class="current"';}?>>Family Detail</a></li>
                        <li><a <? if(isset($_SESSION['emp_id']) or isset($_GET['emp_id'])){ ?> href="employee_detail.php?mode=family_detail"<? } if($mode=='family_detail'){ echo 'class="current"';}?>>Education details</a></li>
                        <li><a <? if(isset($_SESSION['emp_id']) or isset($_GET['emp_id'])){ ?> href="employee_detail.php?mode=education_detail"<? } if($mode=='education_detail'){ echo 'class="current"';}?>>Official Profile</a></li>
                        <li><a <? if(isset($_SESSION['emp_id']) or isset($_GET['emp_id'])){ ?>href="employee_detail.php?mode=offical_profile"<? } if($mode=='offical_profile'){ echo 'class="current"';}?>>Salary details</a></li>
                        </ul>
                        <div <? if($mode==''){ echo 'class="current"';}else{echo 'class="simpleTabsContent"';}?>>
                    <form name="empolyee_profile" id="empolyee_profile" action="employee_detail.php" method="post" enctype="multipart/form-data" onSubmit="return valid_customer(this);">
                    <table width="100%" cellpadding="2" cellspacing="2" border="0" align="center" class="border" style="padding-top:10px;">
                        <tr>
                            <td width="100%" colspan="2" align="center">
                                <table cellpadding="0" cellspacing="0" border="0" align="center" class="loginbg">
                                    <tr>
                                        <td width="13%" class="text_1" style="padding-left:15px;">Empolyee Code</td>
                                      <td width="87%"><input type="text" name="emp_login" id="emp_login" readonly="readonly" style="width:150px; height:20px;" value="<?=$emp_id?>"></td>
                                        <!--<td style="padding-top:5px;"><div id="check_login"></div></td>-->
                                        <!--<td class="text_1" style="padding-top:0px;">Password<span class="red">*</span></td>
                                        <td><input type="password" name="password" id="password" style="width:150px; height:20px;"/></td>
                                        <td class="text_1" style="padding-top:0px;">Retype Password<span class="red">*</span></td>
                                        <td><input type="password" name="re_password" id="re_password" style="width:150px; height:20px;"/></td>-->
                                  </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <table width="100%" cellpadding="2" cellspacing="2" class="border" border="0">
                                    <tr>
                                        <td class="text_1">First Name<span class="red">*</span></td>
                                        <td align="left" style="padding-top:5px;"><input type="text" name="first_name" id="first_name" style="width:150px; height:20px;" value="<?=$first_name?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">Last Name<span class="red">*</span></td>
                                        <td align="left" style="padding-top:5px;"><input type="text" name="last_name" id="last_name" style="width:150px; height:20px;" value="<?=$last_name?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="text_1" valign="top">Address<span class="red">*</span></td>
                                        <td align="left" style="padding-top:5px;"><textarea name="address" id="address" rows="3" cols="30" style="height:80px;"><?=$address?></textarea></td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">Country<span class="red">*</span></td>
                                        <td align="left">
                                            <?
                                            $sql = "SELECT * FROM mpc_countries order by countries_name";
                                            $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
                                            ?>
                                            <select name="country" id="country" onChange="get_frm1('get_state.php',this.value,'div_add_state','state');">
                                            <option value="">-select country-</option>
                                            <? 
                                            
                                            while ($row=mysql_fetch_array($result))
                                            {	?>
                                            <option value="<?=$row['countries_id']?>" <? if($row['countries_id']==$country){?> selected="selected" <? } ?>><?=$row["countries_name"]?></option>
                                            <?  }	?>
                                            </select>
                                           
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">State<span class="red">*</span></td>
                                        <td align="left"><div id="div_add_state">
                                            <?
											if($other_state=="0")
											{
											 $sql = "SELECT * FROM mpc_state_master where country_id = '99' order by state_name";
                                            $result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
                                            ?>
                                            <select name="state" id="state" onChange="get_frm('get_city_reg.php',this.value,'div_city','city_select');">
                                            <option value="">--select state--</option>
                                            <? 
                                            while ($row=mysql_fetch_array($result))
                                            {
                                            ?>
                                            <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$state){?> selected="selected" <? } ?>>
                                            <?=$row["state_name"]?>
                                            </option>
                                            <?
                                            }
                                            ?>
                                            </select>
                                             <?
												}
												else
												{
											?>
                                            <input type="text" name="txt_other_state" id="txt_other_state" value="<?=$other_state?>">
                                            <?
												}
											?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">City<span class="red">*</span></td>
                                        <td align="left">
                                            <div id="div_city">
                                            <?
											if($other_city=="0")
											{
                                            $sql = "SELECT * FROM  ".$mysql_table_prefix."city_master order by city_name ";
$result_city = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
											?>
                                            <select name="city_select" id="city_select">
                                            <option value="">--select city--</option>
                                            <? 
                                            while ($row=mysql_fetch_array($result_city))
                                            {
                                            ?>
                                            <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$city){?> selected="selected" <? } ?>>
                                            <?=$row["city_name"]?>
                                            </option>
                                            <?
                                            }
                                            ?>
                                            </select>
                                            <?
												}
												else
												{
											?>
                                            <input type="text" name="other_city" id="other_city" value="<?=$other_city?>">	
                                            <?   
												}
											?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">Pin Code<span class="red">*</span></td>
                                        <td align="left"><input type="text" name="pin_code" id="pin_code" style="width:150px; height:20px;" value="<?=$pincode?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">Date Of Birth<span class="red">*</span></td>
                                        <td align="left"><input type="text" name="dob" id="dob" style="width:150px; height:20px;" value="<?=getDatetime($dob)?>"/>
                                        <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.empolyee_profile.dob);" HIDEFOCUS><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a>
                                        </td>
                                    </tr>                    
                                </table>
                            </td>
                            <td width="50%" valign="top">
                                <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border" border="0">
                                    <tr>
                                        <td width="43%" class="text_1">Gender<span class="red">*</span></td>
                                      <td width="57%" align="left" class="text_1" style="padding-left:0px;">
                                      <?=$gender?>
                                       	<input type="radio" id="gender" name="gender" value="Male" <? if($gender=='male') {?>checked="checked"<? }?>/>Male
                                        <input type="radio" id="gender" name="gender" value="Female"<? if($gender=='female'){ ?>checked="checked"<? }?>/>Female
                                        </td>
                                  </tr>
                                    <tr>
                                        <td class="text_1">Phone<span class="red">*</span></td>
                                        <td align="left"><input type="text" name="phone_no" id="phone_no" style="width:150px; height:20px;" value="<?=$phone_no?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">Email Id<span class="red">*</span></td>
                                        <td align="left"><input type="text" name="email_id" id="email_id" style="width:150px; height:20px;" value="<?=$email_id?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">Marital Status<span class="red">*</span></td>
                                        <td align="left" class="text_1" style="padding-left:0px;">
                                        	<input type="radio" id="marital" name="marital" value="yes" onClick="marriage_date(this)" <? if($marital_status =='yes'){ ?>checked="checked"<? }?>/>Married
                                            <input type="radio" id="marital" name="marital" value="no" onClick="marriage_date(this)" <? if($marital_status =='no'){ ?>checked="checked"<? }?>/>Single
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">if Married then date of Marriage<span class="red">*</span></td>
                                        <td align="left"><input type="text" name="marr_date" id="marr_date" disabled="disabled" style="width:150px; height:20px;" value="<?=$marriage_date?>"/><a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.empolyee_profile.marr_date);" HIDEFOCUS><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a></td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">Blood Group<span class="red">*</span></td>
                                        <td align="left"><select name="blood_group" id="blood_group">
                                            <option value="">---Select---</option>
                                            <option value="O-" <? if($blood_group=='O-'){echo 'selected="selected"';}?> >O-</option>
                                            <option value="O+" <? if($blood_group=='O+'){echo 'selected="selected"';}?>>O+</option>
                                            <option value="A-" <? if($blood_group=='A-'){echo 'selected="selected"';}?>>A-</option>
                                            <option value="A+" <? if($blood_group=='A+'){echo 'selected="selected"';}?>>A+</option>
                                            <option value="B-" <? if($blood_group=='B-'){echo 'selected="selected"';}?>>B-</option>
                                            <option value="B+" <? if($blood_group=='B+'){echo 'selected="selected"';}?>>B+</option>
                                            <option value="AB-" <? if($blood_group=='AB-'){echo 'selected="selected"';}?>>AB-</option>
                                            <option value="AB+"  <? if($blood_group=='AB+'){echo 'selected="selected"';}?>>AB+</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">Religion<span class="red">*</span></td>
                                        <td align="left"><input type="text" name="religion" id="religion" style="width:150px; height:20px;" value="<?=$religion?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">Nationality</td>
                                        <td align="left"><input type="text" name="nationality" id="nationality" style="width:150px; height:20px;" value="<?=$nationality?>"/></td>
                                    </tr> 
                                    <tr>
                                        <td class="text_1">Reference</td>
                                        <td align="left"><input type="text" name="reference" id="reference" style="width:150px; height:20px;" value="<?=$reference?>"/></td>
                                    </tr>  
                                    <tr>
                                        <td class="text_1">Employee picture<span class="red">*</span></td>
                                        <td align="left"><input type="file" name="emp_pic" id="emp_pic" style="width:150px; height:20px;"/></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center;">
                                <input type="submit"  value="Submit" name="Submit_emp" id="Submit_emp"/>
                                <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                            </td>
                        </tr>
                    </table>
                    </form>
                    </div>
                    
                    <div <? if($mode=='personal_detail'){ echo 'class="current"';}else{echo 'class="simpleTabsContent"';}?>>
                    <form name="empolyee_family" id="empolyee_family" action="employee_detail.php" method="post" enctype="multipart/form-data" onSubmit="return valid_customer(this);">
                    <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border" border="0" style="padding-top:10px">
                        <tr>
                            <td width="50%" valign="top">
                                <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                                    <tr>
                                        <td class="text_1" width="35%">Father Name <span class="red">*</span></td>
                                        <td align="left" width="65%"><input type="text" name="father_name" id="father_name" style="width:150px; height:20px;" value="<?=$father_name?>"/></td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="text_1">Depended<span class="red">*</span></td>
                                        <td align="left" class="text_1" style="padding-left:0px;">
                                        	<input type="radio" id="Dependant_member1" name="Dependant_member1" value="Yes" <? if($Dependant_father=='Yes'){ ?>checked="checked"<? }?>/>Yes
                                            <input type="radio" id="Dependant_member1" name="Dependant_member1" value="No" <? if($Dependant_father=='No'){ ?>checked="checked"<? }?>/>No
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">Mother Name <span class="red">*</span></td>
                                        <td align="left"><input type="text" name="mother_name" id="mother_name" style="width:150px; height:20px;" value="<?=$mother_name?>"/></td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="text_1">Depended<span class="red">*</span></td>
                                        <td align="left" class="text_1" style="padding-left:0px;">
                                        	<input type="radio" id="Dependant_member2" name="Dependant_member2" value="Yes"<? if($Dependant_mother=='Yes'){ ?>checked="checked"<? }?>/>Yes 
                                            <input type="radio" id="Dependant_member2" name="Dependant_member2" value="No"<? if($Dependant_mother=='No'){ ?>checked="checked"<? }?>/>No
                                        </td>
                                    </tr>
                                     <tr>
                                        <td class="text_1">Wife Name <span class="red">*</span></td>
                                        <td align="left"><input type="text" name="wife_name" id="wife_name" style="width:150px; height:20px;" value="<?=$wife_name?>"/></td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="text_1">Depended<span class="red">*</span></td>
                                        <td align="left" class="text_1" style="padding-left:0px;">
                                        	<input type="radio" id="Dependant_member3" name="Dependant_member3" value="Yes"<? if($Dependant_wife =='Yes'){ ?>checked="checked"<? }?>/>Yes 
                                            <input type="radio" id="Dependant_member3" name="Dependant_member3" value="No"<? if($Dependant_wife =='No'){ ?>checked="checked"<? }?>/>No
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td width="50%" valign="top">
                                <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                                    <tr>
                                        <td class="text_1" width="35%">Date of Birth<span class="red">*</span></td>
                                        <td align="left" width="65%"><input type="text" name="father_dob" id="father_dob" style="width:150px; height:20px;" value="<?=$father_dob?>"/>
                                         <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.empolyee_family.father_dob);" HIDEFOCUS><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">Occupation</td>
                                        <td align="left"><input type="text" name="father_occupation" id="father_occupation" style="width:150px; height:20px;" value="<?=$father_occupation?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">Date of Birth <span class="red">*</span></td>
                                        <td align="left"><input type="text" name="mother_dob" id="mother_dob" style="width:150px; height:20px;" value="<?=$mother_dob?>"/>
                                         <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.empolyee_family.mother_dob);" HIDEFOCUS><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a>
                                        </td>
                                    </tr>
                                     <tr>
                                        <td class="text_1">Occupation</td>
                                        <td align="left"><input type="text" name="mother_occupation" id="mother_occupation" style="width:150px; height:20px;" value="<?=$mother_occupation?>"/></td>
                                    </tr>
                                     <tr>
                                        <td class="text_1">Date of Birth <span class="red">*</span></td>
                                        <td align="left"><input type="text" name="wife_dob" id="wife_dob" style="width:150px; height:20px;" value="<?=$wife_dob?>"/>
                                         <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.empolyee_family.wife_dob);" HIDEFOCUS><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">Occupation</td>
                                        <td align="left"><input type="text" name="wife_occupation" id="wife_occupation" style="width:150px; height:20px;" value="<?=$wife_occupation?>"/></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center;">
                                <input type="submit"  value="Submit" name="emp_family" id="emp_family"/>
                                <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                            </td>
                        </tr>
                    </table>
                    </form>
                    </div>
                    
                    <div <? if($mode=='family_detail'){ echo 'class="current"';}else{echo 'class="simpleTabsContent"';}?>>
                    <form name="empolyee_eduction" id="empolyee_eduction" action="employee_detail.php" method="post" enctype="multipart/form-data" onSubmit="return valid_customer(this);">
                    <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border" border="0"  style="padding-top:10px;">
                        <tr>
                            <td width="50%" valign="top">
                                <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                                    <tr>
                                        <td class="text_1">Qualification<span class="red">*</span></td>
                                        <td align="left"><input type="text" name="qualification" id="qualification" style="width:150px; height:20px;" value="<?=$qualification?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">University  <span class="red">*</span></td>
                                        <td class="text_2" align="left"><input type="text" name="university" id="university" style="width:150px; height:20px;" value="<?=$university?>"/></td>
                                    </tr>
                                </table>
                            </td>
                            <td width="50%" valign="top">
                                <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                                    <tr>
                                        <td class="text_1">Couse Duration</td>
                                        <td align="left"><input type="text" name="duration" id="duration" style="width:150px; height:20px;" value="<?=$duration?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">Percentage </td>
                                        <td align="left"><input type="text" name="percentage" id="percentage" style="width:150px; height:20px;" value="<?=$percentage?>"/></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center;">
                                <input type="submit"  value="Submit" name="emp_education" id="emp_education"/>
                                <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                            </td>
                        </tr>
                    </table>
                    </form>
                    </div>
                    
                    <div <? if($mode=='education_detail'){ echo 'class="current"';}else{echo 'class="simpleTabsContent"';}?>>
                    <form name="offical_profile" id="offical_profile" action="employee_detail.php" method="post" enctype="multipart/form-data" onSubmit="return valid_customer(this);">
                    <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border" border="0" style="padding-top:10px;">
                        <tr>
                            <td width="50%" valign="top">
                                <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                                    <tr>
                                        <td class="text_1">Date of Joining<span class="red">*</span></td>
                                        <td align="left"><input type="text" name="date_joining" id="date_joining" style="width:150px; height:20px;" value="<?=$date_joining?>"/>
                                         <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.offical_profile.date_joining);" HIDEFOCUS><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">Plant<span class="red">*</span></td>
                                        <td  align="left">
                                        <?
													 $sql = "SELECT * FROM mpc_plant_master order by plant_name";
													 $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
                                                     ?>
                                        		<select name="plant_name" id="plant_name" style="width:150px; height:20px;">
                                                	<option value="">Select</option>
                                                     <?
                                                  while ($row=mysql_fetch_array($result))
													{	?>
														   <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$plant){?> selected="selected" <? } ?>><?=$row["plant_name"]?></option>
													<?  }	?>
                                                </select>
                                       </td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">Department<span class="red">*</span></td>
                                        <td align="left">
                                        			<?
													 $sql = "SELECT * FROM mpc_department_master where reference_id='0' order by department_name";
													 $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
                                                     ?>
                                        		<select name="department" id="department" style="width:150px; height:20px;" onChange="get_frm('get_department.php',this.value,'div_sub_dept','sub_department');">
                                                	<option value="">Select</option>
                                                     <?
                                                  while ($row=mysql_fetch_array($result))
													{	?>
														   <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$dep){?> selected="selected" <? } ?>><?=$row["department_name"]?></option>
													<?  }	?>
                                                </select>
                                        </td>
                                    </tr>
                                     <tr>
                                        <td class="text_1">Sub Department<span class="red">*</span></td>
                                        <td align="left">
                                        	<div id="div_sub_dept">
                                        			<?
													 $sql = "SELECT * FROM mpc_department_master where reference_id !='0' order by department_name";
													 $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
                                                     ?>
                                        		<select name="sub_department" id="sub_department" style="width:150px; height:20px;" onchange="">
                                                	<option value="">Select</option>
                                                     <?
                                                  while ($row=mysql_fetch_array($result))
													{	?>
														   <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$dept_id){?> selected="selected" <? } ?>><?=$row["department_name"]?></option>
													<?  }	?>
                                                </select>
                                                </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">Reporting Authority name<span class="red">*</span></td>
                                        <td align="left"><input type="text" name="authority_name" id="authority_name" style="width:150px; height:20px;" value="<?=$reporting_authority_name?>"/></td>
                                    </tr>
                                </table>
                            </td>
                            <td width="50%" valign="top">
                                <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                                	<tr>
                                        <td class="text_1">Grade<span class="red">*</span></td>
                                        <td align="left"><input type="text" name="grade" id="grade" style="width:150px; height:20px;" value="<?=$grade?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">PAN No.</td>
                                        <td align="left"><div id="div_add_div"><input type="text" name="pan_no" id="pan_no" style="width:150px; height:20px;" value="<?=$pan_no?>"/></div></td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">Employee Type<span class="red">*</span></td>
                                        <td align="left">
                                        	<select name="emp_type" id="emp_type">
                                            	<option value="fix_salary" <? if($employee_typ=='fix_salary'){ echo 'selected="selected"';} ?> >Fix Salary</option>
                                                <option value="daily_wages" <? if($employee_typ=='daily_wages'){ echo 'selected="selected"';} ?>>Daily Wages</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">Employee Catagory<span class="red">*</span></td>
                                        <td align="left">
                                        <select  name="emp_category" id="emp_category" onChange="get_frm('get_designation.php',this.value,'designation_div','designation');">
                                            	<option value="staff" <? if($emp_category=='staff'){ echo 'selected="selected"';}?>>Staff</option>
                                                <option value="worker" <? if($emp_category=='worker'){ echo 'selected="selected"';}?>>Worker</option>
                                            </select>                                      
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">Designation<span class="red">*</span></td>
                                        <td align="left">
                                        <div id="designation_div">
                                        <?
													 $sql = "SELECT * FROM mpc_designation_master";
													 $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
                                                     ?>
                                        		<select name="designation" id="designation" style="width:150px; height:20px;">
                                                	<option value="">Select</option>
                                                     <?
                                                  while ($row=mysql_fetch_array($result))
													{	?>
														   <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$designation){?> selected="selected" <? } ?>><?=$row["designation_name"]?></option>
													<?  }	?>
                                                </select>
                                        </div>        
                                                </td>
                                    </tr>
                                </table>
                            </td>
                        </tr> 
                        <tr>
                            <td colspan="2" style="text-align:center;">
                                <input type="submit"  value="Submit" name="emp_offical" id="emp_offical"/>
                                <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                            </td>
                        </tr>                                                   
                    </table>
                    </form>
                    </div>
                    <div <? if($mode=='offical_profile'){ echo 'class="current"';}else{echo 'class="simpleTabsContent"';}?>>
                    <form name="salary_detail" id="salary_detail" action="employee_detail.php" method="post" enctype="multipart/form-data" onSubmit="return valid_customer(this);">
                    <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border" border="0" style="padding-top:10px;">
                        <tr>
                            <td width="50%" valign="top">
                                <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                                    <tr>
                                        <td class="text_1">Basic<span class="red">*</span></td>
                                        <td align="left"><input type="text" name="basic" id="basic" style="width:150px; height:20px;" value="<?=$basic?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">LTA<span class="red">*</span></td>
                                        <td align="left"><input type="text" name="lta" id="lta" style="width:150px; height:20px;" value="<?=$leave_travel_allow?>"/></td>
                                  </tr>
                                    <tr>
                                        <td class="text_1">Convence<span class="red">*</span></td>
                                        <td align="left"><input type="text" name="convence" id="convence" style="width:150px; height:20px;" value="<?=$convence?>"/></td>
                                    </tr>
                                     <tr>
                                        <td class="text_1">Medical<span class="red">*</span></td>
                                        <td align="left"><input type="text" name="medical" id="medical" style="width:150px; height:20px;" value="<?=$medical?>"/></td>
                                    </tr> 
                                    <tr>
                                        <td class="text_1">HRA<span class="red">*</span></td>
                                        <td align="left"><input type="text" name="hra" id="hra" style="width:150px; height:20px;" value="<?=$hra?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">Side Allowance<span class="red">*</span></td>
                                        <td align="left"><input type="text" name="side_allowance" id="side_allowance" style="width:150px; height:20px;" value="<?=$side_allowance?>"/></td>
                                    </tr>                                                                 
                                </table>
                          </td>
                            <td width="50%" valign="top">
                                <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                                    <tr>
                                        <td class="text_1">Professional Tax</td>
                                        <td align="left"><input type="text" name="p_tax" id="p_tax" style="width:150px; height:20px;" value="<?=$professional_tax?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">TDS<span class="red">*</span></td>
                                        <td align="left"><input type="text" name="tds" id="tds" style="width:150px; height:20px;" value="<?=$tds?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">Advance<span class="red">*</span></td>
                                        <td align="left"><input type="text" name="advance" id="advance" style="width:150px; height:20px;" value="<?=$advance?>"/></td>
                                    </tr>
                                     <tr>
                                        <td class="text_1">Loan<span class="red">*</span></td>
                                        <td align="left"><input type="text" name="loan" id="loan" style="width:150px; height:20px;" value="<?=$loan?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">Other Deduction's<span class="red">*</span></td>
                                        <td align="left"><input type="text" name="other_gain" id="other_gain" style="width:150px; height:20px;" value="<?=$other_deductions?>"/></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center;">
                                <input type="submit"  value="Submit" name="emp_salary" id="emp_salary"/>
                                <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                            </td>
                        </tr>
                    </table>   
                    </form>
                    </div>
                    </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<DIV id=modal style="DISPLAY: none;">
  <div style="padding: 0px; background-color: rgb(37, 100, 192); visibility: visible; position: relative; width: 222px; height: 202px; z-index: 10002; opacity: 1;">
    <div onClick="Popup.hide('modal')" style="padding: 0px; background: transparent url(./images/close.gif) no-repeat scroll 0%; visibility: visible; position: absolute; left: 201px; top: 1px; width: 20px; height: 20px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; cursor: pointer; z-index: 10004;" id="adpModal_close"></div>
    <div style="padding: 0px; background: transparent url(resize.gif) no-repeat scroll 0%; visibility: visible; position: absolute; width: 9px; height: 9px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; cursor: nw-resize; z-index: 10003;" id="adpModal_rsize"></div>
    <div style="padding: 0px; overflow: hidden; background-color: rgb(140, 183, 231); visibility: visible; position: absolute; left: 1px; top: 1px; width: 220px; height: 20px; font-family: arial; font-style: normal; font-variant: normal; font-weight: bold; font-size: 9pt; line-height: normal; font-size-adjust: none; font-stretch: normal; color: rgb(15, 15, 15); cursor: move;" id="adpModal_adpT"></div>
    <div style="border-style: inset; border-width: 0px; padding: 8px; overflow: hidden; background-color: rgb(118, 201, 238); visibility: visible; position: absolute; left: 1px; top: 21px; width: 204px; height: 164px; font-family: MS Sans Serif; font-style: normal; font-variant: normal; font-weight: bold; font-size: 11pt; line-height: normal; font-size-adjust: none; font-stretch: normal; color: rgb(28, 94, 162);" id="adpModal_adpC">
      <center>
        <p>
        <div id="div_message"></div>
        </p>
        <p style="font-size: 10px; color: rgb(253, 80, 0);">To gain access to the page behind the popup must be closed</p>
      </center>
    </div>
  </div>
</DIV>   
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:5000; position:absolute; left:-500px; top:0px;">
</iframe> 
<? include ("inc/hr_footer.php"); ?>	