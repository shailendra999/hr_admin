<!--My code start from here-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">

<script>
  $(function() {
    //$( "#dob" ).datepicker();
	$('.footer').hide();
  });
</script>

<!--And End here-->
<?php include('inc/dbconnection.php');
include('inc/function.php');
$id="";
$id = $_GET["id"];
$date_releaving="";
$reason_realeaving="";
$sql = "SELECT * FROM  mpc_account_detail where emp_id  = '$id'";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result)>0)
{
	while($row = mysql_fetch_array($result))
	{
		$date_releaving=$row['date_releaving'];
		$reason_realeaving=$row['reason_realeaving'];
		$reason_realeaving = $reason_realeaving;
		
	} 	
}
if($date_releaving!="0000-00-00 00:00:00")
{
	if($date_releaving!="")
	{
	$date_releaving=getDatetime($date_releaving);
	}
//$reason_realeaving = nl2br($reason_realeaving);
?>
<div id="div_update_releave">
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
	<tr>
    	<td colspan="2" class="blackHead">Releaving Detail</td>
    </tr>
	<tr>
    	<td align="left" valign="top">
        	<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
            	<tr>
                	<td class="text_1">Date of Leaving</td>
                    <td><?=$date_releaving?></td>
                </tr>
            </table>
        </td>
        <td>
            <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                <tr>
                    <td class="text_1" valign="top">Reason</td>
                    <td><?=nl2br($reason_realeaving)?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
    	<td colspan="2" align="center">

        	<a onclick="post_frm('releaving_update.php','0','div_update_releave','','<?=$date_releaving?>','<?=str_replace(array("\r\n", "\r", "\n", "\t"),"<br>", $reason_realeaving);?>','<?=$id?>')">Edit</a>
        </td>
    </tr>
</table>
</div>
	<?
}
else
{
?>

<div id="div_insert_releave" style="display:block;">
<form action="" method="post" name="frm_releaving" id="frm_releaving">
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
	<tr>
    	<td colspan="2" class="blackHead">Releaving Detail</td>
    </tr>
	<tr>
    	<td align="left" valign="top">
        	<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
            	<tr>
                	<td class="text_1">Date of Leaving</td>
                    <td>
                    <!-- my code -->
                    <h1>asdf;lkjh</h1>
                      <input type="text" name="dob" id="dob" style="width:150px; height:20px;" value="<?=getDatetime($dob)?>" data-beatpicker="true" data-beatpicker-position="['right','*']" data-beatpicker-format="['DD','MM','YYYY']" />
                    <!--My code End Here -->
                   <!-- <input type="text" name="releaving_date" id="releaving_date" style="width:180px; height:20px;" readonly="readonly"/>
                    <a href="javascript:void(0)" onclick="gfPop.fPopCalendar(document.frm_releaving.releaving_date);"><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="27" height="22" border="0" alt=""/></a> -->
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                <tr>
                    <td class="text_1" valign="top">Reason</td>
                    <td><textarea name="releaving_reason" id="releaving_reason" rows="4" cols="35"></textarea></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
    	<td colspan="2" align="center">
        	<a onclick="post_frm('releaving_update.php','1','div_insert_releave','',document.getElementById('releaving_date').value,document.getElementById('releaving_reason').value,'<?=$id?>')"><img src="images/btn_submit.png" border="0"/></a>
            <input type="hidden" name="emp_id" id="emp_id" value="<?=$id?>"/>
        </td>
    </tr>
</table>
</form>
</div>
<?
}
?>