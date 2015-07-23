<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
$url = "list_advance.php";
$advance = "";
$ad_date = "";
$adv_id = "";
if(isset($_GET["id"]))
{
	$adv_id = $_GET["id"];
	
	$sql = "select * from mpc_advance_employee where rec_id = '$adv_id'";
	$result = mysql_query($sql) or die("Error in sql : ".mysql_errno()." : ".mysql_error()." : ".$sql);	
	$row = mysql_fetch_array($result);
	
	$advance = $row["advance"];
	$ad_date = getDatetime($row["ad_date"]);	
}
?>
<form name="frm" action="<?=$url?>" method="post">
<table width="60%" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
		<td align="center" valign="middle">
			<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td align="left" class="text_1" style="padding-left:15px;"><b>Advance</b></td>
                    <td align="left"><input type="text" name="txt_advance" id="txt_advance" value="<?=$advance?>" style="width:150px; height:20px;"/></td>
                    <td align="left" class="text_1"><b>Advance Date</b></td>
                    <td align="left"><input type="text" name="txt_date" id="txt_date" value="<?=$ad_date?>" style="width:150px; height:20px;"/><a href="javascript:void(0)" onclick="gfPop.fPopCalendar(document.frm.txt_date);"><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="27" height="22" border="0" alt=""/></a>
            		</td>
                    <td align="center" style="padding-top:5px;">
                                                                        
                            <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                            <input type="hidden" name="adv_id" id="adv_id" value="<?=$adv_id?>" />
                            <span style="padding-top:0px;">
                                <input type="image" src="images/Modify.png" name="image_edit" id="image_edit" alt="Edit Advance" title="Edit Advance">&nbsp;
                                <img src="images/Exit.png" alt="Cancel" title="Cancel" onClick="document.getElementById('div_edit').innerHTML='';">
                            </span>
						</td>
	            	</tr>
            	</table>
    	</td>
	</tr>
</table>
</form>