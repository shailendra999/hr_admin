
<!-- date picker -->
<link rel="stylesheet" href="css/BeatPicker.min.css"/>
<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/BeatPicker.min.js"></script>
<!-- end -->

<?

include('inc/dbconnection.php');
$id="";
$net_advance="";
$id = $_GET["id"];
$sql = "SELECT sum(advance) as total_advance,sum(deduction) as total_deduction FROM  mpc_advance_employee where emp_id  = '$id'";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result)>0)
{
	while($row = mysql_fetch_array($result))
	{
		$total_advance=$row['total_advance'];
		$total_deduction=$row['total_deduction'];
		$net_advance=$total_advance-$total_deduction;
	} 	
}
?>
<style type="text/css" media="screen">
@import "tab/css/style.css";
@import "tab/css/simpletabs.css";
</style>
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
	<tr>
    	<td colspan="2" class="blackHead">Account Detail</td>
    </tr>
	<tr>
        <td style="vertical-align:top; padding-top:5px;">
            <div class="simpleTab">
                <ul class="simpleTabsNavigation">
                    <li><a href="javascript:;" onclick="show_tab(1)" class="current" id="menu_item1">Advance</a></li>
                    <li><a href="javascript:;" onclick="show_tab(2)" id="menu_item2">Loan</a></li>
            
                </ul>
            </div>
            <div class="current" id="tab_content1">        
              <form id="frm_advance" name="frm_advance" action="" method="post">     
                <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0" class="border">
                 	<tr>
                        <td class="text_1">Out Standing Advance</td>
                        <td style="border-right:1px solid #CCCCCC;">
                           <?=$net_advance?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text_1">Advance Limit left</td>
                        <td style="border-right:1px solid #CCCCCC;">
                             <?=$net_advance?>
                        </td>
                    </tr>
                    <tr>
                    <td class="text_1">Date</td>
                    <td>
                    <input type="text" name="advancedate" id="advancedate" style="width:150px; height:20px;" value="" data-beatpicker="true"  placeholder="dd-mm-yyyy"/></td>
                    <tr>
                        <td class="text_1">Issue Advance</td>
                        <td style="border-right:1px solid #CCCCCC;">
                            <input type="text" name="issue_advance" id="issue_advance" style="width:180px; height:20px;"/>
                            <input type="hidden" name="emp_id" id="emp_id" value="<?=$id?>" style="width:180px; height:20px;"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input type="image" src="images/btn_submit.png" name="submit_advance" id="submit_advance" value="Submit"/>
                        </td>
                    </tr>
                </table>
                </form>
            </div>
            <div class="simpleTabsContent" id="tab_content2">   
              <form id="frm_loan" name="frm_loan" action="" method="post">          
                <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0" class="border">
                    <?
                    $sql = "SELECT rec_id ,loan_amount,installments_decided FROM mpc_loan_employee where emp_id  = '$id' and status ='Open'";
                    $result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
                    if(mysql_num_rows($result)>0)
                    {
						$i=1;;
                        while($row = mysql_fetch_array($result))
                        {
                            $loan_amount=$row['loan_amount'];
							$installments_decided =$row['installments_decided'];
							$sql_install = "SELECT sum(installments) as install FROM mpc_loan_installments where loan_id=".$row['rec_id'];
                  		    $result_install = mysql_query ($sql_install) or die ("Error in : ".$sql_install."<br>".mysql_errno()." : ".mysql_error());
							$row_install= mysql_fetch_array($result_install);
                            $total_install=$row_install['install'];
                            $net_loan=$loan_amount-$total_install;
                       ?>
                    <tr>
                    	<td colspan="2" class="text_1">
                        Loan <?=$i?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text_1">Out Standing Loan</td>
                        <td><?=$net_loan?></td>
                    </tr>
                    <tr>
                        <td class="text_1">Installment</td>
                        <td><?=$installments_decided?></td>
                    </tr>
                    	<?
						$i++;
						 } 	
                    }
					?>
                    <tr>
                        <td class="text_1">Issue Loan</td>
                        <td style="border-right:1px solid #CCCCCC;">
                            <input type="text" name="issuse_loan" id="issuse_loan" style="width:180px; height:20px;"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="text_1">Decide Installment</td>
                        <td style="border-right:1px solid #CCCCCC;">
                            <input type="text" name="decide_install" id="decide_install" style="width:180px; height:20px;"/>
                            <input type="hidden" name="emp_id" id="emp_id" value="<?=$id?>" style="width:180px; height:20px;"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input type="image" src="images/btn_submit.png" name="submit_loan" id="submit_loan" value="Submit"/>
                        </td>
                    </tr>
                </table>
                </form>
            </div>
       </td>      
    </tr>
</table>