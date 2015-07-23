<?
$ticket_no = "";
$filter_sql = "";
echo "string";
if (isset($_GET['ticket_no'])) {
    echo $ticket_no = $_GET['ticket_no'];
    echo $filter_sql = "where ticket_no ='$ticket_no'";
}
?>
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td align="left" style="padding-top:5px;" colspan="2">
            <table cellpadding="0" cellspacing="0" border="0" align="left" class="loginbg" width="98%">
                <tr>
                    <td width="12%" class="text_1" style="padding-left:15px;">Employee List<span class="red">*</span></td>
                    <td width="3%" align="left"><img src="images/tnb_div_1.jpg" width="7" height="35"/></td>
                    <td width="13%">
                        <input type="text" id="emp_search" name="emp_search" onkeydown="if (event.keyCode && event.keyCode == 13) {
                                    get_frm_menu('employee_list_releaved.php', this.value, 'emp_list', '');
                                }" value="<?= $ticket_no ?>"/>
                    </td>
                    <td width="72%" class="text_1" style="padding-top:5px;">
                        <form name="frm_check" id="frm_check">
                            <input type="radio" id="search_by" name="search_by" value="ID" checked="checked" onclick="get_frm_menu('employee_list_releaved.php', document.getElementById('emp_search').value, 'emp_list', '')" />ID
                            <input type="radio" id="search_by" name="search_by"  value="Name" onclick="get_frm_menu('employee_list_releaved.php', document.getElementById('emp_search').value, 'emp_list', '')"/>Name
                            <input type="radio" id="search_by" name="search_by"  value="employee" onclick="get_frm_menu('employee_list_releaved.php', document.getElementById('emp_search').value, 'emp_list', '')"/>Department Name
                        </form>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td id="td_data" align="left" class="menuLink" style="border-right:1px solid #CCCCCC; border-left:1px solid #CCCCCC; padding-top:1px;" width="200px" valign="top">
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
                    oninit: function (headers, expandedindices) { //custom code to run when headers have initalized
                        //do nothing
                    },
                    onopenclose: function (header, index, state, isuseractivated) { //custom code to run whenever a header is opened or closed
                        //do nothing
                    }
                })


            </script>
            <script type="text/javascript">
                $(document).ready(function () {
                    var height;
                    function last_msg_funtion()
                    {

                        var ID = $(".message_box:last").attr("id");
                        //$('div#last_msg_loader').html('<img src="load/bigLoader.gif">');

                        $.post("load/load_realeaved_data.php?action=get&last_msg_id=" + ID,
                                function (data) {
                                    if (data != "") {
                                        $(".message_box:last").after(data);
                                    }
                                    //$('div#last_msg_loader').empty();
                                });
                    }
                    ;
                    $('#emp_list').scroll(function () {
                        var ID = $(".message_box:last").attr("id");

                        if ($('#emp_list').scrollTop() == $(".message_box").height() * ID - 333) {
                            //alert($('#emp_list').scrollTop() + " : " + $(".message_box").height() + " : " + ID + " : " + $(".message_box").height()*ID + " : ");

                            last_msg_funtion();
                        }
                    });
                });
            </script>


            <? $action = ""; ?>
            <div id="emp_list" style="overflow:scroll;height:350px;width:500px;">
                <?php include('load/load_realeaved_first.php'); ?>

            </div>
        </td>
        <td align="left" style="padding-left:5px;" valign="top"><div id="div_detail"></div></td>
    </tr>   
</table>

