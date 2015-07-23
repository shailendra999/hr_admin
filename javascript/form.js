var digits = "0123456789";
var lowercaseLetters = "abcdefghijklmnopqrstuvwxyz";
var uppercaseLetters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
var whitespace = " \t\n\r";
var decimalPointDelimiter = ".";
var phoneNumberDelimiters = "()- ";
var validUSPhoneChars = digits + phoneNumberDelimiters;
var validWorldPhoneChars = digits + phoneNumberDelimiters + "+";
var SSNDelimiters = "- ";
var validSSNChars = digits + SSNDelimiters;
var digitsInSocialSecurityNumber = 9;
var digitsInUSPhoneNumber = 10;
var ZIPCodeDelimiters = "-";
var ZIPCodeDelimeter = "-"
var validZIPCodeChars = digits + ZIPCodeDelimiters;
var digitsInZIPCode1 = 5;
var digitsInZIPCode2 = 9;
var creditCardDelimiters = " ";
//var mPrefix = "You did not enter a value into the ";
//var mSuffix = " field. This is a required field. Please enter it now.";
var mPrefix = "Please enter your "
var mSuffix = "";

var sName = "Name";
var sBusiness = "Business";
var sUSAddress2 = "Address 2";
var sCompany = "Company";
var sComments = "Comments";
var sYourName = "Your Name";
var sFriendName = "Your Friends Name";

var sUSLastName = "Last Name";
var sUSFirstName = "First Name";
var sWorldLastName = "Family Name";
var sWorldFirstName = "Given Name";
var sTitle = "Title";
var sCompanyName = "Company Name";
var sUSAddress = "Address";
var sWorldAddress = "Address";
var sCity = "City";
var sStateCode = "State";
var sWorldState = "State, Province, or Prefecture";
var sCountry = "Country";
var sZIPCode = "Zip";
var sWorldPostalCode = "Postal Code";
var sPhone = "Phone";
var sFax = "Fax";
var sDateOfBirth = "Date of Birth";
var sExpirationDate = "Expiration Date";
var sEmail = "Email";
var sSSN = "Social Security Number";
var sCreditCardNumber = "Credit Card Number";
var sOtherInfo = "Other Information";
var iStateCode = "This field must be a valid two character U.S. state abbreviation (like AZ for Arizona).";
var iZIPCode = "This field must be a 5 or 9 digit U.S. ZIP Code (like 85016).";
var iUSPhone = "This field must be a 10 digit U.S. phone number (like 602 264 5455).";
var iWorldPhone = "This field must be a valid international phone number.";
var iSSN = "This field must be a 9 digit U.S. social security number (like 123 45 6789).";
var iEmail = "Please enter valid email address (example:email@server.extension).";
var iCreditCardPrefix = "This is not a valid ";
var iCreditCardSuffix = " credit card number. (Click the link on this form to see a list of sample numbers.).";
var iDay = "This field must be a day number between 1 and 31.";
var iMonth = "This field must be a month number between 1 and 12.";
var iYear = "This field must be a 2 or 4 digit year number.";
var iDatePrefix = "The Day, Month, and Year for ";
var iDateSuffix = " do not form a valid date.";
var pEntryPrompt = "Please enter a ";
var pStateCode = "2 character code (like AZ).";
var pZIPCode = "5 or 9 digit U.S. Zip Code (like 85016).";
var pUSPhone = "10 digit U.S. phone number (like 602 264 5455).";
var pWorldPhone = "international phone number.";
var pSSN = "9 digit U.S. social security number (like 123 45 6789).";
var pEmail = "valid email address (like email@server.ext).";
var pCreditCard = "valid credit card number.";
var pPass = "Enter Your Password.";
var pDay = "day number between 1 and 31.";
var pMonth = "month number between 1 and 12.";
var pYear = "2 or 4 digit year number.";
var defaultEmptyOK = false;

var isNN = (navigator.appName.indexOf("Netscape") != -1);
function autoTab(input, len, e) {
    var keyCode = (isNN) ? e.which : e.keyCode;
    var filter = (isNN) ? [0, 8, 9] : [0, 8, 9, 16, 17, 18, 37, 38, 39, 40, 46];
    if (input.value.length >= len && !containsElement(filter, keyCode)) {
        input.value = input.value.slice(0, len);
        input.form[(getIndex(input) + 1) % input.form.length].focus();
    }
    function containsElement(arr, ele) {
        var found = false, index = 0;
        while (!found && index < arr.length)
            if (arr[index] == ele)
                found = true;
            else
                index++;
        return found;
    }
    function getIndex(input) {
        var index = -1, i = 0, found = false;
        while (i < input.form.length && index == - 1)
            if (input.form[i] == input)
                index = i;
            else
                i++;
        return index;
    }
    return true;
}


function focus(i, j) {
    document.forms[i].elements[j].focus();
}

function trim(form, i) {
    var trim = trimStr(form.elements[i].value);
    form.elements[i].value = trim;
}

function trimStr(urstr) {
    var i = 0;
    var j = 0;

    for (i = 0; i < urstr.length; i++) {
        if (urstr.charAt(i) != " ") {
            for (j = urstr.length - 1; j > i; j--) {
                if (urstr.charAt(j) != " ")
                    break;
            }
            break;
        }
    }
    if (i > j)
        i = j;
    if (urstr.length > 0 && urstr.charAt(j) != " ")
        j++;
    return urstr.substring(i, j);
}

function makeArray(n) {
    for (var i = 1; i <= n; i++) {
        this[i] = 0
    }
    return this
}

var daysInMonth = makeArray(12);
daysInMonth[1] = 31;
daysInMonth[2] = 29;
daysInMonth[3] = 31;
daysInMonth[4] = 30;
daysInMonth[5] = 31;
daysInMonth[6] = 30;
daysInMonth[7] = 31;
daysInMonth[8] = 31;
daysInMonth[9] = 30;
daysInMonth[10] = 31;
daysInMonth[11] = 30;
daysInMonth[12] = 31;
var USStateCodeDelimiter = "|";
var USStateCodes = "AL|AK|AS|AZ|AR|CA|CO|CT|DE|DC|FM|FL|GA|GU|HI|ID|IL|IN|IA|KS|KY|LA|ME|MH|MD|MA|MI|MN|MS|MO|MT|NE|NV|NH|NJ|NM|NY|NC|ND|MP|OH|OK|OR|PW|PA|PR|RI|SC|SD|TN|TX|UT|VT|VI|VA|WA|WV|WI|WY|AE|AA|AE|AE|AP"

function isEmpty(s) {
    return ((s == null) || (s.length == 0))
}

function isWhitespace(s) {
    var i;
    if (isEmpty(s))
        return true;
    for (i = 0; i < s.length; i++) {
        var c = s.charAt(i);
        if (whitespace.indexOf(c) == -1)
            return false;
    }
    return true;
}

function stripCharsInBag(s, bag) {
    var i;
    var returnString = "";
    for (i = 0; i < s.length; i++) {
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1)
            returnString += c;
    }
    return returnString;
}

function stripCharsNotInBag(s, bag) {
    var i;
    var returnString = "";
    for (i = 0; i < s.length; i++) {
        var c = s.charAt(i);
        if (bag.indexOf(c) != -1)
            returnString += c;
    }
    return returnString;
}

function stripWhitespace(s) {
    return stripCharsInBag(s, whitespace)
}

function charInString(c, s) {
    for (i = 0; i < s.length; i++) {
        if (s.charAt(i) == c)
            return true;
    }
    return false
}

function stripInitialWhitespace(s) {
    var i = 0;
    while ((i < s.length) && charInString (s.charAt(i), whitespace))
        i++;
    return s.substring(i, s.length);
}

function isLetter(c) {
    return (((c >= "a") && (c <= "z")) || ((c >= "A") && (c <= "Z")))
}

function isDigit(c) {
    return ((c >= "0") && (c <= "9"))
}

function isLetterOrDigit(c) {
    return (isLetter(c) || isDigit(c))
}

function isInteger(s) {
    var i;
    if (isEmpty(s))
        if (isInteger.arguments.length == 1)
            return defaultEmptyOK;
        else
            return (isInteger.arguments[1] == true);
    for (i = 0; i < s.length; i++) {
        var c = s.charAt(i);
        if (!isDigit(c))
            return false;
    }
    return true;
}

function isSignedInteger(s) {
    if (isEmpty(s))
        if (isSignedInteger.arguments.length == 1)
            return defaultEmptyOK;
        else
            return (isSignedInteger.arguments[1] == true);
    else {
        var startPos = 0;
        var secondArg = defaultEmptyOK;
        if (isSignedInteger.arguments.length > 1)
            secondArg = isSignedInteger.arguments[1];
        if ((s.charAt(0) == "-") || (s.charAt(0) == "+"))
            startPos = 1;
        return (isInteger(s.substring(startPos, s.length), secondArg))
    }
}

function isPositiveInteger(s) {
    var secondArg = defaultEmptyOK;
    if (isPositiveInteger.arguments.length > 1)
        secondArg = isPositiveInteger.arguments[1];
    return (isSignedInteger(s, secondArg) && ((isEmpty(s) && secondArg) || (parseInt(s) > 0)));
}

function isNonnegativeInteger(s) {
    var secondArg = defaultEmptyOK;
    if (isNonnegativeInteger.arguments.length > 1)
        secondArg = isNonnegativeInteger.arguments[1];
    return (isSignedInteger(s, secondArg) && ((isEmpty(s) && secondArg) || (parseInt(s) >= 0)));
}

function isNegativeInteger(s) {
    var secondArg = defaultEmptyOK;
    if (isNegativeInteger.arguments.length > 1)
        secondArg = isNegativeInteger.arguments[1];
    return (isSignedInteger(s, secondArg) && ((isEmpty(s) && secondArg) || (parseInt(s) < 0)));
}

function isNonpositiveInteger(s) {
    var secondArg = defaultEmptyOK;
    if (isNonpositiveInteger.arguments.length > 1)
        secondArg = isNonpositiveInteger.arguments[1];
    return (isSignedInteger(s, secondArg) && ((isEmpty(s) && secondArg) || (parseInt(s) <= 0)));
}

function isFloat(s) {
    var i;
    var seenDecimalPoint = false;
    if (isEmpty(s))
        if (isFloat.arguments.length == 1)
            return defaultEmptyOK;
        else
            return (isFloat.arguments[1] == true);
    if (s == decimalPointDelimiter)
        return false;
    for (i = 0; i < s.length; i++) {
        var c = s.charAt(i);
        if ((c == decimalPointDelimiter) && !seenDecimalPoint)
            seenDecimalPoint = true;
        else if (!isDigit(c))
            return false;
    }
    return true;
}

function isSignedFloat(s) {
    if (isEmpty(s))
        if (isSignedFloat.arguments.length == 1)
            return defaultEmptyOK;
        else
            return (isSignedFloat.arguments[1] == true);
    else {
        var startPos = 0;
        var secondArg = defaultEmptyOK;
        if (isSignedFloat.arguments.length > 1)
            secondArg = isSignedFloat.arguments[1];
        if ((s.charAt(0) == "-") || (s.charAt(0) == "+"))
            startPos = 1;
        return (isFloat(s.substring(startPos, s.length), secondArg))
    }
}

function isAlphabetic(s) {
    var i;
    if (isEmpty(s))
        if (isAlphabetic.arguments.length == 1)
            return defaultEmptyOK;
        else
            return (isAlphabetic.arguments[1] == true);
    for (i = 0; i < s.length; i++) {
        var c = s.charAt(i);
        if (!isLetter(c))
            return false;
    }
    return true;
}

function isAlphanumeric(s) {
    var i;
    if (isEmpty(s))
        if (isAlphanumeric.arguments.length == 1)
            return defaultEmptyOK;
        else
            return (isAlphanumeric.arguments[1] == true);
    for (i = 0; i < s.length; i++) {
        var c = s.charAt(i);
        if (!(isLetter(c) || isDigit(c)))
            return false;
    }
    return true;
}

function reformat(s) {
    var arg;
    var sPos = 0;
    var resultString = "";
    for (var i = 1; i < reformat.arguments.length; i++) {
        arg = reformat.arguments[i];
        if (i % 2 == 1)
            resultString += arg;
        else {
            resultString += s.substring(sPos, sPos + arg);
            sPos += arg;
        }
    }
    return resultString;
}

function isSSN(s) {
    if (isEmpty(s))
        if (isSSN.arguments.length == 1)
            return defaultEmptyOK;
        else
            return (isSSN.arguments[1] == true);
    return (isInteger(s) && s.length == digitsInSocialSecurityNumber)
}

function isUSPhoneNumber(s) {
    if (isEmpty(s))
        if (isUSPhoneNumber.arguments.length == 1)
            return defaultEmptyOK;
        else
            return (isUSPhoneNumber.arguments[1] == true);
    return (isInteger(s) && s.length == digitsInUSPhoneNumber)
}

function isInternationalPhoneNumber(s) {
    if (isEmpty(s))
        if (isInternationalPhoneNumber.arguments.length == 1)
            return defaultEmptyOK;
        else
            return (isInternationalPhoneNumber.arguments[1] == true);
    return (isPositiveInteger(s))
}

function isZIPCode(s) {
    if (isEmpty(s))
        if (isZIPCode.arguments.length == 1)
            return defaultEmptyOK;
        else
            return (isZIPCode.arguments[1] == true);
    return (isInteger(s) && ((s.length == digitsInZIPCode1) || (s.length == digitsInZIPCode2)))
}

function isStateCode(s) {
    if (isEmpty(s))
        if (isStateCode.arguments.length == 1)
            return defaultEmptyOK;
        else
            return (isStateCode.arguments[1] == true);
    return ((USStateCodes.indexOf(s) != -1) && (s.indexOf(USStateCodeDelimiter) == -1))
}

function isEmail(s) {
    if (isEmpty(s))
        if (isEmail.arguments.length == 1)
            return defaultEmptyOK;
        else
            return (isEmail.arguments[1] == true);
    if (isWhitespace(s))
        return false;
    var i = 1;
    var sLength = s.length;
    while ((i < sLength) && (s.charAt(i) != "@")) {
        i++
    }
    if ((i >= sLength) || (s.charAt(i) != "@"))
        return false;
    else
        i += 2;
    while ((i < sLength) && (s.charAt(i) != ".")) {
        i++
    }
    if ((i >= sLength - 1) || (s.charAt(i) != "."))
        return false;
    else
        return true;
}

function isYear(s) {
    if (isEmpty(s))
        if (isYear.arguments.length == 1)
            return defaultEmptyOK;
        else
            return (isYear.arguments[1] == true);
    if (!isNonnegativeInteger(s))
        return false;
    return ((s.length == 2) || (s.length == 4));
}

function isIntegerInRange(s, a, b) {
    if (isEmpty(s))
        if (isIntegerInRange.arguments.length == 1)
            return defaultEmptyOK;
        else
            return (isIntegerInRange.arguments[1] == true);
    if (!isInteger(s, false))
        return false;
    var num = parseInt(s);
    return ((num >= a) && (num <= b));
}

function isMonth(s) {
    if (isEmpty(s))
        if (isMonth.arguments.length == 1)
            return defaultEmptyOK;
        else
            return (isMonth.arguments[1] == true);
    return isIntegerInRange(s, 1, 12);
}

function isDay(s)
{
    if (isEmpty(s))
        if (isDay.arguments.length == 1)
            return defaultEmptyOK;
        else
            return (isDay.arguments[1] == true);
    return isIntegerInRange(s, 1, 31);
}

function daysInFebruary(year) {
    return (((year % 4 == 0) && ((!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28);
}

function isDate(year, month, day) {
    if (!(isYear(year, false) && isMonth(month, false) && isDay(day, false)))
        return false;
    var intYear = year;
    var intMonth = month;
    var intDay = day;
    if (intDay > daysInMonth[intMonth])
        return false;
    if ((intMonth == 2) && (intDay > daysInFebruary(intYear)))
        return false;
    return true;
}

function prompt(s) {
    window.status = s
}

function promptEntry(s) {
    window.status = pEntryPrompt + s
}

function warnEmpty(theField, s) {
    Popup.showModal('modal', null, null, {'screenColor': '#99ff99', 'screenOpacity': .6}, mPrefix + s + mSuffix);
    theField.focus()
    return false
}

function warnInvalid(theField, s) {
    theField.focus()
    theField.select()

    Popup.showModal('modal', null, null, {'screenColor': '#99ff99', 'screenOpacity': .6}, s);
    return false;
    return false
}

function checkString(theField, s, emptyOK) {
    if (checkString.arguments.length == 2)
        emptyOK = defaultEmptyOK;
    if ((emptyOK == true) && (isEmpty(theField.value)))
        return true;
    if (isWhitespace(theField.value))
        return warnEmpty(theField, s);
    else
        return true;
}

function checkPassword(field1, field2, s, emptyOK)
{
    if ((emptyOK == true) && (isEmpty(field1.value)))
        return true;
    if ((emptyOK == true) && (isEmpty(field2.value)))
        return true;

    if (field1.value != field2.value)
    {
        Popup.showModal('modal', null, null, {'screenColor': '#99ff99', 'screenOpacity': .6}, s);
        return false;
        return false;
    }
    return true
}


function isEqual(s1, field1, s2, field2)
{
    if (field1 != field2)
    {
        alert(s1 + " should be equal to " + s2);



        return false;
    }
    return true
}

function checkStateCode(theField, emptyOK) {
    if (checkStateCode.arguments.length == 1)
        emptyOK = defaultEmptyOK;
    if ((emptyOK == true) && (isEmpty(theField.value)))
        return true;
    else {
        theField.value = theField.value.toUpperCase();
        if (!isStateCode(theField.value, false))
            return warnInvalid(theField, iStateCode);
        else
            return true;
    }
}

/////My Modification/////////
function checkInteger(theField, s, emptyOK) {
    if (checkInteger.arguments.length == 1)
        emptyOK = defaultEmptyOK;
    if ((emptyOK == true) && (isEmpty(theField.value)))
        return true;
    else {
        theField.value = theField.value.toUpperCase();
        if (!isInteger(theField.value, false))
            return warnInvalid(theField, s);
        else
            return true;
    }
}



function reformatZIPCode(ZIPString) {
    if (ZIPString.length == 5)
        return ZIPString;
    else
        return (reformat(ZIPString, "", 5, "-", 4));
}

function checkZIPCode(theField, emptyOK) {
    if (checkZIPCode.arguments.length == 1)
        emptyOK = defaultEmptyOK;
    if ((emptyOK == true) && (isEmpty(theField.value)))
        return true;
    else {
        var normalizedZIP = stripCharsInBag(theField.value, ZIPCodeDelimiters)
        if (!isZIPCode(normalizedZIP, false))
            return warnInvalid(theField, iZIPCode);
        else {
            theField.value = reformatZIPCode(normalizedZIP)
            return true;
        }
    }
}

function reformatUSPhone(USPhone) {
    return (reformat(USPhone, "(", 3, ") ", 3, "-", 4))
}

function checkUSPhone(theField, emptyOK) {
    if (checkUSPhone.arguments.length == 1)
        emptyOK = defaultEmptyOK;
    if ((emptyOK == true) && (isEmpty(theField.value)))
        return true;
    else {
        var normalizedPhone = stripCharsInBag(theField.value, phoneNumberDelimiters)
        if (!isUSPhoneNumber(normalizedPhone, false))
            return warnInvalid(theField, iUSPhone);
        else {
            theField.value = reformatUSPhone(normalizedPhone)
            return true;
        }
    }
}


function checkUSPhone_fields(areacode, phone1, phone2, emptyOK) {
    if (checkUSPhone_fields.arguments.length == 3)
        emptyOK = defaultEmptyOK;
    if (emptyOK == true)
        return true;
    else {
        if (!checkString(areacode, "area code", false) || !checkString(phone1, "phone", false) || !checkString(phone2, "phone", false))
        {
            return false;
        }
        else
        {
            var phone_number = areacode.value + "-" + phone1.value + "-" + phone2.value;
            var normalizedPhone = stripCharsInBag(phone_number, phoneNumberDelimiters);
            if (!isUSPhoneNumber(normalizedPhone, false)) {
                alert("Phone number is not valid. Please check the number");
                areacode.focus()
                return false;
            }
            else {
                return true;
            }
        }
    }
}


function checkInternationalPhone(theField, emptyOK) {
    if (checkInternationalPhone.arguments.length == 1)
        emptyOK = defaultEmptyOK;
    if ((emptyOK == true) && (isEmpty(theField.value)))
        return true;
    else {
        if (!isInternationalPhoneNumber(theField.value, false))
            return warnInvalid(theField, iWorldPhone);
        else
            return true;
    }
}

function checkEmail(theField, emptyOK) {
    if (checkEmail.arguments.length == 1)
        emptyOK = defaultEmptyOK;
    if ((emptyOK == true) && (isEmpty(theField.value)))
        return true;
    else if (!isEmail(theField.value, false))
        return warnInvalid(theField, iEmail);
    else
        return true;
}

function reformatSSN(SSN) {
    return (reformat(SSN, "", 3, "-", 2, "-", 4))
}

function checkSSN(theField, emptyOK) {
    if (checkSSN.arguments.length == 1)
        emptyOK = defaultEmptyOK;
    if ((emptyOK == true) && (isEmpty(theField.value)))
        return true;
    else {
        var normalizedSSN = stripCharsInBag(theField.value, SSNDelimiters)
        if (!isSSN(normalizedSSN, false))
            return warnInvalid(theField, iSSN);
        else {
            theField.value = reformatSSN(normalizedSSN)
            return true;
        }
    }
}

function checkYear(theField, emptyOK) {
    if (checkYear.arguments.length == 1)
        emptyOK = defaultEmptyOK;
    if ((emptyOK == true) && (isEmpty(theField.value)))
        return true;
    if (!isYear(theField.value, false))
        return warnInvalid(theField, iYear);
    else
        return true;
}

function checkMonth(theField, emptyOK) {
    if (checkMonth.arguments.length == 1)
        emptyOK = defaultEmptyOK;
    if ((emptyOK == true) && (isEmpty(theField.value)))
        return true;
    if (!isMonth(theField.value, false))
        return warnInvalid(theField, iMonth);
    else
        return true;
}

function checkDay(theField, emptyOK) {
    if (checkDay.arguments.length == 1)
        emptyOK = defaultEmptyOK;
    if ((emptyOK == true) && (isEmpty(theField.value)))
        return true;
    if (!isDay(theField.value, false))
        return warnInvalid(theField, iDay);
    else
        return true;
}

function checkDate(yearField, monthField, dayField, labelString, OKtoOmitDay) {
    if (checkDate.arguments.length == 4)
        OKtoOmitDay = false;
    if (!isYear(yearField.value))
        return warnInvalid(yearField, iYear);
    if (!isMonth(monthField.value))
        return warnInvalid(monthField, iMonth);
    if ((OKtoOmitDay == true) && isEmpty(dayField.value))
        return true;
    else if (!isDay(dayField.value))
        return warnInvalid(dayField, iDay);
    if (isDate(yearField.value, monthField.value, dayField.value))
        return true;
    alert(iDatePrefix + labelString + iDateSuffix)
    return false
}

function checkDateString(date_str, labelString, OKtoOmitDay) {
    if (checkDateString.arguments.length == 2)
        OKtoOmitDay = false;
    if (!checkString(date_str, labelString, false))
    {
        return false;
    }
    else
    {
        if (date_str.value.length > 4)
        {
            var dt_tokens = date_str.value.split("/");
            if (dt_tokens.length != 3)
            {
                alert("Please enter a valid " + labelString + " (mm/dd/yyyy)");
                return false;
            }
            else
            {
                //dt_tokens[0]=parseInt(dt_tokens[0],10);
                //dt_tokens[1]=parseInt(dt_tokens[1],10);
                //dt_tokens[2]=parseInt(dt_tokens[2],10);

                if (!isMonth(dt_tokens[0]) || (!isDay(dt_tokens[1]) || !isYear(dt_tokens[2])))
                {
                    alert(iDatePrefix + labelString + iDateSuffix);
                    return false;
                }
                else
                {
                    return true;
                }
            }
        }
        else
        {
            if (date_str.value.length < 4)
            {
                alert("Please enter a valid " + labelString + " (mmyy)");
                return false;
            }
            else
            {
                var mm = date_str.value.substr(0, 2);
                var yy = date_str.value.substr(2, 2);
                if (!isMonth(mm))
                    return warnInvalid(date_str, iMonth);
                if (!isYear(yy))
                    return warnInvalid(date_str, iYear);
                return true;
            }
        }
    }
    return true;
}

function compareDate(small_dt, big_dt, return_val, compareToday)
{
    if (compareDate.arguments.length == 3)
        compareToday = false;
    if (!checkDateString(small_dt, small_dt.name, false) || !checkDateString(big_dt, big_dt.name, false))
    {
        return false;
    }
    else
    {
        aDate = small_dt.value.split("/");
        bDate = big_dt.value.split("/");
        smallDate = new Date(aDate[2], aDate[0] - 1, aDate[1]);
        bigDate = new Date(bDate[2], bDate[0] - 1, bDate[1]);
        var today = new Date();
        var current_date = new Date(today.getYear(), today.getMonth(), today.getDate())
        if (compareToday == true)
        {
            if (smallDate < current_date)
            {
                alert(small_dt.name + " is of past. Please select " + small_dt.name + " that is not in the past ");
                small_dt.focus();
                return return_val;
            }
        }

        if ((aDate[2].toString()).length != (bDate[2].toString()).length)
        {
            alert("Please check the date formats.Both the dates should be of same format.");
            small_dt.focus();
            return return_val;
        }


        if (smallDate > bigDate)
        {
            alert(small_dt.name + " is greater then " + big_dt.name + " Please check the values.");
            small_dt.focus();
            return return_val;
        }
        return true;
    }
    return false
}



function getRadioButtonValue(radio) {
    for (var i = 0; i < radio.length; i++) {
        if (radio[i].checked) {
            break
        }
    }
    return radio[i].value
}


function checkCreditCard(radio, theField) {
    var cardType = getRadioButtonValue(radio)
    var normalizedCCN = stripCharsInBag(theField.value, creditCardDelimiters)
    if (!isCardMatch(cardType, normalizedCCN))
        return warnInvalid(theField, iCreditCardPrefix + cardType + iCreditCardSuffix);
    else {
        theField.value = normalizedCCN
        return true
    }
}

function checkCreditCard_dropdown(dropdown, theField) {
    var cardType = dropdown.options[dropdown.selectedIndex].value;
    var normalizedCCN = stripCharsInBag(theField.value, creditCardDelimiters);
    if (!isCardMatch(cardType, normalizedCCN))
        return warnInvalid(theField, iCreditCardPrefix + cardType + iCreditCardSuffix);
    else {
        theField.value = normalizedCCN
        return true
    }
}


function isCreditCard(st) {
    if (st.length > 19)
        return (false);
    sum = 0;
    mul = 1;
    l = st.length;
    for (i = 0; i < l; i++) {
        digit = st.substring(l - i - 1, l - i);
        tproduct = parseInt(digit, 10) * mul;
        if (tproduct >= 10)
            sum += (tproduct % 10) + 1;
        else
            sum += tproduct;
        if (mul == 1)
            mul++;
        else
            mul--;
    }
    if ((sum % 10) == 0)
        return (true);
    else
        return (false);
}

function isVisa(cc) {
    if (((cc.length == 16) || (cc.length == 13)) && (cc.substring(0, 1) == 4))
        return isCreditCard(cc);
    return false;
}

function isMasterCard(cc) {
    firstdig = cc.substring(0, 1);
    seconddig = cc.substring(1, 2);
    if ((cc.length == 16) && (firstdig == 5) && ((seconddig >= 1) && (seconddig <= 5)))
        return isCreditCard(cc);
    return false;
}

function isAmericanExpress(cc) {
    firstdig = cc.substring(0, 1);
    seconddig = cc.substring(1, 2);
    if ((cc.length == 15) && (firstdig == 3) && ((seconddig == 4) || (seconddig == 7)))
        return isCreditCard(cc);
    return false;
}

function isDinersClub(cc) {
    firstdig = cc.substring(0, 1);
    seconddig = cc.substring(1, 2);
    if ((cc.length == 14) && (firstdig == 3) && ((seconddig == 0) || (seconddig == 6) || (seconddig == 8)))
        return isCreditCard(cc);
    return false;
}

function isCarteBlanche(cc) {
    return isDinersClub(cc);
}

function isDiscover(cc) {
    first4digs = cc.substring(0, 4);
    if ((cc.length == 16) && (first4digs == "6011"))
        return isCreditCard(cc);
    return false;
}

function isEnRoute(cc) {
    first4digs = cc.substring(0, 4);
    if ((cc.length == 15) && ((first4digs == "2014") || (first4digs == "2149")))
        return isCreditCard(cc);
    return false;
}

function isJCB(cc) {
    first4digs = cc.substring(0, 4);
    if ((cc.length == 16) && ((first4digs == "3088") || (first4digs == "3096") || (first4digs == "3112") || (first4digs == "3158") || (first4digs == "3337") || (first4digs == "3528")))
        return isCreditCard(cc);
    return false;
}

function isAnyCard(cc) {
    if (!isCreditCard(cc))
        return false;
    if (!isMasterCard(cc) && !isVisa(cc) && !isAmericanExpress(cc) && !isDinersClub(cc) && !isDiscover(cc) && !isEnRoute(cc) && !isJCB(cc)) {
        return false;
    }
    return true;
}

function isCardMatch(cardType, cardNumber) {
    cardType = cardType.toUpperCase();
    var doesMatch = true;
    if ((cardType == "VISA") && (!isVisa(cardNumber)))
        doesMatch = false;
    if ((cardType == "MASTERCARD") && (!isMasterCard(cardNumber)))
        doesMatch = false;
    if (((cardType == "AMERICANEXPRESS") || (cardType == "AMEX")) && (!isAmericanExpress(cardNumber)))
        doesMatch = false;
    if ((cardType == "DISCOVER") && (!isDiscover(cardNumber)))
        doesMatch = false;
    if ((cardType == "JCB") && (!isJCB(cardNumber)))
        doesMatch = false;
    if ((cardType == "DINERS") && (!isDinersClub(cardNumber)))
        doesMatch = false;
    if ((cardType == "CARTEBLANCHE") && (!isCarteBlanche(cardNumber)))
        doesMatch = false;
    if ((cardType == "ENROUTE") && (!isEnRoute(cardNumber)))
        doesMatch = false;
    return doesMatch;
}

function IsCC(st) {
    return isCreditCard(st);
}

function IsVisa(cc) {
    return isVisa(cc);
}

function IsVISA(cc) {
    return isVisa(cc);
}

function IsMasterCard(cc) {
    return isMasterCard(cc);
}

function IsMastercard(cc) {
    return isMasterCard(cc);
}

function IsMC(cc) {
    return isMasterCard(cc);
}

function IsAmericanExpress(cc) {
    return isAmericanExpress(cc);
}

function IsAmEx(cc) {
    return isAmericanExpress(cc);
}

function IsDinersClub(cc) {
    return isDinersClub(cc);
}

function IsDC(cc) {
    return isDinersClub(cc);
}

function IsDiners(cc) {
    return isDinersClub(cc);
}

function IsCarteBlanche(cc) {
    return isCarteBlanche(cc);
}

function IsCB(cc) {
    return isCarteBlanche(cc);
}

function IsDiscover(cc) {
    return isDiscover(cc);
}

function IsEnRoute(cc) {
    return isEnRoute(cc);
}

function IsenRoute(cc) {
    return isEnRoute(cc);
}

function IsJCB(cc) {
    return isJCB(cc);
}

function IsAnyCard(cc) {
    return isAnyCard(cc);
}

function IsCardMatch(cardType, cardNumber) {
    return isCardMatch(cardType, cardNumber);
}
//-->