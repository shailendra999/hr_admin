<?
include('inc/check_session.php');
include('inc/dbconnection.php');
?>
<script language="javascript">
function calculate(ramt,qty,flag)
{
	var RightFlag = document.getElementById(flag).value
	var Quantity = (qty*5)/100;
	var Plus = parseInt(Quantity)+parseInt(qty);
	//alert(Plus);
	var minus = parseInt(qty)-parseInt(Quantity);
	//alert(minus);
	if(RightFlag='1')
	{
		if(ramt > Plus)
		{
			alert("Please Insert Right Quantity");
			document.getElementById(ramt).focus();
		}
	}
	else if(RightFlag='0')
	{
		if(ramt > minus)
		{
			alert("Please Insert Right Quantity");
			document.getElementById(ramt).focus();
		}
	}	
}
</script>
<SCRIPT language=JavaScript>
<!-- 
function win(){
window.opener.location.href="rightof.php?id=<?=$_GET['id']?>&start=<?=$_GET['start']?>";
self.close();
//-->
}
</SCRIPT>
<?
/*if(!session_is_registered("no_refresh"))
{
	$_SESSION['no_refresh'] = "";
}
if(isset($_POST['btn_submit']))
{
	if($_POST['no_refresh'] == $_SESSION['no_refresh'])
	{	
		//echo "WARNING: Do not try to refresh the page.";
	}
	else
	{
		$edit_id = $_POST['edit_id'];
		$right_flag = $_POST['txt_rightflag'];
		$right_amount = $_POST['txt_amount'];
		
		$sql_up = "update ".$mysql_adm_table_prefix."dispatch_master set
																			RightOfFlag = '$right_flag',
																			RightOfAmount  = '$right_amount' where rec_id = '$edit_id'";
	    $result_up = mysql_query($sql_up) or die("Error in query: ".$sql_up."<br/>".mysql_error()."<br/>".mysql_errno());
		$_SESSION['no_refresh'] = $_POST['no_refresh'];	
		 echo "<script language='javascript'>";
		 echo "win()";
		 echo "</script>";
	}
}*/
?>
<link href="style/adm0_style.css" rel="stylesheet" type="text/css" />
<form action="" method="post" name="frm_rightof" id="frm_rightof">
<table align="center" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #C6B4AE;" bgcolor="#EAE3E1">
	<tr>
        <td align="center"><span class="text_1"><b>Right Of Amount</b></span></td>
    </tr>    
    <tr>
        <td align="center">
        	<input type="text" name="txt_amount" id="txt_amount" value="<?=$_GET['id']?>" readonly="readonly">
        </td>
    </tr>
   <!-- <tr>
    	<td colspan="2" align="center" height="50">
    		<input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
            <input type="hidden" name="edit_id" id="edit_id" value="" />
            <input type="submit" name="btn_submit" id="btn_submit" value="Submit"/>
        </td>
    </tr> -->      
</table>       
</form>