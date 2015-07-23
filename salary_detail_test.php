<div <?
if ($mode == 'offical_profile') {
    echo 'class="current"';
} else {
    echo 'class="simpleTabsContent"';
}
?>>
    <form name="salary_detail" id="salary_detail" action="employee_detail.php?mode=salary_details" method="post" enctype="multipart/form-data" onSubmit="return valid_customer(this);">
        <table width="62%" align="center" border="0" align="center" cellpadding="0" cellspacing="0" class="table" >
            <tr>
                <th width="349" height="40" align="left" valign="middle" scope="col"><h2>Elements</h2></th>
            <th width="25" scope="col">&nbsp;</th>
            <th width="188" align="left" valign="middle" scope="col"><h3>Monthly (Rs)</h3></th>
            <th width="188" align="left" valign="middle" scope="col"><h3>Per Annum (Rs)</h3></th>
            </tr>

            <tr>
                <td height="30"><h2>Fixed Compensation</h2></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td height="30">Basic</td>
                <td>:</td>
                <td align="left" valign="middle"><input type="text" name="basic" id="basic" value="<?php echo $basic; ?>" onblur="test()" /></td>
                <td><input type="text" name="Basic_Annum" readonly id="basic_annum"   /></td>
            </tr>
            <tr>
                <td height="30">HRA</td>
                <td>:</td>
                <td><input type="text" name="hra" onblur="test()" id="hra" value="<?= $hra ?>"/></td>
                <td><input type="text" name="HRA_Annum" id="hra_annum" readonly /></td>
            </tr>
            <tr>
                <td height="30">Conveyance</td>
                <td>:</td>
                <td><input type="text" name="convence" id="conveynce" onblur="test()" value="<?= $convence ?>"/></td>
                <td><input type="text" name="Conveyance_Annum" id="conveynce_annum" readonly  /></td>
            </tr>
            <tr>
                <td height="30">Special Allowance</td>
                <td>:</td>
                <td><input type="text" name="side_allowance" id="special" onblur="test()" value="<?= $side_allowance ?>" /></td>
                <td><input type="text" name="Special_Annum" id="special_annum" readonly /></td>
            </tr>
            <tr>
                <td height="30">Telephone Reimbursement</td>
                <td>:</td>
                <td><input type="text" name="phone_allowance" id="telephone" onblur="test()" value="<?= $phone_allowance ?>" /></td>
                <td><input type="text" name="Telephone_Annum" id="telephone_annum" readonly/></td>
            </tr>
            <tr>
                <td height="30">Other's Allowance</td>
                <td>:</td>
                <td><input type="text" name="other_allowance" id="other_all" onblur="test()" value="<?= $other_allowance ?>"/></td>
                <td><input type="text" name="Other's_Annum" id="other_annum" readonly /></td>
            </tr>
            <tr>
                <td height="30"><h2>(A) Gross salary</h2></td>
                <td>:</td>
                <td><input type="text" name="earning" id="gross"  readonly="readonly" value="<?= $earning ?>"/></td>
                <td><input type="text" name="Gross_Annum" id="gross_annum"  readonly="readonly" /></td>
            </tr>
            <tr>
                <td height="30"><h2>(B) Employee Contribution</h2></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td height="30">PF</td>
                <td>:</td>
                <td><input type="text" name="PF_Monthly" id="pf" readonly  /></td>
                <td><input type="text" name="PF_Annum" id="pf_annum" readonly /></td>
            </tr>
            <tr>
                <td height="30">ESIC</td>
                <td>:</td>
                <td><input type="text" name="ESIC_Monthly" id="esic" readonly /></td>
                <td><input type="text" name="Other's_Annum" id="esic_annum" readonly  /></td>
            </tr>
            <tr>
                <td height="30"><h3>Total Contribution</h3></td>
                <td>:</td>
                <td><input type="text" name="Total_Monthly" id="total" readonly /></td>
                <td><input type="text" name="Total_Annum" id="total_annum" readonly /></td>
            </tr>
            <tr bgcolor="#FFFF00">
                <td height="30"><h3>Take Home</h3></td>
                <td>:</td>
                <td><input type="text" name="take_home" id="takehome"  readonly="readonly" value="<?= $take_home ?>"/></td>
                <td><input type="text" name="Take_Annum" id="takehome_annum"  readonly="readonly" /></td>
            </tr>
            <tr>
                <td height="30"><b>(C)</b> Bonus / Ex-gretia (Annually)</td>
                <td>:</td>
                <td><input type="text" name="bonus" onload="test_bonus()" id="bonus" value="<?= $bonus ?>"/></td>
                <td><input type="text" name="Bonus_Annum" readonly id="bonus_annum" /></td>
            </tr>
            <tr>
                <td height="30"><h3>Sub Total</h3></td>
                <td>:</td>
                <td><input type="text" name="Sub_Monthly" id="subtotal"  readonly="readonly" onblur="test()"/></td>
                <td><input type="text" name="Sub_Annum" id="subtotal_annum"  readonly="readonly" /></td>
            </tr>
            <tr>
                <td height="30"><h2>(D) Employer Contribution</h2></td>
                <td>:</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td height="30">PF</td>
                <td>:</td>
                <td><input type="text" name="PF_Monthly" id="employer_pf" readonly /></td>
                <td><input type="text" name="PF_Annum" id="employer_pf_annum" readonly  /></td>
            </tr>
            <tr>
                <td height="30">ESIC</td>
                <td>:</td>
                <td><input type="text" name="ESIC_Monthly" readonly id="employer_esic" /></td>
                <td><input type="text" name="ESIC_Annum" readonly id="employer_esic_annum" /></td>
            </tr>
            <tr>
                <td height="30">Mediclaim/Insurance</td>
                <td>:</td>
                <?php
                if ($esic_applicable == 'notapplicable') {
                    if ($grade == 'E1') {
                        $medical = 250;
                    }
                    if ($grade == 'E2') {
                        $medical = 250;
                    }
                    if ($grade == 'E3') {
                        $medical = 500;
                    }
                    if ($grade == 'E4') {
                        $medical = 500;
                    }
                    if ($grade == 'E5') {
                        $medical = 700;
                    }
                    if ($grade == 'E6') {
                        $medical = 1000;
                    }
                } else {
                    if ($esic_applicable == "applicable") {
                        $medical = null;
                    }
                }
                ?>
                <td><input type="text" name="medical" id="employer_madi" onblur="test()" value="<?= $medical ?>"/></td>
                <td><input type="text" name="Mediclaim_Annum" id="employer_madi_annum" onblur="test()" /></td>
            </tr>
            <tr>
                <td height="30">Gratuity</td>
                <td>:</td>
                <td><input type="text" name="gratuity" id="employer_gratuity" onload="test_bonus()" value="<?= $gratuity ?>" /></td>
                <td><input type="text" name="Gratuity_Annum" id="employer_gratuity_annum" onload="test_bonus()"/></td>
            </tr>
            <tr>
                <td height="30"><h3>Sub Total</h3></td>
                <td>:</td>
                <td><input type="text" name="Sub_Monthly" id="employer_subtotal"  readonly="readonly" /></td>
                <td><input type="text" name="Sub_Annum" id="employer_subtotal_annum"  readonly="readonly" /></td>
            </tr>
            <tr>
                <td height="30"><b>(E)</b> Loyalty Allowance / Performance Allowance</td>
                <td>:</td>
                <td><input type="text" name="Loyalty_Monthly" id="loyalty" onblur="test()" value="<?= $leave_travel_allow ?>" /></td>
                <td><input type="text" name="Loyalty_Annum" id="loyalty_annum" readonly onblur="test()" /></td>
            </tr>
            <tr>
                <td height="30">Grand Total</td>
                <td>:</td>
                <td rowspan="2"><input type="text" name="Total_Monthly" id="grand_total" readonly /></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td height="30">Total CTC : (A+D+E)</td>
                <td>:</td>
                <td><input type="text" name="Total_Annum" id="ctc" readonly /></td>
            </tr>
            <tr>
                <td colspan="4" style="text-align:center;"><input type="submit"  value="Next" name="emp_salary" id="emp_salary"/>
                    <? if (isset($_SESSION['emp_id'])) {
                        ?>
                                                                    <!--  <input type="button"  value="Done" name="Submit_emp2" id="Submit_emp2" onClick="document.location='list_employee.php?ticket_no=<? //=$ticket_no           ?>';"/>-->
                        <?
                    }
                    ?>
                    <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" /></td>
            </tr>
        </table>
    </form>
</div>
<script>
    function test()
    {
        var basic = document.getElementById('basic').value;
        var basic_annum = document.getElementById('basic_annum').value;
        var hra = document.getElementById('hra').value;
        var hra_annum = document.getElementById('hra_annum').value;
        var conveynce = document.getElementById('conveynce').value;
//        var other_allowance = document.getElementById()
        var conveynce_annum = document.getElementById('conveynce_annum').value;
        var special = document.getElementById('special').value;
        var special_annum = document.getElementById('special_annum').value;
        var telephone = document.getElementById('telephone').value;
        var telephone_annum = document.getElementById('telephone_annum').value;
        var other = document.getElementById('other_all').value;
//        alert(other);
        var other_annum = document.getElementById('other_annum').value;
        var pf = document.getElementById('pf').value;
        var pf_annum = document.getElementById('pf_annum').value;
        var esic_annum = document.getElementById('esic_annum').value;
        var takehome = document.getElementById('takehome').value;
        var takehome_annum = document.getElementById('takehome_annum').value;
        var employer_pf_annum = document.getElementById('employer_pf_annum').value;
        var employer_esic_annum = document.getElementById('employer_esic_annum').value;
        var employer_madi_annum = document.getElementById('employer_madi_annum').value;
        var employer_gratuity_annum = document.getElementById('employer_gratuity_annum').value;
        var employer_pf = document.getElementById('employer_pf').value;
        var employer_esic = document.getElementById('employer_esic').value;
        var employer_madi = document.getElementById('employer_madi').value;
        var employer_gratuity = document.getElementById('employer_gratuity').value;
        var loyalty = document.getElementById('loyalty').value;
        document.getElementById('loyalty_annum').value = parseInt(+loyalty) * 12;
        document.getElementById('employer_esic_annum').value = parseInt(+employer_esic) * 12;
        document.getElementById('employer_madi_annum').value = parseInt(+employer_madi) * 12;
        document.getElementById('employer_subtotal').value = parseInt(+employer_pf) + parseInt(+employer_esic) +
                parseInt(+employer_madi) + parseInt(+employer_gratuity);
        //document.getElementById('employer_subtotal_annum').value=parseInt(+employer_pf_annum)+parseInt(+employer_esic_annum)+
        parseInt(+employer_madi_annum) + parseInt(+employer_gratuity_annum);
        //document.getElementById('bonus_annum').value = parseInt(+bonus)*12;
        //document.getElementById('subtotal').value = parseInt(+takehome)+parseInt(+bonus);
        //   document.getElementById('subtotal_annum').value=document.getElementById('takehome_annum').value+
        // document.getElementById('bonus_annum').value;
        document.getElementById('gross').value = parseInt(+basic) + parseInt(+hra) + parseInt(+conveynce) + parseInt(+special) + parseInt(+telephone) + parseInt(+other);
        //document.getElementById('gross_annum').value=parseInt(+basic_annum)+parseInt(+hra_annum)+parseInt(+conveynce_annum)+parseInt(+special_annum)+parseInt(+telephone_annum)+parseInt(+other_annum);
        document.getElementById('total_annum').value = parseInt(+pf_annum) + parseInt(+esic_annum);
        document.getElementById('takehome_annum').value = document.getElementById('gross_annum').value - document.getElementById('total_annum').value;
        document.getElementById('basic_annum').value = parseInt(+basic) * 12;
        document.getElementById('hra_annum').value = parseInt(+hra) * 12;
        document.getElementById('conveynce_annum').value = parseInt(+conveynce) * 12;
        document.getElementById('special_annum').value = parseInt(+special) * 12;
        document.getElementById('telephone_annum').value = parseInt(+telephone) * 12;
        document.getElementById('other_annum').value = parseInt(+other) * 12;
        document.getElementById('gross_annum').value = parseInt(+document.getElementById('gross').value) * 12;
        document.getElementById('pf').value = parseInt(+basic) * 12 / 100;
        //document.getElementById('pf_annum').value = parseInt(+basic_annum)*12/100;
        document.getElementById('esic').value = document.getElementById('esic_rate').value * document.getElementById('gross').value / 100;

        document.getElementById('employer_esic').value = document.getElementById('esic_rate_employer').value * document.getElementById('gross').value / 100;
        //document.getElementById('esic').value=parseInt(+document.getElementById('gross').value)*parseInt(+document.getElementById('esic_rate').value)/100;
        //document.getElementById('employer_esic').value=parseInt(+document.getElementById('gross').value)*parseInt(+document.getElementById('esic_rate_employer').value)/100;
        //document.getElementById('subtotal_annum').value = parseInt(+subtotal)*12;
        document.getElementById('employer_pf').value = parseInt(+basic) * 12 / 100;

        //document.getElementById('esic_annum').value = parseInt(+esic)*12;



        document.getElementById('total').value = parseInt(+document.getElementById('pf').value) + parseInt(+document.getElementById('esic').value);



        document.getElementById('total_annum').value = parseInt(+document.getElementById('total').value) * 12;

        document.getElementById('pf_annum').value = parseInt(+document.getElementById('pf').value) * 12;
        document.getElementById('esic_annum').value = parseInt(+document.getElementById('esic').value) * 12;
        document.getElementById('employer_pf_annum').value = parseInt(+document.getElementById('employer_pf').value) * 12;
        document.getElementById('employer_esic_annum').value = parseInt(+document.getElementById('employer_esic').value) * 12;

        document.getElementById('takehome').value = document.getElementById('gross').value - document.getElementById('total').value;
        document.getElementById('takehome_annum').value = parseInt(+document.getElementById('takehome').value) * 12;
        //document.getElementById('employer_pf_annum').value=parseInt(+employer_pf)*12;

        document.getElementById('employer_subtotal').value = parseInt(+document.getElementById('employer_pf').value) + parseInt(+document.getElementById('employer_esic').value) +
                parseInt(+document.getElementById('employer_madi').value) + parseInt(+document.getElementById('employer_gratuity').value);

        document.getElementById('employer_subtotal_annum').value = parseInt(+document.getElementById('employer_subtotal').value) * 12;
        document.getElementById('total_annum').value = parseInt(+document.getElementById('total').value) * 12;

        document.getElementById('grand_total').value = parseInt(+document.getElementById('gross').value) + parseInt(+document.getElementById('employer_subtotal').value) +
                parseInt(+document.getElementById('loyalty').value);
        //document.getElementById('ctc').value = parseInt(+document.getElementById('employer_subtotal').value)*12;
        //alert(document.getElementById('grand_total').value);
        document.getElementById('ctc').value = parseInt(+document.getElementById('grand_total').value) * 12;


    }
    function test_bonus() {
        document.getElementById('employer_gratuity').value = parseInt(+document.getElementById('basic').value) * 4.84 / 100;

        document.getElementById('bonus').value = parseInt(+document.getElementById('bonus_rate').value) * parseInt(+document.getElementById('basic').value) / 100;

        document.getElementById('bonus_annum').value = parseInt(+document.getElementById('bonus').value) * 12;
        document.getElementById('subtotal').value = document.getElementById('+bonus').value;
        document.getElementById('subtotal_annum').value = parseInt(+document.getElementById('subtotal').value) * 12;
        document.getElementById('bonus_annum').value = parseInt(+document.getElementById('bonus').value * 12);


    }


</script> 
