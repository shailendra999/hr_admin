<?php
include("inc/hr_header.php");
?>
<form name="creat-leave-type" id="creat-leave-type" method="post" action="">
    <table width="98%" cellpadding="0" cellspacing="0" align="center" border="0" bgcolor="#FFFFFF">
        <tr>
            <td align="left" valign="top" width="230px" style="padding-top:5px;">
                <? include ("inc/snb.php"); ?>
            </td>

            <td style="padding-left:5px; padding-top:5px;" valign="top">
               <table width="100%" height="707px" cellspacing="2" cellpadding="2" border="0" class="border">
                    <tr>
                        <td align="center" class="gray_bg">&nbsp; <a href="#" style="text-decoration:none;color:gray;">Employee master -> </a>employee List</td>
                    </tr>
                    <tr>
                        <td class="red" align="center"><?= $msg ?></td>
                    </tr>
                    <tr>
                        <td valign="top">
                            <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                                <tr>
                                    <td>
                                        <label for="leave_name">Leave Name</label>
                                    </td>
                                    <td>
                                        <input type="text" name="leave_name" id="leave_name" placeholder="Name Of Leave"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Total Leaves</label>
                                    </td>
                                    <td>
                                        <input type="text" name="numberOf_leaves" id="numberOf_leaves"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Allow Half Day</label>
                                    </td>
                                    <td>
                                        <input type="radio" id="half_day" name="half_day" value="1" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Carry Forward</label>
                                    </td>
                                    <td>
                                        <input type="text" name="carry_value" id="carry_value" value=""/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="submit" name="save_leave_type" id="save_leave_type" value="Save" class="btn btn-lg btn-success pull-right" formaction="save_emp_leaves.php"/>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>    
