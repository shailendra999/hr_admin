<?
include("inc/maint_header.php");
?>
<style>
.getDataInDiv{
	background:#fff;
	border:1px solid #96A2BC;
	overflow:hidden;
}
</style>
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
	var myTable= "<table align='center' width='100%' cellpadding='1' cellspacing='1' class='border' border='0'>";
	myTable+= "<tr bgcolor="+tableColor+" class='text_tr'>";
	myTable+= "<td align='center' style='font-weight:bold;'>SNo.</td><td align='center' style='font-weight:bold;'>Service</td><td align='center' style='font-weight:bold;'>Duration</td><td align='center' style='font-weight:bold;'>Duration Type.</td><td align='center' style='font-weight:bold;'>Maint. Date</td><td align='center'>&nbsp;</td></tr>";
	myTable+= "<input type='hidden' name='machine_transaction_id[]' id='machine_transaction_id[]' value=''/>";
	myTable+= "<tr bgcolor="+tableColor+" class='text_tr'>";
	myTable+= "<td align='center'><input type='text' name='sno[]' id='sno[]' readonly='readonly' value='"+num+"' style='height:20px; width:50px;' /></td>";
	myTable+= "<td align='center'><select id='service_id[]' name='service_id[]' onChange=\"getServiceDetails(this.value,'div_duration_"+num+"','div_duration_type_"+num+"','"+num+"')\"style=' height:20px;width:160px'><option value='0'></option><?	$sql_S='select * from maint_services order by name asc';$res_S=mysql_query($sql_S) or die(mysql_error());if(mysql_num_rows($res_S)>0){while($row_S=mysql_fetch_array($res_S)){?><option value='<?=$row_S['s_code']?>'><?=$row_S['name']?></option><?	}	}	?></select></td>";
	myTable+= "<td align='center'><div id='div_duration_"+num+"' style='height:18px;width:80px;' class='getDataInDiv'></div></td>";
	myTable+= "<td align='center'><div id='div_duration_type_"+num+"' style='height:18px;width:80px;' class='getDataInDiv'></div></td>";
	myTable+= "<td align='center'><input type='text' name='maint_date[]' id='maint_date_"+num+"' style='height:20px;width:100px'/>	<a href='javascript:void(0)' onClick='gfPop.fPopCalendar(document.frm_add.maint_date_"+num+");return false;' HIDEFOCUS><img name='popcal' align='absbottom' src='./calendar/calbtn.gif' width='34' height='22' border='0' alt=''></a></td>";
	myTable += "<td class='delete'><a href=\"javascript:;\" onclick=\"removeElement(\'"+divIdName+"\'\,'"+myDivName+"\')\"><img src='images/delete_icon.jpg' border='0'/></a></td>";
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
<script type="text/javascript">
	function getServiceDetails(id, divDuration,divDurationType,idNo)
	{
		var strURL1="maint_get_duration.php?id="+id+"&id_no="+idNo;
		var strURL2="maint_get_duration_type.php?id="+id+"&id_no="+idNo;
		var req = getXMLHTTP();
		var req1 = getXMLHTTP();

		if (req)
		{																					
				req.onreadystatechange = function() {
						if (req.readyState == 4) {
								if (req.status == 200)                         
										document.getElementById(divDuration).innerHTML=req.responseText;
								 else 
										alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}                
				}            
				req.open("GET", strURL1, true);
				req.send(null);
		}
		if(req1)
		{
				req1.onreadystatechange = function() {
						if (req1.readyState == 4) {
								if (req1.status == 200)                        
										document.getElementById(divDurationType).innerHTML=req1.responseText;
								 else 
										alert("There was a problem while using XMLHTTP:\n" + req1.statusText);
						}                
				}            
				req1.open("GET", strURL2, true);
				req1.send(null);
		}
		
	}																	
</script>
<?
$Page = "maint_add_machines.php";
$PageTitle = "Add Machine";
$PageFor = "Machine";
$PageKey = "machine_code";
$PageKeyValue = "";
$Message = "";
$mode = "";
$MachineId="";
$machine_code='';$name='';$department_id='';$model='';$errected_by='';$machine_serial_no='';$make_machine='';
$machine_price='';$manufacture_year='';$install_date='';$commissioning_date='';
if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
	$sql_idate="select * from maint_machine_master where insert_date='".date('Y-m-d')."' and machine_code='".$_GET[$PageKey]."'";
	$res_idate=mysql_query($sql_idate);
	if(mysql_num_rows($res_idate)==0 && !($SessionUserType=='Administrator'))
	{
		echo "<script>alert('You Cant Update Here');location.href='maint_homepage.php';</script>";
	}
}

if(isset($_GET[$PageKey]))
{
	$sql = "select * from maint_machine_master where machine_code = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		
		
		if(isset($_GET["mode"]) and $_GET["mode"]=='new')
		{
			$sql_new="select max(machine_code) as machine_code from maint_machine_master";
			$res_new=mysql_query($sql_new);
			$row_new=mysql_fetch_array($res_new);
			$m_code=($row_new['machine_code']+1);
			
			$sql_new="select count(machine_code) as machine_code from maint_machine_master";
			$res_new=mysql_query($sql_new);
			$row_new=mysql_fetch_array($res_new);
			$machine_code=($row_new['machine_code']+1);
			
			$MachineId = $row['machine_code'];
			$PageKeyValue = "";
			$name ="";
			$department_id = $row['department_code'];
			$model = "";
			$errected_by = "";
			$machine_serial_no ="";
			$make_machine = "";
			$machine_price = "";	
			$manufacture_year = "";
			$install_date = "";
			$commissioning_date = "";
		}
		else
		{
			$machine_code = $row["machine_code"];
			$MachineId = $row["machine_code"];
			$PageKeyValue = $row["machine_code"];
			$name = $row['name'];
			$department_id = $row['department_code'];
			$model = $row['model'];
			$errected_by = $row['errected_by'];
			$machine_serial_no = $row['machine_serial_no'];
			$make_machine = $row["make_machine"];
			$machine_price = $row['machine_price'];	
			$manufacture_year = $row['manufacture_year'];
			$install_date = getDateFormate($row['install_date']);
			$commissioning_date = getDateFormate($row['commissioning_date']);
		}	
		
		
				
	}
}
else if(!isset($_GET[$PageKey]))
{
	$sql="select max(machine_code) as machine_code from maint_machine_master";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$m_code=($row['machine_code']+1);
	
	$sql="select count(machine_code) as machine_code from maint_machine_master";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$machine_code=($row['machine_code']+1);
}
if(isset($_POST["btn_delete"]))
{
	$PageKeyValueTrans  = $_POST["hidden_overlay"];
	$PageKeyValue = $_POST["hidden_overlay_master"];
	$sql = "delete from maint_machine_transaction where machine_transaction_id = '".$PageKeyValueTrans."'";
	$sql1 = "delete from maint_job where machine_transaction_id = '".$PageKeyValueTrans."' and machine_code='".$PageKeyValue."'";
	if(mysql_query ($sql))
	{
		if(mysql_query ($sql1))
			$Message = "Record Sucessfully Deleted";
	}
	$UrlPage=$Page."?".$PageKey."=".$PageKeyValue."&mode=edit";
	redirect("$UrlPage");//redirect("$Page?Message=$Message");
}

if(isset($_POST["btn_submit"]))
{
	$PageKeyValue = $_POST[$PageKey];
	$machine_code = $_POST["machine_code"];
	$name = $_POST['name'];
	$department_id = $_POST['department_id'];
	$model = $_POST['model'];
	$errected_by = $_POST['errected_by'];
	$machine_serial_no = $_POST['machine_serial_no'];
	$make_machine = $_POST["make_machine"];
	$machine_price = $_POST['machine_price'];	
	$manufacture_year = $_POST['manufacture_year'];
	$install_date = getDateFormate($_POST['install_date']);
	$commissioning_date = getDateFormate($_POST['commissioning_date']);
	
	if($PageKeyValue == "")
	{
		$tableName="maint_machine_master";
		
		$tableData=array("''","'$m_code'","'$name'","'$department_id'","'$model'","'$errected_by'","'$machine_serial_no'","'$make_machine'","'$machine_price'","'$manufacture_year'","'$install_date'","'$commissioning_date'","now()");
		//print_r($tableData);
		addDataIntoTable($tableName,$tableData);
		$insert_id = mysql_insert_id();
		if(isset($_POST['service_id'])){$count=count($_POST['service_id']);}
		for($i=0; $i<$count; $i++)
		{
				if($_POST['service_id'][$i]!="0")
				{
					$service_id=$_POST['service_id'][$i];	
					$d='duration_'.($i+1);
					$dt='duration_type_'.($i+1);
					$duration=$_POST[$d];
					$duration_type=$_POST[$dt];
					if($_POST['maint_date'][$i]=='')
						$maint_date=date("Y-m-d");
					else
						$maint_date=getDateFormate($_POST['maint_date'][$i]);
					$da=explode('-',$maint_date);//$da=explode('-','2011-03-01');
					$sch_date='';
					if($duration_type=="Month(s)")
						$sch_date= date("Y-m-d", mktime(0, 0, 0,$da[1]+$duration ,$da[2] , $da[0]));
					if($duration_type=="Day(s)")
						$sch_date= date("Y-m-d", mktime(0, 0, 0,$da[1] ,$da[2]+$duration , $da[0]));
						
					$tableName="maint_machine_transaction";
					$tableData=array("''","'$m_code'","'$service_id'","'$maint_date'","'$sch_date'","now()");
					//print_r($tableData);
					addDataIntoTable($tableName,$tableData);
					$machine_tr_id=mysql_insert_id();
					$res_j=mysql_query("select max(job_code) as job_code from maint_job");
					$row_j=mysql_fetch_array($res_j);
					$jc=$row_j['job_code']+1;
					//echo $sch_date;
					$tableDataJob=array("''","'$jc'","'$service_id'","'$m_code'","'P'","'$sch_date'","'$maint_date'","''","''","now()");
					addDataIntoTable("maint_job",$tableDataJob);
					$Message = "$PageFor Inserted";
				}
		}	
		$Message = "$PageFor Inserted";
		//redirect("$Page?Message=$Message");
	}	
	else
	{
		if($mode == "edit")
		{
			$tableName="maint_machine_master";
			$machine_code= $_POST['machine_code'];
			$tableColumns=array("machine_code","name","department_code","model","errected_by","machine_serial_no","make_machine","machine_price","manufacture_year","install_date","commissioning_date");
			
			$tableData=array("'$PageKeyValue'","'$name'","'$department_id'","'$model'","'$errected_by'","'$machine_serial_no'","'$make_machine'","'$machine_price'","'$manufacture_year'","'$install_date'","'$commissioning_date'");
			//print_r($tableData);
			updateDataIntoTable($tableName,$tableColumns,$tableData);
			
			if(isset($_POST['service_id'])){$count=count($_POST['service_id']);}
		
			for($i=0; $i<$count; $i++)
			{
				if($_POST['service_id'][$i]!="0")
				{
					$machine_transaction_id=$_POST['machine_transaction_id'][$i];
					$service_id=$_POST['service_id'][$i];	
					$d='duration_'.($i+1);
					$dt='duration_type_'.($i+1);
					$duration=$_POST[$d];
					$duration_type=$_POST[$dt];
					if($_POST['maint_date'][$i]=='' or $_POST['maint_date'][$i]=='00-00-0000')
						$maint_date=date('Y-m-d');
					else
						$maint_date=getDateFormate($_POST['maint_date'][$i]);
					$da=explode('-',$maint_date);//$da=explode('-','2011-03-01');
					$sch_date='';
					if($duration_type=="Month(s)")
						$sch_date= date("Y-m-d", mktime(0, 0, 0,$da[1]+$duration ,$da[2] , $da[0]));
					if($duration_type=="Day(s)")
						$sch_date= date("Y-m-d", mktime(0, 0, 0,$da[1] ,$da[2]+$duration , $da[0]));
						
					$tableName="maint_machine_transaction";
					if($machine_transaction_id=="")
					{
						
						$tableData=array("''","'$PageKeyValue'","'$service_id'","'$maint_date'","'$sch_date'","now()");
						//print_r($tableData);
						addDataIntoTable($tableName,$tableData);
						$machine_tr_id=mysql_insert_id();
						$res_j=mysql_query("select max(job_code) as job_code from maint_job");
						$row_j=mysql_fetch_array($res_j);
						$jc=$row_j['job_code']+1;
						//echo $jc." : ".$service_id." : ".$PageKeyValue." : ".$sch_date." : ".$maint_date."<br>";;
						$tableDataJob=array("''","'$jc'","'$service_id'","'$PageKeyValue'","'P'","'$sch_date'","'$maint_date'","''","''","now()");
						addDataIntoTable("maint_job",$tableDataJob);
					}
					else
					{
						//$machine_transaction_id.'<br />';
						
						$tableData=array("''","'$PageKeyValue'","'$service_id'","'$maint_date'","'$sch_date'","now()");
						//print_r($tableData);
						$tableColumns=array("machine_transaction_id","machine_id","service_id","maint_date","schedule_date");
						$tableData=array("'$machine_transaction_id'","'$machine_code'","'$service_id'","'$maint_date'","'$sch_date'");
						updateDataIntoTable($tableName,$tableColumns,$tableData);
					
						$job_id=$_POST['job_id'][$i];
						$tableColumns=array("job_id","service_id","machine_id","schedule_date","maint_date");
						//echo $jc." : ".$service_id." : ".$PageKeyValue." : ".$sch_date." : ".$maint_date."<br>";;
						$tableDataJob=array("'$job_id'","'$service_id'","'$machine_code'","'$sch_date'","'$maint_date'");
						updateDataIntoTable("maint_job",$tableColumns,$tableDataJob);
					}
					$Message = "$PageFor Updated";
				}
			}	
			$Message = "$PageFor Updated";
			//redirect("maint_list_machines.php?Message=$Message");
		}
	}
}
?>
<?
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}

?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
	<tr>
		<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/maint_snb.php"); ?>
		</td>
		<td style="padding-left:5px; padding-top:5px;" valign="top">
			<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
        <tr>
          <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add/Edit Machine</td>
        </tr>
        <tr>
          <td valign="top" style="padding-top:10px;">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td class="red"><?=$Message?></td>
              </tr>
              <tr>
                <td valign="top" style="padding-bottom:5px;">
                  <form name="frm_add" id="frm_add" action="" method="post">
                  <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                    <tr>
                      <td align="center" valign="top" class="border" width="100%" bgcolor="#EAE3E1">
                        <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                          <tr>
                            <td align="left"><b>Machine No</b></td>
                            <td align="left" colspan="3">
                              <input type="text" readonly="readonly" id="machine_code" name="machine_code" value="<?= $machine_code ?>"  />
                            </td>
                          </tr>
                          <tr>
                            <td align="left"><b>Machine Name</b></td>
                            <td align="left">
                              <input type="text" id="name"  name="name" value="<?= $name ?>" />
                            </td>
                            <td align="left"><b>Department</b></td>
                            <td align="left">
                              <?
                              $sql_d= "select * from maint_department order by name asc";
                              $res_d =mysql_query ($sql_d) or die ("Invalid query : ".$sql_d."<br>".mysql_errno()." : ".mysql_error());
                              ?>
                              <select name="department_id" id="department_id" style="width:125px;">
                                <option value="0"></option>
                                <?
                                if(mysql_num_rows($res_d)>0)
                                {
																	while($row_d = mysql_fetch_array($res_d))
																	{
																	?>
																<option value="<?=$row_d['department_code']?>" <? if($row_d['department_code']==$department_id){ ?>selected="selected"<? }?>><?=$row_d['name']?></option>
																	<?
																	}
                                }	
                                ?>
                              </select>
                            </td>
                           </tr>                          
                          <tr>
                            <td align="left"><b>Model</b></td>
                            <td align="left">
	                          	<input type="text" id="model" name="model" value="<?= $model ?>" />
                            </td>
                            <td align="left"><b>Errected By</b></td>
                            <td align="left">
                              <input type="text" id="errected_by" name="errected_by" value="<?= $errected_by ?>" />
                            </td>
                          </tr>
                          <tr>
                            <td align="left"><b>Machine Serial No.</b></td>
                            <td>
                            	<input type="text" id="machine_serial_no" name="machine_serial_no" value="<?= $machine_serial_no ?>" />
                            </td>
                            <td align="left"><b>Make Of Machine</b></td>
                            <td align="left">
                            	<input type="text" id="make_machine" name="make_machine" value="<?= $make_machine ?>" />
                            </td>
                          </tr>
                          <tr>
                            <td align="left"><b>Price Of Machine</b></td>
                            <td align="left">
                            	<input type="text" id="machine_price" name="machine_price" value="<?= $machine_price ?>"  />
                            </td>
                            <td align="left"><b>Manufacture Year</b></td>
                            <td align="left">
                              <input type="text" id="manufacture_year" name="manufacture_year" value="<?= $manufacture_year ?>" />
                            </td>
                          </tr>
                          <tr>
                            <td align="left"><b>Date Of Installation</b></td>
                            <td align="left">
                            	<input type="text" id="install_date" name="install_date" value="<?= $install_date ?>" />
                              <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.install_date);return false;" HIDEFOCUS>
                              <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                              </a>
                            </td>
                            <td align="left"><b>Date Of Commissioning</b></td>
                            <td>
                              <input type="text" id="commissioning_date" name="commissioning_date" value="<?= $commissioning_date ?>" />
                              <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.commissioning_date);return false;" HIDEFOCUS>
                              <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                              </a>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td>
                      <?
											$sql_j="select * from maint_job where machine_id='".$PageKeyValue."'";
											$res_j=mysql_query($sql_j);
											while($row_j=mysql_fetch_array($res_j))
											{
												?>
                        <input type="hidden" name="job_id[]" id="job_id[]" value="<?= $row_j['job_id']?>"/>
                        <?
											}
											?>
                        <div id="myDataBaseDiv">
                        <?
                        $sql_item_trans="SELECT * FROM maint_machine_master mim, maint_machine_transaction mit WHERE mim.machine_code = mit.machine_id AND mit.machine_id ='".$MachineId."'";
                        $res_item_trans=mysql_query($sql_item_trans) or die(mysql_error());
                        $countTrans=1;
                        $rc_trans=mysql_num_rows($res_item_trans);
                        if($rc_trans>0)
                        {
                          while($row_i_t=mysql_fetch_array($res_item_trans))
                          {
                            if($countTrans%2==0)
                            $tableColor="#eedfdc";
                            else
                            $tableColor="#f8f1ef";
                            ?>
                            <div id="myDiv_<?=$countTrans?>">
                              <table width="100%" border="0" cellspacing="1" cellpadding="0" class="border">
																<tr bgcolor="#eedfdc" class="text_tr">
                                  <td align="center" style="font-weight:bold;">SNo.</td>
                                  <td align="center" style="font-weight:bold;">Service</td>
                                  <td align="center" style="font-weight:bold;">Duration</td>
                                  <td align="center" style="font-weight:bold;">Duration Type.</td>
                                  <td align="center" style="font-weight:bold;">Maint. Date</td>
                                  <td align="center">&nbsp;</td>
                                </tr>
                                <tr bgcolor="<?= $tableColor?>">
                                  <input type="hidden" name="machine_transaction_id[]" id="machine_transaction_id[]" value="<?= $row_i_t['machine_transaction_id']?>"/>
                                  <td align="center">
                                    <input type="text" name="sno[]" id="sno[]" readonly="readonly" value="<?= $countTrans?>" style="height:20px;width:50px;"/>
                                  </td>
                                  <td align="center">
                                    <select id="service_id[]" name="service_id[]" style=" height:20px;width:160px" onChange="getServiceDetails(this.value,'div_duration_<?= $countTrans?>','div_duration_type_<?= $countTrans?>','<?=$countTrans?>')">
                                    <option value="0"></option>
                                    <?
                                    $sql_S="select * from maint_services order by name asc";
                                    $res_S=mysql_query($sql_S) or die(mysql_error());
                                    if(mysql_num_rows($res_S)>0)
                                    {
                                    	while($row_S=mysql_fetch_array($res_S))
																			{
																			?>
																				<option value="<?=$row_S['s_code']?>" <? if($row_S['s_code']==$row_i_t['service_id']){?> selected="selected" <? } ?>><?=$row_S['name']?></option>
																			<?
																			}
                                    }
                                    ?>
                                    </select>
                                  </td>
                                  <td align="center">
                                   <? 
																		$id = $row_i_t['service_id'];
																		$sql_D = "SELECT * FROM  maint_services where s_code = '$id' order by name ";
																		$result_D = mysql_query ($sql_D) or die ("Error in : ".$sql_D."<br>".mysql_errno()." : ".mysql_error());
																		$duration='';$duration_type='';
																		if(mysql_num_rows($result_D)>0)
																		{
																			$row_D = mysql_fetch_array($result_D);
																			$duration= $row_D['duration'];
																			$dt= $row_D['duration_type'];
																			if($dt=="M")
																				$duration_type='Month(s)';
																			if($dt=="D")
																				$duration_type='Day(s)';
																		}
																		?>
																		<div id="div_duration_<?= $countTrans?>" style="height:18px;width:80px;" class="getDataInDiv">
																		<input type="hidden" value="<?=$duration?>" id="duration_<?= $countTrans?>" name="duration_<?= $countTrans?>"/>
																		<?=$duration?></div>
                                  </td>
                                  <td align="center">
																		<div id="div_duration_type_<?= $countTrans?>" style="height:18px;width:80px;" class="getDataInDiv">
																			<input type="hidden" value="<?=$duration_type?>" id="duration_type_<?= $countTrans?>" name="duration_type_<?= $countTrans?>"/>
																		<?=$duration_type?></div>
                                  </td>
                                  <td align="center">
                                    <input type="text" name="maint_date[]" id="maint_date_<?=$countTrans?>" value="<?= getDateFormate($row_i_t['maint_date'])?>"  style="height:20px;width:100px"/>
                                    <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.maint_date_<?=$countTrans?>);return false;" HIDEFOCUS>
                                    <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                                    </a> 
                                  </td>
                                  <td class='delete'>
                                    <a href="javascript:;" onClick="overlay(<?= $PageKeyValue?>,<?= $row_i_t['machine_transaction_id'] ?>);">
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
                        <table width="100%" border="0" cellspacing="1" cellpadding="2" class="border">
                          <tr bgcolor="#eedfdc" class="text_tr">
                            <td align="center" style="font-weight:bold;">SNo.</td>
                            <td align="center" style="font-weight:bold;">Service</td>
                            <td align="center" style="font-weight:bold;">Duration</td>
                            <td align="center" style="font-weight:bold;">Duration Type.</td>
                            <td align="center" style="font-weight:bold;">Maint. Date</td>
                            <td align="center">&nbsp;</td>
                          </tr>
                          <input type="hidden" name="machine_transaction_id[]" id="machine_transaction_id[]" value=""/>
                          <tr bgcolor="#eedfdc" class="text_tr">
                            <td align="center">
                              <input type="text" name="sno[]" id="sno[]" readonly="readonly" value="<?=$countTrans ?>" style="height:20px; width:50px;" />
                            </td>
                            <td align="center">
                              <select id="service_id[]" name="service_id[]" style=" height:20px;width:160px" onChange="getServiceDetails(this.value,'div_duration_<?= $countTrans?>','div_duration_type_<?= $countTrans?>','<?=$countTrans?>')">
                                <option value="0"></option>
                                <?
                                $sql_S="select * from maint_services order by name asc";
                                $res_S=mysql_query($sql_S) or die(mysql_error());
                                if(mysql_num_rows($res_S)>0)
                                {
                                  while($row_S=mysql_fetch_array($res_S))
                                  {
                                  ?>
                                    <option value="<?=$row_S['s_code']?>"><?=$row_S['name']?></option>
                                  <?
                                  }
                                }
                                ?>
                                </select>
                            </td>
                            <td align="center">
                            	<div id="div_duration_<?= $countTrans?>" style="height:18px;width:80px;" class="getDataInDiv"></div>
                            </td>
                            <td align="center">
                              <div id="div_duration_type_<?= $countTrans?>" style="height:18px;width:80px;" class="getDataInDiv"></div>
                            </td>
                            <td align="center">
                              <input type="text" name="maint_date[]" id="maint_date_<?=$countTrans?>" style="height:20px;width:100px"/>
                              <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.maint_date_<?=$countTrans?>);return false;" HIDEFOCUS>
                              <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                              </a> 
                            </td>
                            <td class="AddMore" align="center">
                              <input type="hidden" name="h_hidden" id="h_hidden" value="<?= $countTrans ?>"/> 
                              <a href="javascript:;" onClick="addElement();" title="Add More Rows">
                              <img src="images/add_icon.jpg" alt="Add" border="0" align="absmiddle"/></a>
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
                      <td align="center">
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