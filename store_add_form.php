<?
include("inc/store_header.php");
?>
<script type="text/javascript">
function overlay(MasterId,RecordId) 
{
	e1 = document.getElementById("overlay");
	document.getElementById("hidden_overlay_master").value=MasterId;
	document.getElementById("hidden_overlay").value=RecordId;
	e1.style.visibility = (e1.style.visibility == "visible") ? "hidden" : "visible";	
}
</script>
<script type="text/javascript">
function addElement() {
	var ni = document.getElementById('myDiv1');
  var numi = document.getElementById('h_hidden');
  var num = (document.getElementById('h_hidden').value -1)+ 2;
  numi.value = num;
  var newdiv = document.createElement('div');
  var divIdName = 'my'+num+'Div1';
  var myDivName='myDiv1';
  newdiv.setAttribute('id',divIdName);
  if(num%2!==0)
		tableColor="#f8f1ef";
	else
		tableColor="#eedfdc";
	var myTable = "<table align='center' width='100%' cellpadding='1' cellspacing='1' class='border' border='0'>";
	myTable +="<input type='hidden' name='form_transaction_id[]' id='form_transaction_id[]' value=''/>";
	myTable +="<tr class='text_tr' bgcolor="+tableColor+"><td align='center' style='font-weight:bold;'>SNo.</td><td align='center' style='font-weight:bold;'>GRN No.</td><td align='center' style='font-weight:bold;'>GRN Date</td><td align='center' style='font-weight:bold;'>Book No.</td><td align='center' style='font-weight:bold;'>Form Type</td><td align='center'></td></tr>";
	myTable += "<tr class='text_tr' bgcolor="+tableColor+">";
	myTable += "<td align='center'><input name='sno[]' type='text'  value="+(num)+" readonly='readonly' style='height:20px;width:50px;' /></td>";
	myTable += "<td align='center'><input type='text' name='GRN_no[]' id='GRN_no[]' style='height:20px;'/></td>";
	myTable += "<td align='center'><input type='text' name='GRN_date[]' id='GRN_date_"+num+"' style='height:20px;' /><a href=\"javascript:;\" onClick=gfPop.fPopCalendar(document.frm_add.GRN_date_"+num+");return false;' HIDEFOCUS><img name='popcal' align='absbottom' src='./calendar/calbtn.gif' width='34' height='22' border='0' alt=''></a></td>";
	myTable += "<td align='center'><input type='text' name='book_no[]' id='book_no[]' style='height:20px;'/></td>";
	myTable += "<td align='center'><input type='text' name='form_type[]' id='form_type[]' style='height:20px;'/></td>";
	myTable += "<td class='delete' align='center'><a href=\"javascript:;\" onclick=\"removeElement(\'"+divIdName+"\'\,'"+myDivName+"\')\"><img src='images/delete_icon.jpg' border='0'/></a></td>";                                       
	myTable += "</tr></table>";
	newdiv.innerHTML=myTable;
	ni.appendChild(newdiv);
}
function removeElement(divNum,myDiv) 
{
	var d = document.getElementById(myDiv);
	var olddiv = document.getElementById(divNum);
	d.removeChild(olddiv);
}
</script>
<?
$Page = "store_add_form.php";
$PageTitle = "Add Form";
$PageFor = "Form";
$PageKey = "form_id";
$PageKeyValue = "";
$Message = "";
$form_id = '';$form_number = '';
$supplier_id = '';
$GRN_no = '';
$GRN_date = '';
$book_no = '';
$form_type = '';
$form_no = '';$form_date = '';
if(date('m') > 03){	$gFinYear = date('Y').'-'.(date('Y')+1);	}else{	$gFinYear = (date('Y')-1).'-'.date('Y');	}
$mode = "";
if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
}
if(isset($_POST["btn_delete"]))
{
	$PageKeyValueTrans  = $_POST["hidden_overlay"];
	$PageKeyValue = $_POST["hidden_overlay_master"];
	$sql = "delete from ms_form_transaction where form_transaction_id = '".$PageKeyValueTrans."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$Message = "Item Transaction Row Sucessfully Deleted";
	$UrlPage=$Page."?".$PageKey."=".$PageKeyValue."&mode=edit";
	redirect("$UrlPage");//redirect("$Page?Message=$Message");
}

if(isset($_POST["btn_submit"]))
{
	$PageKeyValue = $_POST[$PageKey];
	$supplier_id = $_POST['supplier_id'];	$form_number = $_POST['form_number'];
	if($_POST['form_date']=='' or $_POST['form_date']=='00-00-0000')
		$form_date =date('Y-m-d');
	else
		$form_date = getDateFormate($_POST['form_date']);
	$form_no = $_POST['form_no'];
	if($form_date=='')
		$form_date=date('Y-m-d');
	if($PageKeyValue == "")
	{
		$tableName="ms_form_master";
		$tableData=array("''","'$form_number'","'$form_date'","'$form_no'","'$supplier_id'","now()","'$gFinYear'");
		addDataIntoTable($tableName,$tableData);
		$insert_id = mysql_insert_id();
		if(isset($_POST['GRN_no'])){$count=count($_POST['GRN_no']);}
		for($i=0; $i<$count; $i++)
		{
			if($_POST['GRN_no'][$i]!="" && $_POST['GRN_no'][$i]!=0)
			{
				$GRN_no=$_POST['GRN_no'][$i];
				$GRN_date=getDateFormate($_POST['GRN_date'][$i]);
				$book_no=$_POST['book_no'][$i];
				$form_type=$_POST['form_type'][$i];
				$tableName="ms_form_transaction";
				$tableData=array("''","'$insert_id'","'$GRN_no'","'$GRN_date'","'$book_no'","'$form_type'","now()","'$gFinYear'");
				addDataIntoTable($tableName,$tableData);
				$Message = "$PageFor Inserted";
			}
		}	
		//$Message = "$PageFor Inserted";
		redirect("$Page?Message=$Message");
	}	
	else
	{
		if($mode == "edit")
		{
			$tableName="ms_form_master";
			$tableColumns=array("form_id","form_number","form_date","form_no","supplier_id");
			$tableData=array("'$PageKeyValue'","'$form_number'","'$form_date'","'$form_no'","'$supplier_id'");
			updateDataIntoTable($tableName,$tableColumns,$tableData);
			for($i=0; $i<sizeof($_POST['GRN_no']); $i++)
			{
				if($_POST['GRN_no'][$i]!="" && $_POST['GRN_no'][$i]!=0)
				{
					$form_transaction_id=$_POST['form_transaction_id'][$i];	
					$GRN_no=$_POST['GRN_no'][$i];
					$GRN_date=getDateFormate($_POST['GRN_date'][$i]);
					$book_no=$_POST['book_no'][$i];
					$form_type=$_POST['form_type'][$i];
					if($form_transaction_id!="")
					{
						$tableName="ms_form_transaction";
						$tableColumns=array("form_transaction_id","form_id","GRN_no","GRN_date","book_no","form_type");
						$tableData=array("'$form_transaction_id'","'$PageKeyValue'","'$GRN_no'","'$GRN_date'","'$book_no'","'$form_type'");
						updateDataIntoTable($tableName,$tableColumns,$tableData);
					}
					else
					{
						$tableName="ms_form_transaction";
						$tableData=array("''","'$PageKeyValue'","'$GRN_no'","'$GRN_date'","'$book_no'","'$form_type'","'$form_no'","now()");
						addDataIntoTable($tableName,$tableData);
					}
					$Message = "$PageFor Updated";
				}
			}	
			redirect("store_list_form.php");
		}
	}
}
if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_form_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$supplier_id = $row["supplier_id"];
		$form_date = getDateFormate($row["form_date"]);			
		$form_no = $row["form_no"];	
	}
}
?>
<?
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}
if(isset($_GET["form_id"]))
{
	$form_id = $_GET["form_id"];
}
else
{
	$sql="select max(form_id) as form_id from ms_form_master";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$form_id=($row['form_id']+1);
	
	$sqlf="select finYear from ms_form_master where form_id = '".$row['form_id']."'";
	$resf=mysql_query($sqlf);
	$rowf=mysql_fetch_array($resf);
	if($rowf['finYear'] != $gFinYear){
		$form_number =1;
	}else{
		$sqlfy="select max(form_number) as form_number from ms_form_master where finYear = '".$gFinYear."'";
		$resfy=mysql_query($sqlfy);
		$rowfy=mysql_fetch_array($resfy);
		$form_number=($rowfy['form_number']+1);
	}

}

?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
    	<? include ("inc/store_snb.php"); ?>
    </td>
  	<td style="padding-left:5px; padding-top:5px;"  valign="top">
      <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
        <tr>
        	<td align="center" class="gray_bg">
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add Form
          </td>
        </tr>
        <tr>
          <td valign="top" style="padding-top:10px;">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
              	<td class="red"><?=$Message?></td>
              </tr>
              <tr>
                <td valign="top" style="padding-bottom:5px;">
                  <form name="frm_add" id="frm_additem" action="" method="post">
                    <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                      <tr>
                        <td align="center" valign="top" class="border" width="34%" bgcolor="#EAE3E1">
                          <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                            <tr>
                              <td align="left"><b>Form No.</b></td>
                              <td align="left">
                              	<input type="text" name="form_number" id="form_number" readonly="readonly" value="<?=$form_number?>"  />
                              	<input type="hidden" name="form_id" id="form_id" readonly="readonly" value="<?=$form_id?>"  />
                              </td>
                              <td align="left"><b>Form Date.</b></td>
                              <td align="left">
                              	<input type="text" name="form_date" id="form_date" value="<?=$form_date?>" />
                                <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.form_date);return false;" HIDEFOCUS>
                              		<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                                </a>
                              </td>
                            </tr>      
                            <tr>
                              <td align="left"><b>Form No.</b></td>
                              <td align="left">
                              	<input type="text" name="form_no" id="form_no" value="<?=$form_no?>" />
                              </td>
                              <td align="left"><b>Supplier Name</b></td>
                              <td align="left">
                                <select name='supplier_id' id='supplier_id' style='width:160px;height:20px;'>
                                  <option value='0'></option>
                                  <?  $sql_sup="select * from ms_supplier order by name asc";
                                  $res_sup=mysql_query($sql_sup) or die(mysql_error()); 
                                  while ($row_sup=mysql_fetch_array($res_sup))
                                  {
                                  ?>
                                  <option value="<?=$row_sup['supplier_id']?>" <? if($supplier_id==$row_sup['supplier_id']){ ?> selected="selected" <? } ?>><?=$row_sup['name']?></option>
                                  <?  } ?>
                                </select>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div id="myDataBaseDiv">
														<?
                            $sql_form_trans="SELECT * FROM ms_form_master mim, ms_form_transaction mit WHERE mim.form_id = mit.form_id AND mit.form_id ='".$PageKeyValue."'";
                            $res_form_trans=mysql_query($sql_form_trans) or die(mysql_error());
                            $countTrans=1;
                            $rc_trans=mysql_num_rows($res_form_trans);
                            if($rc_trans>0)
                            {
                            while($row_i_t=mysql_fetch_array($res_form_trans))
                            {
                            if($countTrans%2==0)
                            $tableColor="#eedfdc";
                            else
                            $tableColor="#f8f1ef";
                            ?>
                            <div id="myDiv_<?=$countTrans?>">
                              <table width="100%" border="0" cellspacing="1" cellpadding="1" class="border">
                              <tr bgcolor="#eedfdc" class="text_tr">
                              <td align="center"><b>SNo.</b></b></td>
                              <td align="center"><b>GRN No.</b></td>
                              <td align="center"><b>GRN Date</b></td>
                              <td align="center"><b>Book No.</b></td>
                              <td align="center"><b>Form Type</b></td>
                              <td align="center"></td>
                              </tr>
                              <tr class="text_tr" bgcolor="<?=$tableColor?>">
                              <input type="hidden" name="form_transaction_id[]" id="form_transaction_id[]" value="<?= $row_i_t['form_transaction_id']?>"/>
                              
                              <td align="center">
                              	<input type="text" name="sno[]" id="sno[]" readonly="readonly" value="<?= $countTrans?>" style="height:20px; width:50px;"/>
                              </td>
                              <td align="center">
                              	<input type="text" name="GRN_no[]" id="GRN_no[]" value="<?= $row_i_t['GRN_no']?>" style="height:20px;"/>
                              </td>
                              <td align="center">
                              	<input type="text" name="GRN_date[]" id="GRN_date_<?=$countTrans?>" value="<?= getDateFormate($row_i_t['GRN_date'])?>"  style="height:20px;"/>
                                <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.GRN_date_<?=$countTrans?>);return false;" HIDEFOCUS>
                                <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a>
                              </td>
                              <td align="center">
                              	<input type="text" name="book_no[]" id="book_no[]" value="<?= $row_i_t['book_no']?>" style="height:20px;" />
                              </td>
                              <td align="center">
                              	<input type="text" name="form_type[]" id="form_type[]" value="<?= $row_i_t['form_type']?>"  style="height:20px;"/>
                              </td>
                              <td class='delete'>
                              <a href="javascript:;" onClick="overlay(<?= $PageKeyValue?>,<?= $row_i_t['form_transaction_id'] ?>);">
                              <img src="images/delete_icon.jpg" border="0"/></a>
                              </td>
                              </tr>
                              </table>
                            </div>
                            <?			
                            $countTrans++; 													 
                            } // end of while
                            }// end if	
                            ?>
                          </div>
                          <table width="100%" border="0" cellspacing="1" cellpadding="1" class="border">
                          <input type="hidden" name="form_transaction_id[]" id="form_transaction_id[]" value=""/>
                            <tr class="text_tr" bgcolor="#f0e6e4"> 
                              <td align="center"><b>SNo.</b></td>
                              <td align="center"><b>GRN No.</b></td>
                              <td align="center"><b>GRN Date</b></td>
                              <td align="center"><b>Book  No.</b></td>
                              <td align="center"><b>Form Type</b></td>
                              <td align="center"></td>
                            </tr>
                            <tr class="text_tr" bgcolor="#f0e6e4">
                            <td align="center">
                           		<input type="text" name="sno[]" id="sno[]" readonly="readonly" value="<?=$countTrans ?>" style="height:20px; width:50px;" />
                            </td>
                            <td align="center">
                            	<input type="text" name="GRN_no[]" id="GRN_no[]" style="height:20px;" />
                            </td>
                            <td align="center">
                            	<input type="text" name="GRN_date[]" id="GRN_date_<?=$countTrans?>" style="height:20px;"/>
                              <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.GRN_date_<?=$countTrans?>);return false;" HIDEFOCUS>
                              <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                              </a>
                            </td>
                            <td align="center">
                            	<input type="text" name="book_no[]" id="book_no[]"  style="height:20px;" />
                            </td>
                            <td align="center">
                            	<input type="text" name="form_type[]" id="form_type[]"  style="height:20px;" />
                            </td>
                            <td class="AddMore" align="center">
                              <input type="hidden" name="h_hidden" id="h_hidden" value="<?= $countTrans ?>"/>
                              <a href="javascript:;" onClick="addElement();" title="Add More Rows">
                              <img src="images/add_icon.jpg" alt="Add" border="0" align="absmiddle"/>
                             	</a>
                            </td>
                            </tr>
                            <tr>
                            <td colspan="6" align="center">
                            <div id="myDiv1"></div>
                            </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td align="center" bgcolor="#EAE3E1">
                          <input type="hidden" id="mode" name="mode" value="<?=$mode?>"/>
                          <input type="hidden" id="<?=$PageKey?>" name="<?=$PageKey?>" value="<?=$PageKeyValue?>" />
                          <input type="submit" id="btn_submit" name="btn_submit" value="Save" class="btn_bg" />
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
    </td>
  </tr>
</table>
<div id="overlay">
	<div>
    <p class="form_msg">Are you sure to delete this Record</p>
		<form name="frm_del" action="<?=$_SERVER['PHP_SELF']?>" method="post">
      <input type="hidden" name="hidden_overlay_master" id="hidden_overlay_master" value="" />
      <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
      <input type="submit" class="submit" name="btn_delete" id="btn_delete" value="Yes" />
      <input type="button" class="submit" onClick="overlay();" name="btn_close" id="btn_close" value="No" />
		</form>
	</div>
</div>
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>                                        
<? 
include("inc/hr_footer.php");
?>