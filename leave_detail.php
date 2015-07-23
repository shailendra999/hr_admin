<?php
	include("inc/hr_header.php");
?>
<script language="JavaScript">
function openWindow(url,id) {
   window.showModalDialog(url+"?id="+id, window,'dialogWidth:800px; dialogHeight:800px');
} 
</script>
<script type="text/javascript" src="javascript/common_function.js"></script>
<script type="text/javascript" src="javascript/form.js"></script>
<script type="text/javascript" src="javascript/popup.js"></script>
<script>
function overlay(id) {
	el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
	
}
</script>
<script language="javascript">
function openWin (url,w,h,scroll,pos)
{
if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}
else if((pos!="center" && pos!="random") || pos==null){LeftPosition=0;TopPosition=20}
settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
	var mywin = window.open(url, "winImage", settings);
}
</script>
<?
////////////////////// PF detail //////////////
if(isset($_POST['submit_pf']))
{

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

$sql_check = "update ".$mysql_table_prefix."account_detail set	
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
				IpAddress ='$ip'
				where emp_id='$emp_id'";
																
$result_check=mysql_query($sql_check) or die ("Query Failed ".mysql_error());
}
?>
<?
////////////////////// PF detail //////////////
if(isset($_POST['submit_releaving']))
{

$emp_id=$_POST['emp_id'];
$releaving_date=$_POST['releaving_date'];
$releaving_reason=$_POST['releaving_reason'];
$ip = $_SERVER['REMOTE_ADDR'];

$sql_check = "update ".$mysql_table_prefix."account_detail set	
																date_releaving  ='$releaving_date',
																reason_realeaving ='$releaving_reason',
																InsertBy ='$releaving_reason',
																InsertDate =now(),
																IpAddress ='$ip'
																where emp_id='$emp_id'";
																
$result_check=mysql_query($sql_check) or die ("Query Failed ".mysql_error());
}
?>
<?
////////////////////// shift detail //////////////
if(isset($_POST['submit_shift']))
{

$emp_id=$_POST['emp_id'];
$rotation_type=$_POST['rotation_type'];
$shift_duration=$_POST['shift_duration'];
$off_days=$_POST['off_days'];
$ip = $_SERVER['REMOTE_ADDR'];

$sql_check = "insert into  ".$mysql_table_prefix."shift_detail set	
																emp_id  ='$emp_id',
																rotation_type ='$rotation_type',
																shift='$shift_duration',
																off_day='$off_days',
																InsertBy ='$emp_id',
																InsertDate =now(),
																IpAddress ='$ip'";
																
$result_check=mysql_query($sql_check) or die ("Query Failed ".mysql_error());
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
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0" bgcolor="#FFFFFF">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/snb.php"); ?>
        </td>
        
        <td style="padding-left:5px; padding-top:5px;" valign="top">
            <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                <tr>
                    <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Employee List</td>
                </tr>
				<tr>
                	<td valign="top">
                    	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                        	<tr>
                            	<td valign="top">
                            		<?php include("list_employee_leave_detail.php"); ?>
                                </td>
                          </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<div id="overlay">
     <div>
          <p class="form_msg">Are you sure to delete this Employee</p>
		  <form name="frm_del" action="<?=$_SERVER['PHP_SELF']?>" method="post">
		  <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
          <input type="hidden" name="emp_id" id="emp_id" value="<?=$emp_id?>" />
		  <input type="submit" class="btn_bg1" name="btn_del" id="btn_del" value="Yes" />
		  <input type="button" class="btn_bg1" onClick="overlay();" name="btn_close" value="No" />
		  </form>
     </div>
</div>
<? include ("inc/hr_footer.php"); ?>	