/**
* a css class name that will be applied on the tooltip div. 
* 
* if this and bs_ttt_style both are not specified, a default 
* windows-like style setting will be used.
* 
* @var string bs_ttt_class
* 
* @package    javascript_core
* @subpackage util
*/
var bs_ttt_class;

/**
* a css style string that will be applied on the tooltip div. 
* 
* if this and bs_ttt_class both are not specified, a default 
* windows-like style setting will be used.
* 
* @var string bs_ttt_style
*/
var bs_ttt_style;


/**
* shows the title as tool tip. removes the title itself.
* @param object event (the event object)
* @return void
*/
function bs_ttt_showTitle(ev) {
	if (typeof(ev) == 'undefined') ev = window.event;
	//var ev = ('object' == typeof(window.event)) ? window.event : ev;  //1st is for ie, 2nd for ns
	
	var elm = ev.srcElement;
	if (bs_isEmpty(elm.title)) return;
	var div = bs_ttt_getTitleElm();
	if ((div == false) || (div == null)) return;
	div.innerHTML     = elm.title;
	elm.title = ''; //remove it for now, never show both.
	var pos = getAbsolutePos(elm);
	var elmHeight = elm.offsetHeight; //(moz) ? elm.offsetHeight : elm.clientHeight;
	div.style.left    = pos.x;
	div.style.top     = parseInt(pos.y) + parseInt(elmHeight) +0;
	div.style.display = 'block';
}

/**
* hides the title as tool tip, and makes it available as title again.
* @param object event (the event object)
* @return void
*/
function bs_ttt_hideTitle(ev) {
	if (typeof(ev) == 'undefined') ev = window.event;
	//var ev = ('object' == typeof(window.event)) ? window.event : ev;  //1st is for ie, 2nd for ns
	
	var elm = ev.srcElement;
	var div = bs_ttt_getTitleElm();
	if ((div == false) || (div == null)) return;
	elm.title = div.innerHTML; //set it back.
	div.innerHTML     = '';
	div.style.display = 'none';
}

/**
* returns a reference to the tooltip element div.
* 
* if it's not in the page yet, it will be inserted. 
* it has the hardcoded id 'bs_ttt_dynamicTitle' and can be used for all fields 
* and everything, since only 1 can be visible at a time.
* 
* @return element
*/
function bs_ttt_getTitleElm() {
	var elm = document.getElementById('bs_ttt_dynamicTitle');
	if (elm == null) {
		try {
			var divTagStr = '<div';
			divTagStr += ' id="bs_ttt_dynamicTitle"';
			if (typeof(bs_ttt_class) != 'undefined') {
				divTagStr += ' class="' + bs_ttt_class + '"';
			}
			divTagStr += ' style="position:absolute; display:none; cursor:default;';
			if (typeof(bs_ttt_style) != 'undefined') {
				divTagStr += bs_ttt_style;
			} else if (typeof(bs_ttt_class) == 'undefined') {
				divTagStr += ' background-color:#FFFFE7; font-family:arial,helvetica; font-size:11px; border:1px solid black; padding:1px;';
			}
			divTagStr += '"></div>';
			
			var bodyTag = document.getElementsByTagName('body');
			bodyTag = bodyTag[0];
			bodyTag.insertAdjacentHTML('beforeEnd', divTagStr);
			elm = document.getElementById('bs_ttt_dynamicTitle');
			if (elm == null) return false;
		} catch (e) {
			alert('exception: ' + e);
			return false;
		}
	}
	return elm;
}

/**
* loops through all input fields of the document and makes them tooltipable.
* attaches the needed events to the fields.
* only works on fields that have a title, of course.
* @return void
* @todo: add a param so that only the fields of a named form are used.
*/
function bs_ttt_initAll() {
	var elms = document.getElementsByTagName('input');
	for (var i=0; i<elms.length; i++) {
		if (!bs_isEmpty(elms[i].title)) {
			elms[i].attachEvent('onfocus', bs_ttt_showTitle);
			elms[i].attachEvent('onblur',  bs_ttt_hideTitle);
		}
	}
}

