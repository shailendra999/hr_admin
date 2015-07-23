<?php
if(isset($_POST['submit_pf']))
{
echo"hello";
}
?>



<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
	<tr>
    	<td colspan="2" class="blackHead">Other Facilities</td>
    </tr>
	<tr>
    	<td align="left">
        	<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
            	<tr>
                	<td class="text_1">Electricity</td>
                    <td><input type="text" name="rotation_type" id="rotation_type" style="width:180px; height:20px;"/></td>
                </tr>
            </table>
        </td></tr>
        <tr>
        <td>
            <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                <tr>
                    <td class="text_1">Mess</td>
                    <td><input type="text" name="rotation_type" id="rotation_type" style="width:180px; height:20px;"/></td>
                </tr>
            </table>
        </td></tr>
        <tr>
        <td>
            <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                <tr>
                    <td class="text_1">Accomodation</td>
                    <td><select name="accomodation">
                    <option value="">-select-</option>
                    <option value="Family">Family</option>
                    <option value="Bachlor">Bachlor</option>
                    </select></td>
                </tr>
            </table>
        </td></tr>
        <tr>
        <td>
            <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                <tr>
                    <td class="text_1">Coneynce</td>
                    <td><input type="text" name="conveynce" id="conveynce" /></td>
                </tr>
            </table>
        </td>
            </tr>
    <tr>
    	<td colspan="2" align="center">
        	<input type="image" src="images/btn_submit.png" name="submit_pf" id="submit_pf" value="Submit"/>
        </td>
    </tr>
</table>