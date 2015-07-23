<?
include ("inc/hr_header.php");
$Message = "";
$dept_id = "";
?>
<script>
    function overlay(RecordId)
    {
        e1 = document.getElementById("overlay");
        document.getElementById("hidden_overlay").value = RecordId;
        e1.style.visibility = (e1.style.visibility == "visible") ? "hidden" : "visible";

    }
    $("#div input[name='ot_policy']").click(function () {
        alert('You clicked radio!');
//    if($('input:radio[name=ot_policy]:checked').val() == "1"){
        alert($('input:radio[name=ot_policy]:checked').val());
        //$('#select-table > .roomNumber').attr('enabled',false);
//    }
    });
</script>
<?
$Page = "ot_setting.php";
$PageTitle = "Over-Time Setting";
$PageFor = "OT";
$PageKey = "rec_id";
$Message = "";
if (isset($_POST["btn_submit"])) {
    $id = $_POST["ot_policy"];
    if (isset($id)) {
        $sql = "update mpc_ot_policy set status = '1' where $PageKey = '$id'";
        mysql_query($sql) or die("Error in " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
        $sql = "update mpc_ot_policy set status = '0' where $PageKey != '$id'";
        mysql_query($sql) or die("Error in " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
        $Message = "$PageFor Updated";
    }
}
$select = mysql_query("select * from mpc_ot_policy where status =1");
$fetch = mysql_fetch_array($select);
$rec_id = $fetch['rec_id'];
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
        <td align="left" valign="top" width="230px" style="padding-top:5px;">
            <? include ("inc/setting_snb.php"); ?>
        </td>

        <td style="padding-left:5px; padding-top:5px;">
            <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                <tr>
                    <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp;Over Time Policy </td>
                </tr>
                <tr>
                    <td height="400px" valign="top" style="padding-top:40px; padding-left:40px;">
                        <table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td align="center" class="border">
                                    <div align="center" style="height:470px; padding-top:30px;" id="div">
                                        <div id="div_message"><?= $Message ?></div>
                                        <form id="frm_category" name="frm_category" action="<?= $Page ?>" method="post">
                                            <table align="center" cellpadding="1" cellspacing="1" border="0" width="60%" style="border:#CCCCCC solid 1px;">
                                                <tr>
                                                    <td class="paas_text" bgcolor="#E2EBF0">
                                                        <input type="radio" name="ot_policy" id="ot_policy" value="1"
                                                        <?php
                                                        if ($rec_id == 1) {
                                                            echo "checked";
                                                        }
                                                        ?>/>
                                                    </td>
                                                    <td align="left" bgcolor="#F2F7F9" style="padding-left:10px;">
                                                        <b>Basic Salary &times; 1</b>
                                                    </td>
                                                    <td align="left" bgcolor="#F2F7F9" style="padding-left:10px;">
                                                        <?php
                                                        if ($rec_id == 1) {
                                                            ?>
                                                            <span id="first">
                                                                Active
                                                            </span>
                                                            <?
                                                        }
                                                        ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="paas_text" bgcolor="#E2EBF0">
                                                        <input type="radio" name="ot_policy" id="ot_policy" value="2" 
                                                        <?php
                                                        if ($rec_id == 2) {
                                                            echo "checked";
                                                        }
                                                        ?>/>
                                                    </td>
                                                    <td align="left" bgcolor="#F2F7F9" style="padding-left:10px;">
                                                        <b>Basic Salary &times; 2</b>
                                                    </td>
                                                    <td align="left" bgcolor="#F2F7F9" style="padding-left:10px;">
                                                        <?php if ($rec_id == 2) { ?>
                                                            <span id="first">
                                                                Active
                                                            </span>
                                                        <? }
                                                        ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="paas_text" bgcolor="#E2EBF0">
                                                        <input type="radio" name="ot_policy" id="ot_policy" value="3"
                                                        <?php
                                                        if ($rec_id == 3) {
                                                            echo "checked";
                                                        }
                                                        ?>
                                                               />
                                                    </td>
                                                    <td align="left" bgcolor="#F2F7F9" style="padding-left:10px;">
                                                        <b>GROSS Salary &times; 1</b>
                                                    </td>
                                                    <td align="left" bgcolor="#F2F7F9" style="padding-left:10px;">
                                                        <?php
                                                        if ($rec_id == 3) {
                                                            ?>
                                                            <span id="first">
                                                                Active
                                                            </span>
                                                            <?
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="paas_text" bgcolor="#E2EBF0">
                                                        <input type="radio" name="ot_policy" id="ot_policy" value="1"/>
                                                    </td>
                                                    <td align="left" bgcolor="#F2F7F9" style="padding-left:10px;" 
                                                    <?php
                                                    if ($rec_id == 4) {
                                                        echo "checked";
                                                    }
                                                    ?>>
                                                        <b>GROSS Salary &times; 2</b>
                                                    </td>
                                                    <td align="left" bgcolor="#F2F7F9" style="padding-left:10px;">
                                                        <?php
                                                        if ($rec_id == 4) {
                                                            ?>
                                                            <span id="first">
                                                                Active
                                                            </span>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="paas_text" bgcolor="#E2EBF0">

                                                    </td>
                                                    <td align="left" bgcolor="#F2F7F9" style="padding-left:10px;" colspan="2">
                                                        <input type="submit" name="btn_submit" id="btn_submit" value="Save"/>
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="padding-bottom:5px;"><img src="images/pageBtm.jpg" width="1000" height="10"/></td>
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
        <p class="form_msg">Are you sure to delete this Designation</p>
        <form name="frm_del" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
            <input type="submit" class="submit" name="btn_delete" id="btn_delete" value="Yes" />
            <input type="button" class="submit" onClick="overlay();" name="btn_close" id="btn_close" value="No" />
        </form>
    </div>
</div>
<? include ("inc/hr_footer.php"); ?>	
