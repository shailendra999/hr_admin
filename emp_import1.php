<? include ("inc/hr_header.php"); ?>

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;"><? include ("inc/snb.php"); ?></td>
    <td style="padding-left:5px; padding-top:5px;"><table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
        <tr>
          <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add Employee By CSV File</td>
        </tr>
        <tr>
        <td>
          <form enctype='multipart/form-data' action='' method='post'>
            File name to import:<br />
            <input size='50' type='file' name='filename'>
            <br />
            <input type='submit' name='submit' value='Upload'>
          </form></td>
        </tr>
      </table>
  </tr>
</table>
<div id="form">
<?php
//Upload File
if (isset($_POST['submit'])) {
$filename=$_FILES["file"]["tmp_name"];
			echo "***".$filename."<br>";
		 if($_FILES["file"]["size"] > 0)
		 {
		  	$file = fopen($filename, "r");
			 echo "***".$file."<br>";
			 
			 while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
	         {
				 echo "<pre>";
				 print_r($emapData);
				 
				 die();
				 //Added this code for employee ID
				 if(!empty($data[0]) and !empty($data[1]) and !empty($data[2]) and  !empty($data[3]))
				 {
					 $year =  date("Y");
		$sql = "SELECT ticket_no FROM ".$mysql_table_prefix."employee_master ORDER BY rec_id DESC LIMIT 1";
		$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());	

        $row = mysql_fetch_row($result);
		
		if($row == ""){
			
			$emp_login = '101';
			}
			else{
				$emp_login = substr($row[0], 4);
				$emp_login++;
				}
				$emp_login = $year.$emp_login;
				
					 
				 if($emapData[0]=="Sr.no" && $emapData[1]=="PF NO" && $emapData[2]=="ESIC NO" && $emapData[3] == "Name of Employee" ) 
				 {
					
				 }
				 else
				 {
					$sql="INSERT INTO ".$mysql_table_prefix."employee_master(rec_id, emp_id, ticket_no, empType, username, password, first_name, last_name, father_husband_name, address, correspondance, country, state, other_state, city, pincode, dob, pob, gender, eye, illness, height, height_inch, weight, phone_no, mobile_no, emergancy_contact, email_id, email_official, marital_status, employee_picture, marriage_date, blood_group, cast, category, religion, nationality, reference, reference_contact, hobby, habit, designation, department, date_joining, sub_department, pan_no) VALUES ('$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]','$emapData[4]','$emapData[5]','$emapData[6]','$emapData[7]',
			 '$emapData[8]','$emapData[9]','$emapData[10]','$emapData[11]','$emapData[12]','$emapData[13]','$emapData[14]','$emapData[15]','$emapData[16]','$emapData[17]','$emapData[18]','$emapData[19]','$emapData[20]','$emapData[21]','$emapData[22]',
			 '$emapData[23]','$emapData[24]','$emapData[25]','$emapData[26]','$emapData[27]','$emapData[28]','$emapData[29]',
			 '$emapData[30]','$emapData[31]','$emapData[32]','$emapData[33]','$emapData[34]','$emapData[35]','$emapData[36]',
			 '$emapData[37]','$emapData[38]','$emapData[39]','$emapData[40]','$emapData[41]','$emapData[42]','$emapData[43]',
			 '$emapData[44]','$emapData[45]')";
			  $result = mysql_query( $sql, $conn );
			  
			  // inserting the value of username and password in mpc_login_master.
			  echo $emapData[4];
			  echo $emapData[5];
			  $sql = "insert into mpc_login_master set 
		Username = '$emapData[4]',Password = '$emapData[5]',UserType = 'User',IsActive= '1'";
		
		$result_insert_personal = mysql_query($sql) or die("Error in query:".$sql_insert_personal."<br>".mysql_error()."<br>".mysql_errno());
			  
			  
				 }
			  
				 }

            }

            fclose($file);

        } else

            echo 'Invalid File:Please Upload CSV File';

 
 		 }

?>		

