<script type="text/javascript" src="javascript/jquery.min.js"></script>
<script type="text/javascript" src="javascript/ddaccordion.js">

/***********************************************
* Accordion Content script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* Visit http://www.dynamicDrive.com for hundreds of DHTML scripts
* This notice must stay intact for legal use
***********************************************/

</script>

<style type="text/css">
.categoryitems{display: none}
</style>
<script type="text/javascript">


ddaccordion.init({
	headerclass: "expandable", //Shared CSS class name of headers group that are expandable
	contentclass: "categoryitems", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [], //index of content(s) open by default [index1, index2, etc]. [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: false, //persist state of opened contents within browser session?
	toggleclass: ["", "openheader"], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["prefix", "", ""], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})


</script>
<?
	$year =date("Y");
?>
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr>
    	<td align="left" style="padding-top:5px;" colspan="2">
        	<table cellpadding="0" cellspacing="0" border="0" align="left" class="loginbg" width="98%">
                <tr>
                    <td width="12%" class="text_1" style="padding-left:15px;">Employee List<span class="red">*</span></td>
                    <td width="3%" align="left"><img src="images/tnb_div_1.jpg" width="7" height="35"/></td>
                    <td width="13%">
                   		 <input type="text" id="emp_search" name="emp_search" onkeydown="if(event.keyCode && event.keyCode == 13){get_frm_menu('employee_list_leave_wages.php',this.value,'emp_list','');}" value=""/>
                    </td>
                    <td class="text_1" style="padding-top:5px;">
						<form name="frm_check" id="frm_check">
                        <input type="radio" id="search_by" name="search_by" value="ID" checked="checked" onclick="get_frm_menu('employee_list.php',document.getElementById('emp_search').value,'emp_list','')" />ID
                       		 <input type="radio" id="search_by" name="search_by"  value="Name" onclick="get_frm_menu('employee_list.php',document.getElementById('emp_search').value,'emp_list','')"/>Name
                            
                        </form>
                    </td>
                    <td align="center" class="text_1"><b>Year</b></td>
                    <td align="center">
                   <?    
                        $sql_prd = "select max(date)as MAXDATE,min(date)as MINDATE from ".$mysql_table_prefix."attendence_master ";
                        $result_prd = mysql_query ($sql_prd) or die ("Error in : ".$sql_prd."<br>".mysql_errno()." : ".mysql_error());												
                        $row_prd = mysql_fetch_array($result_prd);	
                         $min_year=substr($row_prd["MINDATE"],0,4);
                         $max_year=substr($row_prd["MAXDATE"],0,4);
                        ?>    
                            <select name="year" id="year" style="width:150px; height:25px;" onchange="get_frm('get_month.php',this.value,'div_month','');">
                                <option value="">--select--</option>
                                
                            <? 
                          for($i=$min_year;$i<=$max_year;$i++)
                            {
                            ?>
                                <option value="<?=$i?>" <? if($i==$year)  { echo 'selected="selected"';}?>><?=$i?>
                                </option>
                            <?
                            }
                            ?>
                            </select>         						
                    </td>
              </tr>
            </table>
        </td>
    </tr>
    
    <tr>
        <td align="left" class="menuLink" style="border-right:1px solid #CCCCCC; border-left:1px solid #CCCCCC; padding-top:1px;" width="200px" valign="top">
            <div id="emp_list" style="overflow:scroll;height:300px;">
				<?
                $sql_digital = "select * from ".$mysql_table_prefix."employee_master order by first_name";
                $result_digital = mysql_query($sql_digital) or die("Error in Query:".$sql_digital."<br>".mysql_errno().":".mysql_error());
                if(mysql_num_rows($result_digital)>0)	
                {
                while($row_emp=mysql_fetch_array($result_digital))
                {
                ?>
            <div class="emp_snb expandable"><?=$row_emp['first_name']?>&nbsp;<?=$row_emp['last_name']?></div>
            <div class="categoryitems subLinks" style="height:auto;">
            
            <div class="snb_sublink"><img src="images/red_bullet.png"/>
            <a href="javascript:;" onclick="get_frm('register_leave.php','<?=$row_emp['rec_id']?>','div_detail',document.getElementById('year').value)">Leave Wages</a></div>
            </div>
				<?
                }
                }
                ?>
            </div>
        </td>
        <td align="left" style="padding-left:5px;" valign="top"><div id="div_detail"></div></td>
    </tr>   
</table>
                
                