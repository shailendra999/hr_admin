<? $pgName = ""; ?>
<? include("inc/hr_header.php"); ?>
<?
include("inc/dbconnection.php");
include("inc/function.php");
?>
<style type="text/css" media="screen">
@import "tab/css/style.css";
@import "tab/css/simpletabs.css";
</style>
<?
$msg = '';
$mode='';
if(!session_is_registered("no_refresh"))
{
	$_SESSION['no_refresh'] = "";
}

if(isset($_POST['reg_s1']))
{
	if($_POST['no_refresh'] == $_SESSION['no_refresh'])
	{	
		//echo "WARNING: Do not try to refresh the page.";
	}
	else
	{	
		////////////////////login deatil
		$emp_login = $_POST['emp_login'];
		$password = $_POST['password'];
		
		
		$sql_insert_login = "insert into ".$mysql_table_prefix."login_master  set 
			UserName = '$emp_login',
			Password = '$password',
			UserType = 'Empolyee',
			IsActive = '0',
			InsertDate= now()";
																				
		$result_login = mysql_query($sql_insert_login) or die("Error in query:".$sql_insert_login."<br>".mysql_error()."<br>".mysql_errno());
		$emp_id = mysql_insert_id();
		
		$_SESSION['emp_id'] = $emp_id;
		
		
		$first_name = $_POST['first_name'];
		$last_name=$_POST['last_name'];
		$address=$_POST['address'];
		$country = $_POST['country'];
		$state=isset($_POST['state']) ? $_POST['state'] : 0;
		$other_state = isset($_POST['txt_other_state']) ? $_POST['txt_other_state'] : "";
		$other_city =  isset($_POST['city']) ? $_POST['city'] : "";
		$city = isset($_POST['city_select']) ? $_POST['city_select'] : 0;
		$dob = $_POST['dob'];
		$gender = $_POST['gender'];
		
		$phone_no = $_POST['phone_no'];
		$email_id = $_POST['email_id'];
		$marital = $_POST['marital'];
		$marr_date = $_POST['marr_date'];
		$blood_group = $_POST['blood_group'];
		$nationality = $_POST['nationality'];
		$reference = $_POST['reference'];



		$sql_insert_personal = "insert into ".$mysql_table_prefix."employee_master  set 
			emp_id = '$emp_id',
			first_name = '$first_name',
			last_name = '$last_name',
			address = '$address',
			country = '$country',
			state = '$state',
			other_state = '$other_state',
			city = '$city',
			dob = '$dob',
			gender = '$gender',
			phone_no = '$phone_no',
			email_id = '$email_id',
			marital_status = '$marital',
			marriage_date = '$marr_date',
			blood_group = '$blood_group',
			nationality = '$nationality',		
			reference = '$reference'";
			
	    $result_insert_personal = mysql_query($sql_insert_personal) or die("Error in query:".$sql_insert_personal."<br>".mysql_error()."<br>".mysql_errno());
		$emp_rec_id = mysql_insert_id();
		
		
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
						
						
						$msg ='Image Change';
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
		$father_dob = $_POST['father_dob'];
		$father_occupation = $_POST['father_occupation'];
		$mother_dob = $_POST['mother_dob'];
		$mother_occupation = $_POST['mother_occupation'];

		
		$sql_insert_family = "insert into ".$mysql_table_prefix."family_master  set 
			emp_id = '".$_SESSION['emp_id']."',
			father_name = '$father_name',
			father_dob = '$father_dob',
			Dependant_father = '$Dependant_member1',
			father_occupation = '$father_occupation',
			mother_name = '$mother_name',
			mother_occupation = '$mother_occupation',
			mother_dob = '$mother_dob',
			Dependant_mother = '$Dependant_member2'";
																				
		$result_family = mysql_query($sql_insert_family) or die("Error in query:".$sql_insert_family."<br>".mysql_error()."<br>".mysql_errno());
		
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

		
		$sql_insert_education = "insert into ".$mysql_table_prefix."education_master  set 
			emp_id = '$emp_id',
			qualification = '$qualification',
			university = '$university',
			duration = '$duration',
			percentage = '$percentage'";
																				
		$result_family_education = mysql_query($sql_insert_education) or die("Error in query:".$sql_insert_education."<br>".mysql_error()."<br>".mysql_errno());
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

if(isset($_POST['emp_official']))
{
	if($_POST['no_refresh'] == $_SESSION['no_refresh'])
	{	
		//echo "WARNING: Do not try to refresh the page.";
	}
	else
	{			
	
		
		$date_joining = $_POST['date_joining'];
		$probation_period = $_POST['probation_period'];
		$comformation_date = $_POST['comformation_date'];
		$bank_name = $_POST['bank_name'];
		$department = $_POST['department'];
		$grade = $_POST['grade'];
		$authority_name = $_POST['authority_name'];
		$pan_no = $_POST['pan_no'];
		$pf_no = $_POST['pf_no'];
		$mode_payment = $_POST['mode_payment'];
		$account_no = $_POST['account_no'];
		$designation = $_POST['designation'];
		$emp_type = $_POST['emp_type'];
		
		$sql_insert_offical = "insert into ".$mysql_table_prefix."official_detail  set 
			emp_id = '$emp_id',
			date_joining = '$date_joining',
			probation_period= '$probation_period',
			confirmation_date= '$comformation_date',
			pan_no = '$pan_no',
			pf_no = '$pf_no',
			mode_payment = '$mode_payment',
			bank_account_no = '$account_no',
			bank_name = '$bank_name',
			department = '$department',
			designation = '$designation',
            grade = '$grade',
			employee_typ = '$emp_type',
			reporting_authority_name = '$authority_name'";
			
	    $result_insert_offical = mysql_query($sql_insert_offical) or die("Error in query:".$sql_insert_offical."<br>".mysql_error()."<br>".mysql_errno());
		$mode='emp_offical';
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
			document.getElementById('div_city').innerHTML='<input type="text" name="txt_other_state" id="txt_other_state" value="" class="inputfield">';
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
	if(radio_value.value=='Single')
		{
			text_box.disabled=true;	
		}
	else
		{
			text_box.disabled=false;	
		}
}	
</script> 

<table  width="100%" cellpadding="2" cellspacing="2" border="0" bgcolor="#FFFFFF" style="vertical-align:top;">
    <tr>
        <td >Employee Registration Form</td>
    </tr>
    <tr>
        <td class="red"><?=$msg?></td>
    </tr>
    <tr>
        <td style="vertical-align:top;">
          <div class="simpleTabs">
            <ul class="simpleTabsNavigation">
              <li><a href="employee_detail.php?mode=" <? if($mode==''){ echo 'class="current"';}?>>Personal Detail</a></li>
              <li><a href="employee_detail.php?mode=personal_detail"<? if($mode=='personal_detail'){ echo 'class="current"';}?>>Family Detail</a></li>
              <li><a href="employee_detail.php?mode=family_detail"<? if($mode=='family_detail'){ echo 'class="current"';}?>>Education details</a></li>
              <li><a href="employee_detail.php?mode=education_detail"<? if($mode=='education_detail'){ echo 'class="current"';}?>>Salary details</a></li>
              <li><a href="employee_detail.php?mode=emp_offical"<? if($mode=='emp_offical'){ echo 'class="current"';}?>>Offical details</a></li>
            </ul>
    <div <? if($mode==''){ echo 'class="current"';}else{echo 'class="simpleTabsContent"';}?>>
       <form name="empolyee_profile" id="empolyee_profile" action="employee_detail.php" method="post" enctype="multipart/form-data" onSubmit="return valid_customer(this);">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding-top:50px;">
                <tr>
                 <td colspan="2" align="center">
              			 <table cellpadding="0" cellspacing="0" border="0" width="775" align="center">
    <tr>
                                <td>Empolyee Code<span class="red">*</span></td>
                                <td><input type="text" name="emp_login" id="emp_login" onBlur="check_login_id(this.value);" ></td>
                                <td><div id="check_login"></div></td>
                                <td>Password <span class="red">*</span></td>
                                <td><input type="password" name="password" id="password" /></td>
                                <td>Retype Password <span class="red">*</span></td>
                                <td><input type="password" name="re_password" id="re_password" /></td>
                            </tr>    
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                         <table width="100%" cellpadding="2" cellspacing="2" class="border" border="0">
                            <tr>
                                <td class="text_1">First Name<span class="red">*</span></td>
                                <td align="left"><input type="text" name="first_name" id="first_name" /></td>
                            </tr>
                            <tr>
                                <td class="text_1">Last Name<span class="red">*</span></td>
                                <td align="left"><input type="text" name="last_name" id="last_name" /></td>
                            </tr>
                            <tr>
                                <td class="text_1">Address<span class="red">*</span></td>
                                <td align="left"><textarea name="address" id="address" rows="3" cols="15"></textarea></td>
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
                                <option value="<?=$row['countries_id']?>" <? if($row['countries_id']==99){?> selected="selected" <? } ?>><?=$row["countries_name"]?></option>
                                <?  }	?>
                                </select>
                                </td>
                            </tr>
                             <tr>
                                <td class="text_1">State<span class="red">*</span></td>
                                <td align="left"><div id="div_add_state">
                                <? $sql = "SELECT * FROM mpc_state_master where country_id = '99' order by state_name";
                                $result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
                                ?>
                                <select name="state" id="state" onChange="get_frm('get_city_reg.php',this.value,'div_city','city');">
                                <option value="">--select state--</option>
                                <? 
                                while ($row=mysql_fetch_array($result))
                                {
                                ?>
                                <option value="<?=$row['rec_id']?>">
                                <?=$row["state_name"]?>
                                </option>
                                <?
                                }
                                ?>
                                </select>
                                </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text_1">City<span class="red">*</span></td>
                                <td align="left">
                                <div id="div_city">
                                   <select name="city_select" id="city_select">
                                    <option value="">--select city--</option>
                                    <? 
                                    while ($row=mysql_fetch_array($result))
                                    {
                                    ?>
                                    <option value="<?=$row['rec_id']?>">
                                    <?=$row["city_name"]?>
                                    </option>
                                    <?
                                    }
                                    ?>
                                    </select>
                                 </div>
                            </tr>
                            <tr>
                                <td class="text_1">Pin Code<span class="red">*</span></td>
                                <td align="left"><input type="text" name="dob" id="dob" /></td>
                            </tr>
                            
                            <tr>
                                <td class="text_1">Date Of Birth<span class="red">*</span></td>
                                <td align="left"><input type="text" name="dob" id="dob" /></td>
                            </tr>                    
                        </table>
                     </td>
                     <td width="50%">
                       		 <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border" border="0">
                             <tr>
                                <td class="text_1">Gender<span class="red">*</span></td>
                                <td align="left"><input type="radio" id="gender" name="gender" value="Male"/>Male
                                                <input type="radio" id="gender" name="gender" value="Female"/>Female
                                </td>                           
                           </tr>
                            <tr>
                                <td class="text_1">Phone<span class="red">*</span></td>
                                <td align="left"><input type="text" name="phone_no" id="phone_no" /></td>
                            </tr>
                             <tr>
                                <td class="text_1">Email Id<span class="red">*</span></td>
                                <td align="left"><input type="text" name="email_id" id="email_id" /></td>
                            </tr>
                            <tr>
                                <td class="text_1">Marital Status<span class="red">*</span></td>
                                <td align="left"><input type="radio" id="marital" name="marital" value="Married" onClick="marriage_date(this)"/>Married
                                                <input type="radio" id="marital" name="marital" value="Single" onClick="marriage_date(this)"/>Single</td>
                            </tr>
                             <tr>
                                <td class="text_1">if Married then date of Marriage<span class="red">*</span></td>
                                <td align="left"><input type="text" name="marr_date" id="marr_date" disabled="disabled"/></td>
                            </tr>
                             <tr>
                                <td class="text_1">Blood Group<span class="red">*</span></td>
                                <td align="left"><select name="blood_group" id="blood_group">
                                                    <option value="">---Select---</option>
                                                    <option value="O-">O-</option>
                                                    <option value="O+">O+</option>
                                                    <option value="A-">A-</option>
                                                    <option value="A+">A+</option>
                                                    <option value="B-">B-</option>
                                                    <option value="B+">B+</option>
                                                    <option value="AB-">AB-</option>
                                                    <option value="AB+">AB+</option>
                                                </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="text_1">Religion<span class="red">*</span></td>
                                <td align="left"><input type="text" name="dob" id="dob" /></td>
                            </tr>
                             <tr>
                                <td class="text_1">Nationality</td>
                                <td align="left"><input type="text" name="nationality" id="nationality" /></td>
                            </tr> 
                             <tr>
                                <td class="text_1">Reference</td>
                                <td align="left"><input type="text" name="reference" id="reference" /></td>
                            </tr>  
                            <tr>
                                <td class="text_1">Employee picture<span class="red">*</span></td>
                                <td align="left"><input type="file" name="emp_pic" id="emp_pic" /></td>
                            </tr>
                        </table>
                     </td>
                </tr>
                <tr>
                	  <td colspan="2" style="text-align:center;">
                      	<input type="submit"  value="Submit" name="reg_s1" id="reg_s1"/>
 <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                      </td>
                </tr>
             </table>
             </form>
        </div>
    <div <? if($mode=='personal_detail'){ echo 'class="current"';}else{echo 'class="simpleTabsContent"';}?>>
    <form name="empolyee_family" id="empolyee_family" action="employee_detail.php" method="post" enctype="multipart/form-data" onSubmit="return valid_customer(this);">
		<table align="center" width="100%" cellpadding="2" cellspacing="2" class="border" border="0" style="padding-top:50px">
            <tr>
                <td width="50%" valign="top">
                    <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                        <tr>
                            <td class="text_1">Father Name <span class="red">*</span></td>
                            <td align="left"><input type="text" name="father_name" id="father_name"/></td>
                        </tr>
                        
                        <tr>
                            <td class="text_1">Depended<span class="red">*</span></td>
                            <td align="left"><input type="radio" id="Dependant_member1" name="Dependant_member1" value="Yes"/>Yes
                                            <input type="radio" id="Dependant_member1" name="Dependant_member1" value="No"/>No
                            </td>
                        </tr>
                        <tr>
                            <td class="text_1">Mother Name <span class="red">*</span></td>
                            <td align="left"><input type="text" name="mother_name" id="mother_name" /></td>
                        </tr>
                        
                        <tr>
                            <td class="text_1">Depended<span class="red">*</span></td>
                            <td align="left"><input type="radio" id="Dependant_member2" name="Dependant_member2" value="Yes"/>Yes
                                            <input type="radio" id="Dependant_member2" name="Dependant_member2" value="No"/>No
                            </td>
                        </tr>
                     </table>
                </td>
                <td width="50%" valign="top">
                    <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                       <tr>
                            <td class="text_1">Date of Birth<span class="red">*</span></td>
                            <td align="left"><input type="text" name="father_dob" id="father_dob" /></td>
                        </tr>
                         <tr>
                            <td class="text_1">Occupation</td>
                            <td align="left"><input type="text" name="father_occupation" id="father_occupation" /></td>
                        </tr>
                         <tr>
                            <td class="text_1">Date of Birth <span class="red">*</span></td>
                            <td align="left"><input type="text" name="mother_dob" id="mother_dob" /></td>
                        </tr>
                         <tr>
                            <td class="text_1">Occupation</td>
                            <td align="left"><input type="text" name="mother_occupation" id="mother_occupation" /></td>
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
<table align="center" width="100%" cellpadding="2" cellspacing="2" class="border" border="0"  style="padding-top:50px;">
            <tr>
                <td class="Form" colspan="2">Education details</td>
            </tr>
            <tr>
                <td width="50%" valign="top">
                    <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                        <tr>
                            <td class="text_1">Qualification<span class="red">*</span></td>
                            <td align="left"><input type="text" name="qualification" id="qualification" /></td>
                        </tr>
                        <tr>
                            <td class="text_1">University  <span class="red">*</span></td>
                            <td class="text_2" align="left"><input type="text" name="university" id="university"  onblur="check_email(this.value,'st');"/><div id="div_email"></div></td>
                        </tr>
                     </table>
                </td>
                <td width="50%" valign="top">
                    <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                        <tr>
                            <td class="text_1">Couse Duration</td>
                            <td align="left"><input type="text" name="duration" id="duration" /></td>
                        </tr>
                        <tr>
                            <td class="text_1">Percentage </td>
                            <td align="left"><input type="text" name="percentage" id="percentage" /></td>
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
    <form name="empolyee_salary" id="empolyee_salary" action="employee_detail.php" method="post" enctype="multipart/form-data" onSubmit="return valid_customer(this);">
    <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border" border="1"  style="padding-top:50px;">
        <tr>
            <td width="50%" valign="top">
                <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                	<tr>
                        <td colspan="2" class="text_1">Earning</td>
                    </tr> 
                    <tr>
                        <td class="text_1">Basic & DA<span class="red">*</span></td>
                        <td align="left"><input type="text" name="skill_name" id="skill_name" /></td>
                    </tr> 
                    <tr>
                        <td class="text_1">HRA<span class="red">*</span></td>
                        <td align="left"><input type="text" name="skill_name" id="skill_name" /></td>
                    </tr>
                    <tr>
                        <td class="text_1">Conveyance<span class="red">*</span></td>
                        <td align="left"><input type="text" name="skill_name" id="skill_name" /></td>
                    </tr>                                                                 
                 </table>
            </td>
            <td width="50%" valign="top">
                <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                    <tr>
                        <td colspan="2" class="text_1">Deduction</td>
                    </tr>
                    <tr>
                        <td class="text_1">Provident Fund</td>
                        <td align="left"><input type="text" name="experience" id="experience" /></td>
                    </tr>
                     <tr>
                        <td class="text_1">P/Pay<span class="red">*</span></td>
                        <td align="left"><input type="text" name="skill_name" id="skill_name" /></td>
                    </tr>
                    <tr>
                        <td class="text_1">Other Gain<span class="red">*</span></td>
                        <td align="left"><input type="text" name="skill_name" id="skill_name" /></td>
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
    <div <? if($mode=='emp_offical'){ echo 'class="current"';}else{echo 'class="simpleTabsContent"';}?>>
 <form name="empolyee_official" id="empolyee_official" action="employee_detail.php" method="post" enctype="multipart/form-data" onSubmit="return valid_customer(this);">
    <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border" border="0"  style="padding-top:50px;">
        <tr>
            <td width="50%" valign="top">
                <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                    <tr>
                        <td class="text_1">Date of Joining<span class="red">*</span></td>
                        <td align="left"><input type="text" name="date_joining" id="date_joining" /></td>
                    </tr>
                    <tr>
                        <td class="text_1">Probation Period<span class="red">*</span></td>
                        <td  align="left"><input type="text" name="probation_period" id="probation_period" /></td>
                    </tr>
                    <tr>
                        <td class="text_1">Confirmation Date</td>
                        <td align="left"><input type="text" name="comformation_date" id="comformation_date" /></td>
                    </tr>
                    <tr>
                        <td class="text_1">Bank Name<span class="red">*</span></td>
                        <td align="left"><input type="text" name="bank_name" id="bank_name" /></td>
                    </tr>
                    <tr>
                        <td class="text_1">Department<span class="red">*</span></td>
                        <td align="left"><input type="text" name="department" id="department" /></td>
                    </tr>
                    <tr>
                        <td class="text_1">Grade<span class="red">*</span></td>
                        <td align="left"><input type="text" name="grade" id="grade" /></td>
                    </tr>
                    <tr>
                        <td class="text_1">Reporting Authority name<span class="red">*</span></td>
                        <td align="left"><input type="text" name="authority_name" id="authority_name" /></td>
                    </tr>
                 </table>
            </td>
            <td width="50%" valign="top">
                <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                    <tr>
                        <td class="text_1">PAN No.</td>
                        <td align="left"><div id="div_add_div">
                        <input type="text" name="pan_no" id="pan_no"/>                                                                   
                        </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text_1"> PF Number<span class="red">*</span></td>
                        <td align="left"><input type="text" name="pf_no" id="pf_no" /></td>
                    </tr>
                    <tr>
                        <td class="text_1">Mode of Payment </td>
                        <td align="left">
                            <select name="mode_payment" id="mode_payment">
                                <option value="">--select--</option>
                                <option value="Cash">Cash</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="Cheque">Cheque</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="text_1">Bank Account No.<span class="red">*</span></td>
                        <td align="left"><input type="text" name="account_no" id="account_no" /></td>
                    </tr>
                    <tr>
                        <td class="text_1">Designation<span class="red">*</span></td>
                        <td align="left"><input type="text" name="designation" id="designation" /></td>
                    </tr>
                    <tr>
                        <td class="text_1">Employee Type<span class="red">*</span></td>
                        <td align="left"><input type="text" name="emp_type" id="emp_type" /></td>
                    </tr>
                    <tr>
                        <td class="text_1">Employee Catagory<span class="red">*</span></td>
                        <td align="left"><input type="text" name="emp_type" id="emp_type" /></td>
                    </tr>
                     <tr>
                          <td colspan="2" style="text-align:center;">
                            <input type="submit"  value="Submit" name="emp_official" id="emp_official"/>
                             <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                          </td>
                    </tr>
                 </table>
             </td>
         </tr>        
		</table>
        </form>
        </div>
    </div>
  </div>                                          
	
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
<? include ("inc/footer.php"); ?>

<tr>
                                <td class="text_1">Catagory<span class="red">*</span></td>
                                <td align="left"><select name="catagory" id="catagory">
                                                    <option value="Staff">Staff</option>
                                                    <option value="Worker">Worker</option>
                                                 </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="text_1">Employee Type<span class="red">*</span></td>
                                <td align="left"><select name="employee_type" id="employee_type">
                                                    <option value="Fix_Salary">Fix Salary</option>
                                                    <option value="Daily_wagar">Daily Wagar</option>
                                                 </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="text_1">Weekly Off<span class="red">*</span></td>
                                <td align="left"><select name="weekly_off" id="weekly_off">
                                                    <option value="">---Select---</option>
                                                    <option value="Sunday">Sunday</option>
                                                    <option value="Manday">Manday</option>
                                                    <option value="Tuesday">Tuesday</option>
                                                    <option value="Wenesday">Wenesday</option>
                                                    <option value="Thuesday">Thuesday</option>
                                                    <option value="Friday">Friday</option>
                                                    <option value="Satarday">Satarday</option>
                                                </select>
                                </td>
                            </tr>
                             <tr>
                                <td class="text_1">Shift<span class="red">*</span></td>
                                <td align="left"><select name="shift" id="shift">
                                                    <option value="">---Select---</option>
                                                    <option value="I">I</option>
                                                    <option value="II">II</option>
                                                    <option value="III">III</option>
                                                </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="text_1">Shift Incharge <span class="red">*</span></td>
                                <td align="left"><input type="radio" name="shift_incharge" id="shift_incharge" value="Yes"/>Yes
                                                <input type="radio" name="shift_incharge" id="shift_incharge" value="No"/>No
                                </td>
                            </tr>