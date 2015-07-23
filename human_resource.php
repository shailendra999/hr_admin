<?php
session_start();
$plant = $_REQUEST['plant_id'];
if ($plant == 'demolss') {
    $url = "http://solutionsofts.com/demolss/login_check.php";
    $ul = "http://solutionsofts.com/demolss/";
    $UserName = "hr";
    $pass = "12345";
    $LoginMasterId = "hr";
    $UserType = "hr";
    $lower_user_type = strtolower($UserType);
    $_SESSION[$lower_user_type . '_mahima_session_user_name'] = "hr";
    $_SESSION[$lower_user_type . '_mahima_session_user_type'] = "HR";
    $_SESSION["mahima_session_user_type"] = $lower_user_type;
    $_SESSION["admin"] = "admin";
    echo "location.href = '" . $ul . $lower_user_type . "_homepage.php'";
    echo "<script>";
    echo "location.href = '" . $ul . $lower_user_type . "_homepage.php'";
    echo "</script>";
}
include("inc/dbconnection.php");
?>
<? include ("inc/administrator_header.php"); ?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
        <td align="left" valign="top" width="230px" style="padding-top:5px;"><? include ("inc/administrator_snb.php"); ?></td>
        <td style="padding-left:5px; padding-top:5px;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                <tr>
                    <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Welcome to Laxyo Solution Soft Pvt. Ltd.</td>
                </tr>
                <tr>
                    <td valign="top" style="padding-top:40px; padding-left:40px;">
                        <form action="" method="post">
                            <table class="border">
                                <tr>
                                    <td>
                                        Plant
                                    </td>
                                    <td>
                                        <select name="plant_id" id="plant_id">
                                            <option value="-1" >
                                                Select Plant 
                                            </option>
                                            <?php
                                            $select_plant = mysql_query("Select * from mpc_plant_master");
                                            while ($fetch_plant = mysql_fetch_array($select_plant)) {
                                                ?>
                                                <option value="<?= $fetch_plant['rec_id'] ?>" ><?= $fetch_plant['plant_name'] ?></option>
                                                <?php
                                            }
                                            ?>
                                            <option value="demolss">
                                                Demolss                                                    
                                            </option>
                                        </select>
                                    </td>
                                    <td><input type="submit" name="loginas" id="loginas" value="Login"></td>
                                </tr>
                            </table>
                        </form>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<? include ("inc/hr_footer.php"); ?>
