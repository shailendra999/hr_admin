<? include ("inc/dbconnection.php"); ?>
<? include ("inc/function.php"); ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">

<script>
    $(function () {
        $('.footer').hide();
    });
</script>
<?
$id = "";
$start = 0;
$id = $_GET["id"];
$check = $_GET["str"];
$deduction_date = "";
if ($check == "name") {
    $sql = "SELECT mpc_employee_master.*,mpc_account_detail.emp_id,mpc_account_detail.date_releaving FROM mpc_employee_master,mpc_account_detail where mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' and first_name!='' and  first_name like '$id%' order by first_name";
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
}
if ($check == "id") {
    $sql = "SELECT mpc_employee_master.*,mpc_account_detail.emp_id,mpc_account_detail.date_releaving FROM mpc_employee_master,mpc_account_detail where mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' and first_name!='' and ticket_no like '$id' order by first_name ";
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
}
if ($check == "employee") {
    $sql = "SELECT mpc_employee_master.*,mpc_account_detail.emp_id,mpc_account_detail.date_releaving FROM mpc_employee_master,mpc_account_detail where mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' and ticket_no like '$id' order by first_name ";
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
}
if (mysql_num_rows($result) > 0) {
    ?>
    <form id="frm_emp_list" name="frm_emp_list" method="post" action="">
        <table width="100%" align="center" cellpadding="2" cellspacing="2" border="0" class="border">
            <tr class="blackHead">
                <td align="center">Employee Id</td>
                <td align="center">Employee Name</td>
                <td align="center">Fine</td
                ><td align="center">Dam Loss</td>
                <td align="center">Canteen/Mess</td>
                <td align="center">Society Welfare</td>
                <td align="center">Electrical</td>
                <td align="center">Security</td>
                <td align="center">H/Rent</td>
                <td align="center">Date</td>
            </tr>
            <?
            $sno = 1;
            $j = 0;
            while ($row = mysql_fetch_array($result)) {
                ?>
                <tr <? if ($sno % 2 == 1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
                    <td align="center">
                        <?= $row["ticket_no"] ?>
                    </td>
                    <td align="center">
                        <?= $row["first_name"] ?> <?= $row["last_name"] ?> 
                    </td>
                    <td align="center">
                        <input type="text" name="salary_fine[]"  id="salary_fine[]" value="" size="6"/>
                    </td>
                    <td align="center">
                        <input type="text" name="salary_damage[]"  id="salary_damage[]" value="" size="6"/>
                    </td>
                    <td align="center">
                        <input type="text" name="salary_canteen[]"  id="salary_canteen[]" value="" size="6"/>
                    </td>
                    <td align="center">
                        <input type="text" name="salary_society_welfare[]"  id="salary_society_welfare[]" value="" size="6"/>
                    </td>
                    <td align="center">
                        <input type="text" name="salary_electrical[]"  id="salary_electrical[]" value="" size="6"/>
                    </td>
                    <td align="center">
                        <input type="text" name="salarly_security[]"  id="salarly_security[]" value="" size="6"/>
                    </td>
                    <td align="center">
                        <input type="text" name="salary_house_rent[]"  id="salary_house_rent[]" value="" size="6"/>
                    </td>
                    <td align="center">
                        <input type="text" name="salary_deduction_date<?= $j ?>" id="salary_deduction_date<?= $j ?>" value="" style="width:100px; height:20px;" readonly="readonly" data-beatpicker="true"/>
                        <input type="hidden" name="emp_id[]"  id="emp_id[]" value="<?= $row["rec_id"] ?>"/>   
                    </td>
                </tr>
                <?
                $sno++;
                $j++;
            }
            ?>
            <tr bgcolor="#F8F8F8">
                <td colspan="9" align="center">				
                    <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                    <input type="submit" src="images/btn_submit.png" name="btn_submit" id="btn_submit" value="Submit"/>
                </td>
            </tr>    
        </table>
    </form>
    <?
}
?>