<script language="javascript">
var function_count = 0;
    function addRow(tableID) {
		function_count++;
		    var table = document.getElementById(tableID);
            var tableName = document.getElementById("child_gender").name;
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
			var colCount = table.rows[0].cells.length;
			for (var i = 0; i < colCount; i++) {
			var newcell = row.insertCell(i);
            newcell.innerHTML = table.rows[0].cells[i].innerHTML;
			var element ='';
           	if(i==2){
				alert("inside");
				/*var field = getElementById("child_gender");
				field.setAttribute("name","child_gender"+function_count);
				*/
			  var element = '<label><input name="child_gender[function_count]" id="child_gender" value="male" type="radio">Male</label><label><input name="child_gender_0" id="gen" value="female" type="radio">Female</label>';
			}
			else{
			  var element = newcell.innerHTML;
			   alert(element);
			}			
           	var tab = table.rows[0].cells[i].innerHTML;
            switch (newcell.childNodes[0].type) {
                case"text":
                newcell.childNodes[0].value = "";
                break;
                case"checkbox":
                newcell.childNodes[0].checked = false;
                break;
                case"select-one":
                newcell.childNodes[0].selectedIndex = 0;
                break;
            }
        }
	}
    function deleteRow(tableID) {
        try {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
            for (var i = 0; i < rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if (null != chkbox && true == chkbox.checked) {
                    if (rowCount <= 1) {
                        alert("Cannot delete all the rows.");
                        break;
                    }
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }
            }
        }   catch (e) {
             alert(e);
            }
    }
    $(function () {
            $('.footer').hide();
    });
</script>
    
    <style>
    .border td{ 
        padding-top:7px;
    }
    input[type='text']{
        border-radius:5px;
        width:235px !important;
        height:35px !important;
        padding-left:2px !important;
        color:#6d6d6d !important;
    }
</style>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
    <div <?
        if ($mode == 'personal_detail') {
              echo 'class="current"';
        }else {
                echo 'class="simpleTabsContent" ';
        }
        ?>>
    <form name="empolyee_family" id="empolyee_family" action="<?php
        if ($p == 'User_details.php') {
            echo 'User_details.php';
        }else {
        echo 'employee_detail.php';
        }
        ?>" method="post" enctype="multipart/form-data" onSubmit="return valid_customer(this);">
        <?php echo $p;die();?>
        <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border" border="0" >
            <tr>
                <td width="50%" valign="top">
                    <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border" height="346px">
                        <tr>
                            <?php
                                while ($row = mysql_fetch_array($result)) {
                                    echo $father_name = $row['father_name'];
                                }
                                $b = 0;
                            ?>
                            <td class="text_1" width="35%">Father Name(Mr.)<span class="red">*</span></td>
                            <td align="left" width="65%"><input type="text" name="father_name" id="father_name" style="width:210px; height:26px;" value="<?php echo $father_name ?>" required /></td>
                        </tr>
                        <tr>
                            <td class="text_1">Depended</td>
                            <td align="left" class="text_1" style="padding-left:0px;"><input type="radio" id="Dependant_member1" name="Dependant_member1" value="Yes" <? if ($Dependant_father == 'Yes') { ?>checked="checked"<? } ?>/>
                                Yes
                                <input type="radio" id="Dependant_member1" name="Dependant_member1" value="No" <? if ($Dependant_father == 'No') { ?>checked="checked"<? } ?>/>
                                No 
                            </td>
                        </tr>
                        <tr>
                            <td class="text_1">Mother Name(Mrs.) 
                                <span class="red">
                                    *
                                </span>
                            </td>
                            <td align="left">
                                <input type="text" name="mother_name" id="mother_name" style="width:210px; height:26px;" value="<?= $mother_name ?>" required />
                            </td>
                        </tr>
                        <tr>
                            <td class="text_1">
                                Depended
                            </td>
                            <td align="left" class="text_1" style="padding-left:0px;">
                                <input type="radio" id="Dependant_member2" name="Dependant_member2" value="Yes"<? if ($Dependant_mother == 'Yes') { ?>checked="checked"<? } ?>/>
                                Yes
                                <input type="radio" id="Dependant_member2" name="Dependant_member2" value="No"<? if ($Dependant_mother == 'No') { ?>checked="checked"<? } ?>/>
                                No 
                            </td>
                        </tr>
                            <?php if ($_SESSION['marital_sta'] === 'yes') { ?>
                        <tr>
                            <td class="text_1">Spouse Name </td>
                            <td align="left"><input type="text" name="wife_name" id="wife_name" style="width:210px; height:26px;" value="<?= $wife_name ?>"/></td>
                        </tr>
                        <tr>
                            <td class="text_1">
                                Depended
                            </td>
                            <td align="left" class="text_1" style="padding-left:0px;"><input type="radio" id="Dependant_member3" name="Dependant_member3" value="Yes"<? if ($Dependant_wife == 'Yes') { ?>checked="checked"<? } ?>/>
                                Yes
                                <input type="radio" id="Dependant_member3" name="Dependant_member3" value="No"<? if ($Dependant_wife == 'No') { ?>checked="checked"<? } ?>/>
                                    No 
                            </td>
                        </tr>
                            <?php } ?>
                    </table>
                </td>
                <td width="50%" valign="top">
                    <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                        <tr>
                            <td class="text_1" width="35%">Father's DOB</td>
                            <td align="left" width="65%"><input type="text" name="father_dob" id="father_dob" style="width:210px; height:26px;" value="<?= $father_dob ?>" data-beatpicker="true"></td>
                        </tr>
                        <tr>
                            <td class="text_1">Mother's DOB</td>
                            <td align="left"><input type="text" name="mother_dob" id="mother_dob" style="width:210px; height:26px;" value="<?= getDatetime($mother_dob) ?>" data-beatpicker="true" data-beatpicker-format="['DD','MM','YYYY']" />
                            </td>
                        </tr>    
                            <?php if ($_SESSION['marital_sta'] === 'yes') { ?>
                        <tr>
                            <td class="text_1">Spouse DOB </td>
                            <td align="left"><input type="text" name="wife_dob" id="wife_dob" style="width:210px; height:26px;" value="<?= $wife_dob ?>" data-beatpicker="true" data-beatpicker-format="['DD','MM','YYYY']" /></td>
                        </tr>
                            <?php } ?>
                    </table>
                </td>
            </tr>
            <?php ?>
        </table>
    </form>
</div>
<script>
        function addElements() {
            var ni = document.getElementById('myDiv1');
            var numi = document.getElementById('h_hidden').value;
            var num = (document.getElementById('h_hidden').value - 1) + 2;
            var i = document.getElementById('i').value;
            if (i > 0){            
                var nume = parseInt(i) + parseInt(1);
                        i++;
            }else {
                    var nume = parseInt(i);
            }
                numi.value = nume;
                style = "width:180px; height:20px;"
                var newdiv = document.createElement('div');
                var divIdName = 'my' + nume + 'Div1';
                var myDivName = 'myDiv1';
                newdiv.setAttribute('id', divIdName);
                newdiv.innerHTML = "<table align='center' width='100%' border='0' cellpadding='1' cellspacing='0'><tr><td align='left' style='width:291px;'><input name='child_name[]' type='text' value=''/></td><td align='left' style='width:291px;'>Male<input name='child_gender" + nume + "[]'id='child_gender' type='radio' value='male' />Female<input name='child_gender" + nume + "[]' id='child_gender' type='radio' value='female' /></td><td align='left' style='width: 290px;'>yes<input name='child_dependent" + nume + "[]' id='child_dependent' type='radio' value='yes' />no<input name='child_dependent" + nume + "[]' type='radio' value='no' /></td><td align='left' style='width:290px;'><input name='child_dob[]' id='chil_dob' type='text' value='' style='width:150px;height:20px;' /></td><td class='delete' style='padding-right:10px;'><a href=\"javascript:;\" onclick=\"removeElements(\'" + divIdName + "\'\,'" + myDivName + "\')\"><img src='images/delete_icon.jpg' border='0'/></span></a></td></tr></table>";
                i.appendChild(newdiv);
            }
        } 

            function removeElements(divNum, myDiv){
            var d = document.getElementById(myDiv);
                    var olddiv = document.getElementById(divNum);
                    d.removeChild(olddiv);
            }
</script>