<html>

<head>
<script type="text/javascript">
function bb()
{
 var a=document.cc.aa.selectedIndex;
 var selected_text = document.cc.aa.options[a].text;
   window.open(selected_text,"_Self",false);
 
}

</script>
</head>
<body>
<form name="cc">
<select name="aa" onChange="bb()" >
<option value="a">http://www.Yahoo.com</option>
<option value="b">http://www.google.com</option>
</select>
</form>
</body>
</html>