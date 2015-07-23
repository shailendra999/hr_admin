<?php
include("inc/hr_header.php");
include("inc/dbconnection.php");
?>
<link rel="stylesheet" type="text/css" href="inc/popup.css">
<script>
    $(function () {
        //$( "#dob" ).datepicker();
        $('.footer').hide();
    });</script>
<style type="text/css" media="screen">
    @import "tab/css/style.css";
    @import "tab/css/simpletabs.css";
</style>
<body>
    <script type="text/javascript" src="javascript/form.js"></script>
    <script type="text/javascript" src="javascript/popup.js"></script>
    <style>
        #vpb_pop_up_background {
            background: none repeat scroll 0 0 #000000;
            border: 1px solid #cecece;
            display: none;
            height: 100%;
            left: 0;
            opacity: 0.4;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 99999999;
        }
        #vpb_signup_pop_up_box {
            background-color: #ffffff;
            border: 1px solid #000000;
            border-radius: 15px;
            box-shadow: 0 0 20px #000000;
            display: none;
            font-family: Verdana, Geneva, sans-serif;
            font-size: 11px;
            padding: 10px 20px;
            position: absolute;
            right: 30%;
            top: 0;
            width: 500px;
            z-index: 2147483647;
            margin-top:250px;
        }
        .editBox {
            background-color: #ffffff;
            border: 1px solid #000000;
            border-radius: 15px;
            box-shadow: 0 0 20px #000000;
            display: none;
            font-family: Verdana, Geneva, sans-serif;
            font-size: 11px;
            padding: 10px 20px;
            position: absolute;
            right: 30%;
            top: 0;
            width: 500px;
            z-index: 2147483647;
            margin-top:250px;

        }
        #vpb_signup_pop_up_box {
            display:none;
        }
        #my_div{
            display:none;
        }
    </style>
    <script>
    function show_popup()
    {
        document.getElementById('vpb_pop_up_background').style.display = "block";
        document.getElementById('vpb_signup_pop_up_box').style.display = "block";
    }
    function edit_show_popupp(n) {
        var dep = document.getElementById('dep_ids' + n).value;
        document.getElementById('select' + n).innerHTML = "<select id='edit_dep'" + "name='edit_dep'><option>Select Department</option>" + "<?php
$data = array();
$index = array();
$query = mysql_query('SELECT mpc_department_master.rec_id, mpc_department_master.reference_id, mpc_department_master.department_name FROM mpc_department_master ORDER BY department_name');
while ($row = mysql_fetch_assoc($query)) {
    $id = $row['rec_id'];
    $parent_id = $row['reference_id'] === 0 ? '0' : $row['reference_id'];
    $data[$id] = $row;
    $index[$parent_id][] = $id;
}

function dis($parent_id, $level, $index1, $data1) {
    $parent_id = $parent_id === 0 ? '0' : $parent_id;
    if (isset($index1[$parent_id])) {
        foreach ($index1[$parent_id] as $id) {
            echo '<option value=' . $data1[$id]['rec_id'] . '>' . str_repeat('_', $level) . $data1[$id]['department_name'] . '</option>';
            dis($id, $level + 1, $index1, $data1);
        }
    }
}

dis(0, 0, $index, $data);
?>" + "</select>";
        document.getElementById('vpb_pop_up_background').style.display = "block";
        document.getElementById('edit_popup_box' + n).style.display = "block";
    }
    function edit_hide_popup(n) {
        document.getElementById('vpb_pop_up_background').style.display = "none";
        document.getElementById('edit_popup_box' + n).style.display = "none";
    }
    function hide_popup()
    {
        document.getElementById('vpb_pop_up_background').style.display = "none";
        document.getElementById('vpb_signup_pop_up_box').style.display = "none";
    }

    </script>
    <table width="98%" cellpadding="0" cellspacing="0" border="0" align="center">
        <tr>
            <td align="left" valign="top" width="230px" style="padding-top:5px;">
                <?php
                include ("inc/snb.php");
                ?>
            </td>
            <td style="padding-left:5px; padding-top:5px; float:left;">
                <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                    <tr>
                        <td align="center" class="gray_bg">
                            <img src="images/bullet.gif" width="15" height="22"/>
                            &nbsp; Designation
                            <label style="float: right">
                                <div>
                                    <p>
                                        <a href="javascript:show_popup()" class="eventDetail impAtt" >
                                            Add New
                                        </a>&nbsp;
                                    </p>
                                </div>
                            </label>
                        </td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                        <td class="red">
                            <?= $msg ?>
                        </td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                        <td style="vertical-align:top; padding-top:5px;">
                            <table width="100%" cellspacing="2" cellpadding="2" border="0" align="center" class="border">
                                <thead class="blackHead" style="text-align: center">
                                    <tr>
                                        <th>S.No</th>
                                        <th>Designation Name</th>
                                        <th>Department Name</th>
                                        <th>Employee Category</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <?php
                                $n = 1;
                                $select = mysql_query("SELECT * FROM mpc_designation_master ORDER BY designation_name");
                                while ($row = mysql_fetch_array($select)) {
                                    $designation = $row['designation_name'];
                                    $reference_id = $row['department_id'];
                                    $rec_id = $row['rec_id'];
                                    $select1 = mysql_query("SELECT department_name FROM mpc_department_master where rec_id='$reference_id'");
                                    $row1 = mysql_fetch_array($select1);
                                    ?>
                                    <tbody class="tableTxt" bgcolor="#F8F8F8" style="text-align: center">
                                        <tr>
                                            <td><?php echo $n; ?></td>
                                            <td><?php echo $designation; ?></td>
                                            <td><?php
                                                echo $row1['department_name'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo $row['emp_category'];
                                                ?>
                                            </td>
                                            <td align="center">
                                                <a href="javascript:edit_show_popupp('<?php echo $n; ?>')">
                                                    <img src="images/Modify.png" alt="Edit" title="Edit" border="0">
                                                </a>

                                            </td>
                                            <td align="center"><a href="" onClick="">
                                                    <img src="images/Delete.png" alt="Delete" title="Delete" border="0">
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                        $n++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </td>
                    </tr>
                </table>
                <?php
                $n = 1;
                $select = mysql_query("SELECT * FROM mpc_designation_master ORDER BY designation_name");
                $num = mysql_num_rows($select);
                while ($row = mysql_fetch_array($select)) {
                    $designation = $row['designation_name'];
                    $reference_id = $row['department_id'];
                    $rec_id = $row['rec_id'];
                    $select1 = mysql_query("SELECT department_name FROM mpc_department_master where rec_id='$reference_id'");
                    $row1 = mysql_fetch_array($select1);
                    ?>
                    <div id="edit_popup_box<?php echo $n; ?>" style="display: none" class="editBox">
                        <p>
                            <a href="javascript:edit_hide_popup('<?php echo $n; ?>')" style="float:right;">
                                close
                            </a>
                        </p>
                        <?php
                        for ($i = 1; $i <= $num; $i++) {
                            if (isset($_POST['update' . $i])) {
                                $dep_name = $_REQUEST['edit_des_name' . $i];
                                $ref = $_REQUEST['edit_dep' . $i];
                                $emp_category = $_REQUEST['emp_category' . $i];
                                $insert = "update mpc_designation_master (designation_name,department_id,emp_category)values('$dep_name','$ref','$emp_category')";
                                mysql_query($insert) or die(mysql_error());
                                print "Save Succefully!!";
                            }
                        }
                        ?>
                        <form id="edit_department" name="edit_department" method="post" action="">
                            <table>
                                <tr>
                                    <td>Designation Name</td>
                                    <td>
                                        <input type="text" name="edit_des_name<?php echo $n; ?>" id="edit_des_name<?php echo $n; ?>" value="<?php echo $designation; ?>"/>
                                    </td>
                                <input type="hidden" name="dep_ids<?php echo $n; ?>" id="dep_ids<?php echo $n; ?>" value="<?php echo $reference_id; ?>"/>
                                </tr>
                                <tr>
                                    <td>
                                        Department
                                    </td>
                                    <td id="select<?php echo $n; ?>">
                                        <select id="edit_dep" name="edit_dep">
                                            <option>
                                                Select Department
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Employee Category</td>
                                    <td>
                                        <select id="emp_category<?php echo $n; ?>" name="emp_category<?php echo $n; ?>" >
                                            <option value="Staff">Staff</option>
                                            <option value="Worker">Worker</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>

                                    </td>
                                    <td>
                                        <input type="submit" name="update<?php echo $n; ?>" id="update<?php echo $n; ?>" value="Update"/>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <?php
                    $n++;
                }
                ?>
                <div id="vpb_pop_up_background">

                </div>
                <div id="vpb_signup_pop_up_box">
                    <p>
                        <a href="javascript:hide_popup()" style="float:right;">
                            close
                        </a>
                    </p>
                    <div id="form">
                        <?php
                        if (isset($_POST['save'])) {
                            $dep_name = $_REQUEST['des_name'];
                            $ref = $_REQUEST['dep_ref'];
                            $emp_category = $_REQUEST['emp_category'];
                            $insert = "Insert into mpc_designation_master (designation_name,department_id,emp_category)values('$dep_name','$ref','$emp_category')";
                            mysql_query($insert) or die(mysql_error());
                            print "Save Succefully!!";
                        }
                        ?>
                        <form id="add_department" name="add_department" method="post" action="">
                            <table>
                                <tr>
                                    <td>Designation Name</td>
                                    <td>
                                        <input type="text" name="des_name" id="des_name"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Department
                                    </td>
                                    <td>
                                        <select id="dep_ref" name="dep_ref">
                                            <option value="0">
                                                Select Parent
                                            </option>
                                            <?php
                                            $data = array();
                                            $index = array();
                                            $query = mysql_query("SELECT mpc_department_master.rec_id, mpc_department_master.reference_id, mpc_department_master.department_name FROM mpc_department_master ORDER BY department_name");

                                            while ($row = mysql_fetch_assoc($query)) {
                                                $id = $row["rec_id"];
                                                $parent_id = $row["reference_id"] === 0 ? "0" : $row["reference_id"];
                                                $data[$id] = $row;
                                                $index[$parent_id][] = $id;
                                            }

                                            function display($parent_id, $level, $index1, $data1) {
                                                $parent_id = $parent_id === 0 ? "0" : $parent_id;
                                                if (isset($index1[$parent_id])) {
                                                    foreach ($index1[$parent_id] as $id) {
                                                        echo '<option value=' . $data1[$id]["rec_id"] . '>' . str_repeat("_", $level) . $data1[$id]["department_name"] . '</option>';
                                                        display($id, $level + 1, $index1, $data1);
                                                    }
                                                }
                                            }

                                            display(0, 0, $index, $data);
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Employee Category</td>
                                    <td>
                                        <select id="emp_category" name="emp_category" >
                                            <option value="Staff">Staff</option>
                                            <option value="Worker">Worker</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>

                                    </td>
                                    <td>
                                        <input type="submit" name="save" id="save" value="Save"/>
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <?php ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <div data-role="main" class="ui-content">
        <div data-role="popup" id="myPopup"> </div>
        <DIV id=modal style="DISPLAY: none;">
            <div style="padding: 0px; background-color: rgb(37, 100, 192); visibility: visible; position: relative; width: 222px; height: 202px; z-index: 10002; opacity: 1;">
                <div onClick="Popup.hide('modal')" style="padding: 0px; background: transparent url(./images/close.gif) no-repeat scroll 0%; visibility: visible; position: absolute; left: 201px; top: 1px; width: 20px; height: 20px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; cursor: pointer; z-index: 10004;" id="adpModal_close"></div>
                <div style="padding: 0px; background: transparent url(resize.gif) no-repeat scroll 0%; visibility: visible; position: absolute; width: 9px; height: 9px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; cursor: nw-resize; z-index: 10003;" id="adpModal_rsize"></div>
                <div style="padding: 0px; overflow: hidden; background-color: rgb(140, 183, 231); visibility: visible; position: absolute; left: 1px; top: 1px; width: 220px; height: 20px; font-family: arial; font-style: normal; font-variant: normal; font-weight: bold; font-size: 9pt; line-height: normal; font-size-adjust: none; font-stretch: normal; color: rgb(15, 15, 15); cursor: move;" id="adpModal_adpT"></div>
                <div style="border-style: inset; border-width: 0px; padding: 8px; overflow: hidden; background-color: rgb(118, 201, 238); visibility: visible; position: absolute; left: 1px; top: 21px; width: 204px; height: 164px; font-family: MS Sans Serif; font-style: normal; font-variant: normal; font-weight: bold; font-size: 11pt; line-height: normal; font-size-adjust: none; font-stretch: normal; color: rgb(28, 94, 162);" id="adpModal_adpC">
                    <center>
                        <p>
                        <div id="div_message"></div>
                        </p>
                        <p style="font-size: 10px; color: rgb(253, 80, 0);">To gain access to the page behind the popup must be closed</p>
                    </center>
                </div>
            </div>
        </DIV>
        <iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:5000; position:absolute; left:-500px; top:0px;"> </iframe>
        <? include ("inc/hr_footer.php"); ?>
</body>