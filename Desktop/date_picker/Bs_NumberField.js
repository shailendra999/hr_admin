// The global array of objects that have been instanciated
if (!Bs_Objects) {var Bs_Objects = [];};


function bs_numberFieldKeyDown() {
	return event.srcElement.bsObject.onKeyDown();
}
function bs_numberFieldKeyUp() {
	return event.srcElement.bsObject.onKeyUp();
}
function bs_numberFieldFocus() {
	return event.srcElement.bsObject.onFocus();
}
function bs_numberFieldWheel() {
	return event.srcElement.bsObject.onWheel();
}
function bs_numberFieldBlur() {
	return event.srcElement.bsObject.onBlur();
}

function bs_numberFieldRedraw() {
	for (var i=0; i<bs_numberFieldObjects.length; i++) {
		try {
			bs_numberFieldObjects[i].redraw();
		} catch (e) {
			break;
		}
	}
}
var bs_numberFieldObjects = new Array;
try {
	window.attachEvent('onresize', bs_numberFieldRedraw);
} catch (e) {
}
window.setInterval(bs_numberFieldRedraw, 1000);


/**
* Text field for numbers.
* 
* currently only full numbers (integers) are supported. 
* negative numbers are possible, see minValue.
* 
* dependencies: /core/lang/Bs_Misc.lib.js
*               /components/toolbar/Bs_Button.class.js
* 
* @package    javascript_components
* @subpackage numberfield
* @author     andrej arn <andrej-at-blueshoes-dot-org>
* @copyright  blueshoes.org
*/
function Bs_NumberField(elm) {
	
  // To support the old interface call with 2 arguments. (First argument used to be the object name). 
  var a = arguments;
  this._elementId = (a.length>1) ? a[1] :  a[0];  
	this._elm       = document.getElementById(this._elementId);
	
	/**
  * Unique Object/Tag ID is initialized in the constuctor.
  * Bassed on this._id. Can be used in genarate JS-code as ID. Is set together 
  * from the  classname + this._id (see _constructor() code ).
  *
  * @access private
  * @var  string 
  */
  this._objectId;
	
	/**
	* a max value, if any. can be negative.
	* @access public
	* @var    int maxValue
	*/
	this.maxValue;
	
	/**
	* a min value. can be negative. default is 0.
	* @access public
	* @var    int minValue
	*/
	this.minValue = 0;
	
	/**
	* if an empty value '' should be allowed. default is false.
	* @access public
	* @var    bool allowEmpty
	* @since  bs-4.6
	*/
	this.allowEmpty = false;
	
	/**
	* if the number should be zerofilled.
	* example: zeroFill 3 means a value of 5 looks like 005.
	* @access public
	* @var    int zeroFill
	*/
	this.zeroFill;
	
	/**
	* @access public
	* @var    object buttonUp
	*/
	this.buttonUp;
	
	/**
	* @access public
	* @var    object buttonDown
	*/
	this.buttonDown;
	
	/**
	* @access public
	* @var    bool drawButtonsInside
	* @status experimental
	*/
	this.drawButtonsInside = false;
	
	
	/**
	* the current value.
	* @access private
	* @see    getValue(), setValue()
	*/
	this._value   = 0;
	
  /**
  * array holding all the information about attached events. 
	* 
  * the structure can be like these:
  * 1) attach a function directly
  *    syntax:  _attachedEvents['eventName'] = yourFunctionName;
  * 2) attach some javascript code
  *    syntax:  _attachedEvents['eventName'] = "yourCode();";
  *    example: _attachedEvents['eventName'] = "alert('hi'); callSomething('foo');";
  *    just keep in mind that you cannot use vars in that code, because when it 
  *    gets executed that will be another scope (unless the vars are global...)
  * 3) attach multiple things for the same event
  *    syntax:  _attachedEvents['eventName']    = new Array;
  *             _attachedEvents['eventName'][0] = yourFunctionName;
  *             _attachedEvents['eventName'][1] = "yourCode();";
  * 
  * @access private
  * @var    array _attachedEvents (hash, see above)
  * @see    this.attachEvent();
  */
  this._attachedEvents;	
	
	
	/**
	* the pseudo constructor.
	* @access private
	* @return void
	*/
	this._constructor = function() {
  	// Put this instance into the global object instance list
    this._id = Bs_Objects.length;
    Bs_Objects[this._id] = this; 
    this._objectId = "Bs_NumberField_"+this._id;



		if (typeof(this._elm) == 'string') this._elm = document.getElementById(this._elm);
		bs_numberFieldObjects[bs_numberFieldObjects.length] = this;
		this._elm.bsObject = this;
		this._elm.attachEvent('onkeydown',    bs_numberFieldKeyDown); //keypress
		this._elm.attachEvent('onkeyup',      bs_numberFieldKeyUp);
		this._elm.attachEvent('onfocus',      bs_numberFieldFocus);
		this._elm.attachEvent('onmousewheel', bs_numberFieldWheel);
		this._elm.attachEvent('onblur',       bs_numberFieldBlur);
		
		var arrowUpObjName   = this._objectId + '_btnUpObj';
		var arrowUpDivName   = this._objectId + '_btnUpDiv';
		var arrowDownObjName = this._objectId + '_btnDownObj';
		var arrowDownDivName = this._objectId + '_btnDownDiv';
		
		var buttonHeights = this._getButtonHeights();
		
		this.buttonUp   = new Bs_Button();
		this.buttonUp.objectName = arrowUpObjName;
		this.buttonUp.imgPath = '/mahimapurespun/date_picker/';
	  this.buttonUp.imgName = 'arrowBlackUp';
	  this.buttonUp.title   = 'Increase';
		this.buttonUp.height  = buttonHeights.button1;
		this.buttonUp.width   = 13;
		this.buttonUp.cssClassDefault = 'bsBtnMouseOver';
	  this.buttonUp.attachEvent('Bs_Objects['+this._id+'].onClickButtonUp();');
		
		this.buttonDown = new Bs_Button();
		this.buttonDown = new Bs_Button();
	  this.buttonDown.objectName = arrowDownObjName;
		this.buttonDown.imgPath = '/mahimapurespun/date_picker/';
	  this.buttonDown.imgName = 'arrowBlackDown';
	  this.buttonDown.title   = 'Decrease';
		this.buttonDown.height  = buttonHeights.button2;
		this.buttonDown.width   = 13;
		this.buttonDown.cssClassDefault   = 'bsBtnMouseOver';
	  this.buttonDown.attachEvent('Bs_Objects['+this._id+'].onClickButtonDown();');
	}
	
	
	/**
	* sets a new value.
	* @access public
	* @param  mixed value
	* @return void
	*/
	this.setValue = function(value) {
		value = this.fixValue(value);
		this._value = value;
		this._elm.value = this._zeroFillValue(value);
	}
	
	/**
	* returns the current value.
	* @access public
	* @return int
	*/
	this.getValue = function() {
		this.updateByField();
		return this._value;
	}
	
	/**
	* increases the value by 1.
	* @access public
	* @return void
	*/
	this.increase = function() {
		this.updateByField();
		this.setValue(this._value +1);
	}
	
	/**
	* decreases the value by 1.
	* @access public
	* @return void
	*/
	this.decrease = function() {
		this.updateByField();
		this.setValue(this._value -1);
	}
	
	/**
	* @access ?
	* @return ?
	*/
	this.render = function() {
		var arrowUpDivName   = this._objectId + '_btnUpDiv';
		var arrowDownDivName = this._objectId + '_btnDownDiv';
		
		var fldPos        = getAbsolutePos(this._elm, true);
		var fldHeight     = this._elm.offsetHeight;
		var fldWidth      = this._elm.offsetWidth;
		var left          = fldPos.x + fldWidth;
		var top           = fldPos.y;
		
		if (this.drawButtonsInside) {
			left      -= 15;
			top       += 2;
			fldHeight -= 4;
		}
		
		var bDiv = new Array;
		bDiv[bDiv.length] = '<div id="' + this._objectId + '_btnContainer"';
		bDiv[bDiv.length] = ' style="position:absolute; left:' + left + 'px; top:' + top + 'px;';
		if (false) { //use the z-index? not sure.
			var zIndex = (this._elm.style.zIndex > 0) ? this._elm.style.zIndex : 1;
			bDiv[bDiv.length] = ' z-index:' + zIndex + ';';
		}
		bDiv[bDiv.length] = '">';
		bDiv[bDiv.length] = this._renderButtonContainers(arrowUpDivName, arrowDownDivName);
		bDiv[bDiv.length] = '</div>';
		
		return bDiv.join('');
	}
	
	/**
	* @access private
	* @return object
	*/
	this._getButtonHeights = function() {
		var ret = new Object;
		var fldHeight = this._elm.offsetHeight;
		if (this.drawButtonsInside) {
			fldHeight -= 4;
		}
		ret.button1   = parseInt(fldHeight /2);
		ret.button2   = fldHeight - ret.button1;
		return ret;
	}
	
	/**
	* redraws the buttons.
	* 
	* if your number field was in an invisible area while draw() was called 
	* (for example in a div that had display:none) then you'll need to call 
	* this method once your div becomes visible. this is because the browser 
	* does not tell us the right measurements if display is set to none.
	* 
	* also other changes like a window resize require this method.
	* 
	* @access public
	* @return void
	*/
	this.redraw = function() {
		var fldPos        = getAbsolutePos(this._elm, true);
		var fldWidth      = this._elm.offsetWidth;
		var left          = fldPos.x + fldWidth;
		var top           = fldPos.y;
		
		if (this.drawButtonsInside) {
			left      -= 15;
			top       += 2;
		}
		
		var container = document.getElementById(this._objectId + '_btnContainer');
		if ((parseInt(container.style.left) == left) && (parseInt(container.style.top) == top)) {
			//nothing to do.
			return;
		}
		container.style.left = left;
		container.style.top  = top;
		
		if (moz) {
			var fldPos = getAbsolutePos(container, true);
			if (fldPos.x != left) {
				container.style.left = left - (fldPos.x - left);
			}
			if (fldPos.y != top) {
				container.style.top = top - (fldPos.y - top);
			}
		}
		
		container.innerHTML  = this._renderButtonContainers();
		this._renderButtons();
	}
	
	/**
	* @access ?
	* @return ?
	*/
	this.draw = function() {
		if (this.updateByField()) {
			//there was a change
		}
		
		var htmlCode = this.render();
		this._elm.insertAdjacentHTML('afterEnd', htmlCode);
		
		this._renderButtons();
		
		//onpropertychange
	}
	
	/**
	* renders the buttons (up and down) after the container has been spitted out.
	* @access private
	* @return void
	*/
	this._renderButtons = function() {
		var arrowUpDivName   = this._objectId + '_btnUpDiv';
		var arrowDownDivName = this._objectId + '_btnDownDiv';
		var arrowUpObjName   = this._objectId + '_btnUpObj';
		var arrowDownObjName = this._objectId + '_btnDownObj';
		
		var buttonHeights = this._getButtonHeights();
		this.buttonUp.height    = buttonHeights.button1;
		this.buttonDown.height  = buttonHeights.button2;
		
	  this.buttonUp.drawInto(arrowUpDivName);
		eval(arrowUpObjName+' = Bs_Objects['+this._id+'].buttonUp;');
	  this.buttonDown.drawInto(arrowDownDivName);
		eval(arrowDownObjName+' = Bs_Objects['+this._id+'].buttonDown;');
	}
	
	/**
	* @access private
	* @param  string arrowUpDivName
	* @param  string arrowDownDivName
	* @return string
	*/
	this._renderButtonContainers = function(arrowUpDivName, arrowDownDivName) {
		if (typeof(arrowUpDivName)   == 'undefined') arrowUpDivName   = this._objectId + '_btnUpDiv';
		if (typeof(arrowDownDivName) == 'undefined') arrowDownDivName = this._objectId + '_btnDownDiv';
		
		var bDiv = new Array;
		bDiv[bDiv.length] = '<div style="display:block;" id="' + arrowUpDivName   + '"></div>';
		bDiv[bDiv.length] = '<div style="display:block;" id="' + arrowDownDivName + '"></div>';
		return bDiv.join('');
	}
	
	
	/**
	* checks min and max size etc and returns the 'clean' value.
	* if we don't have a valid number, then:
	*   if empty values are allowed (this.allowEmpty) 
	*     then '' is returned.
	*   else this.minValue is returned.
	*     if no minValue is specified then 0 is returned.
	* 
	* @access public
	* @param  mixed value
	* @return int (or string if zerofilled, or empty string if allowEmpty and no valid value.)
	*/
	this.fixValue = function(value) {
		value = parseInt(value, 10);
		if (isNaN(value)) {
			if (this.allowEmpty) {
				return '';
			} else {
				if (!isNaN(this.minValue)) return this.minValue;
				return 0;
			}
		}
		if (!bs_isNull(this.minValue) && (value < this.minValue)) value = this.minValue;
		if (!bs_isNull(this.maxValue) && (value > this.maxValue)) value = this.maxValue;
		return value;
	}
	
	/**
	* zerofills the given value if needed.
	* @access private
	* @return mixed (string or int)
	* @see    this.zeroFill
	*/
	this._zeroFillValue = function(value) {
		if (typeof(this.zeroFill) != 'undefined') {
			var numLength = (value + '').length;
			for (var i=numLength; i<this.zeroFill; i++) {
				value = '0' + value;
			}
		}
		return value;
	}
	
	/**
	* tells if the value specified is valid, and in the desired range.
	* @access public
	* @param  mixed value
	* @return bool
	*/
	this.isValidValue = function(value) {
		if (isNaN(value)) return false;
		if (!bs_isNull(this.minValue) && (value < this.minValue)) return false;
		if (!bs_isNull(this.maxValue) && (value > this.maxValue)) return false;
		return true;
	}
	
	/**
	* @access public (you don't need that.)
	*/
	this.onKeyDown = function() {
		//alert(window.event.keyCode);
		if ((window.event.keyCode <= 90) && (window.event.keyCode >= 65)) return false; //a-z
	  switch (window.event.keyCode) {
	    case 40: //cursor-down
				if (!this.fireEvent('onBeforeChange')) return false;
				this.decrease();
				this.fireEvent('onAfterChange');
				return false;
				break;
	    case 38: //cursor-up
				if (!this.fireEvent('onBeforeChange')) return false;
				this.increase();
				this.fireEvent('onAfterChange');
				return false;
				break;
	  }
		return true;
	}
	
	/**
	* @access public (you don't need that.)
	*/
	this.onKeyUp = function() {
		if (this.isValidValue(this._elm.value)) {
			//only update it if it's a value on the allowed range.
			//otherwise we'd reset the field to the minvalue while the user is still 
			//typing, for example. very annoying.
			if (!this.fireEvent('onBeforeChange')) return;
			this.updateByField();
			this.fireEvent('onAfterChange');
		}
	}
	
	/**
	* fires when the 'up-botton' is clicked.
	* @access public (used internally, but feel free.)
	* @return void
	*/
	this.onClickButtonUp = function() {
		if (!this.fireEvent('onBeforeChange')) return;
		this.increase();
		this.fireEvent('onAfterChange');
	}
	
	/**
	* fires when the 'up-botton' is clicked.
	* @access public (used internally, but feel free.)
	* @return void
	*/
	this.onClickButtonDown = function() {
		if (!this.fireEvent('onBeforeChange')) return;
		this.decrease();
		this.fireEvent('onAfterChange');
	}
	
	
	/**
	* @access public (you don't need that.)
	*/
	this.onFocus = function() {
		this.updateByField();
		this._elm.select();
		//if (!moz) this._elm.focus();
	}
	
	/**
	* @access public (you don't need that.)
	* @return false (so that the event does not bubble)
	*/
	this.onWheel = function() {
		if (!this.fireEvent('onBeforeChange')) return;
		if (event.wheelDelta > 0) {
			this.increase();
		} else if (event.wheelDelta < 0) {
			this.decrease();
		}
		this.fireEvent('onAfterChange');
		return false;
	}
	
	/**
	* @access public (you don't need that.)
	*/
	this.onBlur = function() {
		this.updateByField();
	}
	
	/**
	* updates everything based on the current value in the field.
	* @access public
	* @return bool (true if there was a change, false if not)
	*/
	this.updateByField = function() {
		var oldVal = this._elm.value;
		if (isNaN(oldVal) || (oldVal == '') || (oldVal.length == 0)) {
			if (this.allowEmpty) {
				oldVal = '';
			} else {
				oldVal = this.minValue;
			}
		}
		if ((this._value != oldVal)) {
			this.setValue(oldVal);
		}
		return (this._value != oldVal);
	}
	
	
	/**
	* shows or hides the up-down buttons.
	* @access public
	* @param  bool show (true = display, false = hide)
	* @return void
	*/
	this.toggleButtonDisplay = function(show) {
		var elm = document.getElementById(this._objectId + '_btnContainer');
		elm.style.display = (show) ? 'block' : 'none';
	}
	
	
  /**
  * attaches an event.
	* 
	* the following triggers can be used:
	*   'onBeforeChange'
	*   'onAfterChange'
	* 
	* the onXXXChange events fire when the wheel is used, a button (up/down) 
	* is clicked, cursor up or down is pushed. but they do NOT fire when you 
	* use the api methods setValue(), increase() and decrease(). because 
	* then you already know what's happening.
	* 
	* 
	* the events will be executed in the order they were registered.
	* 
	* if an onBeforeXXX event you've attached returns bool FALSE, it 
	* will stop executing any other attached events in that queue, 
	* and it will quit. example: if you attach an onBeforeChange 
	* event, and your code returns FALSE, the change won't be done 
	* at all.
	* 
	* examples:
	*   myObj.attachEvent('onBeforeChange', myFunction);
	*   then your function myFunction() receives one param, it is 
	*   a reference to this object (myObj).
	*   
	*   myObj.attachEvent('onBeforeChange', "if (true) return false;");
	*   this is an example with code attached that will be evaluated.
	* 
  * @access public
  * @param  string trigger
  * @param  mixed  yourEvent (string (of code) or function)
  * @return void
  * @see    var this._attachedEvents
  */
  this.attachEvent = function(trigger, yourEvent) {
    if (typeof(this._attachedEvents) == 'undefined') {
      this._attachedEvents = new Array();
    }
    
    if (typeof(this._attachedEvents[trigger]) == 'undefined') {
      this._attachedEvents[trigger] = new Array(yourEvent);
    } else {
      this._attachedEvents[trigger][this._attachedEvents[trigger].length] = yourEvent;
    }
  }
	
  /**
  * tells if any event is attached for the trigger specified. 
  * @access public
  * @param  string trigger
  * @return bool
  */
  this.hasEventAttached = function(trigger) {
    return (this._attachedEvents && this._attachedEvents[trigger]);
  }
  
  /**
  * fires the events for the trigger specified.
  * @access public (used internally but feel free to trigger events yourself...)
  * @param  string trigger
  * @return true
  */
  this.fireEvent = function(trigger) {
		if (trigger == 'onAfterChange') this._fireOnChange();
		
    if (this._attachedEvents && this._attachedEvents[trigger]) {
      var e = this._attachedEvents[trigger];
      if ((typeof(e) == 'string') || (typeof(e) == 'function')) {
        e = new Array(e);
      }
      for (var i=0; i<e.length; i++) {
        if (typeof(e[i]) == 'function') {
          var status = e[i](this);
        } else if (typeof(e[i]) == 'string') {
          var status = eval(e[i]);
        } //else murphy
				if (status == false) return false;
      }
    }
		return true;
  }
	
	/**
	* special case: the onchange event set in the field does not fire. 
	* we need to call it ourself.
	* @access private
	* @return void
	*/
	this._fireOnChange = function() {
		if (this._elm.onchange) {
			this._elm.onchange();
		}
	}
	
	this._constructor(); //call the constructor. needs to be at the end.
	
}

