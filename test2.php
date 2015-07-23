<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
body{
	background-repeat:no-repeat;
	font-family: Trebuchet MS, Lucida Sans Unicode, Arial, sans-serif;
	height:100%;
	background-color: #FFF;
	margin:0px;
	padding:0px;
}
select{
	width:150px;
}
</style>
<script type="text/javascript" src="ajax.js"></script>
<script type="text/javascript">
/************************************************************************************************************
Ajax chained select
Copyright (C) 2006  DTHMLGoodies.com, Alf Magne Kalleland

This library is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 2.1 of the License, or (at your option) any later version.

This library is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public
License along with this library; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA

Dhtmlgoodies.com., hereby disclaims all copyright interest in this script
written by Alf Magne Kalleland.

Alf Magne Kalleland, 2006
Owner of DHTMLgoodies.com


************************************************************************************************************/	
var ajax = new Array();

/*function getCityList(sel)
{
	var countryCode = sel.options[sel.selectedIndex].value;
	document.getElementById('dhtmlgoodies_city').options.length = 0;	// Empty city select box
	if(countryCode.length>0){
		var index = ajax.length;
		ajax[index] = new sack();
		
		ajax[index].requestFile = 'getCities.php?countryCode='+countryCode;	// Specifying which file to get
		ajax[index].onCompletion = function(){ createCities(index) };	// Specify function that will be executed after file has been found
		ajax[index].runAJAX();		// Execute AJAX function
	}
}

function createCities(index)
{
	var obj = document.getElementById('dhtmlgoodies_city');
	eval(ajax[index].response);	// Executing the response from Ajax as Javascript code	
}
*/

function getSubCategoryList(sel,child_sel,file_name)
{
	
	var category = sel.value;
	alert(category);
	document.getElementById(child_sel).options.length = 0;	// Empty city select box
	if(category.length>0){
		var index = ajax.length;
		ajax[index] = new sack();
		
		ajax[index].requestFile = file_name + '?var='+category;	// Specifying which file to get
		ajax[index].onCompletion = function(){ createSubCategories(index,child_sel) };	// Specify function that will be executed after file has been found
		ajax[index].runAJAX();		// Execute AJAX function
	}
}
function createSubCategories(index,child_sel)
{
	var obj = document.getElementById(child_sel);
	eval(ajax[index].response);	// Executing the response from Ajax as Javascript code	
}		
</script>

</head>

<body>
<form action="" method="post">
<table>
	<tr>
		<td>Country: </td>
		<td><select id="dhtmlgoodies_country" name="dhtmlgoodies_country" onchange="getSubCategoryList(this,'dhtmlgoodies_city','getCities.php');getSubCategoryList(0	,'dhtmlgoodies_subcategory','getSubCategories.php')">
			<option value="">Select a country</option>
			<option value="dk">Denmark</option>
			<option value="no">Norway</option>
			<option value="us">US</option>
		</select>
		</td>
	</tr>
	<tr>
		<td>City: </td>
		<td>
        <select id="dhtmlgoodies_city" name="dhtmlgoodies_city" onchange="getSubCategoryList(this,'dhtmlgoodies_subcategory','getSubCategories.php')">
		
		</select>
		</td>
	</tr>
	
	<tr>
		<td>Sub category: </td>
		<td><select id="dhtmlgoodies_subcategory" name="dhtmlgoodies_subcategory">
		
		</select>
		</td>
	</tr>
</table>
</form>

</body>
</html>
