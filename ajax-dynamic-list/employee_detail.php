<? $pgName = ""; ?>
<? include("inc/hr_header.php"); ?>
<?
include("inc/dbconnection.php");
?>
<style type="text/css" media="screen">
@import "tab/css/style.css";
@import "tab/css/simpletabs.css";
</style>
<body onLoad="sum_salary()">
<?
$first_name ="";	
$last_name="";	
$address="";	
$country ="";	
$state ="";	
$other_state  ="";	
$city ="";	
$other_city ="";	
$dob ="";	
$gender ="male";	
$phone_no  ="";	
$email_id ="";	
$employee_picture ="";	
$marital_status="no";
$marriage_date="";	
$blood_group ="";		
$religion ="";			
$nationality  ="";		
$reference ="";	
$pincode="";	
$emp_edit_id="";	
if(isset($_GET['unset']))
{
	
	unset($_SESSION['emp_id']);
	unset($_SESSION['emp_family']);
	unset($_SESSION['emp_education']);
	unset($_SESSION['emp_offical']);
	unset($_SESSION['emp_salary']);
	unset($_SESSION['marital_sta']);
	$ticket_no="";
}
if(isset($_GET['emp_id']))
{	
	$emp_edit_id=$_GET['emp_id'];
	
	$_SESSION['emp_id']=$emp_edit_id;

	$_SESSION['emp_family']=$emp_edit_id;
	$_SESSION['emp_education']=$emp_edit_id;
	$_SESSION['emp_offical']=$emp_edit_id;
	$_SESSION['emp_salary']=$emp_edit_id;

}

	if(isset($_SESSION['emp_id']))
		{
			$emp_edit_id=$_SESSION['emp_id'];
			
		    $sql = "SELECT * FROM ".$mysql_table_prefix."employee_master where rec_id = '$emp_edit_id'";
			$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());	
			if(mysql_num_rows($result)>0)
				{	
					$row = mysql_fetch_array($result);
					
					$ticket_no =$row['ticket_no'];	
			$empType =$row['empType'];	
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
$Dependant_father ="Yes";
$father_occupation  ="";
$mother_name  ="";
$mother_occupation  ="";
$mother_dob ="";
$Dependant_mother  ="Yes";	
$wife_name ="";
$wife_dob  ="";
$Dependant_wife ="Yes";
$wife_occupation  ="";		
$emp_family_edit="";	

		if(isset($_SESSION['emp_family']))
		{
			$emp_family_edit=$_SESSION['emp_family'];
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
				
		if(isset($_SESSION['emp_education']))
		{
			$emp_education_edit=$_SESSION['emp_education'];
			
			$sql = "SELECT * FROM ".$mysql_table_prefix."education_master where emp_id = '$emp_education_edit'";
			$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());	
			if(mysql_num_rows($result)>0)
				{	
					$row = mysql_fetch_array($result);
					$qualification  =$row['qualification'];	
					$university   =$row['university'];
					$duration  =$row['duration'];
					$percentage =$row['percentage'];
					$hscyear =$row['hscyear'];
					$hscboard =$row['hscboard'];
					$hscsubject =$row['hscsubject'];
					$hscpercentage =$row['hscpercentage'];
					$diplomaqualification =$row['diplomaqualification'];
					$diplomayear =$row['diplomayear'];
					$diplomauniversity =$row['diplomauniversity'];
					$diplomaduration =$row['diplomaduration'];
					$diplomapercentage =$row['diplomapercentage'];
					$graduationqualification =$row['graduationqualification'];
					$graduationpassingyear =$row['graduationpassingyear'];
					$graduationuniversity =$row['graduationuniversity'];
					$grdurationDuration =$row['grdurationDuration'];
					$graduationpercentage =$row['graduationpercentage'];
					$mastergraduationqualification =$row['mastergraduationqualification'];
					$mastergraduationpassingyear =$row['mastergraduationpassingyear'];
					$mastergraduationuniversity =$row['mastergraduationuniversity'];
					$mastergraduationduration =$row['mastergraduationduration'];
					$mastergraduationpercentage =$row['mastergraduationpercentage'];
										
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
$designation_id="";
$designation="";
				
		if(isset($_SESSION['emp_offical']))
		{
			$emp_offical_edit=$_SESSION['emp_offical'];
			
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
					$skill_level =$row['skill_level'];	
					$reporting_authority_name =$row['reporting_authority_name'];						
				}
				
				// get pf details
$sql = "SELECT * FROM  mpc_account_detail where emp_id  = '$emp_offical_edit'";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result)>0)
{
	while($row = mysql_fetch_array($result))
	{
		$pf_number=$row['pf_number'];
		$pf_nominee=$row['pf_nominee'];
		$pf_rate=$row['pf_rate'];
		$pf_relationship=$row['pf_relationship'];
		$esic_rate=$row['esic_rate'];
		$esic_number=$row['esic_number'];
		$esic_nominee=$row['esic_nominee'];
		$esic_relationship=$row['esic_relationship'];
		$account_no = $row['account_no'];
		$bank_name = $row['bank_name'];
		$payment_mode = $row['payment_mode'];
	} 
}
				//
				
				
			$sql = "SELECT * FROM ".$mysql_table_prefix."department_employee where emp_id = '$emp_offical_edit' and to_date='00-00-0000'";
			$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());	
			if(mysql_num_rows($result)>0)
				{	
					$row = mysql_fetch_array($result);
					$dept_id =$row['dept_id'];		
					$dep=getdeptDetail('reference_id','rec_id',$dept_id);		
				}
			$sql = "SELECT * FROM ".$mysql_table_prefix."designation_employee where emp_id = '$emp_offical_edit' and to_date='00-00-0000'";
			$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());	
			if(mysql_num_rows($result)>0)
				{	
					$row = mysql_fetch_array($result);
					$designation_id =$row['designation_id'];		
					$emp_category=getdesignationMaster('emp_category','rec_id', $designation_id);		
				}
				
	$sql = "SELECT * FROM  mpc_shift_detail where emp_id = '$emp_offical_edit' and to_date='0000-00-00'";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result)>0)
{
	while($row = mysql_fetch_array($result))
	{
		$shift=$row['shift'];
	} 
}
$sql = "SELECT * FROM  mpc_weekly_off_employee where emp_id = '$emp_offical_edit' and to_date='0000-00-00'";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result)>0)
{
	while($row = mysql_fetch_array($result))
	{
		$off_day=$row['off_day']; 	
	} 
}
$sql = "SELECT * FROM  mpc_rotation_type_employee where emp_id = '$emp_offical_edit' and to_date='0000-00-00'";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result)>0)
{
	while($row = mysql_fetch_array($result))
	{
		$rotation_type=$row['rotation_type']; 	

	} 
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
				
		if(isset($_SESSION['emp_salary']))
		{
			$emp_offical_edit=$_SESSION['emp_salary'];
			
			$sql = "SELECT * FROM ".$mysql_table_prefix."salary_master where emp_id = '$emp_offical_edit' and to_date='0000-00-00'";
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
					$celling = $row['celling'];		
					$bonus = $row['bonus'];
					$graduity =$row['graduity'];
					$total_deduction = $row['total_deduction'];
					$take_home = $row['take_home'];
					$total_salary = $row['total_salary'];
					$phone =$row['phone'];				
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
		$emp_login = sprintf("%04d",$_POST['emp_login']);
		
		/*$password = $_POST['password'];
		$sql_insert_login = "insert into ".$mysql_table_prefix."login_master  set 
			UserName = '$emp_login',
			Password = '$password',
			UserType = 'Empolyee',
			IsActive = '0',
			InsertDate= now()";																				
		$result_login = mysql_query($sql_insert_login) or die("Error in query:".$sql_insert_login."<br>".mysql_error()."<br>".mysql_errno());
		$emp_id = mysql_insert_id();*/
$empType = $_POST['empType'] == 2 ? 'worker' : 'Staff';
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
		$_SESSION['marital_sta']=$marital;
		$marr_date = getdbDate(isset($_POST['marr_date']) ? $_POST['marr_date']:"");
		$blood_group = $_POST['blood_group'];
		$nationality = $_POST['nationality'];
		$reference = $_POST['reference'];
		$religion = $_POST['religion'];

		if($emp_edit_id=="")
		{
		$sql_insert_personal = "insert into ".$mysql_table_prefix."employee_master  set 
																						emp_id = '$emp_login',
																						ticket_no='$emp_login',
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
		$_SESSION['emp_id']=$emp_rec_id;
		
		$sql_insert_personal = "insert into ".$mysql_table_prefix."account_detail  set 
																						emp_id = '$emp_rec_id',
																						date_releaving='0000-00-00'";
			
	    $result_insert_personal = mysql_query($sql_insert_personal) or die("Error in query:".$sql_insert_personal."<br>".mysql_error()."<br>".mysql_errno());
		
	    $sql_insert = "update ".$mysql_table_prefix."employee_master set 
																			emp_id = '$emp_rec_id'
																			where rec_id = '$emp_rec_id'";
		$result_insert = mysql_query($sql_insert) or die("Error in query:".$sql_insert."<br>".mysql_error()."<br>".mysql_errno());
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
																							reference = '$reference' where rec_id = '$emp_edit_id'";
					
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
		$child_name=$_POST['child_name'];
		$child_gender=$_POST['child_gender'];
		$child_dependent=$_POST['child_dependent'];
		$child_dob=$_POST['child_dob'];
	   
	   
	   
	   
	   if($emp_family_edit=="")
		{
			if(isset($_POST['child_name'])){$count=count($_POST['child_name']);}

			for($i=0; $i<$count; $i++)
			{
			echo 	$child_name=$_POST['child_name'][$i];
		    echo    $child_gender=$_POST['child_gender'.$i][0];
		    echo    $child_dependent=$_POST['child_dependent'.$i][0];
		    echo    $child_dob=$_POST['child_dob'][$i];
			
			 $sql_insert_family="insert into ".$mysql_table_prefix."family_master  set 
			 emp_id = '".$_SESSION['emp_id']."',
			 child_name='$child_name',
			 child_gender='$child_gender',
			 child_dependent='$child_dependent',
			 child_dob='$child_dob'";
			 
			 echo "***********qery";
			 echo $sql_insert_family;
			
			$result_family = mysql_query($sql_insert_family) or die("Error in query:".$sql_insert_family."<br>".mysql_error()."<br>".mysql_errno());
				
	     	}
		//die();
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
		  if(checkEmpTable($emp_family_edit,$mysql_table_prefix.'family_master')!=1)
		  	{
				 $sql_insert_family = "insert into ".$mysql_table_prefix."family_master  set 
																					      emp_id = '".$emp_family_edit."'";
																				
		$result_family = mysql_query($sql_insert_family) or die("Error in query:".$sql_insert_family."<br>".mysql_error()."<br>".mysql_errno());
			}
		  
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
					$hscyear =$_POST['hscyear'];
					$hscboard =$_POST['hscboard'];
					$hscsubject =$_POST['hscsubject'];
					$hscpercentage =$_POST['hscpercentage'];
					$diplomaqualification =$_POST['diplomaqualification'];
					$diplomayear =$_POST['diplomayear'];
					$diplomauniversity =$_POST['diplomauniversity'];
					$diplomaduration =$_POST['diplomaduration'];
					$diplomapercentage =$_POST['diplomapercentage'];
					$graduationqualification =$_POST['graduationqualification'];
					$graduationpassingyear =$_POST['graduationpassingyear'];
					$graduationuniversity =$_POST['graduationuniversity'];
					$grdurationDuration =$_POST['grdurationDuration'];
					$graduationpercentage =$_POST['graduationpercentage'];
					$mastergraduationqualification =$_POST['mastergraduationqualification'];
					$mastergraduationpassingyear =$_POST['mastergraduationpassingyear'];
					$mastergraduationuniversity =$_POST['mastergraduationuniversity'];
					$mastergraduationduration =$_POST['mastergraduationduration'];
					$mastergraduationpercentage =$_POST['mastergraduationpercentage'];

		if($emp_education_edit=="")
		{
		
echo $sql_insert_education = "insert into ".$mysql_table_prefix."education_master  set 
emp_id = '".$_SESSION['emp_id']."',
qualification = '$qualification',
university = '$university',
duration = '$duration',
percentage = '$percentage',
hscyear='$hscyear',
hscboard='$hscboard',
hscsubject='$hscsubject',
hscpercentage='$hscpercentage',
diplomaqualification='$diplomaqualification',
diplomayear='$diplomayear',
diplomauniversity='$diplomauniversity',
diplomaduration='$diplomaduration',
diplomapercentage='$diplomapercentage',
graduationqualification='$graduationqualification',
graduationpassingyear='$graduationpassingyear',
graduationuniversity='$graduationuniversity',
grdurationDuration='$grdurationDuration',
graduationpercentage='$graduationpercentage',
mastergraduationqualification='$mastergraduationqualification',
mastergraduationpassingyear='$mastergraduationpassingyear',
mastergraduationuniversity='$mastergraduationuniversity',
mastergraduationduration='$mastergraduationduration',
mastergraduationpercentage='$mastergraduationpercentage'";																						
																				
			$result_family_education = mysql_query($sql_insert_education) or die("Error in query:".$sql_insert_education."<br>".mysql_error()."<br>".mysql_errno());
		
		
		}
		else
		{
			if(checkEmpTable($emp_education_edit,$mysql_table_prefix.'education_master')!=1)
		  	{
				 $sql_insert_family = "insert into ".$mysql_table_prefix."education_master  set 
																					emp_id = '".$emp_family_edit."'";
																				
		$result_family = mysql_query($sql_insert_family) or die("Error in query:".$sql_insert_family."<br>".mysql_error()."<br>".mysql_errno());
			}
			
			 $sql_insert_personal = "update ".$mysql_table_prefix."education_master  set 
																						qualification = '$qualification',
																						university = '$university',
																						duration = '$duration',
																						percentage = '$percentage',hscyear='$hscyear',hscboard='$hscboard',hscsubject='$hscsubject',hscpercentage='$hscpercentage',diplomaqualification='$diplomaqualification',diplomayear='$diplomayear',diplomauniversity='$diplomauniversity',diplomaduration='$diplomaduration',diplomapercentage='$diplomapercentage',graduationqualification='$graduationqualification',graduationpassingyear='$graduationpassingyear',graduationuniversity='$graduationuniversity',grdurationDuration='$grdurationDuration',graduationpercentage='$graduationpercentage',mastergraduationqualification='$mastergraduationqualification',mastergraduationpassingyear='$mastergraduationpassingyear',mastergraduationuniversity='$mastergraduationuniversity',mastergraduationduration='$mastergraduationduration',mastergraduationpercentage='$mastergraduationpercentage' where emp_id = '$emp_education_edit'";
					
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
		$emp_id=$_POST['emp_id'];
		$pf_no=$_POST['pf_no'];
		$pf_rate=$_POST['pf_rate'];
		$pf_nominee=$_POST['pf_nominee'];
		$pf_relationship=$_POST['pf_relationship'];
		$esic_no=$_POST['esic_no'];
		$esic_rate=$_POST['esic_rate'];
		$esic_nominee=$_POST['esic_nominee'];
		$esic_relationship=$_POST['esic_relationship'];
		$ip = $_SERVER['REMOTE_ADDR'];
		$emp_id=$_POST['emp_id'];
		$rotation_type=$_POST['rotation_type'];
		$shift=$_POST['shift_duration'];
		$off_days=$_POST['off_days'];
		$payment_mode = $_POST['payment_mode']; 
		$bank_name = $_POST['bank_name'];
		$account_no = $_POST['account_no'];
		$ip = $_SERVER['REMOTE_ADDR'];

	//ALL OFFICIAL INSERT  QUERY//				
		if($emp_offical_edit=="")
		{
		
		 $sql_insert_offical = "insert into ".$mysql_table_prefix."official_detail  set 
																						emp_id = '".$_SESSION['emp_id']."',
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
// PF DETAILS
$sql_check = "insert into ".$mysql_table_prefix."account_detail set	
																	emp_id ='$emp_id',
																	pf_number ='$pf_no',
																	pf_nominee ='$pf_nominee',
																	pf_rate ='$pf_rate',
																	pf_relationship ='$pf_relationship',
																	esic_number ='$esic_no',
																	esic_nominee ='$esic_nominee',
																	esic_rate ='$esic_rate',
																	esic_relationship ='$esic_relationship',
																	InsertBy ='$pf_no',
																	InsertDate =now(),
																	IpAddress ='$ip',
																	payment_mode ='$payment_mode',
																	bank_name ='$bank_name',
																	account_no='$account_no'";
																
$result_check=mysql_query($sql_check) or die ("Query Failed ".mysql_error());
// SHIFT DETAILS  INSERT QUERY//

/*$sql_check = "insert into  ".$mysql_table_prefix."shift_detail set	
																emp_id  ='$emp_id',
																rotation_type ='$rotation_type',
																shift='$shift_duration',
																off_day='$off_days',
																InsertBy ='$emp_id',
																InsertDate =now(),
																IpAddress ='$ip'";
																
$result_check=mysql_query($sql_check) or die ("Query Failed ".mysql_error());
*/
		   $sql_insert_emp_update = "update ".$mysql_table_prefix."employee_master  set date_joining = '$date_joining',department = '$department',sub_department = '$sub_department',designation = '$designation'"; 
		   
		   $result_insert_empa= mysql_query($sql_insert_emp_update) or die("Error in query:".$sql_insert_emp_update."<br>".mysql_error()."<br>".mysql_errno());
		   
		$sql_insert_dept = "insert into ".$mysql_table_prefix."department_employee  set 
																						emp_id = '".$_SESSION['emp_id']."',
																						dept_id = '$sub_department',
																						from_date = now()";
			
	   mysql_query($sql_insert_dept) or die("Error in query:".$sql_insert_dept."<br>".mysql_error()."<br>".mysql_errno());
	   
	   
	   $sql_insert_desi = "insert into ".$mysql_table_prefix."designation_employee  set 
																						emp_id = '".$_SESSION['emp_id']."',
																						designation_id = '$designation',
																						from_date = now()";
			
	   mysql_query($sql_insert_desi) or die("Error in query:".$sql_insert_desi."<br>".mysql_error()."<br>".mysql_errno());
	   
	   }
	   else
	   {
	   
	   	if(checkEmpTable($emp_education_edit,$mysql_table_prefix.'official_detail')!=1)
		  	{
			 $sql_insert_family = "insert into ".$mysql_table_prefix."official_detail  set 
																					        emp_id = '".$emp_offical_edit."'";
																				
		$result_family = mysql_query($sql_insert_family) or die("Error in query:".$sql_insert_family."<br>".mysql_error()."<br>".mysql_errno());
		
		
		$sql_insert_dept = "insert into ".$mysql_table_prefix."department_employee  set 
																						emp_id = '$emp_offical_edit'";
			
	   mysql_query($sql_insert_dept) or die("Error in query:".$sql_insert_dept."<br>".mysql_error()."<br>".mysql_errno());
	   
	   
	   $sql_insert_desi = "insert into ".$mysql_table_prefix."designation_employee  set 
																						emp_id = '$emp_offical_edit'";
			
		
			}
	   
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
		//
		$sql_check = "update ".$mysql_table_prefix."account_detail set	
																	emp_id ='$emp_id',
																	pf_number ='$pf_no',
																	pf_nominee ='$pf_nominee',
																	pf_rate ='$pf_rate',
																	pf_relationship ='$pf_relationship',
																	esic_number ='$esic_no',
																	esic_nominee ='$esic_nominee',
																	esic_rate ='$esic_rate',
																	esic_relationship ='$esic_relationship',
																	InsertBy ='$pf_no',
																	InsertDate =now(),
																	IpAddress ='$ip',
																	payment_mode ='$payment_mode',
																	bank_name ='$bank_name',
																	account_no='$account_no'
																	where emp_id = '$emp_education_edit'";
																
$result_check=mysql_query($sql_check) or die ("Query Failed ".mysql_error());

		//
	   	   
		   	   $sql_insert_emp_update = "update ".$mysql_table_prefix."employee_master  set date_joining = '$date_joining',department = '$department',sub_department = '$sub_department',designation = '$designation'"; 
		   $result_insert_empa= mysql_query($sql_insert_emp_update) or die("Error in query:".$sql_insert_emp_update."<br>".mysql_error()."<br>".mysql_errno());
		   
		   
	   $sql_check1 = "update ".$mysql_table_prefix."department_employee set	
	   																		to_date  =now()
																			where emp_id='$emp_education_edit' and to_date ='0000-00-00'";
																
		$result_check1=mysql_query($sql_check1) or die ("Query Failed ".mysql_error());

		$sql_check = "insert into  ".$mysql_table_prefix."department_employee set	
																					emp_id  ='$emp_education_edit',
																					dept_id ='$sub_department',
																					from_date =now(),
																					to_date ='0000-00-00'";
																
		$result_check=mysql_query($sql_check) or die ("Query Failed ".mysql_error());
	   
	   
	   $sql_check1 = "update ".$mysql_table_prefix."designation_employee set	
																				to_date  =now()
																				where emp_id='$emp_education_edit' and to_date ='0000-00-00'";
																
		$result_check1=mysql_query($sql_check1) or die ("Query Failed ".mysql_error());

		$sql_check = "insert into  ".$mysql_table_prefix."designation_employee set	
																					emp_id  ='$emp_education_edit',
																					designation_id ='$designation',
																					from_date =now(),
																					to_date ='0000-00-00'";
																
		$result_check=mysql_query($sql_check) or die ("Query Failed ".mysql_error());
		
		$sql_check1 = "update ".$mysql_table_prefix."shift_detail set	
																to_date  =now()
																where emp_id='$emp_id' and to_date ='0000-00-00'";
																
$result_check1=mysql_query($sql_check1) or die ("Query Failed ".mysql_error());

$sql_check1 = "update ".$mysql_table_prefix."rotation_type_employee set	
																to_date  =now()
																where emp_id='$emp_id' and to_date ='0000-00-00'";
																
$result_check1=mysql_query($sql_check1) or die ("Query Failed ".mysql_error());

$sql_check1 = "update ".$mysql_table_prefix."weekly_off_employee set	
																to_date  =now()
																where emp_id='$emp_id' and to_date ='0000-00-00'";
																
$result_check1=mysql_query($sql_check1) or die ("Query Failed ".mysql_error());

		
	   }
	   // shift details
	   $sql_check = "insert into  ".$mysql_table_prefix."shift_detail set	
																emp_id  ='$emp_id',
																shift ='$shift',
																from_date =now(),
																to_date ='0000-00-00'";
																
$result_check=mysql_query($sql_check) or die ("Query Failed ".mysql_error());

	 // rotation type
	 $sql_check = "insert into  ".$mysql_table_prefix."rotation_type_employee set	
																emp_id  ='$emp_id',
																rotation_type ='$rotation_type',
																from_date =now(),
																to_date ='0000-00-00'";
																
$result_check=mysql_query($sql_check) or die ("Query Failed ".mysql_error());  
	   
	   //  weekly off
	   $sql_check = "insert into  ".$mysql_table_prefix."weekly_off_employee set	
																emp_id  ='$emp_id',
																off_day ='$weekly_off',
																from_date =now(),
																to_date ='0000-00-00'";
																
$result_check=mysql_query($sql_check) or die ("Query Failed ".mysql_error());
	   
	   
		
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

		$convence = $_POST['convence'];
		$medical = $_POST['medical'];
		$hra = $_POST['hra'];
		$side_allowance = $_POST['side_allowance'];
		
		$p_tax = $_POST['p_tax'];
		$tds = $_POST['tds'];
		$advance = $_POST['advance'];
		$loan = $_POST['loan'];
		$other_gain = $_POST['other_gain'];	
		$celling = $_POST['cell'];
		$phone_allowance = $_POST['phone_allowance'];
		
		$earning = $_POST['earning'];
		$bonus = $_POST['bonus'];
		$gratuity = $_POST['gratuity'];
		$deduction = $_POST['deduction'];
		$deduction1 = $_POST['deduction1']; 
		
			$deduc = 	$deduction + $deduction1;
		if($emp_salary_edit=="")
		{
			
$sql_update = "update ".$mysql_table_prefix."salary_master set 
																			to_date = now(),
																			InsertDate = 'now()',
																			IpAddress = '$ip'
																			where emp_id = '$emp_id' and to_date='0000-00-00'";
																			
	$result_check=mysql_query($sql_update) or die ("Query Failed ".mysql_error());
			
		$sql_insert_education = "insert into ".$mysql_table_prefix."salary_master set 
																						emp_id ='".$_SESSION['emp_id']."',
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
																						IpAddress = '',
																					celling = '$celling',
																	phone = '$phone_allowance',
																	take_home = '$earning',
																	bonus = '$bonus',
																	graduity = '$gratuity',
																	total_deduction = '$deduc',
																	total_salary = '$total_salary'
																						";
																				
		$result_family_education = mysql_query($sql_insert_education) or die("Error in query:".$sql_insert_education."<br>".mysql_error()."<br>".mysql_errno());
		
		$sql_loan= "insert into ".$mysql_table_prefix."loan_employee set 
																			emp_id = '".$_SESSION['emp_id']."',
																			loan_amount = '$loan'";
																				
		mysql_query($sql_loan) or die("Error in query:".$sql_loan."<br>".mysql_error()."<br>".mysql_errno());
		
		$sql_advance= "insert into ".$mysql_table_prefix."advance_employee set 
																				emp_id = '".$_SESSION['emp_id']."',
																				advance = '$advance',
																				ad_date = now()";
																				
		mysql_query($sql_advance) or die("Error in query:".$sql_advance."<br>".mysql_error()."<br>".mysql_errno());	
		}
		else
		{
			if(checkEmpTable($emp_education_edit,$mysql_table_prefix.'salary_master')!=1)
		  	{
			 $sql_insert_family = "insert into ".$mysql_table_prefix."salary_master  set 
																					        emp_id = '".$emp_offical_edit."'";
																				
		$result_family = mysql_query($sql_insert_family) or die("Error in query:".$sql_insert_family."<br>".mysql_error()."<br>".mysql_errno());
		
		
		$sql_loan= "insert into ".$mysql_table_prefix."loan_employee set 
																			emp_id = '$emp_offical_edit'";
																				
		mysql_query($sql_loan) or die("Error in query:".$sql_loan."<br>".mysql_error()."<br>".mysql_errno());
		
		$sql_advance= "insert into ".$mysql_table_prefix."advance_employee set 
																				emp_id = '$emp_offical_edit'";
																				
		mysql_query($sql_advance) or die("Error in query:".$sql_advance."<br>".mysql_error()."<br>".mysql_errno());	
			
		
			}
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
																						IpAddress = '',
																						celling ='$celling'
																						 where emp_id = '$emp_salary_edit'";
																				
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
		//redirect('employee_detail.php?unset');
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
		if(document.getElementById('empStaff').checked == true){
			var empType = 'Staff';
		}if(document.getElementById('empWorker').checked == true){
			var empType = 'worker';
		}
		var urlstr = 'id='+str1+'&empType='+empType;
		xmlHttp.open('get','check_login.php?id='+str1+'&empType='+empType+'&act=username'+'&sid='+Math.random());
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
		document.getElementById('emp_login').focus();
		document.getElementById('emp_login').value='';
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
function valid_empoylee(personel_reg)
{
	return(
				checkString(personel_reg.elements["emp_login"],"Empolyee Id",false) &&	
				checkString(personel_reg.elements["first_name"],"First Name",false) &&	
				checkString(personel_reg.elements["last_name"],"Last Name",false)									
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
<!--      my script    --> 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
	 $("#ss").hide();
  $("#show").click(function(){
    $("#ss").hide();
  });
  $("#hide").click(function(){
    $("#ss").show();
  });
});
</script>
<script>
function addElements() {
  var ni = document.getElementById('myDiv1');
  var numi = document.getElementById('h_hidden');
  var num = (document.getElementById('h_hidden').value -1)+ 2;
  numi.value = num;
  var newdiv = document.createElement('div');
  var divIdName = 'my'+num+'Div1';
  var myDivName='myDiv1';
  newdiv.setAttribute('id',divIdName);
newdiv.innerHTML = "<table align='center' width='100%' border='0' cellpadding='1' cellspacing='0'><tr><td align='left' style='width:256px;'><input name='child_name[]' type='text' value='' style='width:180px;height:20px;' /></td><td align='left' style='width:251px;'>male<input name='child_gender"+num+"[] 'id='child_gender' type='radio' value='male' />female<input name='child_gender"+num+"[]' id='child_gender' type='radio' value='female' /></td><td align='left' style='width: 253px;'>yes<input name='child_dependent"+num+"[]' id='child_dependent' type='radio' value='yes' />no<input name='child_dependent"+num+"[]' type='radio' value='no' /></td><td align='left' style='width:246px;'><input name='child_dob[]' id='chil_dob' type='text' value='' style='width:150px;height:20px;'/></td><td class='delete' style='padding-right:10px;'><a href=\"javascript:;\" onclick=\"removeElements(\'"+divIdName+"\'\,'"+myDivName+"\')\"><img src='images/delete_icon.jpg' border='0'/></span></a></td></tr></table>";
 ni.appendChild(newdiv);
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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
<script>
				   var jj = jQuery.noConflict();
                jj(document).ready(function(){
                jj("#hide").click(function(){
                jj(".wife_name").hide();
                 });
                jj("#show").click(function(){
                jj(".wife_name").show();
                });
                });
                </script>
<?
/*
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
*/
?>
<table width="98%" cellpadding="0" cellspacing="0" border="0" align="center">
    <tr>
  
  <td align="left" valign="top" width="230px" style="padding-top:5px;"><? include ("inc/snb.php"); ?></td>
  <td style="padding-left:5px; padding-top:5px;"><table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
      <tr>
        <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Employee Registration Form</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td class="red"><?=$msg?></td>
      </tr>
        <tr bgcolor="#FFFFFF">
      
      <td style="vertical-align:top; padding-top:5px;"><div class="simpleTabs">
          <ul class="simpleTabsNavigation">
            <li><a <? if(isset($_SESSION['emp_id']) or isset($_GET['emp_id'])){ ?>href="employee_detail.php?mode=" <? } if($mode==''){ echo 'class="current"';}?>>Personal Detail</a></li>
            <li><a <? if(isset($_SESSION['emp_id']) or isset($_GET['emp_id'])){ ?> href="employee_detail.php?mode=personal_detail"<? } if($mode=='personal_detail'){ echo 'class="current"';}?>>Family Detail</a></li>
            <li><a <? if(isset($_SESSION['emp_id']) or isset($_GET['emp_id'])){ ?> href="employee_detail.php?mode=family_detail"<? } if($mode=='family_detail'){ echo 'class="current"';}?>>Education details</a></li>
            <li><a <? if(isset($_SESSION['emp_id']) or isset($_GET['emp_id'])){ ?> href="employee_detail.php?mode=education_detail"<? } if($mode=='education_detail'){ echo 'class="current"';}?>>Official Profile</a></li>
            <li><a <? if(isset($_SESSION['emp_id']) or isset($_GET['emp_id'])){ ?>href="employee_detail.php?mode=offical_profile"<? } if($mode=='offical_profile'){ echo 'class="current"';}?>>Salary details</a></li>
          </ul>
          <div <? if($mode==''){ echo 'class="current"';}else{echo 'class="simpleTabsContent"';}?>>
            <form name="empolyee_profile" id="empolyee_profile" action="employee_detail.php" method="post" enctype="multipart/form-data" onSubmit="return valid_empoylee(this);">
              <table width="100%" cellpadding="2" cellspacing="2" border="0" align="center" class="border" style="padding-top:10px;">
                <tr>
                  <td width="100%" colspan="2" align="center"><table cellpadding="0" cellspacing="0" border="0" align="center" class="loginbg">
                      <tr>
                        <td  class="text_1">Select Employee Type</td>
                        <td><input type="radio" name="empType" id="empStaff" value="1" <?php if(@$empType == 'staff'){echo 'checked="checked"';}?>    />
                          <label for="empStaff">Staff</label>
                          <input type="radio" name="empType" id="empWorker" value="2" <?php if(@$empType == 'worker'){echo 'checked="checked"';}?> />
                          <label for="empWorker">Worker</label></td>
                        <td width="" class="text_1" style="padding-left:15px;">Empolyee Code<span class="red">*</span></td>
                        <td width=""><!--<input type="text" name="emp_login" id="emp_login" readonly="readonly" style="width:150px; height:20px;" value="<?=@$emp_id?>">-->
                          
                          <input type="text" name="emp_login" id="emp_login" style="width:150px; height:20px;" value="<?=@$ticket_no?>" <? if(isset($_SESSION['emp_id'])){echo 'readonly="readonly"';}else{?> onBlur="check_login_id(this.value);"<? }?>></td>
                        <td width="30%"><div style="font-size:14px;" id="check_login"></div></td>
                        <!--
                                        <td width="13%" class="text_1" style="padding-left:15px;">Empolyee Code<span class="red">*</span></td>
                                      <td width="25%"><!--<input type="text" name="emp_login" id="emp_login" readonly="readonly" style="width:150px; height:20px;" value="<?=$emp_id?>">
                                      <input type="text" name="emp_login" id="emp_login" style="width:150px; height:20px;" value="<?=$ticket_no?>" <? if(isset($_SESSION['emp_id'])){echo 'readonly="readonly"';}else{?>onBlur="check_login_id(this.value);"<? }?>></td>
                                      <td><div id="check_login"></div></td>--> 
                        <!--<td style="padding-top:5px;"><div id="check_login"></div></td>--> 
                        <!--<td class="text_1" style="padding-top:0px;">Password<span class="red">*</span></td>
                                        <td><input type="password" name="password" id="password" style="width:150px; height:20px;"/></td>
                                        <td class="text_1" style="padding-top:0px;">Retype Password<span class="red">*</span></td>
                                        <td><input type="password" name="re_password" id="re_password" style="width:150px; height:20px;"/></td>--> 
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td valign="top"><table width="100%" cellpadding="2" cellspacing="2" class="border" border="0">
                      <tr>
                        <td class="text_1">First Name<span class="red">*</span></td>
                        <td align="left" style="padding-top:5px;"><input type="text" name="first_name" id="first_name" style="width:150px; height:20px;" value="<?=$first_name?>"/></td>
                      </tr>
                      <tr>
                        <td class="text_1">Last Name<span class="red">*</span></td>
                        <td align="left" style="padding-top:5px;"><input type="text" name="last_name" id="last_name" style="width:150px; height:20px;" value="<?=$last_name?>"/></td>
                      </tr>
                      <tr>
                        <td class="text_1" valign="top">Address</td>
                        <td align="left" style="padding-top:5px;"><textarea name="address" id="address" rows="4" cols="32" style="height:105px;"><?=$address?>
</textarea></td>
                      </tr>
                      <tr>
                        <td class="text_1">Country</td>
                        <td align="left"><?
                                            $sql = "SELECT * FROM mpc_countries order by countries_name";
                                            $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
                                            ?>
                          <select name="country" id="country" onChange="get_frm1('get_state.php',this.value,'div_add_state','state');">
                            <option value="">-select country-</option>
                            <? 
                                            
                                            while ($row=mysql_fetch_array($result))
                                            {	?>
                            <option value="<?=$row['countries_id']?>" <? if($row['countries_id']==$country){?> selected="selected" <? } ?>>
                            <?=$row["countries_name"]?>
                            </option>
                            <?  }	?>
                          </select></td>
                      </tr>
                      <tr>
                        <td class="text_1">State</td>
                        <td align="left"><div id="div_add_state">
                            <?
											if($other_state=="")
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
                          </div></td>
                      </tr>
                      <tr>
                        <td class="text_1">City</td>
                        <td align="left"><div id="div_city">
                            <?
											if($other_city=="")
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
                          </div></td>
                      </tr>
                      <tr>
                        <td class="text_1">Pin Code</td>
                        <td align="left"><input type="text" name="pin_code" id="pin_code" style="width:150px; height:20px;" value="<?=$pincode?>"/></td>
                      </tr>
                      <tr>
                        <td class="text_1">Date Of Birth</td>
                        <td align="left"><input type="text" name="dob" id="dob" style="width:150px; height:20px;" value="<?=getDatetime($dob)?>"/>
                          <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.empolyee_profile.dob);" HIDEFOCUS><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a></td>
                      </tr>
                    </table></td>
                  <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border" border="0">
                      <tr>
                        <td width="43%" class="text_1">Gender</td>
                        <td width="57%" align="left" class="text_1" style="padding-left:0px;"><input type="radio" id="gender" name="gender" value="Male" <? if($gender=='male') {?>checked="checked"<? }?>/>
                          Male
                          <input type="radio" id="gender" name="gender" value="Female"<? if($gender=='female'){ ?>checked="checked"<? }?>/>
                          Female </td>
                      </tr>
                      <tr>
                        <td class="text_1">Phone</td>
                        <td align="left"><input type="text" name="phone_no" id="phone_no" style="width:150px; height:20px;" value="<?=$phone_no?>"/></td>
                      </tr>
                      <tr>
                        <td class="text_1">Email Id</td>
                        <td align="left"><input type="text" name="email_id" id="email_id" style="width:150px; height:20px;" value="<?=$email_id?>"/></td>
                      </tr>
                      <tr>
                        <td class="text_1">Marital Status</td>
                        <td align="left" class="text_1" style="padding-left:0px;"><input type="radio" id="hide" name="marital" value="yes" onClick="marriage_date(this)" <? if($marital_status =='yes'){ ?>checked="checked"<? }?>/>
                          Married
                          <input type="radio" id="show" name="marital" value="no" onClick="marriage_date(this)" <? if($marital_status =='no'){ ?>checked="checked"<? }?>/>
                          Single </td>
                      </tr>
                      <tr id="ss">
                      
                        <td class="text_1">if Married then date of Marriage</td>
                        <td align="left"><input type="text" name="marr_date" id="marr_date" disabled="disabled" style="width:150px; height:20px;" value="<?=$marriage_date?>"/>
                          <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.empolyee_profile.marr_date);" HIDEFOCUS><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a></td>
                      </tr>
                      <tr>
                        <td class="text_1">Blood Group</td>
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
                          </select></td>
                      </tr>
                      <tr>
                        <td class="text_1">Religion</td>
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
                        <td class="text_1">Employee picture</td>
                        <td align="left"><input type="file" name="emp_pic" id="emp_pic" style="width:150px; height:20px;"/></td>
                        

<?php $img_path = "http://".$_SERVER['HTTP_HOST']."employee_picture/thumb/".$employee_picture ; ?>
 <td><img src="<?php echo "http://solutionsofts.com/mah_database/"?>employee_picture/thumb/<?php echo $employee_picture ; ?>"></td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td colspan="2" style="text-align:center;"><input type="submit"  value="Submit" name="Submit_emp" id="Submit_emp"/>
                    <? if(isset($_SESSION['emp_id'])){
								    ?>
                    <input type="button"  value="Done" name="Submit_emp2" id="Submit_emp2" onClick="document.location='list_employee.php?ticket_no=<?=$ticket_no?>';"/>
                    <?	
                                        							}
								 ?>
                    <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" /></td>
                </tr>
              </table>
            </form>
          </div>
          <div <? if($mode=='personal_detail'){ echo 'class="current"';}else{echo 'class="simpleTabsContent"';}?>>
            <form name="empolyee_family" id="empolyee_family" action="employee_detail.php" method="post" enctype="multipart/form-data" onSubmit="return valid_customer(this);">
              <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border" border="0" style="padding-top:10px">
                <tr>
                  <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                      <tr>
                        <td class="text_1" width="35%">Father Name(Mr.)</td>
                        <td align="left" width="65%"><input type="text" name="father_name" id="father_name" style="width:150px; height:20px;" value="<?=$father_name?>"/></td>
                      </tr>
                      <tr>
                        <td class="text_1">Depended</td>
                        <td align="left" class="text_1" style="padding-left:0px;"><input type="radio" id="Dependant_member1" name="Dependant_member1" value="Yes" <? if($Dependant_father=='Yes'){ ?>checked="checked"<? }?>/>
                          Yes
                          <input type="radio" id="Dependant_member1" name="Dependant_member1" value="No" <? if($Dependant_father=='No'){ ?>checked="checked"<? }?>/>
                          No </td>
                      </tr>
                      <tr>
                        <td class="text_1">Mother Name(Mrs.) </td>
                        <td align="left"><input type="text" name="mother_name" id="mother_name" style="width:150px; height:20px;" value="<?=$mother_name?>"/></td>
                      </tr>
                      <tr>
                        <td class="text_1">Depended</td>
                        <td align="left" class="text_1" style="padding-left:0px;"><input type="radio" id="Dependant_member2" name="Dependant_member2" value="Yes"<? if($Dependant_mother=='Yes'){ ?>checked="checked"<? }?>/>
                          Yes
                          <input type="radio" id="Dependant_member2" name="Dependant_member2" value="No"<? if($Dependant_mother=='No'){ ?>checked="checked"<? }?>/>
                          No </td>
                      </tr>
                      <?php   if($_SESSION['marital_sta'] === 'yes'){ ?>
                      <tr>
                        <td class="text_1">Wife Name </td>
                        <td align="left"><input type="text" name="wife_name" id="wife_name" style="width:150px; height:20px;" value="<?=$wife_name?>"/></td>
                      </tr>
                      <tr>
                        <td class="text_1">Depended</td>
                        <td align="left" class="text_1" style="padding-left:0px;"><input type="radio" id="Dependant_member3" name="Dependant_member3" value="Yes"<? if($Dependant_wife =='Yes'){ ?>checked="checked"<? }?>/>
                          Yes
                          <input type="radio" id="Dependant_member3" name="Dependant_member3" value="No"<? if($Dependant_wife =='No'){ ?>checked="checked"<? }?>/>
                          No </td>
                      </tr>
                      <?php } ?>
                      <?php  // if($_SESSION['marital_sta'] === 'yes'){ ?>
                    </table></td>
                  <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                      <tr>
                        <td class="text_1" width="35%">Date of Birth</td>
                        <td align="left" width="65%"><input type="text" name="father_dob" id="father_dob" style="width:150px; height:20px;" value="<?=$father_dob?>"/>
                          <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.empolyee_family.father_dob);" HIDEFOCUS><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a></td>
                      </tr>
                      <tr>
                        <td class="text_1">Occupation</td>
                        <td align="left"><input type="text" name="father_occupation" id="father_occupation" style="width:150px; height:20px;" value="<?=$father_occupation?>"/></td>
                      </tr>
                      <tr>
                        <td class="text_1">Date of Birth </td>
                        <td align="left"><input type="text" name="mother_dob" id="mother_dob" style="width:150px; height:20px;" value="<?=$mother_dob?>"/>
                          <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.empolyee_family.mother_dob);" HIDEFOCUS><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a></td>
                      </tr>
                      <tr>
                        <td class="text_1">Occupation</td>
                        <td align="left"><input type="text" name="mother_occupation" id="mother_occupation" style="width:150px; height:20px;" value="<?=$mother_occupation?>"/></td>
                      </tr>
                      <?php   if($_SESSION['marital_sta'] === 'yes'){ ?>
                      <tr>
                        <td class="text_1">Date of Birth </td>
                        <td align="left"><input type="text" name="wife_dob" id="wife_dob" style="width:150px; height:20px;" value="<?=$wife_dob?>"/>
                          <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.empolyee_family.wife_dob);" HIDEFOCUS><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a></td>
                      </tr>
                      <tr>
                        <td class="text_1">Occupation</td>
                        <td align="left"><input type="text" name="wife_occupation" id="wife_occupation" style="width:150px; height:20px;" value="<?=$wife_occupation?>"/></td>
                      </tr>
                    
                      <?php } ?>
                    
					</table></td>
                </tr>
               <?php   if($_SESSION['marital_sta'] === 'yes'){ ?>
                
                <!--new try-->
                
                 <?php 
				 
			 $que = mysql_query("select * from mpc_family_master where emp_id='$emp_id'");
			 ?>
          <table align="left" width="100%" cellpadding="1" cellspacing="1" class="border" border="0">
            <tr>
             <!-- <td align="left" width="10px">Childrens information</td>
              -->
            </tr>
            <?php
			 //$row=(mysql_num_rows($que)>0);
			 $i = 1;
     		 while($row = mysql_fetch_array($que))
			  {
				if(!empty($row['child_name'])){
			
				
				  ?>
            <tr>
              <?//php echo $child_name0; ?>
              <input type="hidden" value="<?php echo $row['rec_id']?>">
              <td align="left"><input name="child_name[]" id="child_name[]" type="text" value="<?php echo $row['child_name'];?>" style="width:180px; height:20px;"/></td>
              <td align="left"><?php echo $male=$row['child_gender'];?> male
                <input name="child_gender<?php echo $i;?>[]" id="child_gender[]" type="radio" value="male"<?php if($male=='male'){echo 'checked';}?> />
                female
                <input name="child_gender<?php echo $i;?>[]" id="gen[]" type="radio" value="female"  <?php if($male=='female'){ echo 'checked';}?> /></td>
              
              <td align="left"> yes
              <?php $child_dependent=$row['child_dependent'];?>
                <input name="child_dependent<?php echo $i;?>[]" id="child_dependent[]" type="radio" value="yes"<?php if($child_dependent=='yes'){echo'checked'; }?>/>
                no
                <input name="child_dependent<?php echo $i;?>[]" id="child_dependent[]" type="radio" value="no"<?php if($child_dependent=='no'){ echo 'checked';}?>/></td>
              <td align="left"><input name="child_dob[]" id="child_dob[]" type="text" value="<?= $row['child_dob']?>"  style="width:150px; height:20px;"/></td>
              
<td><a href="http://solutionsofts.com/mah_database/employee_detail.php?mode=personal_detail&rec_id=<?php echo $row['rec_id']?>">delete</a></td>
<td><a href="http://solutionsofts.com/mah_database/employee_detail.php?mode=personal_detail&rec_ids=<?php echo $row['rec_id']?>&child_name=<?php $child_name;?>&child_gender=<?php echo $child_gender;?>&child_dependent=<?php echo $child_dependent?>&child_dob=<?php echo $child_dob?>">update</a></td>
            </tr>
            <?php
			  $i++;			  }}
			  ?>
              
              </table>
        <?php 
				if(isset($_GET['rec_id']))
				{
					
					$rec_id=$_GET['rec_id'];
					$query = mysql_query("delete from mpc_family_master where rec_id='$rec_id'");
					if(!($query))
					{
						echo"data is deleted";
					}
					else {
						echo"Data is deleted";
					}
				}
				
				
				?>
                
                <?php
				if(isset($_GET['rec_ids']))
				{
					$rec_id=$_GET['rec_ids'];
					$query = mysql_query("update mpc_family_master set child_name='$child_name',child_gender='$child_gender',child_dependent='$child_dependent',child_dob='$child_dob' where rec_id='$rec_id'");
					if(!($query))
					{
						echo"data is updated";
					}
					else
					{
						echo"data is not updated";}
					
					
				}
				
				
				
				?>
                <!-- End -->
                
             <!--  my code   -->
                <tr>
                <td align="left" width="10px">Childrens information</td>
                                                  
                                                    </tr>
                                                    <tr>
                                                    	<td align="left" colspan="3" style="padding-top:3px;">
                                                            <table align="left" width="100%" cellpadding="1" cellspacing="1" class="border" border="0">
                                                                <tr class="text_1" bgcolor="#EAE3E1">
                                                                    
                                                                  	<td width="24%"><b>child Name</b></td>
                                                                  	<td width="24%"><b>Gender</b></td>
                                                                  	<td width="24%"><b>Dependent</b></td>
                                                                  	<td width="24%"><b>Date of Birth</b></td>
                                                                  	<td width="4%"></td>
                                                                </tr>
																 
                                                            
                                                                <tr>
                                                                 <?php echo $child_name0; ?>
                                                                    <td align="left">
                                                                  
                                                                    	<input name="child_name[]" id="child_name[]" type="text" value="<?=$child_name?>" style="width:180px; height:20px;"/>
                                                                    </td>
                                                                    <td align="left">
                                                                    	male<input name="child_gender0[]" id="child_gender[]" type="radio" value="male" />
                                                                       female<input name="child_gender0[]" id="gen[]" type="radio" value="female" /></td>
                                                                    
                                                                    </td>
                                                                    <td align="left">
                                                                    	yes<input name="child_dependent0[]" id="child_dependent[]" type="radio" value="yes" />
                                                                       no<input name="child_dependent0[]" id="child_dependent[]" type="radio" value="no" /></td>
                                                                    <td align="left">
                                                                    	<input name="child_dob[]" id="child_dob[]" type="text" value="" style="width:150px; height:20px;"/>
                                                                    </td>
                                                                    
                                                                    <td class="AddMore" style="padding-right:10px;">
                                                                     	<input type="hidden" name="h_hidden" id="h_hidden"/> 
                                                                    	<a href="javascript:;"  onclick="addElements();"><img src="images/add_icon.jpg" border="0"/></a>
                                                                    </td>
                                                                </tr>
                                                                
                                                                <?php } ?>
                                                             </table>       
                                                             </div>       
                                                        </td>
                
                
                
                
                <!--   End of code     -->
                <tr>
                  <td colspan="2" style="text-align:center;"><div id="myDiv1"></div></td>
                </tr>
                <tr>
                  <td style="text-align:center;" colspan="2"><input type="submit"  value="Submit" name="emp_family" id="emp_family"/>
                    <? if(isset($_SESSION['emp_id'])){
								    ?>
                    <input type="button"  value="Done" name="Submit_emp2" id="Submit_emp2" onClick="document.location='list_employee.php?ticket_no=<?=$ticket_no?>';"/>
                    <?	
                                        							}
								 ?>
                    <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" /></td>
                </tr>
              </table>
            </form>
          </div>
          <div <? if($mode=='family_detail'){ echo 'class="current"';}else{echo 'class="simpleTabsContent"';}?>>
            <form name="empolyee_eduction" id="empolyee_eduction" action="employee_detail.php" method="post" enctype="multipart/form-data" onSubmit="return valid_customer(this);">
              <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border" border="0"  style="padding-top:10px;">
                  <tr>
                
                <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                    <tr>
                      <td><label>S.S.C.</label></td>
                    </tr>
                    <tr>
                      <td class="text_1">year of passing</td>
                      <td align="left"><input type="text" name="qualification" id="qualification" style="width:150px; height:20px;" value="<?=$qualification?>"/></td>
                    </tr>
                    <tr>
                      <td class="text_1">Board</td>
                      <td class="text_2" align="left"><input type="text" name="university" id="university" style="width:150px; height:20px;" value="<?=$university?>"/></td>
                    </tr>
                  </table></td>
                <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                    <tr>
                    <tr>
                      <td class="text_1"></td>
                      <td align="left"></td>
                    </tr>
                    <tr>
                      <td class="text_1">Subject</td>
                      <td align="left"><input type="text" readonly="readonly" value="All" style="width:150px; height:20px;" name="duration" id="duration"  /></td>
                    </tr>
                      </tr>
                    <td class="text_1">Percentage </td>
                      <td align="left"><input type="text" name="percentage" id="percentage" style="width:150px; height:20px;" value="<?=$percentage?>"/></td>
                    </tr>
                    <tr>
                      <td class="text_1"></td>
                      <td align="left"></td>
                    </tr>
                    <tr>
                      <td class="text_1"></td>
                      <td align="left"></td>
                    </tr>
                      </tr>
                    
                  </table></td>
                  </tr>
                
                  <tr>
                
                <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                    <tr>
                      <td><label>H.S.C</label></td>
                    </tr>
                    <tr>
                      <td class="text_1">Year of passing</td>
                      <td align="left"><input type="text" name="hscyear" id="hscyear" style="width:150px; height:20px;" value="<?=$hscyear?>"/></td>
                    </tr>
                    <tr>
                      <td class="text_1">Board</td>
                      <td class="text_2" align="left"><input type="text" name="hscboard" id="hscboard" style="width:150px; height:20px;" value="<?=$hscboard?>"/></td>
                    </tr>
                  </table></td>
                <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                    <tr>
                    <tr>
                      <td class="text_1"></td>
                      <td align="left"></td>
                    </tr>
                    <tr>
                      <td class="text_1">Subject</td>
                      <td align="left"><select name="hscsubject" id="hscsubject">
                          <option  value="">-select-</option>
                          <option value="PCM" <?php if($hscsubject == "PCM"){echo 'selected="selected"'; } ;?>>PCM</option>
                          <option value="PCB" <?php if($hscsubject == "PCB"){echo 'selected="selected"'; } ;?>>PCB</option>
                          <option value="COMERCE" <?php if($hscsubject == "COMERCE"){echo 'selected="selected"'; } ;?>>COMERCE</option>
                          <option value="ART" <?php if($hscsubject == "ART"){echo 'selected="selected"'; } ;?>>ART</option>
                        </select></td>
                    </tr>
                    <tr>
                      <td class="text_1">Percentage </td>
                      <td align="left"><input type="text" name="hscpercentage" id="hscpercentage" style="width:150px; height:20px;" value="<?=$hscpercentage?>"/></td>
                    </tr>
                    <tr>
                      <td class="text_1"></td>
                      <td align="left"></td>
                    </tr>
                    <tr>
                      <td class="text_1"></td>
                      <td align="left"></td>
                    </tr>
                      </tr>
                    
                  </table></td>
                  </tr>
                
                <tr>
                  <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                      <tr>
                        <td><label>Diploma</label>
                      <tr>
                        <td>
                      
                      <tr>
                        <td class="text_1">Qualification</td>
                        <td align="left"><input type="text" name="diplomaqualification" id="diplomaqualification" style="width:150px; height:20px;" value="<?=$diplomaqualification?>"/></td>
                      
                      <tr>
                        <td class="text_1">Year of passing</td>
                        <td align="left"><input type="text" name="diplomayear" id="diplomayear" style="width:150px; height:20px;" value="<?=$diplomayear?>"/></td>
                      </tr>
                      <tr>
                        <td class="text_1">University </td>
                        <td class="text_2" align="left"><input type="text" name="diplomauniversity" id="diplomauniversity" style="width:150px; height:20px;" value="<?=$diplomauniversity?>"/></td>
                      </tr>
                    </table></td>
                  <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                      <tr>
                      <tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                      </tr>
                      <tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                      </tr>
                      <tr>
                        <td class="text_1">Course Duration</td>
                        <td align="left"><select name="diplomaduration" id="diplomaduration" >
                            <option  value="" >-select-</option>
                            <option value="1" <?php if($diplomaduration == "1"){echo 'selected="selected"'; } ;?>>1year</option>
                            <option value="2" <?php if($diplomaduration == "2"){echo 'selected="selected"'; } ;?>>2year</option>
                            <option value="3" <?php if($diplomaduration== "3"){echo 'selected="selected"'; } ;?>>3year</option>
                            <option value="4" <?php if($diplomaduration == "4"){echo 'selected="selected"'; } ;?>>4year</option>
                          </select></td>
                      </tr>
                      <tr>
                        <td class="text_1">Percentage </td>
                        <td align="left"><input type="text" name="diplomapercentage" id="diplomapercentage" style="width:150px; height:20px;" value="<?=$diplomapercentage?>"/></td>
                      </tr>
                      <tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                      </tr>
                      <tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                      </tr>
                      <tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                      </tr>
                      <tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                      </tr>
                      <tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                      </tr>
                      <tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                      </tr>
                      <tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                      <tr>
                        <td><label>Graduation</label></td>
                      </tr>
                      <tr>
                        <td class="text_1">Qualification</td>
                        <td align="left"><input type="text" name="graduationqualification" id="graduationqualification" style="width:150px; height:20px;" value="<?=$graduationqualification?>"/></td>
                      </tr>
                      
                        <td class="text_1">Year of passing</td>
                        <td align="left"><input type="text" name="graduationpassingyear" id="graduationpassingyear" style="width:150px; height:20px;" value="<?=$graduationpassingyear?>"/></td>
                      <tr>
                        <td class="text_1">University</td>
                        <td class="text_2" align="left"><input type="text" name="graduationuniversity" id="graduationuniversity" style="width:150px; height:20px;" value="<?=$graduationuniversity?>"/></td>
                      </tr>
                    </table></td>
                  <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                      <tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                      </tr>
                      
                        <td class="text_1"></td>
                        <td align="left"></td>
                      </tr>
                      
                        <td class="text_1"></td>
                        <td align="left"></td>
                      </tr>
                      <tr>
                        <td class="text_1">Course Duration</td>
                        <td align="left"><select name="grdurationDuration" id="grdurationDuration">
                            <option value="">-select-</option>
                            <option value="1" <?php if($grdurationDuration == "1"){echo 'selected="selected"'; } ;?>>1year</option>
                            <option value="2year" <?php if($grdurationDuration =="2year") {echo 'selected="selected"'; } ;?>>2year</option>
                            <option value="3" <?php if($grdurationDuration =="3"){ echo 'selected="selected"'; };?> >3year</option>
                            <option value="4" <?php if($grdurationDuration=="4"){echo 'selected="selected"';};?>>4year</option>
                            <option value="5" <?php if($grdurationDuration=="5"){echo 'selected="selected"';};?>>5year</option>
                          </select>
                      </tr>
                      <tr>
                        <td class="text_1">Percentage </td>
                        <td align="left"><input type="text" name="graduationpercentage" id="graduationpercentage" style="width:150px; height:20px;" value="<?=$graduationpercentage?>"/></td>
                      </tr>
                      <tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                      </tr>
                      <tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                      </tr>
                      <tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                      </tr>
                      <tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                      </tr>
                      <tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                      <tr>
                        <td><label>Post-Graduation</label>
                      <tr>
                        <td>
                      
                      <tr>
                        <td class="text_1">Qualification</td>
                        <td align="left"><input type="text" name="mastergraduationqualification" id="mastergrationqualification" style="width:150px; height:20px;" value="<?=$mastergraduationqualification?>"/></td>
                      
                      <tr>
                        <td class="text_1">Year of passing</td>
                        <td align="left"><input type="text" name="mastergraduationpassingyear" id="mastergraduationpassingyear" style="width:150px; height:20px;" value="<?=$mastergraduationpassingyear?>"/></td>
                      </tr>
                      <tr>
                        <td class="text_1">University </td>
                        <td class="text_2" align="left"><input type="text" name="mastergraduationuniversity" id="mastergraduationuniversity" style="width:150px; height:20px;" value="<?=$mastergraduationuniversity?>"/></td>
                      </tr>
                    </table></td>
                  <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                      <tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                      </tr>
                      
                        <td class="text_1"></td>
                        <td align="left"></td>
                      </tr>
                      <tr>
                        <td class="text_1">Course Duration</td>
                        <td align="left"><select name="mastergraduationduration" id="mastergraduationduration">
                            <option  value="">-select-</option>
                            <option value="1" <?php if($mastergraduationduration == "1"){echo 'selected="selected"'; } ;?>>1year</option>
                            <option value="2" <?php if($mastergraduationduration == "2"){echo 'selected="selected"'; } ;?>>2year</option>
                            <option value="3" <?php if($mastergraduationduration== "3"){echo 'selected="selected"'; } ;?>>3year</option>
                            <option value="4" <?php if($mastergraduationduration == "4"){echo 'selected="selected"'; } ;?>>4year</option>
                          </select>
                      </tr>
                      <tr>
                        <td class="text_1">Percentage </td>
                        <td align="left"><input type="text" name="mastergraduationpercentage" id="mastergraduationpercentage" style="width:150px; height:20px;" value="<?=$mastergraduationpercentage?>"/></td>
                      </tr>
                      
                        <td class="text_1"></td>
                        <td align="left"></td>
                      </tr>
                      
                        <td class="text_1"></td>
                        <td align="left"></td>
                      </tr>
                      
                        <td class="text_1"></td>
                        <td align="left"></td>
                      </tr>
                      
                        <td class="text_1"></td>
                        <td align="left"></td>
                      </tr>
                      
                        <td class="text_1"></td>
                        <td align="left"></td>
                      </tr>
                      
                        <td class="text_1"></td>
                        <td align="left"></td>
                      </tr>
                      
                        <td class="text_1"></td>
                        <td align="left"></td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                <tr>
                  <td colspan="2" style="text-align:center;"><input type="submit"  value="Submit" name="emp_education" id="emp_education"/>
                    <? if(isset($_SESSION['emp_id'])){
								    ?>
                    <input type="button"  value="Done" name="Submit_emp2" id="Submit_emp2" onClick="document.location='list_employee.php?ticket_no=<?=$ticket_no?>';"/>
                    <?	
                                        							}
								 ?>
                    <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" /></td>
                </tr>
              </table>
            </form>
          </div>
          <div <? if($mode=='education_detail'){ echo 'class="current"';}else{echo 'class="simpleTabsContent"';}?>>
            <form name="offical_profile" id="offical_profile" action="employee_detail.php" method="post" enctype="multipart/form-data" onSubmit="return valid_customer(this);">
              <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border" border="0" style="padding-top:10px;">
                <tr>
                  <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                      <tr>
                        <td class="text_1">Date of Joining</td>
                        <td align="left"><input type="text" name="date_joining" id="date_joining" style="width:150px; height:20px;" value="<?=getDatetime($date_joining)?>"/>
                          <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.offical_profile.date_joining);" HIDEFOCUS><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a></td>
                      </tr>
                      <tr>
                        <td class="text_1">Plant</td>
                        <td  align="left"><?
													 $sql = "SELECT * FROM mpc_plant_master order by plant_name";
													 $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
                                                     ?>
                          <select name="plant_name" id="plant_name" style="width:150px; height:20px;">
                            <option value="">Select</option>
                            <?
                                                  while ($row=mysql_fetch_array($result))
													{	?>
                            <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$plant){?> selected="selected" <? } ?>>
                            <?=$row["plant_name"]?>
                            </option>
                            <?  }	?>
                          </select></td>
                      </tr>
                      <tr>
                        <td class="text_1">Department</td>
                        <td align="left"><?
													 $sql = "SELECT * FROM mpc_department_master where reference_id='0' order by department_name";
													 $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
                                                     ?>
                          <select name="department" id="department" style="width:150px; height:20px;" onChange="get_frm('get_department.php',this.value,'div_sub_dept','sub_department');">
                            <option value="">Select</option>
                            <?
                                                  while ($row=mysql_fetch_array($result))
													{	?>
                            <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$dep){?> selected="selected" <? } ?>>
                            <?=$row["department_name"]?>
                            </option>
                            <?  }	?>
                          </select></td>
                      </tr>
                      <tr>
                        <td class="text_1">Sub Department</td>
                        <td align="left"><div id="div_sub_dept">
                            <?
													 $sql = "SELECT * FROM mpc_department_master where reference_id !='0' order by department_name";
													 $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
                                                     ?>
                            <select name="sub_department" id="sub_department" style="width:150px; height:20px;" onChange="">
                              <option value="">Select</option>
                              <?
                                                  while ($row=mysql_fetch_array($result))
													{	?>
                              <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$dept_id){?> selected="selected" <? } ?>>
                              <?=$row["department_name"]?>
                              </option>
                              <?  }	?>
                            </select>
                          </div></td>
                      </tr>
                      <tr>
                        <td class="text_1">Reporting Authority name</td>
                        <td align="left"><input type="text" name="authority_name" id="authority_name" style="width:150px; height:20px;" value="<?=$reporting_authority_name?>"/></td>
                      </tr>
                    </table></td>
                  <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                      <tr>
                        <td class="text_1">Grade</td>
                        <td align="left"><input type="text" name="grade" id="grade" style="width:150px; height:20px;" value="<?=$grade?>"/></td>
                      </tr>
                      <tr>
                        <td class="text_1">PAN No.</td>
                        <td align="left"><div id="div_add_div">
                            <input type="text" name="pan_no" id="pan_no" style="width:150px; height:20px;" value="<?=$pan_no?>"/>
                          </div></td>
                      </tr>
                      <tr>
                        <td class="text_1">Employee Type</td>
                        <td align="left"><select name="emp_type" id="emp_type">
                            <option value="fix_salary" <? if($employee_typ=='fix_salary'){ echo 'selected="selected"';} ?> >Fix Salary</option>
                            <option value="daily_wages" <? if($employee_typ=='daily_wages'){ echo 'selected="selected"';} ?>>Daily Wages</option>
                          </select></td>
                      </tr>
                      <tr>
                        <td class="text_1">Employee Catagory</td>
                        <td align="left"><select  name="emp_category" id="emp_category" onChange="get_frm('get_designation.php',this.value,'designation_div','designation');">
                            <option value="staff" <? if($emp_category=='staff'){ echo 'selected="selected"';}?>>Staff</option>
                            <option value="worker" <? if($emp_category=='Worker'){ echo 'selected="selected"';}?>>Worker</option>
                          </select></td>
                      </tr>
                      <tr>
                        <td class="text_1">Designation</td>
                        <td align="left"><div id="designation_div">
                            <?
													$sql = "SELECT * FROM  mpc_designation_master where emp_category  = '$emp_category' order by designation_name";
													$result_city = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
												?>
                            <select name="designation" id="designation" style="width:150px; height:20px;">
                              <option value="">Select</option>
                              <?
														if(mysql_num_rows($result_city)>0)
														{
															while($row_city = mysql_fetch_array($result_city))
															{
															?>
                              <option value="<?=$row_city['rec_id']?>" <? if($row_city['rec_id']==$designation_id){ echo 'selected="selected"';}?>>
                              <?=$row_city['designation_name']?>
                              </option>
                              <?
															}
														}
													?>
                            </select>
                          </div></td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td colspan="2" style="text-align:center;"><!-- ************************************Added pf details************************************************  *** -->
                    
                    <div id="div_show" >
                      <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                        <tr>
                          <td colspan="2" class="blackHead">PF Detail</td>
                        </tr>
                        <tr>
                          <td align="left"><table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                              <tr>
                                <td class="text_1">PF Number</td>
                                <td><input type="text" name="pf_no" id="pf_no" style="width:180px; height:20px;" value="<?=$pf_number?>"/></td>
                              </tr>
                              <tr>
                                <td class="text_1">PF Rate</td>
                                <td><input type="text" name="pf_rate" id="pf_rate" style="width:180px; height:20px;" value="<?=$pf_rate?>"/></td>
                              </tr>
                            </table></td>
                          <td><table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                              <tr>
                                <td class="text_1">PF Nominee</td>
                                <td><input type="text" name="pf_nominee" id="pf_nominee" style="width:180px; height:20px;" value="<?=$pf_nominee?>"/></td>
                              </tr>
                              <tr>
                                <td class="text_1">RelationShip</td>
                                <td><input type="text" name="pf_relationship" id="pf_relationship" style="width:180px; height:20px;" value="<?=$pf_relationship?>"/></td>
                              </tr>
                            </table></td>
                        </tr>
                        <tr>
                          <td colspan="2" class="blackHead">ESIC Detail (Employee State Insurance Corporation)</td>
                        </tr>
                        <tr>
                          <td><table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                              <tr>
                                <td class="text_1">ESIC Number</td>
                                <td><input type="text" name="esic_no" id="esic_no" style="width:180px; height:20px;" value="<?=$esic_number?>"/></td>
                              </tr>
                              <tr>
                                <td class="text_1">ESIC Rate</td>
                                <td><input type="text" name="esic_rate" id="esic_rate" style="width:180px; height:20px;" value="<?=$esic_rate?>"/></td>
                              </tr>
                            </table></td>
                          <td><table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                              <tr>
                                <td class="text_1">ESIC Nominee</td>
                                <td><input type="text" name="esic_nominee" id="esic_nominee" style="width:180px; height:20px;" value="<?=$esic_nominee?>"/></td>
                              </tr>
                              <tr>
                                <td class="text_1">RelationShip</td>
                                <td><input type="text" name="esic_relationship" id="esic_relationship" style="width:180px; height:20px;" value="<?=$esic_relationship?>"/></td>
                              </tr>
                            </table></td>
                        </tr>
                        <tr>
                          <td align="center" colspan="2"><?php /*?><input type="image" src="images/btn_submit.png" name="submit_pf" id="submit_pf" value="Submit" onclick="post_frm_long('pf_update.php',document.getElementById('pf_no').value,'div_detail',document.getElementById('pf_rate').value,document.getElementById('pf_nominee').value,document.getElementById('pf_relationship').value,document.getElementById('esic_no').value,document.getElementById('esic_rate').value,document.getElementById('esic_nominee').value,document.getElementById('esic_relationship').value,'<?=$id?>','','')"/><?php */?>
                            <input type="hidden" name="emp_id" id="emp_id" value="<?=$id?>"/>
                            <input type="hidden" name="update" id="update" value="<?=$id?>"/></td>
                        </tr>
                      </table>
                    </div>
                    
                    <!--****************************************End**************************************************--> 
                    
                    <!--****************************************Shift_details************************************************-->
                    
                    <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                      <tr>
                        <td colspan="2" class="blackHead">Shift Detail</td>
                      </tr>
                      <tr>
                        <td align="left"><table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                            <tr>
                              <td class="text_1" width="40%">Rotation Type</td>
                              <td align="left" width="60%"><div id="div_rotation_type_edit">
                                  <?=$rotation_type?>
                                  <div id="div_rotation_type"></div>
                                </div></td>
                              <td class="text_1">
                              <td align="center" valign="middle"><select name="rotation_type" id="rotation_type" style="width:150px; height:20px;">
                                  <option <?php if($rotation_type == 'Weekly'){echo 'selected';} ?> value="Weekly">Weekly</option>
                                  <option <?php if($rotation_type == '2 Week'){echo 'selected';} ?> value="2 Week">2 Week</option>
                                  <option <?php if($rotation_type == 'Monthly'){echo 'selected';} ?> value="Monthly">Monthly</option>
                                </select>
                                <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                <input type="hidden" name="emp_id" id="emp_id" value="<?=$product_id?>" />
                              <td><!--<input type="image" src="images/Modify.png" name="image_edit" id="image_edit" alt="Edit Rotation" title="Edit Rotation" onclick="get_frm('change_rotation_edit.php',document.getElementById('rotation_type').value,'div_rotation_type_change','<?//=$emp_id?>')" />&nbsp;</td>
 <td>
             <img src="images/Exit.png" alt="Cancel" title="Cancel" onClick="edit_div('div_rotation_type_edit','<?//=$rotation_type ?>')"></td>
	</tr> --> 
                                
                                <!--  <a href="javascript:;" onclick="get_frm('change_rotation.php','<?//=$rotation_type?>','div_rotation_type_edit','<?//=$id?>')">Change</a>  --></td>
                            </tr>
                            <tr>
                              <td class="text_1">Shift</td>
                              <td align="left"><div id="div_shift_type_edit">
                                  <?=$shift?>
                                  <div id="div_shift_type"></div>
                                </div></td>
                              <td class="text_1">
                              <td align="center" valign="middle"><select name="shift_duration" id="shift_duration" style="width:150px; height:20px;">
                                  <option <?php if($shift == 'A'){echo 'selected';} ?>  value="A">A</option>
                                  <option <?php if($shift == 'B'){echo 'selected';} ?> value="B">B</option>
                                  <option <?php if($shift == 'C'){echo 'selected';} ?> value="C">C</option>
                                  <option <?php if($shift == 'D'){echo 'selected';} ?> value="G">G</option>
                                </select>
                                <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                <input type="hidden" name="emp_id" id="emp_id" value="<?=$shift?>" />
                              <td><!--   <a href="javascript:;" onclick="get_frm('change_shift.php','<?=$shift?>','div_shift_type_edit','<?//=$id?>')">Change</a>  --></td>
                            </tr>
                          </table></td>
                        <td><table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                            <tr>
                              <td class="text_1" width="40%">Weekly OFF day</td>
                              <td align="left" width="60%"><div id="div_weekly_off_edit">
                                  <?=$off_day?>
                                  <div id="div_weekly_off"></div>
                                </div></td>
                              <td class="text_1"><!--  <a href="javascript:;" onclick="get_frm('change_weekly.php','<?//=$off_day?>','div_weekly_off_edit','<?//=$id?>')">Change</a>  -->
                                
                                <div id="change_weekly_off">
                                  <table width="60%" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td align="center" valign="middle"><select name="off_days" id="off_days" style="width:150px; height:20px;">
                                          <option <?php if($off_day == 'Sunday'){echo 'selected';} ?> value="Sunday">Sunday</option>
                                          <option <?php if($off_day == 'Monday'){echo 'selected';} ?> value="Monday">Monday</option>
                                          <option <?php if($off_day == 'Tuesday'){echo 'selected';} ?> value="Tuesday">Tuesday</option>
                                          <option <?php if($off_day == 'Wednesday'){echo 'selected';} ?> value="Wednesday">Wednesday</option>
                                          <option <?php if($off_day == 'Thursday'){echo 'selected';} ?> value="Thursday">Thursday</option>
                                          <option <?php if($off_day == 'Friday'){echo 'selected';} ?> value="Friday">Friday</option>
                                          <option <?php if($off_day == 'Saturday'){echo 'selected';} ?> value="Saturday">Saturday</option>
                                        </select>
                                        <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                        <input type="hidden" name="emp_id" id="emp_id" value="<?=$product_id?>" />
                                      <td><!--	<input type="image" src="images/Modify.png" name="image_edit" id="image_edit" alt="Edit Weekly Off" title="Edit Weekly Off" onclick="get_frm('change_weekly_edit.php',document.getElementById('off_days').value,'change_weekly_off','<?//=$emp_id?>')">&nbsp;
         </td>
         <td>
             <img src="images/Exit.png" alt="Cancel" title="Cancel" onClick="edit_div('div_weekly_off_edit','<?//=$weekly_off ?>')">  --></td>
                                    </tr>
                                  </table>
                                </div></td>
                            </tr>
                            <tr>
                              <td colspan="2">&nbsp;</td>
                            </tr>
                          </table></td>
                      </tr>
                      <!--    <tr>
    	<td colspan="2" align="center">
        	<input type="image" src="images/btn_submit.png" name="submit_shift" id="submit_shift" value="Submit"/>
            <input type="hidden" name="emp_id" id="emp_id" value="<?//=$id?>"/>
        </td>
    </tr>-->
                    </table>
                    
                    <!--**************************************end*************************************************************--> 
                    <!--*************************************Department Designation***************************************** -->
                    
                    <?php /*?><table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
	<tr>
    	<td colspan="2" class="blackHead">Department / Designation Detail</td>
    </tr>
	<tr>
    	<td align="left">
        	<div id="div_department_edit">
        	<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
            	<tr>
                	<td class="text_1" width="40%">Department</td>
                    <td align="left" width="60%">
                    	<?=getdeptDetail('department_name','rec_id',$main_dept_id)?>
                     </td>
                </tr>
                <tr>
                	<td class="text_1" width="40%">Sub Department</td>
                    <td align="left" width="60%">
                    	<div id="div_sub_department_edit"><?=getdeptDetail('department_name','rec_id',$dept_id)?><div id="div_rotation_type"></div>
                        </div>
                     </td>
                </tr>
                <tr>
                	<td class="text_1" width="40%">Effective From</td>
                    <td align="left" width="60%">
                    	<div id="div_from_date_edit"><?=$dept_from_date?><div id="div_rotation_type"></div>
                        </div>
                     </td>
                     <!--<td class="text_1">
                        <a href="javascript:;" onclick="get_frm('change_department.php','<?=$dept_id?>','div_department_edit','<?=$id?>'); get_frm2('change_sub_department.php','<?=$main_dept_id?>&old_dept_id=<?=$dept_id?>','div_sub_department_edit','<?=$id?>');get_frm_new('change_department_date.php','<?=$dept_from_date?>','div_from_date_edit','<?=$dept_id?>','<?=$id?>')">Change</a>
                    </td>-->
                    <td class="text_1">
                       <!-- <a href="javascript:;" onclick="post_frm('change_department.php','<?//=$dept_id?>','div_department_edit','<?//=$main_dept_id?>','','<?//=$dept_from_date?>','<?//=$id?>')">Change</a>  -->
                    </td>
                   
                </tr>
            </table>
            </div>
        </td>
        <td>
            <div id="div_category_edit">
            <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                <tr>
                    <td class="text_1" width="40%">Employee Type</td>
                    <td align="left" width="60%">
                     <?=$emp_type=getdesignationMaster('emp_category','rec_id', $designation_id)?>
                    </td>
                    <td class="text_1">
                    </td>
                </tr>
                 <tr>
                    <td class="text_1" width="40%">Designation</td>
                    <td align="left" width="60%">
                     <div id="div_designation_edit"><?=getdesignationMaster('designation_name','rec_id',$designation_id)?>
                        </div>
                    </td>
                </tr>
                 <tr>
                	<td class="text_1" width="40%">Effective From</td>
                    <td align="left" width="60%">
                    	<div id="div_from_date_edit_des"><?=$designation_from_date?><div id="div_rotation_type"></div>
                        </div>
                     </td>
                    <td class="text_1">
                    <!--	<a href="javascript:;" onclick="post_frm('change_category.php','<?//=$designation_id?>','div_category_edit','<//?=$emp_type?>','','<//?=$designation_from_date?>','<//?=$id?>')">Change</a>  --> 
                       <!--<a href="javascript:;" onclick="get_frm('change_category.php','<?//=$designation_id?>&emp_type=<?//=$emp_type?>','div_category_edit','<?//=$id?>'); get_frm2('change_designation.php','<?//=$emp_type?>&old_cat=<?//=$emp_type?>&old_des_id=<?//=$designation_id?>','div_designation_edit','<?//=$id?>')">Change</a>-->
                    </td>
                </tr>
            </table>
           </div>
        </td>
    </tr>
</table><?php */?>
                    
                    <!--****************************************end**********************************************************--> 
                    <!--********************************Bank detailos******************************************************  -->
                    
                    <div id="div_insert_bank">
                      <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                        <tr>
                          <td colspan="2" class="blackHead">Bank Detail</td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                              <tr>
                                <td class="text_1" width="60%">Mode of Payment</td>
                                <td align="left" width="40%"><select id="payment_mode" name="payment_mode">
                                    <option <?php if($payment_mode == 'Cash'){echo 'selected';} ?> selected value="Cash">Cash</option>
                                    <option <?php if($payment_mode == 'Cheque'){echo 'selected';} ?> value="Cheque">Cheque</option>
                                    <option <?php if($payment_mode == 'Online'){echo 'selected';} ?> value="Online">Online</option>
                                  </select></td>
                              </tr>
                            </table></td>
                          <td><table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                              <tr>
                                <td class="text_1" width="40%">Bank Name</td>
                                <td align="left" width="60%"><input type="text" name="bank_name" value="<?php echo $bank_name; ?>" id="bank_name" style="width:150px; height:20px;"/></td>
                              </tr>
                              <tr>
                                <td class="text_1" width="40%">Account Number</td>
                                <td align="left" width="60%"><input type="text" name="account_no" value="<?php echo $account_no; ?>" id="account_no" style="width:150px; height:20px;"/></td>
                              </tr>
                            </table></td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center"><!--<input type="image" src="images/btn_submit.png" name="submit_pf" id="submit_pf" value="Submit" onclick="post_frm('bank_update.php','1','div_insert_bank',document.getElementById('payment_mode').value,document.getElementById('bank_name').value,document.getElementById('account_no').value,'<?//=$id?>')"/>--></td>
                        </tr>
                      </table>
                    </div>
                    
                    <!--****************************************end**********************************************************-->
                    
                    <input type="submit"  value="Submit" name="emp_offical" id="emp_offical"/>
                    <? if(isset($_SESSION['emp_id'])){
								    ?>
                    <input type="button"  value="Done" name="Submit_emp2" id="Submit_emp2" onClick="document.location='list_employee.php?ticket_no=<?=$ticket_no?>';"/>
                    <?	
                                        							}
								 ?>
                    <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" /></td>
                </tr>
              </table>
            </form>
          </div>
          <div <? if($mode=='offical_profile'){ echo 'class="current"';}else{echo 'class="simpleTabsContent"';}?>>
            <form name="salary_detail" id="salary_detail" action="employee_detail.php" method="post" enctype="multipart/form-data" onSubmit="return valid_customer(this);">
              <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border" border="0" style="padding-top:10px;">
                <tr>
                  <td width="32%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                      <tr>
                        <td>Fixed Compensation </td>
                      </tr>
                      <tr>
                        <td class="text_1">Basic</td>
                        <td align="left"><input type="text" onBlur="sum_salary()" name="basic" id="basic" style="width:150px; height:20px;" value="<?=$basic?>"/></td>
                      </tr>
                      <tr>
                        <td class="text_1">HRA</td>
                        <td align="left"><input type="text" name="hra" id="hra" onBlur="sum_salary()" style="width:150px; height:20px;" value="<?=$hra?>"/></td>
                      </tr>
                      <!--<tr>
                                        <td class="text_1">LTA</td>
                                        <td align="left"><input type="text" name="lta" id="lta" style="width:150px; height:20px;" value="<?php  // $leave_travel_allow; ?>"/></td>
                                  </tr>-->
                      <tr>
                        <td class="text_1">Conveyance</td>
                        <td align="left"><input type="text" name="convence" onBlur="sum_salary()" id="convence" style="width:150px; height:20px;" value="<?=$convence?>"/></td>
                      </tr>
                      <!--<tr>
                                        <td class="text_1">Medical</td>
                                        <td align="left"><input type="text" name="medical" id="medical" style="width:150px; height:20px;" value="<?$medical?>"/></td>
                                    </tr>-->
                      
                      <tr>
                        <td class="text_1">Special Allowance</td>
                        <td align="left"><input type="text" name="side_allowance" id="side_allowance" style="width:150px; height:20px;" onBlur="sum_salary()" value="<?=$side_allowance?>"/></td>
                      </tr>
                      <tr>
                        <td class="text_1">Phone</td>
                        <td align="left"><input type="text" name="phone_allowance" id="phone_allowance" style="width:150px; height:20px;" onBlur="sum_salary()" value="<?=$phone_allowance?>"/></td>
                      </tr>
                      <tr>
                        <td class="text_1">Others</td>
                        <td align="left"><input type="text" name="others" id="others" style="width:150px; height:20px;" onBlur="sum_salary()" value="<?php echo $other_deductions?>"/></td>
                      </tr>
                      <tr>
                        <td class="text_1">Earning</td>
                        <td align="left"><input type="text" readonly="readonly" name="earning" id="earning" style="width:150px; height:20px;" value="<?php echo $earning;?>"/></td>
                      </tr>
                    </table></td>
                  <td width="36%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                      <tr>
                        <td>Employee Contribution</td>
                      </tr>
                      <!--<tr>
                                        <td class="text_1">Professional Tax</td>
                                        <td align="left"><input type="text" name="p_tax" id="p_tax" style="width:150px; height:20px;" value="<?$professional_tax?>"/></td>
                                    </tr>--> 
                      <!--<tr>
                                        <td class="text_1">TDS</td>
                                        <td align="left"><input type="text" name="tds" id="tds" style="width:150px; height:20px;" value="<?$tds?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">Advance</td>
                                        <td align="left"><input type="text" name="advance" id="advance" style="width:150px; height:20px;" value="<?$advance?>"/></td>
                                    </tr>
                                     <tr>
                                        <td class="text_1">Loan</td>
                                        <td align="left"><input type="text" name="loan" id="loan" style="width:150px; height:20px;" value="<?$loan?>"/></td>
                                    </tr>-->
                      <tr>
                        <td class="text_1">PF Deduction </td>
                        <td>Celling
                          <input  type="radio" onClick="sum_salary()"  value="yes" id="cell" name="cell">
                          Nocelling
                          <input type="radio" onClick="sum_salary()" checked id="nocell" value="no" name="cell"></td>
                      </tr>
                      <tr>
                        <td class="text_1">PF</td>
                        <td align="left"><input readonly="readonly" type="text" name="PF" id="PF" style="width:150px; height:20px;" value="<?php echo $pf;?>"/></td>
                      </tr>
                      <tr>
                        <td class="text_1">ESIC</td>
                        <td align="left"><input type="text" readonly="readonly" name="ESIC" id="ESIC" style="width:150px; height:20px;" value="<?php echo $esic;?>"/></td>
                      </tr>
                      <tr>
                        <td class="text_1">Bonus</td>
                        <td align="left"><input type="text" onBlur="sum_salary()"  name="bonus" id="bonus" style="width:150px; height:20px;" value="<?php  echo $bonus;?>"/></td>
                      </tr>
                      <tr>
                        <td class="text_1">Deduction </td>
                        <td><input type="text" name="deduction" readonly="readonly" id="deduction" style="width:150px; height:20px;" value="<?php echo $deduction;?>"/></td>
                      </tr>
                    </table></td>
                  <td width="32%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                      <tr>
                        <td>Employer Contribution</td>
                      </tr>
                      <tr>
                        <td class="text_1">PF</td>
                        <td align="left"><input readonly="readonly" type="text" name="PF1" id="PF1" style="width:150px; height:20px;" value="<?php echo $pf;?>"/></td>
                      </tr>
                      <tr>
                        <td class="text_1">ESIC</td>
                        <td align="left"><input type="text" readonly="readonly" name="ESIC1" id="ESIC1" style="width:150px; height:20px;" value="<?php echo $esic;?>"/></td>
                      </tr>
                      <tr>
                        <td class="text_1">Medical</td>
                        <td align="left"><input type="text" onBlur="sum_salary()" name="medical" id="medical" style="width:150px; height:20px;" value="<?php echo $medical;?>"/></td>
                      </tr>
                      <tr>
                        <td class="text_1">Gratuity</td>
                        <td><input type="text" name="gratuity" onBlur="sum_salary()" id="gratuity" style="width:150px; height:20px;" value="<?php echo $graduity;?>"/></td>
                      </tr>
                      <tr>
                        <td class="text_1">Deduction </td>
                        <td><input type="text" readonly="readonly" name="deduction1" id="deduction1" style="width:150px; height:20px;" value="<?php echo $deduction;?>"/></td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td colspan="2" style="text-align:center;"><input type="submit"  value="Submit" name="emp_salary" id="emp_salary"/>
                    <? if(isset($_SESSION['emp_id'])){
								    ?>
                    <input type="button"  value="Done" name="Submit_emp2" id="Submit_emp2" onClick="document.location='list_employee.php?ticket_no=<?=$ticket_no?>';"/>
                    <?	
                                        							}
								 ?>
                    <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" /></td>
                </tr>
              </table>
            </form>
          </div>
        </div></td>
        </tr>
      
    </table></td>
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
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:5000; position:absolute; left:-500px; top:0px;"> </iframe>
<? include ("inc/hr_footer.php"); ?>
<script language="javascript1.2">
function sum_salary()
{
	var total_earning=0;
	var a1=0;
	var a2=0;
	var a3=0;
	var a4=0;
	var a5=0;
	var a6=0;
	
	a1 = document.getElementById('basic').value;
	a2 =document.getElementById('convence').value;
	a3 =document.getElementById('hra').value;
	a4 =document.getElementById('side_allowance').value;
	a5 =document.getElementById('others').value;
	a6 =document.getElementById('phone_allowance').value;
	bonus =document.getElementById('bonus').value;
	medical =document.getElementById('medical').value;

	gratuity =document.getElementById('gratuity').value;

	//var a7 =document.getElementById('professional_tax').value;
	//var a8 =document.getElementById('tds').value;
	//var a9 =document.getElementById('other_deduction').value;
	
	var a10 =document.getElementById('pf_rate').value;
	var a11 =document.getElementById('esic_rate').value;
	if (document.getElementById('cell').checked) {
  a12 = document.getElementById('cell').value;
}
if (document.getElementById('nocell').checked) {
  a12 = document.getElementById('nocell').value;
}
//		var	a12 =document.getElementById('cellin_val').value;


total_earning=parseInt (+a1)+ parseInt (+a2)+ parseInt (+a3)+parseInt (+a4)+parseInt (+a5)+ parseInt (+a6);
 
	 a10 = a10.replace('%','');
	 
	if(a12 == 'yes' && a1>6500){ 	var pf=(a10*6500)/100;} 
	else{ var pf=(a10*a1)/100;}
	
	var esi =(a11*total_earning)/100;
	//alert(esi);
	document.getElementById('earning').value=total_earning;
	//document.getElementById('total_earning').value=total_earning;
	
	 document.getElementById('PF').value=parseInt(pf);
	 document.getElementById('PF1').value=parseInt(pf);
	 document.getElementById('ESIC').value=parseInt(esi);
	 document.getElementById('ESIC1').value=parseInt(esi);
	
	var employerdeduction = parseInt(+pf)+parseInt(+esi)+parseInt(+bonus);
	 document.getElementById('deduction').value=parseInt(employerdeduction);
	 	var employerdeduction1 = parseInt(+pf)+parseInt(+esi)+parseInt(+medical)+parseInt(+gratuity);
	 	 document.getElementById('deduction1').value=parseInt(employerdeduction1);
	
	//var total_deduction=parseInt(a7)+parseInt(a8)+parseInt(a9)+pf+esi;
	//document.getElementById('total_deduction').value=total_deduction;
	
	
	//var a =document.getElementById(salary_basic).value=value1;
	//var a =document.getElementById(div_id2).value=value2;
}
function removeElements(divNum,myDiv) 
{
	var d = document.getElementById(myDiv);
	var olddiv = document.getElementById(divNum);
	d.removeChild(olddiv);
}
</script>
</body>

