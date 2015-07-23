<html>
<body>
<script type="text/javascript">
current_row=0;
function getXMLHTTP() { //fuction to return the xml http object
        var xmlhttp=false;    
        try{
            xmlhttp=new XMLHttpRequest();
        }
        catch(e)    {        
            try{            
                xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch(e){
                try{
                xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
                }
                catch(e1){
                    xmlhttp=false;
                }
            }
        }
        return xmlhttp;
    }

function ajax_showOptions(value,divId,page,e)
{
	//Ajax Function To Get Data From a PHP Page.
	var evt=(e)?e:(window.event)?window.event:null;
	if(evt)
	{
		
		var key=(evt.charCode)?evt.charCode: ((evt.keyCode)?evt.keyCode:((evt.which)?evt.which:0));
		
		if(key!=40 && key!=38 && key!=13 && key!=27)
		{
			var strURL=page+"?rand="+Math.random()+"&letters="+value;
			document.getElementById(divId).style.visibility='visible';
			var req = getXMLHTTP();
			if (req)
			{																					
					req.onreadystatechange = function() {
						if (req.readyState == 4) {
							if (req.status == 200)                         
									document.getElementById(divId).innerHTML=req.responseText;
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
function mouseoverTR(element,n)
{
	// Function For HighLight the active Row
	var id=document.getElementById(element);
	//alert(n);
	for(var i=1;i<=n;i++)
	{
		document.getElementById("normalROW"+i.toString()).className="";
	}
	var len=id.id.length;
	current_row = id.id.substring(9,Number(len));
	//alert(current_row);
	id.className='highlightROW';
}
function setItemId(row_id)
{
	//alert(row_id);
	//Function to set the selected row
	document.getElementById('item_id1').value=document.getElementById('item_id_'+row_id).value;
	
	document.getElementById('item_name1').value=document.getElementById('item_name_'+row_id).value;
	document.getElementById('ajax_listOfOptions').style.visibility='hidden';
	
}
</script>

<style type="text/css">
/* Big box with list of options */
	#ajax_listOfOptions{
		position:absolute;	/* Never change this one */
		width:800px;	/* Width of box */
		height:150px;	/* Height of box */
		overflow:auto;	/* Scrolling features */
		border:1px solid #333333;	/* Dark green border */
		background-color:#FFF;	/* White background color */
		text-align:left;
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:11px;
		z-index:100;
		visibility:hidden;
		
	}
.table1
{
   
	border-width:1px 1px 1px 1px; 
	border-spacing:2px;
	border-left-style:solid; 
	border-color:#000000;
	border-collapse:collapse;
}
.text_1 {
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
	color:#666666;
	text-align:left;
	line-height:25px;
}
.gredBg {
	background:#CCC;
	height:30px;
	text-align:center;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:11px;
	color:#555;
	font-weight:bold;
}
.normalROW{
	font-family:Verdana, Geneva, sans-serif;
	font-size:11px;
	color:#333;
	background-color:#FFF;
	text-align:left;
	height:30px;
	line-height:30px;

}
.highlightROW{
	font-family:Verdana, Geneva, sans-serif;
	font-size:11px;
	color:#333;
	background-color:#06C;
	text-align:left;
	height:30px;
	line-height:30px;
}
.itemText{
	font-family:Verdana, Geneva, sans-serif;
	font-size:11px;
	color:#000;
	background:none transparent;
	text-align:left;
	height:20px;
	border:1px solid #96A2BC;
	padding-right:10px;
	background:url(images/arrow.png) no-repeat center right;
}
</style>
<script language="javascript"> 
	var scrolLength = 30;
	
	nn=(document.layers)?true:false;
	ie=(document.all)?true:false;
	
	function keyDown(e) {	
	//// Events Used on pressing UP, DOWN, Or ENTER Keys 
		var evt=(e)?e:(window.event)?window.event:null;
		if(evt){
			var key=(evt.charCode)?evt.charCode: ((evt.keyCode)?evt.keyCode:((evt.which)?evt.which:0));
			
			
			if(key==38){
				id1=document.getElementById('normalROW'+current_row);
				if(id1){
					id2=document.getElementById('normalROW'+parseInt(current_row-1));
					if(id2){
						current_row=current_row-1;
						id1.className='normalROW';
						id2.className='highlightROW';
						scrolLength = (current_row * 30)+current_row;
						//alert(current_row);
					  	document.getElementById("ajax_listOfOptions").scrollTop = scrolLength;
						//alert(document.getElementById("ajax_listOfOptions").scrollTop);
					}
					else
					{
						id1.className='highlightROW';
					}
				}
			}
			else if(key==40){
				id1=document.getElementById('normalROW'+current_row);
				if(id1){
				
					id2=document.getElementById('normalROW'+parseInt(current_row+1));
					if(id2){
						current_row=current_row+1;
						//alert(current_row)
						id1.className='normalROW';
						id2.className='highlightROW';
						//if(scrolLength>150)
						{
							document.getElementById("ajax_listOfOptions").scrollTop = scrolLength;
                     		
						}
						//alert(document.getElementById("ajax_listOfOptions").scrollTop+ " : "+scrolLength)
						scrolLength = ((current_row) * 30)+current_row;
					}
					else
					{
						id1.className='highlightROW';
					}
				}
			}
			else if(key==13){
				document.getElementById('ajax_listOfOptions').style.visibility='hidden';
				// Call This Function To Set Item Id And Name....
				// This Function is Used When we Enter on a record or clicking on a row....
						setItemId(current_row);
				
			}
			else
			{
				current_row=0;
				scrolLength = 30;
			}
		}
	}
document.onkeydown=keyDown;
if(nn) document.captureEvents(Event.KEYDOWN);
 </script>
<div style="width:40%;margin:0 auto" align="center">This Demo is Best For Mozilla.<br />It Will Work on IE But not Flexible</div>
  <table align="center" width="40%" cellpadding="2" cellspacing="2" bgcolor="#F8F8F8" style="border:1px solid #E9E9E9;">
  			<tr><td align="center" colspan="2"><b>Press BackSpace After Clicking On TextBox First</b></td></tr>
        <tr>
            <td>Search By :</td>
            <td>
                <input type="text" name="item_name" id="item_name1" onKeyUp="ajax_showOptions(this.value,'ajax_listOfOptions','store_ajax_list_item.php',event)" onfocus="ajax_showOptions(this.value,'ajax_listOfOptions','store_ajax_list_item.php',event)" autocomplete="off" class="itemText" value=""/>
                <div id="ajax_listOfOptions"></div>
                <input type="text" id="item_id1" name="item_id_hidden" value="" />
            </td>
        </tr>
    </table>
    
</body>
</html>