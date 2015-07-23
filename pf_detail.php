<?
include('inc/dbconnection.php');
$id="";
$id = $_GET["id"];
$sql = "SELECT * FROM  mpc_account_detail where emp_id  = '$id'";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result)>0)
{
    $row = mysql_fetch_array($result);
	//while($row = mysql_fetch_array($result))
	//{
		$pf_number    =   $row['pf_number'];
		$pf_nominee   =   $row['pf_nominee'];
		$pf_rate  =   $row['pf_rate'];
		$pf_relationship  =    $row['pf_relationship'];
		$esic_rate    =   $row['esic_rate'];
		$esic_number  =   $row['esic_number'];
		$esic_nominee =    $row['esic_nominee'];
		$esic_relationship    =   $row['esic_relationship'];
	//}
?>
<div id="div_hide" style="display:block;" >
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
	<tr>
    	<td colspan="2" class="blackHead">PF Detail</td>
    </tr>
	<tr>
    	<td align="left">
        	<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
            	<tr>
                	<td class="text_1">PF Number</td>
                    <td><?=$pf_number?></td>
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
                    <td><?=$esic_number?></td>
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
                    <td><input type="text" name="pf_no" id="pf_no" style="width:180px; height:20px;" value="<?=$pf_number?>"/></td>
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
                    <td><input type="text" name="esic_no" id="esic_no" style="width:180px; height:20px;" value="<?=$esic_number?>"/></td>
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
        	<input type="image" src="images/btn_submit.png" name="submit_pf" id="submit_pf" value="Submit" onclick="post_frm_long('pf_update.php',document.getElementById('pf_no').value,'div_detail',document.getElementById('pf_rate').value,document.getElementById('pf_nominee').value,document.getElementById('pf_relationship').value,document.getElementById('esic_no').value,document.getElementById('esic_rate').value,document.getElementById('esic_nominee').value,document.getElementById('esic_relationship').value,'<?=$id?>','','')"/>
            <input type="hidden" name="emp_id" id="emp_id" value="<?=$id?>"/>
            <input type="hidden" name="update" id="update" value="<?=$id?>"/>
        </td>
    </tr>
</table>
</div>
<?
}
else
{
?>
<div id="hide_div">
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
	<tr>
    	<td colspan="2" class="blackHead">PF Detail</td>
    </tr>
	<tr>
    	<td align="left">
        	<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
            	<tr>
                	<td class="text_1">PF Number</td>
                    <td><input type="text" name="pf_no" id="pf_no" style="width:180px; height:20px;" value=""/></td>
                </tr>
            	<tr>
                	<td class="text_1">PF Rate</td>
                    <td><input type="text" name="pf_rate" id="pf_rate" style="width:180px; height:20px;" value=""/></td>
                </tr>
            </table>
        </td>
        <td>
            <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                <tr>
                    <td class="text_1">PF Nominee</td>
                    <td><input type="text" name="pf_nominee" id="pf_nominee" style="width:180px; height:20px;" value=""/></td>
                </tr>
                <tr>
                    <td class="text_1">RelationShip</td>
                    <td><input type="text" name="pf_relationship" id="pf_relationship" style="width:180px; height:20px;" value=""/></td>
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
                    <td><input type="text" name="esic_no" id="esic_no" style="width:180px; height:20px;" value=""/></td>
                </tr>
            	<tr>
                	<td class="text_1">ESIC Rate</td>
                    <td><input type="text" name="esic_rate" id="esic_rate" style="width:180px; height:20px;" value=""/></td>
                </tr>
            </table>
        </td>
        <td>
            <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                <tr>
                    <td class="text_1">ESIC Nominee</td>
                    <td><input type="text" name="esic_nominee" id="esic_nominee" style="width:180px; height:20px;" value=""/></td>
                </tr>
                <tr>
                    <td class="text_1">RelationShip</td>
                    <td><input type="text" name="esic_relationship" id="esic_relationship" style="width:180px; height:20px;" value=""/></td>
                </tr>
             </table>
        </td>
    </tr>
    <tr>
    	<td colspan="2" align="center">
        	<input type="image" src="images/btn_submit.png" name="submit_pf" id="submit_pf" value="Submit" onclick="post_frm_long('pf_update.php',document.getElementById('pf_no').value,'div_detail',document.getElementById('pf_rate').value,document.getElementById('pf_nominee').value,document.getElementById('pf_relationship').value,document.getElementById('esic_no').value,document.getElementById('esic_rate').value,document.getElementById('esic_nominee').value,document.getElementById('esic_relationship').value,'<?=$id?>','','')"/>
            <input type="hidden" name="emp_id" id="emp_id" value="<?=$id?>"/>
        </td>
    </tr>
</table>
</div>
<?
}
?>
