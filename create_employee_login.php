<?php
//include("inc/common_db_connection.php");
include("inc/dbconnection.php");
$select_code = mysql_query("select * from mpc_employee_master ORDER BY ticket_no DESC LIMIT 1");

if (mysql_num_rows($select_code) == 0) {
    $new_ticket = '000001';
    $emp = '1';
    $rest = substr($new_ticket, 4);
   
} else {
    $fetch_code = mysql_fetch_array($select_code);
    $new_ticket = $fetch_code['ticket_no'] + 1;
    $emp = $fetch_code['emp_id'] + 1;
    $rest = substr($new_ticket, 4);
}
if (isset($_REQUEST['save_user'])) {
    $user = $_REQUEST['user_name'];
    $pass = mysql_real_escape_string(md5($_REQUEST['password']));
    $emp_type = $_REQUEST['emp_type'];
    $UserType = 'User';
    $fullname = $_REQUEST['first_name'] . " " . $_REQUEST['last_name'];
    $period = $_REQUEST['period'];
//    $insert_user = mysql_query("INSERT INTO `mpc_login_master`(`UserName`, `Password`, `Name`,`UserType`, `IsActive`, `InsertDate`) VALUES ('$user','$pass','$fullname','$UserType','1','now()')");
//    if (!$insert_user) {
//        $msg = "Error in query" . mysql_errno();
//    } else {
    $insert = mysql_query("INSERT INTO mpc_employee_master (emp_id,ticket_no,empType,username,password,first_name,last_name,emp_period)VALUES('$emp','$new_ticket','$emp_type','$user','$pass','$_REQUEST[first_name]','$_REQUEST[last_name]','$period')");
    $msg = "Insert Successfully";
//    }
}
mysql_close();
include("inc/hr_header.php");
if (isset($_REQUEST['save_user'])) {
    $insert_user = mysql_query("INSERT INTO `mpc_login_master`(`UserName`, `Password`, `Name`,`UserType`, `IsActive`, `InsertDate`) VALUES ('$user','$pass','$fullname','$UserType','1','now()')");
    if (!$insert_user) {
        $msg = "Error in query" . mysql_errno();
    }
}
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0" bgcolor="#FFFFFF">
    <tr>
        <td align="left" valign="top" width="230px" style="padding-top:5px;">
            <? include ("inc/snb.php"); ?>
        </td>

        <td style="padding-left:5px; padding-top:5px;" valign="top">
            <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                <tr>
                    <td align="center" class="gray_bg" >&nbsp; <a href="#" style="text-decoration:none;color:gray;">Employee master -> </a>Employee Login</td>
                </tr>
                <tr>
                    <td class="red" align="center"><?= $msg ?></td>
                </tr>
                <tr>
                    <td valign="top">
                        <form action="" method="post" name ="oForm" onsubmit="return valid_input(this);">
                            <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                                <tr>
                                    <td width="100%" colspan="2" align="center">
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" class="loginbg">
                                            <tbody>
                                                <tr>
                                                    <td width="4%"></td>
                                                    <td width="33%">
                                                        Select Employee Type
                                                        <span class="red">*</span>
                                                    </td>
                                                    <td>
                                                        <select id="emp_type" name="emp_type" required>
                                                            <?php
                                                            $selectTyp = mysql_query("Select * from mpc_employee_type_master");
                                                            while ($fetchTyp = mysql_fetch_array($selectTyp)) {
                                                                ?>
                                                                <option value="<?php echo $fetchTyp['type_name'] ?>">
                                                                    <?php
                                                                    echo $fetchTyp['type_name'];
                                                                    ?>
                                                                </option>
                                                            <?php }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td width="4%"></td>
                                                    <td>
                                                        <input type="radio" name="period" id="01" value="0" required>
                                                    </td>
                                                    <td width="20%">Probational Period</td>
                                                    <td>
                                                        <input type="radio" name="period" id="period" value="1" required>
                                                    </td>
                                                    <td>Conform</td>
                                                    <td width="23%" style="padding-left:15px;">
                                                        Employee Code
                                                        <span class="red">*</span><?php echo $new_ticket; ?>
                                                    </td>
                                                    <td width="">
                                                        <!--<input type="text" name="emp_login" id="emp_login" style="width:150px; height:20px;" value="" readonly="readonly" onblur="check_login_id(this.value);" data-cip-id="emp_login" value="<?php echo $new_ticket; ?>" ></td>-->
                                                    <td width="30%"><div style="font-size:14px;" id="check_login"></div></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table width="100%" cellpadding="2" cellspacing="2" class="border" border="0" height="0px"> 

                                            <tr>
                                                <td class="text_1">First Name<span class="red">*</span></td>
                                                <td align="left" style="padding-top:5px;"><input type="text"  required name="first_name" id="first_name" style="width:150px; height:20px;" /></td>
                                            </tr>
                                            <tr>
                                                <td class="text_1">Last Name<span class="red">*</span></td>
                                                <td align="left" style="padding-top:5px;"><input type="text" required name="last_name" id="last_name" style="width:150px; height:20px;" onkeyup="createUsername(this.value, first_name.value, '<?php echo $rest; ?>')"/></td>
                                            </tr>
                                            <tr>
                                                <td class="text_1">User Name<span class="red">*</span></td>
                                                <td align="left" style="padding-top:5px;">
                                                    <input type="text" name="user_name" id="user_name"  style="width:150px; height:20px;" />
                                                </td>   
                                            </tr>
                                            <tr>
                                                <td class="text_1">Password<span class="red">*</span></td>
                                                <td align="left" style="padding-top:5px;">
                                                    <input type="password" name="password" id="password"  required style="width:150px; height:20px;" />
                                                </td>   
                                            </tr>
                                            <tr>
                                                <td class="text_1"></td>
                                                <td align="left" style="padding-top:5px;">
                                                    <input type="submit" name="save_user" id="save_user" value="Submit" style="width:150px; height:20px;" />
                                                </td>   
                                            </tr>

                                        </table>

                                    </td>

                                    </td>
                                </tr>

                            </table>
                        </form>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<script>
    function createUsername(lastName, firstName, rest) {
        var username = lastName + "." + firstName + rest;
        document.getElementById('user_name').value = username;
    }
    function valid_input()
    {
        var emp_type    =   document.forms['oForm']['emp_type'].value;
        var period      =   document.forms['oForm']['period'].value;
        var first_name  =   document.forms['oForm']['first_name'].value;
        var last_name   =   document.forms['oForm']['last_name'].value;
        var user_name   =   document.forms['oForm']['user_name'].value;
        var password    =   document.forms['oForm']['password'].value;
        var ck_username =   /^[A-Za-z0-9_]{1,20}$/;
        var ck_password =   /^[A-Za-z0-9!@#$%^&*()_]{6,20}$/; 
        var errors      =   [];
        if(!emp_type || !first_name ||  !last_name  ||  !user_name || !password || !period)
        {
            alert("please fill all the fields");
            return false;
        }
        else
        {
            return true;
        }
    }
</script>
