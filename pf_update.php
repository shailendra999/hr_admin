<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
$date_releaving = "";
$reason_realeaving = "";
$emp_id = "";
if(isset($_POST["str1"]))
{
	$pf_no=$_POST['str1'];
	$pf_rate=$_POST['str3'];
	$pf_nominee=$_POST['str4'];
	$pf_relationship=$_POST['str5'];
	$esic_no=$_POST['str6'];
	$esic_rate=$_POST['str7'];
	$esic_nominee=$_POST['str8'];
	$esic_relationship=$_POST['str9'];
	$emp_id=$_POST['str10'];
	$ip = $_SERVER['REMOTE_ADDR'];
}

//echo $weekly_off;

 $sql_check1 = "update ".$mysql_table_prefix."account_detail set	
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
																
$result_check1=mysql_query($sql_check1) or die ("Query Failed ".mysql_error());
?>
<div id="div_hide" style="display:block;">
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
	<tr>
    	<td colspan="2" class="blackHead">PF Detail</td>
    </tr>
	<tr>
    	<td align="left">
        	<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
            	<tr>
                	<td class="text_1">PF Number</td>
                    <td><?=$pf_no?></td>
                </tr>
            	<tr>
                	<td class="text_1">PF Rate</td>
                    <td><?=$pf_rate?></td>
                </tr>
            </table>
        </td>
        <td>
            <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                <tr>
                    <td class="text_1">PF Nominee</td>
                    <td><?=$pf_nominee?></td>
                </tr>
                <tr>
                    <td class="text_1">RelationShip</td>
                    <td><?=$pf_relationship?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
    	<td colspan="2" class="blackHead">ESIC Detail (Employee State Insurance Corporation)</td>
    </tr>
    <tr>
    	<td>
        	<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
            	<tr>
                	<td class="text_1">ESIC Number</td>
                    <td><?=$esic_no?></td>
                </tr>
            	<tr>
                	<td class="text_1">ESIC Rate</td>
                    <td><?=$esic_rate?></td>
                </tr>
            </table>
        </td>
        <td>
            <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                <tr>
                    <td class="text_1">ESIC Nominee</td>
                    <td><?=$esic_nominee?></td>
                </tr>
                <tr>
                    <td class="text_1">RelationShip</td>
                    <td><?=$esic_relationship?></td>
                </tr>
             </table>
        </td>
    </tr>
    <tr>
    	<td colspan="2" align="center">
        	<input type="image"  name="submit_pf" id="submit_pf" value="Edit" onclick="show_div()"/>
            <input type="hidden" name="emp_id" id="emp_id" value="<?=$id?>"/>
        </td>
    </tr>
</table>
</div>
<div id="div_show" style="display:none;">
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
	<tr>
    	<td colspan="2" class="blackHead">PF Detail</td>
    </tr>
	<tr>
    	<td align="left">
        	<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
            	<tr>
                	<td class="text_1">PF Number</td>
                    <td><input type="text" name="pf_no" id="pf_no" style="width:180px; height:20px;" value="<?=$pf_no?>"/></td>
                </tr>
            	<tr>
                	<td class="text_1">PF Rate</td>
                    <td><input type="text" name="pf_rate" id="pf_rate" style="width:180px; height:20px;" value="<?=$pf_rate?>"/></td>
                </tr>
            </table>
        </td>
        <td>
            <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                <tr>
                    <td class="text_1">PF Nominee</td>
                    <td><input type="text" name="pf_nominee" id="pf_nominee" style="width:180px; height:20px;" value="<?=$pf_nominee?>"/></td>
                </tr>
                <tr>
                    <td class="text_1">RelationShip</td>
                    <td><input type="text" name="pf_relationship" id="pf_relationship" style="width:180px; height:20px;" value="<?=$pf_relationship?>"/></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
    	<td colspan="2" class="blackHead">ESIC Detail (Employee State Insurance Corporation)</td>
    </tr>
    <tr>
    	<td>
        	<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
            	<tr>
                	<td class="text_1">ESIC Number</td>
                    <td><input type="text" name="esic_no" id="esic_no" style="width:180px; height:20px;" value="<?=$esic_no?>"/></td>
                </tr>
            	<tr>
                	<td class="text_1">ESIC Rate</td>
                    <td><input type="text" name="esic_rate" id="esic_rate" style="width:180px; height:20px;" value="<?=$esic_rate?>"/></td>
                </tr>
            </table>
        </td>
        <td>
            <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                <tr>
                    <td class="text_1">ESIC Nominee</td>
                    <td><input type="text" name="esic_nominee" id="esic_nominee" style="width:180px; height:20px;" value="<?=$esic_nominee?>"/></td>
                </tr>
                <tr>
                    <td class="text_1">RelationShip</td>
                    <td><input type="text" name="esic_relationship" id="esic_relationship" style="width:180px; height:20px;" value="<?=$esic_relationship?>"/></td>
                </tr>
             </table>
        </td>
    </tr>
    <tr>
    	<td align="center" colspan="2">
        	<input type="image" src="images/btn_submit.png" name="submit_pf" id="submit_pf" value="Submit" onclick="post_frm_long('pf_update.php',document.getElementById('pf_no').value,'div_detail',document.getElementById('pf_rate').value,document.getElementById('pf_nominee').value,document.getElementById('pf_relationship').value,document.getElementById('esic_no').value,document.getElementById('esic_rate').value,document.getElementById('esic_nominee').value,document.getElementById('esic_relationship').value,'<?=$emp_id?>','','')"/>
            <input type="hidden" name="emp_id" id="emp_id" value="<?=$emp_id?>"/>
            <input type="hidden" name="update" id="update" value="<?=$emp_id?>"/>
        </td>
    </tr>
</table>
</div>
