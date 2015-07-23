<div <?
if ($mode == 'family_detail') {
    echo 'class="current"';
} else {
    echo 'class="simpleTabsContent"';
}
?>>
    <form name="empolyee_eduction" id="empolyee_eduction" action="<?php
    if ($p == 'User_details.php') {
        echo 'User_details.php';
    } else {
        echo 'employee_detail.php';
    }
    ?>" method="post" enctype="multipart/form-data" onSubmit="return valid_customer(this);">
        <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border" border="0"  style="padding-top:10px;">
            <tr>

                <td width="50%" valign="top">
                    <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                        <tr>
                            <td><label>S.S.C.</label></td>
                        </tr>
                        <tr>
                            <td class="text_1">Year of passing</td>
                            <td align="left"><input type="text" name="qualification" id="qualification" style="width:150px; height:20px;" value="<?= $qualification ?>"/></td>
                        </tr>
                        <tr>
                            <td class="text_1">Board</td>
                            <td class="text_2" align="left"><input type="text" name="university" id="university" style="width:150px; height:20px;" value="<?= $university ?>"/></td>
                        </tr>
                    </table></td>
                <td width="50%" valign="top">
                    <table align="center" width="100%" height="90px" cellpadding="2" cellspacing="2" class="border">

                        <tr>
                            <td class="text_1"></td>
                            <td align="left"></td>
                        </tr>
                        <tr>
                            <td class="text_1">Subject</td>
                            <td align="left"><input type="text" readonly value="All" style="width:150px; height:20px;" name="duration" id="duration"  /></td>
                        </tr>
                        <tr>
                            <td class="text_1">Percentage </td>
                            <td align="left"><input type="text" name="percentage" id="percentage" style="width:150px; height:20px;" value="<?= $percentage ?>"/></td>
                        </tr>
                        <tr>
                            <td class="text_1"></td>
                            <td align="left"></td>
                        </tr>
                        <tr>
                            <td class="text_1"></td>
                            <td align="left"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="50%" valign="top">
                    <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                        <tr>
                            <td><label>H.S.C</label></td>
                        </tr>
                        <tr>
                            <td class="text_1">Year of passing</td>
                            <td align="left"><input type="text" name="hscyear" id="hscyear" style="width:150px; height:20px;" value="<?= $hscyear ?>"/></td>
                        </tr>
                        <tr>
                            <td class="text_1">Board</td>
                            <td class="text_2" align="left"><input type="text" name="hscboard" id="hscboard" style="width:150px; height:20px;" value="<?= $hscboard ?>"/></td>
                        </tr>
                    </table></td>
                <td width="50%" valign="top">
                    <table align="center" width="100%" height="90px" cellpadding="2" cellspacing="2" class="border">
                        <tr>
                        <tr>
                            <td class="text_1"></td>
                            <td align="left"></td>
                        </tr>
                        <tr>
                            <td class="text_1">Subject</td>
                            <td>
                                <dl class="dropdown" name="hscsubject" id="hscsubject"> 
                                    <dt>
                                    <a href="javascript:void(0);">
                                        <span class="hida">Select</span>    
                                        <p class="multiSel"></p> 
                                        <div id="w">
                                            <input type="text" name="txt_hscsubject" id="txt_hscsubject">
                                            <input type="button" name="txt_save" id="txt_save" value="done"/>
                                        </div> 
                                    </a>
                                    </dt>

                                    <dd>
                                        <div class="mutliSelect">
                                            <ul>
                                                <li>
                                                <?php
												$hscsubject_explode= explode(',',$hscsubject);
												$count = sizeof($hscsubject_explode);
												$check1	=	'';
												$check2	=	'';
												$check3	=	'';
												$check4	=	'';
												$check5	=	'';
												$check6	=	'';
												$check7	=	'';
												$check8	=	'';												
												for($i=0;$i<$count;$i++){ 
												 if ($hscsubject_explode[$i] =='Maths') {
                                                         $check1 = 'checked';
                                                    }
												if ($hscsubject_explode[$i] =='physics') {
                                                         $check2 = 'checked';
                                                    }
												if ($hscsubject_explode[$i] =="Chemistry") {
                                                         $check3 = 'checked';
                                                   }
												if ($hscsubject_explode[$i] =="Biology") {
                                                         $check4 = 'checked';
                                                    }
												if ($hscsubject_explode[$i] =="Art") {
                                                         $check5 = 'checked';
                                                    }
												if ($hscsubject_explode[$i] =="English") {
                                                         $check6 = 'checked';
                                                    }
												if ($hscsubject_explode[$i] =="Hindi") {
                                                         $check7 = 'checked';
                                                    }
												if ($hscsubject_explode[$i] =="other") {
                                                         $check8 = 'checked';
                                                    }
												 } 
												 ?>
                                                    <input type="checkbox" value="Maths" name="hscsubject[]" <?php echo $check1;?>/>Maths</li>
                                                <li>
                                                    <input type="checkbox" value="physics" name="hscsubject[]" <?php echo $check2; ?> />physics</li>
                                                <li>
                                                    <input type="checkbox" value="Chemistry" name="hscsubject[]" <?php echo $check3;?> />Chemistry</li>
                                                <li>
                                               <input type="checkbox" value="Biology" name="hscsubject[]"  <?php echo $check4;?>>Biology</li>
                                                <li>
                                                    <input type="checkbox" value="Art" name="hscsubject[]"  <?php echo $check5;?>/>Art</li>
                                                <li>
                                                    <input type="checkbox" value="English"  name="hscsubject[]" <?php echo $check6;?>/>English</li>
                                                <li>
                                                    <input type="checkbox" value="Hindi" name="hscsubject[]"  <?php echo $check7;?>/>Hindi</li>
                                                <li>
                                                    <input type="checkbox" value="other" id="other" name="hscsubject[]"  <?php echo $check8;?> onclick="showText();"
                                                           />Other</li>
                                                       
                                            </ul>
                                        </div>
                                    </dd>
                                </dl>
                            </td>
                              <!--   <td align="left"><input type="text" name="hscsubject" id="hscsubject" value="<? //=$hscsubject          ?>" /></td>  -->
                            <?php /* ?><td align="left"><select name="hscsubject" id="hscsubject">
                              <option  value="">-select-</option>
                              <option value="SCIENCE" <?php if($hscsubject == "SCIENCE"){echo 'selected="selected"'; } ;?>>SCIENCE</option>

                              <option value="COMERCE" <?php if($hscsubject == "COMERCE"){echo 'selected="selected"'; } ;?>>COMERCE</option>
                              <option value="ARTS" <?php if($hscsubject == "ARTS"){echo 'selected="selected"'; } ;?>>ARTS</option>
                              <option value="HOME SCIENCE" <?php if($hscsubject == "HOME SCIENCE"){echo 'selected="selected"'; } ;?>>HOME SCIENCE</option>

                              <option value="AGRICULTURE" <?php if($hscsubject == "AGRICULTURE"){echo 'selected="selected"'; } ;?>>AGRICULTURE</option>
                              </select></td><?php */ ?>
                        </tr>
                        <tr>
                            <td class="text_1">Percentage </td>
                            <td align="left"><input type="text" name="hscpercentage" id="hscpercentage" style="width:150px; height:20px;" value="<?= $hscpercentage ?>"/></td>
                        </tr>
                        <tr>
                            <td class="text_1"></td>
                            <td align="left"></td>
                        </tr>
                        <tr>
                            <td class="text_1"></td>
                            <td align="left"></td>
                        </tr>
            </tr>

        </table></td>
        </tr>

        <tr>
            <td width="50%" valign="top">
                <table align="center" width="100%" height="243px" cellpadding="2" cellspacing="2" class="border">
                    <tr>
                        <td><label>Diploma</label>
                    <tr>
                        <td>
                    <tr>
                        <td class="text_1">Qualification</td>
                        <td align="left"><input type="text" name="diplomaqualification" id="diplomaqualification" style="width:150px; height:20px;" value="<?= $diplomaqualification ?>"/></td>
                    <tr>
                        <td class="text_1">Year of passing</td>
                        <td align="left"><input type="text" name="diplomayear" id="diplomayear" style="width:150px; height:20px;" value="<?= $diplomayear ?>"/></td>
                    </tr>
                    <tr>
                        <td class="text_1">University </td>
                        <td class="text_2" align="left"><input type="text" name="diplomauniversity" id="diplomauniversity" style="width:150px; height:20px;" value="<?= $diplomauniversity ?>"/></td>
                    </tr>
                </table></td>
            <td width="50%" valign="top">
                <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                    <tr>
                    <tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                    </tr>
                    <tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                    </tr>
                    <tr>
                        <td class="text_1">Course Duration</td>
                        <td class="text_2" align="left">
                            <select name="diplomaduration" id="diplomaduration" >
                                <option  value="" >-select-</option>
                                <option value="1" <?php
                                if ($diplomaduration == "1") {
                                    echo 'selected="selected"';
                                };
                                ?>>1year</option>
                                <option value="2" <?php
                                if ($diplomaduration == "2") {
                                    echo 'selected="selected"';
                                };
                                ?>>2year</option>
                                <option value="3" <?php
                                if ($diplomaduration == "3") {
                                    echo 'selected="selected"';
                                };
                                ?>>3year</option>
                                <option value="4" <?php
                                if ($diplomaduration == "4") {
                                    echo 'selected="selected"';
                                };
                                ?>>4year</option>
                            </select></td>
                    </tr>
                    <tr>
                        <td class="text_1">Percentage </td>
                        <td align="left"><input type="text" name="diplomapercentage" id="diplomapercentage" style="width:150px; height:20px;" value="<?= $diplomapercentage ?>"/></td>
                    </tr>
                    <tr>
                        <td class="text_1">Specialization</td>
                        <td align="left"><input type="text" name="diploma_specialization" id="diploma_specialization" style="width:150px; height:20px;" value="<?= $diploma_specialization ?>"/></td>
                    </tr>
                    <tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                    </tr>
                    <tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                    </tr>
                    <tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                    </tr>
                    <tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                    </tr>
                    <!--<tr>
                      <td class="text_1"></td>
                      <td align="left"></td>
                    </tr>
                    <tr>
                      <td class="text_1"></td>
                      <td align="left"></td>
                    </tr>
                    <tr>
                      <td class="text_1"></td>
                      <td align="left"></td>
                    </tr>-->
                </table></td>
        </tr>
        <tr>
            <td width="50%" valign="top">
                <table align="center" width="100%" height="241px" cellpadding="2" cellspacing="2" class="border">
                    <tr>
                        <td><label>Graduation</label></td>
                    </tr>
                    <tr>
                        <td class="text_1">Qualification</td>
                        <td align="left"><input type="text" name="graduationqualification" id="graduationqualification" style="width:150px; height:20px;" value="<?= $graduationqualification ?>"/></td>
                    </tr>
                    <td class="text_1">Year of passing</td>
                    <td align="left"><input type="text" name="graduationpassingyear" id="graduationpassingyear" style="width:150px; height:20px;" value="<?= $graduationpassingyear ?>"/></td>
                    <tr>
                        <td class="text_1">University</td>
                        <td class="text_2" align="left"><input type="text" name="graduationuniversity" id="graduationuniversity" style="width:150px; height:20px;" value="<?= $graduationuniversity ?>"/></td>
                    </tr>
                </table></td>
            <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                    <tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                    </tr>
                    <td class="text_1"></td>
                    <td align="left"></td>
        </tr>
        <td class="text_1"></td>
        <td align="left"></td>
        </tr>
        <tr>
            <td class="text_1">Course Duration</td>
            <td align="left"><select name="grdurationDuration" id="grdurationDuration">
                    <option value="">-select-</option>
                    <option value="1" <?php
                    if ($grdurationDuration == "1") {
                        echo 'selected="selected"';
                    };
                    ?>>1year</option>
                    <option value="2year" <?php
                    if ($grdurationDuration == "2year") {
                        echo 'selected="selected"';
                    };
                    ?>>2year</option>
                    <option value="3" <?php
                    if ($grdurationDuration == "3") {
                        echo 'selected="selected"';
                    };
                    ?> >3year</option>
                    <option value="4" <?php
                    if ($grdurationDuration == "4") {
                        echo 'selected="selected"';
                    };
                    ?>>4year</option>
                    <option value="5" <?php
                    if ($grdurationDuration == "5") {
                        echo 'selected="selected"';
                    };
                    ?>>5year</option>
                </select>
        </tr>
        <tr>
            <td class="text_1">Percentage </td>
            <td align="left"><input type="text" name="graduationpercentage" id="graduationpercentage" style="width:150px; height:20px;" value="<?= $graduationpercentage ?>"/></td>
        </tr>
        <tr>
            <td class="text_1">Specialization</td>
            <td align="left"><input type="text" name="graduation_specialization" id="graduation_specialization" style="width:150px; height:20px;" value="<?= $graduation_specialization ?>"/></td>
        </tr>
        <tr>
            <td class="text_1"></td>
            <td align="left"></td>
        </tr>
        <tr>
            <td class="text_1"></td>
            <td align="left"></td>
        </tr>
        <tr>
            <td class="text_1"></td>
            <td align="left"></td>
        </tr>
        <!--<tr>
          <td class="text_1"></td>
          <td align="left"></td>
        </tr>
        <tr>
          <td class="text_1"></td>
          <td align="left"></td>
        </tr>
        -->          </table></td>
        </tr>
        <tr>
            <td width="50%" valign="top">
                <table align="center" width="100%" height="252px" cellpadding="2" cellspacing="2" class="border">
                    <tr>
                        <td><label>Post-Graduation</label>
                    <tr>
                        <td>
                    <tr>
                        <td class="text_1">Qualification</td>
                        <td align="left"><input type="text" name="mastergraduationqualification" id="mastergrationqualification" style="width:150px; height:20px;" value="<?= $mastergraduationqualification ?>"/></td>
                    <tr>
                        <td class="text_1">Year of passing</td>
                        <td align="left"><input type="text" name="mastergraduationpassingyear" id="mastergraduationpassingyear" style="width:150px; height:20px;" value="<?= $mastergraduationpassingyear ?>"/></td>
                    </tr>
                    <tr>
                        <td class="text_1">University </td>
                        <td class="text_2" align="left"><input type="text" name="mastergraduationuniversity" id="mastergraduationuniversity" style="width:150px; height:20px;" value="<?= $mastergraduationuniversity ?>"/></td>
                    </tr>
                </table></td>
            <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                    <tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                    </tr>
                    <td class="text_1"></td>
                    <td align="left"></td>
        </tr>
        <tr>
            <td class="text_1">Course Duration</td>
            <td align="left"><select name="mastergraduationduration" id="mastergraduationduration">
                    <option  value="">-select-</option>
                    <option value="1" <?php
                    if ($mastergraduationduration == "1") {
                        echo 'selected="selected"';
                    };
                    ?>>1year</option>
                    <option value="2" <?php
                    if ($mastergraduationduration == "2") {
                        echo 'selected="selected"';
                    };
                    ?>>2year</option>
                    <option value="3" <?php
                    if ($mastergraduationduration == "3") {
                        echo 'selected="selected"';
                    };
                    ?>>3year</option>
                    <option value="4" <?php
                    if ($mastergraduationduration == "4") {
                        echo 'selected="selected"';
                    };
                    ?>>4year</option>
                </select></td>
        </tr>
        <tr>
            <td class="text_1">Percentage </td>
            <td align="left"><input type="text" name="mastergraduationpercentage" id="mastergraduationpercentage" style="width:150px; height:20px;" value="<?= $mastergraduationpercentage ?>"/></td>
        </tr>
        <tr><td class="text_1"></td></tr>
        <tr>
            <td class="text_1">Specialization</td>
            <td align="left"><input type="text" name="master_specialization" id="master_specialization" style="width:150px; height:20px;" value="<?= $master_specialization ?>"/></td>
        </tr>
        <td class="text_1"></td>
        <td align="left"></td>
        </tr>
        <td class="text_1"></td>
        <td align="left"></td>
        </tr>
        <td class="text_1"></td>
        <td align="left"></td>
        </tr>
        <td class="text_1"></td>
        <td align="left"></td>
        </tr>
        <!--<td class="text_1"></td>
          <td align="left"></td>
        </tr>
        <td class="text_1"></td>
          <td align="left"></td>
        </tr>
        <td class="text_1"></td>
          <td align="left"></td>
        </tr>-->
        </table></td>
        </tr>
        <tr>
            <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                    <tr>
                        <td><label>Other</label>
                    <tr>
                        <td>
                    <tr>
                        <td class="text_1">Qualification</td>
                        <td align="left"><input type="text" name="other_qualification" id="other_qualification" style="width:150px; height:20px;" value="<?= $other_qualification ?>"/></td>
                    <tr>
                        <td class="text_1">Year of passing</td>
                        <td align="left"><input type="text" name="other_qualification_year" id="other_qualification_year" style="width:150px; height:20px;" value="<?= $other_qualification_year ?>"/></td>
                    </tr>
                    <tr>
                        <td class="text_1">NCVT/SCVT</td>
                        <td align="left"><input type="text" name="ncvt_scvt" id="ncvt_scvt" style="width:150px; height:20px;" value="<?= $ncvt_scvt ?>"/></td>
                    </tr>
                    <tr>
                        <td class="text_1">University </td>
                        <td class="text_2" align="left"><input type="text" name="other_university" id="other_university" style="width:150px; height:20px;" value="<?= $other_university ?>"/></td>
                    </tr>
                </table></td>
            <td width="50%" valign="top">
                <table align="center" width="100%" height="272px" cellpadding="2" cellspacing="2" class="border">
                    <tr>
                        <td class="text_1">Course Duration</td>
                        <td align="left"><select name="other_course_duration" id="other_course_duration">
                                <option  value="">-select-</option>
                                <option value="1" <?php
                                if ($other_course_duration == "1") {
                                    echo 'selected="selected"';
                                };
                                ?>>1year</option>
                                <option value="2" <?php
                                if ($other_course_duration == "2") {
                                    echo 'selected="selected"';
                                };
                                ?>>2year</option>
                                <option value="3" <?php
                                if ($other_course_duration == "3") {
                                    echo 'selected="selected"';
                                };
                                ?>>3year</option>
                                <option value="4" <?php
                                if ($other_course_duration == "4") {
                                    echo 'selected="selected"';
                                };
                                ?>>4year</option>
                            </select></td>
                    </tr>
                    <tr>
                        <td class="text_1">Percentage </td>
                        <td align="left"><input type="text" name="other_course_percentage" id="other_course_percentage" style="width:150px; height:20px;" value="<?= $other_course_percentage ?>"/></td>
                    </tr>
                    <tr>
                        <td class="text_1">Specialization</td>
                        <td align="left"><input type="text" name="other_specialization" id="other_specialization" style="width:150px; height:20px;" value="<?= $other_specialization ?>"/></td>
                    </tr>
                    <tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                    </tr><tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                    </tr><tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                    </tr>
                    <tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                    </tr><tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                    </tr><tr>
                        <td class="text_1"></td>
                        <td align="left"></td>
                    </tr>

                </table></td>
        </tr>
        <!--<tr>
          <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
              <tr>
                <td><label>Experience</label>
              <tr>
                <td>
              <tr>
                <td class="text_1">Previous Employer's Name</td>
                <td align="left"><textarea name="previous_employer_name"><?= $previous_employer_name ?>
  </textarea></td>
              <tr>
                <td class="text_1">Year Of Experience With Previous Employer</td>
                <td align="left"><select name="previous_employer_experience">
                    <option  value="">-select-</option>
                    <option value="1" <?php
        if ($previous_employer_experience == "1") {
            echo 'selected="selected"';
        };
        ?>>1year</option>
                    <option value="2" <?php
        if ($previous_employer_experience == "2") {
            echo 'selected="selected"';
        };
        ?>>2year</option>
                    <option value="3" <?php
        if ($previous_employer_experience == "3") {
            echo 'selected="selected"';
        };
        ?>>3year</option>
                    <option value="4" <?php
        if ($previous_employer_experience == "4") {
            echo 'selected="selected"';
        };
        ?>>4year</option>
                    <option value="5" <?php
        if ($previous_employer_experience == "5") {
            echo 'selected="selected"';
        };
        ?>>5year</option>
                    <option value="6" <?php
        if ($previous_employer_experience == "6") {
            echo 'selected="selected"';
        };
        ?>>6year</option>
                    <option value="7" <?php
        if ($previous_employer_experience == "7") {
            echo 'selected="selected"';
        };
        ?>>7year</option>
                    <option value="8" <?php
        if ($previous_employer_experience == "8") {
            echo 'selected="selected"';
        };
        ?>>8year</option>
                    <option value="9" <?php
        if ($previous_employer_experience == "9") {
            echo 'selected="selected"';
        };
        ?>>9year</option>
                    <option value="10" <?php
        if ($previous_employer_experience == "10") {
            echo 'selected="selected"';
        };
        ?>>10year</option>
                    <option value="More than 10" <?php
        if ($previous_employer_experience == "More than 10") {
            echo 'selected="selected"';
        };
        ?>>More than 10 year</option>
  </select></td>
              </tr>
              <tr>
                <td class="text_1">Designation</td>
                <td align="left"><input type="text" name="previous_employer_designation" id="previous_employer_designation" style="width:150px; height:20px;" value="<?= $previous_employer_designation ?>"/></td>
              </tr>
            </table></td>
          <td width="50%" valign="top">
          <table align="center" width="100%" height="154px" cellpadding="2" cellspacing="2" class="border">
              <tr>
                <td>Total Experience</td>
              </tr>
              <tr>
                <td class="text_1">No of years</td>
                <td align="left"><input type="text" name="total_experience_years" id="total_experience_years" value="<?= $total_experience_years ?>" style="width:150px; height:20px;"/></td>
              </tr>
              <tr>
                <td class="text_1">Area Of Work</td>
                <td align="left"><input type="text" name="total_experience_area" id="total_experience_area" style="width:150px; height:20px;" value="<?= $total_experience_area ?>"/></td>
              </tr>
              <tr>
                <td class="text_1">Other Specialization</td>
                <td align="left"><textarea name="total_experience_specialization"><?= $total_experience_specialization ?>
  </textarea></td>
              </tr>
            </table></td>
        </tr>-->
        <tr>
        <tr>
            <td colspan="2" style="text-align:center;"><input type="submit"  value="Next" name="emp_education" id="emp_education"/>
                <? if (isset($_SESSION['emp_id'])) {
                    ?>
                                                      <!--<input type="button"  value="Done" name="Submit_emp2" id="Submit_emp2" onClick="document.location='list_employee.php?ticket_no=<?= $ticket_no ?>';"/>-->
                    <?
                }
                ?>
                <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" /></td>
        </tr>
        </table>
    </form>
</div>
