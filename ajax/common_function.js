get_frm_attendence// JavaScript Document
var divId = "";
var divNo;
var item_id = "";
var item_name = "";
var IsGetDesc = "";
var item_no = "";
var div_item_uom = "";
var div_item_desc = "";
var div_item_stock = "";
var stk_qty = "";
var op_qty = "";
var ClosingStock = "";
var OpeningStock = "";
function getXMLHTTP() { //fuction to return the xml http object
    var xmlhttp = false;
    try {
        xmlhttp = new XMLHttpRequest();
    }
    catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch (e) {
            try {
                xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
            }
            catch (e1) {
                xmlhttp = false;
            }
        }
    }

    return xmlhttp;
}

function get_frm_itemname(itemnameId, divId1, divId2, divId3) {

    var strURL1 = "store_get_itemcode.php?item_name=" + itemnameId;
    var strURL2 = "store_get_itemuom.php?item_name=" + itemnameId;
    var strURL3 = "store_get_department.php?item_name=" + itemnameId;

    var req = getXMLHTTP();
    var req1 = getXMLHTTP();
    var req2 = getXMLHTTP();

    if (req) {

        req.onreadystatechange = function () {
            if (req.readyState == 4) {
                // only if "OK"
                if (req.status == 200) {
                    document.getElementById(divId1).innerHTML = req.responseText;
                    //document.getElementById('itemuom').innerHTML=req.responseText;

                } else {
                    alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                }
            }
        }
        req.open("GET", strURL1, true);
        req.send(null);
    }
    if (req1) {

        req1.onreadystatechange = function () {
            if (req1.readyState == 4) {
                // only if "OK"
                if (req1.status == 200) {
                    //document.getElementById('itemcode').innerHTML=req1.responseText;
                    document.getElementById(divId2).innerHTML = req1.responseText;

                } else {
                    alert("There was a problem while using XMLHTTP:\n" + req1.statusText);
                }
            }
        }
        req1.open("GET", strURL2, true);
        req1.send(null);
    }
    if (req2) {

        req2.onreadystatechange = function () {
            if (req2.readyState == 4) {
                // only if "OK"
                if (req2.status == 200) {
                    document.getElementById(divId3).innerHTML = req2.responseText;
                    //document.getElementById('itemuom').innerHTML=req.responseText;

                } else {
                    alert("There was a problem while using XMLHTTP:\n" + req2.statusText);
                }
            }
        }
        req2.open("GET", strURL3, true);
        req2.send(null);
    }
}

function get_frm_monthly_attn(str, str1, str2, str3) {

    xmlHttp1 = GetXmlHttpObject1();
    if (xmlHttp1 == null)
    {
        alert("Browser does not support HTTP Request")
        return;
    }
    document.getElementById(str2).innerHTML = '<img src="images/ajax_loader.gif" border="0">';

    var url = str;
    url = url + "?id=" + str1 + "&str=" + str3;
    url = url + "&sid=" + Math.random();
    xmlHttp1.onreadystatechange = function ()
    {
        if (xmlHttp1.readyState == 4 || xmlHttp1.readyState == "complete")
        {
            document.getElementById(str2).innerHTML = xmlHttp1.responseText;
        }
    };

    xmlHttp1.open("GET", url, true)
    xmlHttp1.send(null)
}




function get_frm(str, str1, str2, str3)
{
//    alert("U");

    xmlHttp1 = GetXmlHttpObject1();
    if (xmlHttp1 == null)
    {
        alert("Browser does not support HTTP Request")
        return;
    }
    document.getElementById(str2).innerHTML = '<img src="images/ajax_loader.gif" border="0">';

    var url = str;
    url = url + "?id=" + str1 + "&str=" + str3;
    url = url + "&sid=" + Math.random();
    xmlHttp1.onreadystatechange = function ()
    {
        if (xmlHttp1.readyState == 4 || xmlHttp1.readyState == "complete")
        {
            document.getElementById(str2).innerHTML = xmlHttp1.responseText;
        }
    };

    xmlHttp1.open("GET", url, true)
    xmlHttp1.send(null)
}

function GetXmlHttpObject1()
{
    var objXMLHttp1 = null
    if (window.XMLHttpRequest)
    {
        objXMLHttp1 = new XMLHttpRequest()
    }
    else if (window.ActiveXObject)
    {
        objXMLHttp1 = new ActiveXObject("Microsoft.XMLHTTP")
    }
    return objXMLHttp1
}
var xmlHttp1 = GetXmlHttpObject1();
function get_frm_state(str, str1, str2, str3, str4, str5, str6, str7)
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request")
        return
    }
    document.getElementById(str2).innerHTML = '<img src="images/ajax_loader.gif" border="0">';

    var url = str
    url = url + "?id=" + str1 + "&str=" + str3;

    url = url + "&sid=" + Math.random()
    xmlHttp.onreadystatechange = function ()
    {
        if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
        {
            document.getElementById(str2).innerHTML = xmlHttp.responseText;
            if (document.getElementById(str7))
            {
                document.getElementById(str4).innerHTML = "<input type=\"text\" name=\"" + str6 + "\" id=\"" + str6 + "\" value=\"\">";
            }
            else
            {
                document.getElementById(str4).innerHTML = "<select name=\"" + str5 + "\" id=\"" + str5 + "\"><option value=\"\">--select city--</option></select>";
            }
        }
    };

    xmlHttp.open("GET", url, true)
    xmlHttp.send(null)
}

function get_frm_time(str, str1, str2, str3)
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request")
        return
    }
    document.getElementById(str2).innerHTML = '<img src="images/ajax_loader.gif" border="0">';

    var url = str
    url = url + "?id=" + str1 + "&str=" + str3;

    url = url + "&sid=" + Math.random()
    xmlHttp.onreadystatechange = function ()
    {
        if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
        {
            document.getElementById(str2).innerHTML = xmlHttp.responseText;
            init(document.getElementById('count_row').value);
        }
    };

    xmlHttp.open("GET", url, true)
    xmlHttp.send(null)
}
function get_frm_menu(str, str1, str2, str3)
{
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request")
        return
    }
    if (frm_check.search_by[2].checked == true) {
//        alert(frm_check.search_by[2].checked);
        str3 = 'employee';
    }

    if (frm_check.search_by[1].checked == true)
    {
        str3 = 'name';
    }
    if (frm_check.search_by[0].checked == true)
    {
        str3 = 'id';
    }
//alert(str3);
    //if ( check[0].checked == true )
//		{
//			alert('name');
//		}
//	if ( check[1].checked == true )
//		{
//			alert('id');
//		}

    document.getElementById(str2).innerHTML = '<img src="images/ajax_loader.gif" border="0">';

    var url = str
    url = url + "?id=" + str1 + "&str=" + str3;
    url = url + "&sid=" + Math.random()
    xmlHttp.onreadystatechange = function ()
    {
        if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
        {

            document.getElementById(str2).innerHTML = xmlHttp.responseText;
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
                oninit: function (headers, expandedindices) { //custom code to run when headers have initalized
                    //do nothing

                },
                onopenclose: function (header, index, state, isuseractivated) { //custom code to run whenever a header is opened or closed
                    //do nothing
                }
            })
        }
    };


    xmlHttp.open("GET", url, true)
    xmlHttp.send(null)
}
function get_frm1(str, str1, str2)
{
//    alert("yre");
    xmlHttp = GetXmlHttpObject()
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request")
        return
    }
    document.getElementById(str2).innerHTML = "<img src='images/ajax_loader.gif'>";
    var url = str
    url = url + "?id=" + str1
    url = url + "&sid=" + Math.random()
    xmlHttp.onreadystatechange = function ()
    {
        if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
        {

            document.getElementById(str2).innerHTML = xmlHttp.responseText;
        }
    };

    xmlHttp.open("GET", url, true)
    xmlHttp.send(null)
}
function get_frm_new(str, str1, str2, str3, str4)
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request")
        return
    }
    document.getElementById(str2).innerHTML = '<img src="images/ajax_loader.gif" border="0">';

    var url = str
    url = url + "?id=" + str1 + "&str=" + str3 + "&str4=" + str4;
    url = url + "&sid=" + Math.random()
    xmlHttp.onreadystatechange = function ()
    {
        if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
        {
            document.getElementById(str2).innerHTML = xmlHttp.responseText;
        }
    };

    xmlHttp.open("GET", url, true)
    xmlHttp.send(null)
}
function GetXmlHttpObject()
{
    var objXMLHttp = null
    if (window.XMLHttpRequest)
    {
        objXMLHttp = new XMLHttpRequest()
    }
    else if (window.ActiveXObject)
    {
        objXMLHttp = new ActiveXObject("Microsoft.XMLHTTP")
    }
    return objXMLHttp
}

var xmlHttp = GetXmlHttpObject();

function get_frm2(str, str1, str2, str3)
{
    xmlHttp2 = GetXmlHttpObject2();
    if (xmlHttp2 == null)
    {
        alert("Browser does not support HTTP Request")
        return
    }
    document.getElementById(str2).innerHTML = '<img src="images/loader.gif" border="0">';

    var url = str
    url = url + "?id=" + str1 + "&str=" + str3;
    url = url + "&sid=" + Math.random()
    xmlHttp2.onreadystatechange = function ()
    {
        if (xmlHttp2.readyState == 4 || xmlHttp2.readyState == "complete")
        {
            document.getElementById(str2).innerHTML = xmlHttp2.responseText;
        }
    };

    xmlHttp2.open("GET", url, true)
    xmlHttp2.send(null)
}

function get_frm_leave(str, str1, str2, str3, str4, str5, str6)
{

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request")
        return
    }
    document.getElementById(str2).innerHTML = '<img src="images/ajax_loader.gif" border="0">';

    var url = str
    url = url + "?id=" + str1 + "&str=" + str3;

    url = url + "&sid=" + Math.random()
    var params = "str4=" + str4 + "&str5=" + str5 + "&str6=" + str6;

    xmlHttp.open("POST", url, true)
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange = function ()
    {
        if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
        {
            document.getElementById(str2).innerHTML = xmlHttp.responseText;
            overlay('a');
        }
    };
    xmlHttp.send(params)
}

function GetXmlHttpObject2()
{
    var objXMLHttp2 = null
    if (window.XMLHttpRequest)
    {
        objXMLHttp2 = new XMLHttpRequest()
    }
    else if (window.ActiveXObject)
    {
        objXMLHttp2 = new ActiveXObject("Microsoft.XMLHTTP")
    }
    return objXMLHttp2
}

var xmlHttp2 = GetXmlHttpObject2();
/*____________ Function to get Attendance Form____________ */

function get_frm_attendence(str, str1, str2, str3, str4, str5, str6)
{
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request")
        return
    }
    document.getElementById(str2).innerHTML = '<img src="images/ajax_loader.gif" border="0">';


    var url = str
    url = url + "?id=" + str1 + "&str=" + str3;

    url = url + "&sid=" + Math.random()
    var params = "str4=" + str4 + "&str5=" + str5 + "&str6=" + str6;


    xmlHttp.open("POST", url, true)
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange = function ()
    {
        if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
        {
            document.getElementById(str2).innerHTML = xmlHttp.responseText;
            document.getElementById('div_employee_list').innerHTML = "Successfull";
            document.getElementById('employee_id').value = "";
            document.getElementById('employee_id').focus();
        }
    };
    xmlHttp.send(params)

}

/*____________End  Function to get Attendance Form____________ */
function GetXmlHttpObject2()
{
    var objXMLHttp2 = null
    if (window.XMLHttpRequest)
    {
        objXMLHttp2 = new XMLHttpRequest()
    }
    else if (window.ActiveXObject)
    {
        objXMLHttp2 = new ActiveXObject("Microsoft.XMLHTTP")
    }
    return objXMLHttp2
}

var xmlHttp2 = GetXmlHttpObject2();

function get_frm_focus(str, str1, str2, str3)
{
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request")
        return
    }
    document.getElementById(str2).innerHTML = '<img src="images/ajax_loader.gif" border="0">';

    var url = str
    url = url + "?id=" + str1 + "&str=" + str3;

    url = url + "&sid=" + Math.random()
    xmlHttp.onreadystatechange = function ()
    {
        if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
        {
            document.getElementById(str2).innerHTML = xmlHttp.responseText;
            if (str1.split('=')[1] == 'Staff&shift')
            {
                document.getElementById('attendace').focus();
            }
            else
            {
                document.getElementById('designation').focus();
            }
        }
    };

    xmlHttp.open("GET", url, true)
    xmlHttp.send(null)
}
function get_frm_focus_goodwork(str, str1, str2, str3)
{
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request")
        return
    }
    document.getElementById(str2).innerHTML = '<img src="images/ajax_loader.gif" border="0">';

    var url = str
    url = url + "?id=" + str1 + "&str=" + str3;

    url = url + "&sid=" + Math.random()
    xmlHttp.onreadystatechange = function ()
    {
        if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
        {
            document.getElementById(str2).innerHTML = xmlHttp.responseText;
            document.getElementById('good_work').focus();
        }
    };

    xmlHttp.open("GET", url, true)
    xmlHttp.send(null)
}
function post_frm(str, str1, str2, str3, str4, str5, str6)
{
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request")
        return
    }
    document.getElementById(str2).innerHTML = '<img src="images/ajax_loader.gif" border="0">';

    var url = str

    url = url + "?sid=" + Math.random()
    var params = "&str1=" + str1 + "&str3=" + str3 + "&str4=" + str4 + "&str5=" + str5 + "&str6=" + str6;

    xmlHttp.open("POST", url, true)
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange = function ()
    {
        if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
        {
            document.getElementById(str2).innerHTML = xmlHttp.responseText;
        }
    };
    xmlHttp.send(params)
}



function post_frm_long(str, str1, str2, str3, str4, str5, str6, str7, str8, str9, str10, str11, str12, str13, str14)
{
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request")
        return
    }
    document.getElementById(str2).innerHTML = '<img src="images/ajax_loader.gif" border="0">';

    var url = str

    url = url + "?sid=" + Math.random()
    var params = "&str1=" + str1 + "&str3=" + str3 + "&str4=" + str4 + "&str5=" + str5 + "&str6=" + str6 + "&str7=" + str7 + "&str8=" + str8 + "&str9=" + str9 + "&str10=" + str10 + "&str11=" + str11 + "&str12=" + str12 + "&str13=" + str13 + "&str14=" + str14;
    xmlHttp.open("POST", url, true)
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.setRequestHeader("Content-length", params.length);
    xmlHttp.setRequestHeader("Connection", "close");

    xmlHttp.onreadystatechange = function ()
    {
        if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
        {
            document.getElementById(str2).innerHTML = xmlHttp.responseText;
        }
    };
    xmlHttp.send(params)
}
function GetXmlHttpObject2()
{
    var objXMLHttp2 = null
    if (window.XMLHttpRequest)
    {
        objXMLHttp2 = new XMLHttpRequest()
    }
    else if (window.ActiveXObject)
    {
        objXMLHttp2 = new ActiveXObject("Microsoft.XMLHTTP")
    }
    return objXMLHttp2
}
////////////////////////////////////////////////////////////////////////////////////////////////////

function ajax_showOptions(value, num, page, e, GetDesc)
{
    //Ajax Function To Get Data From a PHP Page.
    var evt = (e) ? e : (window.event) ? window.event : null;
    divNo = num;
    divId = "ajax_listOfOptions_" + divNo;
    item_id = "item_id" + divNo;
    item_name = "item_name" + divNo;

    IsGetDesc = GetDesc;
    if (Number(GetDesc) == 0)
    {
        item_id = "item_id" + divNo;
        item_name = "item_name" + divNo;
        ClosingStock = "closing_stock";
        OpeningStock = "opening_stock";
    }
    //alert(IsGetDesc);
    if (IsGetDesc == 1) // Used For Purchase Indent
    {
        item_no = "item_no_" + divNo;
        div_item_uom = "div_item_uom_" + divNo;
        div_item_desc = "div_item_desc_" + divNo;
        div_item_stock = "div_item_stock_" + divNo;
    }
    if (IsGetDesc == 2) // Used For Issue Entry
    {
        item_no = "item_no_" + divNo;
        div_item_uom = "div_item_uom_" + divNo;
        stk_qty = "stk_qty_" + divNo;
    }
    //alert(divId + item_id + item_name);
    if (evt)
    {
        var key = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode : ((evt.which) ? evt.which : 0));

        //if(key!=40 && key!=38 && key!=13 && key!=27)
        {
            var strURL = page + "?rand=" + Math.random() + "&letters=" + value;
            document.getElementById(divId).style.visibility = 'visible';
            var req = getXMLHTTP();
            if (req)
            {
                req.onreadystatechange = function () {
                    if (req.readyState == 4) {
                        if (req.status == 200)
                            document.getElementById(divId).innerHTML = req.responseText;
                        else
                            alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                    }
                }
                req.open("GET", strURL, true);
                req.send(null);
            }
        }
    }
}
function setItemId(itemIdPhp, itemNamePhp, UOM, DrawingNumber, CatelogNumber, OStock, CStock)
{
    //alert(divId);
    //Function to set the selected row
    //// -------- Change Div Id Here By (Rohan Kumar) ------------ ////////
    if (parseInt(IsGetDesc) == 0)// Code Used For Opening Stock
    {
        document.getElementById(item_id).value = itemIdPhp;
        //obj.cells[1].innerHTML;//document.getElementById('item_id_'+row_id).value;
        //// -------- Change Div Id Here By (Rohan Kumar) ------------ ////////
        document.getElementById(item_name).value = itemNamePhp;
        document.getElementById(ClosingStock).value = CStock;
        document.getElementById(OpeningStock).value = OStock;
        //obj.cells[2].innerHTML;//document.getElementById('item_name_'+row_id).value;
    }
    //alert(IsGetDesc);
    //alert(UOM+DrawingNumber+div_item_stock+IsGetDesc);
    if (parseInt(IsGetDesc) == 1)// Code Used For Purchase Indent
    {
        if (checkItemForPurchaseIndent(divNo, itemIdPhp))
        {
            document.getElementById(item_no).value = itemIdPhp;
            document.getElementById(item_name).value = itemNamePhp;
            document.getElementById(div_item_uom).innerHTML = UOM;
            document.getElementById(div_item_desc).innerHTML = 'Drg No. ' + DrawingNumber + 'Cat No. ' + CatelogNumber;
            document.getElementById(div_item_stock).innerHTML = CStock;
        }
        else
            document.getElementById(item_name).value = '';
    }
    if (parseInt(IsGetDesc) == 2)// Code Used For Issue Entry
    {
        if (CStock == '0')
        {
            alert("Stock Empty");
            document.getElementById(item_name).value = '';
        }
        else
        {
            if (checkItemForPurchaseIndent(divNo, itemIdPhp))
            {
                document.getElementById(item_no).value = itemIdPhp;
                document.getElementById(item_name).value = itemNamePhp;
                document.getElementById(div_item_uom).innerHTML = UOM;
                document.getElementById(stk_qty).value = CStock;
            }
            else
                document.getElementById(item_name).value = '';
        }

    }
    //// -------- Change Id Here By (Rohan Kumar) ------------ ////////
    document.getElementById(divId).style.visibility = 'hidden';
    //alert(document.getElementById('item_id_'+row_id).value);alert(document.getElementById('item_name_'+row_id).value);
}
function checkItemForPurchaseIndent(no, value)
// Used For Purchase Indent AND Issue Entry To Check Item Duplicacy
{
    var status = true;
    //alert(no);
    var item_id = document.getElementsByName("item_id[]");
    var len = item_id.length;
    for (var i = 0; i < len; i++)
    {
        //alert('new='+item_id[i].value);
        if (value == item_id[i].value && parseInt(no - 1) != parseInt(i))
        {
            status = false;
            break;
        }
        else
            status = true;
    }
    if (status == false)
        alert("Item Already selected.");
    return status;
}

////////////////////////////////////////////////////////////////////////////////////////////////////
var xmlHttp2 = GetXmlHttpObject2();
